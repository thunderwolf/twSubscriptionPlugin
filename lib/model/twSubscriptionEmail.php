<?php

/**
 * Subclass for representing a row from the 'tw_subscription_email' table.
 *
 *
 *
 * @package plugins.twSubscriptionPlugin.lib.model
 */
class twSubscriptionEmail extends BasetwSubscriptionEmail {
	public function getListname() {
		return $this->gettwSubscriptionList()->getListname();
	}
	
	public function getStatus() {
		return $this->gettwSubscriptionStatus()->getName();
	}
}
