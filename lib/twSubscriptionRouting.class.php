<?php
/**
 * twSubscriptionPlugin routing.
 *
 * @package    twSubscriptionPlugin
 * @subpackage routing
 * @author     Arkadiusz Tułodziecki
 */
class twSubscriptionRouting {
	static public function addRouteForSubscriptionSubscribe(sfEvent $event) {
		$subscribe_folder = sfConfig::get('app_tw_subscription_subscribe_prefix', 'subscribe');
		$event->getSubject()->prependRoute('subscription_subscribe', new sfRoute('/'.$subscribe_folder, array(
			'module' => 'twSubscriptionSubscribe', 'action' => 'index'
		), array(), array()));
	}

	static public function addRouteForSubscriptionUnsubscribe(sfEvent $event) {
		$un_subscribe_folder = sfConfig::get('app_tw_subscription_unsubscribe_prefix', 'unsubscribe');
		$event->getSubject()->prependRoute('subscription_unsubscribe', new sfRoute('/'.$un_subscribe_folder.'/:id/:auth_key', array(
				'module' => 'twSubscriptionUnsubscribe', 'action' => 'index'
		), array(), array()));
	}
}
