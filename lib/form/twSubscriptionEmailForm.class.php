<?php

/**
 * twSubscriptionEmail form.
 *
 * @package    form
 * @subpackage tw_subscription_email
 * @version    SVN: $Id: twSubscriptionEmailForm.class.php 505 2011-04-18 23:21:45Z ldath $
 */
class twSubscriptionEmailForm extends BasetwSubscriptionEmailForm {
	public function configure() {
		$user = $this->getOption('user');
		$list_id = $user->getAttribute('twSubscriptionEmail.list_id', null, 'admin_module');
		if (!is_null($list_id)) {
			$this->setWidget('list_id', new sfWidgetFormInputHidden());
			$this->setDefault('list_id', $list_id);
		}
		
		$this->validatorSchema['remail'] = new sfValidatorAnd(array(
			new sfValidatorString(array('max_length' => 250)),
			new sfValidatorEmail(),
		));
		
		$this->validatorSchema['auth_key'] = new sfValidatorAuthKey();
		
		unset($this['created_at']);
		unset($this['expires']);
	}
	
	public function updateObject($values = null) {
		$values = $this->getValues();
		$user = $this->getOption('user');
		$list_id = $user->getAttribute('twSubscriptionEmail.list_id', null, 'admin_module');
		if (!is_null($list_id)) {
			$values['list_id'] = $list_id;
		}
		parent::updateObject($values);
		
		return $this->object;
	}
}
