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
        var serviceTypeName = $this.eq(0).find('input').val();
        var displayOrder = $this.eq(1).find('select').val();
        var serviceTypeId = $this.eq(2).attr('service-type-id');
        if(serviceTypeName == ''){
    		showNotification(serviceTypeNameText, 0);
    		return false
    	}

        var html = '<tr class="htmlServiceTypes">';
    	html += '<td>'+serviceTypeName+'</td>';
        html += '<td>'+displayOrder+'</td>';
    	html += '<td service-type-id="'+serviceTypeId+'"><a href="javascript:void(0)" class="link_edit" title="Update"><i class="fa fa-pencil"></i></a>&nbsp;';
        html += '<a href="javascript:void(0)" class="link_delete" title="Delete"><i class="fa fa-times"></i></a></td>';
    	html += '</tr>';
    	$("#tbodyServiceTypes").prepend(html);
        $("input#service_type_name").val('');
        $("select#display_order_0").val(1).trigger('change');
    }).on('click', '.link_edit', function(){
        var $this = $(this).parent().parent().find('td');
        var serviceTypeName = $this.eq(0).text();
        var displayOrder = $this.eq(1).text();
        var serviceTypeId = $this.eq(2).attr('service-type-id');
        $("input#service_type_name").val(serviceTypeName);
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
        if(validateEmpty('#serviceForm'), '.submit'){
            // $('.submit').prop('disabled', true);
            var form = $('#serviceForm');
            var datas = form.serializeArray();
            datas.push({ name: "ServiceTypes", value: JSON.stringify(getDataServiceType())});
            console.log(getDataServiceType())
            $.ajax({
                type: "POST",
                url: form.attr('action'),
                data: datas,
                success: function (response) {
                    var json = $.parseJSON(response);
                    showNotification(json.message, json.code);
                    // if(json.code == 1){
                    //     redirect(true, '');
                    // }
                    // else $('.submit').prop('disabled', false);
                },
                error: function (response) {
                    showNotification('Có lỗi xảy ra trong quá trình thực hiện', 0);
                    // $('.submit').prop('disabled', false);
                }
            });
        }
        return false;
    });
}


function getDataServiceType(){
	var arrDatas = [];
	$('.htmlServiceTypes').each(function(){
		arrDatas.push({
            // id: $(this).find('td').eq(2).attr('service-type-id'),
			service_type_name: $(this).find('td').eq(0).text(),
            display_order: $(this).find('td').eq(1).text()
		});
	});
	return arrDatas;
}