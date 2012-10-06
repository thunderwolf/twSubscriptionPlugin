<?php

/**
 * twSubscriptionMailSent form base class.
 *
 * @method twSubscriptionMailSent getObject() Returns the current form's model object
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 */
abstract class BasetwSubscriptionMailSentForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'           => new sfWidgetFormInputHidden(),
      'mailing_id'   => new sfWidgetFormPropelChoice(array('model' => 'twSubscriptionMailing', 'add_empty' => false)),
      'time_to_send' => new sfWidgetFormDateTime(),
      'sender'       => new sfWidgetFormInputText(),
      'remail'       => new sfWidgetFormInputText(),
      'body'         => new sfWidgetFormTextarea(),
      'created_at'   => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'           => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'mailing_id'   => new sfValidatorPropelChoice(array('model' => 'twSubscriptionMailing', 'column' => 'id')),
      'time_to_send' => new sfValidatorDateTime(),
      'sender'       => new sfValidatorString(array('max_length' => 50)),
      'remail'       => new sfValidatorString(array('max_length' => 50)),
      'body'         => new sfValidatorString(),
      'created_at'   => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('tw_subscription_mail_sent[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'twSubscriptionMailSent';
  }


}
