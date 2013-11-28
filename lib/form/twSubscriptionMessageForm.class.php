<?php

/**
 * twSubscriptionMessage form.
 *
 * @package    form
 * @subpackage tw_subscription_message
 */
class twSubscriptionMessageForm extends BasetwSubscriptionMessageForm
{
	public function configure()
	{
		$type_id = 1;
		if (!$this->isNew()) {
			$type_id = $this->getObject()->getTypeId();
		}
		if ($type_id != 1) {
			sfContext::getInstance()->getConfiguration()->loadHelpers(array(
				'Helper', 'Tag', 'Url'
			));
			$config = array(
				'language' => 'pl',
				'entities_latin' => false,
				'entities_greek' => false,
				'filebrowserBrowseUrl' => url_for('@tw_filemanager_index?sf_format=html') . '?path=' . urlencode(sfConfig::get('app_tw_subscription_media_folder', 'subscription')),
				'customConfig' => '/twAdminPlugin/js/ck_content.js',
			);

			$this->widgetSchema['message'] = new sfWidgetFormCKEditor(array(
				'jsoptions' => $config
			));
		}
	}
}
