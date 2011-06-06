<?php

/**
 * twSubscriptionMessage form.
 *
 * @package    form
 * @subpackage tw_subscription_message
 * @version    SVN: $Id: twSubscriptionMessageForm.class.php 507 2011-04-19 21:20:06Z ldath $
 */
class twSubscriptionMessageForm extends BasetwSubscriptionMessageForm {
	public function configure() {
		$type_id = 1;
		if (!$this->isNew()) {
			$type_id = $this->getObject()->getTypeId();
		}
		if ($type_id != 1) {
			$this->widgetSchema['message'] = new sfWidgetFormCKEditor();
			$editor = $this->widgetSchema['message']->getEditor();
			$editor->config['customConfig'] = '/twSubscriptionPlugin/js/ck_template.js';
		}
	}
}
