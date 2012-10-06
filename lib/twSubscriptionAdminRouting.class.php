<?php

/**
 * twSubscriptionPlugin routing.
 *
 * @package    twSubscriptionPlugin
 * @subpackage routing
 * @author     Arkadiusz Tułodziecki
 */
class twSubscriptionAdminRouting {
	static public function addRouteForAdminSubscriptionInfo(sfEvent $event) {
		$event->getSubject()
			->prependRoute('tw_subscription_info',
				new sfRoute('/tw_subscription_info', array(
					'module' => 'twSubscriptionInfo', 'action' => 'index'
				), array(), array()));
		$event->getSubject()
			->prependRoute('tw_subscription_faq',
				new sfRoute('/tw_subscription_faq', array(
					'module' => 'twSubscriptionInfo', 'action' => 'pytania'
				), array(), array()));
		$event->getSubject()
			->prependRoute('tw_subscription_import',
				new sfRoute('/tw_subscription_import', array(
					'module' => 'twSubscriptionInfo', 'action' => 'import'
				), array(), array()));
	}
	
	static public function addRouteForAdminSubscriptionList(sfEvent $event) {
		$event->getSubject()->prependRoute('tw_subscription_list', new sfPropelORMRouteCollection(array(
			'name' => 'tw_subscription_list',
			'model' => 'twSubscriptionList',
			'module' => 'twSubscriptionList',
			'prefix_path' => 'tw_subscription_list',
			'with_wildcard_routes' => true,
			'requirements' => array()
		)));
	}
	
	static public function addRouteForAdminSubscriptionEmail(sfEvent $event) {
		$event->getSubject()->prependRoute('tw_subscription_email', new sfPropelORMRouteCollection(array(
			'name' => 'tw_subscription_email',
			'model' => 'twSubscriptionEmail',
			'module' => 'twSubscriptionEmail',
			'prefix_path' => 'tw_subscription_email',
			'with_wildcard_routes' => true,
			'requirements' => array()
		)));
		$event->getSubject()
			->prependRoute('tw_subscription_email_clean',
				new sfRoute('/tw_subscription_email_clean', array(
					'module' => 'twSubscriptionEmail', 'action' => 'ListClean'
				), array(), array()));
	}
	
	static public function addRouteForAdminSubscriptionMessage(sfEvent $event) {
		$event->getSubject()->prependRoute('tw_subscription_message', new sfPropelORMRouteCollection(array(
			'name' => 'tw_subscription_message',
			'model' => 'twSubscriptionMessage',
			'module' => 'twSubscriptionMessage',
			'prefix_path' => 'tw_subscription_message',
			'with_wildcard_routes' => true,
			'requirements' => array()
		)));
	}
	
	static public function addRouteForAdminSubscriptionMailing(sfEvent $event) {
		$event->getSubject()->prependRoute('tw_subscription_mailing', new sfPropelORMRouteCollection(array(
			'name' => 'tw_subscription_mailing',
			'model' => 'twSubscriptionMailing',
			'module' => 'twSubscriptionMailing',
			'prefix_path' => 'tw_subscription_mailing',
			'with_wildcard_routes' => true,
			'requirements' => array()
		)));
	}
	
	static public function addRouteForAdminSubscriptionMailQueue(sfEvent $event) {
		$event->getSubject()->prependRoute('tw_subscription_mail_queue', new sfPropelORMRouteCollection(array(
			'name' => 'tw_subscription_mail_queue',
			'model' => 'twSubscriptionMailQueue',
			'module' => 'twSubscriptionMailQueue',
			'prefix_path' => 'tw_subscription_mail_queue',
			'with_wildcard_routes' => true,
			'requirements' => array()
		)));
	}
	
	static public function addRouteForAdminSubscriptionMailSent(sfEvent $event) {
		$event->getSubject()->prependRoute('tw_subscription_mail_sent', new sfPropelORMRouteCollection(array(
			'name' => 'tw_subscription_mail_sent',
			'model' => 'twSubscriptionMailSent',
			'module' => 'twSubscriptionMailSent',
			'prefix_path' => 'tw_subscription_mail_sent',
			'with_wildcard_routes' => true,
			'requirements' => array()
		)));
	}
	
	static public function addRouteForAdminSubscriptionSetup(sfEvent $event) {
		$event->getSubject()->prependRoute('tw_subscription_setup', new sfPropelORMRouteCollection(array(
			'name' => 'tw_subscription_setup',
			'model' => 'twSubscriptionSetup',
			'module' => 'twSubscriptionSetup',
			'prefix_path' => 'tw_subscription_setup',
			'with_wildcard_routes' => true,
			'requirements' => array()
		)));
	}
	
	static public function addRouteForAdminSubscriptionTemplate(sfEvent $event) {
		$event->getSubject()->prependRoute('tw_subscription_template', new sfPropelORMRouteCollection(array(
			'name' => 'tw_subscription_template',
			'model' => 'twSubscriptionTemplate',
			'module' => 'twSubscriptionTemplate',
			'prefix_path' => 'tw_subscription_template',
			'with_wildcard_routes' => true,
			'requirements' => array()
		)));
	}
}
