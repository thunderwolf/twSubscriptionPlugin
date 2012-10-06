<?php

class subscriptionSyncextlistsTask extends sfBaseTaskLoggerTask {
	const ERROR_CODE_FAILURE = -1;
	const ERROR_CODE_SUCCESS = 1;
	
	protected function configure() {
		parent::configure();
		
		$this->namespace = 'subscription';
		$this->name = 'sync-ext-lists';
		$this->briefDescription = 'Synchronize external lists';
		$this->detailedDescription = <<<EOF
The [subscription:sync-ext-lists|INFO] Synchronize external lists.
Call it with:
		
  [php symfony subscription:sync-ext-lists|INFO]
EOF;
	}
	
	protected function doProcess($arguments = array(), $options = array()) {
		$databaseManager = new sfDatabaseManager($this->configuration);
		$connection = $databaseManager->getDatabase('propel')->getConnection();
		
		try {
			$lists = twSubscriptionListQuery::create()->find($connection);
			if ($lists instanceof PropelObjectCollection) {
				$processed = $notprocessed = 0;
				foreach ($lists as $list) {
					$this->tryToSyncList($list, $connection, $processed, $notprocessed);
				}
				$this->task->setCountProcessed($processed);
				$this->task->setCountNotProcessed($notprocessed);
			}
			$this->task->setErrorCode(self::ERROR_CODE_SUCCESS);
			$this->setOk();
		} catch (Exception $e) {
			$this->task->setErrorCode(self::ERROR_CODE_FAILURE);
			$this->setNOk($e);
		}
	}
	
	protected function tryToSyncList($list, $connection, &$processed, &$notprocessed) {
		$libclass = $list->getTwSubscriptionListType()->getLibrary();
		if (empty($libclass)) {
			return null;
		}
		
		$syncclass = new $libclass();
		if ($syncclass instanceof twSubscriptionExtListInterface) {
			$this->printAndLog(sprintf(' - Start synchronizing list `%s`', $list->getListname()));
			$syncclass->syncList($list->getId(), null, $connection);
			$this->printAndLog(sprintf(' - Synchronization of list `%s` finished', $list->getListname()));
			$processed++;
		} else {
			$this->printAndLog(sprintf(' - Class `%s` is not Instance of twSubscriptionExtListInterface', get_class($syncclass)));
			$notprocessed++;
		}
		return true;
	}
}
