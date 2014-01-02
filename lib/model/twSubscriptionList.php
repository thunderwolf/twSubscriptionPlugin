<?php

/**
 * Subclass for representing a row from the 'tw_subscription_list' table.
 *
 *
 *
 * @package plugins.twSubscriptionPlugin.lib.model
 */
class twSubscriptionList extends BasetwSubscriptionList
{
    public $website_code_js;
    public $website_code_php;

    public function __toString()
    {
        return $this->getListname();
    }

    public function getListType()
    {
        return $this->gettwSubscriptionListType();
    }

    public function getMessageTypeId()
    {
        $template = twSubscriptionTemplateQuery::create()->findPk($this->getTemplateId());
        if ($template instanceof twSubscriptionTemplate) {
            return $template->getTypeId();
        }
        return null;
    }

    public function getEmails()
    {
        return $this->counttwSubscriptionEmails();
    }

    public function getCreateMailing()
    {
        return 0;
    }
}
