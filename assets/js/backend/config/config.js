$(document).ready(function(){
    var aboundId = parseInt($('input#autoLoad').val());
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


        $('#btnUpAboutUsImageBanner').click(function(){
            $('#logoFileAboutUsImageBanner').trigger('click');
        });
    
        chooseFile($('#logoFileAboutUsImageBanner'), $('#fileProgress'), 5, function(fileUrl){
            $('input#logoAboutUsImageBanner').val(fileUrl);
            $('img#imgAboutUsImageBanner').attr('src', fileUrl).show();
        });

        $('#btnUpAboutUsImage1').click(function(){
            $('#logoFileAboutUsImage1').trigger('click');
        });
    
        chooseFile($('#logoFileAboutUsImage1'), $('#fileProgress'), 5, function(fileUrl){
            $('input#logoAboutUsImage1').val(fileUrl);
            $('img#imgAboutUsImage1').attr('src', fileUrl).show();
        });

        $('#btnUpAboutUsImage2').click(function(){
            $('#logoFileAboutUsImage2').trigger('click');
        });
    
        chooseFile($('#logoFileAboutUsImage2'), $('#fileProgress'), 5, function(fileUrl){
            $('input#logoAboutUsImage2').val(fileUrl);
            $('img#imgAboutUsImage2').attr('src', fileUrl).show();
        });


        if(aboundId == 0) {
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
        } 
        

        $('.submit').click(function(){
            if(validateEmpty('#configForm')) {
                if(aboundId == 0) {
                    CKEDITOR.instances['TERM_OF_USE'].updateElement();
                    CKEDITOR.instances['PRIVACY_POLICY'].updateElement();
                }
                // $('.submit').prop('disabled', true);
               
                var form = $('#configForm');
                var data = form.serializeArray();
                data.push({ name: "general", value: $("input#general").val()});
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
