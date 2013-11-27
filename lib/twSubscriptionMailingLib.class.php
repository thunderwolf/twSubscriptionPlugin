<?php

class twSubscriptionMailingLib
{

	static public function createMailing($list_id, $type_id, $subject, $message, $time_to_send)
	{
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

	static public function sendMailing($connection, &$processed, &$not_processed, sfBaseTask $task)
	{
		$result = twSubscriptionMailQueueQuery::getMailingData($connection);
		foreach ($result as $row) {
			try {
				$ret = self::sendMailingMessage($row, $task);
				if ($ret) {
					self::delFromQueue($row, $connection, $processed, $task);
				} else {
					$not_processed++;
				}
			} catch (Exception $e) {
				if (!is_null($task)) {
					$task->logMe($e->getMessage());
				}
				continue;
			}
		}
	}

	static protected function sendMailingMessage($row, $task = null)
	{
		$params = array(
			'email' => $row['remail'],
			'fullname' => $row['rname'],
			'unsubscribe' => $row['unsublink'],
			'subscription_base_url' => $row['subscription_base_url'],
			'website_base_url' => $row['website_base_url']
		);
		$transport = self::getTransport(
			$row['smtphost'],
			$row['smtpuser'],
			$row['smtppass'],
			$row['smtpport'],
			$row['smtpencr']
		);
		$base_message_obj = self::getBaseMessageObject(
			$row['subject'],
			$row['mailfrom'],
			$row['remail'],
			$row['fromname'],
			$row['rname']
		);
		$message_obj = self::getMessageObject(
			$row['message_type'],
			$row['message'],
			$base_message_obj,
			$params,
			$task
		);
		return self::sendPreparedMessage($message_obj, $transport, $task);
	}

	static protected function getTransport($smtphost, $smtpuser, $smtppass, $smtpport = 25, $smtpencr = 0)
	{
		//Create the Transport the call setUsername() and setPassword()
		$transport = Swift_SmtpTransport::newInstance()
			->setHost($smtphost)
			->setUsername($smtpuser)
			->setPassword($smtppass)
			->setPort($smtpport);
		if ($smtpencr == 1) {
			$transport->setEncryption('ssl');
		}
		return $transport;
	}

	static protected function getBaseMessageObject(
		$subject, $from_email, $recipient_email, $from_name = null, $recipient_name = null
	)
	{
		return Swift_Message::newInstance($subject)
			->setFrom($from_email, $from_name)
			->setTo($recipient_email, $recipient_name);
	}

	static protected function getMessageObject(
		$message_type, $message_data, Swift_Message $message_obj, $params = null, sfBaseTask $task = null
	)
	{
		switch ($message_type) {
			case 'text':
				$message = self::preparePlainMessage($message_obj, $message_data, $params);
				break;
			case 'xhtml':
				$message = self::prepareHtmlMessage($message_obj, $message_data, $params);
				break;
			case 'xhtml-em':
				$message = self::prepareEmbededMessage($message_obj, $message_data, $params, $task);
				break;
			default:
				throw new Exception('Not known message type');
		}
		return $message;
	}

	static protected function sendPreparedMessage(Swift_Message $message_obj, Swift_SmtpTransport $transport)
	{
		$mailer = Swift_Mailer::newInstance($transport);
		return $mailer->send($message_obj);
	}

	static public function preparePlainMessage(Swift_Message $message_obj, $message_data, $params)
	{
		$body = self::standardReplace($message_data, $params);
		return $message_obj->setBody($body);
	}

	static public function prepareHtmlMessage(Swift_Message $message_obj, $message_data, $params)
	{
		$html = self::standardReplace($message_data, $params);
		$html = self::expandHtmlTags($html, $params);
		$text = self::getPlainFromHtml($html);

		$message_obj->setBody($html, 'text/html');
		$message_obj->addPart($text, 'text/plain');
		return $message_obj;
	}

	static public function prepareEmbededMessage(Swift_Message $message_obj, $message_data, $params, $task = null)
	{
		$html = self::standardReplace($message_data, $params);
		$html = self::embedHtmlTags($html, $params, $message_obj, $task);
		$text = self::getPlainFromHtml($html);

		$message_obj->setBody($html, 'text/html');
		$message_obj->addPart($text, 'text/plain');
		return $message_obj;
	}

	static protected function expandHtmlTags($message, $data)
	{
		$message = preg_replace('/(<img.*?src=\")(.*?)(\".*?>)/ise', "self::parseHtmlTag('$1', '$2', '$3', \$data)", $message);
		$message = preg_replace('/(<.*?background=\")(.*?)(\".*?>)/ise', "self::parseHtmlTag('$1', '$2', '$3', \$data)", $message);
		$message = preg_replace('/(<input.*?src=\")(.*?)(\".*?>)/ise', "self::parseHtmlTag('$1', '$2', '$3', \$data)", $message);
		$message = preg_replace('/(<a.*?href=\")(.*?)(\".*?>)/ise', "self::parseHtmlTag('$1', '$2', '$3', \$data)", $message);

		return $message;
	}

	static protected function embedHtmlTags($message, $data, $messageobj, $task = null)
	{
		$message = preg_replace('/(<img.*?src=\")(.*?)(\".*?>)/ise', "self::bundleHtmlTag('$1', '$2', '$3', \$data, \$messageobj, \$task)", $message);
		$message = preg_replace('/(<.*?background=\")(.*?)(\".*?>)/ise', "self::bundleHtmlTag('$1', '$2', '$3', \$data, \$messageobj, \$task)", $message);
		$message = preg_replace('/(<input.*?src=\")(.*?)(\".*?>)/ise', "self::bundleHtmlTag('$1', '$2', '$3', \$data, \$messageobj, \$task)", $message);
		// TODO: pamięć zawodzi - czy ma być parseHtmlTag?
		$message = preg_replace('/(<a.*?href=\")(.*?)(\".*?>)/ise', "self::parseHtmlTag('$1', '$2', '$3', \$data)", $message);

		return $message;
	}

	static protected function bundleHtmlTag($prefix, $path, $suffix, $data, $messageobj, $task = null)
	{
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

	static protected function getImageFileCid($path, $messageobj, $task = None)
	{
		if (is_file($path)) {
			$cid = $messageobj->embed(Swift_Image::fromPath($path));
		} else {
			if (!is_null($task)) {
				$task->logMe("Warning: No file '" . $path . "'\n");
			}
			$cid = '';
		}
		return $cid;
	}

	static protected function parseHtmlTag($prefix, $path, $suffix, $data)
	{
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
	static protected function resolve_href($base, $href)
	{
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

	static protected function standardReplace($message, $data)
	{
		$loader = new Twig_Loader_String();
		$twig = new Twig_Environment($loader);

		return $twig->render($message, $data);
	}

	static protected function getPlainFromHtml($html)
	{
		$message = strip_tags($html);
		$text_array = explode("\n", $message);
		$text = '';
		foreach ($text_array as $v) {
			$text .= trim(str_replace('&nbsp;', ' ', $v)) . "\n";
		}
		return $text;
	}

	static protected function delFromQueue($row, $con, &$processed, sfBaseTask $task)
	{
		$con->beginTransaction();
		try {
			twSubscriptionMailQueueQuery::delFromQueue($con, $row);
			$con->commit();
			$processed++;
		} catch (Exception $e) {
			$con->rollBack();
			if (!is_null($task)) {
				$task->logMe("Failed: " . $e->getMessage());
			}
		}
	}

	static protected function cacheInternetImage($path)
	{
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

	static protected function guessExtensionFromFile($file)
	{
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

