<?php
/*
 */

/**
 *
 * @package    thunderwolf
 * @subpackage plugin
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: twSubscriptionRouting.class.php 285 2009-01-19 22:22:41Z ldath $
 */
class twSubscriptionRouting
{
	/**
	 * Listens to the routing.load_configuration event.
	 *
	 * @param sfEvent An sfEvent instance
	 */
	static public function listenToRoutingLoadConfigurationEvent(sfEvent $event)
	{
		$r = $event->getSubject();
		$r->prependRoute('subscription_unsubscribe', '/unsubscribe/:id/:auth_key', array('module' => 'twSubscriptionUnsubscribe', 'action' => 'index'));
	}
}
