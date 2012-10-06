<?php

/**
 * twSubscriptionListInvitation form base class.
 *
 * @method twSubscriptionListInvitation getObject() Returns the current form's model object
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 */
abstract class BasetwSubscriptionListInvitationForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'      => new sfWidgetFormInputHidden(),
      'list_id' => new sfWidgetFormPropelChoice(array('model' => 'twSubscriptionList', 'add_empty' => false)),
      'type_id' => new sfWidgetFormPropelChoice(array('model' => 'twSubscriptionMessageType', 'add_empty' => false)),
      'subject' => new sfWidgetFormTextarea(),
      'message' => new sfWidgetFormTextarea(),
    ));

    $this->setValidators(array(
      'id'      => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'list_id' => new sfValidatorPropelChoice(array('model' => 'twSubscriptionList', 'column' => 'id')),
      'type_id' => new sfValidatorPropelChoice(array('model' => 'twSubscriptionMessageType', 'column' => 'id')),
      'subject' => new sfValidatorString(),
      'message' => new sfValidatorString(),
    ));

    $this->widgetSchema->setNameFormat('tw_subscription_list_invitation[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'twSubscriptionListInvitation';
  }


}
