<?php

require_once sfConfig::get('sf_lib_dir') . '/vendor/swift/Swift.php';
require_once sfConfig::get('sf_lib_dir') . '/vendor/swift/Swift/Connection/SMTP.php';
require_once sfConfig::get('sf_lib_dir') . '/vendor/swift/Swift/Authenticator/LOGIN.php';

/**
 * twSubscriptionApi actions.
 *
 * @package    subskrypcja
 * @subpackage twSubscriptionApi
 * @author     Arkadiusz Tułodziecki
 */
class twSubscriptionApiActions extends sfActions
{
	/**
	 * Executes index action
	 *
	 * @param sfRequest $request A request object
	 */
	public function executeIndex($request)
	{
	}
	
	public function executePrepare($request)
	{
		sfConfig::set('sf_web_debug', false);
		$this->setLayout(false);
	}
	
	public function executeJs($request)
	{
		sfConfig::set('sf_web_debug', false);
		$this->setLayout(false);
		$this->getResponse()->setHttpHeader('Content-Type','text/javascript; charset=UTF-8');
		
		$this->jqsrc = $_SERVER['SERVER_NAME'];
		$this->form_id = md5(0xDeadBeef + $request->getParameter('id'));

		$list = twSubscriptionListPeer::retrieveByPK($request->getParameter('id'));
		$this->forward404Unless($list);
		
		$this->website_base_url = $list->getWebsiteBaseUrl();
		
	}
	
	public function executeAjax($request)
	{
		$this->setLayout(false);
//		$this->getResponse()->setHttpHeader('Content-Type','application/json; charset=UTF-8');

		$list_id = $request->getParameter('id');
		$cmd = $request->getParameter('cmd');
		$shared_key = $request->getParameter('shared_key');
		
		$list = twSubscriptionListPeer::retrieveByPK($list_id);
		
		$json = array();
		
		switch($cmd) {
			case 'subscribe':
				
				if (!$list) {
					$json['error_code'] = 404;
					$json['error_msg'] = 'Not Found';
					break;
				}
				
				if (!$list->getWebsiteSharedKey() || $list->getWebsiteSharedKey() != $shared_key) {
					$json['error_code'] = 403;
					$json['error_msg'] = 'Forbidden';
					break;
				}
				
				if ($request->getParameter('email') == '' || $request->getParameter('name') == '') {
					$json['error_code'] = 406;
					$json['error_msg'] = 'Not Acceptable';
					break;
				}
			
				$email = trim($request->getParameter('email'));	// TODO: zrobić lepszą walidację
				$name = trim($request->getParameter('name'));	// TODO: zrobić lepszą walidację
				
				$tw_subscription_email = new twSubscriptionEmail();
				$tw_subscription_email->setRemail($email);	// TODO: sprawdzić poprawność TODO: zrobić z tego UNIQUE
				$tw_subscription_email->setRname($name);	// TODO: sprawdzić poprawność
				$tw_subscription_email->setListId($list_id);
				$tw_subscription_email->setExpires(time() + 24*3600);
				
				$criteria = new Criteria();
				$criteria->add(twSubscriptionStatusPeer::CODE, 'pending');
				$status_pending = twSubscriptionStatusPeer::doSelectOne($criteria);
				
				$tw_subscription_email->setStatusId($status_pending->getId());
				
				$emailValidator = new sfValidatorPropelUnique(array('model' => 'twSubscriptionEmail', 'column' => 'remail'));
				try {
					$emailValidator->clean(array('remail' => $email));
				} catch (Exception $e) {
					$json['error_code'] = 409;
					$json['error_msg'] = 'Conflict';
					break;
				}
				
				$auth_tries = 0;

				$authValidator = new sfValidatorPropelUnique(array('model' => 'twSubscriptionEmail', 'column' => 'auth_key'));
				do {
					$tw_subscription_email->setAuthKey(sha1(uniqid(rand(), true)));
					try {
						$authValidator->clean(array('auth_key' => $tw_subscription_email->getAuthKey()));
						break;
					} catch (Exception $e) {
						$auth_tries++;
					}
				} while ($auth_tries++ < 3);
				
				if ($auth_tries == 3) {
					$json['error_code'] = 409;
					$json['error_msg'] = 'Conflict';
					break;
				}
				
				try {
					$tw_subscription_email->save();
				} catch (PropelException $e) {
					$json['error_code'] = 500;
					$json['error_msg'] = 'Internal Server Error';
					break;
				}
				
				$mailBody = $this->getPartial('confirm', array(
					'email' => $email,
					'list_name' => $list->getListname(),
					'from' => $list->getMailfrom(),
					'confirm_link' => $list->getWebsiteBaseUrl() . '/subskrypcja.php?cmd=confirm&hash=' . $tw_subscription_email->getAuthKey(),
				));

				//Create the Transport the call setUsername() and setPassword()
				// TODO: Trzeba pobierać port oraz typ szyfrowania jeśli istnieje
				$transport = Swift_SmtpTransport::newInstance()
					->setHost($list->getSmtphost())
					->setPort($list->getSmtpport())
//					->setPort(465)
//					->setEncryption('ssl')
					->setUsername($list->getSmtpuser())
					->setPassword($list->getSmtppass());
				//Create the Mailer using your created Transport
				$mailer = Swift_Mailer::newInstance($transport);

				$message = new Swift_Message('Potwierdzenie rejestracji na newsletter: '.$list->getListname(), $mailBody, 'text/plain');
				$mailer->send($message, $email, new Swift_Address($list->getMailfrom()));
				
				$json['error_code'] = 200;
				$json['error_msg'] = 'OK';
				
				break;
			
			case 'unsubscribe':
			case 'confirm':
		
				if (!$list) {
					$json['error_code'] = 404;
					$json['error_msg'] = 'Not Found';
					$json['redir'] = $list->getWebsiteBaseUrl() . '?subskrypcja.cmd=' . $cmd . '&subskrypcja.code=' . $json['error_code'];
					$json['redir_auth'] = sha1($json['redir'] . 0xDEADBEEF . $list->getWebsiteSharedKey());
					break;
				}
				
				if (!$list->getWebsiteSharedKey() || $list->getWebsiteSharedKey() != $shared_key) {
					$json['error_code'] = 403;
					$json['error_msg'] = 'Forbidden';
					$json['redir'] = $list->getWebsiteBaseUrl() . '?subskrypcja.cmd=' . $cmd . '&subskrypcja.code=' . $json['error_code'];
					$json['redir_auth'] = sha1($json['redir'] . 0xDEADBEEF . $list->getWebsiteSharedKey());
					break;
				}

				$criteria = new Criteria();
				$criteria->add(twSubscriptionEmailPeer::AUTH_KEY, $request->getParameter('hash'));
				
				$email = twSubscriptionEmailPeer::doSelectOne($criteria);
				
				if (!$email) {
					$json['error_code'] = 404;
					$json['error_msg'] = 'Not Found';
					$json['redir'] = $list->getWebsiteBaseUrl() . '?subskrypcja.cmd=' . $cmd . '&subskrypcja.code=' . $json['error_code'];
					$json['redir_auth'] = sha1($json['redir'] . 0xDEADBEEF . $list->getWebsiteSharedKey());
					break;
				}
				
				if ($email->getAuthKey() != $request->getParameter('hash')) {
					$json['error_code'] = 403;
					$json['error_msg'] = 'Forbidden';
					$json['redir'] = $list->getWebsiteBaseUrl() . '?subskrypcja.cmd=' . $cmd . '&subskrypcja.code=' . $json['error_code'];
					$json['redir_auth'] = sha1($json['redir'] . 0xDEADBEEF . $list->getWebsiteSharedKey());
					break;
				}
				
				$auth_tries = 0;
				$authValidator = new sfValidatorPropelUnique(array('model' => 'twSubscriptionEmail', 'column' => 'auth_key'));
				do {
					$email->setAuthKey(sha1(uniqid(rand(), true)));
					try {
						$authValidator->clean(array('auth_key' => $email->getAuthKey()));
						break;
					} catch (Exception $e) {
						$auth_tries++;
					}
				} while ($auth_tries++ < 3);
				
				if ($auth_tries == 3) {
					$json['error_code'] = 409;
					$json['error_msg'] = 'Conflict';
					$json['redir'] = $list->getWebsiteBaseUrl() . '?subskrypcja.cmd=' . $cmd . '&subskrypcja.code=' . $json['error_code'];
					$json['redir_auth'] = sha1($json['redir'] . 0xDEADBEEF . $list->getWebsiteSharedKey());
					break;
				}
				
				$criteria = new Criteria();

				if ($cmd == 'confirm') {
					$criteria->add(twSubscriptionStatusPeer::CODE, 'active');
				} elseif ($cmd == 'unsubscribe') {
					$criteria->add(twSubscriptionStatusPeer::CODE, 'disabled');
				}
				
				$status = twSubscriptionStatusPeer::doSelectOne($criteria);
				$email->setStatusId($status->getId());
				
				try {
					$email->save();
				} catch (PropelException $e) {
					$json['error_code'] = 500;
					$json['error_msg'] = 'Internal Server Error';
					$json['redir'] = $list->getWebsiteBaseUrl() . '?subskrypcja.cmd=' . $cmd . '&subskrypcja.code=' . $json['error_code'];
					$json['redir_auth'] = sha1($json['redir'] . 0xDEADBEEF . $list->getWebsiteSharedKey());
					break;
				}
				
				$json['error_code'] = 200;
				$json['error_msg'] = 'OK';
				$json['redir'] = $list->getWebsiteBaseUrl() . '?subskrypcja.cmd=' . $cmd . '&subskrypcja.code=' . $json['error_code'];
				$json['redir_auth'] = sha1($json['redir'] . 0xDEADBEEF . $list->getWebsiteSharedKey());
				
				break;
			
			default:
				$json['error_code'] = 400;
				$json['error_msg'] = 'Bad Request';
				break;
		}
		
		echo json_encode( $json );
		return sfView::NONE;
	}
}
