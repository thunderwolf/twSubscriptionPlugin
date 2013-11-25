<?php

/**
 * twSubscriptionSubscribeOld form.
 *
 * @package    form
 * @subpackage tw_subscription_email
 */
class twSubscriptionSubscribeForm extends BasetwSubscriptionEmailForm {
	public function configure() {
		$this->validatorSchema['remail'] = new sfValidatorAnd(array(
			new sfValidatorString(array(
				'max_length' => 250
			)), new sfValidatorEmail(),
		));
		
		$this->validatorSchema['auth_key'] = new sfValidatorAuthKey();
		
		unset($this['created_at']);
		unset($this['expires']);
	}
	
	public function updateObject($values = null) {
		$values = $this->getValues();
		$list_id = $this->getOption('list_id');
		if (!is_null($list_id)) {
			$values['list_id'] = $list_id;
		}
		parent::updateObject($values);
		
		return $this->object;
	}
}
