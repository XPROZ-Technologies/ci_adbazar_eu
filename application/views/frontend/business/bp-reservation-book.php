<?php $this->load->view('frontend/includes/header'); ?>
<main>
  <div class="page-business-profile page-bp-reservation v1">
    <div class="bp-reservation-book">
      <div class="container">
        <div class="book-content">
          <h3 class="text-center page-title-md">Book a reservation at <?php echo $businessInfo['business_name']; ?></h3>
          <div class="d-flex justify-content-center">
            <form class="row" action="<?php echo base_url('business/book-reservation'); ?>" id="formBookReservation" method="POST">
              <input type="hidden" name="business_profile_id" id="businessId" value="<?php echo $businessInfo['id']; ?>" />
              <input type="hidden" name="customer_id" id="customerId" value="<?php echo $customer['id']; ?>" />
              <div class="col-lg-12">
                <div class="form-group mb-3">
                  <label for="bookName" class="form-label">Your name<span class="required text-danger">*</span></label>
                  <input type="text" class="form-control" id="bookName" name="book_name" required>
                </div>
              </div>
              <div class="col-lg-12">
                <div class="form-group mb-3 form-group-quantity">
                  <label class="d-block form-label" for="numOfPeople">Number of people</label>
                  <div class="d-flex">
                    <button type="button" class="minus">
                      <img src="assets/img/frontend/ic-minus.png" alt="icon minus">
                    </button>
                    <input type="number" class="form-control quantity" id="numOfPeople" name="number_of_people" value="1" min="1" />
                    <button type="button" class="plus">
                      <img src="assets/img/frontend/ic-plus.png" alt="icon plus">
                    </button>
                  </div>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group mb-3">
                  <label class="form-label">Country code</label>
                  <input type="hidden" name="country_code_id" id="countryCodeId" value="80" />
                  <div class="dropdown dropdown-country dropdown-country-book page-text-lg">
                    <a href="#" class="wrapper-btn dropdown-toggle current js-country country_book" id="countryDropdown" data-bs-toggle="dropdown" aria-expanded="false" value="en">
                      <img src="assets/img/iso_flags/de.png" alt="Germany" class="img-fluid me-2">
                      <span class="country-text">Germany</span>
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
                  <label for="bookPhone" class="form-label">Phone number</label>
                  <input type="tel" class="form-control" id="bookPhone" name="book_phone" value="">
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group mb-3 form-group-datepicker">
                  <label for="dateArrived" class="form-label">Select a date</label>
                  <div class="datepicker-wraper position-relative">
                    <img src="assets/img/frontend/icon-calendar.png" alt="calendar icon" class="img-fluid icon-calendar" />
                    <input type="text" class="js-datepicker form-control datetimepicker-input" name="date_arrived" id="dateArrived" data-toggle="datetimepicker" data-target="#dateArrived" />
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
                  <label class="form-label">Select a time <span class="required text-danger">*</span></label>
                  <div class="custom-select js-select-service">
                    <select name="time_arrived" required id="timeArrived">
                      <option value="10:00">10:00</option>
                      <option value="11:00">11:00</option>
                      <option value="12:00">12:00</option>
                      <option value="13:00">13:00</option>
                    </select>
                  </div>
                </div>
              </div>

              <div class="d-flex justify-content-center book-btn">
                <button type="submit" class="btn btn-red btn-confirm">Confirm</button>
                <button type="button" class="btn btn-outline-red btn-cancel">Cancel</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
<?php $this->load->view('frontend/includes/footer'); ?>

<script>
  $(".btn-confirm").click(function(e) {
    e.preventDefault();

    var business_id = $("#businessId").val();

    var book_name = $("#bookName").val();
    var number_of_people = $("#numberOfPeople").val();
    var country_code_id = $("#countryCodeId").val();
    var book_phone = $("#bookPhone").val();
    var date_arrived = $("#dateArrived").val();
    var time_arrived = $("#timeArrived").val();

    if (book_name == '' || number_of_people == '' || country_code_id == '' || book_phone == '' || date_arrived == '' || time_arrived == '') {
      $(".notiPopup .text-secondary").html("Please fulfill information");
      $(".ico-noti-error").removeClass('ico-hidden');
      $(".notiPopup").fadeIn('slow').fadeOut(4000);
    }else{
      $("#formBookReservation").submit();
    }
  });

  $(".btn-cancel").click(function(e) {
    redirect(false, '<?php echo base_url('business/' . $businessInfo['business_url'] . '/reservation'); ?>');
  });
</script>