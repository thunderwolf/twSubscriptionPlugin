<?php

/**
 * twSubscriptionPlugin configuration.
 *
 * @package     twSubscriptionPlugin
 * @subpackage  config
 * @author      Arkadiusz Tułodziecki
 */
class twSubscriptionPluginConfiguration extends sfPluginConfiguration
{
    const VERSION = '1.4';
    const DATE = '2014-01-02';

    /**
     * @see sfPluginConfiguration
     */
    public function initialize()
    {
        if (in_array('twAdmin', sfConfig::get('sf_enabled_modules', array()))) {
            $modules = array('twSubscriptionInfo', 'twSubscriptionList', 'twSubscriptionEmail', 'twSubscriptionMessage', 'twSubscriptionMailing', 'twSubscriptionMailQueue', 'twSubscriptionMailSent', 'twSubscriptionListInvitation', 'twSubscriptionTemplate');
            sfConfig::set('sf_enabled_modules', array_merge((array)sfConfig::get('sf_enabled_modules'), $modules));

            foreach ($modules as $module) {
                $this->dispatcher->connect('routing.load_configuration', array('twSubscriptionAdminRouting', 'addRouteForAdmin' . str_replace('tw', '', $module)));
            }
        } else {
            $modules = array('twSubscriptionSubscribe', 'twSubscriptionUnsubscribe');
            sfConfig::set('sf_enabled_modules', array_merge((array)sfConfig::get('sf_enabled_modules'), $modules));
            foreach ($modules as $module) {
                $this->dispatcher->connect('routing.load_configuration', array('twSubscriptionRouting', 'addRouteFor' . str_replace('tw', '', $module)));
            }
        }
    }
}
