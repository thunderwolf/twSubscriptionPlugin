<?php

require_once dirname(__FILE__) . '/../lib/twSubscriptionMailSentGeneratorConfiguration.class.php';
require_once dirname(__FILE__) . '/../lib/twSubscriptionMailSentGeneratorHelper.class.php';

/**
 * twSubscriptionMailSent actions.
 *
 * @package    pzmtravel
 * @subpackage twSubscriptionMailSent
 * @author     Your name here
 */
class twSubscriptionMailSentActions extends autoTwSubscriptionMailSentActions {
	public function preExecute() {
		sfConfig::set('tw_admin:default:module', 'tw_subscription');
		sfConfig::set('tw_admin:default:category', 'tw_subscription_mail_sent');
		sfConfig::set('tw_admin:default:nav', 'tabs');
		return parent::preExecute();
	}
}
