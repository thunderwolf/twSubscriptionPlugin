<?php

class twSubscriptionAdminRouting
{
	static public function addRouteForSubscriptionList(sfEvent $event)
	{
		$event->getSubject()->prependRoute('tw_subscription_list', new sfPropelRouteCollection(array(
			'name'                 => 'tw_subscription_list',
			'model'                => 'twSubscriptionList',
			'module'               => 'twSubscriptionList',
			'prefix_path'          => 'twSubscriptionList',
			'column'               => 'id',
			'with_wildcard_routes' => true,
			'requirements'         => array(),
		)));
	}

	static public function addRouteForSubscriptionEmail(sfEvent $event)
	{
		$event->getSubject()->prependRoute('tw_subscription_email', new sfPropelRouteCollection(array(
			'name'                 => 'tw_subscription_email',
			'model'                => 'twSubscriptionEmail',
			'module'               => 'twSubscriptionEmail',
			'prefix_path'          => 'twSubscriptionEmail',
			'column'               => 'id',
			'with_wildcard_routes' => true,
			'requirements'         => array(),
		)));
	}

	static public function addRouteForSubscriptionMessage(sfEvent $event)
	{
		$event->getSubject()->prependRoute('tw_subscription_message', new sfPropelRouteCollection(array(
			'name'                 => 'tw_subscription_message',
			'model'                => 'twSubscriptionMessage',
			'module'               => 'twSubscriptionMessage',
			'prefix_path'          => 'twSubscriptionMessage',
			'column'               => 'id',
			'with_wildcard_routes' => true,
			'requirements'         => array(),
		)));
	}

	static public function addRouteForSubscriptionMailing(sfEvent $event)
	{
		$event->getSubject()->prependRoute('tw_subscription_mailing', new sfPropelRouteCollection(array(
			'name'                 => 'tw_subscription_mailing',
			'model'                => 'twSubscriptionMailing',
			'module'               => 'twSubscriptionMailing',
			'prefix_path'          => 'twSubscriptionMailing',
			'column'               => 'id',
			'with_wildcard_routes' => true,
			'requirements'         => array(),
		)));
	}

	static public function addRouteForSubscriptionMailQueue(sfEvent $event)
	{
		$event->getSubject()->prependRoute('tw_subscription_mail_queue', new sfPropelRouteCollection(array(
			'name'                 => 'tw_subscription_mail_queue',
			'model'                => 'twSubscriptionMailQueue',
			'module'               => 'twSubscriptionMailQueue',
			'prefix_path'          => 'twSubscriptionMailQueue',
			'column'               => 'id',
			'with_wildcard_routes' => true,
			'requirements'         => array(),
		)));
	}

	static public function addRouteForSubscriptionMailSent(sfEvent $event)
	{
		$event->getSubject()->prependRoute('tw_subscription_mail_sent', new sfPropelRouteCollection(array(
			'name'                 => 'tw_subscription_mail_sent',
			'model'                => 'twSubscriptionMailSent',
			'module'               => 'twSubscriptionMailSent',
			'prefix_path'          => 'twSubscriptionMailSent',
			'column'               => 'id',
			'with_wildcard_routes' => true,
			'requirements'         => array(),
		)));
	}

	static public function addRouteForSubscriptionSetup(sfEvent $event)
	{
		$event->getSubject()->prependRoute('tw_subscription_setup', new sfPropelRouteCollection(array(
			'name'                 => 'tw_subscription_setup',
			'model'                => 'twSubscriptionSetup',
			'module'               => 'twSubscriptionSetup',
			'prefix_path'          => 'twSubscriptionSetup',
			'column'               => 'id',
			'with_wildcard_routes' => true,
			'requirements'         => array(),
		)));
	}

	static public function addRouteForSubscriptionTemplate(sfEvent $event)
	{
		$event->getSubject()->prependRoute('tw_subscription_template', new sfPropelRouteCollection(array(
			'name'                 => 'tw_subscription_template',
			'model'                => 'twSubscriptionTemplate',
			'module'               => 'twSubscriptionTemplate',
			'prefix_path'          => 'twSubscriptionTemplate',
			'column'               => 'id',
			'with_wildcard_routes' => true,
			'requirements'         => array(),
		)));
	}
}
