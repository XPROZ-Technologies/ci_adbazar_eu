<?php $this->load->view('frontend/includes/header'); ?>
<main>
  <div class="page-business-manager">
    <div class="bm-content">
      <div class="container">
        <?php $this->load->view('frontend/includes/bm_header'); ?>


        <div class="row">
          <div class="col-lg-3">
            <?php $this->load->view('frontend/includes/business_manage_nav_sidebar'); ?>
          </div>
          <div class="col-lg-9">
            <div class="bp-reservation bm-reservation">
              <div class="bp-reservation-inner um-reservation-inner">

                <div class="d-flex justify-content-between reservation-config">
                  <div class="d-flex align-items-center switch-btn">
                    <input id="reservation-config" type="checkbox" class="checkbox" <?php if ($businessInfo['allow_book'] == STATUS_ACTIVED) {
                                                                                      echo "checked";
                                                                                    } ?>>
                    <label for="reservation-config" class="switch">
                      <span class="switch-circle">
                        <span class="switch-circle-inner"></span>
                      </span>
                      <span class="switch-left">Off</span>
                      <span class="switch-right">On</span>
                    </label>
                    <p class="mb-0 switch-text fw-bold">Receive reservation(s)</p>
                  </div>
                  <button class="btn btn-red mr-24" type="button" data-bs-toggle="modal" data-bs-target="#configModal"><img src="assets/img/frontend/ic-setting.png" alt="reservation-config"> Reservation Setting</button>
                </div>


                <div class="w-275">
                  <div class="reservation-select-date">
                    <div class="form-group form-group-datepicker">
                      <label for="selecteDate" class="form-label">Select a date</label>
                      <div class="datepicker-wraper position-relative">
                        <img src="assets/img/frontend/icon-calendar.png" alt="calendar icon" class="img-fluid icon-calendar" />
                        <input type="text" class="form-control datetimepicker-input" id="selecteDate" data-toggle="datetimepicker" value="" />
                      </div>
                    </div>
                  </div>
                </div>
                <?php if (!empty($lists)) { ?>
                  <div class="bg-f5">
                    <form class="d-flex search-box" action="<?php echo $basePagingUrl; ?>" method="GET" name="searchForm">
                      <a href="javascript:void(0)" class="search-box-icon" onclick="document.searchForm.submit();"><img src="assets/img/frontend/ic-search.png" alt="search icon"></a>
                      <input class="form-control" type="text" placeholder="Search" aria-label="Search" name="keyword" value="<?php echo $keyword; ?>">
                    </form>
                    <div class="notification-wrapper-filter d-flex align-items-center justify-content-md-between">
                      <div class="d-flex align-items-center inner-filter">

                        <span class="me-2 page-text-lg fw-bold">Filter by</span>
                        <div class="notification-filter">
                          <div class="custom-select">
                            <select>
                              <option value="0" selected>All</option>
                              <option value="1">Personal</option>
                              <option value="2">The Rice Bowl</option>
                              <option value="3">Inspire Beauty Salon</option>
                            </select>
                          </div>
                        </div>

                      </div>
                      <div class="d-flex align-items-center notification-sort">
                        <img src="assets/img/frontend/ic-sort.png" alt="sort icon" class="img-fluid me-2">
                        <div class="custom-select mb-0 choose-order">
                          <select>
                            <option value="desc" selected>Newest</option>
                            <option value="asc" <?php if (isset($order_by) && $order_by == 'asc') {
                                                  echo 'selected="selected"';
                                                } ?>>Oldest</option>
                          </select>
                        </div>
                      </div>
                    </div>

                    <div class="table-responsive reservation-table">
                      <table class="table page-text-lg">
                        <thead>
                          <tr>
                            <th>Time</th>
                            <th>ID</th>
                            <th>People</th>
                            <th>Status</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          foreach ($lists as $itemBook) { ?>
                            <tr>
                              <td><?php echo $itemBook['date_arrived']; ?><br><?php echo $itemBook['time_arrived']; ?></td>
                              <td><?php echo $itemBook['book_code']; ?></td>
                              <td><?php echo $itemBook['number_of_people']; ?></td>
                              <td>
                                <?php if ($itemBook['book_status_id'] == STATUS_ACTIVED) { ?>
                                  <span class="badge badge-approved">Approved</span>
                                <?php } ?>
                                <?php if ($itemBook['book_status_id'] == 1) { ?>
                                  <span class="badge badge-expire">Expired</span>
                                <?php } ?>
                                <?php if ($itemBook['book_status_id'] == 3) { ?>
                                  <span class="badge badge-declined">Cancelled</span>
                                <?php } ?>
                                <?php if ($itemBook['book_status_id'] == 4) { ?>
                                  <span class="badge badge-declined">Declined</span>
                                <?php } ?>
                              </td>
                              <td>
                                <div class="d-flex justify-content-center">
                                  <?php if ($itemBook['book_status_id'] == STATUS_ACTIVED) { ?>
                                    <button type="button" class="btn  btn-outline-red btn-outline-red-md fw-bold btn-ask-cancel-reservation" data-book="<?php echo $itemBook['id']; ?>" data-code="<?php echo $itemBook['book_code']; ?>">Cancel</button>
                                  <?php } ?>
                                  <?php if ($itemBook['book_status_id'] == 4 || $itemBook['book_status_id'] == 1 || $itemBook['book_status_id'] == 3) { ?>
                                    <button type="button" class="btn  btn-outline-red btn-outline-red-md btn-outline-red-disabled" disabled>Cancel</button>
                                  <?php } ?>
                                </div>
                              </td>
                            </tr>
                          <?php }
                          ?>

                        </tbody>
                      </table>
                    </div>



                    <?php if (count($lists) > 0) { ?>
                      <!-- Pagination -->
                      <div class="d-flex align-items-center flex-column flex-md-row justify-content-between page-pagination">
                        <div class="d-flex align-items-center pagination-left">
                          <p class="page-text-sm mb-0 me-3">Showing <span class="fw-500"><?php echo ($page - 1) * $perPage + 1; ?> – <?php echo ($page - 1) * $perPage + count($lists); ?></span> of <span class="fw-500"><?php echo number_format($rowCount); ?></span>
                            results</p>
                          <div class="page-text-sm mb-0 d-flex align-items-center">
                            <div class="custom-select choose-perpage">
                              <select>
                                <option value="10" <?php if (isset($per_page) && $per_page == 20) {
                                                      echo 'selected';
                                                    } ?>>10</option>
                                <option value="20" <?php if (isset($per_page) && $per_page == 20) {
                                                      echo 'selected';
                                                    } ?>>20</option>
                                <option value="30" <?php if (isset($per_page) && $per_page == 30) {
                                                      echo 'selected';
                                                    } ?>>30</option>
                                <option value="40" <?php if (isset($per_page) && $per_page == 40) {
                                                      echo 'selected';
                                                    } ?>>40</option>
                                <option value="50" <?php if (isset($per_page) && $per_page == 50) {
                                                      echo 'selected';
                                                    } ?>>50</option>
                              </select>
                            </div>
                            <span class="ms-2">/</span>
                            <span class=""> Page</span>
                          </div>
                        </div>
                        <div class="pagination-right">
                          <!-- Page pagination -->
                          <nav>
                            <?php echo $paggingHtml; ?>
                          </nav>
                          <!-- End Page pagination -->
                        </div>
                      </div>
                      <!-- END. Pagination -->
                    <?php } ?>

                  </div>

                  <!-- END -->

                <?php } else { ?>
                  <div class="zero-event zero-box">
                    <img src="assets/img/frontend/img-empty-box.svg" alt="img-empty-box" class="img-fluid d-block mx-auto">
                    <p class="text-secondary page-text-lg">No reservations</p>
                  </div>
                <?php } ?>


              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
<input type="hidden" id="businessId" value="<?php echo $businessInfo['id']; ?>" />
<input type="hidden" id="currentBaseUrl" value="<?php echo $basePagingUrl; ?>" />
<?php $this->load->view('frontend/includes/footer'); ?>

<!-- Modal Config -->
<div class="modal fade bm-modal-config" id="configModal" tabindex="-1" aria-labelledby="configModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body">
        <form action="#">
          <h3 class="text-center page-title-sm text-config">Setting up reservation
          </h3>

          <div class="weekdays-selector">
            <input type="checkbox" id="weekday-mon" data-id="0" class="weekday <?php if (isset($reservationConfigs[0])) {
                                                                                  echo "saved";
                                                                                } ?>" />
            <label for="weekday-mon">Mon</label>
            <input type="checkbox" id="weekday-tue" data-id="1" class="weekday <?php if (isset($reservationConfigs[1])) {
                                                                                  echo "saved";
                                                                                } ?>" />
            <label for="weekday-tue">Tue</label>
            <input type="checkbox" id="weekday-wed" data-id="2" class="weekday <?php if (isset($reservationConfigs[2])) {
                                                                                  echo "saved";
                                                                                } ?>" />
            <label for="weekday-wed">Wed</label>
            <input type="checkbox" id="weekday-thu" data-id="3" class="weekday <?php if (isset($reservationConfigs[3])) {
                                                                                  echo "saved";
                                                                                } ?>" />
            <label for="weekday-thu">Thu</label>
            <input type="checkbox" id="weekday-fri" data-id="4" class="weekday <?php if (isset($reservationConfigs[4])) {
                                                                                  echo "saved";
                                                                                } ?>" />
            <label for="weekday-fri">Fri</label>
            <input type="checkbox" id="weekday-sat" data-id="5" class="weekday <?php if (isset($reservationConfigs[5])) {
                                                                                  echo "saved";
                                                                                } ?>" />
            <label for="weekday-sat">Sat</label>
            <input type="checkbox" id="weekday-sun" data-id="6" class="weekday <?php if (isset($reservationConfigs[6])) {
                                                                                  echo "saved";
                                                                                } ?>" />
            <label for="weekday-sun">Sun</label>
          </div>

          <div class="wrapper-config">
            <input type="hidden" id="selecteDay" value="" />
            <input type="hidden" id="businessId" value="<?php echo $businessInfo['id']; ?>" />
            <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-md-between form-group mb-3 mb-lg-2">
              <label for="maxPeople" class="page-text-lg fw-500">Max number of people to
                be served at a time</label>
              <div class="wrapper-input">
                <input type="number" id="maxPeople" class="form-control square-input required-input">
              </div>
            </div>
            <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-md-between form-group mb-3 mb-lg-2">
              <label for="maxPerReservation" class="page-text-lg fw-500">Max number of people per
                reservation</label>
              <div class="wrapper-input">
                <input type="number" id="maxPerReservation" class="form-control  square-input required-input">
              </div>
            </div>
            <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-md-between form-group mb-3 mb-lg-2">
              <label for="duration" class="page-text-lg fw-500">Time between
                reservations</label>
              <div class="d-flex align-items-center wrapper-input">
                <input type="text" id="duration" class="form-control  square-input required-input">
                <span class="page-text-lg fw-500 ms-2">Minute(s)</span>
              </div>
            </div>
            <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-md-between form-group mb-3 mb-lg-2">
              <label for="startTime" class="page-text-lg fw-500">Start taking reservation
                at</label>
              <div class="timepicker-wraper wrapper-input time-content">
                <input type="text" class="js-time-picker form-control datetimepicker-input required-input" id="startTime" data-toggle="datetimepicker" />
              </div>
            </div>
            <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-md-between form-group mb-3 mb-lg-2">
              <label for="endTime" class="page-text-lg fw-500">Closing time</label>
              <div class="timepicker-wraper wrapper-input time-content">
                <input type="text" class="js-time-picker form-control datetimepicker-input required-input" id="endTime" data-toggle="datetimepicker" />
              </div>
            </div>
          </div>

          <div class="d-flex justify-content-center form-check apply-everyday">
            <input class="form-check-input" type="checkbox" id="config-everyday">
            <label class="form-check-label" for="config-everyday">
              Apply to everyday
            </label>
          </div>

          <!-- Remove this line when valid content -->
          <p class="page-text-lg text-danger text-center fw-500">IMPORTANT: You need to fill in all information to save changes.</p>

          <!-- Remove disabled when validate content -->
          <div class="modal-footer justify-content-center border-0 p-0">
            <button type="button" class="btn btn-red btn-red btn-save-config">Save changes</button>
            <button type="button" class="btn btn-outline-red" data-bs-dismiss="modal">Cancel</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- End Modal Config  -->


<!-- Modal confirm remove -->
<div class="modal fade" id="removeEventModal" tabindex="-1" aria-labelledby="removeEventModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-medium">
    <div class="modal-content">
      <div class="modal-header border-bottom-0">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p class="text-center page-text-lg">Are you sure want to decline the reservation
          "<b id="reservationCode"></b>"?
        </p>
        <input type="hidden" id="selectedBookId" value="" />
        <div class="d-flex justify-content-center">
          <a href="javascript:void(0)" class="btn btn-red btn-yes btn-cancel-reservation">Yes</a>
          <a href="javascript:void(0)" class="btn btn-outline-red btn-cancel" data-bs-dismiss="modal">Cancel</a>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Modal confirm remove -->

<script>
  $(document).ready(function() {
    // change date 
    var dateNow = new Date();
    $("#selecteDate").datetimepicker({
      defaultDate: dateNow,
      //minDate: moment(),
      // onChangeDateTime:function(dp,$input){
      //   alert($input.val())
      //   console.log(213);
      // },
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

    $('#selecteDate').on('dp.change', function(e) {
      var formatedValue = e.date.format(e.date._f);
      var formatDay = moment(formatedValue).format('YYYY-MM-DD');
      console.log(formatDay);
      redirect(false, '<?php echo $basePagingUrl; ?>?selected_day=' + formatDay);
    });

    // Config everday bm reservation
    $("#config-everyday").click(function() {
      $("input[class='weekday']").prop("checked", $(this).prop("checked"));
      $("input[class='weekday']").addClass('saved');
    });

    $("input[class='weekday']").click(function() {
      if (!$(this).prop("checked")) {
        $("#config-everyday").prop("checked", false);
        $("input[class='weekday']").removeClass('saved');
      }
    });

    $(".weekday").click(function() {
      var business_id = $("#businessId").val();
      var day_id = $(this).data('id');
      $('#selecteDay').val(day_id);

      $(".weekday").prop('checked', false);
      $(this).prop('checked', true);

      $("#config-everyday").prop('checked', false);

      /* clear data */
      $("#maxPeople").val("");
      $("#maxPerReservation").val("");
      $("#duration").val("");
      $("#startTime").val("");
      $("#endTime").val("");

      if (day_id !== '') {
        $.ajax({
          type: 'POST',
          url: '<?php echo base_url('business-management/get-reservation-config'); ?>',
          data: {
            day_id: day_id,
            business_id: business_id
          },
          dataType: "json",
          success: function(json) {
            if (json.code == 1) {
              /* console.log(json.data); */
              var configData = json.data;

              /* load data */
              $("#maxPeople").val(configData.max_people);
              $("#maxPerReservation").val(configData.max_per_reservation);
              $("#duration").val(configData.duration);
              $("#startTime").val(configData.start_time);
              $("#endTime").val(configData.end_time);

            }
          },
          error: function(json) {
            $(".notiPopup .text-secondary").html("Reply review failed");
            $(".ico-noti-error").removeClass('ico-hidden');
            $(".notiPopup").fadeIn('slow').fadeOut(4000);
          }
        });
      } else {
        $(".notiPopup .text-secondary").html("Selected day not exist");
        $(".ico-noti-error").removeClass('ico-hidden');
        $(".notiPopup").fadeIn('slow').fadeOut(4000);
      }
    });


    /* Save config */
    $(".btn-save-config").click(function() {
      var business_id = $("#businessId").val();
      var day_id = $("#selecteDay").val();

      var isAll = 0;
      if ($("#config-everyday").is(":checked")) {
        isAll = 1;
      }

      /* clear data */
      var max_people = $("#maxPeople").val();
      var max_per_reservation = $("#maxPerReservation").val();
      var duration = $("#duration").val();
      var start_time = $("#startTime").val();
      var end_time = $("#endTime").val();

      if (max_people == '' || max_per_reservation == '' || duration == '' || start_time == '' || end_time == '') {
        $(".notiPopup .text-secondary").html("Please fulfill information");
        $(".ico-noti-error").removeClass('ico-hidden');
        $(".notiPopup").fadeIn('slow').fadeOut(4000);
      }

      if (day_id !== '') {
        $.ajax({
          type: 'POST',
          url: '<?php echo base_url('business-management/save-reservation-config'); ?>',
          data: {
            day_id: day_id,
            business_id: business_id,
            max_people: max_people,
            max_per_reservation: max_per_reservation,
            duration: duration,
            start_time: start_time,
            end_time: end_time,
            isAll: isAll
          },
          dataType: "json",
          success: function(json) {
            if (json.code == 1) {
              $(".notiPopup .text-secondary").html("Save config successfully");
              $(".ico-noti-success").removeClass('ico-hidden');
              $(".notiPopup").fadeIn('slow').fadeOut(4000);

            } else {
              $(".notiPopup .text-secondary").html(json.message);
              $(".ico-noti-error").removeClass('ico-hidden');
              $(".notiPopup").fadeIn('slow').fadeOut(4000);
            }
          },
          error: function(json) {
            $(".notiPopup .text-secondary").html("Save config failed 2");
            $(".ico-noti-error").removeClass('ico-hidden');
            $(".notiPopup").fadeIn('slow').fadeOut(4000);
          }
        });
      } else {
        $(".notiPopup .text-secondary").html("Save config failed 1");
        $(".ico-noti-error").removeClass('ico-hidden');
        $(".notiPopup").fadeIn('slow').fadeOut(4000);
      }
    });


    //on-off receive notification
    $("#reservation-config").on('change', function() {
      var statusReservation = 1
      if ($(this).is(":checked")) {
        statusReservation = 2;
      }
      console.log(statusReservation);
      var business_id = $("#businessId").val();

      $.ajax({
        type: 'POST',
        url: '<?php echo base_url('business-management/change-allow-book'); ?>',
        data: {
          allow_book: statusReservation,
          business_id: business_id
        },
        dataType: "json",
        success: function(json) {
          if (json.code == 1) {
            $(".notiPopup .text-secondary").html(json.message);
            $(".ico-noti-success").removeClass('ico-hidden');
            $(".notiPopup").fadeIn('slow').fadeOut(4000);

          } else {
            $(".notiPopup .text-secondary").html(json.message);
            $(".ico-noti-error").removeClass('ico-hidden');
            $(".notiPopup").fadeIn('slow').fadeOut(4000);
          }
        },
        error: function(json) {
          $(".notiPopup .text-secondary").html("Change status failed");
          $(".ico-noti-error").removeClass('ico-hidden');
          $(".notiPopup").fadeIn('slow').fadeOut(4000);
        }
      });
    });

    // change date 
    var dateNow = new Date();
    $("#reservation-date").datetimepicker({
      defaultDate: dateNow,
      startDate: dateNow,
      // onChangeDateTime:function(dp,$input){
      //   alert($input.val())
      //   console.log(213);
      // },
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

    $('#reservation-date').on('dp.change', function(e) {
      var formatedValue = e.date.format(e.date._f);
      console.log(formatedValue);
    });


    $(".btn-ask-cancel-reservation").click(function() {
      var book_id = $(this).data('book');
      $("#selectedBookId").val(book_id);
      var book_code = $(this).data('code');
      $("#reservationCode").html(book_code);
      $("#removeEventModal").modal('show');
    });


    $(".btn-cancel-reservation").click(function() {
      var book_id = $("#selectedBookId").val();
      var business_id = $('#businessId').val();

      //action
      $.ajax({
        type: 'POST',
        url: '<?php echo base_url('reservation/business-decline-reservation'); ?>',
        data: {
          book_id: book_id,
          business_id: business_id
        },
        dataType: "json",
        success: function(data) {
          $("#removeEventModal").modal('hide');
          if (data.code == 1) {
            $(".notiPopup .text-secondary").html(data.message);
            $(".ico-noti-success").removeClass('ico-hidden');
            $(".notiPopup").fadeIn('slow').fadeOut(4000);
          } else {
            $(".notiPopup .text-secondary").html(data.message);
            $(".ico-noti-error").removeClass('ico-hidden');
            $(".notiPopup").fadeIn('slow').fadeOut(4000);
          }
          redirect(true);
        },
        error: function(data) {
          $(".notiPopup .text-secondary").html("Declined failed");
          $(".ico-noti-error").removeClass('ico-hidden');
          $(".notiPopup").fadeIn('slow').fadeOut(4000);

          redirect(true);
        }
      });

    });


  });
</script>