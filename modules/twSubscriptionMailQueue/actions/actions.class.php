<?php

require_once dirname(__FILE__) . '/../lib/twSubscriptionMailQueueGeneratorConfiguration.class.php';
require_once dirname(__FILE__) . '/../lib/twSubscriptionMailQueueGeneratorHelper.class.php';

/**
 * twSubscriptionMailQueue actions.
 *
 * @package    subscription
 * @subpackage twSubscriptionMailQueue
 * @author     Your name here
 */
class twSubscriptionMailQueueActions extends autoTwSubscriptionMailQueueActions {
	public function preExecute() {
		sfConfig::set('tw_admin:default:module', 'tw_subscription');
		sfConfig::set('tw_admin:default:category', 'tw_subscription_mail_queue');
		sfConfig::set('tw_admin:default:nav', 'tabs');
		return parent::preExecute();
	}
}
