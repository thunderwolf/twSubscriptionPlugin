<?php

/**
 * twSubscriptionPlugin configuration.
 *
 * @package     twSubscriptionPlugin
 * @subpackage  config
 * @author      Arkadiusz Tułodziecki
 */
class twSubscriptionPluginConfiguration extends sfPluginConfiguration {
	const VERSION = '1.3.0';
	const DATE = '2013-06-11';

	/**
	 * @see sfPluginConfiguration
	 */
	public function initialize() {
		if (in_array('twAdmin', sfConfig::get('sf_enabled_modules', array()))) {
			$modules = array('twSubscriptionInfo', 'twSubscriptionList', 'twSubscriptionEmail', 'twSubscriptionMessage', 'twSubscriptionMailing', 'twSubscriptionMailQueue', 'twSubscriptionMailSent', 'twSubscriptionSetup', 'twSubscriptionTemplate');
			sfConfig::set('sf_enabled_modules', array_merge((array) sfConfig::get('sf_enabled_modules'), $modules));
			
			foreach ($modules as $module) {
				$this->dispatcher->connect('routing.load_configuration', array('twSubscriptionAdminRouting', 'addRouteForAdmin' . str_replace('tw', '', $module)));
			}
		} else {
			$modules = array('twSubscriptionUnsubscribe');
			sfConfig::set('sf_enabled_modules', array_merge((array) sfConfig::get('sf_enabled_modules'), $modules));
			foreach ($modules as $module) {
				$this->dispatcher->connect('routing.load_configuration', array('twSubscriptionRouting', 'addRouteFor' . str_replace('tw', '', $module)));
			}
		}
	}
}
