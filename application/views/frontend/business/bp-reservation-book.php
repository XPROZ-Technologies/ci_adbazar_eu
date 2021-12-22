<?php $this->load->view('frontend/includes/header'); ?>
<main>
  <div class="page-business-profile page-bp-reservation v1">
    <div class="bp-reservation-book">
      <div class="container">
        <div class="book-content">
          
          <?php $book_a_reservation_at_inpire_beauty_salon = $this->lang->line('book_a_reservation_at_inpire_beauty_salon'); 
                $book_a_reservation_at_inpire_beauty_salon = explode('<Inspire Beauty Salon>', $book_a_reservation_at_inpire_beauty_salon);
            ?>
          <h3 class="text-center page-title-md"><?php echo $book_a_reservation_at_inpire_beauty_salon[0]; ?> <?php echo $businessInfo['business_name']; ?></h3>
          <div class="d-flex justify-content-center">
            <form class="row" action="<?php echo base_url('business/submit-book-reservation'); ?>" id="formBookReservation" method="POST">
              <input type="hidden" name="business_profile_id" id="businessId" value="<?php echo $businessInfo['id']; ?>" />
              <input type="hidden" name="customer_id" id="customerId" value="<?php echo $customer['id']; ?>" />
              <input type="hidden" name="selected_day" id="selecteDate" value="<?php echo date('Y-m-d'); ?>" />
              <div class="col-lg-12">
                <div class="form-group mb-3">
                  <label for="bookName" class="form-label"><?php echo $this->lang->line('your_name'); ?><span class="required text-danger">*</span></label>
                  <input type="text" class="form-control" id="bookName" name="book_name" required>
                </div>
              </div>
              <div class="col-lg-12">
                <div class="form-group mb-3 form-group-quantity">
                  <label class="d-block form-label" for="numOfPeople"><?php echo $this->lang->line('number_of_people'); ?></label>
                  <div class="d-flex align-items-center">
                    <button type="button" class="minus">
                      <img src="assets/img/frontend/ic-minus.png" alt="icon minus">
                    </button>
                    <input type="number" class="form-control quantity" id="numOfPeople" name="number_of_people" value="1" min="1"  />
                    <button type="button" class="plus">
                      <img src="assets/img/frontend/ic-plus.png" alt="icon plus">
                    </button>
                    <p class="color-close ml-8px mb-0 max-number-noti" style="display:none"></p>
                  </div>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group mb-3">
                  <label class="form-label"><?php echo $this->lang->line('country_code'); ?></label>
                  <input type="hidden" name="country_code_id" id="countryCodeId" value="80" />
                  <div class="dropdown dropdown-country dropdown-country-book page-text-lg">
                    <a href="#" class="wrapper-btn dropdown-toggle current js-country country_book" id="countryDropdown" data-bs-toggle="dropdown" aria-expanded="false" value="en">
                      <img src="assets/img/iso_flags/de.png" alt="<?php echo $this->lang->line('german'); ?>" class="img-fluid me-2">
                      <span class="country-text"><?php echo $this->lang->line('german'); ?></span>
                      <span class="country-code">+49</span>
                    </a>
                    <ul class="dropdown-menu js-list-country" aria-labelledby="countryDropdown">
                      <?php if (!empty($phoneCodes)) { ?>
                        <?php foreach ($phoneCodes as $itemPhoneCode) { ?>
                          <li class="" data-id="<?php echo $itemPhoneCode['id']; ?>">
                            <a class="dropdown-item" href="javascript:void(0)" data-id="<?php echo $itemPhoneCode['id']; ?>">
                              <img src="assets/img/iso_flags/<?php echo $itemPhoneCode['image']; ?>" alt="<?php echo $itemPhoneCode['country_name']; ?>" class="img-fluid me-2" data-id="<?php echo $itemPhoneCode['id']; ?>">
                              <span class="country-text"><?php echo $itemPhoneCode['country_name']; ?></span>
                              <span class="country-code">+<?php echo $itemPhoneCode['phonecode']; ?></span>
                            </a>
                          </li>
                        <?php } ?>
                      <?php } ?>
                    </ul>
                  </div>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group mb-3">
                  <label for="bookPhone" class="form-label"><?php echo $this->lang->line('phone_number'); ?></label>
                  <input type="tel" class="form-control" id="bookPhone" name="book_phone" value="">
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group mb-3 form-group-datepicker">
                  <label for="dateArrived" class="form-label"><?php echo $this->lang->line('select_a_date'); ?></label>
                  <div class="datepicker-wraper position-relative">
                    <img src="assets/img/frontend/icon-calendar.png" alt="calendar icon" class="img-fluid icon-calendar" />
                    <input type="text" class="form-control datetimepicker-input" name="date_arrived" id="dateArrived" data-toggle="datetimepicker" data-target="#dateArrived" value="" />
                  </div>
                </div>
              </div>

              <div class="col-lg-6">
                <!--
                <div class="form-group mb-3 form-group-timepicker">
                  <label for="timepicker1" class="form-label">Select a time</label>
                  <select class="form-control">
                    <option value="0">--Select a time--</option>
                    <option value="1">Dog</option>
                    <option value="2">Cat</option>
                    <option value="hamster">Hamster</option>
                    <option value="parrot">Parrot</option>
                    <option value="spider">Spider</option>
                    <option value="goldfish">Goldfish</option>
                  </select>
                </div>
                -->
                <div class="form-group mb-3">
                  <label class="form-label"><?php echo $this->lang->line('select_a_time'); ?> <span class="required text-danger">*</span></label>
                  <input type="hidden" name="time_arrived" id="getTimeArrived" value="0" />
                  <div class="custom-select js-select-time js-select-service">
                    <select required id="timeArrived">
                      <option value="0"><?php echo $this->lang->line('select_a_time'); ?></option>
                      <?php if (!empty($listHours)) {
                        foreach ($listHours as $itemHours) { ?>
                          <option value="<?php echo $itemHours; ?>"><?php echo $itemHours; ?></option>
                      <?php }
                      } ?>
                    </select>
                  </div>
                </div>
              </div>

              <div class="d-flex justify-content-center book-btn">
                <button type="submit" class="btn btn-red btn-confirm">Confirm</button>
                <button type="button" class="btn btn-outline-red btn-cancel"><?php echo $this->lang->line('cancel'); ?></button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
<input type="hidden" id="maxPerReservation" value="<?php if(isset($configTimes['max_per_reservation'])) { echo $configTimes['max_per_reservation']; }else{ echo "0"; } ?>" />
<?php $this->load->view('frontend/includes/footer'); ?>

<script>
  $(document).ready(function() {
    
    $("body").on("click", ".js-list-country li a", function() {
      $("#countryCodeId").val($(this).data('id'));
    });

    $("body").on("click", ".js-select-time li", function() {
      $("#getTimeArrived").val($(this).data('value'));
    });

    $(".btn-confirm").click(function(e) {
      e.preventDefault();

      var business_id = $("#businessId").val();
      var book_name = $("#bookName").val();
      var number_of_people = $("#numOfPeople").val();
      var country_code_id = $("#countryCodeId").val();
      var book_phone = $("#bookPhone").val();
      var date_arrived = $("#dateArrived").val();
      var time_arrived = $("#timeArrived").val();

      var selectedDay = $("#selecteDate").val();
      var selectTime = $('.js-select-service ul li.selected').data('value');
      var maxPerReservation = $("#maxPerReservation").val();
      //console.log(number_of_people + '____' + maxPerReservation);
      
      
      if (parseInt(number_of_people) > parseInt(maxPerReservation) && parseInt(maxPerReservation) > 0) {
        $(".max-number-noti").html("Maximum of people is: " + maxPerReservation);
        $(".max-number-noti").show();
        $(".notiPopup .text-secondary").html("Maximum of people is: " + maxPerReservation);
        $(".ico-noti-error").removeClass('ico-hidden');
        $(".notiPopup").fadeIn('slow').fadeOut(5000);
        return false;
      }else{
        $(".max-number-noti").html("");
        $(".max-number-noti").hide();
      }

      if (selectedDay == 0 || selectedDay == "") {
        $(".notiPopup .text-secondary").html("Please select a day");
        $(".ico-noti-error").removeClass('ico-hidden');
        $(".notiPopup").fadeIn('slow').fadeOut(5000);
        return false;
      }

      if (selectTime == "0" || selectTime == "") {
        $(".notiPopup .text-secondary").html("Please select a time");
        $(".ico-noti-error").removeClass('ico-hidden');
        $(".notiPopup").fadeIn('slow').fadeOut(5000);
        return false;
      }

      if (book_name == '' || number_of_people == '' || country_code_id == '' || book_phone == '' || date_arrived == '' || time_arrived == '') {
        $(".notiPopup .text-secondary").html("Please fulfill information");
        $(".ico-noti-error").removeClass('ico-hidden');
        $(".notiPopup").fadeIn('slow').fadeOut(5000);
        return false;
      } else {
        $("#formBookReservation").submit();
      }
    });

    $(".btn-cancel").click(function(e) {
      redirect(false, '<?php echo base_url('business/' . $businessInfo['business_url'] . '/reservation'); ?>');
    });

    /*
    $('#numOfPeople').on('change', function() {
      console.log($(this).val());
      var maxPerReservation = $("#maxPerReservation").val();
      if ($(this).val() > maxPerReservation) {
        $(".notiPopup .text-secondary").html("Maximum of people is: " + maxPerReservation);
        $(".ico-noti-error").removeClass('ico-hidden');
        $(".notiPopup").fadeIn('slow').fadeOut(5000);
        $(this).val(maxPerReservation);
      }
    });
    */

    // change date 
    var dateNow = new Date();
    $("#dateArrived").datetimepicker({
      defaultDate: dateNow,
      minDate: moment(),
      // onChangeDateTime:function(dp,$input){
      //   alert($input.val())
      //   console.log(213);
      // },
      //format: "MMMM DD, YYYY",
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

    $('#dateArrived').on('dp.change', function(e) {
      var formatedValue = e.date.format(e.date._f);
      var business_id = $("#businessId").val();
      
      $.ajax({
        type: 'POST',
        url: '<?php echo base_url('reservation/get-avail-time'); ?>',
        data: {
          selected_day: formatedValue,
          business_id: business_id
        },
        dataType: "json",
        success: function(data) {

          if (data.code == 1) {
            console.log(data.data);
            $("#timeArrived").html(data.data);
            $("#maxPerReservation").val(data.max_people);
            $(".custom-select").niceSelect('update');
          } else {
            $("#timeArrived").html('<option value="0"><?php echo $this->lang->line('select_a_time'); ?></option>');
            $(".custom-select").niceSelect('update');
            $(".notiPopup .text-secondary").html(data.message);
            $(".ico-noti-error").removeClass('ico-hidden');
            $(".notiPopup").fadeIn('slow').fadeOut(5000);
          }

        },
        error: function(data) {
          $(".notiPopup .text-secondary").html("Reply review failed");
          $(".ico-noti-error").removeClass('ico-hidden');
          $(".notiPopup").fadeIn('slow').fadeOut(5000);
        }
      });

    });

  });
</script>