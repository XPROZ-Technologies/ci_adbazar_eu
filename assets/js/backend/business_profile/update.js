var app = app || {};

app.init = function (businessProfileId) {
    app.library();
    app.handle();
    app.submits(businessProfileId);
}

$(document).ready(function () {
    var businessProfileId = parseInt($('input[name="id"]').val());
    app.init(businessProfileId);
});



app.library = function() {
    $('.js-switch').bootstrapSwitch({size: 'mini'}).on('switchChange.bootstrapSwitch', function(event, state) {
        var isDay = $(this).attr('day-id');
        var statusId = state ? 2:1;
        $(this).val(statusId)
        var isOpen = state ? 'Open':'Close';
        $("span#textDay_"+isDay).text(isOpen);
        if(state) {
            $('input#start_time_'+isDay).attr("placeholder", "Open at");
            $('input#end_time_'+isDay).attr("placeholder", "Open at");
            $("input#start_time_"+isDay).prop('readonly', false);
            $("input#end_time_"+isDay).prop('readonly', false);
        } else {
            $("input#start_time_"+isDay).prop('readonly', true).val('');
            $("input#end_time_"+isDay).prop('readonly', true).val('');
            $('input#start_time_'+isDay).attr("placeholder", "Close at");
            $('input#end_time_'+isDay).attr("placeholder", "Close at");
        }
        
    });

    $('.datetimepicker-start').datetimepicker({
        datepicker:false,
        timepicker:true,
        format:'H:i',
        step:5,
    });

    $('.datetimepicker-end').datetimepicker({
        datepicker:false,
        timepicker:true,
        format:'H:i',
        step:5,
    });

    $('#btnAvatar').click(function(){
        $('#logoFileAvatar').trigger('click');
    });

    chooseFile($('#logoFileAvatar'), $('#fileProgress'), 7, function(fileUrl){
        $('input#logoImageAvatar').val(fileUrl);
        $('img#imgAvatar').attr('src', fileUrl).show();
    });

    $('#btnCover').click(function(){
        $('#logoFileCover').trigger('click');
    });

    chooseFile($('#logoFileCover'), $('#fileProgress'), 7, function(fileUrl){
        $('input#logoImageCover').val(fileUrl);
        $('img#imgCover').attr('src', fileUrl).show();
    });

    $('#businessProfileForm').on('focusout', 'input#business_name', function(){
        $('input#business_url').val(makeSlug($(this).val()));
    });

    $('#businessProfileForm').on('keydown', 'input#business_url', function (e) {
        if(makeSlug(e)) e.preventDefault();
    }).on('keyup', 'input#business_url', function () {
        makeSlug($(this).val())
    });

    $('#btnUpImage').click(function(){
        $('#inputFileImage').trigger('click');
    });
    
    chooseFile($('#inputFileImage'), $('#fileProgress'), 7, function(fileUrl){
        console.log("==fileUrl==",fileUrl)
        $('#ulImages').append('<li><a href="' + fileUrl + '"  target="_blank"><img  src="' + fileUrl + '" style="width:80px!important"></a><i class="fa fa-times"></i></li>');
    });

    $('#ulImages').on('click', 'i', function(){
        $(this).parent().remove();
    });

}

app.handle = function() {
    $('#expired_date').datetimepicker({
        format: 'd/m/Y H:m',
        step:5,
        changeMonth: true,
        changeYear: true,
        minDate:new Date()
    });
    $("select#location_id").select2({
        placeholder: '--Choose Location Name--',
        allowClear: true,
        ajax: {
            url: $("input#urlGetLocationNotInBusinessProfile").val(),
            type: 'POST',
            dataType: 'json',
            data: function(data) {
                $("input#expired_date").val('');
                return {
                    search_text: data.term,
                    business_profile_location_id: $('input[name="business_profile_location_id"]').val()
                };
            },
            processResults: function(data, params) {
                return {
                    results: $.map(data, function(item) {
                        return {
                            text: item.location_name,
                            id: item.id,
                            data: item
                        };
                    })
                };
            }
        }

    }).on('change',function() {
        $("input#expired_date").val('');
    });

    $("select#customer_id").select2({
        placeholder: '--Choose Customer--',
        allowClear: true,
        ajax: {
            url: $("input#urlGetCustomer").val(),
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
                            text: item.full_name,
                            id: item.id,
                            data: item
                        };
                    })
                };
            }
        }

    });

    $("select#serviceId").select2({
        placeholder: '--Choose Service--',
        allowClear: true,
        ajax: {
            url: $("input#urlGetService").val(),
            type: 'POST',
            dataType: 'json',
            data: function(data) {
				$('#businessServiceTypeIds').val(0).trigger('change');
                return {
                    search_text: data.term
                };
            },
            processResults: function(data, params) {
                return {
                    results: $.map(data, function(item) {
                        return {
                            text: item.service_name_en,
                            id: item.id,
                            data: item
                        };
                    })
                };
            }
        }

    });

    $("select#businessServiceTypeIds").select2({
        placeholder: '--Sub-categories--',
        allowClear: true,
        ajax: {
            url: $("input#urlGetServiceType").val(),
            type: 'POST',
            dataType: 'json',
            data: function(data) {
                var serviceId = $('select#serviceId').val(); 
                return {
                    search_text: data.term,
                    service_id: serviceId != null ? serviceId: 0
                };
            },
            processResults: function(data, params) {
                return {
                    results: $.map(data, function(item) {
                        return {
                            text: item.service_type_name_en,
                            id: item.id,
                            data: item
                        };
                    })
                };
            }
        }

    });

    $("select#country_code_id").select2({
        placeholder: '--Choose Country Code--',
        allowClear: true,
        ajax: {
            url: $("input#urlGetPhoneCode").val(),
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
                            text: item.country_name +'  +'+item.phonecode,
                            id: item.id,
                            data: item
                        };
                    })
                };
            }
        }

    });
    var player;
    $("body").on('click', '#link_add', function(){
        var linkYoutube = $("input#linkYoutube").val().trim();
        var videoCode = getIdYoutube(linkYoutube)
        if(linkYoutube == "" || videoCode == false) {
            showNotification(youtubeText);
            return false;
        }
       
        var html = '<tr class="htmlYoutube">';
    	html += '<td><input class="form-control" name="video_url" value="'+linkYoutube+'"></td>';
    	html += '<td><a href="javascript:void(0)" class="link_play" title="Play" video-code="'+videoCode+'"><i class="fa fa-youtube-play"></i></a>';
        html += ' <a href="javascript:void(0)" class="link_delete" title="Delete"><i class="fa fa-times"></i></a></td>';
    	html += '</tr>';
        $("#tbodyYoutube").prepend(html);
        $("input#linkYoutube").val('');
    }).on('click', '.link_delete', function(){
        $(this).parent().parent().remove();
    }).on('click', '.link_play', function() {
        var videoCode = $(this).attr('video-code');
        var ifream = `<iframe id="video" src="https://www.youtube.com/embed/${videoCode}?enablejsapi=1&html5=1" allowfullscreen="" frameborder="0" width="100%" height="480px"></iframe>`;
        $(".contentVideo").html(ifream);
        setTimeout(function(){ 
            $.getScript("https://www.youtube.com/iframe_api", function() {
                onYouTubePlayerAPIReady()
            });
        }, 300);
        
        $("#modalPlayYoutube").modal('show');
    }).on('click','#videoTop', function() {
        $(".contentVideo").html('');
    });

    function onYouTubePlayerAPIReady() {
        player = new window.YT.Player('video', {
            events: {
            'onReady': onPlayerReady
            }
        });
    }

    function onPlayerReady(event) {
        //   var playButton = document.getElementById("play-button");
        //   playButton.addEventListener("click", function() {
        //     player.playVideo();
        //   });
  
        var pauseButton = document.getElementById("videoTop");
        pauseButton.addEventListener("click", function() {
            player.pauseVideo();
        });
    }

   
}

app.submits = function() {
    $("body").on('click', '.submit', function() {
        // $('.submit').prop('disabled', true);
        if(validateEmpty('#businessProfileForm')) {
            
            var customerId = $("select#customer_id").val();
            if(customerId == null || customerId == 'null'){
                showNotification(customerText, 0);
                $('select#customer_id').focus();
                $('.submit').prop('disabled', false);
                return false;
            }

            var country_code_id = $("select#country_code_id").val();
            if(country_code_id == null || country_code_id == 'null'){
                showNotification(phoneCode, 0);
                $('select#country_code_id').focus();
                $('.submit').prop('disabled', false);
                return false;
            }
            
            var serviceId = $("select#serviceId").val();
            if(serviceId == null || serviceId == 'null'){
                showNotification(typeOfServiceText, 0);
                $('select#serviceId').focus();
                $('.submit').prop('disabled', false);
                return false;
            }
            var businessServiceTypeIds = JSON.stringify($('select#businessServiceTypeIds').val());
            if(businessServiceTypeIds == null || businessServiceTypeIds == 'null'){
                businessServiceTypeIds = '[]';
                showNotification(subCategoriesText, 0);
                $('select#businessServiceTypeIds').focus();
                $('.submit').prop('disabled', false);
                return false;
            }
            var photos = [];
            $('#ulImages li a').each(function(){
                photos.push($(this).attr('href'));
            });
            var youtube = [];
            var flagYouTube = true;
            $(".htmlYoutube").each(function() {
                var linkYoutube = $(this).find('td').eq(0).find('input').val();
                if(linkYoutube == "" || getIdYoutube(linkYoutube) == false) {
                    flagYouTube = false
                    $('.submit').prop('disabled', false);
                    return false;
                }
                youtube.push({
                    video_url: linkYoutube,
                    video_code: getIdYoutube(linkYoutube)
                });
            });
            if(flagYouTube == false) {
                showNotification(youtubeText);
                $('.submit').prop('disabled', false);
                return false;
            }
            var form = $('#businessProfileForm');
            var data = form.serializeArray();
            data.push({ name: "OpeningHours", value: JSON.stringify(getOpeningHours())});
            data.push({ name: "BusinessServiceTypeIds", value: businessServiceTypeIds});
            data.push({ name: 'Photos', value: JSON.stringify(photos) });
            data.push({ name: 'BusinessVideos', value: JSON.stringify(youtube)})
            $.ajax({
                type: "POST",
                url: form.attr('action'),
                data: data,
                success: function (response) {
                    var json = $.parseJSON(response);
                    showNotification(json.message, json.code);
                    // if(json.code == 1){
                    //     redirect(false, $("a#btnCancel").attr('href'));
                    // }
                    // else $('.submit').prop('disabled', false);
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

function getOpeningHours() {
    var openHours = [];
    $(".opening_hour").each(function() {
        var $this = $(this);
        var dayId = $this.find("input[name='day_id']").val();
        var dayOpen  = $this.find("input[name='opening_hours_status_id']").val();
        var startTime = $this.find("input[name='start_time']").val();
        var endTime = $this.find("input[name='end_time']").val();
        openHours.push({
            day_id: dayId,
            opening_hours_status_id: dayOpen,
            start_time: startTime,
            end_time: endTime
        });
        
    })
    return openHours;
}
