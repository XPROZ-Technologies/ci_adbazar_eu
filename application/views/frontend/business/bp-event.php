<?php $this->load->view('frontend/includes/header'); ?>
<main>
  <div class="page-business-profile">
    <?php $this->load->view('frontend/includes/business_top_header'); ?>

    <div class="bp-tabs">
      <div class="container">
        <div class="row">
          <div class="col-lg-4">
            <?php $this->load->view('frontend/includes/business_nav_sidebar'); ?>
          </div>
          <div class="col-lg-8">
            <div class="bp-tabs-right">
              <div class="bp-event">
                <div class="bp-event-content">
                  <div class="wrapper-search">
                    <form class="d-flex search-box" action="<?php echo $basePagingUrl; ?>" method="GET" name="searchForm">
                      <a href="javascript:void(0)" class="search-box-icon" onclick="document.searchForm.submit();"><img src="assets/img/frontend/ic-search.png" alt="search icon"></a>
                      <input class="form-control" type="text" placeholder="<?php echo $this->lang->line('search'); ?>" aria-label="<?php echo $this->lang->line('search'); ?>" name="keyword" value="<?php echo $keyword; ?>">
                    </form>
                  </div>
                  <?php if (!empty($lists) > 0) { ?>
                    <div class="bp-event-list">

                      <!-- item event -->
                      <?php foreach ($lists as $key => $eventItem) {
                        $eventDetailUrl = base_url('event/' . makeSlug($eventItem['event_subject']) . '-' . $eventItem['id']) . '.html'; ?>
                        <div class="w-100 d-flex flex-column flex-lg-row customer-event-item event-item-<?php echo $eventItem['id']; ?>">
                          <a href="<?php echo $eventDetailUrl; ?>" class="event-img">
                            <img src="<?php echo $eventItem['event_image']; ?>" alt="event image">
                          </a>
                          <div class="event-text">
                            <a href="<?php echo $eventDetailUrl; ?>" class="event-header page-text-lg fw-500"><?php echo $eventItem['event_subject']; ?></a>
                            <p class="mb-0">By <?php echo $eventItem['business_name']; ?></p>
                            <hr class="my-2 my-lg-3">
                            <p class="event-date page-text-sm"><?php echo ddMMyyyy($eventItem['start_date'], 'M d, Y'); ?> - <?php echo ddMMyyyy($eventItem['end_date'], 'M d, Y'); ?></p>
                            <p class="mb-0 event-time page-text-sm"><?php echo ddMMyyyy($eventItem['start_time'], 'H:i'); ?> - <?php echo ddMMyyyy($eventItem['end_time'], 'H:i'); ?></p>

                            <a href="javascript:void(0)" class="event-join btn btn-outline-red mt-2 mt-lg-0 join-event-in-list" data-id="<?php echo $eventItem['id']; ?>" data-customer="<?php echo $customer['id']; ?>" ><?php echo $this->lang->line('join'); ?></a>
                          </div>
                        </div>
                      <?php } ?>
                      <!-- END. item event -->

                    </div>
                  <?php } else { ?>
                    <div class="zero-event zero-box">
                      <img src="assets/img/frontend/img-empty-box.svg" alt="img-empty-box" class="img-fluid d-block mx-auto">
                      <p class="text-secondary page-text-lg"><?php echo $this->lang->line('no_upcoming_event_on_this_day'); ?></p>
                    </div>
                  <?php } ?>
                  <!-- Pagination -->
                  <?php if (!empty($lists) > 0) { ?>
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
                  <?php } ?>
                  <!-- END. Pagination -->

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