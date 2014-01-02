<?php

/**
 * twSubscriptionMessage module configuration.
 *
 * @package    subscription
 * @subpackage twSubscriptionMessage
 * @author     Your name here
 */
class twSubscriptionMessageGeneratorConfiguration extends BaseTwSubscriptionMessageGeneratorConfiguration
{
    protected $user = null;

    public function setUser($user)
    {
        $this->user = $user;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function getFormOptions()
    {
        return array('user' => $this->getUser());
    }
}
