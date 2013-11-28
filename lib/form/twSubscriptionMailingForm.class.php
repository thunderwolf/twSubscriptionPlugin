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
		unset($this['created_at']);
	}
}
