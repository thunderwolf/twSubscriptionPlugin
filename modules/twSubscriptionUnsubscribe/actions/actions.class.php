<?php

/**
 * twSubscriptionUnsubscribe actions.
 *
 * @package    subskrypcja
 * @subpackage twSubscriptionUnsubscribe
 * @author     Arkadiusz Tułodziecki
 * @version    SVN: $Id: actions.class.php 285 2009-01-19 22:22:41Z ldath $
 */
class twSubscriptionUnsubscribeActions extends sfActions
{
	public function executeIndex($request)
	{
		$list_id = $request->getParameter('id');
		$auth_key = $request->getParameter('auth_key');

		$criteria = new Criteria();
		$criteria->add(twSubscriptionEmailPeer::AUTH_KEY, $request->getParameter('auth_key'));
		$criteria->add(twSubscriptionEmailPeer::LIST_ID, $request->getParameter('id'));
		$email = twSubscriptionEmailPeer::doSelectOne($criteria);

		if (!$email) {
			$this->forward404();
//			$this->forward('twSubscriptionUnsubscribe', 'noemail');
		}

		$criteria = new Criteria();
		$criteria->add(twSubscriptionStatusPeer::CODE, 'disabled');
		$status = twSubscriptionStatusPeer::doSelectOne($criteria);

		$email->setStatusId($status->getId());
		$email->save();
		$this->email = $email;
	}
}
