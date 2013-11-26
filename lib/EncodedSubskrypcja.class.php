<?php


class EncodedSubskrypcja
{

	public static function autoload($classname)
	{
		switch ($classname) {
			// lib - model
			case 'PlugintwSubscriptionEmail':
				require_once sfConfig::get('sf_plugins_dir') . DIRECTORY_SEPARATOR . 'twSubscriptionPlugin' . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'model' . DIRECTORY_SEPARATOR . 'plugin' . DIRECTORY_SEPARATOR . 'PlugintwSubscriptionEmail.php';
				break;
			case 'PlugintwSubscriptionList':
				require_once sfConfig::get('sf_plugins_dir') . DIRECTORY_SEPARATOR . 'twSubscriptionPlugin' . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'model' . DIRECTORY_SEPARATOR . 'plugin' . DIRECTORY_SEPARATOR . 'PlugintwSubscriptionList.php';
				break; 
			case 'PlugintwSubscriptionListType':
				require_once sfConfig::get('sf_plugins_dir') . DIRECTORY_SEPARATOR . 'twSubscriptionPlugin' . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'model' . DIRECTORY_SEPARATOR . 'plugin' . DIRECTORY_SEPARATOR . 'PlugintwSubscriptionListType.php';
				break;
			case 'PlugintwSubscriptionMailing':
				require_once sfConfig::get('sf_plugins_dir') . DIRECTORY_SEPARATOR . 'twSubscriptionPlugin' . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'model' . DIRECTORY_SEPARATOR . 'plugin' . DIRECTORY_SEPARATOR . 'PlugintwSubscriptionMailing.php';
				break;
				
			case 'PlugintwSubscriptionMailQueue':
				require_once sfConfig::get('sf_plugins_dir') . DIRECTORY_SEPARATOR . 'twSubscriptionPlugin' . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'model' . DIRECTORY_SEPARATOR . 'plugin' . DIRECTORY_SEPARATOR . 'PlugintwSubscriptionMailQueue.php';
				break;
				
			case 'PlugintwSubscriptionMessage':
				require_once sfConfig::get('sf_plugins_dir') . DIRECTORY_SEPARATOR . 'twSubscriptionPlugin' . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'model' . DIRECTORY_SEPARATOR . 'plugin' . DIRECTORY_SEPARATOR . 'PlugintwSubscriptionMessage.php';
				break;
				
			case 'PlugintwSubscriptionMessageType':
				require_once sfConfig::get('sf_plugins_dir') . DIRECTORY_SEPARATOR . 'twSubscriptionPlugin' . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'model' . DIRECTORY_SEPARATOR . 'plugin' . DIRECTORY_SEPARATOR . 'PlugintwSubscriptionMessageType.php';
				break;
				
			// lib - form
			case 'twSubscriptionImportForm':
				require_once sfConfig::get('sf_plugins_dir') . DIRECTORY_SEPARATOR . 'twSubscriptionPlugin' . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'form' . DIRECTORY_SEPARATOR . 'twSubscriptionImportForm.class.php';
				break;
				
			// lib - core
			case 'excelReader':
				require_once sfConfig::get('sf_plugins_dir') . DIRECTORY_SEPARATOR . 'twSubscriptionPlugin' . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'excelReader.class.php';
				break;
				
			case 'twSubscriptionRouting':
				require_once sfConfig::get('sf_plugins_dir') . DIRECTORY_SEPARATOR . 'twSubscriptionPlugin' . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'twSubscriptionRouting.class.php';
				break;
				
			case 'xlsOle':
				require_once sfConfig::get('sf_plugins_dir') . DIRECTORY_SEPARATOR . 'twSubscriptionPlugin' . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'xlsOle.class.php';
				break;
				
			// modules
			//require_once sfConfig::get('sf_plugins_dir') . DIRECTORY_SEPARATOR . 'twSubscriptionPlugin' . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . 'twSubscriptionApi' . DIRECTORY_SEPARATOR . 'actions' . DIRECTORY_SEPARATOR . 'components.class.php';
			//require_once sfConfig::get('sf_plugins_dir') . DIRECTORY_SEPARATOR . 'twSubscriptionPlugin' . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . 'twSubscriptionApi' . DIRECTORY_SEPARATOR . 'actions' . DIRECTORY_SEPARATOR . 'components.class.php';
			//require_once sfConfig::get('sf_plugins_dir') . DIRECTORY_SEPARATOR . 'twSubscriptionPlugin' . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . 'twSubscriptionEmail' . DIRECTORY_SEPARATOR . 'actions' . DIRECTORY_SEPARATOR . 'components.class.php';
			//require_once sfConfig::get('sf_plugins_dir') . DIRECTORY_SEPARATOR . 'twSubscriptionPlugin' . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . 'twSubscriptionInfo' . DIRECTORY_SEPARATOR . 'actions' . DIRECTORY_SEPARATOR . 'components.class.php';
			//require_once sfConfig::get('sf_plugins_dir') . DIRECTORY_SEPARATOR . 'twSubscriptionPlugin' . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . 'twSubscriptionList' . DIRECTORY_SEPARATOR . 'actions' . DIRECTORY_SEPARATOR . 'components.class.php';
			//require_once sfConfig::get('sf_plugins_dir') . DIRECTORY_SEPARATOR . 'twSubscriptionPlugin' . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . 'twSubscriptionMailing' . DIRECTORY_SEPARATOR . 'actions' . DIRECTORY_SEPARATOR . 'components.class.php';
			//require_once sfConfig::get('sf_plugins_dir') . DIRECTORY_SEPARATOR . 'twSubscriptionPlugin' . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . 'twSubscriptionMailQueue' . DIRECTORY_SEPARATOR . 'actions' . DIRECTORY_SEPARATOR . 'components.class.php';
			//require_once sfConfig::get('sf_plugins_dir') . DIRECTORY_SEPARATOR . 'twSubscriptionPlugin' . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . 'twSubscriptionMailSent' . DIRECTORY_SEPARATOR . 'actions' . DIRECTORY_SEPARATOR . 'components.class.php';
			//require_once sfConfig::get('sf_plugins_dir') . DIRECTORY_SEPARATOR . 'twSubscriptionPlugin' . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . 'twSubscriptionMessage' . DIRECTORY_SEPARATOR . 'actions' . DIRECTORY_SEPARATOR . 'components.class.php';
			//require_once sfConfig::get('sf_plugins_dir') . DIRECTORY_SEPARATOR . 'twSubscriptionPlugin' . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . 'twSubscriptionListInvitation' . DIRECTORY_SEPARATOR . 'actions' . DIRECTORY_SEPARATOR . 'components.class.php';
			//require_once sfConfig::get('sf_plugins_dir') . DIRECTORY_SEPARATOR . 'twSubscriptionPlugin' . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . 'twSubscriptionTemplate' . DIRECTORY_SEPARATOR . 'actions' . DIRECTORY_SEPARATOR . 'components.class.php';
		}
	}
}
?>