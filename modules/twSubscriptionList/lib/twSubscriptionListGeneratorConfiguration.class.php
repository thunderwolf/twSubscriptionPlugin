<?php

/**
 * pzmFormEmail module configuration.
 *
 * @package    subscription
 * @subpackage pzmFormEmail
 * @author     Your name here
 * @version    SVN: $Id: twSubscriptionListGeneratorConfiguration.class.php 491 2011-02-22 22:33:23Z ldath $
 */
class twSubscriptionListGeneratorConfiguration extends BaseTwSubscriptionListGeneratorConfiguration
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
