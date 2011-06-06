<?php use_helper('I18N') ?>

<?php use_stylesheet('/sf/sf_admin/css/main') ?>

<div id="sf_admin_container">
<h1><?php echo __('Import', null, 'subskrypcja') ?></h1>

<div id="sf_admin_content">

<form action="<?php echo url_for('twSubscriptionInfo/import') ?>" method="POST" enctype="multipart/form-data">

<fieldset id="sf_fieldset_none" class="">

<div style="padding: 5px;"><strong style="color: red;">UWAGA!</strong> Importowanie z pliku do listy spowoduje całkowite usunięcie wcześniejszych adresów zgromadzonych na podanej do importu liście.</div>

<blockquote style="padding: 20px;">Podany do importu plik powinien mieć w pierwszym arkuszu w pierwszej kolumnie nazwy które będą przypisane do emaili a w drugiej emaile. Importowane dane są od drugiego wiersza.</blockquote>

<div class="form-row">
  <?php echo $form['list_id']->renderLabel() ?>
  <div class="content<?php if ($form['list_id']->hasError()): ?> form-error<?php endif; ?>">
  <?php if ($form['list_id']->hasError()): ?>
    <?php echo $form['list_id']->renderError() ?>
  <?php endif; ?>

  <?php echo $form['list_id'] ?>
    </div>
</div>

<div class="form-row">
  <?php echo $form['file']->renderLabel() ?>
  <div class="content<?php if ($form['file']->hasError()): ?> form-error<?php endif; ?>">
  <?php if ($form['file']->hasError()): ?>
    <?php echo $form['file']->renderError() ?>
  <?php endif; ?>

  <?php echo $form['file'] ?>
    </div>
</div>

</fieldset>

<ul class="sf_admin_actions">
  <li><input type="submit" value="wyślij" class="sf_admin_action_save" /></li>
</ul>


</form>

</div>

</div>


<?php slot('contentViews') ?>
      <ul class="contentViews">
        <li id="contentview-info" class="plain"><?php echo link_to(__('Informations', null, 'subskrypcja'), 'twSubscriptionInfo/index', array('accesskey' => 'i')) ?></li>
        <li id="contentview-info" class="plain"><?php echo link_to(__('Your Lists', null, 'subskrypcja'), '@tw_subscription_list', array('accesskey' => 'l')) ?></li>
        <li id="contentview-info" class="plain"><?php echo link_to(__('Your Emails', null, 'subskrypcja'), 'twSubscriptionEmail/ListClean', array('accesskey' => 'l')) ?></li>
        <li id="contentview-info" class="plain"><?php echo link_to(__('Messages', null, 'subskrypcja'), '@tw_subscription_message', array('accesskey' => 'l')) ?></li>
        <li id="contentview-info" class="plain"><?php echo link_to(__('Your Mailer', null, 'subskrypcja'), '@tw_subscription_mailing', array('accesskey' => 'l')) ?></li>
        <li id="contentview-info" class="plain"><?php echo link_to(__('Emails Queue', null, 'subskrypcja'), '@tw_subscription_mail_queue', array('accesskey' => 'l')) ?></li>
        <li id="contentview-info" class="plain"><?php echo link_to(__('Sent Emails', null, 'subskrypcja'), '@tw_subscription_mail_sent', array('accesskey' => 'l')) ?></li>
        <li id="contentview-info" class="plain"><?php echo link_to(__('Questions', null, 'subskrypcja'), 'twSubscriptionInfo/pytania', array('accesskey' => 'h')) ?></li>
        <li id="contentview-info" class="selected"><?php echo link_to(__('Import', null, 'subskrypcja'), 'twSubscriptionInfo/import') ?></li>
        <li id="contentview-info" class="plain"><?php echo link_to(__('Templates', null, 'subskrypcja'), '@tw_subscription_template', array('accesskey' => 't')) ?></li>
        <li id="contentview-info" class="plain"><?php echo link_to(__('Setup', null, 'subskrypcja'), '@tw_subscription_setup', array('accesskey' => 's')) ?></li>
      </ul>
<?php end_slot() ?>