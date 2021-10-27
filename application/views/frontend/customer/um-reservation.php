<?php $this->load->view('frontend/includes/header'); ?>
<main>
  <div class="page-user-manager">
    <!-- Customer Tab Header -->
    <?php $this->load->view('frontend/includes/customer_tab_header'); ?>

    <div class="um-content">
      <div class="container">
        <div class="row">
          <div class="col-lg-3">
            <!-- Customer Menu Sidebar -->
            <?php $this->load->view('frontend/includes/customer_nav_sidebar'); ?>
          </div>
          <div class="col-lg-9">
            <div class="um-right">
              <div class="bp-reservation um-reservation">
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
                <div class="bp-reservation-inner um-reservation-inner">
                  <div class="bg-f5">
                  <?php if (!empty($lists)) { ?>
                    <form class="d-flex search-box">
                      <a href="#" class="search-box-icon"><img src="assets/img/frontend/ic-search.png" alt="search icon"></a>
                      <input class="form-control w-100" type="text" placeholder="<?php echo $this->lang->line('search'); ?>" aria-label="<?php echo $this->lang->line('search'); ?>">
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
                            <th>Business</th>
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
                                <td>
                                  <a href="<?php if(isset($itemBook['business_url'])){ echo base_url($itemBook['business_url']); }else{ echo 'javascript:void(0)'; } ?>"><?php if(isset($itemBook['business_name'])){ echo getNumberOfWords($itemBook['business_name']," ", 2); }else{ echo '-'; } ?></a>
                                </td>
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
<?php $this->load->view('frontend/includes/footer'); ?>
<script>
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
    console.log(selectedDate !== undefined);
    if(selectedDate !== undefined){
      dateNow = selectedDate;
    }
    console.log(dateNow);
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
  });
</script>