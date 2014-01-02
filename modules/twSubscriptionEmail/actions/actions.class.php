<?php

require_once dirname(__FILE__) . '/../lib/twSubscriptionEmailGeneratorConfiguration.class.php';
require_once dirname(__FILE__) . '/../lib/twSubscriptionEmailGeneratorHelper.class.php';

/**
 * twSubscriptionEmail actions.
 *
 * @package    subscription
 * @subpackage twSubscriptionEmail
 * @author     Your name here
 */
class twSubscriptionEmailActions extends autoTwSubscriptionEmailActions
{
    public function preExecute()
    {
        sfConfig::set('tw_admin:default:module', 'tw_subscription');
        sfConfig::set('tw_admin:default:category', 'tw_subscription_email');
        sfConfig::set('tw_admin:default:nav', 'tabs');
        parent::preExecute();
        $this->configuration->setUser($this->getUser());
    }

    public function executeListClean(sfWebRequest $request)
    {
        $this->getUser()->setAttribute('twSubscriptionEmail.list_id', null, 'admin_module');
        $this->redirect('@tw_subscription_email');
    }

    protected function getFilters()
    {
        $out = $this->getUser()->getAttribute('twSubscriptionEmail.filters', $this->configuration->getFilterDefaults(), 'admin_module');
        $list_id = $this->getUser()->getAttribute('twSubscriptionEmail.list_id', null, 'admin_module');
        if (!is_null($list_id)) {
            $out['list_id'] = $list_id;
        }
        return $out;
    }

    public function executeListReturn()
    {
        $this->redirect('@tw_subscription_list');
    }
}
