$(document).ready(function () {
    $( "#formLogin" ).submit(function( e ) {
        e.preventDefault();
        alert('a');
    });
});

function renderProductType() {
    let categoryId = $('#categoryId').val();
    if (categoryId > 0) {
        $.ajax({
            type: 'POST',
            url: $('#getProductTypeByCategoryUrl').val(),
            data: {
                CategoryId: categoryId
            },
            success: function (response) {
                let json = $.parseJSON(response);
                if (json.code == 1) {
                    let html = genSelectHtml(json.data);
                    $('.productTypeId').html(html);
                    $('.select2').select2();
                } else showNotification(json.message, json.code);
            },
            error: function () {
                showNotification($('#errorCommonMessage').val(), 0);
            }
        });
    }
}