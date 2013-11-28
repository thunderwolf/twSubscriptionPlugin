<?php

/**
 * FerryForm form.
 *
 * @package    form
 * @subpackage form
 * @author     Arkadiusz Tułodziecki
 */
class twSubscriptionCodeForm extends sfForm
{
	public function configure()
	{
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
