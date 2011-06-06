<?php

/**
 * Subclass for representing a row from the 'twSubscription_mail_queue' table.
 *
 *
 *
 * @package lib.model
 */
class PlugintwSubscriptionMailQueue extends BasetwSubscriptionMailQueue
{
	
	public function getMessageType()
	{
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
