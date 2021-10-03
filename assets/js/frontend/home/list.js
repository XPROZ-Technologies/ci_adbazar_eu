$(document).ready(function() {
    $("#profilePagging").html('');
    $(".customer-location-list").html('');
    var current_page = 1;
    var records_per_page = 4;
    loadProfile($("select#selectServiceMap").val(), $("input#search_text").val(), current_page, records_per_page);

    $("body").on('click', 'a.page-link-click', function() {
        var page = parseInt($(this).attr('data-page'));
        loadProfile($("select#selectServiceMap").val(), $("input#search_text").val(), page, records_per_page)
    }).on("click", ".customer-location-dropdown li.option", function(){
        var selectServiceMapId = $(this).data('value');
        loadProfile(selectServiceMapId, $("input#search_text").val(), current_page, records_per_page)
    }).on('keyup', 'input#search_text', function() {
        setTimeout(function(){ 
            var searchText = $("input#search_text").val();
            loadProfile($("select#selectServiceMap").val(), searchText, current_page, records_per_page)
        }, 1000);
    });
});

function loadProfile(service_id, search_text_fe, page, per_page) {
    $.ajax({
        type: "POST",
        url: $("input#urlGetListProfile").val(),
        data: {
            service_id: service_id,
            search_text: search_text_fe,
            page: page,
            per_page: per_page
        },
        success: function (response) {
            var json = $.parseJSON(response);
            $("#profilePagging").html('');
            $(".customer-location-list").html('');
            if(json.code == 1){
                var listProfiles = json.data;
                var html = '';
                var pathProfileBusiness = $("input#pathProfileBusiness").val();
                var urlProfileBusiness = $("input#urlProfileBusiness").val();
                for(var i = 0; i < listProfiles.length; i++) {
                    var item = listProfiles[i];
                    var businessServiceTypes = item.businessServiceTypes;
                    var htmlBusiness = '';
                    for(var y = 0; y < businessServiceTypes.length; y++) {
                        htmlBusiness += businessServiceTypes[y]['service_type_name']+', ';
                    }
                    var isOpen = '<a href="javascript:void(0)" class="text-success">Opening</a>';
                    if(!item.isOpen) isOpen = '<a href="javascript:void(0)" class="customer-location-close">Closed</a>';
                    html += 
                    `<div class="card rounded-0 customer-location-item mb-2">
                        <div class="row g-0">
                            <div class="col-3">
                                <a href="#" class="customer-location-img"><img src="${pathProfileBusiness+item.business_avatar}" class="img-fluid" alt="${item.business_name}"></a>
                            </div>
                            <div class="col-9">
                                <div class="card-body p-0">
                                    <h6 class="card-title mb-1 page-text-xs"><a href="${urlProfileBusiness+item.business_url}" title="">${item.business_name}</a></h6>
                                    <p class="card-text mb-0 page-text-xxs text-secondary">${htmlBusiness.replace(/, *$/, "")}</p>
                                    ${isOpen}
                                    <a href="avascript:void(0)" class="btn btn-outline-red btn-outline-red-xs btn-view">View</a>
                                </div>
                            </div>
                        </div>
                    </div>`;
                }
                var pageCount = json.page_count;
                var page = json.page;
                if(listProfiles.length > 0) {
                    var retVal = '';
                    if (pageCount > 1) {
                        retVal = '<ul class="pagination justify-content-end mb-lg-0">';
                        if(page > 1) {
                            retVal += `<li class="page-item"><a class="page-link page-link-click" data-page="${page-1}" href="javascript:void(0)"><i class="bi bi-chevron-left"></i></a></li>`;
                            retVal += '<li class="page-item"><a class="page-link page-link-click " data-page="1" href="javascript:void(0)">1</a></li>';
                        } else retVal += '<li class="page-item active"><a class="page-link" href="javascript:void(0)">1</a></li>';
                        var start = (page > 1)? (page - 1) : 1;
                        if(start != 1) retVal +=  '<li class="page-item"><a class="page-link" href="javascript:void(0)">...</a></li>';
                        for(var i= start + 1; i <= page + 3 && i <= pageCount; i++){
                            if(i == page) retVal += `<li class="page-item active"><a class="page-link" href="javascript:void(0)">${i}</a></li>`;
                            else retVal += `<li class="page-item"><a class="page-link page-link-click " data-page="${i}" href="javascript:void(0)">${i}</a></li>`;
                        }
                        if(page + 3 < pageCount){
                            retVal += '<li class="page-item"><a class="page-link" href="javascript:void(0)">...</a></li>';
                            retVal += `<li class="page-item active"><a class="page-link page-link-click " data-page="${pageCount}" href="javascript:void(0)">${pageCount}</a></li>`;
                        }
                        if(page < pageCount) retVal += `<li class="page-item"><a class="page-link page-link-click " data-page="${page + 1}" href="avascript:void(0)"><i class="bi bi-chevron-right"></i></a></li>`;
                        retVal += '</ul>';
                    }
                    $("#profilePagging").html(retVal);
                }
                $(".customer-location-list").html(html);
            }
        },
        error: function (response) {
        }
    });
    return false;
}