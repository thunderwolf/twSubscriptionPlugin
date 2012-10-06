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
