var app = app || {};

app.init = function (couponId) {
    app.library();
    app.handle();
    app.submits(couponId);
}

$(document).ready(function () {
    var couponId = parseInt($('input[name="id"]').val());
    app.init(couponId);
});

app.library = function() {
    $('#btnImage').click(function(){
        $('#logoFileImage').trigger('click');
    });

    chooseFile($('#logoFileImage'), $('#fileProgress'), 8, function(fileUrl){
        $('input#logoImageImage').val(fileUrl);
        $('img#imgImage').attr('src', fileUrl).show();
    });

   
}

app.handle = function() {
    $("select#business_profile_id").select2({
        placeholder: '--Choose Business Profile--',
        allowClear: true,
        ajax: {
            url: $("input#urlGetBusinessProfile").val(),
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
                            text: item.business_name,
                            id: item.id,
                            data: item
                        };
                    })
                };
            }
        }

    });

    var dateNow = new Date();
    dateNow.setDate(dateNow.getDate());
    $('#start_date').datepicker({
        format: 'dd/mm/yyyy',
        todayBtn: true,
        startDate: dateNow,
        autoclose: true
    }).on('changeDate', function (selected) {
        var minDate = new Date(selected.date.valueOf());
        $('#end_date').datepicker('setStartDate', minDate);
        $('#end_date').prop('disabled', false);
    });

    let dateString = $('#start_date').val();
    let dateParts = dateString.split('/');
    let startDate = new Date(+dateParts[2], dateParts[1] - 1, +dateParts[0]);
    $("#end_date").datepicker({
        format: 'dd/mm/yyyy',
        startDate: startDate,
        autoclose: true
    }).on('changeDate', function (selected) {
        var minDate = new Date(selected.date.valueOf());
        $('#start_date').datepicker('setEndDate', minDate);
    });
   
}

app.submits = function() {
    $("body").on('click', '.submit', function() {
        $('.submit').prop('disabled', true);
        if(validateEmpty('#couponForm')) {
            var businessProfileId = $("select#business_profile_id").val();
            if(businessProfileId == null || businessProfileId == 'null'){
                showNotification(businessProfileText, 0);
                $('select#business_profile_id').focus();
                $('.submit').prop('disabled', false);
                return false;
            }
            var form = $('#couponForm');
            var data = form.serializeArray();
            $.ajax({
                type: "POST",
                url: form.attr('action'),
                data: data,
                success: function (response) {
                    var json = $.parseJSON(response);
                    showNotification(json.message, json.code);
                    if(json.code == 1){
                        redirect(false, $("a#btnCancel").attr('href'));
                    }
                    else $('.submit').prop('disabled', false);
                },
                error: function (response) {
                    showNotification($('input#errorCommonMessage').val(), 0);
                    $('.submit').prop('disabled', false);
                }
            });
        }
        return false;
    })
}