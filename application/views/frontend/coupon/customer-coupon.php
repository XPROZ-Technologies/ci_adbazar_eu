<?php $this->load->view('frontend/includes/header'); ?>
<main>
  <div class="page-customer-coupon">
    <div class="customer-coupon">
      <div class="container">
        <div class="wrapper-search d-md-flex  justify-content-between">
          <h2 class="page-heading page-title-md text-black mb-3 mb-md-0 fw-bold"><?php echo $this->lang->line('all_coupons'); ?></h2>
          <form class="d-flex search-box" action="<?php echo $basePagingUrl; ?>" method="GET" name="searchForm">
            <a href="javascript:void(0)" class="search-box-icon" onclick="document.searchForm.submit();"><img src="assets/img/frontend/ic-search.png" alt="search icon"></a>
            <input class="form-control" type="text" placeholder="Search" aria-label="Search" name="keyword" value="<?php echo $keyword; ?>">
          </form>
        </div>
        <div class="notification-wrapper-filter">
          <div class="d-flex align-items-center inner-filter">
            <span class="me-2 page-text-lg">Filter by</span>
            <div class="notification-filter">
              <div class="custom-select choose-service">
                <select>
                  <option value="0" selected><?php echo $this->lang->line('all'); ?></option>
                  <?php if ($listServices) { foreach($listServices as $itemService){ ?>
                    <option value="<?php echo $itemService['id']; ?>" <?php  if(isset($service) && $itemService['id'] == $service){ echo 'selected="selected"'; } ?> ><?php echo $itemService['service_name']; ?></option>
                  <?php } } ?>
                </select>
              </div>
            </div>
          </div>
          <div class="d-flex align-items-center notification-sort">
            <img src="assets/img/frontend/ic-sort.png" alt="sort icon" class="img-fluid me-2">
            <div class="custom-select mb-0 choose-order">
              <select>
                <option value="desc">Newest</option>
                <option value="asc" <?php if(isset($order_by) && $order_by == 'asc'){ echo 'selected="selected"'; } ?>>Oldest</option>
              </select>
            </div>
          </div>
        </div>

        <div class="list-tags">
          <ul class="list-unstyled list-inline">
            <?php if (!empty($serviceTypes)) {
              for ($i = 0; $i < count($serviceTypes); $i++) { ?>
                <li class="list-inline-item page-text-xs fw-500 li_service_type <?php if(isset($service_types) && in_array($serviceTypes[$i]['id'], $service_types)){ echo "selected"; } ?>">
                  <a href="javascript:void(0)" class="service_type_selected" data-id="<?php echo $serviceTypes[$i]['id']; ?>"><?php echo $serviceTypes[$i]['service_type_name']; ?></a>
                </li>
            <?php }
            } ?>
          </ul>
        </div>
        <?php if (count($lists) > 0) { ?>     
        <div class="customer-coupon-content grid-60 all-coupon">
          <div class="row">
            <!-- coupon item -->
            <?php foreach ($lists as $indexCoupon => $itemCoupon) {
              $couponDetailUrl = base_url('coupon/' . makeSlug($itemCoupon['coupon_subject']) . '-' . $itemCoupon['id']) . '.html'; ?>
              <div class="col-md-6 col-xl-3 coupon-item-<?php echo $itemCoupon['id']; ?>">
                <div class="position-relative">
                  <a class="card customer-coupon-item" href="<?php echo $couponDetailUrl; ?>">
                    <p class="customer-coupon-img mb-0">
                      <?php 
                        $couponImg = COUPONS_PATH . NO_IMAGE;
                        if(!empty($itemCoupon['coupon_image'])){
                          $couponImg = COUPONS_PATH . $itemCoupon['coupon_image'];
                        }
                      ?>
                      <img src="<?php echo $couponImg; ?>" class="img-fluid" alt="<?php echo $itemCoupon['coupon_subject']; ?>">
                    </p>
                    <div class="card-body d-flex flex-column flex-lg-row align-items-lg-center justify-content-between">
                      <div class="customer-coupon-body">
                        <h6 class="card-title"><span><?php echo $itemCoupon['coupon_subject']; ?></span></h6>
                        <p class="card-text page-text-xs"><?php echo ddMMyyyy($itemCoupon['start_date'], 'M d, Y'); ?> - <?php echo ddMMyyyy($itemCoupon['end_date'], 'M d, Y'); ?></p>
                        <div class="d-flex align-items-center justify-content-between">
                          <div class="wraper-progress">
                            <div class="progress">
                              <div class="progress-bar page-text-xs fw-500" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"><span class="progress-text"><span class="progress-first"><?php echo $itemCoupon['coupon_amount_used']; ?></span>/<span class="progress-last"><?php echo $itemCoupon['coupon_amount']; ?></span></span></div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </a>
                  <a href="javascript:void(0)" class="btn btn-outline-red btn-outline-red-md btn-getnow get-coupon-in-list" data-customer="<?php echo $customer['id']; ?>" data-id="<?php echo $itemCoupon['id']; ?>" >Get now</a>
                </div>
              </div>
            <?php } ?>
            <!-- END. coupon item -->
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
                      <option value="10" <?php if(isset($per_page) && $per_page == 20){ echo 'selected'; } ?> >10</option>
                      <option value="20" <?php if(isset($per_page) && $per_page == 20){ echo 'selected'; } ?> >20</option>
                      <option value="30" <?php if(isset($per_page) && $per_page == 30){ echo 'selected'; } ?> >30</option>
                      <option value="40" <?php if(isset($per_page) && $per_page == 40){ echo 'selected'; } ?> >40</option>
                      <option value="50" <?php if(isset($per_page) && $per_page == 50){ echo 'selected'; } ?> >50</option>
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
        <?php }else{ ?>
          <div class="zero-event zero-box">
            <img src="assets/img/frontend/img-empty-box.svg" alt="img-empty-box" class="img-fluid d-block mx-auto">
            <p class="text-secondary page-text-lg">No coupons</p>
          </div>
        <?php } ?>
      </div>
    </div>
  </div>
</main>
<input type="hidden" id="currentBaseUrl" value="<?php echo $basePagingUrl; ?>" />
<?php $this->load->view('frontend/includes/footer'); ?>
<script>
  $(document).ready(function() {
    $("body").on('click', '.service_type_selected', function(){
      $(this).parent('li').addClass('selected');
      var keySearch = '';
      if($(".li_service_type").hasClass('selected')) {
        $(".selected .service_type_selected").each(function() {
          keySearch += $(this).attr('data-id')+',';
        })
      }
      var repKeySearch = keySearch.replace(/,*$/, "")
      var splitSearch = window.location.search.split("&");
      console.log(window.location.search)
      var search = splitSearch[0]+'&'+splitSearch[1]+'&service_types='+repKeySearch;
      window.location.href = window.location.origin+window.location.pathname+search
    })
  })
</script>