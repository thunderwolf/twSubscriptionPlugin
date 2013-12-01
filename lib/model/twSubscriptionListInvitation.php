<?php

/**
 * Subclass for representing a row from the 'tw_subscription_list_invitation' table.
 *
 *
 *
 * @package plugins.twSubscriptionPlugin.lib.model
 */
class twSubscriptionListInvitation extends BasetwSubscriptionListInvitation
{
	public function getList()
	{
		return $this->gettwSubscriptionList();
	}

	public function getType()
	{
		return $this->gettwSubscriptionMessageType();
	}
}
