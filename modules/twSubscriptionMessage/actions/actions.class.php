<?php

require_once dirname(__FILE__) . '/../lib/twSubscriptionMessageGeneratorConfiguration.class.php';
require_once dirname(__FILE__) . '/../lib/twSubscriptionMessageGeneratorHelper.class.php';

/**
 * twSubscriptionMessage actions.
 *
 * @package    subscription
 * @subpackage twSubscriptionMessage
 * @author     Your name here
 */
class twSubscriptionMessageActions extends autoTwSubscriptionMessageActions
{
    public function preExecute()
    {
        sfConfig::set('tw_admin:default:module', 'tw_subscription');
        sfConfig::set('tw_admin:default:category', 'tw_subscription_message');
        sfConfig::set('tw_admin:default:nav', 'tabs');
        parent::preExecute();
        $this->configuration->setUser($this->getUser());
    }

    protected function getFilters()
    {
        $out = $this->getUser()->getAttribute('twSubscriptionMessage.filters', $this->configuration->getFilterDefaults(), 'admin_module');
        $type_id = $this->getUser()->getAttribute('twSubscriptionMessage.type_id', null, 'admin_module');
        if (!is_null($type_id)) {
            $out['type_id'] = $type_id;
        }
        return $out;
    }

    public function executeListReturn()
    {
        $this->redirect('@tw_subscription_list');
    }

    public function executeCreateMailing(sfWebRequest $request)
    {
        $list_id = $this->getUser()->getAttribute('twSubscriptionMessage.list_id', null, 'admin_module');
        $type_id = $this->getUser()->getAttribute('twSubscriptionMessage.type_id', null, 'admin_module');
        if (is_null($list_id) or is_null($type_id)) {
            $this->forward404();
        }

        $list = twSubscriptionListPeer::retrieveByPK($list_id);
        $this->forward404Unless($list);

        $response = $this->getResponse();

        $message = '';

        $template_id = $list->getTemplateId();
        if (!empty($template_id)) {
            $template = twSubscriptionTemplatePeer::retrieveByPK($template_id);
            $this->forward404Unless($template);
            $type_id = $template->getTypeId();
            $message = $template->getTdata();
        }

        $this->form = new twSubscriptionCreateMailingForm(array('message' => $message), array('type_id' => $type_id));
        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter('mailing'));
            if ($this->form->isValid()) {
                twSubscriptionMailingLib::createMailing($list_id, $type_id, $this->form->getValue('subject'), $this->form->getValue('message'), $this->form->getValue('time_to_send'));
                $this->redirect('@tw_subscription_mailing');
            }
        }
    }
}
