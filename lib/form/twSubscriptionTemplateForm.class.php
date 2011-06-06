<?php

/**
 * twSubscriptionTemplate form.
 *
 * @package    form
 * @subpackage tw_subscription_template
 * @version    SVN: $Id: twSubscriptionTemplateForm.class.php 506 2011-04-19 21:11:07Z ldath $
 */
class twSubscriptionTemplateForm extends BasetwSubscriptionTemplateForm {
	public function configure() {
		$type_id = 1;
		if (!$this->isNew()) {
			$type_id = $this->getObject()->getTypeId();
		}
		if ($type_id != 1) {
			$this->widgetSchema['tdata'] = new sfWidgetFormCKEditor();
			$editor = $this->widgetSchema['tdata']->getEditor();
			$editor->config['customConfig'] = '/twSubscriptionPlugin/js/ck_template.js';
		}
	}
}
