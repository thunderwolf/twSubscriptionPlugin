<?php

require_once dirname(__FILE__) . '/../lib/twSubscriptionMailSentGeneratorConfiguration.class.php';
require_once dirname(__FILE__) . '/../lib/twSubscriptionMailSentGeneratorHelper.class.php';

/**
 * twSubscriptionMailSent actions.
 *
 * @package    pzmtravel
 * @subpackage twSubscriptionMailSent
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 1011 2012-09-11 05:45:22Z ldath $
 */
class twSubscriptionMailSentActions extends autoTwSubscriptionMailSentActions {
	public function preExecute() {
		sfConfig::set('tw_admin:default:module', 'tw_subscription');
		sfConfig::set('tw_admin:default:category', 'tw_subscription_mail_sent');
		sfConfig::set('tw_admin:default:nav', 'tabs');
		return parent::preExecute();
	}
}
