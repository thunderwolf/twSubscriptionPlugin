<?php use_helper('I18N', 'Date') ?>
<?php include_partial('twSubscriptionMessage/assets') ?>

<h2><?php echo __('New Mailing', array(), 'messages') ?></h2>

<?php include_partial('twSubscriptionMessage/flashes') ?>

<div id="tw_admin_content">
	<?php include_partial('twSubscriptionMessage/create_mailing_form', array('form' => $form)) ?>
</div>
