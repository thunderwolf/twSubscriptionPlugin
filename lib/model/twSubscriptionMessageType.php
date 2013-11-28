<?php

/**
 * Subclass for representing a row from the 'tw_subscription_message_type' table.
 *
 *
 *
 * @package plugins.twSubscriptionPlugin.lib.model
 */
class twSubscriptionMessageType extends BasetwSubscriptionMessageType
{
	public function __toString()
	{
		return $this->getName();
	}
}
