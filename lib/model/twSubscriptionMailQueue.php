<?php

/**
 * Subclass for representing a row from the 'tw_subscription_mail_queue' table.
 *
 *
 *
 * @package plugins.twSubscriptionPlugin.lib.model
 */
class twSubscriptionMailQueue extends BasetwSubscriptionMailQueue
{
	public function getMessageType()
	{
		return $this->gettwSubscriptionMessageType();
	}
}
