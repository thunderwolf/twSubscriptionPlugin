<?php

/**
 * twSubscriptionStatus form base class.
 *
 * @method twSubscriptionStatus getObject() Returns the current form's model object
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 */
abstract class BasetwSubscriptionStatusForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'   => new sfWidgetFormInputHidden(),
      'code' => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'   => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'code' => new sfValidatorString(array('max_length' => 250)),
    ));

    $this->widgetSchema->setNameFormat('tw_subscription_status[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'twSubscriptionStatus';
  }

  public function getI18nModelName()
  {
    return 'twSubscriptionStatusI18n';
  }

  public function getI18nFormClass()
  {
    return 'twSubscriptionStatusI18nForm';
  }

}
