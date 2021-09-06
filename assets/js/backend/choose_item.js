function chooseProduct(fnChooseProduct){
    var panelProduct = $('#panelProduct');
    var pageIdProduct = $('input#pageIdProduct');
    $(document).on('click','.open-search',function(){
        panelProduct.removeClass('active');
        $('.wrapper').removeClass('open-search');

    }).on('click', '.panel-default.active', function(e) {
        e.stopPropagation();
    });
    var statusSearch = null;
    $('#txtSearchProduct').click(function(){
        if(panelProduct.hasClass('active')){
            panelProduct.removeClass('active');
            panelProduct.find('.panel-body').css("width", "99%");
        }
        else{
            panelProduct.addClass('active');
            $('.wrapper').removeClass('open-search');
            setTimeout(function (){
                panelProduct.find('.panel-body').css("width", "100%");
                $('.wrapper').addClass('open-search');
            }, 100);
            pageIdProduct.val('1');
            getListProducts();
        }
    }).keydown(function () {
        if (statusSearch != null) {
            clearTimeout(statusSearch);
            statusSearch = null;
        }
    }).keyup(function () {
        if (statusSearch == null) {
            statusSearch = setTimeout(function () {
                if(!panelProduct.hasClass('active')){
                    panelProduct.addClass('active');
                    setTimeout(function (){
                        panelProduct.find('.panel-body').css("width", "100%");
                        $('.wrapper').addClass('open-search');
                    }, 100);
                }
                pageIdProduct.val('1');
                getListProducts();
            }, 500);
        }
    });
    $('select#productTypeId').change(function(){
        pageIdProduct.val('1');
        getListProducts();
    });
    $('#btnPrevProduct').click(function(){
        var pageId = parseInt(pageIdProduct.val());
        if(pageIdProduct > 1){
            pageIdProduct.val(pageId - 1);
            getListProducts();
        }
    });
    $('#btnNextProduct').click(function(){
        var pageId = parseInt(pageIdProduct.val());
        pageIdProduct.val(pageId + 1);
        getListProducts();
    });
    $('#tbodyProductSearch').on('click', 'tr', function () {
        panelProduct.removeClass('active');
        panelProduct.find('.panel-body').css("width", "99%");
        $('#txtSearchProduct').val('');
        $('select#productTypeId').val('0');
        pageIdProduct.val('1');
        fnChooseProduct($(this));
    });
}

function getListProducts(){
    var loading = $('#panelProduct .search-loading');
    loading.show();
    $('#tbodyProductSearch').html('');
    $.ajax({
        type: "POST",
        url: $('input#getListProductUrl').val(),
        data: {
            SearchText: $('input#txtSearchProduct').val().trim(),
            ProductTypeId: $('select#productTypeId').val(),
            PageId: parseInt($('input#pageIdProduct').val()),
            Limit: 10
        },
        success: function (response) {
            var json = $.parseJSON(response);
            if (json.code == 1){
                loading.hide();
                var data = json.data;
                var html = '';
                var i, j;
                var productPath = $('input#productPath').val();
                var noImage = 'no_image.jpg';
                for(i = 0; i < data.length; i++){
                    html += '<tr class="pProduct" data-id="' + data[i].ProductId + '"> ';
                    html += '<td><img width="60px" src="' + productPath + (data[i].ProductImage == '' ? noImage : data[i].ProductImage) + '" class="productImg"></td>';
                    html += '<td class="productName">' + data[i].ProductName + '</td>';
                    html += '<td>' + data[i].Quantity + '</td>';
                    html += '<td>' + formatDecimal(data[i].Price.toString()) + '</td>';
                }
                $('#tbodyProductSearch').html(html);
                $('#panelProduct .panel-body').slimScroll({
                    height: '300px',
                    alwaysVisible: true,
                    wheelStep: 20,
                    touchScrollStep: 500
                });
            }
            else loading.text('Có lỗi xảy ra').show();
        },
        error: function (response) {
            loading.text('Có lỗi xảy ra').show();
        }
    });
}
