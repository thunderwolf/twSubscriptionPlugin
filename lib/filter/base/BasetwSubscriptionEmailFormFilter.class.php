<?php

/**
 * twSubscriptionEmail filter form base class.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage filter
 * @author     ##AUTHOR_NAME##
 */
abstract class BasetwSubscriptionEmailFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'list_id'    => new sfWidgetFormPropelChoice(array('model' => 'twSubscriptionList', 'add_empty' => true)),
      'status_id'  => new sfWidgetFormPropelChoice(array('model' => 'twSubscriptionStatus', 'add_empty' => true)),
      'remail'     => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'rname'      => new sfWidgetFormFilterInput(),
      'expires'    => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'auth_key'   => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'created_at' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
    ));

    $this->setValidators(array(
      'list_id'    => new sfValidatorPropelChoice(array('required' => false, 'model' => 'twSubscriptionList', 'column' => 'id')),
      'status_id'  => new sfValidatorPropelChoice(array('required' => false, 'model' => 'twSubscriptionStatus', 'column' => 'id')),
      'remail'     => new sfValidatorPass(array('required' => false)),
      'rname'      => new sfValidatorPass(array('required' => false)),
      'expires'    => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'auth_key'   => new sfValidatorPass(array('required' => false)),
      'created_at' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('tw_subscription_email_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'twSubscriptionEmail';
  }

  public function getFields()
  {
    return array(
      'id'         => 'Number',
      'list_id'    => 'ForeignKey',
      'status_id'  => 'ForeignKey',
      'remail'     => 'Text',
      'rname'      => 'Text',
      'expires'    => 'Date',
      'auth_key'   => 'Text',
      'created_at' => 'Date',
    );
  }
}
