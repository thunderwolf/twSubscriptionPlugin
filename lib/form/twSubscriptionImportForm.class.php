<?php
class twSubscriptionImportForm extends sfForm
{
	public function configure()
	{
		$this->setWidgets(array(
			'list_id' => new sfWidgetFormPropelChoice(array('model' => 'twSubscriptionList', 'add_empty' => false)),
			'file' => new sfWidgetFormInputFile(),
		));
		$this->widgetSchema->setLabels(array(
			'list_id' => 'Wybierz listę do importu',
			'file' => 'Plik z danymi adresami poczty elektronicznej',
		));

		$this->widgetSchema->setFormFormatterName('list');
		$this->widgetSchema->setNameFormat('import[%s]');

		$this->setValidators(array(
			'file' => new sfValidatorFile(),
			'list_id' => new sfValidatorPropelChoice(array('model' => 'twSubscriptionList', 'column' => 'id')),
		));

	}
}