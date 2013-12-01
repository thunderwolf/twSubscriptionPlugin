<?php

class twSubscriptionMailingLib
{
	/**
	 * Sending invitation email
	 *
	 * @param twSubscriptionList $list
	 * @param twSubscriptionListInvitation $list_inv
	 * @param $m_type
	 * @param $recipient_email
	 * @param null $recipient_name
	 * @return int
	 */
	static public function sendInvitationEmail(
		twSubscriptionList $list, twSubscriptionListInvitation $list_inv, $m_type, $recipient_email, $recipient_name = null
	)
	{
		$params = array(
			'email' => $recipient_email,
			'fullname' => $recipient_name,
			'unsubscribe' => null,
			'sub_base_url' => 'http://' . $_SERVER['SERVER_NAME'] . '/',
			'web_base_url' => $list->getWebBaseUrl()
		);
		$transport = self::getTransport(
			$list->getSmtpHost(),
			$list->getSmtpUser(),
			$list->getSmtpPass(),
			$list->getSmtpPort(),
			$list->getSmtpEncr()
		);
		$base_message_obj = self::getBaseMessageObject(
			$list_inv->getSubject(),
			$list->getFromAddress(),
			$recipient_email,
			$list->getFromName(),
			$recipient_name
		);
		$message_obj = self::getMessageObject(
			$m_type,
			$list_inv->getMessage(),
			$base_message_obj,
			$params,
			null
		);
		return self::sendPreparedMessage($message_obj, $transport, null);
	}

	/**
	 * Create mailing
	 *
	 * @param $list_id
	 * @param $type_id
	 * @param $subject
	 * @param $message
	 * @param $time_to_send
	 */
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

	/**
	 * Sending mailing
	 *
	 * @param $connection
	 * @param $processed
	 * @param $not_processed
	 * @param sfBaseTask $task
	 */
	static public function sendMailing($connection, &$processed, &$not_processed, sfBaseTask $task)
	{
		$result = twSubscriptionMailQueueQuery::getMailingQueue($connection);
		foreach ($result as $row) {
			try {
				// TODO: messages should be pre-compiled once for each message_id then only `standardReplace` for each record
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

	/**
	 * Send mailing record message
	 *
	 * @param $row  Data from twSubscriptionMailQueueQuery::getMailingQueue row
	 * @param null $task
	 * @return int
	 */
	static protected function sendMailingMessage($row, $task = null)
	{
		$params = array(
			'email' => $row['r_email'],
			'fullname' => $row['r_name'],
			'unsubscribe' => $row['un_sub_link'],
			'sub_base_url' => $row['sub_base_url'],
			'web_base_url' => $row['web_base_url']
		);
		$transport = self::getTransport(
			$row['smtp_host'],
			$row['smtp_user'],
			$row['smtp_pass'],
			$row['smtp_port'],
			$row['smtp_encr']
		);
		$base_message_obj = self::getBaseMessageObject(
			$row['subject'],
			$row['from_address'],
			$row['r_email'],
			$row['from_name'],
			$row['r_name']
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

	/**
	 * Delete message from Queue
	 *
	 * @param $row
	 * @param $con
	 * @param $processed
	 * @param sfBaseTask $task
	 */
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

	/**
	 * Get Swift_SmtpTransport
	 *
	 * @param $host
	 * @param $user
	 * @param $pass
	 * @param int $port
	 * @param int $encr
	 * @return Swift_SmtpTransport
	 */
	static protected function getTransport($host, $user, $pass, $port = 25, $encr = 0)
	{
		//Create the Transport the call setUsername() and setPassword()
		$transport = Swift_SmtpTransport::newInstance()
			->setHost($host)
			->setUsername($user)
			->setPassword($pass)
			->setPort($port);
		if ($encr == 1) {
			$transport->setEncryption('ssl');
		}
		return $transport;
	}

	/**
	 * Get base Swift_Message
	 *
	 * @param $subject
	 * @param $from_address
	 * @param $recipient_email
	 * @param null $from_name
	 * @param null $recipient_name
	 * @return Swift_Message
	 */
	static protected function getBaseMessageObject(
		$subject, $from_address, $recipient_email, $from_name = null, $recipient_name = null
	)
	{
		return Swift_Message::newInstance($subject)
			->setFrom($from_address, $from_name)
			->setTo($recipient_email, $recipient_name);
	}

	/**
	 * Get Swift_Message with parsed message data
	 * @param $message_type
	 * @param $message_data
	 * @param Swift_Message $message_obj
	 * @param null $params
	 * @param sfBaseTask $task
	 * @return Swift_Message
	 * @throws Exception
	 */
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
				$message = self::prepareEmbeddedMessage($message_obj, $message_data, $params, $task);
				break;
			default:
				throw new Exception('Not known message type');
		}
		return $message;
	}

	/**
	 * Sending prepared message
	 *
	 * @param Swift_Message $message_obj
	 * @param Swift_SmtpTransport $transport
	 * @return int
	 */
	static protected function sendPreparedMessage(Swift_Message $message_obj, Swift_SmtpTransport $transport)
	{
		$mailer = Swift_Mailer::newInstance($transport);
		return $mailer->send($message_obj);
	}

	/**
	 * Returning prepared plain type Swift_Message
	 *
	 * @param Swift_Message $message_obj
	 * @param $message_data
	 * @param $params
	 * @return Swift_Message
	 */
	static public function preparePlainMessage(Swift_Message $message_obj, $message_data, $params)
	{
		$body = self::standardReplace($message_data, $params);
		return $message_obj->setBody($body);
	}

	/**
	 * Returning prepared XHTML type Swift_Message
	 *
	 * @param Swift_Message $message_obj
	 * @param $message_data
	 * @param $params
	 * @return Swift_Message
	 */
	static public function prepareHtmlMessage(Swift_Message $message_obj, $message_data, $params)
	{
		$html = self::standardReplace($message_data, $params);
		$html = self::expandHtmlTags($html, $params);
		$text = self::getPlainFromHtml($html);

		$message_obj->setBody($html, 'text/html');
		$message_obj->addPart($text, 'text/plain');
		return $message_obj;
	}

	/**
	 * Returning prepared XHTML type Swift_Message with embedded files
	 *
	 * @param Swift_Message $message_obj
	 * @param $message_data
	 * @param $params
	 * @param null $task
	 * @return Swift_Message
	 */
	static public function prepareEmbeddedMessage(Swift_Message $message_obj, $message_data, $params, $task = null)
	{
		$html = self::standardReplace($message_data, $params);
		$html = self::embeddedHtmlTags($html, $params, $message_obj, $task);
		$text = self::getPlainFromHtml($html);

		$message_obj->setBody($html, 'text/html');
		$message_obj->addPart($text, 'text/plain');
		return $message_obj;
	}

	/**
	 * In this moment this method use Twig for replace parameters
	 *
	 * @param $message
	 * @param $data
	 * @return string
	 */
	static protected function standardReplace($message, $data)
	{
		$loader = new Twig_Loader_String();
		$twig = new Twig_Environment($loader);

		return $twig->render($message, $data);
	}

	/**
	 * Repairing links in normal XHTML message
	 *
	 * @param $message
	 * @param $data
	 * @return string
	 */
	static protected function expandHtmlTags($message, $data)
	{
		$message = preg_replace('/(<img.*?src=\")(.*?)(\".*?>)/ise', "self::parseHtmlTag('$1', '$2', '$3', \$data)", $message);
		$message = preg_replace('/(<.*?background=\")(.*?)(\".*?>)/ise', "self::parseHtmlTag('$1', '$2', '$3', \$data)", $message);
		$message = preg_replace('/(<input.*?src=\")(.*?)(\".*?>)/ise', "self::parseHtmlTag('$1', '$2', '$3', \$data)", $message);
		$message = preg_replace('/(<a.*?href=\")(.*?)(\".*?>)/ise', "self::parseHtmlTag('$1', '$2', '$3', \$data)", $message);

		return $message;
	}

	/**
	 * Repairing links in embedded XHTML message
	 *
	 * @param $message
	 * @param $data
	 * @param Swift_Message $message_obj
	 * @param null $task
	 * @return mixed
	 */
	static protected function embeddedHtmlTags($message, $data, Swift_Message $message_obj, $task = null)
	{
		$message = preg_replace('/(<img.*?src=\")(.*?)(\".*?>)/ise', "self::bundleHtmlTag('$1', '$2', '$3', \$data, \$message_obj, \$task)", $message);
		$message = preg_replace('/(<.*?background=\")(.*?)(\".*?>)/ise', "self::bundleHtmlTag('$1', '$2', '$3', \$data, \$message_obj, \$task)", $message);
		$message = preg_replace('/(<input.*?src=\")(.*?)(\".*?>)/ise', "self::bundleHtmlTag('$1', '$2', '$3', \$data, \$message_obj, \$task)", $message);
		// TODO: pamięć zawodzi - czy ma być parseHtmlTag?
		$message = preg_replace('/(<a.*?href=\")(.*?)(\".*?>)/ise', "self::parseHtmlTag('$1', '$2', '$3', \$data)", $message);

		return $message;
	}

	/**
	 * Repair link
	 *
	 * @param $prefix
	 * @param $path
	 * @param $suffix
	 * @param $data
	 * @return string
	 */
	static protected function parseHtmlTag($prefix, $path, $suffix, $data)
	{
		return stripslashes($prefix) . self::resolve_href($data['web_base_url'], $path) . stripslashes($suffix);
	}

	/**
	 * Bundle Html Tag for embedded XHTML message
	 *
	 * @param $prefix
	 * @param $path
	 * @param $suffix
	 * @param $data
	 * @param Swift_Message $message_obj
	 * @param null $task
	 * @return string
	 */
	static protected function bundleHtmlTag($prefix, $path, $suffix, $data, Swift_Message $message_obj, $task = null)
	{
		$allowed_schemes = array('http', 'https', 'ftp');

		$url_chopped = parse_url($path);
		if (is_array($url_chopped) && in_array('scheme', array_keys($url_chopped)) && in_array($url_chopped['scheme'], $allowed_schemes)) {
			// TODO: clean after send mailing
			$path = self::cacheInternetImage($path);
			$cid = self::getImageFileCid($path, $message_obj, $task);
		} else {
			// TODO: clean after send mailing
			$path = $data['sub_base_url'] . urldecode($path);
			$path = self::cacheInternetImage($path);
			$cid = self::getImageFileCid($path, $message_obj, $task);
		}
		return stripslashes($prefix) . $cid . stripslashes($suffix);
	}

	/**
	 * Embed Image in message and get CID of it.
	 *
	 * @param $path
	 * @param Swift_Message $message_obj
	 * @param null $task
	 * @return string
	 */
	static protected function getImageFileCid($path, Swift_Message $message_obj, $task = null)
	{
		if (is_file($path)) {
			$cid = $message_obj->embed(Swift_Image::fromPath($path));
		} else {
			if (!is_null($task)) {
				$task->logMe("Warning: No file '" . $path . "'\n");
			}
			$cid = '';
		}
		return $cid;
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
	 * TODO: If your path contains "0" (or any "false" string) directory name, the function removes that directory from the path.
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

	/**
	 * Creating plain text message from html message
	 *
	 * @param $html
	 * @return string
	 */
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

	/**
	 * Download Image from internet and cache it on hdd
	 *
	 * @param $path
	 * @return string
	 * @throws Exception
	 */
	static protected function cacheInternetImage($path)
	{
		$extension = escapeshellcmd(strtolower(substr($path, strrpos($path, '.') + 1)));
		if (!function_exists('curl_init')) {
			throw new Exception('no CURL module installed');
		}

		$tmp_file = tempnam(getenv('TMPDIR'), '');
		$tmp = fopen($tmp_file, 'w');

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

		$res = self::guessExtensionFromFile($tmp_file);
		if ($res !== false) {
			$extension = $res;
		}

		$new_tmp_file = $tmp_file . '.' . $extension;
		rename($tmp_file, $new_tmp_file);
		$tmp_file = $new_tmp_file;

		return $tmp_file;
	}

	/**
	 * Guess File Extension based on it data
	 *
	 * @param $file
	 * @return bool
	 */
	static protected function guessExtensionFromFile($file)
	{
		$f_info = finfo_open(FILEINFO_MIME_TYPE);
		$f_type = finfo_file($f_info, $file);

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

		if (in_array($f_type, array_keys($image_type_identifiers))) {
			return $image_type_identifiers[$f_type];
		}
		return false;
	}
}

