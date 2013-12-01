<?php

/**
 * Subclass for representing a row from the 'tw_subscription_status' table.
 *
 *
 *
 * @package plugins.twSubscriptionPlugin.lib.model
 */
class twSubscriptionStatus extends BasetwSubscriptionStatus
{
	public function __toString()
	{
		$i18n = $this->gettwSubscriptionStatusI18ns();
		if (isset($i18n[0])) {
			return $i18n[0]->getName();
		}
		return $this->getCode();
	}
}
