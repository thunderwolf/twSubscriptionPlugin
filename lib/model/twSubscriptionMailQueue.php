<?php

/**
 * Subclass for representing a row from the 'tw_subscription_mail_queue' table.
 *
 *
 *
 * @package plugins.twSubscriptionPlugin.lib.model
 */
class twSubscriptionMailQueue extends BasetwSubscriptionMailQueue {
	public function getMessageType() {
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
