$(window).ready(() => {
  // Show modal login/signup success reset password
  $("#signupSucess").modal("show");
  $("#signinSuccessResetPassModal").modal("show");
  $("#profileChangePassModal").modal("show");
  $("#joinModal").modal("show");
  $("#eventModal").modal("show");
  $("#eventCancelModal").modal("show");
  $("#reservationModal").modal("show");
  $('.btn-getnow').click(function(){
    $("#savedCouponModal").modal("show");
    
})
  // Init carousel customer home service
  $(".owl-customer-service").owlCarousel({
    loop: true,
    margin: 60,
    responsiveClass: true,
    autoplay: true,
    autoplayTimeout: 6000,
    autoplayHoverPause: true,
    nav: true,
    navText: [
      '<img src="assets/img/frontend/icon-left.png">',
      '<img src="assets/img/frontend/icon-right.png">',
    ],
    responsive: {
      0: {
        items: 2,
        margin: 16,
      },
      768: {
        items: 2,
        margin: 20,
      },
      1000: {
        items: 3,
      },
      1366: {
        items: 4,
      },
    },
  });

  // Init carousel customer home service
  $(".owl-coupon").owlCarousel({
    loop: true,
    margin: 16,
    autoplay: true,
    autoplayTimeout: 5000,
    autoplayHoverPause: true,
    responsiveClass: true,
    nav: true,
    navText: [
      '<img src="assets/img/frontend/icon-left.png">',
      '<img src="assets/img/frontend/icon-right.png">',
    ],
    responsive: {
      0: {
        items: 1,
        margin: 16,
      },
      768: {
        items: 2,
      },
      1000: {
        items: 3,
      },
    },
  });

  // Play video when click icon
  $(".js-play-video").each(function() {
    $(this).on("click", function(e) {
      e.preventDefault();
      $(this).next().trigger("play");
      $(this).next().attr("controls", true);
      $(this).addClass("d-none");
    });
  });

  $(".js-video").each(function() {
    $(this).on("ended", function() {
      $(this).trigger("pause");
      $(this).removeAttr("controls");
      $(this).prev().removeClass("d-none");
    });
  });

  // Init bootstrap datetime picker
  $("#datetimepickerEvent").datetimepicker({
    format: "MMMM DD, YYYY",
    // collapse: true,
    allowInputToggle: true,
    // inline: true,
    // debug: true,
    // allowMultidate: true,
    // multidateSeparator: ',',
    icons: {
      time: "",
      date: "fa fa-calendar",
      up: "fa fa-arrow-up",
      down: "fa fa-arrow-down",
      previous: "far fa-chevron-left",
      next: "far fa-chevron-right",
      today: "far fa-calendar-check-o",
    },
  });

  // Init datepicker
  $(".js-datepicker").datetimepicker({
    format: "MMMM DD, YYYY",
    allowInputToggle: true,
    // inline: true,
    // debug: true,
    // allowMultidate: true,
    // multidateSeparator: ',',
    icons: {
      time: "bi bi-clock",
      date: "bi bi-calendar2-check-fillr",
      up: "bi bi-chevron-up",
      down: "bi bi-chevron-down",
      previous: "bi bi-chevron-left",
      next: "bi bi-chevron-right",
    },
  });

  // Init timepicker
  $(".js-time-picker").datetimepicker({
    format: "HH:mm",
    allowInputToggle: true,
    // debug: true,
    icons: {
      time: "bi bi-clock",
      date: "bi bi-calendar2-check-fill",
      up: "bi bi-chevron-up",
      down: "bi bi-chevron-down",
    },
  });

  // Upload profile picture
  let readURL = function (input) {
    if (input.files && input.files[0]) {
      let reader = new FileReader();

      reader.onload = function (e) {
        $(".js-profile-pic").attr("src", e.target.result);
      };

      reader.readAsDataURL(input.files[0]);
    }
  };

  $(".js-profile-upload").on("change", function () {
    readURL(this);
  });

  $(".js-profile-upload-btn, .general-icon").on("click", function () {
    $(".js-profile-upload").click();
  });

  // Toggle show/hide password
  $(".icon-show-pass").on("click", function () {
    $(this).each(function () {
      if ($(this).parent().find("input").attr("type") === "password") {
        $(this).parent().find("input").attr("type", "text");
      } else {
        $(this).parent().find("input").attr("type", "password");
      }
    });
  });

  // Dropdown language
  $(".js-list-language li").each(function () {
    $(this).click(function (e) {
      e.preventDefault();
      $(".js-list-language li").removeClass("selected");
      const value = $(this).find("a").attr("value");
      const imgSrc = $(this).find("img").attr("src");

      $(this).addClass("selected");

      if (imgSrc) {
        $("#languageDropdown").find("img").attr("src", imgSrc);
      }
      if (value) {
        $("#languageDropdown").attr("value", value);
      }

      console.log($(this).find("a").attr("value"));
      console.log($(this).find("img").attr("src"));
    });
  });

  // Dropdown country code
  $(".js-list-country li").each(function () {
    $(this).click(function (e) {
      e.preventDefault();
      $(".js-list-country li").removeClass("selected");
      const countryText = $(this).find(".country-text").text();
      const countryCode = $(this).find(".country-code").text();
      const imgSrc = $(this).find("img").attr("src");

      $(this).addClass("selected");

      if (imgSrc) {
        $(".js-country").find("img").attr("src", imgSrc);
      }
      if (countryText) {
        $(".js-country").find('.country-text').text(countryText);
      }
      if (countryCode) {
        $(".js-country").find('.country-code').text(countryCode);
      }

      console.log($(this).find("a").attr("value"));
      console.log($(this).find("img").attr("src"));
    });
  });

  // Custom Select option
  $(".custom-select").niceSelect();

  // CK Editor
  // ClassicEditor.create(document.querySelector("#editor"), {
  //   toolbar: ["uploadImage", "heading"],
  //   // extraPlugins: 'imageuploader',
  // }).catch((error) => {
  //   console.error(error);
  // });

  // Quantity input
  var input = $(".quantity"),
    minValue = parseInt(input.attr("min")),
    maxValue = parseInt(input.attr("max"));
  $(".plus").click(function () {
    if ($(this).prev().val() < maxValue) {
      $(this)
        .prev()
        .val(+$(this).prev().val() + 1);
    }
  });
  $(".minus").click(function () {
    if ($(this).next().val() > minValue) {
      if ($(this).next().val() > 1)
        $(this)
          .next()
          .val(+$(this).next().val() - 1);
    }
  });
});

if($('#map').length > 0){
  let map;
  function initMap() {
    map = new google.maps.Map(document.getElementById("map"), {
      center: new google.maps.LatLng(-33.91722, 151.23064),
      zoom: 16,
    });
  
    const iconBase =
      "assets/img/frontend/";
    const icons = {
      iconMap: {
        icon: iconBase + "iconmap.png",
      },
    };

    const features = [
      {
        position: new google.maps.LatLng(-33.91662347903106, 151.22879464019775),
        type: "iconMap",
        imgiInfo:'assets/img/frontend/home-location1.svg',
        linkInfo:'',
        titleInfo:'VELTA Free Shop',
        starInfo:5,
        evaluateInfo:3,
        linkClose:'#',
        linkLocation:'#',
        linkView:'#',
      },
      {
        position: new google.maps.LatLng(-33.916365282092855, 151.22937399734496),
        type: "iconMap",
        imgiInfo:'assets/img/frontend/home-location1.svg',
        linkInfo:'',
        titleInfo:'33333',
        starInfo:1,
        evaluateInfo:3,
        linkClose:'',
        linkLocation:'',
        linkView:'',
      },
      {
        position: new google.maps.LatLng(-33.91665018901448, 151.2282474695587),
        type: "iconMap",
        imgiInfo:'assets/img/frontend/home-location1.svg',
        linkInfo:'',
        titleInfo:'21212313',
        starInfo:0,
        evaluateInfo:3,
        linkClose:'',
        linkLocation:'',
        linkView:'',
      },
      {
        position: new google.maps.LatLng(-33.919543720969806, 151.23112279762267),
        type: "iconMap",
        imgiInfo:'assets/img/frontend/home-location1.svg',
        linkInfo:'',
        titleInfo:'Khai Lam - Vietnamese Traditional Restaurant',
        starInfo:4,
        evaluateInfo:3,
        linkClose:'',
        linkLocation:'',
        linkView:'',
      },
      {
        position: new google.maps.LatLng(-33.91608037421864, 151.23288232673644),
        type: "iconMap",
        imgiInfo:'assets/img/frontend/home-location1.svg',
        linkInfo:'',
        titleInfo:'Khai Lam ',
        starInfo:3,
        evaluateInfo:3,
        linkClose:'',
        linkLocation:'',
        linkView:'',
      },
      {
        position: new google.maps.LatLng(-33.91851096391805, 151.2344058214569),
        type: "iconMap",
        imgiInfo:'assets/img/frontend/home-location1.svg',
        linkInfo:'',
        titleInfo:'Vietnamese Traditional Restaurant',
        starInfo:3,
        evaluateInfo:3,
        linkClose:'',
        linkLocation:'',
        linkView:'',
      },
      {
        position: new google.maps.LatLng(-33.91818154739766, 151.2346203981781),
        type: "iconMap",
        imgiInfo:'assets/img/frontend/home-location1.svg',
        linkInfo:'',
        titleInfo:'21212313',
        starInfo:3,
        evaluateInfo:3,
        linkClose:'',
        linkLocation:'',
        linkView:'',
      },
    ];
    // Create markers.
    for (let i = 0; i < features.length; i++) {
      var rank = ``;
    if(features[i].starInfo === 0) {
      var rank = `
      <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star"></i></a></li>
      <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star"></i></a></li>
      <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star"></i></a></li>
      <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star"></i></a></li>
      <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star"></i></a></li>
      `;
    }
    else if(features[i].starInfo === 1) {
      var rank = `
      <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star-fill"></i></a></li>
      <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star"></i></a></li>
      <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star"></i></a></li>
      <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star"></i></a></li>
      <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star"></i></a></li>
      `;
    }
    else if(features[i].starInfo === 2) {
      var rank = `
      <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star-fill"></i></a></li>
      <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star-fill"></i></a></li>
      <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star"></i></a></li>
      <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star"></i></a></li>
      <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star"></i></a></li>
      `;
    }
    else if(features[i].starInfo === 3) {
      var rank = `
      <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star-fill"></i></a></li>
      <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star-fill"></i></a></li>
      <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star-fill"></i></a></li>
      <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star"></i></a></li>
      <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star"></i></a></li>
      `;
    }
    else if(features[i].starInfo === 4) {
      var rank = `
      <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star-fill"></i></a></li>
      <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star-fill"></i></a></li>
      <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star-fill"></i></a></li>
      <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star-fill"></i></a></li>
      <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star"></i></a></li>
      `;
    }
    else if(features[i].starInfo === 5) {
      var rank = `
      <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star-fill"></i></a></li>
      <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star-fill"></i></a></li>
      <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star-fill"></i></a></li>
      <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star-fill"></i></a></li>
      <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star-fill"></i></a></li>
      `;
    }
      const infoMap = `<div class="card rounded-0 customer-location-item mb-2">
      <div class="row g-0">
          <div class="col-3">
              <a href="#" class="customer-location-img"><img
                      src="${features[i].imgiInfo}" class="img-fluid"
                      alt="location image"></a>
          </div>
          <div class="col-9">
              <div class="card-body p-0 ml-2">
                  <h6 class="card-title mb-1 page-text-xs"><a href="${features[i].linkInfo}" title="">${features[i].titleInfo}</a></h6>
                  <ul class="list-inline mb-2 list-rating-sm">
                    ${rank}
                      <li class="list-inline-item me-0">(${features[i].evaluateInfo})</li>
                  </ul>
                  <p class="card-text mb-0 page-text-xxs text-secondary">Restaurants</p>
                  <a href="${features[i].linkClose}" class="customer-location-close">Closed</a>
                  <a href="${features[i].linkLocation}"><img src="assets/img/frontend/IconButton.png" class="img-fluid customer-location-icon" alt="location image"></a>
                  <a href="${features[i].linkView}" class="btn btn-outline-red btn-outline-red-xs btn-view">View</a>
              </div>
          </div>
      </div>
  </div>`;
      const infowindow = new google.maps.InfoWindow({
        content: infoMap,
      });
      const marker = new google.maps.Marker({
        position: features[i].position,
        icon: icons[features[i].type].icon,
        map: map,
      });
      marker.addListener("click", () => {
        infowindow.open({
          anchor: marker,
          map,
          shouldFocus: false,
        });
      });
    }
  }
}

if($('#calendar').length > 0){
  document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
      headerToolbar: {
        left: 'prev',
        center: 'title',
        right: 'next'
      },
      // initialDate: '2021-09-12',
      navLinks: false, 
      businessHours: false, 
      editable: false,
      selectable: false,
      events: [
        {
          start: '2021-09-03',
          constraint: '',
          color: '#C20000'
        },
        {
          start: '2021-09-13',
          constraint: '', 
          color: '#C20000'
        },
      ],
      dateClick: function(info) {
        console.log(info.dateStr);
      }
    });

    calendar.render();
  });
}

if($('.fancy').length > 0) {
	$('.fancy').fancybox({
    loop    : false,
    arrows  : true,
    infobar : true,
    buttons : [
      'arrowLeft',
      'arrowRight',
      'close'
    ],
    thumbs : {
      hideOnClose : true,
      autoStart : true,
      axis : 'x'
    },
    caption : function(instance, item) {
      return $(this).attr('data-id');
    },
    
	});
}

$(window).scroll(function(event) {
  var hei = $('.page-header').height();
  if ($(window).width()>1200) {
    if ($(window).scrollTop()>0) {
      $('.page-header').addClass('fixed');

    }
    else{
      $('.page-header').removeClass('fixed');
    }
  }
  else{
    if ($(window).scrollTop()>0) {
      $('.page-header').addClass('fixed');

    }
    else{
      $('.page-header').removeClass('fixed');
    }
  }
});

$(document).on('click', '.input-eye', function(event) {
  event.stopPropagation();
  if ($(this).prev('input').attr('type') == "text") {
    $(this).prev('input').attr('type','password');
  } else {
  $(this).prev('input').attr('type','text');
  }
}).on('keyup', '.signup-form .signup-form-list .inputPassword', function(event) {
  event.stopPropagation();
  var password = $(this).val();
  checkPass(password,$(this))
}).on('blur', '.signup-form .signup-form-list .inputPassword', function(event) {
  $(this).parent().find('.tooltip-signup').hide();
}).on('click', '.signup-form .signup-form-list .inputPassword', function(event) {
  var password = $(this).val();
  checkPass(password,$(this))
});
function checkPass(password,$this){
  var strength = 0  
  if (password.length > 7) strength += 1  
  if (password.match(/([a-z].*[A-Z])|([A-Z].*[a-z])/)) strength += 1  
  if (password.match(/([a-zA-Z])/) && password.match(/([0-9])/)) strength += 1 
  if (strength < 3) {
    $this.parent().find('.tooltip-signup').show();
  }
  else{
    $this.parent().find('.tooltip-signup').hide();
    
  }
}
