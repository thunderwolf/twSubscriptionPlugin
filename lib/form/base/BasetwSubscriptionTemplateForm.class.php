<?php

/**
 * twSubscriptionTemplate form base class.
 *
 * @method twSubscriptionTemplate getObject() Returns the current form's model object
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 */
abstract class BasetwSubscriptionTemplateForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'      => new sfWidgetFormInputHidden(),
      'type_id' => new sfWidgetFormPropelChoice(array('model' => 'twSubscriptionMessageType', 'add_empty' => false)),
      'tname'   => new sfWidgetFormInputText(),
      'tdata'   => new sfWidgetFormTextarea(),
    ));

    $this->setValidators(array(
      'id'      => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'type_id' => new sfValidatorPropelChoice(array('model' => 'twSubscriptionMessageType', 'column' => 'id')),
      'tname'   => new sfValidatorString(array('max_length' => 50)),
      'tdata'   => new sfValidatorString(),
    ));

    $this->widgetSchema->setNameFormat('tw_subscription_template[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'twSubscriptionTemplate';
  }


}
