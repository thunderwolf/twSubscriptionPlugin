<?php

require_once dirname(__FILE__) . '/../lib/twSubscriptionListInvitationGeneratorConfiguration.class.php';
require_once dirname(__FILE__) . '/../lib/twSubscriptionListInvitationGeneratorHelper.class.php';

/**
 * twSubscriptionListInvitation actions.
 *
 * @package    subscription
 * @subpackage twSubscriptionListInvitation
 * @author     Your name here
 */
class twSubscriptionListInvitationActions extends autoTwSubscriptionListInvitationActions {
	public function preExecute() {
		sfConfig::set('tw_admin:default:module', 'tw_subscription');
		sfConfig::set('tw_admin:default:category', 'tw_subscription_list_invitation');
		sfConfig::set('tw_admin:default:nav', 'tabs');
		return parent::preExecute();
	}
}
