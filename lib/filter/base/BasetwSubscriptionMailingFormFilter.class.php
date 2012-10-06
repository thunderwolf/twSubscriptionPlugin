<?php

/**
 * twSubscriptionMailing filter form base class.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage filter
 * @author     ##AUTHOR_NAME##
 */
abstract class BasetwSubscriptionMailingFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'list_id'      => new sfWidgetFormPropelChoice(array('model' => 'twSubscriptionList', 'add_empty' => true)),
      'message_id'   => new sfWidgetFormPropelChoice(array('model' => 'twSubscriptionMessage', 'add_empty' => true)),
      'time_to_send' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'created_at'   => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
    ));

    $this->setValidators(array(
      'list_id'      => new sfValidatorPropelChoice(array('required' => false, 'model' => 'twSubscriptionList', 'column' => 'id')),
      'message_id'   => new sfValidatorPropelChoice(array('required' => false, 'model' => 'twSubscriptionMessage', 'column' => 'id')),
      'time_to_send' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'created_at'   => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('tw_subscription_mailing_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'twSubscriptionMailing';
  }

  public function getFields()
  {
    return array(
      'id'           => 'Number',
      'list_id'      => 'ForeignKey',
      'message_id'   => 'ForeignKey',
      'time_to_send' => 'Date',
      'created_at'   => 'Date',
    );
  }
}
