<?php

/**
 * Subclass for representing a row from the 'tw_subscription_list' table.
 *
 *
 *
 * @package plugins.twSubscriptionPlugin.lib.model
 */
class twSubscriptionList extends BasetwSubscriptionList {
	public $website_code_js;
	public $website_code_php;
	
	public function __toString() {
		return $this->getListname();
	}
	
	public function getListType() {
		$c = new Criteria();
		$c->add(twSubscriptionListTypePeer::ID, $this->getTypeId());
		$type = twSubscriptionListTypePeer::doSelectWithI18n($c);
		if (!empty($type[0])) {
			return $type[0]->getName();
		} else {
			return null;
		}
	}
	
	public function getMessageTypeId() {
		$template = twSubscriptionTemplatePeer::retrieveByPK($this->getTemplateId());
		return $template->getTypeId();
	}
	
	public function getEmails() {
		return $this->counttwSubscriptionEmails();
	}
	
	public function getCreateMailing() {
		return 0;
	}
}
