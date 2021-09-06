// lưu các thông tin lọc khi sử dụng bộ lọc
var data_filter = {
    itemFilters: [],
    filterId: 0,
    tagFilters: []
};
var paginateObject = null;
//--------------- Thiết kế data chuyển tab bộ lọc -------------------------------//
function loadTabAjax(itemName) {
    //xóa tab search đi nếu có
    var tab_search = $('#ulFilter').find('li#tab_search');
    if(tab_search.length > 0) $(tab_search).remove();
    $('#itemSearchName').val('');
    $.ajax({
        type: "POST",
        url: $('#btn-filter').attr('data-href'),
        //async: false,
        data:{
            filterId: data_filter.filterId
        },
        success: function (response) {
            response = $.parseJSON(response);
            //console.log(response);
            //render  table
            render(response.callBackTable, response.dataTables);

            //render nhãn lọc
            data_filter.itemFilters = response.itemFilters == null ? [] : response.itemFilters;
            data_filter.tagFilters = response.tagFilters == null ? [] : response.tagFilters;
            render(response.callBackTagFilter, data_filter.tagFilters);
            updateStatusBtnSaveFilter();
            updateStatusBtnRemoFilter();

            //render paginate
            if(paginateObject == null){
                paginateObject = $('#table-data').Paginate({
                    page: response.page,
                    pageSize: response.pageSize,
                    totalRow: response.totalRow,
                    itemName: itemName// config.ItemName
                });
            }
            else{
                paginateObject.Paginate({
                    page: response.page,
                    pageSize: response.pageSize,
                    totalRow: response.totalRow,
                    registerEvent : false,
                    itemName: itemName// config.ItemName
                });
            }
        },
        error: function (response) {
            showNotification('Có lỗi xảy ra trong quá trình thực hiện', 0);
        }
    });
}
function bindFilter(id, itemName){
    data_filter.filterId = id;
    data_filter.tagFilters = [];
    data_filter.itemFilters = [];
    loadTabAjax(itemName);
}
function updateStatusBtnSaveFilter() {
    var btn = $('#btn-popup-filter');
    if ($('#container-filters').text().length == 0) {
        btn.attr("disabled", true);
        if (btn.hasClass('btn-default')) btn.removeClass('btn-default');
        if (btn.hasClass('btn-flat')) btn.removeClass('btn-flat');
        if (!btn.hasClass('btn-disable')) btn.addClass('btn-disable');

    }
    else {
        btn.attr("disabled", false);
        if (!btn.hasClass('btn-default')) btn.addClass('btn-default');
        if (!btn.hasClass('btn-flat')) btn.addClass('btn-flat');
        if (btn.hasClass('btn-disable')) btn.removeClass('btn-disable');
    }
}
function updateStatusBtnRemoFilter() {
    var btn = $('#remove-filter');
    if (data_filter.filterId == 0) {
        btn.attr('disabled', true);
        if (btn.hasClass('btn-default')) btn.removeClass('btn-default');
        if (btn.hasClass('btn-flat')) btn.removeClass('btn-flat');
        if (!btn.hasClass('btn-disable')) btn.addClass('btn-disable');
    }
    else {
        btn.attr('disabled', false);
        if (!btn.hasClass('btn-default')) btn.addClass('btn-default');
        if (!btn.hasClass('btn-flat')) btn.addClass('btn-flat');
        if (btn.hasClass('btn-disable')) btn.removeClass('btn-disable');
    }
}
$('#ulFilter').on('click', 'a', function(){
    bindFilter($(this).attr('data-id'), 'records');
    $('#btn-save-filter').attr('display-order', $(this).parent().attr('data-id'));
});

function actionItemAndSearch(config) {
    $('input.iCheckTable').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '20%'
    });
    $('body').on('keydown', 'input.input-number', function (e) {
        if(checkKeyCodeNumber(e)) e.preventDefault();
    }).on('keyup', 'input.input-number', function () {
        var value = $(this).val();
        $(this).val(formatDecimal(value));
    }).on('ifToggled', 'input#checkAll', function (e) {
        if (e.currentTarget.checked) {
            $('input.iCheckItem').iCheck('check');
            //$('#h3Title').hide();
            $('#selectAction').show();
            $('#selectData').show();
            
        }
        else {
            $('input.iCheckItem').iCheck('uncheck');
            $('#selectAction').hide();
            $('#selectData').hide();
            //$('#h3Title').show();
        }
        var itemIds = [];
        $('input.iCheckItem').each(function () {
            if ($(this).parent('div.icheckbox_square-blue').hasClass('checked')) itemIds.push(parseInt($(this).val()));
        });
        $("select#selectData").html('<option value="one">'+itemIds.length+' đã chọn</option><option value="all">Chọn tất cả ('+$("div.total-row").text().split(' ')[0]+')</option>');
    }).on('ifToggled', 'input.iCheckItem', function (e) {
        if (e.currentTarget.checked) {
            //$('#h3Title').hide();
            $('#selectAction').show();
            $('#selectData').show();
            
        } else {
            var iCheckItems = document.querySelectorAll('.checked input.iCheckItem');
            if (iCheckItems.length == 1) {
                $('input#checkAll').iCheck('uncheck');
                //$('#h3Title').show();
                $('#selectAction').hide();
                $('#selectData').hide();
            }
        }
        var itemIds = [];
        $("input.iCheckItem:checked").each(function () {
            itemIds.push(parseInt($(this).val()))
        });
        $("select#selectData").html('<option value="one">'+itemIds.length+' đã chọn</option><option value="all">Chọn tất cả ('+$("div.total-row").text().split(' ')[0]+')</option>');
    });
    var tags = [];
    if ($('input#tags').length > 0) {
        $('input#tags').tagsInput({
            'width': '100%',
            'height': '100px',
            'interactive': true,
            'defaultText': '',
            'onAddTag': function (tag) {
                tags.push(tag);
            },
            'onRemoveTag': function (tag) {
                var index = tags.indexOf(tag);
                if (index >= 0) tags.splice(index, 1);
            },
            'delimiter': [',', ';'],
            'removeWithBackspace': true,
            'minChars': 0,
            'maxChars': 0
        });
    }
    $('#selectAction').change(function () {
        var actionCode = $(this).val();
        if (actionCode != '') {
            var itemIds = [];
            $('input.iCheckItem').each(function () {
                if ($(this).parent('div.icheckbox_square-blue').hasClass('checked')) itemIds.push(parseInt($(this).val()));
            });
            if(itemIds.length > 0) {
                /*if(actionCode == 'delete_item') {
                    if (confirm('Bạn có thực sự muốn xóa ?')) {
                        $.ajax({
                            type: "POST",
                            url: $('input#deleteItemUrl').val(),
                            data: {
                                ItemIds: JSON.stringify(itemIds)
                            },
                            success: function (response) {
                                var json = $.parseJSON(response);
                                showNotification(json.message, json.code);
                                if (json.code == 1) {
                                    for (var i = 0; i < itemIds.length; i++) $('#trItem_' + itemIds[i]).remove();
                                }
                            },
                            error: function (response) {
                                showNotification('Có lỗi xảy ra trong quá trình thực hiện', 0);
                            }
                        });
                    }
                }
                else*/ if (actionCode == 'add_tags') {
                    $('.spanItemName').text(config.ItemName);
                    $('input#changeTagTypeId').val('1');
                    $('input#itemTagIds').val(JSON.stringify(itemIds));
                    $('#tags').importTags('');
                    tags = [];
                    $('#modalEditTags').modal('show');
                }
                else if (actionCode == 'delete_tags') {
                    $('.spanItemName').text(config.ItemName);
                    $('input#changeTagTypeId').val('2');
                    $('input#itemTagIds').val(JSON.stringify(itemIds));
                    $('#tags').importTags('');
                    tags = [];
                    $('#modalEditTags').modal('show');
                }
                else if (actionCode.indexOf('change_status-') >= 0) {
                    actionCode = actionCode.split('-');
                    if (actionCode.length == 2) {
                        var statusId = parseInt(actionCode[1]);
                        changeHFStatus(itemIds, statusId);
                    }
                }
                else if (actionCode == 'delete_item') {
                    $('input#itemTagIds').val(JSON.stringify(itemIds));
                    $('#commentDelete').val('');
                    $('#admin-delete').modal('show');
                }
                else config.extendFunction(itemIds, actionCode);
            }
            else showNotification('Vui lòng chọn ' + config.ItemName, 0);
        }
        $('#selectAction').val('');
    });
    $('#btnChangeTags').click(function () {
        var itemTagIds = "";
        if($("select#selectData").val().trim() != 'all') itemTagIds = $('input#itemTagIds').val();
        else itemTagIds = $('input#itemTagAllIds').val();
        if (tags.length > 0 && itemTagIds != '') {
            var btn = $(this);
            btn.prop('disabled', true);
            var loading = $('#modalEditTags .imgLoading');
            loading.show();
            $.ajax({
                type: "POST",
                url: $('input#updateItemTagUrl').val(),
                data: {
                    ItemIds: itemTagIds,
                    TagNames: JSON.stringify(tags),
                    ItemTypeId: $('input#itemTypeId').val(),
                    ChangeTagTypeId: $('input#changeTagTypeId').val()
                },
                success: function (response) {
                    var json = $.parseJSON(response);
                    showNotification(json.message, json.code);
                    if (json.code == 1) {
                        $('input#itemTagIds').val('');
                        $('#modalEditTags').modal('hide');
                        $('input.iCheckItem').iCheck('uncheck');
                    }
                    btn.prop('disabled', false);
                    loading.hide();
                },
                error: function (response) {
                    showNotification('Có lỗi xảy ra trong quá trình thực hiện', 0);
                    btn.prop('disabled', false);
                    loading.hide();
                }
            });
        }
        else showNotification('Vui lòng chọn nhãn', 0);
    });
    $('#btn-save-delete').click(function(){
        var commentDelete = $('#commentDelete').val().trim();
        if(commentDelete != ''){
            var btn = $(this);
            btn.prop('disabled', true);
            var itemTagIds = "";
            if($("select#selectData").val().trim() != 'all') itemTagIds = $('input#itemTagIds').val();
            else itemTagIds = $('input#itemTagAllIds').val();
            $.ajax({
                type: "POST",
                url: btn.attr('data-href'),
                data: {
                    ItemIds: itemTagIds,
                    Comment: commentDelete,
                    ItemTypeId: $('input#itemTypeId').val()
                },
                success: function (response) {
                    var json = $.parseJSON(response);
                    showNotification(json.message, json.code);
                    if (json.code == 1) {
                        $('input#itemTagIds').val('');
                        $('#admin-delete').modal('hide');
                        $('input.iCheckItem').iCheck('uncheck');
                        if(itemTagIds != 'all'){
                            var itemIds = $.parseJSON(itemTagIds);
                            for (var i = 0; i < itemIds.length; i++) $('#trItem_' + itemIds[i]).remove();
                        }else redirect(true, '');
                        
                    }
                    btn.prop('disabled', false);
                },
                error: function (response) {
                    showNotification('Có lỗi xảy ra trong quá trình thực hiện', 0);
                    btn.prop('disabled', false);
                }
            });
        }
        else showNotification('Xác nhận xóa không được bỏ trống', 0);
    });
    $(document).on('click', '.changeHFStatus', function() {
        var itemIds = [];
        let statusId = $(this).attr('data-status');
        itemIds.push($(this).attr('data-id'));
        changeHFStatus(itemIds, statusId);
    })

    if(typeof(config.IsRenderFirst) != 'undefined'){ //tam thoi
        if(config.IsRenderFirst == 1) searchAjax();
        else bindFilter(0, config.ItemName);
    }

    /**
     * function thay đổi trạng thái
     */
    function changeHFStatus(itemIds = [], statusId = '') {
        if(itemIds.length && statusId) {
            swal({
                title: statusId == 0 ? 'Bạn có thực sự muốn xóa?' : "Bạn có thực sự muốn thay đổi?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        type: "POST",
                        url: $('input#changeItemStatusUrl').val(),
                        data: {
                            ItemIds: JSON.stringify(itemIds),
                            StatusId: statusId,
                            Comment: ''
                        },
                        success: function (response) {
                            var json = $.parseJSON(response);
                            showNotification(json.message, json.code);
                            if (json.code == 1) {
                                var i;
                                if (statusId == 0) {
                                    for (i = 0; i < itemIds.length; i++) $('#trItem_' + itemIds[i]).remove();
                                    let totalItems = parseInt($('.total-row span').text());
                                    $('.total-row span').text(totalItems - 1)
                                }
                                else {
                                    for (i = 0; i < itemIds.length; i++) $('td#statusName_' + itemIds[i]).html(json.data);
                                    searchAjax();
                                    $('#selectAction').hide();
                                }
                            }
                        },
                        error: function (response) {
                            showNotification('Có lỗi xảy ra trong quá trình thực hiện', 0);
                        }
                    });
                }
            });
        } else showNotification('Có lỗi xảy ra trong quá trình thực hiện', 0);
    }

    /*--------------------------------Thiết kế bộ lọc-------------------------------------------*/
    /*
     *hàm filter
     *input : string,object
     *output : json
     *itemFilters có dạng
     * [
     *      {filed_name : price ,conds : [=,1000]},
     *      {filed_name : name ,conds : [like,thanh]},
     *      {filed_name : name ,conds : [is,thanh]},
     *      {filed_name : create_at ,conds : [between,01-01-2017,31-01-2017]}
     *
     * ]
     */

    function searchAjax() {
        $.ajax({
            type: "POST",
            url: $('#btn-filter').attr('data-href'),
            //async: false,
            data: {
                itemFilters : data_filter.itemFilters ,
                searchText :$('#itemSearchName').val().trim(),
                filterId: data_filter.filterId
            },
            success: function (response) {
                response = $.parseJSON(response);
                //render  table
                render(response.callBackTable, response.dataTables);
                // render toan bo id của dữ liệu
                $("input#itemTagAllIds").val(response.totalIds);
                //render nhãn lọc
                data_filter.tagFilters = response.tagFilters == null ? data_filter.tagFilters : response.tagFilters;

                render(response.callBackTagFilter, data_filter.tagFilters);
                $('#liFilter_' + data_filter.filterId).addClass('active');
                updateStatusBtnSaveFilter();
                updateStatusBtnRemoFilter();

                //render paginate
                if(paginateObject == null){
                    paginateObject = $('#table-data').Paginate({
                        page: response.page,
                        pageSize: response.pageSize,
                        totalRow: response.totalRow,
                        itemName: config.ItemName
                    });
                }
                else{
                    paginateObject.Paginate({
                        page: response.page,
                        pageSize: response.pageSize,
                        totalRow: response.totalRow,
                        registerEvent : false,
                        itemName: config.ItemName
                    });
                }
            },
            error: function (response) {
                showNotification('Có lỗi xảy ra trong quá trình thực hiện', 0);
            }
        });
    }

    function resetIndex() {
        $('#container-filters').find('.item').each(function (key, val) {
            $(this).attr('data-index', key + 1);
        });
    }

    // Đăng ký sự kiện khi remove nhãn lọc
    $('#container-filters').on('click', '.item  button.remove', function () {
        //lấy đối tượng li
        var parent_item = $(this).parents('.item');
        var index = $(parent_item).attr('data-index');
        data_filter.itemFilters.splice(index - 1, 1);
        data_filter.tagFilters.splice(index - 1, 1);
        resetIndex();
        searchAjax();

    });
    if($('input.datepicker').length > 0){
        $('input.datepicker').datepicker({
            format: 'dd/mm/yyyy'
            //autoclose: true
        }).on('changeDate', function(ev){
            $(this).datepicker('hide');
            setTimeout(function(){
                $('#searchGroup').addClass('open');
            }, 10);
        });
    }
    // sự kiện thay đổi field select ẩn tất cả các trường không tương ứng đi và show các trường tương úng lên
    $('#field_select').change(function () {
        var field = $(this).val();
        $('input.'+field).val('');
        $(this).find('option').each(function (keyO, valO) {
            var elementClass = '.' + $(valO).val();
            if (elementClass != '.') {
                $(elementClass).removeClass('block-display').removeClass('none-display').addClass('none-display');
            }
        });
        $('.' + field).removeClass('none-display').addClass('block-display');
    });

    $('#select_operator_date').change(function () {
        var timeEnd = $('#timeEnd');
        if ($(this).val() == 'between') {
            $('#timeStart').attr('placeholder', 'Nhập thời gian bắt đầu');
            timeEnd.attr('placeholder', 'Nhập thời gian kết thúc');
            if (timeEnd.hasClass('none-display')) timeEnd.removeClass('none-display');
            timeEnd.addClass('block-display');
        }
        else {
            $('#timeStart').attr('placeholder', 'Nhập thời gian');
            if (timeEnd.hasClass('block-display')) timeEnd.removeClass('block-display');
            timeEnd.addClass('none-display');
        }
    });

    // đăng ký sự kiện khi thêm bộ lọc
    $('#btn-filter').click(function () {
        // tạo biến gen code html cho field
        //khởi tạo 1 đối tượng item filer
        var filter_ob = {};

        // lấy nhãn lọc
        var filed_name = $('#field_select').val();
        var text_field_name = $('#field_select').find('option:selected').text();

        // lấy tất cả các điều kiện lọc và giá trị của điều kiện lọc theo nhãn này
        var conds = [];

        //text_opertor  ví dụ : là ,trong khoảng ,trước, sau bằng ,.....
        var text_operator = '';
        var ob_text_operator = $('.' + filed_name).find('.text_opertor');
        if (typeof ob_text_operator != 'undefined ' && ob_text_operator.length > 0) {
            text_operator = " " + $(ob_text_operator).text();
        }
        else{
            ob_text_operator = $('.' + filed_name).find('select.value_operator');
            if (typeof ob_text_operator != 'undefined ' && ob_text_operator.length > 0) {
                text_operator = " " + $(ob_text_operator).find('option:selected').text();
            }
        }
        //giá trị của value_operator khi có text operator ví dụ : là tương úng với is,= | trong khoảng tương ứng với betweet , in tùy ý rồi sang bên server xử lý sau
        var ob_value_operator = $('.' + filed_name).find('.value_operator');
        if (typeof ob_value_operator != 'undefined ' && ob_value_operator.length > 0) {
            var value_operator = $(ob_value_operator).val();
            conds.push(value_operator);
        }
        var text_cond_name = '';
        //push điều kiện lọc và giá trị vào mảng đồng thơi gen html cho nhãn lọc
        $('.' + filed_name).each(function (key, val) {
            if (val.tagName == 'INPUT') {
                conds.push($(val).val());
                if($(val).attr('id') == 'timeEnd') text_cond_name += " đến " + $(val).val();
                else text_cond_name += " " + $(val).val();
            }
            else if (val.tagName == 'SELECT') {
                conds.push($(val).val());
                text_cond_name += " " + $(val).find('option:selected').text();
            }

        });
        //gắn các thuộc tính vào đối tượng item filter
        filter_ob.field_name = filed_name;
        filter_ob.conds = conds;
        filter_ob.tag = text_field_name + text_operator + text_cond_name;

        var replace = false;
        var matches = true;
        var val;
        var key;
        //kiểm tra item lọc này có trùng nhau không
        if (data_filter.itemFilters != null) {
            for (var i = 0; i < data_filter.itemFilters.length; i++) {
                val = data_filter.itemFilters[i];
                //nếu 2 nhãn lọc giống nhau
                if (filter_ob.field_name == val.field_name) {
                    var cond_matches = 0;
                    for (var cond = 0; cond < val.conds.length; cond++) {
                        if (val.conds[cond] == filter_ob.conds[cond]) cond_matches++;
                        else break;
                    }
                    if (cond_matches == val.conds.length) {
                        //showNotification('Điều kiện lọc đã có', 0);
                        return;
                    }
                    // nếu điều kiện lọc mà giống nhau thì nhãn này sẽ bị thay thế
                    if (val.conds[0] == filter_ob.conds[0]) {
                        replace = true;
                        key = i;
                    }
                }
            }
            if(replace){
                for (var i = 1; i < val.conds.length; i++) data_filter.itemFilters[key].conds[i] = filter_ob.conds[i]; //thay thế đối tượng tronmang itemFilters
                data_filter.tagFilters[key] = filter_ob.tag;
                searchAjax();

            }
            else {
                //thêm 1 đối item filter vào itemFilters
                data_filter.itemFilters.push(filter_ob);
                data_filter.tagFilters.push(filter_ob.tag);
                searchAjax();
            }
            //$("input#filterData").val(JSON.stringify(data_filter.itemFilters));
            //$("input#tagFilter").val(JSON.stringify(data_filter.tagFilters));
        }
    });


    //-------------------------------------------- Thiết kế việc lưu  bộ lọc --------------------------------///
    $.fn.ModalSaveFilter = function () {
        var root = this;

        var actions = {
            init: function () {},
            save: function () {}
        };
        actions.init = function () {
            root.find('input.iCheck').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%'
            });
            root.find('input.iCheck').on('ifToggled', function(e){
                if(e.currentTarget.checked){
                    var input_name_new = $(root).find('#input-name-new');
                    var input_name_exit = $(root).find('#input-name-exits');
                    if(e.currentTarget.value == '0'){
                        if ($(input_name_new).hasClass('none-display')) $(input_name_new).removeClass('none-display');
                        $(input_name_new).addClass('block-display');
                        if ($(input_name_exit).hasClass('block-display')) $(input_name_exit).removeClass('block-display');
                        $(input_name_exit).addClass('none-display');
                    }
                    else{
                        if ($(input_name_new).hasClass('block-display')) $(input_name_new).removeClass('block-display');
                        $(input_name_new).addClass('none-display');
                        if ($(input_name_exit).hasClass('none-display')) $(input_name_exit).removeClass('none-display');
                        $(input_name_exit).addClass('block-display');
                    }
                }
            });
            $(root).find('#btn-save-filter').click(function () {
                actions.save();
            });
        };

        actions.save = function () {
            var filterId = 0;
            var filterName = '';
            var displayOrder = 0;
            if ($(root).find('#input-name-exits').hasClass('none-display')) {
                filterName = $(root).find('#new-save-name').val().trim();
                displayOrder = ($("#ulFilter .liFilter").length) +1;
                if (filterName == '') {
                    showNotification('Vui lòng nhập tên bộ lọc', 0);
                    return false;
                }
            }
            else {
                filterId = parseInt($(root).find('select#filter_list_name').val());
                if (filterId == 0) {
                    showNotification('Vui lòng chọn tên muốn ghi đè', 0);
                    return false;
                }
                filterName = $("input#filterName").val().trim();
                if(filterName == ""){
                    showNotification('Vui lòng điền tên muốn ghi đè', 0);
                    return false;
                }
                displayOrder = $('#btn-save-filter').attr('display-order');
            }
            var btn = $(root).find('#btn-save-filter');
            btn.prop('disabled', true);
            $.ajax({
                type: "POST",
                url: btn.attr('data-href'),
                //async: false,
                data: {
                    FilterId: filterId,
                    FilterName: filterName,
                    FilterData: JSON.stringify(data_filter.itemFilters),
                    TagFilter: JSON.stringify(data_filter.tagFilters),
                    ItemTypeId: $('#itemTypeId').val(),
                    DisplayOrder: displayOrder
                },
                success: function (response) {
                    var json = $.parseJSON(response);
                    showNotification(json.message, json.code);
                    if(json.code == 1){
                        $('#save-filter').modal('hide');
                        $('#ulFilter li.active').removeClass('active');
                        if(filterId == 0){ //add tab moi
                            filterId = json.data;
                            $('#ulFilter').append('<li class="active" id="liFilter_' + filterId + '"><a href="#tab_' + filterId + '" data-id="' + filterId + '" data-toggle="tab" aria-expanded="false">' + filterName + '</a></li>');
                            $(root).find('#filter_list_name').append('<option value="' + filterId + '">' + filterName + '</option>');
                        }
                        else{
                            var li = $('#liFilter_' + filterId);
                            li.addClass('active');
                            li.find('a').text(filterName);
                            $(root).find('#filter_list_name option[value="' + filterId + '"]').text(filterName);
                        }
                        bindFilter(filterId, config.ItemName);
                        $(root).find('#new-save-name').val('');
                        $(root).find('input#filterName').val('');
                    }
                    btn.prop('disabled', false);
                },
                error: function (response) {
                    showNotification('Có lỗi xảy ra trong quá trình thực hiện', 0);
                    btn.prop('disabled', false);
                }
            });
        };
        actions.init();
        return root;
    };

    $('#save-filter').ModalSaveFilter();
    //--------------------------------- Thiết kế xóa bộ lọc --------------------------//

    function deleteFilter() {
        $.ajax({
            type: "POST",
            url: $('#remove-filter').attr('data-href'),
            //async: false,
            data: {
                FilterId: data_filter.filterId
            },
            success: function (response) {
                var json = $.parseJSON(response);
                showNotification(json.message, json.code);
                if(json.code == 1){
                    $('#liFilter_' + data_filter.filterId).remove();
                    $('#liFilter_0').addClass('active');
                    bindFilter(0, config.ItemName);
                }
            },
            error: function (response) {
                showNotification('Có lỗi xảy ra trong quá trình thực hiện', 0);
            }
        });
    }

    $('#remove-filter').click(function () {
        swal({
            title: "Bạn có chắc muốn xóa bộ lọc này?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                deleteFilter();
            }
        });
        // if (confirm('Bạn có chắc muốn xóa bộ lọc này !')) deleteFilter();
    });
    // --------------------------- Thiết kế search ------------------------------- //
    var statusSearch = null;
    $('#itemSearchName').keydown(function () {
        var tab_search = $('#ulFilter').find('li#tab_search');
        //thêm tab search khi thực hiện việc search nếu chưa có thì thêm mới vào
        if(tab_search.length == 0){
            $('#ulFilter').find('li.active').removeClass('active');
            data_filter.itemFilters = [];
            data_filter.tagFilters = [];
            // var html= '<li id="tab_search" class="active"><a href="javascript:;" data-id="-1" data-toggle="tab" aria-expanded="true">Tùy chọn</li>';
            // $('#ulFilter').append(html);
        }

        if (statusSearch != null) {
            clearTimeout(statusSearch);
            statusSearch = null;
        }

    });

    $('#itemSearchName').keyup(function () {
        if (statusSearch == null) {
            statusSearch = setTimeout(function () {
                searchAjax();
            }, 500);
        }
    });


//vì mỗi table lại có kiểu gen html khác nhau nên không thể gôp chung lại được
//call_back là 1 tên của funtion thực hiện việc render html cho table bằng dữ liệu data_table
//call_back được gửi xuống từ server khi thực hiện ajax nên call_back phải được định nghĩa global bên js trước khi server trả xuống

}
//data table paginate
$.fn.Paginate = function (opt) {
    var root = this;
    var conf = $.extend({pageShow: 11, page: 1, pageSize: 1, totalRow: 11,registerEvent: true}, opt);
    var actions = {
        init: function () {},
        render: function () {},
        event: function () {}
    };

    actions.init = function () {
        conf.page = parseInt(conf.page);
        conf.pageShow = parseInt(conf.pageShow);
        conf.pageSize = parseInt(conf.pageSize);
        conf.totalRow = parseInt(conf.totalRow);
    };

    actions.render = function () {
        $('.paginate_table').children().remove();
        if(conf.pageSize == 1) {
            html = '<div class="up-n-pager"><div class="total-row"><span>' + conf.totalRow + '</span> ' + conf.itemName + '</div></div>';
            $(root).find('.paginate_table').html(html);
            return false;
        }
        var html = "<ul>{first_page}{prev_page}{pages}{next_page}{last_page}</ul>";
        var first_page = '<li><a class="{option} first-page" data-page="1" href="javascript:;">Trang đầu</a></li>';
        var last_page = '<li><a class="{option} last-page" data-page="' + conf.pageSize + '" href="javascript:;">Trang Cuối</a></li>';
        var prev_page = '<li><a class="{option}" data-page="' + (conf.page - 1 > 0 ? conf.page - 1 : 1 ) + '" href="javascript:;"><<</a></li>';
        var next_page = '<li><a class="{option}" data-page="' + (conf.page + 1 < conf.pageSize ? conf.page + 1 : conf.pageSize ) + '" href="javascript:;">>></a></li>';
        var start_page = 1;
        var end_page = 1;
        var offset = Math.floor(conf.pageShow / 2);
        if (conf.pageSize <= conf.pageShow) {
            start_page = 1;
            end_page = conf.pageSize;
            html = html.replace(/\{[a-z_]{6,}\}|/img, '');
        }
        else {
            // page ở khoảng giữa
            if (conf.page > offset && conf.pageSize > conf.page + offset) {
                start_page = conf.page - offset;
                end_page = conf.page + offset;
                // page ở cuối
            }
            else if (conf.page == conf.pageSize) {
                start_page = conf.pageSize - conf.pageShow + 1;
                end_page = conf.pageSize;
                next_page = next_page.replace('{option}', ' disable');
                last_page = last_page.replace('{option}', ' disable');
                //page ở đầu
            }
            else if (conf.page === 1) {
                start_page = 1;
                end_page = conf.pageShow;
                first_page = first_page.replace('{option}', ' disable');
                prev_page = prev_page.replace('{option}', ' disable');

                //page nhỏ hơn số hiển thị
            }
            else if (conf.page <= conf.pageShow) {
                start_page = 1;
                end_page = conf.pageShow;

                //page lớn hơn số hiển thị conf.page > conf.pageShow
            }
            else {
                start_page = conf.pageSize - conf.pageShow + 1;
                end_page = conf.pageSize;
            }
            next_page = next_page.replace('{option}', '');
            last_page = last_page.replace('{option}', '');
            prev_page = prev_page.replace('{option}', '');
            first_page = first_page.replace('{option}', '');
        }
        var pages = "";
        for (var page = start_page; page <= end_page; page++) {
            var row = '<li>';
            row += '<a class="{option}" data-page="' + page + '" href="javascript:;">' + page + '</a>';
            row += '</li>';
            if (page == conf.page)
                row = row.replace('{option}', 'active disable none-event');
            else
                row = row.replace('{option}', '');
            pages += row;
        }
        html = '<div class="total-row"><span>' + conf.totalRow + '</span> ' + conf.itemName + '</div>' + html;
        html = '<div class="up-n-pager">' + html;
        html = html.replace('{pages}', pages).replace('{first_page}', first_page).replace('{prev_page}', prev_page).replace('{next_page}', next_page).replace('{last_page}', last_page);
        html += '</div>';
        $(root).find('.paginate_table').html(html);
    };
    actions.event = function () {
        // bắt sự kiện chuyển trang của table khi phân trang
        $(root).on('click', '.paginate_table a', function (e) {
            //var active_event = $(this).attr('class').indexOf('disable') > -1 ? false : true;
            //if (active_event) {
            if(!$(this).hasClass('disable')){
                data_filter.page = $(this).attr('data-page');
                var data = {
                    itemFilters : data_filter.itemFilters,
                    page : data_filter.page,
                    searchText : $('#itemSearchName').val().trim()
                };
                $.ajax({
                    type: "POST",
                    url: $('#btn-filter').attr('data-href'),
                    //async: false,
                    data: data,
                    success: function (response) {
                        //console.log(data_filter.itemFilters);
                        response = $.parseJSON(response);
                        //render  table
                        render(response.callBackTable, response.dataTables);

                        //render paginate table
                        conf.page = parseInt(response.page);
                        conf.pageSize = parseInt(response.pageSize);
                        conf.totalRow = parseInt(response.totalRow);
                        actions.render();
                    },
                    error: function (response) {
                        showNotification('Có lỗi xảy ra trong quá trình thực hiện', 0);
                    }
                });
            }
            return false;
        });

    };
    actions.init();
    actions.render();
    if(conf.registerEvent)
        actions.event();

    return root;
};
function renderTagFilter(data) {
    var html = '';
    for (var i = 0; i < data.length; i++) {
        html += '<li class="item" data-index="' + (i + 1) + '">'
            + '<button class="btn btn-field">' + data[i] + '</button>'
            + '<button class="btn remove">'
            + '<i class="fa fa-times font-size-12px type-subdued "></i>'
            + '</button >'
            + '</li>';
    }
    $('#container-filters').html(html);

}
function render(call_back, data) {
    window[call_back](data);
}