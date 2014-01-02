<?php

/**
 * Subclass for representing a row from the 'tw_subscription_template' table.
 *
 *
 *
 * @package plugins.twSubscriptionPlugin.lib.model
 */
class twSubscriptionTemplate extends BasetwSubscriptionTemplate
{
    public function __toString()
    {
        return $this->getTname();
    }

    public function getType()
    {
        return $this->gettwSubscriptionMessageType();
    }
}
