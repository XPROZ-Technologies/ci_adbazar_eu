var app = app || {};

app.init = function () {
    app.changeStatus();
}

$(document).ready(function () {
    app.init();
});

app.changeStatus = function() {
    $("body").on("click", "a.link_delete", function(){
        if (confirm(removeText)){
            var id = $(this).attr('data-id');
            var statusId = $(this).attr('status-id');
            changeStatus(id, statusId)
        }
        return false;
    }).on("click", "a.link_deactive", function(){
        if (confirm(deactiveText)){
            var id = $(this).attr('data-id');
            var statusId = $(this).attr('status-id');
            changeStatus(id, statusId)
        }
        return false;
    }).on("click", "a.link_active", function(){
        if (confirm(activeText)){
            var id = $(this).attr('data-id');
            var statusId = $(this).attr('status-id');
            changeStatus(id, statusId)
        }
        return false;
    });

    $('.js-switch').bootstrapSwitch({size: 'mini'}).on('switchChange.bootstrapSwitch', function(event, state) {
        $.ajax({
            type: "POST",
            url: $('input#updateIsHotUrl').val(),
            data: {
                id: $(this).attr('data-id'),
                is_hot: state ? 'ON' : 'OFF'
            },
            success: function (response) {
                var json = $.parseJSON(response);
                showNotification(json.message, json.code);
                if(json.code != 1) redirect(true, '');
                else $('.js-switch').val(state);
            },
            error: function (response) {
                showNotification($('input#errorCommonMessage').val(), 0);
                redirect(true, '');
            }
        });
    });
}

function changeStatus(id, statusId) {
    $.ajax({
        type: "POST",
        url: $('input#changeStatusUrl').val(),
        data: {
            id: id,
            service_status_id: statusId
        },
        success: function (response) {
            var json = $.parseJSON(response);
            showNotification(json.message, json.code);
            if (json.code == 1) redirect(true);
        },
        error: function (response) {
            showNotification($('input#errorCommonMessage').val(), 0);
        }
    });
    return false;
}