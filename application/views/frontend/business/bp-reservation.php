<?php $this->load->view('frontend/includes/header'); ?>
<main>
  <div class="page-business-profile page-bp-reservation">

    <?php $this->load->view('frontend/includes/business_top_header'); ?>

    <div class="bp-tabs">
      <div class="container">
        <div class="row">
          <div class="col-lg-4">
            <?php $this->load->view('frontend/includes/business_nav_sidebar'); ?>
          </div>
          <div class="col-lg-8">
            <div class="bp-tabs-right">
              <div class="bp-reservation">
                <div class="bp-reservation-inner">
                  <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-lg-between reservation-top">
                    <?php $my_reservations_at_inspire_beauty_salon = $this->lang->line('my_reservations_at_inspire_beauty_salon');
                    $my_reservations_at_inspire_beauty_salon = explode('<Inspire Beauty Salon>', $my_reservations_at_inspire_beauty_salon);
                    ?>
                    <h5 class="page-title-xs mb-lg-0"><?php echo $my_reservations_at_inspire_beauty_salon[0]; ?> <?php echo $businessInfo['business_name']; ?><?php echo $my_reservations_at_inspire_beauty_salon[1]; ?></h5>
                    <?php if ($businessInfo['allow_book'] == STATUS_ACTIVED) { ?>
                      <a href="<?php echo base_url('business/' . $businessInfo['business_url'] . '/book-reservation'); ?>" class="btn btn-red"><?php echo $this->lang->line('book_a_reservation'); ?></a>
                    <?php } ?>
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

                      <!-- Filter -->
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
                      <!-- END. Filter -->

                      <div class="table-responsive reservation-table">
                        <table class="table page-text-lg">
                          <thead>
                            <tr>
                              <th>Time</th>
                              <th>ID</th>
                              <th>People</th>
                              <th><?php echo $this->lang->line('status'); ?></th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>

                            <?php if (!empty($lists)) {
                              foreach ($lists as $itemBook) { ?>

                                <tr>
                                  <td><?php echo ddMMyyyy($itemBook['date_arrived'], 'd/m/Y'); ?><br><?php echo getOnlyHourMinute($itemBook['time_arrived']); ?></td>

                                  <td><?php echo $itemBook['book_code']; ?></td>
                                  <td><?php echo $itemBook['number_of_people']; ?></td>
                                  <td>
                                    <?php if ($itemBook['book_status_id'] == STATUS_ACTIVED && strtotime($itemBook['date_arrived'] . ' ' . $itemBook['time_arrived']) >= strtotime(date('Y-m-d H:i'))) { ?>
                                      <a href="<?php echo $basePagingUrl . '?type=' . STATUS_ACTIVED; ?>"><span class="badge badge-approved"><?php echo $this->lang->line('approved'); ?></span></a>
                                    <?php } else if ($itemBook['book_status_id'] == 1 || $itemBook['book_status_id'] == 4 || strtotime($itemBook['date_arrived'] . ' ' . $itemBook['time_arrived']) < strtotime(date('Y-m-d H:i'))) { ?>
                                      <a href="<?php echo $basePagingUrl . '?type=1'; ?>"><span class="badge badge-expire"><?php echo $this->lang->line('expired'); ?></span></a>
                                    <?php } else if ($itemBook['book_status_id'] == 3) { ?>
                                      <a href="<?php echo $basePagingUrl . '?type=3'; ?>"><span class="badge badge-cancel"><?php echo $this->lang->line('cancelled'); ?></span></a>
                                    <?php } else if ($itemBook['book_status_id'] == 4) { ?>
                                      <a href="<?php echo $basePagingUrl . '?type=4'; ?>"><span class="badge badge-declined"><?php echo $this->lang->line('decline'); ?></span></a>
                                    <?php } ?>
                                  </td>
                                  <td>
                                    <div class="d-flex justify-content-center">
                                      <?php if ($itemBook['book_status_id'] == STATUS_ACTIVED && strtotime($itemBook['date_arrived'] . ' ' . $itemBook['time_arrived']) >= strtotime(date('Y-m-d H:i'))) { ?>
                                        <button data-book="<?php echo $itemBook['id']; ?>" data-code="<?php echo $itemBook['book_code']; ?>" type="button" class="btn  btn-outline-red btn-outline-red-md fw-bold btn-ask-cancel-reservation"><?php echo $this->lang->line('cancel'); ?></button>
                                      <?php } else if ($itemBook['book_status_id'] == 4 || $itemBook['book_status_id'] == 1 || $itemBook['book_status_id'] == 3 || strtotime($itemBook['date_arrived'] . ' ' . $itemBook['time_arrived']) < strtotime(date('Y-m-d H:i'))) { ?>
                                        <button type="button" class="btn  btn-outline-red btn-outline-red-md btn-outline-red-disabled" disabled><?php echo $this->lang->line('cancel'); ?></button>
                                      <?php } ?>
                                  </td>

                                </tr>
                            <?php }
                            } ?>

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

                </div>
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

<!-- Reservation Modal -->
<div class="modal fade" id="reservationModal" tabindex="-1" aria-labelledby="reservationModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body">
        <h5 class="page-title-xs text-center"><?php echo $this->lang->line('your_reservation_at__inspire_beauty_salon_at_1'); ?><?php echo $businessInfo['business_name']; ?> <?php echo $this->lang->line('your_reservation_at__inspire_beauty_salon_at_1'); ?> <?php echo $bookInfo['time_arrived']; ?> <?php echo $this->lang->line('your_reservation_at__inspire_beauty_salon_at_3'); ?> <?php echo $this->Mconstants->dayIds[(int)ddMMyyyy($bookInfo['date_arrived'], 'w')]; ?>, <?php echo ddMMyyyy($bookInfo['date_arrived'], 'F m,Y'); ?> for <?php echo $bookInfo['number_of_people']; ?> <?php echo $this->lang->line('your_reservation_at__inspire_beauty_salon_at_4'); ?></h5>
        <p class="text-warning text-center page-text-lg">
          <img src="assets/img/frontend/ic-warning.svg" alt="ic-warning" class="img-fluid">
          <?php echo $this->lang->line('please_arrive_no_later_than_15_minutes_for_yo'); ?>
        </p>
        <p class="page-text-md text-center"><?php echo $this->lang->line('we_will_send_you_a_notification_if_your_reser'); ?>
        </p>
        <div class="d-sm-flex justify-content-center wrapper-btn">
          <button class="btn btn-outline-red btn-ok " data-bs-dismiss="modal">OK</button>
          <button class="btn btn-red btn-other-reservation"><?php echo $this->lang->line('make_another_reservation'); ?></button>
        </div>
        <div class="text-center">
          <a href="<?php echo base_url('customer/my-reservation'); ?>" class="page-text-md text-underline fw-bold"><?php echo $this->lang->line('see_all_of_my_reservation'); ?></a>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Reservation Modal -->

<!-- Modal confirm remove -->
<div class="modal fade" id="removeEventModal" tabindex="-1" aria-labelledby="removeEventModalLabel" aria-hidden="true">

  <div class="modal-dialog modal-dialog-centered modal-medium">
    <div class="modal-content">
      <div class="modal-header border-bottom-0">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p class="text-center page-text-lg">Are you sure want to cancel the reservation
          "<b id="reservationCode"></b>"?
        </p>
        <input type="hidden" id="selectedBookId" value="" />
        <div class="d-flex justify-content-center">
          <a href="javascript:void(0)" class="btn btn-red btn-yes btn-cancel-reservation"><?php echo $this->lang->line('yes'); ?></a>
          <a href="javascript:void(0)" class="btn btn-outline-red btn-cancel" data-bs-dismiss="modal">Cancel</a>
        </div>

      </div>
    </div>
  </div>
</div>
<!-- End Modal confirm remove -->

<script>
    // change date 
    function GetURLParameter(sParam) {
    var sPageURL = window.location.search.substring(1);
    var sURLVariables = sPageURL.split('?');
    for (var i = 0; i < sURLVariables.length; i++) {
        var sParameterName = sURLVariables[i].split('=');
        if (sParameterName[0] == sParam) {
            return sParameterName[1];
        }
    }
}
  $(document).ready(function() {
    // change date 
    var dateNow = new Date();
    var selectedDate = GetURLParameter('selected_day');
    if(selectedDate !== undefined){
      dateNow = selectedDate;
    }
    $("#selecteDate").datetimepicker({
      defaultDate: dateNow,

      //minDate: moment(),
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
      redirect(false, 'customer/my-reservation?selected_day=' + formatDay);
    });
 
    $('#selecteDate').on('dp.change', function(e) {
      var formatedValue = e.date.format(e.date._f);
      var formatDay = moment(formatedValue).format('YYYY-MM-DD');
      console.log(formatDay);
      redirect(false, '<?php echo $basePagingUrl; ?>?selected_day=' + formatDay);
    });
  });

  $(window).ready(() => {
    <?php
    $bookSuccess = $this->session->flashdata('book_success');
    if (!empty($bookSuccess)) {
    ?>
      $("#reservationModal").modal('show');
    <?php } ?>

    $(".btn-other-reservation").click(function() {
      redirect(false, '<?php echo base_url('business/' . $businessInfo['business_url'] . '/book-reservation'); ?>');
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
        url: '<?php echo base_url('reservation/customer-cancel-reservation'); ?>',
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
          $(".notiPopup .text-secondary").html("Cancellation failed");
          $(".ico-noti-error").removeClass('ico-hidden');
          $(".notiPopup").fadeIn('slow').fadeOut(5000);

          redirect(true);
        }
      });

    });
  });
</script>