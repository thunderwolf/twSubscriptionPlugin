<?php

/**
 * Subclass for representing a row from the 'tw_subscription_status' table.
 *
 * 
 *
 * @package plugins.twSubscriptionPlugin.lib.model
 */ 
class PlugintwSubscriptionStatus extends BasetwSubscriptionStatus
{
	public function __toString()
	{
		return $this->getName();
	}
	
}
