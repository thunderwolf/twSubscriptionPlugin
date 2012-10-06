<?php if ($tw_subscription_list->getTemplateId() > 0): ?>
	<?php echo link_to(__('Create Template mailing', array(), 'messages'), 'twSubscriptionList/createMailing?id='.$tw_subscription_list->getId().'&type_id='.$tw_subscription_list->getMessageTypeId(), array("class" => "btn btn-small")) ?>
<?php else: ?>
	<?php echo link_to(__('Create Template mailing', array(), 'messages'), 'twSubscriptionList/createMailing?id='.$tw_subscription_list->getId().'&type_id=1', array("class" => "btn btn-small")) ?>
	<?php echo link_to(__('Create Template mailing', array(), 'messages'), 'twSubscriptionList/createMailing?id='.$tw_subscription_list->getId().'&type_id=3', array("class" => "btn btn-small")) ?>
<?php endif; ?>
