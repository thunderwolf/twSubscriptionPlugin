<?php use_helper('I18N') ?>
<h1><?php echo __('Questions', null, 'subskrypcja') ?></h1>

<div style="margin-top: 10px; font-size: 12px;">
By zadać pytanie, bądź zgłosić awarię należy najpierw przygotować następujące dane:

<ol>
  <li>Informacje o zgłaszającym/pytającym, nr licencji,</li>
  <li>Informacje o wersji produktu znajdującą się na stronie <?php echo link_to(__('Informations', null, 'subskrypcja'), 'twSubscriptionInfo/index') ?>,</li>
  <li>W przypadku gdy pytanie/zgłoszenie dotyczy danej sekcji serwisu prosimy o zamieszczenie linku do tej sekcji.</li>
</ol>

Proces zadawania pytania/zgłoszenia błędu wygląda następująco:

<ol>
  <li>Wchodzimy pod adres <a href="http://trac.arukomp.eu/newticket" target="_blank">http://trac.arukomp.eu/newticket</a>, który skieruje nas do formularza zgłoszeniowego,</li>
  <li>W polu '<strong>Your email or username:</strong>' wprowadzamy swój adres email, dzięki czemu będą Państwo otrzymywać informacje o przebiegu prac nad zgłoszeniem,</li>
  <li>W polu '<strong>Summary:</strong>' wprowadzamy krótkie streszczenie zgłoszenia,</li>
  <li>W polu '<strong>Description:</strong>' wprowadzamy główną treść zgłoszenia,</li>
  <li>W polu '<strong>Type:</strong>' wprowadzamy rodzaj zgłoszenia,</li>
  <li>W polu '<strong>Priority:</strong>' wprowadzamy priorytet zgłoszenia,</li>
  <li>Możemy wprowadzić znaczniki w polu '<strong>Keywords:</strong>',</li>
  <li>Pozostałe pola możemy pozostawić puste,</li>
  <li>Tworzymy zgłoszenie poprzez kliknięcie na przycisku '<strong>Create ticket</strong>'</li>
</ol>

Jeśli podaliśmy swój adres email w polu '<strong>Your email or username:</strong>', to otrzymamy wiadomość email dotyczącą założenia zgłoszenia oraz numer zgłoszenia i link do niego.

</div>

