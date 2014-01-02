<div class="<?php echo $class ?> control-group<?php $form[$name]->hasError() and print ' errors' ?>">
    <?php echo $form[$name]->renderLabel($label, array('class' => 'control-label')) ?>
    <div class="controls">
        <?php echo $form[$name]->render() ?>
        <?php $is_textarea = false;
        if (get_class($form[$name]->getWidget()) == 'sfWidgetFormTextarea') {
            $is_textarea = true;
        } ?>
        <?php if ($form[$name]->hasError()): ?>
            <span
                class="<?php if ($is_textarea): ?>help-block<?php else: ?>help-inline<?php endif; ?>"><?php echo $form[$name]->renderError() ?></span>
        <?php else: ?>
            <?php if ($help): ?>
                <span
                    class="<?php if ($is_textarea): ?>help-block<?php else: ?>help-inline<?php endif; ?>"><?php echo __($help, array(), 'messages') ?></span>
            <?php elseif ($help = $form[$name]->renderHelp()): ?>
                <span
                    class="<?php if ($is_textarea): ?>help-block<?php else: ?>help-inline<?php endif; ?>"><?php echo $help ?></span>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>