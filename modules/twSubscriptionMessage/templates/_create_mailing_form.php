<?php include_stylesheets_for_form($form) ?>
<?php include_javascripts_for_form($form) ?>

<div class="sf_admin_form">
  <form action="<?php echo url_for('twSubscriptionMessage/createMailing') ?>" method="POST">
    <?php echo $form->renderHiddenFields() ?>

    <?php if ($form->hasGlobalErrors()): ?>
      <?php echo $form->renderGlobalErrors() ?>
    <?php endif; ?>

<fieldset id="sf_fieldset_none">
  <?php include_partial('twSubscriptionMessage/create_mailing_form_field', array('form' => $form, 'name' => 'subject', 'class' => 'mailing_subject_row', 'label' => 'Message subject', 'help' => null)) ?>
  <?php include_partial('twSubscriptionMessage/create_mailing_form_field', array('form' => $form, 'name' => 'message', 'class' => 'mailing_message_row', 'label' => 'Message body', 'help' => 'Please put here your message data. To have personalized information you can use special tags like {email} or {fullname} which are ne change to email adres and Fullname of user who will gain this message. To add special link to unsubscribe from this list please use tag {unsubscribe}.')) ?>
  <?php include_partial('twSubscriptionMessage/create_mailing_form_field', array('form' => $form, 'name' => 'time_to_send', 'class' => 'mailing_time_to_send_row', 'label' => 'Time to send', 'help' => null)) ?>
</fieldset>

    <ul class="sf_admin_actions">
      <li class="sf_admin_action_list"><?php echo link_to(__('return to list', array(), 'sf_admin'), '@tw_subscription_list') ?></li>
      <li class="sf_admin_action_save"><input type="submit" value="<?php echo __('save', array(), 'sf_admin') ?>" /></li>
    </ul>
  </form>
</div>
