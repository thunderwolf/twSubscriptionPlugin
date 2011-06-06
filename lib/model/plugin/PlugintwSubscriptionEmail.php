<?php

/**
 * Subclass for representing a row from the 'twSubscription_email' table.
 *
 *
 *
 * @package lib.model
 */
class PlugintwSubscriptionEmail extends BasetwSubscriptionEmail {
	public function getListname() {
		return $this->gettwSubscriptionList()->getListname();
	}
	
	public function getStatus() {
		return $this->gettwSubscriptionStatus()->getName();
	}
}
