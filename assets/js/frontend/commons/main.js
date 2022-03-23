$(window).ready(() => {
  // Show modal login/signup success reset password
  $("#signupSucess").modal("show");
  /*$("#signinSuccessResetPassModal").modal("show");*/
  $("#profileChangePassModal").modal("show");
  // $("#joinModal").modal("show");
  /*
    $("#eventModal").modal("show");
  */
  $("#eventCancelModal").modal("show");
  /*$("#reservationModal").modal("show");*/
  /*$("#bmCannotCreateModal").modal("show");*/
  /*$("#bmCouponAlertModal").modal("show"); */
  /*
  $('.btn-getnow').click(function(){
    $("#savedCouponModal").modal("show");
    
  });
  */
  /*
   // Init carousel customer home service
   $(".owl-customer-service").owlCarousel({
     loop: true,
     margin: 30,
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
         slideBy: 2
       },
       768: {
         items: 2,
         margin: 20,
         slideBy: 2
       },
       1000: {
         items: 3,
         slideBy: 3
       },
       1366: {
         items: 4,
         slideBy: 4
       },
     },
   });
   */

  /*
  // Init carousel customer home service
  var owl_coupon = $('.owl-coupon');
  owl_coupon.owlCarousel({
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
      1200: {
        items: 4,
      },
    },
  });
  */

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
  /*
  // Upload profile picture
  let readURL = function (input, element, dist) {
    if (input.files && input.files[0]) {
      let reader = new FileReader();

      reader.onload = function (e) {
        element.attr("src", e.target.result);
        if(dist.length > 0){
          dist.val(e.target.result);
        }
      };

      reader.readAsDataURL(input.files[0]);
    }
  };
  */
  /*
  // Business manager upload
  $("#cover-upload-btn, #cover-icon").on("click", function () {
    $("#cover-profile-upload").click();
  });

  $("#cover-profile-upload").on("change", function () {
    readURL(this, $("#cover-photo"));
    $("#cover-text").text("Change cover photo");
  });

  // Business Profile upload

  $(".js-profile-upload").on("change", function () {
    readURL(this, $(".js-profile-pic"), $('#customerAvatarUpload'));
    //$('#customerAvatarUpload').val($(".js-profile-pic").attr('src'));
  });

  $(".js-profile-upload-btn, .js-profile-icon, .js-camera-profile-icon").on("click", function () {
    $(".js-profile-upload").click();
  });
  */

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


  // CK editor Comment
  const editorComment = document.querySelector("#editorComment");
  if (editorComment) {
    ClassicEditor.create(editorComment);
  }

  // CK editor Post Reply
  /*
  const replyComment = document.querySelector("#bmReplyComment");
  if (replyComment) {
    ClassicEditor.create(replyComment);
  }
  */
  /*
  const leaveReviewComment = document.querySelector("#leaveReviewComment");
  if (leaveReviewComment) {
    ClassicEditor.create(leaveReviewComment);
  }
  */

  /*
  // Config everday bm reservation
  $("#config-everyday").click(function () {
    $("input[class='weekday']").prop("checked", $(this).prop("checked"));
    $("input[class='weekday']").addClass('saved');
  });

  $("input[class='weekday']").click(function () {
    if (!$(this).prop("checked")) {
      $("#config-everyday").prop("checked", false);
      $("input[class='weekday']").removeClass('saved');
    }
  });
  */

  // Add class selected business manager plan
  $(".plan-input-radio").on("change", function () {
    $(".bm-plan-item").removeClass("selected-plan");

    if ($(this).is(":checked")) {
      $(this).closest(".bm-plan-item").addClass("selected-plan");
    }
  });

  /*
  // Dropdown photo gallery
  $(".js-dropdown-gallery").each(function () {
    $(this).click(function (e) {
      $(".dropdown-gallery").removeClass("show");
      e.preventDefault();
      $(this).parents(".photo-item").find(".dropdown-gallery").addClass("show");
    });
  });

  $(".dropdown-gallery .dropdown-item").click(function () {
    $(".dropdown-gallery .dropdown-item").removeClass("active");
    $(this).addClass("active");
    $(".dropdown-gallery").removeClass("show");
  });

  $(document).on("click", function (event) {
    var $trigger = $(".photo-item");
    if ($trigger !== event.target && !$trigger.has(event.target).length) {
      $(".dropdown-gallery").removeClass("show");
    }
  });
  */

  /*
  // Add more input video url
  $(".add-more").click(function (e) {
    e.preventDefault();
    $("#list-url .form-group").append(
      '<input type="url" class="form-control form-control-lg mb-3">'
    );
  });
  */

  /*
  // Multiselect tags dropdown
  if ($("select[multiple='multiple']").length > 0) {
    $("select[multiple='multiple']").bsMultiSelect({
      useCssPatch: false,
      css: {
        choice_hover: '',
        picks_focus: '',
      }
    });
  }
  */

});

document.querySelectorAll(".drop-zone__input").forEach((inputElement) => {
  const dropZoneElement = inputElement.closest(".drop-zone");
  const changeImgElement = document.getElementById('change-event-img');

  dropZoneElement.addEventListener("click", (e) => {
    inputElement.click();
  });

  if (changeImgElement) {
    changeImgElement.addEventListener("click", (e) => {
      inputElement.click();
    });
  }

  inputElement.addEventListener("change", (e) => {
    if (inputElement.files.length) {
      updateThumbnail(dropZoneElement, inputElement.files[0]);
    }
  });

  dropZoneElement.addEventListener("dragover", (e) => {
    e.preventDefault();
    dropZoneElement.classList.add("drop-zone--over");
  });

  ["dragleave", "dragend"].forEach((type) => {
    dropZoneElement.addEventListener(type, (e) => {
      dropZoneElement.classList.remove("drop-zone--over");
    });
  });

  dropZoneElement.addEventListener("drop", (e) => {
    e.preventDefault();

    if (e.dataTransfer.files.length) {
      inputElement.files = e.dataTransfer.files;
      updateThumbnail(dropZoneElement, e.dataTransfer.files[0]);
    }

    dropZoneElement.classList.remove("drop-zone--over");
  });
});

/**
* Updates the thumbnail on a drop zone element.
*
* @param {HTMLElement} dropZoneElement
* @param {File} file
*/
function updateThumbnail(dropZoneElement, file) {
  let thumbnailElement = dropZoneElement.querySelector(".drop-zone__thumb");

  // First time - remove the prompt
  if (dropZoneElement.querySelector(".drop-zone__prompt")) {
    dropZoneElement.querySelector(".drop-zone__prompt").remove();
  }

  // First time - there is no thumbnail element, so lets create it
  if (!thumbnailElement) {
    thumbnailElement = document.createElement("div");
    thumbnailElement.classList.add("drop-zone__thumb");
    dropZoneElement.appendChild(thumbnailElement);
  }

  thumbnailElement.dataset.label = file.name;

  // Show thumbnail for image files
  if (file.type.startsWith("image/")) {
    const reader = new FileReader();

    reader.readAsDataURL(file);
    reader.onload = () => {
      thumbnailElement.style.backgroundImage = `url('${reader.result}')`;
      let realElement = dropZoneElement.querySelector(".drop-zone__input").getAttribute('refference');;
      console.log(realElement);
      $("#" + realElement).val(reader.result);
    };
  } else {
    thumbnailElement.style.backgroundImage = null;
  }
}
/*
if($('#map').length > 0){
  let map;
  function initMap() {
    map = new google.maps.Map(document.getElementById("map"), {
      center: new google.maps.LatLng(-33.91722, 151.23064),
      zoom: 16,
    });
  
    const iconBase =
      "../html/assets/img/frontend/";
    const icons = {
      iconMap: {
        icon: iconBase + "iconmap.png",
      },
    };

    const features = [
      {
        position: new google.maps.LatLng(-33.91662347903106, 151.22879464019775),
        type: "iconMap",
        imgiInfo:'./assets/img/frontend/home-location1.svg',
        linkInfo:'',
        titleInfo:'VELTA Free Shop',
        starInfo:5,
        evaluateInfo:3,
        linkClose:'',
        linkLocation:'',
        linkView:'',
      },
      {
        position: new google.maps.LatLng(-33.916365282092855, 151.22937399734496),
        type: "iconMap",
        imgiInfo:'./assets/img/frontend/home-location1.svg',
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
        imgiInfo:'./assets/img/frontend/home-location1.svg',
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
        imgiInfo:'./assets/img/frontend/home-location1.svg',
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
        imgiInfo:'./assets/img/frontend/home-location1.svg',
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
        imgiInfo:'./assets/img/frontend/home-location1.svg',
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
        imgiInfo:'./assets/img/frontend/home-location1.svg',
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
                  <p class="card-text mb-0 page-text-xxs text-secondary">Restaurants
                  </p>
                  <a href="${features[i].linkClose}" class="customer-location-close">Closed</a>
                  <a href="${features[i].linkLocation}"><img src="./assets/img/frontend/IconButton.png" class="img-fluid customer-location-icon"
                    alt="location image"></a>
                  <a href="${features[i].linkView}"
                      class="btn btn-outline-red btn-outline-red-xs btn-view">View</a>
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
*/

/*
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
*/

/*
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
*/

var windowsize = $(window).width();

$(window).resize(function() {
  var windowsize = $(window).width();
});

if (windowsize < 768) {
  $('.input-eye').click(function(event){
    event.stopPropagation();
    var passtype = $(this).prev('input').attr('type');
    if(passtype == 'password') {
      $(this).prev('input').attr('type', 'text');
    }else if(passtype == 'text'){
      $(this).prev('input').attr('type', 'password');
    }
  });
}else{
  $('.input-eye').mousedown(function(event){
    event.stopPropagation();
      $(this).prev('input').attr('type', 'text');
  });
  $('.input-eye').mouseup(function(event){
    event.stopPropagation();
      $(this).prev('input').attr('type', 'password');
  });
}

$(document).on('keyup', '.signup-form .signup-form-list .inputPassword,#profileNewPassword', function (event) {
  event.stopPropagation();
  var password = $(this).val();
  checkPass(password, $(this))
}).on('blur', '.signup-form .signup-form-list .inputPassword,#profileNewPassword', function (event) {
  $(this).parent().find('.tooltip-signup').hide();
}).on('click', '.signup-form .signup-form-list .inputPassword,#profileNewPassword', function (event) {
  var password = $(this).val();
  checkPass(password, $(this))
});
function checkPass(password, $this) {
  var strength = 0
  if (password.length > 7) strength += 1
  if (password.match(/([a-z].*[A-Z])|([A-Z].*[a-z])/)) strength += 1
  if (password.match(/([a-zA-Z])/) && password.match(/([0-9])/)) strength += 1
  if (strength < 3) {
    $this.parent().find('.tooltip-signup').show();
  }
  else {
    $this.parent().find('.tooltip-signup').hide();

  }
}


$(document).ready(function () {

  $('.plus').click(function () {
    let parent = $(this).parents('.form-group-quantity');
    var input = parent.find('.quantity');
    parent.find('.minus').removeClass('disabled');
    var val = parseInt(input.val(), 10);
    input.val(val + 1);
  });

  $('.minus').click(function () {
    let parent = $(this).parents('.form-group-quantity');
    var input = parent.find('.quantity');
    var val = parseInt(input.val(), 10);
    if (input.hasClass('adults') && (val - 1 == 1)) {
      parent.find('.minus').addClass('disabled');
    }
    if (input.val() > 0) {
      input.val(val - 1);
    }
  });
})
/*
$(document).ready(function () {
  if($('.posting').length > 0){
    $('.slider').slick({
      infinite: true,
      slidesToShow: 1,
      slidesToScroll: 1,
      asNavFor: '.slider1',
      prevArrow: '<img src="./assets/img/frontend/left1.png" class="icon-left">',
      nextArrow: '<img src="./assets/img/frontend/right1.png" class="icon-right">',
    });
     $('.slider1').slick({
      infinite: true,
      slidesToShow: 5,
      slidesToScroll: 5,
       asNavFor: '.slider',
       centerMode: false,
      swipeToSlide: true,
      focusOnSelect: true,
      infinity: false,
      prevArrow: '<img src="./assets/img/frontend/left2.png" class="icon-left1">',
      nextArrow: '<img src="./assets/img/frontend/right2.png" class="icon-right1">',
      centerMode: true,
        centerPadding: '0px',
        responsive: [
          {
            breakpoint: 576,
            settings: {
              slidesToShow: 3,
              slidesToScroll: 3
            }
          }
        ]
    });
    $('.slider2').slick({
      infinite: true,
      slidesToShow: 1,
      slidesToScroll: 1,
      asNavFor: '.slider3',
      prevArrow: '<img src="./assets/img/frontend/left1.png" class="icon-left">',
      nextArrow: '<img src="./assets/img/frontend/right1.png" class="icon-right">',
    });
     $('.slider3').slick({
      infinite: true,
      slidesToShow: 3,
      slidesToScroll: 3,
       asNavFor: '.slider2',
       centerMode: false,
      swipeToSlide: true,
      focusOnSelect: true,
      infinity: false,
      prevArrow: '<img src="./assets/img/frontend/left2.png" class="icon-left1">',
      nextArrow: '<img src="./assets/img/frontend/right2.png" class="icon-right1">',
      centerMode: true,
      centerPadding: '0px',
    });
    
    $('.photo-list .row .col-6').click(function(event){
      event.stopPropagation();
      $('.slider').show();
      $('.slider1').show();
      $('.slider2').hide();
      $('.slider3').hide();
      var id = $(this).find('a').attr('data-id');
      $("body").css("overflow", "hidden");
      $('.posting')
      .toggle("slow",function(){
        $('.slider').resize();
      });
      $('.slider').slick("slickGoTo", id-1);
      });
      $('.tab-video-list .row .col-6').click(function(event){
        event.stopPropagation();
        $('.slider').hide();
        $('.slider1').hide();
        $('.slider2').show();
        $('.slider3').show();
        var id = $(this).find('a').attr('data-id');
        $("body").css("overflow", "hidden");
        $('.posting')
        .toggle("slow",function(){
          $('.slider2').resize();
        });
        $('.slider2').slick("slickGoTo", id-1);
        });
     $('.close_posting').click(function() {　
      $("body").css("overflow", "auto");
       $('.posting').hide();
       $('.slider').resize();
       $('.slider2').resize();
     });
    $('.posting').click(function(event) {　
      event.stopPropagation();
    });
  }
  
});

*/

/*
$(document).ready(function () {
  if (window.File && window.FileList && window.FileReader) {
    $("#files").on("change", function (e) {
      var files = e.target.files,
        filesLength = files.length;
      for (var i = 0; i < filesLength; i++) {
        var f = files[i]
        var fileReader = new FileReader();
        fileReader.onload = (function (e) {
          $('#image_preview').append("<span class='pip position-relative'><img src='" + e.target.result + "'><span class=\"remove-img\"><img src='./assets/img/frontend/ic-remove.svg'></span></span>");
          $(".remove-img").click(function () {
            $(this).parent(".pip").remove();
            if ($('#image_preview .pip').length == 0) {
              $('.drop-zone__prompt').show();
              $('.add-more-img').hide();
              $('.upload-more-img').hide();
            }
          });
          $('.drop-zone__prompt').hide();
          $('.add-more-img').show();
          $('.upload-more-img').show();
        });
        fileReader.readAsDataURL(f);
      }
    });
    $('.hide-loading').click(function (e) {
      e.stopPropagation();
      $(this).closest('.uploading').hide();
    })
    $('.upload-more-img button').click(function (e) {
      e.stopPropagation();
      $('#addGalleryModal').modal('hide');
      $('.uploading .uploading-body table').empty();
      var count = 0;
      $('#image_preview .pip ').each(function (index, element) {
        count += 1;
        var html = ``;
        var src = $(this).find('img').attr('src');
        html = `<tr>
                  <td><img src="${src}" alt=""></td>
                  <td>${src}</td>
                  <td class="text-right"><img src="./assets/img/frontend/spinner.gif" alt=""></td>
                </tr>`;
        $('.uploading .uploading-body table').append(html);
      })
      $('.uploading-head p span').text(count);
      $('.uploading').show();

      // var formData = new FormData(this);

      // $.ajax({
      //     type:'POST',
      //     url: $(this).attr('action'),
      //     data:formData,
      //     cache:false,
      //     contentType: false,
      //     processData: false,
      //     success:function(data){
      //  setTimeout fake loading
      setTimeout(function () {
        $('.uploading .uploading-body tr td.text-right img').attr("src", "./assets/img/frontend/ic-check-mask.png");
      }, 1000);


      //     },
      //     error: function(data){
      //     }
      // });
    })
  }
});
*/

// function youtubeParser(url){
//   var regExp = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*).*/;
//   var match = url.match(regExp);
//   return (match&&match[7].length==11)? match[7] : false;
// }
/*
if ($('.slider2').length > 0) {
  $(".slider2 .video-item .video-item-ct").click(function (event) {
    event.preventDefault();
    var html = '<iframe width = "' + ($(this).closest('.video-item').attr('data-width')) + '"  height = "' + ($(this).height()) + '" src="https://www.youtube.com/embed/' + $(this).closest('.video-item').attr('data-src') + '?autoplay=1" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
    $(this).html(html);
  });
  $(window).resize(function () {
    var height = $(".slider2 .video-item .video-item-ct").height();
    $(".slider2 .video-item .video-item-ct iframe").height(height);
  })
}
*/
// redirect link 
$(document).on('click', '.page-select', function () {
  var ul = $(this).find('ul');
  ul.toggle();
}).on('click', '.page-select ul li', function (e) {
  e.stopPropagation();
  var text = $(this).text();
  $(this).closest('.page-select').find('li').removeClass('active');
  $(this).addClass('active');
  $(this).closest('.page-text-sm').find('.show-page-text').text(text);
  $(this).closest('ul').hide();
}).on('click', '.reply-comment', function (e) {
  var selectComment = $(this).data('review');
  $(this).closest('.list-comment').find('.comment-reply-' + selectComment).show();
}).on('click', '.reply-cancel', function (e) {
  $(this).closest('.comment-reply').hide();
});
$('.progress').each(function () {
  var first = $(this).find('.progress-first').text();
  var last = $(this).find('.progress-last').text();
  var num = 0;
  num = (parseInt(first) / parseInt(last)) * 100;
  $(this).find('.progress-bar').css('width', num + '%')
})

$(".icon-show-mobile").click(function () {
  $(this).closest('.show-mobile-ic').find('.bp-sidebar').toggle();
  $(this).closest('.show-mobile-ic').find('.um-links').toggle();
});
if($('.star-rate').length > 0){
  starRate();
}
function starRate(){
  $('.star-rate').each(function(){
    var rate = $(this).attr('data-rate');
    var width = 0;
    width = rate * 21.43;
    $(this).css('width',width);
    $('#rankStar').val(rate);
  });
}


function countChar(val) {
  var len = val.value.length ;
  $('.slogan-counter').text(len+"/100")
};