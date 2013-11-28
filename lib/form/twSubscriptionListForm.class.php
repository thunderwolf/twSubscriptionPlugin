<?php

/**
 * twSubscriptionList form.
 *
 * @package    form
 * @subpackage tw_subscription_list
 */
class twSubscriptionListForm extends BasetwSubscriptionListForm
{
	public function configure()
	{
		$this->setValidator('from_address', new sfValidatorEmail());
		unset($this['language_id']);
		unset($this['last_sync_at']);
	}
}
