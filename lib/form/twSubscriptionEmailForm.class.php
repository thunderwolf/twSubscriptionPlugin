<?php

/**
 * twSubscriptionEmail form.
 *
 * @package    form
 * @subpackage tw_subscription_email
 */
class twSubscriptionEmailForm extends BasetwSubscriptionEmailForm
{
	public function configure()
	{
		$user = $this->getOption('user');
		if ($user instanceof sfUser) {
			$list_id = $user->getAttribute('twSubscriptionEmail.list_id', null, 'admin_module');
			if (!is_null($list_id)) {
				$this->setWidget('list_id', new sfWidgetFormInputHidden());
				$this->setDefault('list_id', $list_id);
			}
		}

		$this->validatorSchema['r_email'] = new sfValidatorAnd(array(
			new sfValidatorString(array(
				'max_length' => 250
			)), new sfValidatorEmail(),
		));

		$this->validatorSchema['auth_key'] = new sfValidatorAuthKey();

		unset($this['created_at']);
		unset($this['expires']);
	}

	public function updateObject($values = null)
	{
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
