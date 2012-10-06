<?php

/**
 * twSubscriptionListInvitation filter form base class.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage filter
 * @author     ##AUTHOR_NAME##
 */
abstract class BasetwSubscriptionListInvitationFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'list_id' => new sfWidgetFormPropelChoice(array('model' => 'twSubscriptionList', 'add_empty' => true)),
      'type_id' => new sfWidgetFormPropelChoice(array('model' => 'twSubscriptionMessageType', 'add_empty' => true)),
      'subject' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'message' => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'list_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'twSubscriptionList', 'column' => 'id')),
      'type_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'twSubscriptionMessageType', 'column' => 'id')),
      'subject' => new sfValidatorPass(array('required' => false)),
      'message' => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('tw_subscription_list_invitation_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'twSubscriptionListInvitation';
  }

  public function getFields()
  {
    return array(
      'id'      => 'Number',
      'list_id' => 'ForeignKey',
      'type_id' => 'ForeignKey',
      'subject' => 'Text',
      'message' => 'Text',
    );
  }
}
