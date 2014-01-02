<?php if ($email): ?>
    Adres <?php echo $email->getRemail() ?> dla listy <?php echo $email->getListName() ?> został zdezaktywowany
<?php else: ?>
    Wystąpił błąd proszę o skontaktowanie się z administratorem serwisu.
<?php endif; ?>