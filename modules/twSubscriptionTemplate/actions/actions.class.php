<?php

require_once dirname(__FILE__) . '/../lib/twSubscriptionTemplateGeneratorConfiguration.class.php';
require_once dirname(__FILE__) . '/../lib/twSubscriptionTemplateGeneratorHelper.class.php';

/**
 * twSubscriptionTemplate actions.
 *
 * @package    subscription
 * @subpackage twSubscriptionTemplate
 * @author     Your name here
 */
class twSubscriptionTemplateActions extends autoTwSubscriptionTemplateActions {
	public function preExecute() {
		sfConfig::set('tw_admin:default:module', 'tw_subscription');
		sfConfig::set('tw_admin:default:category', 'tw_subscription_template');
		sfConfig::set('tw_admin:default:nav', 'tabs');
		return parent::preExecute();
	}
}
