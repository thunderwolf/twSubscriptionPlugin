<?php

/**
 * twSubscriptionEmail module configuration.
 *
 * @package    pzmtravel
 * @subpackage twSubscriptionEmail
 * @author     Your name here
 * @version    SVN: $Id: twSubscriptionEmailGeneratorConfiguration.class.php 504 2011-03-16 23:26:14Z ldath $
 */
class twSubscriptionEmailGeneratorConfiguration extends BaseTwSubscriptionEmailGeneratorConfiguration {
	protected $user = null;
	
	public function setUser($user) {
		$this->user = $user;
	}
	
	public function getUser() {
		return $this->user;
	}
	
	public function getFormOptions() {
		return array('user' => $this->getUser());
	}
}
