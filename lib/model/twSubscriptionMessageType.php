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
        $i18n = $this->gettwSubscriptionMessageTypeI18ns();
        if (isset($i18n[0])) {
            return $i18n[0]->getName();
        }
        return $this->getCode();
    }
}
