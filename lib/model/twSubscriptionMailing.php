<?php

/**
 * Subclass for representing a row from the 'tw_subscription_mailing' table.
 *
 *
 *
 * @package plugins.twSubscriptionPlugin.lib.model
 */
class twSubscriptionMailing extends BasetwSubscriptionMailing
{
	public function __toString()
	{
		return $this->getMessage();
	}

	public function getList()
	{
		return $this->gettwSubscriptionList()->getListName();
	}

	public function getMessage()
	{
		return $this->gettwSubscriptionMessage()->getSubject();
	}

	public function getInQueue()
	{
		return $this->counttwSubscriptionMailQueues();
	}

	public function getInSent()
	{
		return $this->counttwSubscriptionMailSents();
	}
}
