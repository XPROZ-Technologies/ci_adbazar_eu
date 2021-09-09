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
            // var statusId = $(this).attr('status-id');
            changeStatus(id)
        }
        return false;
    });
}

function changeStatus(id) {
    $.ajax({
        type: "POST",
        url: $('input#changeStatusUrl').val(),
        data: {
            id: id
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