<?php

/**
 * twSubscriptionMailing form.
 *
 * @package    form
 * @subpackage tw_subscription_mailing
 */
class twSubscriptionMailingForm extends BasetwSubscriptionMailingForm
{
	public function configure()
	{
		$this->setWidget('time_to_send', new sfWidgetFormInput(array(), array('class' => 'input-large j-datetimepicker')));
		unset($this['created_at']);
	}
}
