<td class="sf_admin_text sf_admin_list_td_listname">
	<?php echo $tw_subscription_list->getListname() ?>
</td>
<td class="sf_admin_text sf_admin_list_td_list_type">
	<?php echo $tw_subscription_list->getListType() ?>
</td>
<td class="sf_admin_text sf_admin_list_td_emails">
	<?php echo $tw_subscription_list->getEmails() ?>
	<?php if ($tw_subscription_list->getTwSubscriptionListType()->getLibrary()): ?>
	<?php echo link_to(image_tag('/twSubscriptionPlugin/images/icons/arrow_refresh.png', array('alt' => __('Synchronize emails', null, 'messages'), 'title' => __('Synchronize emails', null, 'messages'))), 'twSubscriptionList/syncEmails?id='.$tw_subscription_list->getId()) ?>
	<?php else: ?>
	<?php echo link_to(image_tag('/twSubscriptionPlugin/images/icons/add.png', array('alt' => __('Add a email', null, 'messages'), 'title' => __('Add a email', null, 'messages'))), 'twSubscriptionList/createEmail?id='.$tw_subscription_list->getId()) ?>
	<?php endif; ?>
	<?php echo link_to(image_tag('/twSubscriptionPlugin/images/icons/magnifier.png', array('alt' => __('Show emails', null, 'messages'), 'title' => __('Show emails', null, 'messages'))), 'twSubscriptionList/listEmails?id='.$tw_subscription_list->getId()) ?>
</td>
<td class="sf_admin_text sf_admin_list_td_create_mailing">
	<?php include_partial('mailing_list', array('tw_subscription_list' => $tw_subscription_list)) ?>
</td>
