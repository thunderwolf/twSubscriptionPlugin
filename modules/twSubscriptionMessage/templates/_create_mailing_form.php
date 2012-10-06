<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<form action="<?php echo url_for('twSubscriptionMessage/createMailing') ?>" method="POST" class="form-horizontal">
	<?php echo $form->renderHiddenFields(false) ?>

<?php if ($form->hasGlobalErrors()): ?>
	<?php echo $form->renderGlobalErrors() ?>
<?php endif; ?>

	<fieldset id="tw_fieldset_mailing">
		<?php include_partial('twSubscriptionMessage/create_mailing_form_field', array('form' => $form, 'name' => 'subject', 'class' => 'mailing_subject_row', 'label' => 'Message subject', 'help' => null)) ?>
		<?php include_partial('twSubscriptionMessage/create_mailing_form_field', array('form' => $form, 'name' => 'message', 'class' => 'mailing_message_row', 'label' => 'Message body', 'help' => 'Please put here your message data. To have personalized information you can use special tags like {email} or {fullname} which are ne change to email adres and Fullname of user who will gain this message. To add special link to unsubscribe from this list please use tag {unsubscribe}.')) ?>
		<?php include_partial('twSubscriptionMessage/create_mailing_form_field', array('form' => $form, 'name' => 'time_to_send', 'class' => 'mailing_time_to_send_row', 'label' => 'Time to send', 'help' => null)) ?>
	</fieldset>

	<ul class="sf_admin_actions">
		<?php echo link_to(__('return to list', array(), 'sf_admin'), '@tw_subscription_list', array('class' => 'btn btn-success')); ?>
		<input type="submit" value="<?php echo __('save', array(), 'sf_admin') ?>" class="btn btn-primary" />
	</ul>
</form>
