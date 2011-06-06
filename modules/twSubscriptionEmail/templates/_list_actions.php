<?php echo $helper->linkToNew(array(  'params' =>   array(  ),  'class_suffix' => 'new',  'label' => 'New',)) ?>
<?php $list_id = $sf_user->getAttribute('twSubscriptionEmail.list_id', null, 'admin_module'); ?>
<?php if (!is_null($list_id)): ?>
<li class="sf_admin_action_return">
  <?php echo link_to(__('Powrót do listy', array(), 'messages'), 'twSubscriptionEmail/ListReturn', array()) ?>
</li>
<?php endif; ?>