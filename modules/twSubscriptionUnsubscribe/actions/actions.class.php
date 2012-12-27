<?php

/**
 * twSubscriptionUnsubscribe actions.
 *
 * @package    subskrypcja
 * @subpackage twSubscriptionUnsubscribe
 * @author     Arkadiusz Tułodziecki
 */
class twSubscriptionUnsubscribeActions extends sfActions {
	public function executeIndex($request) {
		$list_id = $request->getParameter('id');
		$auth_key = $request->getParameter('auth_key');
		
		$this->email = twSubscriptionEmailQuery::create()->unsubscribe($auth_key, $list_id);
		
		$this->content = false;
		
		if (in_array('twBasicCmsPlugin', $this->getContext()->getConfiguration()->getPlugins())) {
			$template = twBasicCmsTemplatePeer::doSelectForCode('core.subscription.unsubscribe');
			if ($template instanceof twBasicCmsTemplate) {
				sfContext::getInstance()->getConfiguration()->loadHelpers(array(
					'Partial'
				));
				$generator = new twBasicCmsGenerator($this);
				$content = get_partial('index', array(
					'email' => $this->email
				));
				$this->content = $generator->generate($template, $content);
			}
		}
	}
}
