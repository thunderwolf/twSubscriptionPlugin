<?php use_helper('I18N') ?>
<h1><?php echo __('Informations', null, 'subskrypcja') ?> - <?php echo __('Subscription', null, 'subskrypcja') ?> 1.2</h1>

<ul>
  <li>
    <b><?php echo __('Your Lists', null, 'subskrypcja') ?></b> - <?php echo __('creating and administrating lists of emails', null, 'subskrypcja.info') ?>
  </li>
  <li>
    <b><?php echo __('Your Emails', null, 'subskrypcja') ?></b> - <?php echo __('email searching, adding and modify', null, 'subskrypcja.info') ?>
  </li>
  <li>
    <b><?php echo __('Your Mailer', null, 'subskrypcja') ?></b> - <?php echo __('looking to your mailings and creating new ones', null, 'subskrypcja.info') ?>
  </li>
  <li>
   <b><?php echo __('Email Campaigns', null, 'subskrypcja') ?></b> - <?php echo __('creating email promotions campaings', null, 'subskrypcja.info') ?>
  </li>
  <li>
    <b><?php echo __('Autoresponder', null, 'subskrypcja') ?></b> - <?php echo __('setting up autoresponder messages', null, 'subskrypcja.info') ?>
  </li>
  <li>
    <b><?php echo __('Messages', null, 'subskrypcja') ?></b> - <?php echo __('creating and modifying messages to clients', null, 'subskrypcja.info') ?>
  </li>
  <li>
    <b><?php echo __('Emails Queue', null, 'subskrypcja') ?></b> - <?php echo __('mails in queue, in progress of sending or waitingfor send', null, 'subskrypcja.info') ?>
  </li>
  <li>
    <b><?php echo __('Sent Emails', null, 'subskrypcja') ?></b> - <?php echo __('mails sent to clients', null, 'subskrypcja.info') ?>
  </li>
  <li>
    <b><?php echo __('Questions', null, 'subskrypcja') ?></b> - <?php echo __('if you have any suggestions please tell us about it', null, 'subskrypcja.info') ?>
  </li>
  <li>
    <b><?php echo __('Templates', null, 'subskrypcja') ?></b> - <?php echo __('you can connect template to your list, it\'s simplify your email creation', null, 'subskrypcja.info') ?>
  </li>
</ul>

<strong>Subskrypcja wersja <?php echo twSubscriptionPluginConfiguration::VERSION ?>, data wydania <?php echo twSubscriptionPluginConfiguration::DATE ?></strong>

<?php slot('contentViews') ?>
      <ul class="contentViews">
        <li id="contentview-info" class="selected"><?php echo link_to(__('Informations', null, 'subskrypcja'), 'twSubscriptionInfo/index', array('accesskey' => 'i')) ?></li>
        <li id="contentview-info" class="plain"><?php echo link_to(__('Your Lists', null, 'subskrypcja'), '@tw_subscription_list', array('accesskey' => 'l')) ?></li>
        <li id="contentview-info" class="plain"><?php echo link_to(__('Your Emails', null, 'subskrypcja'), 'twSubscriptionEmail/ListClean', array('accesskey' => 'l')) ?></li>
        <li id="contentview-info" class="plain"><?php echo link_to(__('Messages', null, 'subskrypcja'), '@tw_subscription_message', array('accesskey' => 'l')) ?></li>
        <li id="contentview-info" class="plain"><?php echo link_to(__('Your Mailer', null, 'subskrypcja'), '@tw_subscription_mailing', array('accesskey' => 'l')) ?></li>
        <li id="contentview-info" class="plain"><?php echo link_to(__('Emails Queue', null, 'subskrypcja'), '@tw_subscription_mail_queue', array('accesskey' => 'l')) ?></li>
        <li id="contentview-info" class="plain"><?php echo link_to(__('Sent Emails', null, 'subskrypcja'), '@tw_subscription_mail_sent', array('accesskey' => 'l')) ?></li>
        <li id="contentview-info" class="plain"><?php echo link_to(__('Questions', null, 'subskrypcja'), 'twSubscriptionInfo/pytania', array('accesskey' => 'h')) ?></li>
        <li id="contentview-info" class="plain"><?php echo link_to(__('Import', null, 'subskrypcja'), 'twSubscriptionInfo/import') ?></li>
        <li id="contentview-info" class="plain"><?php echo link_to(__('Templates', null, 'subskrypcja'), '@tw_subscription_template', array('accesskey' => 't')) ?></li>
        <li id="contentview-info" class="plain"><?php echo link_to(__('Setup', null, 'subskrypcja'), '@tw_subscription_setup', array('accesskey' => 's')) ?></li>
      </ul>
<?php end_slot() ?>