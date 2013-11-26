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

		$this->form = new sfForm();
		$this->form->setWidgets(array(
			'remail'    => new sfWidgetFormInputText(),
			'rname'   => new sfWidgetFormInputText()
		));

		$this->form->setValidators(array(
			'remail' => new sfValidatorAnd(array(
					new sfValidatorString(array('max_length' => 250)), new sfValidatorEmail()
				)),
			'rname' => new sfValidatorString(array('max_length' => 250, 'required' => false))
		));
		$this->form->getWidgetSchema()->setNameFormat('subscribe[%s]');

		if ($request->isMethod('post')) {
			$this->form->bind($request->getParameter('subscribe'));
			if ($request->isMethod('post')) {
				$values = $this->form->getValues();
				$status = twSubscriptionStatusQuery::create()->findOneByCode('pending');

				$email_list = twSubscriptionEmailQuery::create()
					->filterBytwSubscriptionList($list)
					->findOneByRemail($values['remail']);

				if (!$email_list) {
					$email_list = $this->savePendingEmail($list, $status, $values);
				}
			}
		}
	}

	protected function savePendingEmail(twSubscriptionList $list, twSubscriptionStatus $status, $values)
	{
		$email_list = new twSubscriptionEmail();
		$email_list->settwSubscriptionList($list);
		$email_list->settwSubscriptionStatus($status);
		$email_list->setRemail($values['remail']);
		$email_list->setRname($values['rname']);
		$email_list->setExpires(strtotime("+1 day"));
		$email_list->setAuthKey(microtime(true));
		$email_list->save();
		return $email_list;
	}

	protected function sendPendingEmail(twSubscriptionList $list, $values)
	{
		$message = Swift_Message::newInstance()
			->setFrom($list->getMailfrom(), $list->getFromname())
			->setTo($values['remail'], $values['rname'])
			->setSubject('Powiadomienie o nowym zgłoszeniu kontaktowym')
			->setBody($body)
		;
		$this->getMailer()->send($message);

	}
}
