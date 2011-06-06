<?php

// TODO: maile powinny być prekompilowane by 1000 razy nie przygotowywać np embedowania identycznie wyglądającej wiadomości . Może w memecache ? i klonować ?

class subscriptionSendmailingTask extends sfBaseTask {
	/** the default period to rotate logs in days */
	const DEF_PERIOD = 7;
	
	/** the default number of log historys to store, one history is created for every period */
	const DEF_HISTORY = 10;
	
	/** Special logger - allways logging **/
	protected $file_logger;
	
	protected function configure() {
		$this->addOptions(array(
				new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name'),
				new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
				new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'propel')));
		
		$this->namespace = 'subscription';
		$this->name = 'send-mailing';
		$this->briefDescription = 'Will send mailing';
		$this->detailedDescription = <<<EOF
The [subscription:send-mailing|INFO] will send mailing.
Call it with:

  [php symfony subscription:send-mailing|INFO]
EOF;
	}
	
	protected function execute($arguments = array(), $options = array()) {
		// initialize the database connection
		$databaseManager = new sfDatabaseManager($this->configuration);
		$connection = $databaseManager->getDatabase($options['connection'] ? $options['connection'] : null)->getConnection();
		
		$logdir = sfConfig::get('sf_log_dir');
		$logfile = 'mailing';
		
		// Rotate  mailing logs
		$this->rotateLogs($logdir, $logfile);
		
		// Adding file logger for mailing
		$this->file_logger = $this->addMailingLogger($logdir, $logfile);
		
		// Staring Cron Jobs
		$this->log('Starting Mailing Cron Job - try to create lock file');
		$lockfile = sfConfig::get('sf_data_dir') . '/mailing.lck';
		$lockfilehandler = fopen($lockfile, 'w+');
		if (flock($lockfilehandler, LOCK_EX | LOCK_NB)) {
			fwrite($lockfilehandler, getmypid());
			$this->log('Lock file created - start sending queue');
			
			twSubscriptionMailingLib::sendMailing($this->file_logger, $connection);
			
			$this->log('Sleep for 10 sec before close');
			sleep(10);
			
			$this->log('Unlocking');
			flock($lockfilehandler, LOCK_UN);
			
			$this->log('Finalize jobs');
			fclose($lockfilehandler);
			unlink($lockfile);
		} else {
			$this->log('Other Cron Job working');
		}
	}
	
	protected function rotateLogs($logdir, $logfile, $period = null, $history = null, $override = false) {
		$period = isset($period) ? $period : self::DEF_PERIOD;
		$history = isset($history) ? $history : self::DEF_HISTORY;
		
		// get todays date
		$today = date('Ymd');
		
		// check history folder exists
		if (!is_dir($logdir . '/history')) {
			mkdir($logdir . '/history', 0777);
		}
		
		// determine date of last rotation
		$logs = sfFinder::type('file')->maxdepth(1)->name($logfile . '_*.log')->in($logdir . '/history/');
		$recentlog = is_array($logs) ? array_pop($logs) : null;
		
		if ($recentlog) {
			// calculate date to rotate logs on
			$lastRotatedOn = filemtime($recentlog);
			$rotateOn = date('Ymd', strtotime('+ ' . $period . ' days', $lastRotatedOn));
		} else {
			// no rotation has occured yet
			$rotateOn = null;
		}
		
		$srcLog = $logdir . '/' . $logfile . '.log';
		$destLog = $logdir . '/history/' . $logfile . '_' . $today . '.log';
		
		// if rotate log on date doesn't exist, or that date is today, then rotate the log
		if (!$rotateOn || ($rotateOn == $today) || $override) {
			// if log file exists rotate it
			if (file_exists($srcLog)) {
				// check if the log file has already been rotated today
				if (file_exists($destLog)) {
					// append log to existing rotated log
					$handle = fopen($destLog, 'a');
					$append = file_get_contents($srcLog);
					fwrite($handle, $append);
				} else {
					// copy log
					copy($srcLog, $destLog);
				}
				
				// remove the log file
				unlink($srcLog);
				
				// get all log history files for this application and environment
				$newLogs = sfFinder::type('file')->maxdepth(1)->name($logfile . '_*.log')->in($logdir . '/history/');
				
				// if the number of logs in history exceeds history then remove the oldest log
				if (count($newLogs) > $history) {
					unlink($newLogs[0]);
				}
			}
		}
	}
	
	protected function addMailingLogger($logdir, $logfile) {
		$file_logger = new sfFileLogger($this->dispatcher, array(
				'file' => $logdir . '/' . $logfile . '.log'));
		$this->dispatcher->connect('command.log', array(
				$file_logger,
				'listenToLogEvent'));
		return $file_logger;
	}
	
	/**
	 * @see sfCommandApplicationTask
	 */
	public function log($messages) {
		if (is_null($this->commandApplication) || $this->commandApplication->isVerbose()) {
			parent::log($messages);
		} else {
			$prefix = '{subscriptionSendmailingTask}';
			if (is_array($messages)) {
				foreach ($messages as $message) {
					$this->file_logger->log(sprintf('%s %s', $prefix, $message));
				}
			} else {
				$this->file_logger->log(sprintf('%s %s', $prefix, $messages));
			}
		}
	}
}
