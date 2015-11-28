<?php

/**
 * twSubscriptionUnsubscribe actions.
 *
 * @package    subskrypcja
 * @subpackage twSubscriptionUnsubscribe
 * @author     Arkadiusz Tułodziecki
 */
class twSubscriptionUnsubscribeActions extends sfActions
{
    public function executeIndex(sfWebRequest $request)
    {
        $list_id = $request->getParameter('id');
        $auth_key = $request->getParameter('auth_key');

        $this->email = twSubscriptionEmailQuery::create()->unsubscribe($auth_key, $list_id);
    }
}
