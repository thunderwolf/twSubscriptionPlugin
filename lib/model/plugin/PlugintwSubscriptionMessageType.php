<?php

/**
 * Subclass for representing a row from the 'twSubscription_message_type' table.
 *
 * 
 *
 * @package lib.model
 */ 
class PlugintwSubscriptionMessageType extends BasetwSubscriptionMessageType
{

	public function __toString()
	{
		return $this->getName();
	}
	
}
