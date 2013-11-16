<?php

require_once dirname(__FILE__) . '/../lib/twSubscriptionSetupGeneratorConfiguration.class.php';
require_once dirname(__FILE__) . '/../lib/twSubscriptionSetupGeneratorHelper.class.php';

/**
 * twSubscriptionSetup actions.
 *
 * @package    pzmtravel
 * @subpackage twSubscriptionSetup
 * @author     Your name here
 */
class twSubscriptionSetupActions extends autoTwSubscriptionSetupActions {
	public function preExecute() {
		sfConfig::set('tw_admin:default:module', 'tw_subscription');
		sfConfig::set('tw_admin:default:category', 'tw_subscription_setup');
		sfConfig::set('tw_admin:default:nav', 'tabs');
		return parent::preExecute();
	}
}
