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
            $("input#start_time_"+isDay).prop('readonly', false);
            $("input#end_time_"+isDay).prop('readonly', false);
        } else {
            $("input#start_time_"+isDay).prop('readonly', true).val('');
            $("input#end_time_"+isDay).prop('readonly', true).val('');
        }
        
    });

    $('.datetimepicker-start').datetimepicker({
        format: 'HH:mm'
    });

    $('.datetimepicker-end').datetimepicker({
        format: 'HH:mm'
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
    })
}

app.handle = function() {
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
   
}

app.submits = function() {
    $("body").on('click', '.submit', function() {
        $('.submit').prop('disabled', true);
        if(validateEmpty('#businessProfileForm')) {
            
            var customerId = $("select#customer_id").val();
            if(customerId == null || customerId == 'null'){
                showNotification(customerText, 0);
                $('select#customer_id').focus();
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
            var form = $('#businessProfileForm');
            var data = form.serializeArray();
            data.push({ name: "OpeningHours", value: JSON.stringify(getOpeningHours())});
            data.push({ name: "BusinessServiceTypeIds", value: businessServiceTypeIds});
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