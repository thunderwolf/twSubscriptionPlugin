<?php

/**
 * twSubscriptionList form.
 *
 * @package    form
 * @subpackage tw_subscription_list
 * @version    SVN: $Id: twSubscriptionListForm.class.php 497 2011-02-28 23:26:45Z ldath $
 */
class twSubscriptionListForm extends BasetwSubscriptionListForm {
	public function configure() {
		$this->setValidator('mailfrom', new sfValidatorEmail());
		unset($this['language_id']);
		unset($this['lastsync_at']);
	}
}
