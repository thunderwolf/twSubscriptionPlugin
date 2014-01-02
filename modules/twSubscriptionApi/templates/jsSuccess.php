jQuery.noConflict();

var sub_form = jQuery('\
<form id="sub_z<?php echo $form_id; ?>z">\
    <fieldset>\
        <legend>Zapisz się na newsletter</legend>
        \
        <div class="sub_row"><label for="sub_z<?php echo $form_id; ?>z_email">Twój e-mail:</label> <input tyle="text"
                                                                                                          id="sub_z<?php echo $form_id; ?>z_email"
                                                                                                          class="sub_email"/>
        </div>
        \
        <div class="sub_row"><label for="sub_z<?php echo $form_id; ?>z_name">Twoje imię:</label> <input type="text"
                                                                                                        id="sub_z<?php echo $form_id; ?>z_name"
                                                                                                        class="sub_name"/>
        </div>
        \
        <div class="sub_row_submit"><input type="submit" value="Zapisz się"/></div>
        \
        <span id="sub_z<?php echo $form_id; ?>z_error" class="sub_error"></span>\
    </fieldset>
    \
</form>\
');

jQuery("#z9800a22f9168b83018e3eacdb439d7c5z").after(sub_form);

jQuery("#sub_z<?php echo $form_id; ?>z").submit( function(e) {

jQuery.post(
"<?php echo $website_base_url; ?>/subskrypcja.php",
{
method: 'GET',
cmd: 'subscribe',
email: jQuery("#sub_z<?php echo $form_id; ?>z_email").val(),
name: jQuery("#sub_z<?php echo $form_id; ?>z_name").val()
},
function(data) {
if (typeof subskrypcja_callback_func == "function") {
subskrypcja_callback_func('subscribe', data.error_code, data.error_msg);
} else {
if (data.error_code == 200) {
alert('Rejestracja udana. Dziękujemy. Otrzymasz e-mail z prośbą o potwierdzenie.');
} else {
alert('Wystąpił błąd:\n'+ data.error_code + ' ' + data.error_msg);
}
}

return false;
},
"json");

return false;
});

jQuery(document).ready( function() {
if (jQuery.query.get('subskrypcja.cmd') != '' && jQuery.query.get('subskrypcja.code') != '' && typeof subskrypcja_callback_func == 'function') {
subskrypcja_callback_func(jQuery.query.get('subskrypcja.cmd'), jQuery.query.get('subskrypcja.code'));
}
});
