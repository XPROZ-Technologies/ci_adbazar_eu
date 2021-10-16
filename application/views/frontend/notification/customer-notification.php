<?php $this->load->view('frontend/includes/header'); ?>
<main>
  <div class="page-notification">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-8">
          <div class="notification">
            <div class="bg-white notification-content">
              <div class="d-flex justify-content-between align-items-center">
                <h2 class="page-heading page-title-xs mb-3 mb-md-4">Notifications</h2>
                <form class="d-flex search-box">
                  <a href="#" class="search-box-icon"><img src="assets/img/frontend/ic-search.svg" alt="search icon"></a>
                  <input class="form-control" type="text" placeholder="Search" aria-label="Search">
                </form>
              </div>
              <div class="wrapper-content">
                <div class="notification-wrapper-filter d-flex flex-column flex-md-row align-items-md-center justify-content-between">
                  <div class="d-flex align-items-center inner-filter">
                    <span class="me-2 page-text-lg"><?php echo $this->lang->line('filter_by'); ?></span>
                    <div class="notification-filter">
                      <div class="custom-select">
                        <select>
                          <option value="0" selected>All</option>
                          <option value="1">Personal</option>
                          <!--
                          <option value="2">The Rice Bowl</option>
                          <option value="3">Inspire Beauty Salon</option>
                          -->
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="d-flex align-items-center notification-sort">
                    <img src="assets/img/frontend/ic-sort.svg" alt="sort icon" class="img-fluid me-2">
                    <div class="custom-select mb-0 choose-order">
                      <select>
                        <option value="desc" ><?php echo $this->lang->line('1310_newest'); ?></option>
                        <option value="asc" <?php if (isset($order_by) && $order_by == 'asc') {
                                                echo 'selected="selected"';
                                              } ?> ><?php echo $this->lang->line('1310_oldest'); ?></option>
                      </select>
                    </div>
                  </div>
                </div>
                <?php if (empty($lists)) { ?>
                  <div class="notification-zero zero-box">
                    <img src="assets/img/frontend/img-empty-box.svg" alt="empty box" class="img-fluid d-block mx-auto">
                    <p class="page-text-lg text-center text-secondary">You do not have any notification yet</p>
                  </div>
                <?php } else { ?>
                  <div class="notification-list">
                    <?php foreach ($lists as $itemNoti) { ?>
                      <div class="notification-item">
                        <?php if($itemNoti['notification_status_id'] == STATUS_ACTIVED){ ?>
                          <img src="assets/img/frontend/icon-new-badge.png" alt="icon-new-badge" class="notification-badge" />
                        <?php } ?>
                        <div class="notification-img">
                          <img src="<?php echo $itemNoti['image']; ?>" alt="notification image" class="img-fluid">
                        </div>
                        <div class="notification-body">
                          <p><?php echo $itemNoti['text']; ?></p>
                          <span class="notification-date"><?php echo ddMMyyyy($itemNoti['created_at'] ,'Y-m-d H:i'); ?></span>
                        </div>
                      </div>
                    <?php } ?>
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
<input type="hidden" id="currentBaseUrl" value="<?php echo base_url('notifications.html'); ?>" />
<?php $this->load->view('frontend/includes/footer'); ?>