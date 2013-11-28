<?php

require_once dirname(__FILE__) . '/../lib/twSubscriptionMailingGeneratorConfiguration.class.php';
require_once dirname(__FILE__) . '/../lib/twSubscriptionMailingGeneratorHelper.class.php';

/**
 * twSubscriptionMailing actions.
 *
 * @package    pzmtravel
 * @subpackage twSubscriptionMailing
 * @author     Your name here
 */
class twSubscriptionMailingActions extends autoTwSubscriptionMailingActions {
	public function preExecute() {
		sfConfig::set('tw_admin:default:module', 'tw_subscription');
		sfConfig::set('tw_admin:default:category', 'tw_subscription_mailing');
		sfConfig::set('tw_admin:default:nav', 'tabs');
		return parent::preExecute();
	}
	
	public function executeStop(sfWebRequest $request) {
		$tw_subscription_mailing = $this->getRoute()->getObject();
		
		$c = new Criteria();
		$c->add(twSubscriptionMailQueuePeer::MAILING_ID, $tw_subscription_mailing->getId());
		$queue = twSubscriptionMailQueuePeer::doSelect($c);
		try {
			foreach ($queue as $object) {
				$object->delete();
			}
		} catch (PropelException $e) {
			$this->getUser()->setFlash('error', 'Could not delete the selected Tw subscription emails in queue. Make sure they do not have any associated items.');
			return $this->forward('twSubscriptionMailing', 'index');
		}
		
		return $this->redirect('@tw_subscription_mailing');
	}
	
	public function executeSendMailing(sfWebRequest $request) {
		$tw_subscription_mailing = $this->getRoute()->getObject();
		
		$tw_subscription_message = twSubscriptionMessageQuery::create()->findPk($tw_subscription_mailing->getMessageId());
		$this->forward404Unless($tw_subscription_mailing);
		
		$tw_subscription_list = twSubscriptionListQuery::create()->findPk($tw_subscription_mailing->getListId());
		$this->forward404Unless($tw_subscription_list);
		
		$from_name = $tw_subscription_list->getFromName();
		if (empty($from_name)) {
			$from_name = $tw_subscription_list->getListName();
		}
		$from_address = $tw_subscription_list->getFromAddress();
		$smpt_host = $tw_subscription_list->getSmtpHost();
		$smpt_port = $tw_subscription_list->getSmtpPort();
		$smpt_encr = $tw_subscription_list->getSmtpEncr();
		$smpt_user = $tw_subscription_list->getSmtpUser();
		$smtp_pass = $tw_subscription_list->getSmtpPass();
		$web_base_url = $tw_subscription_list->getWebBaseUrl();
		
		if (is_null($from_address) || is_null($smpt_host) || is_null($smpt_port) || is_null($smpt_encr) || is_null($smpt_user) || is_null($smtp_pass)) {
			$this->getUser()->setFlash('notice', 'Can\'t send Mailing without SMTP server data for list set');
			return $this->redirect('@tw_subscription_mailing');
		}
		
		$emails = twSubscriptionEmailQuery::create()
			->filterByListId($tw_subscription_mailing->getListId())
			->usetwSubscriptionStatusQuery()
				->filterByCode('active')
			->endUse()
			->find()
		;

		if (empty($emails)) {
			$this->getUser()->setFlash('notice', 'No Emails to send');
			return $this->redirect('@tw_subscription_mailing');
		}
		$msg = $tw_subscription_message->getMessage();
		$type_id = $tw_subscription_message->getTypeId();
		$message_type_obj = twSubscriptionMessageTypeQuery::create()->findPk($type_id);
		$message_type = $message_type_obj->getCode();
		if ($message_type != 'text') {
			if (extension_loaded('tidy')) {
				$config = array(
						'indent' => FALSE,
						'output-xhtml' => FALSE,
						'wrap' => 0);
				
				$tidy = tidy_parse_string($msg, $config, 'UTF8');
				tidy_clean_repair($tidy);
				$msg = $tidy;
			}
		}
		$list_type = twSubscriptionListTypeQuery::create()->findPk($tw_subscription_list->getTypeId());
		
		foreach ($emails as $row) {
			$queue = new twSubscriptionMailQueue();
			
			$queue->setMailingId($this->getRequestParameter('id'));
			
			$queue->setMessageId($tw_subscription_message->getId());

			$queue->setTypeId($type_id);
			$queue->setMessageType($message_type);

			$queue->setSubject($tw_subscription_message->getSubject());
			$queue->setMessage($msg);
			
			$queue->setListId($tw_subscription_list->getId());
			$queue->setListType($list_type->getCode());

			$queue->setFromAddress($from_address);
			$queue->setFromName($from_name);

			$queue->setSmtpHost($smpt_host);
			$queue->setSmtpPort($smpt_port);
			$queue->setSmtpEncr($smpt_encr);
			$queue->setSmtpUser($smpt_user);
			$queue->setSmtpPass($smtp_pass);

			$queue->setREmail($row->getREmail());
			$queue->setRName($row->getRName());

			$queue->setUnSubCode($row->getAuthKey());
			$queue->setUnSubLink($this->generateUrl('subscription_unsubscribe', array('id' => $tw_subscription_list->getId(), 'auth_key' => $row->getAuthKey())));

			$queue->setSubBaseUrl('http://' . $_SERVER['SERVER_NAME'] . '/');
			$queue->setWebBaseUrl($web_base_url);

			$queue->setTimeToSend($tw_subscription_mailing->getTimeToSend());
			
			$queue->setTrySent(0);
			
			$queue->save();
		}
		$this->getUser()->setFlash('notice', 'Mailing prepared');
		
		return $this->redirect('@tw_subscription_mailing');
	}
}
