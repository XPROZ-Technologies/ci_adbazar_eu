var app = app || {};

app.init = function (customerId) {
    app.library();
    app.submits(customerId);
}

$(document).ready(function () {
    var customerId = parseInt($('input[name="id"]').val());
    app.init(customerId);
});

app.library = function() {
    $('.datepicker').datetimepicker({
        format: 'd/m/Y',
        autoclose: true,
        datepicker:true,
        timepicker:false,
        maxDate: new Date()
    });

    $('.chooseImage').click(function() {
        $('#inputFileImage').trigger('click');
    });
    chooseFile($('#inputFileImage'), $('#fileProgress'), 3, function(fileUrl) {
        $('input#avatar').val(fileUrl);
        $('img#imgAvatar').attr('src', fileUrl);
    });
    $('a#generatorPass').click(function(){
        var pass = randomPassword(10);
        $('input#newPass').val(pass);
        $('input#rePass').val(pass);
        return false;
    });

    $('.js-switch').bootstrapSwitch({size: 'mini'}).on('switchChange.bootstrapSwitch', function(event, state) {
        var isHot = state ? 2 : 1;
        $(this).val(isHot)
    });

    $("select#country_code_id").select2({
        placeholder: '--Choose Country Code--',
        allowClear: true,
        ajax: {
            url: $("input#urlGetPhoneCode").val(),
            type: 'POST',
            dataType: 'json',
            data: function(data) {
                return {
                    search_text: data.term
                };
            },
            processResults: function(data, params) {
                return {
                    results: $.map(data, function(item) {
                        return {
                            text: item.country_name +'  +'+item.phonecode,
                            id: item.id,
                            data: item
                        };
                    })
                };
            }
        }

    });
}

app.submits = function(userId) {
    $("body").on('click', '.submit', function() {
        var $this = $(this);
        $this.prop('disabled', true);
        if (validateEmpty('#customerForm', '.submit')) {
            var country_code_id = $("select#country_code_id").val();
            if(country_code_id == null || country_code_id == 'null'){
                showNotification(phoneCode, 0);
                $('select#country_code_id').focus();
                $('.submit').prop('disabled', false);
                return false;
            }
           
            if (!validateEmail($('input[name="customer_email"]').val()) && $('input[name="customer_email"]').val().trim() != '') {
                showNotification(emailText, 0);
                $('input[name="customer_email"]').focus();
                $this.prop('disabled', false);
                return false;
            }
           
            if ($('input#newPass').val() != $('input#rePass').val()) {
                showNotification(rePassText, 0);
                $this.prop('disabled', false);
                return false;
            }
            var form = $('#customerForm');
            $.ajax({
                type: "POST",
                url: form.attr('action'),
                data: form.serialize(),
                success: function(response) {
                    var json = $.parseJSON(response);
                    showNotification(json.message, json.code);
                    if (json.code == 1) {
                        redirect(false, $('a#btnCancel').attr('href'));
                    } else $this.prop('disabled', false);
                },
                error: function(response) {
                    showNotification($('input#errorCommonMessage').val(), 0);
                    $this.prop('disabled', false);
                }
            });
        }
        return false;
    })
}