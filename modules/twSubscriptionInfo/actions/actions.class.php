<?php

/**
 * esub_info actions.
 *
 * @package    subskrypcja
 * @subpackage esub_info
 * @author     Arkadiusz Tułodziecki
 */
class twSubscriptionInfoActions extends sfActions
{
	public function preExecute()
	{
		sfConfig::set('tw_admin:default:module', 'tw_subscription');
		sfConfig::set('tw_admin:default:category', 'tw_subscription_info');
		sfConfig::set('tw_admin:default:nav', 'tabs');
		return parent::preExecute();
	}

	public function executeIndex($request)
	{
	}

	public function executePytania($request)
	{
		sfConfig::set('tw_admin:default:category', 'tw_subscription_faq');
	}
}
