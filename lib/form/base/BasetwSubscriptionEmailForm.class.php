<?php

/**
 * twSubscriptionEmail form base class.
 *
 * @method twSubscriptionEmail getObject() Returns the current form's model object
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 */
abstract class BasetwSubscriptionEmailForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'list_id'    => new sfWidgetFormPropelChoice(array('model' => 'twSubscriptionList', 'add_empty' => false)),
      'status_id'  => new sfWidgetFormPropelChoice(array('model' => 'twSubscriptionStatus', 'add_empty' => false)),
      'remail'     => new sfWidgetFormInputText(),
      'rname'      => new sfWidgetFormInputText(),
      'expires'    => new sfWidgetFormDateTime(),
      'auth_key'   => new sfWidgetFormInputText(),
      'created_at' => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'list_id'    => new sfValidatorPropelChoice(array('model' => 'twSubscriptionList', 'column' => 'id')),
      'status_id'  => new sfValidatorPropelChoice(array('model' => 'twSubscriptionStatus', 'column' => 'id')),
      'remail'     => new sfValidatorString(array('max_length' => 250)),
      'rname'      => new sfValidatorString(array('max_length' => 250, 'required' => false)),
      'expires'    => new sfValidatorDateTime(array('required' => false)),
      'auth_key'   => new sfValidatorString(array('max_length' => 40)),
      'created_at' => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorAnd(array(
        new sfValidatorPropelUnique(array('model' => 'twSubscriptionEmail', 'column' => array('auth_key'))),
        new sfValidatorPropelUnique(array('model' => 'twSubscriptionEmail', 'column' => array('list_id', 'remail'))),
      ))
    );

    $this->widgetSchema->setNameFormat('tw_subscription_email[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'twSubscriptionEmail';
  }


}
