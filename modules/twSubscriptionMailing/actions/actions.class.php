<?php

require_once dirname(__FILE__) . '/../lib/twSubscriptionMailingGeneratorConfiguration.class.php';
require_once dirname(__FILE__) . '/../lib/twSubscriptionMailingGeneratorHelper.class.php';

/**
 * twSubscriptionMailing actions.
 *
 * @package    pzmtravel
 * @subpackage twSubscriptionMailing
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 1011 2012-09-11 05:45:22Z ldath $
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
		
		$tw_subscription_message = twSubscriptionMessagePeer::retrieveByPk($tw_subscription_mailing->getMessageId());
		$this->forward404Unless($tw_subscription_mailing);
		
		$tw_subscription_list = twSubscriptionListPeer::retrieveByPk($tw_subscription_mailing->getListId());
		$this->forward404Unless($tw_subscription_list);
		
		$fromname = $tw_subscription_list->getFromname();
		if (empty($fromname)) {
			$fromname = $tw_subscription_list->getListname();
		}
		$mailfrom = $tw_subscription_list->getMailfrom();
		$smpthhost = $tw_subscription_list->getSmtphost();
		$smptuser = $tw_subscription_list->getSmtpuser();
		$smtppass = $tw_subscription_list->getSmtppass();
		$website_base_url = $tw_subscription_list->getWebsiteBaseUrl();
		
		if (empty($mailfrom) or empty($smpthhost) or empty($smptuser) or empty($smtppass)) {
			$this->getUser()->setFlash('notice', 'Can\'t send Mailing without SMTP server data for list set');
			return $this->redirect('@tw_subscription_mailing');
		}
		
		$c = new Criteria();
		$c->add(twSubscriptionEmailPeer::LIST_ID, $tw_subscription_mailing->getListId());
		$c->addJoin(twSubscriptionEmailPeer::STATUS_ID, twSubscriptionStatusPeer::ID);
		$c->add(twSubscriptionStatusPeer::CODE, 'active');
		
		$tw_subscription_email = twSubscriptionEmailPeer::doSelect($c);
		if (empty($tw_subscription_email)) {
			$this->getUser()->setFlash('notice', 'No Emails to send');
			return $this->redirect('@tw_subscription_mailing');
		}
		$msg = $tw_subscription_message->getMessage();
		$type_id = $tw_subscription_message->getTypeId();
		if ($type_id > 1) {
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
		
		foreach ($tw_subscription_email as $row) {
			$queue = new twSubscriptionMailQueue();
			
			$queue->setMailingId($this->getRequestParameter('id'));
			
			$queue->setMessageId($tw_subscription_message->getId());
			$queue->setTypeId($type_id);
			$queue->setSubject($tw_subscription_message->getSubject());
			$queue->setMessage($msg);
			
			$queue->setListId($tw_subscription_list->getId());
			$queue->setFromname($fromname);
			$queue->setMailfrom($mailfrom);
			$queue->setSmtphost($smpthhost);
			$queue->setSmtpuser($smptuser);
			$queue->setSmtppass($smtppass);
			$queue->setSubscriptionBaseUrl('http://' . $_SERVER['SERVER_NAME'] . '/');
			$queue->setWebsiteBaseUrl($website_base_url);
			
			$queue->setRemail($row->getRemail());
			$queue->setRname($row->getRname());
			$queue->setUnsubscribe($row->getAuthKey());
			
			$queue->setTimeToSend($tw_subscription_mailing->getTimeToSend());
			
			$queue->setTrySent(0);
			
			$queue->save();
		}
		$this->getUser()->setFlash('notice', 'Mailing prepared');
		
		return $this->redirect('@tw_subscription_mailing');
	}
}
