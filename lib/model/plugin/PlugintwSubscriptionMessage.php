<?php

/**
 * Subclass for representing a row from the 'twSubscription_message' table.
 *
 * 
 *
 * @package lib.model
 */ 
class PlugintwSubscriptionMessage extends BasetwSubscriptionMessage
{

	protected $time_to_send;	
	
	public function __toString()
	{
		return $this->getSubject();	
	}	
	
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

	public function getTimeToSend($format = 'Y-m-d H:i:s')
	{
		if ($this->time_to_send === null || $this->time_to_send === '') {
			return null;
		} elseif (!is_int($this->time_to_send)) {
			$ts = strtotime($this->time_to_send);
			if ($ts === -1 || $ts === false) { 				
				throw new PropelException("Unable to parse value of [time_to_send] as date/time value: " . var_export($this->time_to_send, true));
			}
		} else {
			$ts = $this->time_to_send;
		}
		if ($format === null) {
			return $ts;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $ts);
		} else {
			return date($format, $ts);
		}
	}
	
}
