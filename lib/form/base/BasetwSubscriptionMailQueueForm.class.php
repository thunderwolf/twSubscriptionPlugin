<?php

/**
 * twSubscriptionMailQueue form base class.
 *
 * @method twSubscriptionMailQueue getObject() Returns the current form's model object
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 */
abstract class BasetwSubscriptionMailQueueForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                    => new sfWidgetFormInputHidden(),
      'mailing_id'            => new sfWidgetFormPropelChoice(array('model' => 'twSubscriptionMailing', 'add_empty' => false)),
      'message_id'            => new sfWidgetFormPropelChoice(array('model' => 'twSubscriptionMessage', 'add_empty' => false)),
      'type_id'               => new sfWidgetFormPropelChoice(array('model' => 'twSubscriptionMessageType', 'add_empty' => false)),
      'subject'               => new sfWidgetFormTextarea(),
      'message'               => new sfWidgetFormTextarea(),
      'list_id'               => new sfWidgetFormPropelChoice(array('model' => 'twSubscriptionList', 'add_empty' => false)),
      'fromname'              => new sfWidgetFormInputText(),
      'mailfrom'              => new sfWidgetFormInputText(),
      'smtphost'              => new sfWidgetFormInputText(),
      'smtpuser'              => new sfWidgetFormInputText(),
      'smtppass'              => new sfWidgetFormInputText(),
      'subscription_base_url' => new sfWidgetFormInputText(),
      'website_base_url'      => new sfWidgetFormInputText(),
      'remail'                => new sfWidgetFormInputText(),
      'rname'                 => new sfWidgetFormInputText(),
      'unsubscribe'           => new sfWidgetFormInputText(),
      'unsublink'             => new sfWidgetFormInputText(),
      'time_to_send'          => new sfWidgetFormDateTime(),
      'try_sent'              => new sfWidgetFormInputText(),
      'created_at'            => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                    => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'mailing_id'            => new sfValidatorPropelChoice(array('model' => 'twSubscriptionMailing', 'column' => 'id')),
      'message_id'            => new sfValidatorPropelChoice(array('model' => 'twSubscriptionMessage', 'column' => 'id')),
      'type_id'               => new sfValidatorPropelChoice(array('model' => 'twSubscriptionMessageType', 'column' => 'id')),
      'subject'               => new sfValidatorString(),
      'message'               => new sfValidatorString(),
      'list_id'               => new sfValidatorPropelChoice(array('model' => 'twSubscriptionList', 'column' => 'id')),
      'fromname'              => new sfValidatorString(array('max_length' => 250, 'required' => false)),
      'mailfrom'              => new sfValidatorString(array('max_length' => 250)),
      'smtphost'              => new sfValidatorString(array('max_length' => 150, 'required' => false)),
      'smtpuser'              => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'smtppass'              => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'subscription_base_url' => new sfValidatorString(array('max_length' => 250, 'required' => false)),
      'website_base_url'      => new sfValidatorString(array('max_length' => 250, 'required' => false)),
      'remail'                => new sfValidatorString(array('max_length' => 250)),
      'rname'                 => new sfValidatorString(array('max_length' => 250, 'required' => false)),
      'unsubscribe'           => new sfValidatorString(array('max_length' => 40)),
      'unsublink'             => new sfValidatorString(array('max_length' => 250, 'required' => false)),
      'time_to_send'          => new sfValidatorDateTime(),
      'try_sent'              => new sfValidatorInteger(array('min' => -128, 'max' => 127)),
      'created_at'            => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('tw_subscription_mail_queue[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'twSubscriptionMailQueue';
  }


}
