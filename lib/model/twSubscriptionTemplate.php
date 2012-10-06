<?php

/**
 * Subclass for representing a row from the 'tw_subscription_template' table.
 *
 *
 *
 * @package plugins.twSubscriptionPlugin.lib.model
 */
class twSubscriptionTemplate extends BasetwSubscriptionTemplate {
	public function __toString() {
		return $this->getTname();
	}
	
	public function getType() {
		$c = new Criteria();
		$c->add(twSubscriptionMessageTypePeer::ID, $this->getTypeId());
		$type = twSubscriptionMessageTypePeer::doSelectWithI18n($c);
		if (!empty($type[0])) {
			return $type[0]->getName();
		} else {
			return null;
		}
	}
}
