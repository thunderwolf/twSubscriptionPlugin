<?php

/**
 * twSubscriptionMailSent filter form base class.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage filter
 * @author     ##AUTHOR_NAME##
 */
abstract class BasetwSubscriptionMailSentFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'mailing_id'   => new sfWidgetFormPropelChoice(array('model' => 'twSubscriptionMailing', 'add_empty' => true)),
      'time_to_send' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'sender'       => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'remail'       => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'body'         => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'created_at'   => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
    ));

    $this->setValidators(array(
      'mailing_id'   => new sfValidatorPropelChoice(array('required' => false, 'model' => 'twSubscriptionMailing', 'column' => 'id')),
      'time_to_send' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'sender'       => new sfValidatorPass(array('required' => false)),
      'remail'       => new sfValidatorPass(array('required' => false)),
      'body'         => new sfValidatorPass(array('required' => false)),
      'created_at'   => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('tw_subscription_mail_sent_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'twSubscriptionMailSent';
  }

  public function getFields()
  {
    return array(
      'id'           => 'Number',
      'mailing_id'   => 'ForeignKey',
      'time_to_send' => 'Date',
      'sender'       => 'Text',
      'remail'       => 'Text',
      'body'         => 'Text',
      'created_at'   => 'Date',
    );
  }
}
