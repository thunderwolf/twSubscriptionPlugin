<?php

/**
 * Subclass for representing a row from the 'twSubscription_listtype' table.
 *
 * 
 *
 * @package lib.model
 */ 
class PlugintwSubscriptionListType extends BasetwSubscriptionListType
{

	public function __toString()
	{
		return $this->getName();
	}
	
}
