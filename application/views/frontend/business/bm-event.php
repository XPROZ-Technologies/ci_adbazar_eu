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
              <div class="bp-event um-event bm-event">
                <div class="bp-event-content bm-event-content">
                  <div class="text-right">
                    <a href="<?php echo base_url('business-management/' . $businessInfo['business_url'] . '/create-event') ?>" class="btn btn-red btn-red-md btn-create-event d-inline-block">Create new event</a>
                  </div>
                  <div class="d-flex justify-content-end">
                    <form class="d-flex search-box">
                      <a href="#" class="search-box-icon"><img src="assets/img/frontend/ic-search.png" alt="search icon"></a>
                      <input class="form-control" type="text" placeholder="Search" aria-label="Search">
                    </form>
                  </div>
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
                  <div class="bp-event-list bm-event-list">
                  <div class="position-relative">  
                  <a href="" class="w-100 d-flex flex-column flex-lg-row customer-event-item">
                      <span class="event-img">
                        <img src="assets/img/frontend/bm-event1.png" alt="event image">
                      </span>
                      <div class="event-text">
                        <span class="event-header page-text-lg fw-500">50% OFF for all new customers</span>
                        <p class="mb-0">By Inspire Beauty Salon</p>
                        <hr class="my-2 my-lg-3">
                        <p class="event-date page-text-sm">Oct 21, 2021 - Oct 15, 2021</p>
                        <p class="mb-0 event-time page-text-sm">10:00 - 16:00</p>

                        <div class="badge badge-primary bm-event-status">Upcomming</div>

                      </div>
                    </a>
                    <div class="bm-event-actions">
                      <a href="bm-event-edit.html" class="event-edit page-text-xs mt-2 text-decoration-underline">Edit</a>
                      <a href="#bmEventModal" data-bs-toggle="modal" class="event-cancel page-text-xs mt-2 text-decoration-underline">Cancel</a>
                    </div>
                    </div>
                    <div class="position-relative">
                    <a href="" class="w-100 d-flex flex-column flex-lg-row customer-event-item">
                      <span class="event-img">
                        <img src="assets/img/frontend/bm-event2.png" alt="event image">
                      </span>
                      <div class="event-text">
                        <span class="event-header page-text-lg fw-500">50% OFF for all new customers</span>
                        <p class="mb-0">By Inspire Beauty Salon</p>
                        <hr class="my-2 my-lg-3">
                        <p class="event-date page-text-sm">Oct 21, 2021 - Oct 15, 2021</p>
                        <p class="mb-0 event-time page-text-sm">10:00 - 16:00</p>

                        <div class="badge badge-approved bm-event-status">Ongoing</div>

                      </div>
                    </a>
                    <div class="bm-event-actions">
                      <a href="bm-event-edit.html" class="event-edit page-text-xs mt-2 text-decoration-underline">Edit</a>
                      <a href="#bmEventModal" data-bs-toggle="modal" class="event-cancel page-text-xs mt-2 text-decoration-underline">Cancel</a>
                    </div>
                    </div>
                    <div class="position-relative">
                    <a href="" class="w-100 d-flex flex-column flex-lg-row customer-event-item">
                      <span class="event-img">
                        <img src="assets/img/frontend/bm-event3.png" alt="event image">
                      </span>
                      <div class="event-text">
                        <span class="event-header page-text-lg fw-500">50% OFF for all new customers</span>
                        <p class="mb-0">By Inspire Beauty Salon</p>
                        <hr class="my-2 my-lg-3">
                        <p class="event-date page-text-sm">Oct 21, 2021 - Oct 15, 2021</p>
                        <p class="mb-0 event-time page-text-sm">10:00 - 16:00</p>

                        <div class="badge badge-cancel bm-event-status">Cancelled</div>

                      </div>
                    </a>
                    <div class="bm-event-actions">
                      <a href="bm-event-edit.html" class="event-edit page-text-xs mt-2 text-decoration-underline">Edit</a>
                      <a href="#bmEventModal" data-bs-toggle="modal" class="event-cancel page-text-xs mt-2 text-decoration-underline">Cancel</a>
                    </div>
                    </div>
                    <div class="position-relative">
                    <a href="" class="w-100 d-flex flex-column flex-lg-row customer-event-item">
                      <span class="event-img">
                        <img src="assets/img/frontend/bm-event1.png" alt="event image">
                      </span>
                      <div class="event-text">
                        <span class="event-header page-text-lg fw-500">50% OFF for all new customers</span>
                        <p class="mb-0">By Inspire Beauty Salon</p>
                        <hr class="my-2 my-lg-3">
                        <p class="event-date page-text-sm">Oct 21, 2021 - Oct 15, 2021</p>
                        <p class="mb-0 event-time page-text-sm">10:00 - 16:00</p>

                        <div class="badge badge-primary bm-event-status">Upcomming</div>

                      </div>
                    </a>
                    <div class="bm-event-actions">
                      <a href="bm-event-edit.html" class="event-edit page-text-xs mt-2 text-decoration-underline">Edit</a>
                      <a href="#bmEventModal" data-bs-toggle="modal" class="event-cancel page-text-xs mt-2 text-decoration-underline">Cancel</a>
                    </div>
                    </div>
                    <div class="position-relative">
                    <a href="" class="w-100 d-flex flex-column flex-lg-row customer-event-item">
                      <span class="event-img">
                        <img src="assets/img/frontend/bm-event2.png" alt="event image">
                      </span>
                      <div class="event-text">
                        <span class="event-header page-text-lg fw-500">50% OFF for all new customers</span>
                        <p class="mb-0">By Inspire Beauty Salon</p>
                        <hr class="my-2 my-lg-3">
                        <p class="event-date page-text-sm">Oct 21, 2021 - Oct 15, 2021</p>
                        <p class="mb-0 event-time page-text-sm">10:00 - 16:00</p>

                        <div class="badge badge-approved bm-event-status">Ongoing</div>

                      </div>
                    </a>
                    <div class="bm-event-actions">
                      <a href="bm-event-edit.html" class="event-edit page-text-xs mt-2 text-decoration-underline">Edit</a>
                      <a href="#bmEventModal" data-bs-toggle="modal" class="event-cancel page-text-xs mt-2 text-decoration-underline">Cancel</a>
                    </div>
                    </div>
                    <div class="position-relative">
                    <a href="" class="w-100 d-flex flex-column flex-lg-row customer-event-item">
                      <span class="event-img">
                        <img src="assets/img/frontend/bm-event3.png" alt="event image">
                      </span>
                      <div class="event-text">
                        <span class="event-header page-text-lg fw-500">50% OFF for all new customers</span>
                        <p class="mb-0">By Inspire Beauty Salon</p>
                        <hr class="my-2 my-lg-3">
                        <p class="event-date page-text-sm">Oct 21, 2021 - Oct 15, 2021</p>
                        <p class="mb-0 event-time page-text-sm">10:00 - 16:00</p>

                        <div class="badge badge-cancel bm-event-status">Cancelled</div>

                      </div>
                    </a>
                    <div class="bm-event-actions">
                      <a href="bm-event-edit.html" class="event-edit page-text-xs mt-2 text-decoration-underline">Edit</a>
                      <a href="#bmEventModal" data-bs-toggle="modal" class="event-cancel page-text-xs mt-2 text-decoration-underline">Cancel</a>
                    </div>
                    </div>
                    <div class="position-relative">
                    <a href="" class="w-100 d-flex flex-column flex-lg-row customer-event-item">
                      <span class="event-img">
                        <img src="assets/img/frontend/bm-event1.png" alt="event image">
                      </span>
                      <div class="event-text">
                        <span class="event-header page-text-lg fw-500">50% OFF for all new customers</span>
                        <p class="mb-0">By Inspire Beauty Salon</p>
                        <hr class="my-2 my-lg-3">
                        <p class="event-date page-text-sm">Oct 21, 2021 - Oct 15, 2021</p>
                        <p class="mb-0 event-time page-text-sm">10:00 - 16:00</p>

                        <div class="badge badge-primary bm-event-status">Upcomming</div>

                      </div>
                    </a>
                    <div class="bm-event-actions">
                      <a href="bm-event-edit.html" class="event-edit page-text-xs mt-2 text-decoration-underline">Edit</a>
                      <a href="#bmEventModal" data-bs-toggle="modal" class="event-cancel page-text-xs mt-2 text-decoration-underline">Cancel</a>
                    </div>
                    </div>
                    <div class="position-relative">
                    <a href="" class="w-100 d-flex flex-column flex-lg-row customer-event-item">
                      <span class="event-img">
                        <img src="assets/img/frontend/bm-event2.png" alt="event image">
                      </span>
                      <div class="event-text">
                        <span class="event-header page-text-lg fw-500">50% OFF for all new customers</span>
                        <p class="mb-0">By Inspire Beauty Salon</p>
                        <hr class="my-2 my-lg-3">
                        <p class="event-date page-text-sm">Oct 21, 2021 - Oct 15, 2021</p>
                        <p class="mb-0 event-time page-text-sm">10:00 - 16:00</p>

                        <div class="badge badge-approved bm-event-status">Ongoing</div>

                      </div>
                    </a>
                    <div class="bm-event-actions">
                      <a href="bm-event-edit.html" class="event-edit page-text-xs mt-2 text-decoration-underline">Edit</a>
                      <a href="#bmEventModal" data-bs-toggle="modal" class="event-cancel page-text-xs mt-2 text-decoration-underline">Cancel</a>
                    </div>
                    </div>
                    <div class="position-relative">
                    <a href="" class="w-100 d-flex flex-column flex-lg-row customer-event-item">
                      <span class="event-img">
                        <img src="assets/img/frontend/bm-event3.png" alt="event image">
                      </span>
                      <div class="event-text">
                        <span class="event-header page-text-lg fw-500">50% OFF for all new customers</span>
                        <p class="mb-0">By Inspire Beauty Salon</p>
                        <hr class="my-2 my-lg-3">
                        <p class="event-date page-text-sm">Oct 21, 2021 - Oct 15, 2021</p>
                        <p class="mb-0 event-time page-text-sm">10:00 - 16:00</p>

                        <div class="badge badge-cancel bm-event-status">Cancelled</div>

                      </div>
                    </a>
                    <div class="bm-event-actions">
                      <a href="bm-event-edit.html" class="event-edit page-text-xs mt-2 text-decoration-underline">Edit</a>
                      <a href="#bmEventModal" data-bs-toggle="modal" class="event-cancel page-text-xs mt-2 text-decoration-underline">Cancel</a>
                    </div>
                    </div>
                    <div class="position-relative">
                    <a href="" class="w-100 d-flex flex-column flex-lg-row customer-event-item">
                      <span class="event-img">
                        <img src="assets/img/frontend/bm-event1.png" alt="event image">
                      </span>
                      <div class="event-text">
                        <span class="event-header page-text-lg fw-500">50% OFF for all new customers</span>
                        <p class="mb-0">By Inspire Beauty Salon</p>
                        <hr class="my-2 my-lg-3">
                        <p class="event-date page-text-sm">Oct 21, 2021 - Oct 15, 2021</p>
                        <p class="mb-0 event-time page-text-sm">10:00 - 16:00</p>

                        <div class="badge badge-primary bm-event-status">Upcomming</div>

                      </div>
                    </a>
                    <div class="bm-event-actions">
                      <a href="bm-event-edit.html" class="event-edit page-text-xs mt-2 text-decoration-underline">Edit</a>
                      <a href="#bmEventModal" data-bs-toggle="modal" class="event-cancel page-text-xs mt-2 text-decoration-underline">Cancel</a>
                    </div>
                    </div>
                  </a href="">

                  <div class="d-flex align-items-center flex-column flex-md-row justify-content-between page-pagination">
                    <div class="d-flex align-items-center pagination-left">
                      <p class="page-text-sm mb-0 me-3">Showing <span class="fw-500">1 – 10</span> of <span class="fw-500">50</span>
                        results</p>
                      <div class="page-text-sm mb-0 d-flex align-items-center">
                        <span class="fw-500">50</span>
                        <span class="ms-2">/</span>
                        <div class="custom-select">
                          <select>
                            <option value="0" selected>10</option>
                            <option value="1">20</option>
                            <option value="2">30</option>
                            <option value="3">40</option>
                            <option value="4">50</option>
                          </select>
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

    <!-- Modal Event Cancel -->
    <div class="modal fade" id="bmEventModal" tabindex="-1" aria-labelledby="bmEventModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-body">
            <p class="page-text-lg text-center">Are you sure want to remove the coupon
              <b>50% OFF for all new customers?</b>
            </p>
            <div class="d-flex justify-content-center modal-btn">
              <a href="#" class="btn btn-red btn-yes" data-bs-dismiss="modal">Yes</a>
              <a href="#" class="btn btn-outline-red btn-outline-red-md ml-10 btn-cancel" data-bs-dismiss="modal">Cancel</a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- End Modal Event Cancel -->
  </div>
</main>
<?php $this->load->view('frontend/includes/footer'); ?>