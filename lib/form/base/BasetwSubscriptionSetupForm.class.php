<?php

/**
 * twSubscriptionSetup form base class.
 *
 * @method twSubscriptionSetup getObject() Returns the current form's model object
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 */
abstract class BasetwSubscriptionSetupForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'      => new sfWidgetFormInputHidden(),
      'code'    => new sfWidgetFormInputText(),
      'is_html' => new sfWidgetFormInputCheckbox(),
    ));

    $this->setValidators(array(
      'id'      => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'code'    => new sfValidatorString(array('max_length' => 250)),
      'is_html' => new sfValidatorBoolean(),
    ));

    $this->widgetSchema->setNameFormat('tw_subscription_setup[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'twSubscriptionSetup';
  }

  public function getI18nModelName()
  {
    return 'twSubscriptionSetupI18n';
  }

  public function getI18nFormClass()
  {
    return 'twSubscriptionSetupI18nForm';
  }

}
