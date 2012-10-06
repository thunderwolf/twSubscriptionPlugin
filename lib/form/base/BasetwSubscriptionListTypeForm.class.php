<?php

/**
 * twSubscriptionListType form base class.
 *
 * @method twSubscriptionListType getObject() Returns the current form's model object
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 */
abstract class BasetwSubscriptionListTypeForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'      => new sfWidgetFormInputHidden(),
      'code'    => new sfWidgetFormInputText(),
      'library' => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'      => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'code'    => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'library' => new sfValidatorString(array('max_length' => 150, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('tw_subscription_list_type[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'twSubscriptionListType';
  }

  public function getI18nModelName()
  {
    return 'twSubscriptionListTypeI18n';
  }

  public function getI18nFormClass()
  {
    return 'twSubscriptionListTypeI18nForm';
  }

}
