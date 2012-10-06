<?php

class twSubscriptionCreateMailingForm extends sfForm {
	public function configure() {
		$type_id = $this->getOption('type_id');
		
		$this->setWidget('subject', new sfWidgetFormInput());
		if ($type_id != 1) {
			$this->setWidget('message', new sfWidgetFormCKEditor());
			$editor = $this->widgetSchema['message']->getEditor();
			$editor->config['customConfig'] = '/twSubscriptionPlugin/js/ck_template.js';
		}
		
		$this->setWidget('time_to_send', new sfWidgetFormBootstrapDate(array(), array('class' => 'input-small')));
		
		$this->widgetSchema->setNameFormat('mailing[%s]');
		
		$this->setValidator('subject', new sfValidatorString());
		$this->setValidator('message', new sfValidatorString());
		$this->setValidator('time_to_send', new sfValidatorDateTime());
	}
}
