<?php

require_once dirname(__FILE__) . '/../lib/twSubscriptionSetupGeneratorConfiguration.class.php';
require_once dirname(__FILE__) . '/../lib/twSubscriptionSetupGeneratorHelper.class.php';

/**
 * twSubscriptionSetup actions.
 *
 * @package    pzmtravel
 * @subpackage twSubscriptionSetup
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 1011 2012-09-11 05:45:22Z ldath $
 */
class twSubscriptionSetupActions extends autoTwSubscriptionSetupActions {
	public function preExecute() {
		sfConfig::set('tw_admin:default:module', 'tw_subscription');
		sfConfig::set('tw_admin:default:category', 'tw_subscription_setup');
		sfConfig::set('tw_admin:default:nav', 'tabs');
		return parent::preExecute();
	}
}
