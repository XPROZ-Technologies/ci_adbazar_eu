var app = app || {};

app.init = function (eventId) {
    app.library();
    app.handle(eventId);
    app.submits(eventId);
}

$(document).ready(function () {
    var eventId = parseInt($('input[name="id"]').val());
    app.init(eventId);
});

app.library = function() {
    $('#btnImage').click(function(){
        $('#logoFileImage').trigger('click');
    });

    chooseFile($('#logoFileImage'), $('#fileProgress'), 9, function(fileUrl){
        $('input#logoImageImage').val(fileUrl);
        $('img#imgImage').attr('src', fileUrl).show();
    });
}

app.handle = function(eventId) {
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
    // let startDateStr = $('#start_date').val();
    // $('#start_date').datetimepicker({
    //     format: 'DD/MM/YYYY HH:mm', // 
    //     useCurrent: true,
    //     minDate: eventId == 0 ? moment() : moment(startDateStr, 'DD/MM/YYYY HH:mm')
    // });

    // let endDateStr = $('#end_date').val();
    // $('#end_date').datetimepicker({
    //     format: 'DD/MM/YYYY HH:mm', // 
    //     useCurrent: true,
    //     minDate: eventId == 0 ? moment() : moment(endDateStr, 'DD/MM/YYYY HH:mm')
    // });
   

    // $('#start_date').datetimepicker().on('dp.change', function (e) {
    //     var incrementDay = moment(new Date(e.date));
    //     // incrementDay.add(1, 'days');
    //     $('#end_date').val('');
    //     $('#end_date').data('DateTimePicker').minDate(incrementDay);
    //     // $(this).data("DateTimePicker").hide();
    //     $("#end_date").prop('readonly', false);
    // });


    // $('#end_date').datetimepicker().on('dp.change', function (e) {
    //     var decrementDay = moment(new Date(e.date));
    //     // decrementDay.subtract(1, 'days');
    //     $('#start_date').data('DateTimePicker').maxDate(decrementDay);
    //     //  $(this).data("DateTimePicker").hide();
    // });

    var dateNow = new Date();
    dateNow.setDate(dateNow.getDate());
    $('#start_date').datetimepicker({
        format: 'd/m/Y H:i',
        todayBtn: true,
        minDate: dateNow,
        autoclose: true,
        step:5
    }).on('change.datetimepicker', function () {
        let dateString = $('#start_date').val();
        let dateParts = dateString.split('/');
        let yearTime = dateParts[2].split(' ');
        let time = yearTime[1].split(':');
        let startDate = new Date(+yearTime[0], dateParts[1] - 1, +dateParts[0], time[0], time[1]);
        $('#end_date').datetimepicker({
            format: 'd/m/Y H:i',
            step:5,
            minDate:startDate
        });
        $('#end_date').prop('disabled', false);
    });

    if(eventId == 0) {
        $("#end_date").datetimepicker({
            format: 'd/m/Y H:i',
            // minDate: startDate,
            step:5,
            autoclose: true
        }).on('change.datetimepicker', function (selected) {
            let dateString2 = $('#end_date').val();
            let dateParts2 = dateString2.split('/');
            let yearTime2 = dateParts2[2].split(' ');
            let time2 = yearTime2[1].split(':');
            let endDate = new Date(+yearTime2[0], dateParts2[1] - 1, +dateParts2[0], time2[0], time2[1]);
    
            let dateString = $('#start_date').val();
            let dateParts = dateString.split('/');
            let yearTime = dateParts[2].split(' ');
            let time = yearTime[1].split(':');
            let startDate = new Date(+yearTime[0], dateParts[1] - 1, +dateParts[0], time[0], time[1]);
    
            $('#start_date').datetimepicker({
                format: 'd/m/Y H:i',
                minDate:startDate,
                step:5,
                maxDate:endDate
            });
        });
    } else {
        let dateString = $('#start_date').val();
        let dateParts = dateString.split('/');
        let yearTime = dateParts[2].split(' ');
        let time = yearTime[1].split(':');
        let startDate = new Date(+yearTime[0], dateParts[1] - 1, +dateParts[0], time[0], time[1]);
        $("#end_date").datetimepicker({
            format: 'd/m/Y H:i',
            minDate: startDate,
            step:5,
            autoclose: true
        }).on('change.datetimepicker', function (selected) {
            let dateString2 = $('#end_date').val();
            let dateParts2 = dateString2.split('/');
            let yearTime2 = dateParts2[2].split(' ');
            let time2 = yearTime2[1].split(':');
            let endDate = new Date(+yearTime2[0], dateParts2[1] - 1, +dateParts2[0], time2[0], time2[1]);
    
            
    
            $('#start_date').datetimepicker({
                format: 'd/m/Y H:i',
                minDate:startDate,
                step:5,
                maxDate:endDate
            });
        });
    }
    

    

}

app.submits = function() {
    $("body").on('click', '.submit', function() {
        $('.submit').prop('disabled', true);
        if(validateEmpty('#eventForm')) {
            var form = $('#eventForm');
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