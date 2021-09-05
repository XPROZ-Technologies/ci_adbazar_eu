$(document).ready(function(){
    $('select.parent').each(function(){
        $(this).val($('input#parent_' + $(this).attr('data-id')).val());
    });
    $('select.parent').change(function(){
        var id = $(this).attr('data-id');
        var value = $(this).val();
        var text = $('select#parentActionId_' + id + ' option[value="' + value + '"]').text();
        if(text == 'Không có') $('input#level_' + id).val('1');
        else if(text.indexOf('+>') >= 0) $('input#level_' + id).val('3');
        else $('input#level_' + id).val('2');
    });
    $('#tbodyActions').on('click', '.link_update', function(){
        var id = parseInt($(this).attr('data-id'));
        var actionName = $('input#actionName_' + id).val().trim();
        if(actionName != '') {
            var actionLevel = parseInt($('input#level_' + id).val());
            var actionUrl = $('input#actionUrl_' + id).val().trim();
            /*if(actionLevel == 3 && actionUrl == ''){
                showNotification('Url không được bỏ trống', 0);
                $('input#actionName_' + id).focus();
                return false;
            }*/
            $.ajax({
                type: "POST",
                url: $('input#updateActionUrl').val(),
                data: {
                    id: id,
                    action_name: actionName,
                    action_url: actionUrl,
                    parent_action_id: $('select#parentActionId_' + id).val(),
                    display_order: $('select#displayOrder_' + id).val(),
                    font_awesome: $('input#fontAwesome_' + id).val().trim(),
                    action_level: actionLevel
                },
                success: function (response) {
                    var json = $.parseJSON(response);
                    showNotification(json.message, json.code);
                    if (json.code == 1) redirect(true, '');
                },
                error: function (response) {
                    showNotification(text_err_default, 0);
                }
            });
        }
        else{
            showNotification(text_empty_name, 0);
            $('input#actionName_' + id).focus();
        }
        return false;
    }).on('click', '.link_delete', function() {
        var id = parseInt($(this).attr('data-id'));
        if(id > 0){
            $.ajax({
                type: "POST",
                url: $('input#deleteActionUrl').val(),
                data: {
                    action_id: id
                },
                success: function (response) {
                    var json = $.parseJSON(response);
                    showNotification(json.message, json.code);
                    if (json.code == 1) $('tr#action_' + id).remove();
                },
                error: function (response) {
                    showNotification(text_err_default, 0);
                }
            });
        }
        else{
            $('input#actionName_0').val('');
            $('input#actionUrl_0').val('');
            $('input#parentActionId_0').val('0');
            $('input#displayOrder_0').val('1');
            $('input#fontAwesome_0').val('');
            $('input#level_0').val('1');
        }
        return false;
    });
});
