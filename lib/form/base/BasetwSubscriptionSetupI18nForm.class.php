<?php

/**
 * twSubscriptionSetupI18n form base class.
 *
 * @method twSubscriptionSetupI18n getObject() Returns the current form's model object
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 */
abstract class BasetwSubscriptionSetupI18nForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'      => new sfWidgetFormInputHidden(),
      'name'    => new sfWidgetFormInputText(),
      'culture' => new sfWidgetFormInputHidden(),
      'value'   => new sfWidgetFormTextarea(),
    ));

    $this->setValidators(array(
      'id'      => new sfValidatorPropelChoice(array('model' => 'twSubscriptionSetup', 'column' => 'id', 'required' => false)),
      'name'    => new sfValidatorString(array('max_length' => 250)),
      'culture' => new sfValidatorChoice(array('choices' => array($this->getObject()->getCulture()), 'empty_value' => $this->getObject()->getCulture(), 'required' => false)),
      'value'   => new sfValidatorString(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('tw_subscription_setup_i18n[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'twSubscriptionSetupI18n';
  }


}
