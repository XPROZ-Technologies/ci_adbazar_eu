<?php $this->load->view('frontend/includes/header'); ?>
<main class="main-customer">
  <div class="page-customer-service">
    <div class="customer-service-list">
      <div class="container">
        <div class="row">
          <div class="col-xl-3 d-none d-xl-block">
            <div class="customer-service-left">
              <img src="<?php echo CONFIG_PATH . $configs['SERVICE_IMAGE']; ?>" alt="<?php echo $configs['TEXT_LOGO_HEADER']; ?>" class=" img-fluid">
            </div>
          </div>
          <div class="col-xl-9">
            <div class="customer-service-right">
              <div class="customer-service-content">
                <div class="inner-service">
                  <div class="wrapper-search d-md-flex justify-content-between">
                    <h2 class="page-heading page-title-md text-black mb-3 mb-md-0 fw-bold"><?php echo $serviceInfo['service_name']; ?></h2>
                    <form class="d-flex search-box" action="<?php echo $baseServiceUrl; ?>" method="GET" name="searchForm">
                      <a href="javascript:void(0)" class="search-box-icon" onclick="document.searchForm.submit();"><img src="assets/img/frontend/ic-search.png" alt="search icon"></a>
                      <input class="form-control" type="text" name="keyword" placeholder="<?php echo $this->lang->line('search'); ?>" aria-label="Search" value="<?php echo $keyword; ?>">
                    </form>
                  </div>
                  <div class="list-tags text-right">
                    <ul class="list-unstyled list-inline">

                      <?php if (!empty($serviceTypes)) {
                        for ($i = 0; $i < count($serviceTypes); $i++) { ?>
                          <li class="list-inline-item page-text-xs fw-500 li_service_type <?php if(isset($service_types) && in_array($serviceTypes[$i]['id'], $service_types)){ echo "selected"; } ?>"><a class="service_type_selected" data-id="<?php echo $serviceTypes[$i]['id']; ?>" href="javascript:void(0)"><?php echo $serviceTypes[$i]['service_type_name']; ?></a></li>
                      <?php }
                      } ?>
                    </ul>
                  </div>
                  <?php if (!empty($listProfiles) > 0) { ?>
                    <?php for ($i = 0; $i < count($listProfiles); $i++) { ?>
                      <!-- Business profile -->
                      <div class="position-relative">
                        <a href="<?php echo base_url(BUSINESS_PROFILE_URL.$listProfiles[$i]['business_url']); ?>" class="card rounded-0 customer-item-list">
                          <div class="d-flex flex-column flex-md-row">
                            <span class="list-img"><img src="<?php echo BUSINESS_PROFILE_PATH . $listProfiles[$i]['business_avatar']; ?>" class="img-fluid" alt="<?php echo $listProfiles[$i]['business_name']; ?>"></span>
  
                            <div class="card-body p-0">
                              <h5 class="card-title page-text-lg fw-500"><span><?php echo $listProfiles[$i]['business_name']; ?></span></h5>
                              <p class="card-text page-text-xxs"><?php echo $listProfiles[$i]['business_slogan']; ?></p>
                              <ul class="list-unstyled mb-0 list-info">
                                <li class="page-text-xxs font-style-normal">
                                  <div class="wrapper-img"><img src="assets/img/frontend/ic-tag-service.svg" alt="tag icon" class="img-fluid">
                                  </div><?php $businessServiceTypes = $listProfiles[$i]['businessServiceTypes'];
                                        for ($k = 0; $k < count($businessServiceTypes); $k++) {
                                          echo $businessServiceTypes[$k]['service_type_name'];
                                          if ($k < (count($businessServiceTypes) - 1)) {
                                            echo ', ';
                                          }
                                        } ?>
                                </li>
                                <li class="page-text-xxs font-style-normal">
                                  <div class="wrapper-img"><img src="assets/img/frontend/ic-telephone-service.svg" alt="telephone icon" class="img-fluid"></div>+<?php echo $listProfiles[$i]['country_code_id']; ?> <?php echo ltrim($listProfiles[$i]['business_phone'], '0'); ?>
                                </li>
                                <li class="page-text-xxs font-style-normal" >
                                  <div class="wrapper-img"><img src="assets/img/frontend/ic-place-service.svg" alt="map icon" class="img-fluid">
                                  </div><?php echo $listProfiles[$i]['business_address']; ?>
                                </li>
                              </ul>
                              
                              <ul class="list-inline mb-0 list-rating">
                                <li class="list-inline-item"><span href="#"><i class="bi bi-star-fill"></i><span></li>
                                <li class="list-inline-item"><span href="#"><i class="bi bi-star-fill"></i><span></li>
                                <li class="list-inline-item"><span href="#"><i class="bi bi-star-fill"></i><span></li>
                                <li class="list-inline-item"><span href="#"><i class="bi bi-star-fill"></i><span></li>
                                <li class="list-inline-item"><span href="#"><i class="bi bi-star"></i><span></li>
                                <li class="list-inline-item fw-500">(10)</li>
                              </ul>
                              
                              <div class="view-more">
                                <?php if ($listProfiles[$i]['isOpen']) { ?>
                                  <span class="text-success page-text-xs text-center">Open now</span>
                                <?php } else { ?>
                                  <span class="color-close page-text-xs text-center">Closed</span>
                                <?php } ?>
                              </div>
                            </div>
                          </div>
                        </a>
                        <a href="<?php echo base_url(BUSINESS_PROFILE_URL.$listProfiles[$i]['business_url']); ?>" class="btn btn-outline-red view-more-list-cus">View more</a>
                      </div>
                      <!-- END. Business profile -->
                    <?php } ?>
                  <?php } else { ?>
                    <div class="zero-event zero-box">
                      <img src="assets/img/frontend/img-empty-box.svg" alt="img-empty-box" class="img-fluid d-block mx-auto">
                      <p class="text-secondary page-text-lg">No upcoming events on this day</p>
                    </div>
                  <?php } ?>


                  <!-- Pagination -->
                  <?php if (!empty($listProfiles) > 0) { ?>
                    <div class="d-flex align-items-center flex-column flex-md-row justify-content-between page-pagination">
                      <div class="d-flex align-items-center pagination-left">
                        <p class="page-text-sm mb-0 me-3">Showing <span class="fw-500"><?php echo ($page - 1) * $perPage + 1; ?> – <?php echo ($page - 1) * $perPage + count($listProfiles); ?></span> of <span class="fw-500"><?php echo number_format($rowCount); ?></span>
                          results</p>
                        <div class="page-text-sm mb-0 d-flex align-items-center">
                          <div class="custom-select choose-perpage">
                            <select>
                              <option value="10" <?php if (isset($per_page) && $per_page == 20) { echo 'selected'; } ?>>10</option>
                              <option value="20" <?php if (isset($per_page) && $per_page == 20) { echo 'selected'; } ?>>20</option>
                              <option value="30" <?php if (isset($per_page) && $per_page == 30) { echo 'selected'; } ?>>30</option>
                              <option value="40" <?php if (isset($per_page) && $per_page == 40) { echo 'selected'; } ?>>40</option>
                              <option value="50" <?php if (isset($per_page) && $per_page == 50) { echo 'selected'; } ?>>50</option>
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
<input type="hidden" id="currentBaseUrl" value="<?php echo $baseServiceUrl; ?>" />
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
      //window.location.href = window.location.origin+window.location.pathname+search
    })
  })
</script>