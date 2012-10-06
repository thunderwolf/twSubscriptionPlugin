<?php

/**
 * twSubscriptionTemplate filter form base class.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage filter
 * @author     ##AUTHOR_NAME##
 */
abstract class BasetwSubscriptionTemplateFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'type_id' => new sfWidgetFormPropelChoice(array('model' => 'twSubscriptionMessageType', 'add_empty' => true)),
      'tname'   => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'tdata'   => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'type_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'twSubscriptionMessageType', 'column' => 'id')),
      'tname'   => new sfValidatorPass(array('required' => false)),
      'tdata'   => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('tw_subscription_template_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'twSubscriptionTemplate';
  }

  public function getFields()
  {
    return array(
      'id'      => 'Number',
      'type_id' => 'ForeignKey',
      'tname'   => 'Text',
      'tdata'   => 'Text',
    );
  }
}
