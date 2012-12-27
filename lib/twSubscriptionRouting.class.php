<?php
/**
 * twSubscriptionPlugin routing.
 *
 * @package    twSubscriptionPlugin
 * @subpackage routing
 * @author     Arkadiusz Tułodziecki
 */
class twSubscriptionRouting {
	static public function addRouteForSubscriptionUnsubscribe(sfEvent $event) {
		$event->getSubject()->prependRoute('subscription_unsubscribe', new sfRoute('/unsubscribe/:id/:auth_key', array(
				'module' => 'twSubscriptionUnsubscribe', 'action' => 'index'
		), array(), array()));
	}
}
