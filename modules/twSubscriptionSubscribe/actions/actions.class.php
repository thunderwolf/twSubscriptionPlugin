<?php

/**
 * twSubscriptionSubscribe actions.
 *
 * @package    twSubscriptionPlugin
 * @subpackage twSubscriptionSubscribe
 * @author     Arkadiusz Tułodziecki
 */
class twSubscriptionSubscribeActions extends sfActions
{
	public function executeIndex(sfWebRequest $request) {
		$list = twSubscriptionListQuery::create()->findPk(sfConfig::get('app_tw_subscription_subscribe_list', 1));
		$this->forward404Unless($list);
		$list_inv = twSubscriptionListInvitationQuery::create()->findOneByListId($list->getId());
		if (!($list_inv instanceof twSubscriptionListInvitation)) {
			$this->forward404();
		}
		$message_type_obj = twSubscriptionMessageTypeQuery::create()->findPk($list_inv->getTypeId());
		$this->forward404Unless($message_type_obj);

		$this->form = new sfForm();
		$this->form->setWidgets(array(
			'r_email'    => new sfWidgetFormInputText(),
			'r_name'   => new sfWidgetFormInputText()
		));

		$this->form->setValidators(array(
			'r_email' => new sfValidatorAnd(array(
					new sfValidatorString(array('max_length' => 250)), new sfValidatorEmail()
				)),
			'r_name' => new sfValidatorString(array('max_length' => 250, 'required' => false))
		));
		$this->form->getWidgetSchema()->setNameFormat('subscribe[%s]');

		$this->m_sent = 0;
		if ($request->isMethod('post')) {
			$this->form->bind($request->getParameter('subscribe'));
			if ($request->isMethod('post')) {
				$values = $this->form->getValues();
				$status = twSubscriptionStatusQuery::create()->findOneByCode('pending');

				$email_list = twSubscriptionEmailQuery::create()
					->filterBytwSubscriptionList($list)
					->findOneByREmail($values['r_email']);

				if (!$email_list) {
					$this->savePendingEmail($list, $status, $list_inv, $message_type_obj, $values);
					$this->m_sent = 1; // Invitation sent
				} else {
					$this->m_sent = 2; // Invitation already sent
				}
			}
		}
	}

	protected function savePendingEmail(
		twSubscriptionList $list,
		twSubscriptionStatus $status,
		twSubscriptionListInvitation $list_inv,
		twSubscriptionMessageType $message_type_obj,
		$values
	)
	{
		$auth_key = microtime(true);

		$email_list = new twSubscriptionEmail();
		$email_list->settwSubscriptionList($list);
		$email_list->settwSubscriptionStatus($status);
		$email_list->setREmail($values['r_email']);
		$email_list->setRName($values['r_name']);
		$email_list->setExpires(strtotime("+1 day"));
		$email_list->setAuthKey($auth_key);
		$email_list->save();

		$m_type = $message_type_obj->getCode();
		$sub_link = $this->generateUrl('subscription_subscribe_activate', array('id' => $list->getId(), 'auth_key' => $auth_key));
		twSubscriptionMailingLib::sendInvitationEmail($list, $list_inv, $m_type, $sub_link, $values['r_email'], $values['r_name']);

		return true;
	}
}
