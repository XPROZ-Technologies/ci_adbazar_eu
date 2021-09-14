var app = app || {};

app.init = function (userId) {
    app.library();
    app.submits(userId);
}

$(document).ready(function () {
    var userId = parseInt($('input[name="id"]').val());
    app.init(userId);
});

app.library = function() {
    $('.datepicker').datepicker({
        format: 'dd/mm/yyyy',
        autoclose: true,
        endDate: new Date()
    });

    $('.chooseImage').click(function() {
        $('#inputFileImage').trigger('click');
    });
    chooseFile($('#inputFileImage'), $('#fileProgress'), 2, function(fileUrl) {
        $('input#avatar').val(fileUrl);
        $('img#imgAvatar').attr('src', fileUrl);
    });
    $('a#generatorPass').click(function(){
        var pass = randomPassword(10);
        $('input#newPass').val(pass);
        $('input#rePass').val(pass);
        return false;
    });
}

app.submits = function(userId) {
    $("body").on('click', '.submit', function() {
        var $this = $(this);
        $this.prop('disabled', true);
        if (validateEmpty('#userForm', '.submit')) {
            if ($('input#userName').length > 0 && $('input#userName').val().trim().indexOf(' ') >= 0) {
                showNotification(userNameText, 0);
                $('input#userName').focus();
                $this.prop('disabled', false);
                return false;
            }
            if (!validateEmail($('input[name="email"]').val()) && $('input[name="email"]').val().trim() != '') {
                showNotification(emailText, 0);
                $('input[name="email"]').focus();
                $this.prop('disabled', false);
                return false;
            }
            if ($("select#role_id").val() == 0) {
                showNotification(roleText, 0);
                $this.prop('disabled', false);
                return false;
            }
          
            if ($('input#newPass').val() != $('input#rePass').val()) {
                showNotification(rePassText, 0);
                $this.prop('disabled', false);
                return false;
            }
            var form = $('#userForm');
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