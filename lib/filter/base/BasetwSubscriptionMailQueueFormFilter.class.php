<?php

/**
 * twSubscriptionMailQueue filter form base class.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage filter
 * @author     ##AUTHOR_NAME##
 */
abstract class BasetwSubscriptionMailQueueFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'mailing_id'            => new sfWidgetFormPropelChoice(array('model' => 'twSubscriptionMailing', 'add_empty' => true)),
      'message_id'            => new sfWidgetFormPropelChoice(array('model' => 'twSubscriptionMessage', 'add_empty' => true)),
      'type_id'               => new sfWidgetFormPropelChoice(array('model' => 'twSubscriptionMessageType', 'add_empty' => true)),
      'subject'               => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'message'               => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'list_id'               => new sfWidgetFormPropelChoice(array('model' => 'twSubscriptionList', 'add_empty' => true)),
      'fromname'              => new sfWidgetFormFilterInput(),
      'mailfrom'              => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'smtphost'              => new sfWidgetFormFilterInput(),
      'smtpuser'              => new sfWidgetFormFilterInput(),
      'smtppass'              => new sfWidgetFormFilterInput(),
      'subscription_base_url' => new sfWidgetFormFilterInput(),
      'website_base_url'      => new sfWidgetFormFilterInput(),
      'remail'                => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'rname'                 => new sfWidgetFormFilterInput(),
      'unsubscribe'           => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'unsublink'             => new sfWidgetFormFilterInput(),
      'time_to_send'          => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'try_sent'              => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'created_at'            => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
    ));

    $this->setValidators(array(
      'mailing_id'            => new sfValidatorPropelChoice(array('required' => false, 'model' => 'twSubscriptionMailing', 'column' => 'id')),
      'message_id'            => new sfValidatorPropelChoice(array('required' => false, 'model' => 'twSubscriptionMessage', 'column' => 'id')),
      'type_id'               => new sfValidatorPropelChoice(array('required' => false, 'model' => 'twSubscriptionMessageType', 'column' => 'id')),
      'subject'               => new sfValidatorPass(array('required' => false)),
      'message'               => new sfValidatorPass(array('required' => false)),
      'list_id'               => new sfValidatorPropelChoice(array('required' => false, 'model' => 'twSubscriptionList', 'column' => 'id')),
      'fromname'              => new sfValidatorPass(array('required' => false)),
      'mailfrom'              => new sfValidatorPass(array('required' => false)),
      'smtphost'              => new sfValidatorPass(array('required' => false)),
      'smtpuser'              => new sfValidatorPass(array('required' => false)),
      'smtppass'              => new sfValidatorPass(array('required' => false)),
      'subscription_base_url' => new sfValidatorPass(array('required' => false)),
      'website_base_url'      => new sfValidatorPass(array('required' => false)),
      'remail'                => new sfValidatorPass(array('required' => false)),
      'rname'                 => new sfValidatorPass(array('required' => false)),
      'unsubscribe'           => new sfValidatorPass(array('required' => false)),
      'unsublink'             => new sfValidatorPass(array('required' => false)),
      'time_to_send'          => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'try_sent'              => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'created_at'            => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('tw_subscription_mail_queue_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'twSubscriptionMailQueue';
  }

  public function getFields()
  {
    return array(
      'id'                    => 'Number',
      'mailing_id'            => 'ForeignKey',
      'message_id'            => 'ForeignKey',
      'type_id'               => 'ForeignKey',
      'subject'               => 'Text',
      'message'               => 'Text',
      'list_id'               => 'ForeignKey',
      'fromname'              => 'Text',
      'mailfrom'              => 'Text',
      'smtphost'              => 'Text',
      'smtpuser'              => 'Text',
      'smtppass'              => 'Text',
      'subscription_base_url' => 'Text',
      'website_base_url'      => 'Text',
      'remail'                => 'Text',
      'rname'                 => 'Text',
      'unsubscribe'           => 'Text',
      'unsublink'             => 'Text',
      'time_to_send'          => 'Date',
      'try_sent'              => 'Number',
      'created_at'            => 'Date',
    );
  }
}
