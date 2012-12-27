<?php if ($sf_data->getRaw('content')): ?>
<?php echo $sf_data->getRaw('content') ?>
<?php else: ?>
<?php
include_partial('index', array('email' => $email));
?>
<?php endif; ?>