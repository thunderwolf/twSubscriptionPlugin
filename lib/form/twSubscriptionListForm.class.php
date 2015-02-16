<?php

/**
 * twSubscriptionList form.
 *
 * @package    form
 * @subpackage tw_subscription_list
 */
class twSubscriptionListForm extends BasetwSubscriptionListForm
{
    public function configure()
    {
        $this->setWidget('smtp_encr', new sfWidgetFormChoice(array('choices' => array(0 => 'Bez szyfrowania', 2 => 'STARTTLS', 1 => 'SSL/TLS'))));
        $this->setValidator('smt_encr', new sfValidatorChoice(array('required' => false, 'choices' => array(0, 1, 0))));
        $this->setValidator('from_address', new sfValidatorEmail());
        unset($this['language_id']);
        unset($this['last_sync_at']);
    }
}
