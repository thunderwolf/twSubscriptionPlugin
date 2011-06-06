<?php

/**
 * FerryForm form.
 *
 * @package    form
 * @subpackage form
 * @author     Arkadiusz Tułodziecki
 */
class twSubscriptionCodeForm extends sfForm {
	public function setup() {
		sfValidatorBase::setMessage('required', 'To pole jest wymagane.');
		sfValidatorBase::setMessage('invalid', 'Zawartość pola jest nieprawidłowa.');
		parent::setup();
	}
	
	public function configure() {
		$this->setWidgets(
			array(
				'list_js' => new sfWidgetFormTextarea(),
			)
		);
		
		$this->widgetSchema->setNameFormat('code[%s]');
		
		$this->setValidators(
			array(
				'list_js' => new sfValidatorPass(),
			)
		);
	}
}
