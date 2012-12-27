<?php

class twSubscriptionMailingLib {
	
	static public function createMailing($list_id, $type_id, $subject, $message, $time_to_send) {
		$message_obj = new twSubscriptionMessage();
		$message_obj->setTypeId($type_id);
		$message_obj->setSubject($subject);
		$message_obj->setMessage($message);
		
		$mailing = new twSubscriptionMailing();
		$mailing->setListId($list_id);
		$mailing->settwSubscriptionMessage($message_obj);
		$mailing->setTimeToSend($time_to_send);
		$mailing->save();
	}
	
	static public function sendMailing($task, $connection, &$processed, &$notprocessed) {
		$sth = $connection->prepare('
			SELECT smtphost, smtpuser, smtppass, mailfrom, remail, subject, message, id, mailing_id, time_to_send, type_id, rname, unsubscribe, website_base_url, subscription_base_url, fromname, list_id
			FROM tw_subscription_mail_queue
			WHERE time_to_send < NOW()
		');
		$sth->execute();
		
		$result = $sth->fetchAll();
		
		foreach ($result as $row) {
			try {
				//Create the Transport the call setUsername() and setPassword()
				// TODO: Trzeba pobierać port oraz typ szyfrowania jeśli istnieje
				$transport = Swift_SmtpTransport::newInstance()
					->setHost($row['smtphost'])
					->setPort(25)
//					->setPort(465)
//					->setEncryption('ssl')
					->setUsername($row['smtpuser'])
					->setPassword($row['smtppass']);
				//Create the Mailer using your created Transport
				$mailer = Swift_Mailer::newInstance($transport);
			
				if ($row['type_id'] == 1) {
					$message = self::preparePlainMessage($row);
				} else if ($row['type_id'] == 2) {
					$message = self::prepareHtmlMessage($row);
				} else {
					$message = self::prepareEmbededMessage($row, $task);
				}
				
				if ($mailer->send($message)) {
					self::delFromQueue($row, $connection, $task, $processed);
				} else {
					$notprocessed++;
				}
			} catch (Exception $e) {
				$task->logMe($e->getMessage());
				continue;
			}
		}
	}
	
	static public function preparePlainMessage($data) {
		$body = self::standardReplace($data['message'], $data);
		return Swift_Message::newInstance($data['subject'])->setFrom($data['mailfrom'])->setTo($data['remail'])->setBody($body);
	}
	
	static public function prepareHtmlMessage($data) {
		$html = self::standardReplace($data['message'], $data);
		$html = self::expandHtmlTags($html, $data);
		$text = self::getPlainFromHtml($html);
		
		$message = Swift_Message::newInstance($data['subject'])->setFrom($data['mailfrom'])->setTo($data['remail']);
		
		$message->setBody($html, 'text/html');
		$message->addPart($text, 'text/plain');
		return $message;
	}
	
	static public function prepareEmbededMessage($data, $task) {
		$message = Swift_Message::newInstance($data['subject'])->setFrom($data['mailfrom'])->setTo($data['remail']);
		
		$html = self::standardReplace($data['message'], $data);
		$html = self::embedHtmlTags($html, $data, $message, $task);
		$text = self::getPlainFromHtml($html);
		
		$message->setBody($html, 'text/html');
		$message->addPart($text, 'text/plain');
		return $message;
	}
	
	static protected function expandHtmlTags($message, $data) {
		$message = preg_replace('/(<img.*?src=\")(.*?)(\".*?>)/ise', "self::parseHtmlTag('$1', '$2', '$3', \$data)", $message);
		$message = preg_replace('/(<.*?background=\")(.*?)(\".*?>)/ise', "self::parseHtmlTag('$1', '$2', '$3', \$data)", $message);
		$message = preg_replace('/(<input.*?src=\")(.*?)(\".*?>)/ise', "self::parseHtmlTag('$1', '$2', '$3', \$data)", $message);
		$message = preg_replace('/(<a.*?href=\")(.*?)(\".*?>)/ise', "self::parseHtmlTag('$1', '$2', '$3', \$data)", $message);
		
		return $message;
	}
	
	static protected function embedHtmlTags($message, $data, $messageobj, $task) {
		$message = preg_replace('/(<img.*?src=\")(.*?)(\".*?>)/ise', "self::bundleHtmlTag('$1', '$2', '$3', \$data, \$messageobj, \$task)", $message);
		$message = preg_replace('/(<.*?background=\")(.*?)(\".*?>)/ise', "self::bundleHtmlTag('$1', '$2', '$3', \$data, \$messageobj, \$task)", $message);
		$message = preg_replace('/(<input.*?src=\")(.*?)(\".*?>)/ise', "self::bundleHtmlTag('$1', '$2', '$3', \$data, \$messageobj, \$task)", $message);
		// TODO: pamięć zawodzi - czy ma być parseHtmlTag?
		$message = preg_replace('/(<a.*?href=\")(.*?)(\".*?>)/ise', "self::parseHtmlTag('$1', '$2', '$3', \$data)", $message);
		
		return $message;
	}
	
	static protected function bundleHtmlTag($prefix, $path, $suffix, $data, $messageobj, $task) {
		$allowed_schemes = array('http', 'https', 'ftp');
		
		$url_chopped = parse_url($path);
		if (is_array($url_chopped) && in_array('scheme', array_keys($url_chopped)) && in_array($url_chopped['scheme'], $allowed_schemes)) {
			// TODO: clean after send mailing
			$path = self::cacheInternetImage($path);
			$cid = self::getImageFileCid($path, $messageobj, $task);
		} else {
			// TODO: clean after send mailing
			$path = $data['website_base_url'] . urldecode($path);
			$path = self::cacheInternetImage($path);
			$cid = self::getImageFileCid($path, $messageobj, $task);
		}
		return stripslashes($prefix) . $cid . stripslashes($suffix);
	}
	
	static protected function getImageFileCid($path, $messageobj, $task) {
		if (is_file($path)) {
			$cid = $messageobj->embed(Swift_Image::fromPath($path));
		} else {
			$task->logMe("Warning: No file '" . $path . "'\n");
			$cid = '';
		}
		return $cid;
	}
	
	static protected function parseHtmlTag($prefix, $path, $suffix, $data) {
		return stripslashes($prefix) . self::resolve_href($data['subscription_base_url'], $path) . stripslashes($suffix);
	}
	
	/**
	 * If you need to resolve a url against a base url, as the browser does with anchor tags
	 *
	 * @param string $base
	 * @param string $href
	 * @return string
	 *
	 * @link http://www.php.net/manual/en/function.realpath.php#85388
	 * @author Isaac Z. Schlueter
	 */
	static protected function resolve_href($base, $href) {
		// href="" ==> current url.
		if (!$href) {
			return $base;
		}
		
		// href="http://..." ==> href isn't relative
		$rel_parsed = parse_url($href);
		if (array_key_exists('scheme', $rel_parsed)) {
			return $href;
		}
		
		// add an extra character so that, if it ends in a /, we don't lose the last piece.
		$base_parsed = parse_url("$base ");
		// if it's just server.com and no path, then put a / there.
		if (!array_key_exists('path', $base_parsed)) {
			$base_parsed = parse_url("$base/ ");
		}
		
		// href="/ ==> throw away current path.
		if ($href{0} === "/") {
			$path = $href;
		} else {
			$path = dirname($base_parsed['path']) . "/$href";
		}
		
		// bla/./bloo ==> bla/bloo
		$path = preg_replace('~/\./~', '/', $path);
		
		// resolve /../
		// loop through all the parts, popping whenever there's a .., pushing otherwise.
		$parts = array();
		foreach (explode('/', preg_replace('~/+~', '/', $path)) as $part)
			if ($part === "..") {
				array_pop($parts);
			} elseif ($part) {
				$parts[] = $part;
			}
		
		return ((array_key_exists('scheme', $base_parsed)) ? $base_parsed['scheme'] . '://' . $base_parsed['host'] : "") . "/" . implode("/", $parts);
	
	}
	
	static protected function standardReplace($message, $data) {
		$message = str_replace('{email}', $data['remail'], $message);
		$message = str_replace('{fullname}', $data['rname'], $message);
		// TODO: make it better !!!!
// 		if (($data['subscription_base_url'] == $data['website_base_url']) or empty($data['website_base_url'])) {
			$message = str_replace('{unsubscribe}', $data['subscription_base_url'] . 'unsubscribe/' . $data['list_id'] . '/' . $data['unsubscribe'], $message);
// 		} else {
// 			$message = str_replace('{unsubscribe}', $data['website_base_url'] . 'subskrypcja.php?cmd=unsubscribe&id='.$data['list_id'].'&auth_key=' . $data['unsubscribe'], $message);
// 		}
		return $message;
	}
	
	static protected function getPlainFromHtml($html) {
		$message = strip_tags($html);
		$text_array = explode("\n", $message);
		$text = '';
		foreach ($text_array as $v) {
			$text .= trim(str_replace('&nbsp;', ' ', $v)) . "\n";
		}
		return $text;
	}
	
	static protected function delFromQueue($row, $con, $task, &$processed) {
		$con->beginTransaction();
		try {
			$stmt = $con->prepare('
					INSERT INTO tw_subscription_mail_sent
						(mailing_id, time_to_send, sender, remail, body, created_at)
					VALUES
						(:mailing_id, :time_to_send, :sender, :remail, :body, NOW())
					');
			
			$stmt->bindParam(':mailing_id', $row['mailing_id']);
			$stmt->bindParam(':time_to_send', $row['time_to_send']);
			$stmt->bindParam(':sender', $row['mailfrom']);
			$stmt->bindParam(':remail', $row['remail']);
			$stmt->bindParam(':body', $row['message']);
			$stmt->execute();
			
			$stmt = $con->prepare('DELETE FROM tw_subscription_mail_queue WHERE id = :id');
			$stmt->bindParam(':id', $row['id']);
			$stmt->execute();
			
			$con->commit();
			$processed++;
		} catch (Exception $e) {
			$con->rollBack();
			$task->logMe("Failed: " . $e->getMessage());
		}
	}
	
	static protected function cacheInternetImage($path) {
		$extension = escapeshellcmd(strtolower(substr($path, strrpos($path, '.') + 1)));
		if (!function_exists('curl_init')) {
			throw new Exception('no CURL module installed');
		}

		$tmpfile = tempnam(getenv('TMPDIR'), '');
		$tmp = fopen($tmpfile, 'w');

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $path);
//		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_FILE, $tmp);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

		if (curl_exec($ch) === false) {
			throw new Exception(curl_error($ch));
		}

		curl_close($ch);
		fclose($tmp);
		
		if (version_compare(PHP_VERSION, '5.3.0') >= 0) {
			$res = self::guessExtensionFromFile($tmpfile);
			if ($res !== false) {
				$extension = $res;
			}
		}
		
		$ntmpfile = $tmpfile . '.' . $extension;
		rename($tmpfile, $ntmpfile);
		$tmpfile = $ntmpfile;
		
		return $tmpfile;
	}
	
	static protected function guessExtensionFromFile($file) {
		$finfo = finfo_open(FILEINFO_MIME_TYPE);
		$ftype = finfo_file($finfo, $file);
		
		$image_type_identifiers = array(
			'image/gif' => 'gif',
			'image/jpeg' => 'jpg',
			'image/png' => 'png',
			'application/x-shockwave-flash' => 'swf',
			'image/psd' => 'psd',
			'image/bmp' => 'bmp',
			'image/tiff' => 'tiff',
			'image/jp2' => 'jp2',
			'image/iff' => 'aiff',
			'image/vnd.wap.wbmp' => 'wbmp',
			'image/xbm' => 'xbm',
		);
		
		if (in_array($ftype, array_keys($image_type_identifiers))) {
			return $image_type_identifiers[$ftype];
		}
		return false;
	}
}

