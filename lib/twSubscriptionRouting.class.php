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
		$news_folder = sfConfig::get('app_tw_news_list_prefix', 'news');
		$event->getSubject()->prependRoute('subscription_unsubscribe', new sfRoute('/unsubscribe/:id/:auth_key', array(
				'module' => 'twSubscriptionUnsubscribe', 'action' => 'index'
		), array(), array()));
	}
}
