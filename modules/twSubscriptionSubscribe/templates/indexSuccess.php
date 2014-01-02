<div>
    <p>Fill out the form below to add yourself to our newsletter. On the specified e-mail message will be sent with
        activation link</p>

    <form action="<?php echo url_for('@subscription_subscribe') ?>" method="post">
        <?php echo $form->renderHiddenFields(false) ?>
        <fieldset>
            <?php if ($form->hasGlobalErrors()): ?>
                <p><strong><?php echo $form->renderGlobalErrors() ?></strong></p>
            <?php endif; ?>
            <div class="row">
                <label for="r_name">Name<?php if ($form['r_name']->hasError()): ?>
                        <strong><?php echo $form['r_name']->getError() ?></strong><?php endif; ?></label>
                <?php echo $form['r_name']->render(array('id' => 'r_name', 'title' => 'Imię i nazwisko')) ?>
            </div>
            <div class="row">
                <label for="r_email">E-mail<?php if ($form['r_email']->hasError()): ?>
                        <strong><?php echo $form['r_email']->getError() ?></strong><?php endif; ?></label>
                <?php echo $form['r_email']->render(array('id' => 'r_email', 'title' => 'E-mail')) ?>
            </div>
            <div class="row submit">
                <button type="submit">Subscribe</button>
            </div>
        </fieldset>
    </form>
</div>