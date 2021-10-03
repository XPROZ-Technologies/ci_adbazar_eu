<?php $this->load->view('frontend/includes/header'); ?>
<main>
  <div class="page-notification">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-8">
          <div class="notification">
            <div class="bg-white notification-content">
              <h2 class="page-heading page-title-xs mb-3 mb-md-4">Notifications</h2>
              <div class="wrapper-content">
                <form class="d-flex search-box">
                  <a href="#" class="search-box-icon"><img src="assets/img/frontend/ic-search.svg" alt="search icon"></a>
                  <input class="form-control" type="text" placeholder="Search" aria-label="Search">
                </form>
                <div class="notification-wrapper-filter d-flex flex-column flex-md-row align-items-md-center justify-content-between">
                  <div class="d-flex align-items-center inner-filter">
                    <span class="me-2 page-text-lg">Filter by</span>
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
                    <div class="custom-select mb-0">
                      <select>
                        <option value="0" selected>Newest</option>
                        <option value="1">Oldest</option>
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
                    <!--
                    <div class="notification-item">
                        <img src="assets/img/frontend/icon-new-badge.png" alt="icon-new-badge" class="notification-badge"/>
                        <div class="notification-img">
                            <img src="https://loremflickr.com/70/70" alt="notification image" class="img-fluid">
                        </div>
                        <div class="notification-body">
                            <p><span class="fw-bold">Fusion Restaurant</span> replied your comment.</p>
                            <span class="notification-date">Yesterday at 14:35</span>
                        </div>
                    </div>
                    <div class="notification-item">
                        <img src="assets/img/frontend/icon-new-badge.png" alt="icon-new-badge" class="notification-badge"/>
                        <div class="notification-img">
                            <img src="https://loremflickr.com/70/70" alt="notification image" class="img-fluid">
                        </div>
                        <div class="notification-body">
                            <p><span class="fw-bold">Fusion Restaurant</span> replied your comment.</p>
                            <span class="notification-date">Yesterday at 14:35</span>
                        </div>
                    </div>
                    <div class="notification-item">
                        <img src="assets/img/frontend/icon-new-badge.png" alt="icon-new-badge" class="notification-badge"/>
                        <div class="notification-img">
                            <img src="https://loremflickr.com/70/70" alt="notification image" class="img-fluid">
                        </div>
                        <div class="notification-body">
                            <p><span class="fw-bold">Fusion Restaurant</span> replied your comment.</p>
                            <span class="notification-date">Yesterday at 14:35</span>
                        </div>
                    </div>
                    <div class="notification-item">
                        <img src="assets/img/frontend/icon-new-badge.png" alt="icon-new-badge" class="notification-badge"/>
                        <div class="notification-img">
                            <img src="https://loremflickr.com/70/70" alt="notification image" class="img-fluid">
                        </div>
                        <div class="notification-body">
                            <p><span class="fw-bold">Fusion Restaurant</span> replied your comment.</p>
                            <span class="notification-date">Yesterday at 14:35</span>
                        </div>
                    </div>
                    <div class="notification-item">
                        <img src="assets/img/frontend/icon-new-badge.png" alt="icon-new-badge" class="notification-badge"/>
                        <div class="notification-img">
                            <img src="https://loremflickr.com/70/70" alt="notification image" class="img-fluid">
                        </div>
                        <div class="notification-body">
                            <p><span class="fw-bold">Fusion Restaurant</span> replied your comment.</p>
                            <span class="notification-date">Yesterday at 14:35</span>
                        </div>
                    </div>
                    <div class="notification-item">
                        <img src="assets/img/frontend/icon-new-badge.png" alt="icon-new-badge" class="notification-badge"/>
                        <div class="notification-img">
                            <img src="https://loremflickr.com/70/70" alt="notification image" class="img-fluid">
                        </div>
                        <div class="notification-body">
                            <p><span class="fw-bold">Fusion Restaurant</span> replied your comment.</p>
                            <span class="notification-date">Yesterday at 14:35</span>
                        </div>
                    </div>
                    <div class="notification-item">
                        <img src="assets/img/frontend/icon-new-badge.png" alt="icon-new-badge" class="notification-badge"/>
                        <div class="notification-img">
                            <img src="https://loremflickr.com/70/70" alt="notification image" class="img-fluid">
                        </div>
                        <div class="notification-body">
                            <p><span class="fw-bold">Fusion Restaurant</span> replied your comment.</p>
                            <span class="notification-date">Yesterday at 14:35</span>
                        </div>
                    </div>
                    -->

                    <!-- Pagination
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
                            
                        </div>
                    </div>
                    END. Pagination -->
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
<?php $this->load->view('frontend/includes/footer'); ?>