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
              <div class="bp-event um-event">
                <div class="bp-event-content um-event-content">
                  <form class="d-flex search-box" action="<?php echo $basePagingUrl; ?>" method="GET" name="searchForm">
                    <a href="javascript:void(0)" class="search-box-icon" onclick="document.searchForm.submit();"><img src="assets/img/frontend/ic-search.png" alt="search icon"></a>
                    <input class="form-control w-100" type="text" placeholder="Search" aria-label="Search" name="keyword" value="<?php echo $keyword; ?>">
                  </form>
                  <?php if (!empty($lists) > 0 && count($joinedEvents) > 0) { ?>
                    <!-- List event -->
                    <div class="bp-event-list um-event-list">
                      <!-- Event item -->
                      <?php foreach ($lists as $key => $eventItem) {
                        $eventDetailUrl = base_url('event/' . makeSlug($eventItem['event_subject']) . '-' . $eventItem['id']) . '.html'; ?>
                        <div class="w-100 d-flex flex-column flex-lg-row customer-event-item">
                          <a href="<?php echo $eventDetailUrl; ?>" class="event-img">
                            <img src="<?php echo $eventItem['event_image']; ?>" alt="<?php echo $eventItem['event_subject']; ?>">
                          </a>
                          <div class="event-text">
                            <a href="<?php echo $eventDetailUrl; ?>" class="event-header page-text-lg fw-500"><?php echo $eventItem['event_subject']; ?></a>
                            <p class="mb-0">By <?php echo $eventItem['business_name']; ?></p>
                            <hr class="my-2 my-lg-3">
                            <p class="event-date page-text-sm"><?php echo ddMMyyyy($eventItem['start_date'], 'M d, Y'); ?> - <?php echo ddMMyyyy($eventItem['end_date'], 'M d, Y'); ?></p>
                            <p class="mb-0 event-time page-text-sm"><?php echo ddMMyyyy($eventItem['start_time'], 'H:i'); ?> - <?php echo ddMMyyyy($eventItem['end_time'], 'H:i'); ?></p>

                            <a href="javascript:void(0)" data-bs-toggle="modal" class="event-remove mt-2 fw-bold" data-id="<?php echo $eventItem['id']; ?>" data-name="<?php echo $eventItem['event_subject']; ?>">Remove</a>
                          </div>
                        </div>
                      <?php } ?>
                      <!-- END. event item -->
                    </div>
                    <!-- END. List event -->
                  <?php } else { ?>
                    <div class="zero-event zero-box">
                      <img src="assets/img/frontend/img-empty-box.svg" alt="img-empty-box" class="img-fluid d-block mx-auto">
                      <p class="text-secondary page-text-lg">No events</p>
                    </div>
                  <?php } ?>

                  <?php if (count($lists) > 0 && count($joinedEvents) > 0) { ?>
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
                          <span class="">Page</span>
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

  <!-- Modal confirm remove -->
  <div class="modal fade" id="removeEventModal" tabindex="-1" aria-labelledby="removeEventModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-medium">
      <div class="modal-content">
        <div class="modal-header border-bottom-0">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p class="text-center page-text-lg" id="selected-name-event">Are you sure want to remove the event
            "<b></b>"?
          </p>
          <input type="hidden" id="selected-customer-event" value="<?php echo $customer['id']; ?>" />
          <input type="hidden" id="selected-id-event" value="0" />
          <div class="d-flex justify-content-center">
            <a href="javascript:void(0)" class="btn btn-red btn-yes btn-remove-event">Yes</a>
            <a href="javascript:void(0)" class="btn btn-outline-red btn-cancel" data-bs-dismiss="modal">Cancel</a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- End Modal confirm remove -->
</main>
<input type="hidden" id="currentBaseUrl" value="<?php echo $basePagingUrl; ?>" />
<?php $this->load->view('frontend/includes/footer'); ?>
<script>
  $('.event-remove').click(function() {
    $("#selected-id-event").val($(this).data('id'));
    $("#selected-name-event b").html($(this).data('name'));
    $("#removeEventModal").modal("show");
  });

  $('.btn-remove-event').click(function() {
    $.ajax({
      type: "POST",
      url: '<?php echo base_url('customer-left-event'); ?>',
      data: {
        event_id: $("#selected-id-event").val(),
        customer_id: $("#selected-customer-event").val()
      },
      dataType: "json",
      success: function(response) {
        if (response.code == 1) {
          //$("#removeEventModal").modal("show");
          redirect(true);
        }

      },
      error: function(response) {
        // showNotification($('input#errorCommonMessage').val(), 0);
        // $('.submit').prop('disabled', false);
      }
    });
  });
</script>