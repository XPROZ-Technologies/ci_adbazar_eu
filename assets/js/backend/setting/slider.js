var app = app || {};

app.init = function () {
    app.library();
    app.submit();
}

$(document).ready(function () {
    app.init();
});

app.library = function() {
    $('.chooseImage').click(function(){
        $('#inputFileImage').trigger('click');
    });
    chooseFile($('#inputFileImage'), $('#fileProgress'), 4, function(fileUrl){
        $('input#image').val(fileUrl);
        $('img#imgImage').attr('src', fileUrl);
    });

    $('a#generatorPass').click(function(){
        var pass = randomPassword(10);
        $('input#newPass').val(pass);
        $('input#rePass').val(pass);
        return false;
    });
}

app.submit = function() {
    $("body").on('click', 'a#link_update', function() {
        var $this = $(this);
        $this.prop('disabled', true);
        if (validateEmpty('#sliderForm')) {
            if($("img#imgImage").attr('src') == 'assets/uploads/sliders/no_image.png' || $("img#imgImage").attr('src') == 'no_image.png') {
                showNotification(imageText);
                $this.prop('disabled', false);
                return false;
            }
            var form = $('#sliderForm');
            $.ajax({
                type: "POST",
                url: form.attr('action'),
                data: form.serialize(),
                success: function (response) {
                    var json = $.parseJSON(response);
                    showNotification(json.message, json.code);
                    if(json.code == 1){
                        redirect(true)
                    } else $this.prop('disabled', false);
                },
                error: function (response) {
                    showNotification($('input#errorCommonMessage').val(), 0);
                    $this.prop('disabled', false);
                }
            });
        }
        return false;
    }).on("click", "a.link_edit", function(){
        var id = $(this).attr('data-id');
        $('input#sliderId').val(id);
        $('select#display_order').val($('td#display_order_' + id).text().trim()).trigger('change');
        $("input#image").val($(this).attr('url-image'));
        $("img#imgImage").attr('src', $(this).attr('url-image'));
        $("input#sliderUrl").val($('#sliderUrl_' + id).text());
        
        scrollTo('input#sliderUrl');
        return false;
    }).on("click", "a.link_delete", function(){
        if (confirm(removeText)) {
            var id = $(this).attr('data-id');
            $.ajax({
                type: "POST",
                url: $('input#deleteUrl').val(),
                data: {
                    id: id
                },
                success: function (response) {
                    var json = $.parseJSON(response);
                    showNotification(json.message, json.code);
                    if (json.code == 1) redirect(true);
                },
                error: function (response) {
                    showNotification('Có lỗi xảy ra trong quá trình thực hiện', 0);
                }
            });
        }
        return false;
    });
}
