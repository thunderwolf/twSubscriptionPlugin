<?php

/**
 * twSubscriptionSubscribe actions.
 *
 * @package    twSubscriptionPlugin
 * @subpackage twSubscriptionSubscribe
 * @author     Arkadiusz Tułodziecki
 */
class twSubscriptionSubscribeActions extends sfActions
{
	public function executeIndex(sfWebRequest $request) {
		$this->form = new twSubscriptionSubscribeForm();
		if ($request->isMethod('post')) {
			$this->form->bind($request->getParameter($this->form->getName()), $request->getFiles($this->form->getName()));
			if ($request->isMethod('post')) {
				$this->form->save();
			}
		}
	}
}
