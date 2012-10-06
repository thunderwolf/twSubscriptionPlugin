<?php

/**
 * twSubscriptionList form base class.
 *
 * @method twSubscriptionList getObject() Returns the current form's model object
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 */
abstract class BasetwSubscriptionListForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                 => new sfWidgetFormInputHidden(),
      'type_id'            => new sfWidgetFormPropelChoice(array('model' => 'twSubscriptionListType', 'add_empty' => false)),
      'template_id'        => new sfWidgetFormPropelChoice(array('model' => 'twSubscriptionTemplate', 'add_empty' => true)),
      'listname'           => new sfWidgetFormInputText(),
      'listdesc'           => new sfWidgetFormTextarea(),
      'fromname'           => new sfWidgetFormInputText(),
      'mailfrom'           => new sfWidgetFormInputText(),
      'smtphost'           => new sfWidgetFormInputText(),
      'smtpport'           => new sfWidgetFormInputText(),
      'smtpencr'           => new sfWidgetFormInputText(),
      'smtpuser'           => new sfWidgetFormInputText(),
      'smtppass'           => new sfWidgetFormInputText(),
      'website_base_url'   => new sfWidgetFormInputText(),
      'website_shared_key' => new sfWidgetFormInputText(),
      'lastsync_at'        => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                 => new sfValidatorChoice(array('choices' => array($this->getObject()->getId()), 'empty_value' => $this->getObject()->getId(), 'required' => false)),
      'type_id'            => new sfValidatorPropelChoice(array('model' => 'twSubscriptionListType', 'column' => 'id')),
      'template_id'        => new sfValidatorPropelChoice(array('model' => 'twSubscriptionTemplate', 'column' => 'id', 'required' => false)),
      'listname'           => new sfValidatorString(array('max_length' => 250)),
      'listdesc'           => new sfValidatorString(array('required' => false)),
      'fromname'           => new sfValidatorString(array('max_length' => 250, 'required' => false)),
      'mailfrom'           => new sfValidatorString(array('max_length' => 250)),
      'smtphost'           => new sfValidatorString(array('max_length' => 150, 'required' => false)),
      'smtpport'           => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'smtpencr'           => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'smtpuser'           => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'smtppass'           => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'website_base_url'   => new sfValidatorString(array('max_length' => 250)),
      'website_shared_key' => new sfValidatorString(array('max_length' => 40)),
      'lastsync_at'        => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('tw_subscription_list[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'twSubscriptionList';
  }


}
