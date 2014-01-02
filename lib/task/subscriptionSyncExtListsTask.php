<?php

class subscriptionSyncExtListsTask extends sfBaseTaskLoggerTask
{
    const ERROR_CODE_FAILURE = -1;
    const ERROR_CODE_SUCCESS = 1;

    protected function configure()
    {
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

    protected function doProcess($arguments = array(), $options = array())
    {
        $databaseManager = new sfDatabaseManager($this->configuration);
        $connection = $databaseManager->getDatabase('propel')->getConnection();

        try {
            $lists = twSubscriptionListQuery::create()->find($connection);
            if ($lists instanceof PropelObjectCollection) {
                $processed = $not_processed = 0;
                foreach ($lists as $list) {
                    $this->tryToSyncList($list, $connection, $processed, $not_processed);
                }
                $this->task->setCountProcessed($processed);
                $this->task->setCountNotProcessed($not_processed);
            }
            $this->task->setErrorCode(self::ERROR_CODE_SUCCESS);
            $this->setOk();
        } catch (Exception $e) {
            $this->task->setErrorCode(self::ERROR_CODE_FAILURE);
            $this->setNOk($e);
        }
    }

    protected function tryToSyncList(twSubscriptionList $list, $connection, &$processed, &$not_processed)
    {
        $lib_class = $list->getTwSubscriptionListType()->getLibrary();
        if (empty($lib_class)) {
            return null;
        }

        $sync_class = new $lib_class();
        if ($sync_class instanceof twSubscriptionExtListInterface) {
            $this->printAndLog(sprintf(' - Start synchronizing list `%s`', $list->getListName()));
            $sync_class->syncList($list->getId(), null, $connection);
            $this->printAndLog(sprintf(' - Synchronization of list `%s` finished', $list->getListName()));
            $processed++;
        } else {
            $this->printAndLog(sprintf(' - Class `%s` is not Instance of twSubscriptionExtListInterface', get_class($sync_class)));
            $not_processed++;
        }
        return true;
    }
}
