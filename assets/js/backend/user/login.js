$(document).ready(function() {
    $('input.iCheck').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '20%'
    });
    $(document).on('submit','#userForm',function (){
        if(validateEmpty('#userForm')) {
            var form = $('#userForm');
            var data = form.serialize();
            form.find('input, button').prop("disabled", true);
            $.ajax({
                type: "POST",
                dataType: "json",
                url: form.attr('action'),
                data: data,
                success: function (response) {
                    var json = response;// $.parseJSON(response);
                    showNotification(json.message, json.code);
                    if(json.code == 1){
                        var redirectUrl = getURLParameter('redirectUrl');
                        if(redirectUrl.indexOf('http') == -1) redirectUrl = $('input#dashboardUrl').val();
                        redirect(false, redirectUrl);
                    }
                    else{
                        form.find('input, button').prop("disabled", false);
                        $('#divForgot').show();
                    }
                },
                error: function (response) {
                    showNotification($('input#errorCommonMessage').val(), 0);
                    form.find('input, button').prop("disabled", false);
                }
            });
        }
        return false;
    });
});

function getURLParameter(sParam) {
    var sPageURL = window.location.search.substring(1);
    var sURLVariables = sPageURL.split('&');
    for (var i = 0; i < sURLVariables.length; i++) {
        var sParameterName = sURLVariables[i].split('=');
        if (sParameterName[0] == sParam) {
            return sParameterName[1];
        }
    }
    return '';
}
