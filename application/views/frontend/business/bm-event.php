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
            <div class="um-right">
              <div class="bp-event um-event bm-event">
                <div class="bp-event-content bm-event-content">
                  <div class="text-right">
                    <a href="<?php echo base_url('business-management/' . $businessInfo['business_url'] . '/create-event') ?>" class="btn btn-red btn-red-md btn-create-event d-inline-block"><?php echo $this->lang->line('create_new_event'); ?></a>
                  </div>
                    <form class="d-flex search-box" action="<?php echo $basePagingUrl; ?>" method="GET" name="searchForm">
                      <a href="javascript:void(0)" class="search-box-icon" onclick="document.searchForm.submit();"><img src="assets/img/frontend/ic-search.png" alt="search icon"></a>
                      <input class="form-control" type="text" placeholder="<?php echo $this->lang->line('search'); ?>" aria-label="<?php echo $this->lang->line('search'); ?>" name="keyword" value="<?php echo $keyword; ?>" >
                    </form>

                  <?php if (!empty($lists) > 0) { ?>
                    <div class="notification-wrapper-filter d-flex align-items-center justify-content-md-between">
                      
                      <div class="d-flex align-items-center inner-filter">
                        <!--
                        <span class="me-2 page-text-lg fw-bold"><?php echo $this->lang->line('filter_by'); ?></span>
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
                        -->
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

                    <div class="bp-event-list bm-event-list">
                      <?php foreach ($lists as $key => $eventItem) {
                        $eventDetailUrl = base_url('event/' . makeSlug($eventItem['event_subject']) . '-' . $eventItem['id']) . '.html?editable=1'; ?>
                        <div class="position-elative">
                          <a href="<?php echo $eventDetailUrl; ?>" class="w-100 d-flex flex-column flex-lg-row customer-event-item">
                            <span class="event-img">
                              <img src="<?php echo $eventItem['event_image']; ?>" alt="<?php echo $eventItem['event_subject']; ?>">
                            </span>
                            <div class="event-text">
                              <span class="event-header page-text-lg fw-500"><?php echo $eventItem['event_subject']; ?></span>
                              <p class="mb-0">By <?php echo $eventItem['business_name']; ?></p>
                              <hr class="my-2 my-lg-3">
                              <p class="event-date page-text-sm"><?php echo ddMMyyyy($eventItem['start_date'], 'M d, Y'); ?> - <?php echo ddMMyyyy($eventItem['end_date'], 'M d, Y'); ?></p>
                              <p class="mb-0 event-time page-text-sm"><?php echo ddMMyyyy($eventItem['start_time'], 'H:i'); ?> - <?php echo ddMMyyyy($eventItem['end_time'], 'H:i'); ?></p>
                              <?php 
                                $event_class = 'badge-primary';
                                $event_text = 'Upcomming';
                                $timeStart = strtotime(ddMMyyyy($eventItem['start_date'], 'Y-m-d').' '.ddMMyyyy($eventItem['start_time'], 'H:i'));
                                $timeEnd = strtotime(ddMMyyyy($eventItem['end_date'], 'Y-m-d').' '.ddMMyyyy($eventItem['end_time'], 'H:i'));
                                $timeCurrent = strtotime(date('Y-m-d H:i'));
                                if($timeStart <= $timeCurrent){
                                  $event_class = 'badge-approved';
                                  $event_text = 'Ongoing';
                                }else if($timeStart >= $timeCurrent){
                                  $event_class = 'badge-expire';
                                  $event_text = 'Expired';
                                }
                              ?>
                              <div class="badge <?php echo $event_class; ?> bm-event-status"><?php echo $event_text; ?></div>
                            </div>
                          </a>
                          <div class="bm-event-actions" style="display:none;">
                            <a href="bm-event-edit.html" class="event-edit page-text-xs mt-2 text-decoration-underline"><?php echo $this->lang->line('edit'); ?></a>
                            <a href="#bmEventModal" data-bs-toggle="modal" class="event-cancel page-text-xs mt-2 text-decoration-underline"><?php echo $this->lang->line('cancel'); ?></a>
                          </div>
                        </div>
                      <?php } ?>
                    </div>
                  <?php } else { ?>
                    <div class="zero-event zero-box">
                      <img src="assets/img/frontend/img-empty-box.svg" alt="img-empty-box" class="img-fluid d-block mx-auto">
                      <p class="text-secondary page-text-lg">No events</p>
                    </div>
                  <?php } ?>

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

                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal Event Cancel -->
    <div class="modal fade" id="bmEventModal" tabindex="-1" aria-labelledby="bmEventModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-body">
            <p class="page-text-lg text-center">Are you sure want to remove the coupon
              <b>50% OFF for all new customers?</b>
            </p>

            <div class="d-flex justify-content-center modal-btn mt-60">
              <a href="javascript:void(0)" class="btn btn-red btn-yes" data-bs-dismiss="modal"><?php echo $this->lang->line('yes'); ?></a>
              <a href="javascript:void(0)" class="btn btn-outline-red btn-outline-red-md ml-10 btn-cancel" data-bs-dismiss="modal"><?php echo $this->lang->line('cancel'); ?></a>

            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- End Modal Event Cancel -->
  </div>
</main>
<input type="hidden" id="currentBaseUrl" value="<?php echo $basePagingUrl; ?>" />
<?php $this->load->view('frontend/includes/footer'); ?>