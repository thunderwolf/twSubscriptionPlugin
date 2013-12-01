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
					new sfValidatorString(array('max_length' => 250)), new sfValidator_email()
				)),
			'r_name' => new sfValidatorString(array('max_length' => 250, 'required' => false))
		));
		$this->form->getWidgetSchema()->setNameFormat('subscribe[%s]');

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
		$mtype = $message_type_obj->getCode();
		twSubscriptionMailingLib::sendInvitationEmail($list, $list_inv, $mtype, $values['r_email'], $values['r_name']);

		$email_list = new twSubscriptionEmail();
		$email_list->settwSubscriptionList($list);
		$email_list->settwSubscriptionStatus($status);
		$email_list->setREmail($values['r_email']);
		$email_list->setRName($values['r_name']);
		$email_list->setExpires(strtotime("+1 day"));
		$email_list->setAuthKey(microtime(true));
		$email_list->save();
		return $email_list;
	}
}
