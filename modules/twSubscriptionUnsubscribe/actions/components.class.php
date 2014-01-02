<?php

/**
 * twSubscriptionUnsubscribe components.
 *
 * @package    subskrypcja
 * @subpackage twSubscriptionUnsubscribe
 * @author     Arkadiusz Tułodziecki
 */
class twSubscriptionUnsubscribeComponents extends sfComponents
{
    public function executeIndex($request)
    {
        $list_id = $request->getParameter('id');
        $auth_key = $request->getParameter('auth_key');

        $this->email = twSubscriptionEmailQuery::create()->unsubscribe($auth_key, $list_id);
    }
}
