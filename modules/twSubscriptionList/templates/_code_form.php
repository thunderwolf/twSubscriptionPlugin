<?php
$form->getWidgetSchema()->setLabels(array(
	'list_js'    => __('JavaScript code', null, 'messages'),
));
?>
<fieldset id="tw_fieldset_none" class="">

<div class="tw_admin_form_row tw_admin_text tw_admin_form_field_code control-group<?php $form['list_js']->hasError() and print ' errors' ?>">
	<?php echo $form['list_js']->renderLabel() ?>
	<div class="controls">
		<?php echo $form['list_js']->render(array('class' => 'input-xxlarge')) ?>
		<span class="help-block"><?php echo __('This code you add to your website in plase where you like to show subscription form', null, 'messages') ?></spam>
	</div>
</div>

<div class="control-group">
	<div class="controls">
		<a href="<?php echo url_for('twSubscriptionList/php?id='.$tw_subscription_list->getId()) ?>"><img alt="php" title="php" src="/twSubscriptionPlugin/images/icons/script_save.png" />&nbsp;<?php echo __('Save PHP code') ?></a>
		<a rel="tooltip" href="#" data-original-title="<?php echo __('When you save this PHP script, please put it to main webroot folder. It need to be visable as `http://yourpage.com/subskrypcja.php`. This file create PROXY connection betwean your website and subscription program.', null, 'messages') ?>"><i class="icon-info-sign"></i></a>&nbsp;
	</div>
</div>

</fieldset>

<ul class="sf_admin_actions">
	<?php echo link_to(__('Back to list', array(), 'sf_admin'), '@tw_subscription_list', array('class' => 'btn btn-success')); ?>
</ul>
