<?php

class subscriptionInstallTask extends sfBaseTask {
	const VERSION = 4;
	
	protected function configure() {
		$this->addArguments(array(
				new sfCommandArgument('application', sfCommandArgument::REQUIRED, 'The application name'),
			));
		
		$this
			->addOptions(
				array(
					new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
					new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'propel'),
					new sfCommandOption('no-confirmation', null, sfCommandOption::PARAMETER_NONE, 'Do not ask for confirmation'),
				));
		
		$this->namespace = 'subscription';
		$this->name = 'install';
		$this->briefDescription = '';
		$this->detailedDescription = <<<EOF
The [twnews:install|INFO] task does things.
Call it with:
		
  [php symfony twnews:install|INFO]
EOF;
	}
	
	protected function execute($arguments = array(), $options = array()) {
		// initialize the database connection
		$databaseManager = new sfDatabaseManager($this->configuration);
		$connection = $databaseManager->getDatabase($options['connection'])->getConnection();
		
		$is_core_plugin = false;
		if (in_array('twCorePlugin', $this->configuration->getPlugins())) {
			$is_core_plugin = true;
		}
		
		if ($is_core_plugin) {
			$tw_version = twVersionQuery::create()->findOneByName('db.subscription');
		}
		
		if (!$options['no-confirmation']
			&& !$this
				->askConfirmation(
					array(
						'WARNING: If you planing to use twCorePlugin version control for twNewsPlugin stop this task and install twCorePlugin first',
						'Are you sure you want to proceed with install? (y/N)',
					), 'QUESTION_LARGE', false)) {
			$this->logSection('twnews', 'Task aborted.');
			
			return 1;
		}
		
		if ($is_core_plugin) {
			if (is_null($tw_version)) {
				$this->installPlugin($is_core_plugin, $connection);
			} else {
				$this->logSection('twsubscription', 'twSubscriptionPlugin was installed - no need for another install', null, 'INFO');
				return 1;
			}
		} else {
			$this->installPlugin($is_core_plugin, $connection);
		}
		
		$this->logSection('twsubscription', 'twSubscriptionPlugin installed', null, 'INFO');
	}
	
	protected function installPlugin($is_core_plugin, PropelPDO $connection) {
		$root = twMediaFolderQuery::create()->findRoot($connection);
		if (!$root) {
			throw new sfCommandException('create root folder for twMediaPlugin');
		}
		
		twMediaLibrary::createFolder(sfConfig::get('app_tw_subscription_media_folder', 'subscription'), $root, $connection);

		$status = new twSubscriptionStatus();
		$status->setCode('active');
		$status->save($connection);

		$status_i18n = new twSubscriptionStatusI18n();
		$status_i18n->settwSubscriptionStatus($status);
		$status_i18n->setCulture('en');
		$status_i18n->setName('Active');
		$status_i18n->save($connection);

		$status_i18n = new twSubscriptionStatusI18n();
		$status_i18n->settwSubscriptionStatus($status);
		$status_i18n->setCulture('pl');
		$status_i18n->setName('Aktywny');
		$status_i18n->save($connection);

		$status = new twSubscriptionStatus();
		$status->setCode('pending');
		$status->save($connection);

		$status_i18n = new twSubscriptionStatusI18n();
		$status_i18n->settwSubscriptionStatus($status);
		$status_i18n->setCulture('en');
		$status_i18n->setName('Pending');
		$status_i18n->save($connection);

		$status_i18n = new twSubscriptionStatusI18n();
		$status_i18n->settwSubscriptionStatus($status);
		$status_i18n->setCulture('pl');
		$status_i18n->setName('Oczekujący');
		$status_i18n->save($connection);

		$status = new twSubscriptionStatus();
		$status->setCode('disabled');
		$status->save($connection);

		$status_i18n = new twSubscriptionStatusI18n();
		$status_i18n->settwSubscriptionStatus($status);
		$status_i18n->setCulture('en');
		$status_i18n->setName('Disabled');
		$status_i18n->save($connection);

		$status_i18n = new twSubscriptionStatusI18n();
		$status_i18n->settwSubscriptionStatus($status);
		$status_i18n->setCulture('pl');
		$status_i18n->setName('Wyłączony');
		$status_i18n->save($connection);

		$list_type = new twSubscriptionListType();
		$list_type->setCode('standard');
		$list_type->save($connection);

		$list_type_i18n = new twSubscriptionListTypeI18n();
		$list_type_i18n->settwSubscriptionListType($list_type);
		$list_type_i18n->setCulture('en');
		$list_type_i18n->setName('Standard list');
		$list_type_i18n->save($connection);

		$list_type_i18n = new twSubscriptionListTypeI18n();
		$list_type_i18n->settwSubscriptionListType($list_type);
		$list_type_i18n->setCulture('pl');
		$list_type_i18n->setName('Lista standardowa');
		$list_type_i18n->save($connection);

		$message_type = new twSubscriptionMessageType();
		$message_type->setCode('text');
		$message_type->save($connection);

		$message_type_i18n = new twSubscriptionMessageTypeI18n();
		$message_type_i18n->settwSubscriptionMessageType($message_type);
		$message_type_i18n->setCulture('en');
		$message_type_i18n->setName('Text email');
		$message_type_i18n->save($connection);

		$message_type_i18n = new twSubscriptionMessageTypeI18n();
		$message_type_i18n->settwSubscriptionMessageType($message_type);
		$message_type_i18n->setCulture('pl');
		$message_type_i18n->setName('Wiadomość tekstowa');
		$message_type_i18n->save($connection);

		$message_type = new twSubscriptionMessageType();
		$message_type->setCode('xhtml');
		$message_type->save($connection);

		$message_type_i18n = new twSubscriptionMessageTypeI18n();
		$message_type_i18n->settwSubscriptionMessageType($message_type);
		$message_type_i18n->setCulture('en');
		$message_type_i18n->setName('XHTML email');
		$message_type_i18n->save($connection);

		$message_type_i18n = new twSubscriptionMessageTypeI18n();
		$message_type_i18n->settwSubscriptionMessageType($message_type);
		$message_type_i18n->setCulture('pl');
		$message_type_i18n->setName('Wiadomość XHTML');
		$message_type_i18n->save($connection);

		$message_type = new twSubscriptionMessageType();
		$message_type->setCode('xhtml-em');
		$message_type->save($connection);

		$message_type_i18n = new twSubscriptionMessageTypeI18n();
		$message_type_i18n->settwSubscriptionMessageType($message_type);
		$message_type_i18n->setCulture('en');
		$message_type_i18n->setName('XHTML email with embeded images');
		$message_type_i18n->save($connection);

		$message_type_i18n = new twSubscriptionMessageTypeI18n();
		$message_type_i18n->settwSubscriptionMessageType($message_type);
		$message_type_i18n->setCulture('pl');
		$message_type_i18n->setName('Wiadomość XHTML z wbudowaniem zdjęć');
		$message_type_i18n->save($connection);

		$setup = new twSubscriptionSetup();
		$setup->setCode('invitation');
		$setup->setIsHtml(false);
		$setup->save($connection);

		$setup_i18n = new twSubscriptionSetupI18n();
		$setup_i18n->settwSubscriptionSetup($setup);
		$setup_i18n->setCulture('en');
		$setup_i18n->setName("To add to list: {list}, please click a link {auth_link}");
		$setup_i18n->save($connection);

		$setup_i18n = new twSubscriptionSetupI18n();
		$setup_i18n->settwSubscriptionSetup($setup);
		$setup_i18n->setCulture('pl');
		$setup_i18n->setName("Prosimy o zaakceptowanie dodania się do listy {list}. By to zrobić należy kliknąć link {auth_link}");
		$setup_i18n->save($connection);

		if ($is_core_plugin) {
			$tw_version = new twVersion();
			$tw_version->setName('db.subscription');
			$tw_version->setValue(self::VERSION);
			$tw_version->save($connection);
		}
	}
}
