<?php

require_once dirname(__FILE__) . '/../lib/twSubscriptionListGeneratorConfiguration.class.php';
require_once dirname(__FILE__) . '/../lib/twSubscriptionListGeneratorHelper.class.php';

/**
 * twSubscriptionList actions.
 *
 * @package    subskrypcja
 * @subpackage twSubscriptionList
 * @author     Arkadiusz Tułodziecki
 */
class twSubscriptionListActions extends autotwSubscriptionListActions
{
    public function preExecute()
    {
        sfConfig::set('tw_admin:default:module', 'tw_subscription');
        sfConfig::set('tw_admin:default:category', 'tw_subscription_list');
        sfConfig::set('tw_admin:default:nav', 'tabs');
        parent::preExecute();
        $this->configuration->setUser($this->getUser());
    }

    public function executeCreateEmail(sfWebRequest $request)
    {
        $this->getUser()->setAttribute('twSubscriptionEmail.list_id', $request->getParameter('id'), 'admin_module');
        $this->redirect('@tw_subscription_email_new');
    }

    public function executeListEmails(sfWebRequest $request)
    {
        $this->getUser()->setAttribute('twSubscriptionEmail.list_id', $request->getParameter('id'), 'admin_module');
        $this->redirect('@tw_subscription_email');
    }

    public function executeCreateMailing(sfWebRequest $request)
    {
        $this->getUser()->setAttribute('twSubscriptionMessage.list_id', $request->getParameter('id'), 'admin_module');
        $this->getUser()->setAttribute('twSubscriptionMessage.type_id', $request->getParameter('type_id'), 'admin_module');
        $this->redirect('twSubscriptionMessage/createMailing');
    }

    public function executeCode(sfWebRequest $request)
    {
        $this->tw_subscription_list = $this->getRoute()->getObject();

        $file_code = file_get_contents(sfConfig::get('sf_plugins_dir') . '/twSubscriptionPlugin/modules/twSubscriptionList/templates/templ_code.js');
        $file_code = mb_ereg_replace('\^APP_BASE_URL\^', $_SERVER['SERVER_NAME'], $file_code);
        $file_code = mb_ereg_replace('\^LIST_ID\^', $this->tw_subscription_list->getId(), $file_code);
        $file_code = mb_ereg_replace('\^SNIPPET_ID\^', md5(0xDEADBEEF + $this->tw_subscription_list->getId()), $file_code);

        $this->form = new twSubscriptionCodeForm(array(
            'list_js' => $file_code
        ));
    }

    public function executePhp(sfWebRequest $request)
    {
        $this->setLayout(false);

        $this->tw_subscription_list = $this->getRoute()->getObject();

        $file_php = file_get_contents(sfConfig::get('sf_plugins_dir') . '/twSubscriptionPlugin/modules/twSubscriptionList/templates/templ_transport.php');
        $file_php = mb_ereg_replace('\^APP_BASE_URL\^', $_SERVER['SERVER_NAME'], $file_php);
        $file_php = mb_ereg_replace('\^SHARED_KEY\^', $this->tw_subscription_list->getWebsiteSharedKey(), $file_php);
        $file_php = mb_ereg_replace('\^LIST_ID\^', $this->tw_subscription_list->getId(), $file_php);

        $this->getResponse()->setHttpHeader('Content-Type', 'application/octet-stream');
        $this->getResponse()->setHttpHeader('Content-Disposition', 'attachment; filename=subskrypcja.php');

        $this->getResponse()->setContent($file_php);
        return sfView::NONE;
    }

    public function executeSyncEmails(sfWebRequest $request)
    {
        $this->tw_subscription_list = $this->getRoute()->getObject();
        $lib_class = $this->tw_subscription_list->getTwSubscriptionListType()->getLibrary();


        $sync_class = new $lib_class();
        if ($sync_class instanceof twSubscriptionExtListInterface) {
            $sync_class->syncList($this->tw_subscription_list->getId(), $this->getUser());
            return $this->redirect('@tw_subscription_list');
        } else {
            return $this->forward404();
        }
    }
}
