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
                    <p class="mb-0 switch-text"><?php echo $this->lang->line('receive_reservations'); ?></p>
                  </div>
                  <button class="btn btn-red mr-24  reservation-setting" type="button" data-bs-toggle="modal" data-bs-target="#configModal"><img src="assets/img/frontend/ic-setting.png" alt="reservation-config"><?php echo $this->lang->line('reservation_setting'); ?></button>
                </div>


                <div class="w-275">
                  <div class="reservation-select-date">
                    <div class="form-group form-group-datepicker">
                      <label for="selecteDate" class="form-label"><?php echo $this->lang->line('select_a_date'); ?></label>
                      <div class="datepicker-wraper position-relative">
                        <img src="assets/img/frontend/icon-calendar.png" alt="calendar icon" class="img-fluid icon-calendar" />
                        <input type="text" class="form-control datetimepicker-input" id="selecteDate" data-toggle="datetimepicker" value="" />
                      </div>
                    </div>
                  </div>
                </div>

                <div class="bg-f5">
                  <?php if (!empty($lists)) { ?>
                    <form class="d-flex search-box" action="<?php echo $basePagingUrl; ?>" method="GET" name="searchForm">
                      <a href="javascript:void(0)" class="search-box-icon" onclick="document.searchForm.submit();"><img src="assets/img/frontend/ic-search.png" alt="search icon"></a>
                      <input class="form-control" type="text" placeholder="Search" aria-label="Search" name="keyword" value="<?php echo $keyword; ?>">
                    </form>
                    <div class="notification-wrapper-filter d-flex align-items-center justify-content-md-between">
                      <div class="d-flex align-items-center inner-filter">

                        <span class="me-2 page-text-lg fw-bold"><?php echo $this->lang->line('status'); ?></span>
                        <div class="notification-filter">
                          <div class="custom-select choose-reser-status">
                            <select>
                              <option value="0"><?php echo $this->lang->line('1310_all'); ?></option>
                              <option value="2" <?php if (isset($type) && $type == '2') {
                                                  echo 'selected="selected"';
                                                } ?>><?php echo $this->lang->line('approved'); ?></option>
                              <option value="3" <?php if (isset($type) && $type == '3') {
                                                  echo 'selected="selected"';
                                                } ?>><?php echo $this->lang->line('declined'); ?></option>
                              <option value="1" <?php if (isset($type) && $type == '1') {
                                                  echo 'selected="selected"';
                                                } ?>><?php echo $this->lang->line('expired'); ?></option>
                            </select>
                          </div>
                        </div>

                      </div>
                      <div class="d-flex align-items-center notification-sort">
                        <img src="assets/img/frontend/ic-sort.png" alt="sort icon" class="img-fluid me-2">
                        <div class="custom-select mb-0 choose-order">
                          <select>
                            <option value="desc" selected><?php echo $this->lang->line('1310_newest'); ?></option>
                            <option value="asc" <?php if (isset($order_by) && $order_by == 'asc') {
                                                  echo 'selected="selected"';
                                                } ?>><?php echo $this->lang->line('1310_oldest'); ?></option>
                          </select>
                        </div>
                      </div>
                    </div>

                    <div class="table-responsive reservation-table">
                      <table class="table page-text-lg">
                        <thead>
                          <tr>
                            <th>Time</th>
                            <th>Name</th>
                            <th>ID</th>
                            <th>People</th>
                            <th><?php echo $this->lang->line('status'); ?></th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          foreach ($lists as $itemBook) { ?>
                            <tr>
                              <td><?php echo ddMMyyyy($itemBook['date_arrived'], 'd/m/Y'); ?><br><?php echo getOnlyHourMinute($itemBook['time_arrived']); ?></td>
                              <td>
                                <div class="hover-name-infor">
                                  <?php if(isset($itemBook['customer_first_name'])){ echo $itemBook['customer_first_name']; }else{ echo '-'; } ?>
                                  <div class="box-infor-search">
                                    <ul>
                                      <li>Account name: <span><?php echo $itemBook['customer_first_name']; ?> <?php echo $itemBook['customer_last_name']; ?></span></li>
                                      <li>Book name: <span><?php echo $itemBook['book_name']; ?></span></li>
                                      <li>Phone number: <span>+<?php echo $itemBook['phone_code']; ?><?php echo ltrim($itemBook['book_phone'], '0'); ?></span></li>
                                      <li>Reservation ID: <span><?php echo $itemBook['book_code']; ?></span></li>
                                      <li>Number of people: <span><?php echo $itemBook['number_of_people']; ?></span></li>
                                      <li>Date time: <span><?php echo ddMMyyyy($itemBook['date_arrived'], 'd/m/Y'); ?> - <?php echo getOnlyHourMinute($itemBook['time_arrived']); ?></span></li>
                                    </ul>
                                  </div>
                                </div>
                              </td>
                              <td><?php echo $itemBook['book_code']; ?></td>
                              <td><?php echo $itemBook['number_of_people']; ?></td>
                              <td>
                                <?php if ($itemBook['book_status_id'] == STATUS_ACTIVED && strtotime($itemBook['date_arrived'] . ' ' . $itemBook['time_arrived']) >= strtotime(date('Y-m-d H:i'))) { ?>
                                  <a href="<?php echo $basePagingUrl . '?type=' . STATUS_ACTIVED; ?>"><span class="badge badge-approved"><?php echo $this->lang->line('approved'); ?></span></a>
                                <?php } else  if ($itemBook['book_status_id'] == 1 || strtotime($itemBook['date_arrived'] . ' ' . $itemBook['time_arrived']) < strtotime(date('Y-m-d H:i'))) { ?>
                                  <a href="<?php echo $basePagingUrl . '?type=1'; ?>"><span class="badge badge-expire"><?php echo $this->lang->line('expired'); ?></span></a>
                                <?php } else if ($itemBook['book_status_id'] == 4) { ?>
                                  <a href="<?php echo $basePagingUrl . '?type=4'; ?>"><span class="badge badge-declined"><?php echo $this->lang->line('decline'); ?></span></a>
                                <?php } else if ($itemBook['book_status_id'] == 3) { ?>
                                  <a href="<?php echo $basePagingUrl . '?type=3'; ?>"><span class="badge badge-cancel"><?php echo $this->lang->line('cancelled'); ?></span></a>
                                <?php } ?>
                              </td>
                              <td>
                                <div class="d-flex justify-content-center">
                                  <?php if ($itemBook['book_status_id'] == STATUS_ACTIVED && strtotime($itemBook['date_arrived'] . ' ' . $itemBook['time_arrived']) >= strtotime(date('Y-m-d H:i'))) { ?>
                                    <button type="button" class="btn  btn-outline-red btn-outline-red-md fw-bold btn-ask-cancel-reservation" data-book="<?php echo $itemBook['id']; ?>" data-code="<?php echo $itemBook['book_code']; ?>"><?php echo $this->lang->line('decline'); ?></button>
                                  <?php } else if ($itemBook['book_status_id'] == 4 || $itemBook['book_status_id'] == 1 || $itemBook['book_status_id'] == 3 || strtotime($itemBook['date_arrived'] . ' ' . $itemBook['time_arrived']) < strtotime(date('Y-m-d H:i'))) { ?>
                                    <button type="button" class="btn  btn-outline-red btn-outline-red-md btn-outline-red-disabled" disabled><?php echo $this->lang->line('decline'); ?></button>
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
                          <p class="page-text-sm mb-0 me-3"><?php echo $this->lang->line('1310_showing'); ?> <span class="fw-500"><?php echo ($page - 1) * $perPage + 1; ?> – <?php echo ($page - 1) * $perPage + count($lists); ?></span> <?php echo $this->lang->line('1310_of'); ?> <span class="fw-500"><?php echo number_format($rowCount); ?></span>
                            <?php echo $this->lang->line('1310_results'); ?></p>
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
                            <span class=""> <?php echo $this->lang->line('1310_page'); ?></span>
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

                  <?php } else { ?>
                    <div class="zero-event zero-box zero-gray">
                      <img src="assets/img/frontend/img-empty-box.svg" alt="img-empty-box" class="img-fluid d-block mx-auto">
                      <p class="text-secondary page-text-lg">No reservations</p>
                    </div>
                  <?php } ?>
                </div>

                <!-- END -->




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
          <h3 class="text-center page-title-sm text-config"><?php echo $this->lang->line('setting_up_reservation'); ?>
          </h3>

          <div class="weekdays-selector">
            <input type="checkbox" id="weekday-mon" data-id="0" class="weekday weekday_0 <?php if (isset($reservationConfigs[0])) {
                                                                                            echo "saved";
                                                                                          } ?>" />
            <label for="weekday-mon"><?php echo $this->lang->line('mon'); ?></label>
            <input type="checkbox" id="weekday-tue" data-id="1" class="weekday weekday_1 <?php if (isset($reservationConfigs[1])) {
                                                                                            echo "saved";
                                                                                          } ?>" />
            <label for="weekday-tue"><?php echo $this->lang->line('tue'); ?></label>
            <input type="checkbox" id="weekday-wed" data-id="2" class="weekday weekday_2 <?php if (isset($reservationConfigs[2])) {
                                                                                            echo "saved";
                                                                                          } ?>" />
            <label for="weekday-wed"><?php echo $this->lang->line('wed'); ?></label>
            <input type="checkbox" id="weekday-thu" data-id="3" class="weekday weekday_3 <?php if (isset($reservationConfigs[3])) {
                                                                                            echo "saved";
                                                                                          } ?>" />
            <label for="weekday-thu"><?php echo $this->lang->line('thu'); ?></label>
            <input type="checkbox" id="weekday-fri" data-id="4" class="weekday weekday_4 <?php if (isset($reservationConfigs[4])) {
                                                                                            echo "saved";
                                                                                          } ?>" />
            <label for="weekday-fri"><?php echo $this->lang->line('fri'); ?></label>
            <input type="checkbox" id="weekday-sat" data-id="5" class="weekday weekday_5 <?php if (isset($reservationConfigs[5])) {
                                                                                            echo "saved";
                                                                                          } ?>" />
            <label for="weekday-sat"><?php echo $this->lang->line('sat'); ?></label>
            <input type="checkbox" id="weekday-sun" data-id="6" class="weekday weekday_6 <?php if (isset($reservationConfigs[6])) {
                                                                                            echo "saved";
                                                                                          } ?>" />
            <label for="weekday-sun"><?php echo $this->lang->line('sun'); ?></label>
          </div>

          <div class="wrapper-config">
            <input type="hidden" id="selecteDay" value="" />
            <input type="hidden" id="businessId" value="<?php echo $businessInfo['id']; ?>" />
            <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-md-between form-group mb-3 mb-lg-2">
              <p for="maxPeople" class="page-text-lg fw-500"><?php echo $this->lang->line('max_number_of_people_to_be_ser'); ?></p>
              <div class="wrapper-input">
                <input type="number" id="maxPeople" class="form-control square-input required-input">
              </div>
            </div>
            <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-md-between form-group mb-3 mb-lg-2">
              <p for="maxPerReservation" class="page-text-lg fw-500"><?php echo $this->lang->line('max_number_of_people_per_reser'); ?></p>
              <div class="wrapper-input">
                <input type="number" id="maxPerReservation" class="form-control  square-input required-input">
              </div>
            </div>
            <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-md-between form-group mb-3 mb-lg-2">
              <p for="duration" class="page-text-lg fw-500"><?php echo $this->lang->line('time_between_reservations'); ?></p>
              <div class="d-flex align-items-center wrapper-input">
                <input type="text" id="duration" class="form-control  square-input required-input">
                <span class="page-text-lg fw-500 ms-2"><?php echo $this->lang->line('minutes'); ?></span>
              </div>
            </div>
            <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-md-between form-group mb-3 mb-lg-2">
              <p for="startTime" class="page-text-lg fw-500"><?php echo $this->lang->line('start_taking_reservation_at'); ?></p>
              <div class="timepicker-wraper wrapper-input time-content">
                <input type="text" class="js-time-picker form-control datetimepicker-input required-input" id="startTime" data-toggle="datetimepicker" />
              </div>
            </div>
            <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-md-between form-group mb-3 mb-lg-2">
              <p for="endTime" class="page-text-lg fw-500"><?php echo $this->lang->line('closing_time'); ?></p>
              <div class="timepicker-wraper wrapper-input time-content">
                <input type="text" class="js-time-picker form-control datetimepicker-input required-input" id="endTime" data-toggle="datetimepicker" />
              </div>
            </div>
          </div>

          <div class="d-flex justify-content-center form-check apply-everyday">
            <input class="form-check-input" type="checkbox" id="config-everyday">
            <label class="form-check-label" for="config-everyday">
              <?php echo $this->lang->line('apply_to_everyday'); ?>
            </label>
          </div>

          <!-- Remove this line when valid content -->
          <p class="page-text-lg text-danger text-center fw-500"><?php echo $this->lang->line('important_you_need_to_fill_in_'); ?></p>

          <!-- Remove disabled when validate content -->
          <div class="modal-footer justify-content-center border-0 p-0">
            <button type="button" class="btn btn-red btn-red btn-save-config"><?php echo $this->lang->line('save_changes'); ?></button>
            <button type="button" class="btn btn-outline-red" data-bs-dismiss="modal"><?php echo $this->lang->line('cancel'); ?></button>
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
        <p class="text-center page-text-lg">Are you sure want to decline the reservation "<b id="reservationCode"></b>"?
        </p>
        <input type="hidden" id="selectedBookId" value="" />
        <div class="d-flex justify-content-center">
          <a href="javascript:void(0)" class="btn btn-red btn-yes btn-cancel-reservation"><?php echo $this->lang->line('yes'); ?></a>
          <a href="javascript:void(0)" class="btn btn-outline-red btn-cancel" data-bs-dismiss="modal"><?php echo $this->lang->line('cancel'); ?></a>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Modal confirm remove -->

<script>
  function findNextDay() {
    $(".weekday").each(function() {
      if (!$(this).hasClass("saved")) {
        $(this).prop('checked', true);
        $("#selecteDay").val($(this).data('id'));
        console.log($(this).data('id'));
        $("#maxPeople").val("");
        $("#maxPerReservation").val("");
        $("#duration").val("");
        $("#startTime").val("");
        $("#endTime").val("");
        console.log('find next done');
        return false;
      }
    });
  }

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
            $(".notiPopup").fadeIn('slow').fadeOut(5000);
          }
        });
      } else {
        $(".notiPopup .text-secondary").html("Selected day not exist");
        $(".ico-noti-error").removeClass('ico-hidden');
        $(".notiPopup").fadeIn('slow').fadeOut(5000);
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
        $(".notiPopup").fadeIn('slow').fadeOut(5000);
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
              //add saved
              $(".weekday_" + day_id).prop('checked', false);
              $(".weekday_" + day_id).addClass('saved');
              console.log('find next');
              findNextDay();

              $(".notiPopup .text-secondary").html("Save config successfully");
              $(".ico-noti-success").removeClass('ico-hidden');
              $(".notiPopup").fadeIn('slow').fadeOut(5000);



            } else {
              //add saved
              $(".weekday_" + day_id).addClass('saved');
              console.log('find next');
              findNextDay();

              $(".notiPopup .text-secondary").html(json.message);
              $(".ico-noti-error").removeClass('ico-hidden');
              $(".notiPopup").fadeIn('slow').fadeOut(5000);
            }
          },
          error: function(json) {
            $(".notiPopup .text-secondary").html("Save config failed");
            $(".ico-noti-error").removeClass('ico-hidden');
            $(".notiPopup").fadeIn('slow').fadeOut(5000);
          }
        });
      } else {
        $(".notiPopup .text-secondary").html("Save config failed");
        $(".ico-noti-error").removeClass('ico-hidden');
        $(".notiPopup").fadeIn('slow').fadeOut(5000);
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
            $(".notiPopup").fadeIn('slow').fadeOut(5000);

          } else {
            $(".notiPopup .text-secondary").html(json.message);
            $(".ico-noti-error").removeClass('ico-hidden');
            $(".notiPopup").fadeIn('slow').fadeOut(5000);
          }
        },
        error: function(json) {
          $(".notiPopup .text-secondary").html("Change status failed");
          $(".ico-noti-error").removeClass('ico-hidden');
          $(".notiPopup").fadeIn('slow').fadeOut(5000);
        }
      });
    });

    // change date 
    var dateNow = new Date();
    $("#reservation-date").datetimepicker({
      defaultDate: dateNow,
      format: "YYYY-MM-DD",
      minDate: moment(),
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
            $(".notiPopup").fadeIn('slow').fadeOut(5000);
          } else {
            $(".notiPopup .text-secondary").html(data.message);
            $(".ico-noti-error").removeClass('ico-hidden');
            $(".notiPopup").fadeIn('slow').fadeOut(5000);
          }
          redirect(true);
        },
        error: function(data) {
          $(".notiPopup .text-secondary").html("Declined failed");
          $(".ico-noti-error").removeClass('ico-hidden');
          $(".notiPopup").fadeIn('slow').fadeOut(5000);

          redirect(true);
        }
      });

    });


  });
</script>