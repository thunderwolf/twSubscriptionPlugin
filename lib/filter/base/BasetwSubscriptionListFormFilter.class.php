<?php

/**
 * twSubscriptionList filter form base class.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage filter
 * @author     ##AUTHOR_NAME##
 */
abstract class BasetwSubscriptionListFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'type_id'            => new sfWidgetFormPropelChoice(array('model' => 'twSubscriptionListType', 'add_empty' => true)),
      'template_id'        => new sfWidgetFormPropelChoice(array('model' => 'twSubscriptionTemplate', 'add_empty' => true)),
      'listname'           => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'listdesc'           => new sfWidgetFormFilterInput(),
      'fromname'           => new sfWidgetFormFilterInput(),
      'mailfrom'           => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'smtphost'           => new sfWidgetFormFilterInput(),
      'smtpport'           => new sfWidgetFormFilterInput(),
      'smtpencr'           => new sfWidgetFormFilterInput(),
      'smtpuser'           => new sfWidgetFormFilterInput(),
      'smtppass'           => new sfWidgetFormFilterInput(),
      'website_base_url'   => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'website_shared_key' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'lastsync_at'        => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
    ));

    $this->setValidators(array(
      'type_id'            => new sfValidatorPropelChoice(array('required' => false, 'model' => 'twSubscriptionListType', 'column' => 'id')),
      'template_id'        => new sfValidatorPropelChoice(array('required' => false, 'model' => 'twSubscriptionTemplate', 'column' => 'id')),
      'listname'           => new sfValidatorPass(array('required' => false)),
      'listdesc'           => new sfValidatorPass(array('required' => false)),
      'fromname'           => new sfValidatorPass(array('required' => false)),
      'mailfrom'           => new sfValidatorPass(array('required' => false)),
      'smtphost'           => new sfValidatorPass(array('required' => false)),
      'smtpport'           => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'smtpencr'           => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'smtpuser'           => new sfValidatorPass(array('required' => false)),
      'smtppass'           => new sfValidatorPass(array('required' => false)),
      'website_base_url'   => new sfValidatorPass(array('required' => false)),
      'website_shared_key' => new sfValidatorPass(array('required' => false)),
      'lastsync_at'        => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('tw_subscription_list_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'twSubscriptionList';
  }

  public function getFields()
  {
    return array(
      'id'                 => 'Number',
      'type_id'            => 'ForeignKey',
      'template_id'        => 'ForeignKey',
      'listname'           => 'Text',
      'listdesc'           => 'Text',
      'fromname'           => 'Text',
      'mailfrom'           => 'Text',
      'smtphost'           => 'Text',
      'smtpport'           => 'Number',
      'smtpencr'           => 'Number',
      'smtpuser'           => 'Text',
      'smtppass'           => 'Text',
      'website_base_url'   => 'Text',
      'website_shared_key' => 'Text',
      'lastsync_at'        => 'Date',
    );
  }
}
