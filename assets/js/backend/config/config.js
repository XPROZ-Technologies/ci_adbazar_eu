$(document).ready(function(){
    if($('input#autoLoad').val() == '1') {

        $('#btnUpLogoHeader').click(function(){
            $('#logoFileImageHeader').trigger('click');
        });
    
        chooseFile($('#logoFileImageHeader'), $('#fileProgress'), 5, function(fileUrl){
            $('input#logoImageHeader').val(fileUrl);
            $('img#imgLogoHeader').attr('src', fileUrl).show();
        });


        $('#btnCoupons').click(function(){
            $('#logoFileCoupons').trigger('click');
        });
    
        chooseFile($('#logoFileCoupons'), $('#fileProgress'), 5, function(fileUrl){
            $('input#logoImageCoupons').val(fileUrl);
            $('img#imgCoupons').attr('src', fileUrl).show();
        });

        $('#btnAboutUs').click(function(){
            $('#logoFileAboutUs').trigger('click');
        });
    
        chooseFile($('#logoFileAboutUs'), $('#fileProgress'), 5, function(fileUrl){
            $('input#logoImageAboutUs').val(fileUrl);
            $('img#imgAboutUs').attr('src', fileUrl).show();
        });

        $('#btnContactUs').click(function(){
            $('#logoFileContactUs').trigger('click');
        });
    
        chooseFile($('#logoFileContactUs'), $('#fileProgress'), 5, function(fileUrl){
            $('input#logoImageContactUs').val(fileUrl);
            $('img#imgContactUs').attr('src', fileUrl).show();
        });

        $('#btnMarkerMap').click(function(){
            $('#logoFileMarkerMap').trigger('click');
        });
    
        chooseFile($('#logoFileMarkerMap'), $('#fileProgress'), 5, function(fileUrl){
            $('input#logoImageMarkerMap').val(fileUrl);
            $('img#imgMarkerMap').attr('src', fileUrl).show();
        });

        $('#btnLogoFooter').click(function(){
            $('#logoFileLogoFooter').trigger('click');
        });
    
        chooseFile($('#logoFileLogoFooter'), $('#fileProgress'), 5, function(fileUrl){
            $('input#logoImageLogoFooter').val(fileUrl);
            $('img#imgLogoFooter').attr('src', fileUrl).show();
        });

        CKEDITOR.replace('TERM_OF_USE', {
            language: 'en',
            toolbar : 'ShortToolbar',
            height: 200
        });

        CKEDITOR.replace('PRIVACY_POLICY', {
            language: 'en',
            toolbar : 'ShortToolbar',
            height: 200
        });

        $('.submit').click(function(){
            if(validateEmpty('#configForm')) {
                CKEDITOR.instances['TERM_OF_USE'].updateElement();
                CKEDITOR.instances['PRIVACY_POLICY'].updateElement();
                // $('.submit').prop('disabled', true);
               
                var form = $('#configForm');
                var data = form.serializeArray();
                $.ajax({
                    type: "POST",
                    url: form.attr('action'),
                    data: data,
                    success: function (response) {
                        var json = $.parseJSON(response);
                        showNotification(json.message, json.code);
                        $('.submit').prop('disabled', false);
                    },
                    error: function (response) {
                        showNotification(text_err_default, 0);
                        $('.submit').prop('disabled', false);
                    }
                });
            }
            return false;
        });
    }
});
