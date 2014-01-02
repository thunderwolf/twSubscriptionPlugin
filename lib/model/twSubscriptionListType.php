<?php

/**
 * Subclass for representing a row from the 'tw_subscription_list_type' table.
 *
 *
 *
 * @package plugins.twSubscriptionPlugin.lib.model
 */
class twSubscriptionListType extends BasetwSubscriptionListType
{
    public function __toString()
    {
        $i18n = $this->gettwSubscriptionListTypeI18ns();
        if (isset($i18n[0])) {
            return $i18n[0]->getName();
        }
        return $this->getCode();
    }
}
