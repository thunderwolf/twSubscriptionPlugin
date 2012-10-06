<?php

/**
 * Subclass for representing a row from the 'tw_subscription_list_type' table.
 *
 *
 *
 * @package plugins.twSubscriptionPlugin.lib.model
 */
class twSubscriptionListType extends BasetwSubscriptionListType {
	public function __toString() {
		return $this->getName();
	}
}
