<ul class="sf_admin_td_actions">
  <?php if ($tw_subscription_list->getTemplateId() > 0): ?>
  <li class="sf_admin_action_template_mailing">
    <?php echo link_to(__('Create Template mailing', array(), 'messages'), 'twSubscriptionList/createMailing?id='.$tw_subscription_list->getId().'&type_id='.$tw_subscription_list->getMessageTypeId(), array()) ?>
  </li>
  <?php else: ?>
  <li class="sf_admin_action_text_mailing">
    <?php echo link_to(__('Create Template mailing', array(), 'messages'), 'twSubscriptionList/createMailing?id='.$tw_subscription_list->getId().'&type_id=1', array()) ?>
  </li>
  <li class="sf_admin_action_xhtml_mailing">
    <?php echo link_to(__('Create Template mailing', array(), 'messages'), 'twSubscriptionList/createMailing?id='.$tw_subscription_list->getId().'&type_id=3', array()) ?>
  </li>
  <?php endif; ?>
</ul>