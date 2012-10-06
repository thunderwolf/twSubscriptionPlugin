<?php

/**
 * twSubscriptionMailing form base class.
 *
 * @method twSubscriptionMailing getObject() Returns the current form's model object
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 */
abstract class BasetwSubscriptionMailingForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'           => new sfWidgetFormInputHidden(),
      'list_id'      => new sfWidgetFormPropelChoice(array('model' => 'twSubscriptionList', 'add_empty' => false)),
      'message_id'   => new sfWidgetFormPropelChoice(array('model' => 'twSubscriptionMessage', 'add_empty' => false)),
      'time_to_send' => new sfWidgetFormDateTime(),
      'created_at'   => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'           => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'list_id'      => new sfValidatorPropelChoice(array('model' => 'twSubscriptionList', 'column' => 'id')),
      'message_id'   => new sfValidatorPropelChoice(array('model' => 'twSubscriptionMessage', 'column' => 'id')),
      'time_to_send' => new sfValidatorDateTime(),
      'created_at'   => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('tw_subscription_mailing[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'twSubscriptionMailing';
  }


}
