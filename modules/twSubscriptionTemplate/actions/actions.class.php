<?php

require_once dirname(__FILE__) . '/../lib/twSubscriptionTemplateGeneratorConfiguration.class.php';
require_once dirname(__FILE__) . '/../lib/twSubscriptionTemplateGeneratorHelper.class.php';

/**
 * twSubscriptionTemplate actions.
 *
 * @package    pzmtravel
 * @subpackage twSubscriptionTemplate
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 1011 2012-09-11 05:45:22Z ldath $
 */
class twSubscriptionTemplateActions extends autoTwSubscriptionTemplateActions {
	public function preExecute() {
		sfConfig::set('tw_admin:default:module', 'tw_subscription');
		sfConfig::set('tw_admin:default:category', 'tw_subscription_template');
		sfConfig::set('tw_admin:default:nav', 'tabs');
		return parent::preExecute();
	}
}
