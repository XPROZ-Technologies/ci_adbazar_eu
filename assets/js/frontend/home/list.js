
    

$(document).ready(function() {
    console.log(textView);
    $("#profilePagging").html('');
    $(".customer-location-list").html('');
    var current_page = 1;
    var records_per_page = 4;
    var searchText = $("input#search_text").val();
    loadProfile($("select#selectServiceMap").val(), searchText, current_page, records_per_page, textView);

    $("body").on('click', 'a.page-link-click', function() {
        var page = parseInt($(this).attr('data-page'));
        searchText = $("input#search_text").val();
        loadProfile($("select#selectServiceMap").val(), searchText, page, records_per_page, textView)
    }).on("click", ".customer-location-dropdown li.option", function(){
        var selectServiceMapId = $(this).data('value');
        searchText = $("input#search_text").val();
        loadProfile(selectServiceMapId, searchText, current_page, records_per_page, textView)
    }).on('keyup', 'input#search_text', function() {
        setTimeout(function(){ 
            searchText = $("input#search_text").val();
            loadProfile($("select#selectServiceMap").val(), searchText.trim(), current_page, records_per_page, textView)
        }, 1000);
    });
});

let map;

    function initMap() {
      map = new google.maps.Map(document.getElementById("map"), {
        center: new google.maps.LatLng(50.047648687939635, 12.355822100555436),
        zoom: 16,
      });
    
    }
function loadProfile(service_id, search_text_fe, page, per_page, textView) {
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
                let markers = [];
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
                    
                    var starHtml = '';
                    var rating = item.rating;
                    if(parseInt(rating.sumReview) > 0){
                        starHtml = `<div class="star-rating on line  mr-8px relative"> 
                            <div class="star-base">
                            <div class="star-rate" data-rate="${rating.overall_rating}"></div> 
                            <a dt-value="1" href="#1"></a> 
                            <a dt-value="2" href="#2"></a> 
                            <a dt-value="3" href="#3"></a> 
                            <a dt-value="4" href="#4"></a> 
                            <a dt-value="5" href="#5"></a>
                            </div>
                        </div>
                        <span class="star-rating-number">(${rating.sumReview})</span>`;
                    }
                    
                    
                    
                    html += 
                    `<div class="card rounded-0 customer-location-item mb-2">
                        <div class="row g-0">
                            <div class="col-3">
                                <a href="${urlProfileBusiness+item.business_url}" class="customer-location-img">
                                <img src="${pathProfileBusiness+item.business_avatar}" class="img-fluid" alt="${item.business_name}" style="height: 70px;object-fit: contain;"></a>
                            </div>
                            <div class="col-9">
                                <div class="card-body p-0">
                                    <h6 class="card-title mb-1 page-text-xs"><a href="${urlProfileBusiness+item.business_url}" title="">${item.business_name}</a></h6>
                                    <div class="d-flex align-items-center mb-5px"> 
                                        ${starHtml}
                                    </div>
                                    <p class="card-text mb-0 page-text-xxs text-secondary">${htmlBusiness.replace(/, *$/, "")}</p>
                                    ${isOpen}
                                    <a href="${urlProfileBusiness+item.business_url}" class="btn btn-outline-red btn-outline-red-xs btn-view">${textView}</a>
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
                starRate();
                
                var listProfilesMap = json.listProfilesMap;

//var infowindow = null;
jQuery(function() {
        var StartLatLng = new google.maps.LatLng(50.047648687939635, 12.355822100555436);
        var mapOptions = {
            center: StartLatLng,
            zoom: 16,
        };

    var map = new google.maps.Map(document.getElementById('map'), mapOptions);

    
        
    jQuery.each( listProfilesMap, function(i, item) {

        var infowindow = new google.maps.InfoWindow({
            content: ''
        });

        item.servicetypes = '';
        item.linkInfo = '';
        item.evaluateInfo = 10;
        var starInfo = 5;
                    

                        var rank = `
                                <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star"></i></a></li>
                                <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star"></i></a></li>
                                <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star"></i></a></li>
                                <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star"></i></a></li>
                                <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star"></i></a></li>
                            `;
                        // starInfo lấy trong db ra, hiện tại chưa làm
                        if (starInfo == 1) {
                            rank = `
                                <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star-fill"></i></a></li>
                                <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star"></i></a></li>
                                <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star"></i></a></li>
                                <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star"></i></a></li>
                                <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star"></i></a></li>
                                `;
                        } else if (starInfo == 2) {
                            rank = `
                                <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star-fill"></i></a></li>
                                <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star-fill"></i></a></li>
                                <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star"></i></a></li>
                                <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star"></i></a></li>
                                <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star"></i></a></li>
                                `;
                        } else if (starInfo == 3) {
                            rank = `
                                <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star-fill"></i></a></li>
                                <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star-fill"></i></a></li>
                                <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star-fill"></i></a></li>
                                <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star"></i></a></li>
                                <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star"></i></a></li>
                                `;
                        } else if (starInfo == 4) {
                            rank = `
                                <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star-fill"></i></a></li>
                                <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star-fill"></i></a></li>
                                <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star-fill"></i></a></li>
                                <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star-fill"></i></a></li>
                                <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star"></i></a></li>
                                `;
                        } else if (starInfo == 5) {
                            rank = `
                            <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star-fill"></i></a></li>
                            <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star-fill"></i></a></li>
                            <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star-fill"></i></a></li>
                            <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star-fill"></i></a></li>
                            <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star-fill"></i></a></li>
                            `;
                        }
        var open_status = '<a href="javascript:void(0);" class="customer-location-close">Closed</a>';
        if (item.isOpen == true) {
            open_status = `<a href="javascript:void(0);" class="text-success">Opening</a>`;
        }

        var evaluate_info = "";
        if (item.evaluateInfo !== 0) {
            evaluate_info = `<li class="list-inline-item me-0">(${item.evaluateInfo})</li>`;
        }
        
        /*
        const infoMap = `<div class="card rounded-0 customer-location-item mb-2">
            <div class="row g-0">
                <div class="col-3">
                    <a href="#" class="customer-location-img"><img  src="assets/uploads/busines_profile/${item.business_avatar}" class="img-fluid" alt="location image" style="max-width: 100%; height: auto"></a>
                </div>
                <div class="col-9">
                    <div class="card-body p-0 ml-2">
                        <h6 class="card-title mb-1 page-text-xs"><a target="_blank" href="./${item.business_url}" title="">${item.business_name}</a></h6>
                        <ul class="list-inline mb-2 list-rating-sm">
                            ${rank}
                            ${evaluate_info}
                        </ul>
                        <p class="card-text mb-0 page-text-xxs text-secondary">${item.servicetypes}
                        </p>
                        ${open_status}
                        
                        <a target="_blank" href="./${item.business_url}"
                            class="btn btn-outline-red btn-outline-red-xs btn-view">View</a>
                    </div>
                </div>
            </div>
        </div>`;
        */
        const infoMap = `<h6 class="card-title mb-1 page-text-xs text-center"><a target="_blank" href="./${item.business_url}" title="">${item.business_name}</a></h6>`;

        var marker = new google.maps.Marker({
            position: new google.maps.LatLng(parseFloat(item.locationInfo.lat), parseFloat(item.locationInfo.lng)),
            map: map,
            icon: iconMap,
        });
        if(parseInt(service_id) != 0 || search_text_fe != ""){
            infowindow.setContent(infoMap);
            infowindow.open(map,marker);
        }
        
        //console.log(item)
        google.maps.event.addListener(marker, 'click', function() {
            infowindow.close();
            infowindow.setContent(infoMap);
            infowindow.open(map,marker);
        });

        /*
        // show map, open infoBox 
        google.maps.event.addListenerOnce(map, 'tilesloaded', function() {
            infowindow.open(map, marker);
        });
        */
    });
});
                
               
               
            }
        },
        error: function (response) {
        }
    });
    return false;
}

