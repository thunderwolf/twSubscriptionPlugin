<?php

require_once dirname(__FILE__) . '/../lib/twSubscriptionMailQueueGeneratorConfiguration.class.php';
require_once dirname(__FILE__) . '/../lib/twSubscriptionMailQueueGeneratorHelper.class.php';

/**
 * twSubscriptionMailQueue actions.
 *
 * @package    pzmtravel
 * @subpackage twSubscriptionMailQueue
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 1011 2012-09-11 05:45:22Z ldath $
 */
class twSubscriptionMailQueueActions extends autoTwSubscriptionMailQueueActions {
	public function preExecute() {
		sfConfig::set('tw_admin:default:module', 'tw_subscription');
		sfConfig::set('tw_admin:default:category', 'tw_subscription_mail_queue');
		sfConfig::set('tw_admin:default:nav', 'tabs');
		return parent::preExecute();
	}
}
