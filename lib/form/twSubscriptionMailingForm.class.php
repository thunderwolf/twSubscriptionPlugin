<?php

/**
 * twSubscriptionMailing form.
 *
 * @package    form
 * @subpackage tw_subscription_mailing
 * @version    SVN: $Id: twSubscriptionMailingForm.class.php 502 2011-03-15 21:03:07Z ldath $
 */
class twSubscriptionMailingForm extends BasetwSubscriptionMailingForm {
	public function configure() {
		unset($this['created_at']);
	}
}
