<?php
$form->getWidgetSchema()->setLabels(array(
	'list_js'    => __('JavaScript code', null, 'messages'),
));
?>
<fieldset id="sf_fieldset_none" class="">

<div class="form-row">
  <?php echo $form['list_js']->renderLabel() ?>
  <div class="content">
  
  <?php echo $form['list_js']->render() ?>
  
  <div class="sf_admin_edit_help"><?php echo __('This code you add to your website in plase where you like to show subscription form', null, 'messages') ?></div>
</div></div>

<div class="form-row">
  <div class="content">
    <a href="<?php echo url_for('twSubscriptionList/php?id='.$tw_subscription_list->getId()) ?>"><img alt="php" title="php" src="/twSubscriptionPlugin/images/icons/script_save.png" />&nbsp;<?php echo __('Save PHP code') ?></a>
    <div class="sf_admin_edit_help"><?php echo __('When you save this PHP script, please put it to main webroot folder. It need to be visable as `http://yourpage.com/subskrypcja.php`. This file create PROXY connection betwean your website and subscription program.', null, 'messages') ?></div>
  </div>
</div>

</fieldset>

<ul class="sf_admin_actions">
  <li class="sf_admin_action_list"><?php echo link_to(__('list', array(), 'sf_admin'), '@tw_subscription_list') ?></li>
</ul>
