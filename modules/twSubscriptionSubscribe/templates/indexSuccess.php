<div>
	<p>Fill out the form below to add yourself to our newsletter. On the specified e-mail message will be sent with activation link</p>
	<form action="<?php echo url_for('@subscription_subscribe') ?>" method="post" >
		<?php echo $form->renderHiddenFields(false) ?>
		<fieldset>
			<?php if ($form->hasGlobalErrors()): ?>
				<p><strong><?php echo $form->renderGlobalErrors() ?></strong></p>
			<?php endif; ?>
			<div class="row">
				<label for="rname">Name<?php if ($form['rname']->hasError()): ?> <strong><?php echo $form['rname']->getError() ?></strong><?php endif;?></label>
				<?php echo $form['rname']->render(array('id' => 'rname', 'title' => 'Imię i nazwisko')) ?>
			</div>
			<div class="row">
				<label for="remail">E-mail<?php if ($form['remail']->hasError()): ?> <strong><?php echo $form['remail']->getError() ?></strong><?php endif;?></label>
				<?php echo $form['remail']->render(array('id' => 'remail', 'title' => 'E-mail')) ?>
			</div>
			<div class="row submit">
				<button type="submit">Subscribe</button>
			</div>
		</fieldset>
	</form>
</div>