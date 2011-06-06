<?php

/**
 * Subclass for representing a row from the 'twSubscription_mailing' table.
 *
 *
 *
 * @package lib.model
 */
class PlugintwSubscriptionMailing extends BasetwSubscriptionMailing {
	public function __toString() {
		return $this->getMessage();
	}
	
	public function getList() {
		return $this->gettwSubscriptionList()->getListname();
	}
	
	public function getMessage() {
		return $this->gettwSubscriptionMessage()->getSubject();
	}
	
	public function getInQueue() {
		return $this->counttwSubscriptionMailQueues();
	}
	
	public function getInSent() {
		return $this->counttwSubscriptionMailSents();
	}

}
