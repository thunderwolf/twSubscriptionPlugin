<?php

/**
 * pzmFormGenPlugin configuration.
 *
 * @package     pzmFormGenPlugin
 * @subpackage  config
 * @author      Arkadiusz Tułodziecki
 */
class twSubscriptionPluginConfiguration extends sfPluginConfiguration {
	const VERSION = '1.2.0.1';
	const DATE = '06.05.2011';

	/**
	 * @see sfPluginConfiguration
	 */
	public function initialize() {
		require_once dirname(__FILE__) . '/../lib/twSubscriptionRouting.class.php';

		if (sfConfig::get('app_tw_subscription_plugin_routes_register', true) && in_array('twSubscriptionUnsubscribe', sfConfig::get('sf_enabled_modules', array()))) {
			$this->dispatcher->connect('routing.load_configuration', array('twSubscriptionRouting', 'listenToRoutingLoadConfigurationEvent'));
		}

		// ADMIN ROUTING
		if (is_array(sfConfig::get('sf_enabled_modules'))) {
			require_once dirname(__FILE__) . '/../lib/twSubscriptionAdminRouting.class.php';
			
			$a_modules = array('twSubscriptionList', 'twSubscriptionEmail', 'twSubscriptionMessage', 'twSubscriptionMailing', 'twSubscriptionMailQueue', 'twSubscriptionMailSent', 'twSubscriptionSetup', 'twSubscriptionTemplate');
			foreach ($a_modules as $module) {
				if (in_array($module, sfConfig::get('sf_enabled_modules'))) {
					$this->dispatcher->connect('routing.load_configuration', array('twSubscriptionAdminRouting', 'addRouteFor'.str_replace('tw', '', $module)));
				}
			}
		}
	}
}
