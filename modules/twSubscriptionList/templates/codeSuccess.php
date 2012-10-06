<?php use_helper('I18N', 'Date') ?>
<?php include_partial('twSubscriptionList/assets') ?>

<h2><?php echo __('Your List: %%listname%%', array('%%listname%%' => $tw_subscription_list->getListname()), 'messages') ?></h2>

<?php include_partial('twSubscriptionList/flashes') ?>

<div id="tw_admin_content">
	<?php include_partial('twSubscriptionList/code_form', array('tw_subscription_list' => $tw_subscription_list, 'form' => $form)) ?>
</div>