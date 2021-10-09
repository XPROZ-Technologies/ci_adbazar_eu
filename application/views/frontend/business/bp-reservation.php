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
                    <h5 class="page-title-xs mb-lg-0">My reservation(s) at <?php echo $businessInfo['business_name']; ?></h5>
                    <a href="<?php echo base_url('business/' . $businessInfo['business_url'] . '/book-reservation'); ?>" class="btn btn-red">Book a reservation</a>
                  </div>
                  <div class="bg-f5">
                    <form class="d-flex search-box" action="<?php echo $basePagingUrl; ?>" method="GET" name="searchForm">
                      <a  href="javascript:void(0)" class="search-box-icon" onclick="document.searchForm.submit();"><img src="assets/img/frontend/ic-search.png" alt="search icon"></a>
                      <input class="form-control" type="text" placeholder="Search" aria-label="Search" name="keyword" value="<?php echo $keyword; ?>">
                    </form>

                    <div class="table-responsive reservation-table">
                      <table class="table page-text-lg">
                        <thead>
                          <tr>
                            <th>Date</th>
                            <th>Time</th>
                            <th>ID</th>
                            <th>People</th>
                            <th>Status</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php if (!empty($lists)) {
                            foreach ($lists as $itemBook) { ?>
                              <tr>
                                <td><?php echo $itemBook['date_arrived']; ?></td>
                                <td><?php echo $itemBook['time_arrived']; ?></td>
                                <td><?php echo $itemBook['book_code']; ?></td>
                                <td><?php echo $itemBook['number_of_people']; ?></td>
                                <td>
                                  <?php if ($itemBook['book_status_id'] == STATUS_ACTIVED) { ?>
                                    <span class="badge badge-approved">Approved</span>
                                  <?php } ?>
                                  <?php if ($itemBook['book_status_id'] == 1) { ?>
                                    <span class="badge badge-expire">Expired</span>
                                  <?php } ?>
                                  <?php if ($itemBook['book_status_id'] == 3 || $itemBook['book_status_id'] == 4) { ?>
                                    <span class="badge badge-declined">Declined</span>
                                  <?php } ?>
                                </td>
                                <td>
                                  <div class="d-flex justify-content-center">
                                    <?php if ($itemBook['book_status_id'] == STATUS_ACTIVED) { ?>
                                      <button type="button" class="btn  btn-outline-red btn-outline-red-md fw-bold">Cancel</button>
                                    <?php } ?>
                                    <?php if ($itemBook['book_status_id'] == 4 || $itemBook['book_status_id'] == 1 || $itemBook['book_status_id'] == 3) { ?>
                                      <button type="button" class="btn  btn-outline-red btn-outline-red-md btn-outline-red-disabled" disabled>Cancel</button>
                                    <?php } ?>
                                  </div>
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
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
<input type="hidden" id="currentBaseUrl" value="<?php echo $basePagingUrl; ?>" />
<?php $this->load->view('frontend/includes/footer'); ?>

<!-- Reservation Modal -->
<div class="modal fade" id="reservationModal" tabindex="-1" aria-labelledby="reservationModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body">
        <h5 class="page-title-xs text-center">Your reservation at Inspire Beauty Salon at 10:00AM on Thursday, July 10, 2021 for 2 people has been booked.</h5>
        <p class="text-warning text-center page-text-lg">
          <img src="assets/img/frontend/ic-warning.svg" alt="ic-warning" class="img-fluid">
          Please, arrive no later than 15 minutes for your scheduled appointment time.
        </p>
        <p class="page-text-md text-center">We will send you a notification if your reservation is declined by the business owner.
          <br> Thank you so much.
        </p>
        <div class="d-sm-flex justify-content-center wrapper-btn">
          <button class="btn btn-outline-red btn-ok " data-bs-dismiss="modal">OK</button>
          <button class="btn btn-red btn-other-reservation">Make another reservation</button>
        </div>
        <div class="text-center">
          <a href="<?php echo base_url('customer/my-reservation'); ?>" class="page-text-md text-underline fw-bold">See all of my reservation</a>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Reservation Modal -->

<script>
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
  });
</script>