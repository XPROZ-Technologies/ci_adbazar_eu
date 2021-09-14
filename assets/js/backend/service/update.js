var app = app || {};

app.init = function (serviceId) {
    app.library();
    app.handle(serviceId);
    app.submits(serviceId);
}

$(document).ready(function () {
    var serviceId = parseInt($('input[name="id"]').val());
    app.init(serviceId);
});

app.library = function() {

    $('.chooseImage').click(function() {
        $('#inputFileImage').trigger('click');
    });
    chooseFile($('#inputFileImage'), $('#fileProgress'), 6, function(fileUrl) {
        $('input#service_image').val(fileUrl);
        $('img#imgAvatar').attr('src', fileUrl);
    });
    $('a#generatorPass').click(function(){
        var pass = randomPassword(10);
        $('input#newPass').val(pass);
        $('input#rePass').val(pass);
        return false;
    });
}

app.handle = function(serviceId) {
    $("body").on('click', '#link_add', function(){
        var $this = $(this).parent().parent().find('td');
        var htmlServiceType = '<div class="tab-content">';
        var flag = true;
        $(".service_type_name").each(function() {
            var key = $(this).attr('data-key');
            // console.log($(this).hasClass('active'))
            var serviceTypeName = $(this).find('input').val();

            if(serviceTypeName == ''){
                showNotification(serviceTypeNameText, 0);
                flag = false;
                return false;
            } else {
                htmlServiceType += `
                    <div class="tab-pane fade service_type_title_all_content in service-type-name-${key}-tab" data-key="${key}">
                        <div class="form-group">
                            <input type="text" class="form-control service_type_name_text_${key}" readonly value="${serviceTypeName}">
                        </div>
                    </div>
                `;
            }
            
        });
        if(flag == false) return false;
        htmlServiceType += '</div>';
        
        var displayOrder = $this.eq(1).find('select').val();
        var serviceTypeId = $this.eq(2).attr('service-type-id');

        var html = '<tr class="htmlServiceTypes">';
    	html += '<td>'+htmlServiceType+'</td>';
        html += '<td>'+displayOrder+'</td>';
    	html += '<td service-type-id="'+serviceTypeId+'"><a href="javascript:void(0)" class="link_edit" title="Update"><i class="fa fa-pencil"></i></a>&nbsp;';
        html += '<a href="javascript:void(0)" class="link_delete" title="Delete"><i class="fa fa-times"></i></a></td>';
    	html += '</tr>';
    	$("#tbodyServiceTypes").prepend(html);
        $(".service_type_title_all").removeClass('active');
        $(".service_type_title_all_content").removeClass('active');
        $(".service_type_name").removeClass('active');
        $(".service_type_title_en").addClass('active');
        $(".service-type-name-en-tab").addClass('in active');
        $("input.clearAllText").val('');
        htmlServiceType = '';
        $("select#display_order_0").val(1).trigger('change');
    }).on('click', '.link_edit', function(){
        
        var $this = $(this).parent().parent().find('td');
        $this.eq(0).find('.tab-pane').each(function() {
            var key = $(this).attr('data-key');
            var serviceTypeName = $(this).find('input').val();
            $("#service_type_name").val(serviceTypeName)
        });
        var serviceTypeId = $this.eq(2).attr('service-type-id');
        var displayOrder = $this.eq(1).text();
        $("select#display_order_0").val(displayOrder).trigger('change');
        $("td#td-edit").attr('service-type-id', serviceTypeId);
        $(this).parent().parent().remove();
    }).on('click', '.link_delete', function(){
        var $this = $(this).parent().parent().find('td');
        $(this).parent().parent().remove();
    }).on('click', '#link_cancel', function(){
    	$("input#service_type_name").val('');
        $("select#display_order_0").val(1).trigger('change');
    });
}

app.submits = function(serviceId) {
    $("body").on('click', '.submit', function(){
        if(validateEmpty('#serviceForm', '.submit')){
            $('.submit').prop('disabled', true);
            var form = $('#serviceForm');
            var datas = form.serializeArray();
            datas.push({ name: "ServiceTypes", value: JSON.stringify(getDataServiceType())});
            $.ajax({
                type: "POST",
                url: form.attr('action'),
                data: datas,
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
    });
}


function getDataServiceType(){
	var arrDatas = [];
	$('.htmlServiceTypes').each(function(){
        // var arrText = '';
        // $(this).find('.service_type_title_all_content').each(function() {
        //     var key = $(this).attr('data-key');
        //     arrText += 'service_type_name_'+key +':'+ $(this).find('.service_type_name_text_'+key).val()+',';
        // });
        // arrText += 'display_order:'+$(this).find('td').eq(1).text();
        // arrDatas.push(arrText)
        arrDatas.push({
            service_type_name_vi: $(this).find('td').eq(0).find('.service_type_name_text_vi').val(),
            service_type_name_en: $(this).find('td').eq(0).find('.service_type_name_text_en').val(),
            service_type_name_de: $(this).find('td').eq(0).find('.service_type_name_text_de').val(),
            service_type_name_cz: $(this).find('td').eq(0).find('.service_type_name_text_cz').val(),
            display_order: $(this).find('td').eq(1).text()
        })
	});
	return arrDatas;
}