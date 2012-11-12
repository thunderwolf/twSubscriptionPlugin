<?php

// TODO: maile powinny być prekompilowane by 1000 razy nie przygotowywać np embedowania identycznie wyglądającej wiadomości . Może w memecache ? i klonować ?

class subscriptionSendmailingTask extends sfBaseTaskLoggerTask {
	
	const ERROR_CODE_FAILURE = -1;
	const ERROR_CODE_SUCCESS = 1;

	public function logMe($message) {
		$this->printAndLog($message);
	}
	
	protected function configure() {
		parent::configure();
		
		// Zawsze musimy sprawdzić czy
		
		$this->namespace = 'subscription';
		$this->name = 'send-mailing';
		$this->briefDescription = 'Will send mailing';
		$this->detailedDescription = <<<EOF
The [subscription:send-mailing|INFO] will send mailing.
Call it with:
		
  [php symfony subscription:send-mailing|INFO]
EOF;
	}
	
	/**
	 * Advanced check of task parameters.
	 */
	protected function checkParameters($arguments = array(), $options = array()) {
		// check parent parameters
		parent::checkParameters($arguments, $options);
		
		if (!isset($this->opts['check-running']) || $this->opts['check-running'] != true) {
			throw new InvalidArgumentException('Run the task with the "check-running=1" option.');
		}
	}
	
	protected function doProcess($arguments = array(), $options = array()) {
		$databaseManager = new sfDatabaseManager($this->configuration);
		$connection = $databaseManager->getDatabase('propel')->getConnection();
		
		try {
			$processed = $notprocessed = 0;
			twSubscriptionMailingLib::sendMailing($this, $connection, $processed, $notprocessed);
			$this->task->setCountProcessed($processed);
			$this->task->setCountNotProcessed($notprocessed);
			$this->task->setErrorCode(self::ERROR_CODE_SUCCESS);
			$this->setOk();
		} catch (Exception $e) {
			$this->task->setErrorCode(self::ERROR_CODE_FAILURE);
			$this->setNOk($e);
		}
	}
}
