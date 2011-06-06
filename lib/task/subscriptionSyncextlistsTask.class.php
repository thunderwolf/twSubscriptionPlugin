<?php

class subscriptionSyncextlistsTask extends sfBaseTask {
	protected function configure() {
		$this->addOptions(array(
				new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name'),
				new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
				new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'propel'))
		);
		
		$this->namespace = 'subscription';
		$this->name = 'sync-ext-lists';
		$this->briefDescription = 'Synchronize external lists';
		$this->detailedDescription = <<<EOF
The [subscription:sync-ext-lists|INFO] Synchronize external lists.
Call it with:

  [php symfony subscription:sync-ext-lists|INFO]
EOF;
	}
	
	protected function execute($arguments = array(), $options = array()) {
		// initialize the database connection
		$databaseManager = new sfDatabaseManager($this->configuration);
		$connection = $databaseManager->getDatabase($options['connection'] ? $options['connection'] : null)->getConnection();
		
		$c = new Criteria();
		$lists = twSubscriptionListPeer::doSelect($c, $connection);
		if (is_array($lists)) {
			foreach ($lists as $list) {
				$this->tryToSyncList($list, $connection);
			}
		}
	}
	
	protected function tryToSyncList($list, $connection) {
		$libclass = $list->getTwSubscriptionListType()->getLibrary();
		if (empty($libclass)) {
			return null;
		}
		
		$syncclass = new $libclass();
		if ($syncclass instanceof twSubscriptionExtListInterface) {
			$this->log(sprintf('Start synchronizing list `%s`', $list->getListname()));
			$syncclass->syncList($list->getId(), null, $connection);
			$this->log(sprintf('Synchronization of list `%s` finished', $list->getListname()));
		} else {
			$this->log(sprintf('Class `%s` is not Instance of twSubscriptionExtListInterface', get_class($syncclass)));
		}
		return true;
	}
}
