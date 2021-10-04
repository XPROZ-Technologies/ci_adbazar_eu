<?php $this->load->view('frontend/includes/header'); ?>
<main>
  <div class="page-business-manager">
    <div class="bm-content">
      <div class="container">
        <div class="content-top">
          <h2 class="page-title-md text-center">Manage my business</h2>
        </div>
        <div class="row">
          <div class="col-lg-3">
            <?php $this->load->view('frontend/includes/business_manage_nav_sidebar'); ?>
          </div>
          <div class="col-lg-9">
            <div class="um-right">
              <div class="um-coupon bm-coupon">
                <div class="coupon-top">
                  <div class="d-flex flex-column flex-xl-row justify-content-xl-between">
                    <form class="d-flex mb-3 mb-xl-0">
                      <input class="form-control me-2" type="text" placeholder="Enter code here">
                      <button class="btn btn-outline-red" type="submit">Check</button>
                    </form>
                    <a href="<?php echo base_url('business-management/' . $businessInfo['business_url'] . '/create-coupon') ?>" class="btn btn-red btn-create-coupon">Create new coupon</a>
                  </div>
                </div>
                <form class="d-flex search-box">
                  <a href="#" class="search-box-icon"><img src="assets/img/frontend/ic-search.png" alt="search icon"></a>
                  <input class="form-control w-100" type="text" placeholder="Search" aria-label="Search">
                </form>
                <div class="notification-wrapper-filter d-flex align-items-center justify-content-md-between">
                  <div class="d-flex align-items-center inner-filter">
                    <span class="me-2 page-text-lg fw-bold">Filter by</span>
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
                  </div>
                  <div class="d-flex align-items-center notification-sort">
                    <img src="assets/img/frontend/ic-sort.png" alt="sort icon" class="img-fluid me-2">
                    <div class="custom-select mb-0">
                      <select>
                        <option value="0" selected>Newest</option>
                        <option value="1">Oldest</option>
                      </select>
                    </div>
                  </div>
                </div>

                <div class="um-coupon-list grid-60">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="card customer-coupon-item um-coupon-item bm-coupon-item">
                        <a href="bm-coupon-detail.html" class="customer-coupon-img">
                          <img src="assets/img/frontend/um-coupon1.png" class="img-fluid" alt="coupon image">
                        </a>
                        <div class="card-body d-flex flex-column flex-lg-row align-items-lg-center justify-content-between">
                          <div class="customer-coupon-body">
                            <h6 class="card-title page-text-sm"><a href="bm-coupon-detail.html">Face and Body Full Massage Service (80 minutes)</a></h6>
                            <p class="card-text page-text-xs">Oct 21, 2021 - Dec 20, 2021</p>
                            <div class="d-flex align-items-center justify-content-between">
                              <div class="wraper-status">
                                <div class="badge badge-primary">Upcoming</div>
                              </div>
                              <a href="#" class="btn btn-outline-red btn-outline-red-md btn-viewcode fw-bold">Detail</a>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="card customer-coupon-item um-coupon-item bm-coupon-item">
                        <a href="bm-coupon-detail.html" class="customer-coupon-img">
                          <img src="assets/img/frontend/um-coupon1.png" class="img-fluid" alt="coupon image">
                        </a>
                        <div class="card-body d-flex flex-column flex-lg-row align-items-lg-center justify-content-between">
                          <div class="customer-coupon-body">
                            <h6 class="card-title page-text-sm"><a href="bm-coupon-detail.html">Face and Body Full Massage Service (80 minutes)</a></h6>
                            <p class="card-text page-text-xs">Oct 21, 2021 - Dec 20, 2021</p>
                            <div class="d-flex align-items-center justify-content-between">
                              <div class="wraper-status">
                                <div class="badge badge-approved">Ongoing</div>
                              </div>
                              <a href="#" class="btn btn-outline-red btn-outline-red-md btn-viewcode fw-bold">Detail</a>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="card customer-coupon-item um-coupon-item bm-coupon-item">
                        <a href="bm-coupon-detail.html" class="customer-coupon-img">
                          <img src="assets/img/frontend/um-coupon1.png" class="img-fluid" alt="coupon image">
                        </a>
                        <div class="card-body d-flex flex-column flex-lg-row align-items-lg-center justify-content-between">
                          <div class="customer-coupon-body">
                            <h6 class="card-title page-text-sm"><a href="bm-coupon-detail.html">Face and Body Full Massage Service (80 minutes)</a></h6>
                            <p class="card-text page-text-xs">Oct 21, 2021 - Dec 20, 2021</p>
                            <div class="d-flex align-items-center justify-content-between">
                              <div class="wraper-status">
                                <div class="badge badge-cancel">End</div>
                              </div>
                              <a href="#" class="btn btn-outline-red btn-outline-red-md btn-viewcode fw-bold">Detail</a>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="card customer-coupon-item um-coupon-item bm-coupon-item">
                        <a href="bm-coupon-detail.html" class="customer-coupon-img">
                          <img src="assets/img/frontend/um-coupon1.png" class="img-fluid" alt="coupon image">
                        </a>
                        <div class="card-body d-flex flex-column flex-lg-row align-items-lg-center justify-content-between">
                          <div class="customer-coupon-body">
                            <h6 class="card-title page-text-sm"><a href="bm-coupon-detail.html">Face and Body Full Massage Service (80 minutes)</a></h6>
                            <p class="card-text page-text-xs">Oct 21, 2021 - Dec 20, 2021</p>
                            <div class="d-flex align-items-center justify-content-between">
                              <div class="wraper-status">
                                <div class="badge badge-primary">Upcoming</div>
                              </div>
                              <a href="#" class="btn btn-outline-red btn-outline-red-md btn-viewcode fw-bold">Detail</a>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="card customer-coupon-item um-coupon-item bm-coupon-item">
                        <a href="bm-coupon-detail.html" class="customer-coupon-img">
                          <img src="assets/img/frontend/um-coupon1.png" class="img-fluid" alt="coupon image">
                        </a>
                        <div class="card-body d-flex flex-column flex-lg-row align-items-lg-center justify-content-between">
                          <div class="customer-coupon-body">
                            <h6 class="card-title page-text-sm"><a href="bm-coupon-detail.html">Face and Body Full Massage Service (80 minutes)</a></h6>
                            <p class="card-text page-text-xs">Oct 21, 2021 - Dec 20, 2021</p>
                            <div class="d-flex align-items-center justify-content-between">
                              <div class="wraper-status">
                                <div class="badge badge-approved">Ongoing</div>
                              </div>
                              <a href="#" class="btn btn-outline-red btn-outline-red-md btn-viewcode fw-bold">Detail</a>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="card customer-coupon-item um-coupon-item bm-coupon-item">
                        <a href="bm-coupon-detail.html" class="customer-coupon-img">
                          <img src="assets/img/frontend/um-coupon1.png" class="img-fluid" alt="coupon image">
                        </a>
                        <div class="card-body d-flex flex-column flex-lg-row align-items-lg-center justify-content-between">
                          <div class="customer-coupon-body">
                            <h6 class="card-title page-text-sm"><a href="bm-coupon-detail.html">Face and Body Full Massage Service (80 minutes)</a></h6>
                            <p class="card-text page-text-xs">Oct 21, 2021 - Dec 20, 2021</p>
                            <div class="d-flex align-items-center justify-content-between">
                              <div class="wraper-status">
                                <div class="badge badge-cancel">End</div>
                              </div>
                              <a href="#" class="btn btn-outline-red btn-outline-red-md btn-viewcode fw-bold">Detail</a>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="card customer-coupon-item um-coupon-item bm-coupon-item">
                        <a href="bm-coupon-detail.html" class="customer-coupon-img">
                          <img src="assets/img/frontend/um-coupon1.png" class="img-fluid" alt="coupon image">
                        </a>
                        <div class="card-body d-flex flex-column flex-lg-row align-items-lg-center justify-content-between">
                          <div class="customer-coupon-body">
                            <h6 class="card-title page-text-sm"><a href="bm-coupon-detail.html">Face and Body Full Massage Service (80 minutes)</a></h6>
                            <p class="card-text page-text-xs">Oct 21, 2021 - Dec 20, 2021</p>
                            <div class="d-flex align-items-center justify-content-between">
                              <div class="wraper-status">
                                <div class="badge badge-primary">Upcoming</div>
                              </div>
                              <a href="#" class="btn btn-outline-red btn-outline-red-md btn-viewcode fw-bold">Detail</a>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="card customer-coupon-item um-coupon-item bm-coupon-item">
                        <a href="bm-coupon-detail.html" class="customer-coupon-img">
                          <img src="assets/img/frontend/um-coupon1.png" class="img-fluid" alt="coupon image">
                        </a>
                        <div class="card-body d-flex flex-column flex-lg-row align-items-lg-center justify-content-between">
                          <div class="customer-coupon-body">
                            <h6 class="card-title page-text-sm"><a href="bm-coupon-detail.html">Face and Body Full Massage Service (80 minutes)</a></h6>
                            <p class="card-text page-text-xs">Oct 21, 2021 - Dec 20, 2021</p>
                            <div class="d-flex align-items-center justify-content-between">
                              <div class="wraper-status">
                                <div class="badge badge-approved">Ongoing</div>
                              </div>
                              <a href="#" class="btn btn-outline-red btn-outline-red-md btn-viewcode fw-bold">Detail</a>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="card customer-coupon-item um-coupon-item bm-coupon-item">
                        <a href="bm-coupon-detail.html" class="customer-coupon-img">
                          <img src="assets/img/frontend/um-coupon1.png" class="img-fluid" alt="coupon image">
                        </a>
                        <div class="card-body d-flex flex-column flex-lg-row align-items-lg-center justify-content-between">
                          <div class="customer-coupon-body">
                            <h6 class="card-title page-text-sm"><a href="bm-coupon-detail.html">Face and Body Full Massage Service (80 minutes)</a></h6>
                            <p class="card-text page-text-xs">Oct 21, 2021 - Dec 20, 2021</p>
                            <div class="d-flex align-items-center justify-content-between">
                              <div class="wraper-status">
                                <div class="badge badge-cancel">End</div>
                              </div>
                              <a href="#" class="btn btn-outline-red btn-outline-red-md btn-viewcode fw-bold">Detail</a>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="card customer-coupon-item um-coupon-item bm-coupon-item">
                        <a href="bm-coupon-detail.html" class="customer-coupon-img">
                          <img src="assets/img/frontend/um-coupon1.png" class="img-fluid" alt="coupon image">
                        </a>
                        <div class="card-body d-flex flex-column flex-lg-row align-items-lg-center justify-content-between">
                          <div class="customer-coupon-body">
                            <h6 class="card-title page-text-sm"><a href="bm-coupon-detail.html">Face and Body Full
                                Massage Service (80 minutes)</a></h6>
                            <p class="card-text page-text-xs">Oct 21, 2021 - Dec 20,
                              2021</p>
                            <div class="d-flex align-items-center justify-content-between">
                              <div class="wraper-status">
                                <div class="badge badge-cancel">End</div>
                              </div>
                              <a href="#" class="btn btn-outline-red btn-outline-red-md btn-viewcode">View
                                detail</a>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="d-flex align-items-center flex-column flex-md-row justify-content-between page-pagination">
                  <div class="d-flex align-items-center pagination-left">
                    <p class="page-text-sm mb-0 me-3">Showing <span class="fw-500">1 – 10</span> of <span class="fw-500">50</span>
                      results</p>
                    <div class="page-text-sm mb-0 d-flex align-items-center">
                      <span class="fw-500 show-page-text">50</span>
                      <span class="ms-2">/</span>
                      <div class="page-select position-relative">
                        <span class="ml-8px"> Page <img class="ml-8px" src="assets/img/frontend/icon-page.png" alt=""></span>
                        <ul>
                          <li class="active">10</li>
                          <li>20</li>
                          <li>30</li>
                          <li>40</li>
                        </ul>
                      </div>
                    </div>
                  </div>
                  <div class="pagination-right">
                    <!-- Page pagination -->
                    <nav>
                      <ul class="pagination justify-content-end mb-0">
                        <li class="page-item"><a class="page-link" href="#"><i class="bi bi-chevron-left"></i></a>
                        </li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item"><a class="page-link" href="#">4</a></li>
                        <li class="page-item"><a class="page-link" href="#">...</a></li>
                        <li class="page-item"><a class="page-link" href="#"><i class="bi bi-chevron-right"></i></a>
                        </li>
                      </ul>
                    </nav>
                    <!-- End Page pagination -->
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