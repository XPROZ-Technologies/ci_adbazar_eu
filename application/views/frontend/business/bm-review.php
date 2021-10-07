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
            <div class="bp-review bm-review">
              <div class="review-top v1">
                <div class="col-review">
                  <div class="d-flex flex-column justify-content-center align-items-center overall-rate">
                    <h5 class="page-title-xs">Overall rating</h5>
                    <div class="d-flex align-items-center mb-14">
                      <div class="star-rating on line relative">
                        <div class="star-base">
                          <div class="star-rate" data-rate="3.5"></div>
                          <a dt-value="1" href="#1"></a>
                          <a dt-value="2" href="#2"></a>
                          <a dt-value="3" href="#3"></a>
                          <a dt-value="4" href="#4"></a>
                          <a dt-value="5" href="#5"></a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-review ml-32">
                  <div class="d-flex align-items-center mb-14">
                    <div class="star-rating on line relative mr-8px">
                      <div class="star-base">
                        <div class="star-rate" data-rate="5"></div>
                        <a dt-value="1" href="#1"></a>
                        <a dt-value="2" href="#2"></a>
                        <a dt-value="3" href="#3"></a>
                        <a dt-value="4" href="#4"></a>
                        <a dt-value="5" href="#5"></a>
                      </div>
                    </div>
                    <span class="fw-bold star-rating-number">(10)</span>
                  </div>
                  <div class="d-flex align-items-center mb-14">
                    <div class="star-rating on line relative mr-8px">
                      <div class="star-base">
                        <div class="star-rate" data-rate="4"></div>
                        <a dt-value="1" href="#1"></a>
                        <a dt-value="2" href="#2"></a>
                        <a dt-value="3" href="#3"></a>
                        <a dt-value="4" href="#4"></a>
                        <a dt-value="5" href="#5"></a>
                      </div>
                    </div>
                    <span class="fw-bold star-rating-number">(10)</span>
                  </div>
                  <div class="d-flex align-items-center mb-14">
                    <div class="star-rating on line relative mr-8px">
                      <div class="star-base">
                        <div class="star-rate" data-rate="3"></div>
                        <a dt-value="1" href="#1"></a>
                        <a dt-value="2" href="#2"></a>
                        <a dt-value="3" href="#3"></a>
                        <a dt-value="4" href="#4"></a>
                        <a dt-value="5" href="#5"></a>
                      </div>
                    </div>
                    <span class="fw-bold star-rating-number">(10)</span>
                  </div>
                  <div class="d-flex align-items-center mb-14">
                    <div class="star-rating on line relative mr-8px">
                      <div class="star-base">
                        <div class="star-rate" data-rate="2"></div>
                        <a dt-value="1" href="#1"></a>
                        <a dt-value="2" href="#2"></a>
                        <a dt-value="3" href="#3"></a>
                        <a dt-value="4" href="#4"></a>
                        <a dt-value="5" href="#5"></a>
                      </div>
                    </div>
                    <span class="fw-bold star-rating-number">(10)</span>
                  </div>
                  <div class="d-flex align-items-center mb-14">
                    <div class="star-rating on line relative mr-8px">
                      <div class="star-base">
                        <div class="star-rate" data-rate="1"></div>
                        <a dt-value="1" href="#1"></a>
                        <a dt-value="2" href="#2"></a>
                        <a dt-value="3" href="#3"></a>
                        <a dt-value="4" href="#4"></a>
                        <a dt-value="5" href="#5"></a>
                      </div>
                    </div>
                    <span class="fw-bold star-rating-number">(10)</span>
                  </div>
                </div>
              </div>

              <div class="bp-comment">
                <h4 class="page-title-rv">Reviews (31)</h4>
                <div class="bp-inner-content">
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

                  <div class="list-comment">
                    <div class="d-flex flex-column flex-lg-row comment-item">
                      <div class="comment-img">
                        <img src="assets/img/frontend/review-avatar.jpg" alt="comment avatar" class="img-fluid">
                        <span class="mt-3 d-block">John</span>
                      </div>
                      <div class="comment-body">
                        <p class="font500">08/31/2021</p>
                        <ul class="list-inline list-rating">
                          <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star-fill"></i></a></li>
                          <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star-fill"></i></a></li>
                          <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star-fill"></i></a></li>
                          <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star-fill"></i></a></li>
                          <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star-fill"></i></a></li>
                        </ul>
                        <p class="page-text-sm">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed in maximus libero. Fusce
                          vulputate, lectus vitae rhoncus bibendum, eros purus dignissim sapien, sit amet sollicitudin
                          nulla felis sit amet sem. Proin augue felis, luctus vitae enim eu, consectetur rhoncus ligula.
                          Donec elementum fringilla rhoncus. Vestibulum in accumsan velit. Donec interdum.
                          onec elementum fringilla rhoncus. Vestibulum in accumsan velit. Donec interdum.
                        </p>
                        <div class="text-right">
                          <a href="javascript:void(0)" title="" class="btn btn-red d-inline-block reply-comment">Reply</a>
                          <a href="javascript:void(0)" title="" class="btn btn-outline-red d-inline-block"><img src="assets/img/frontend/icon-del.png" alt=""> Delete</a>
                        </div>
                      </div>
                    </div>
                    <div class="comment-item no-avatar comment-reply">
                      <div class="d-flex align-items-center justify-content-between">
                        <p class="page-text-md text-secondary mb-2">Reply to customer:</p>
                        <div class="d-flex mb-10">
                          <button type="submit" class="btn btn-red">Submit</button>
                          <button type="submit" class="btn btn-red ml-8px reply-cancel">cancel</button>
                        </div>
                      </div>
                      <textarea name="comment-post" id="bmReplyComment"></textarea>
                    </div>
                  </div>

                  <div class="list-comment">
                    <div class="d-flex flex-column flex-lg-row comment-item">
                      <div class="comment-img">
                        <img src="assets/img/frontend/review-avatar.jpg" alt="comment avatar" class="img-fluid">
                        <span class="mt-3 d-block">John</span>
                      </div>
                      <div class="comment-body">
                        <p class="font500">08/31/2021</p>
                        <ul class="list-inline list-rating">
                          <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star-fill"></i></a></li>
                          <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star-fill"></i></a></li>
                          <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star-fill"></i></a></li>
                          <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star-fill"></i></a></li>
                          <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star-fill"></i></a></li>
                        </ul>
                        <p class="page-text-sm">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed in maximus libero. Fusce
                          vulputate, lectus vitae rhoncus bibendum, eros purus dignissim sapien, sit amet sollicitudin
                          nulla felis sit amet sem. Proin augue felis, luctus vitae enim eu, consectetur rhoncus ligula.
                          Donec elementum fringilla rhoncus. Vestibulum in accumsan velit. Donec interdum.
                          onec elementum fringilla rhoncus. Vestibulum in accumsan velit. Donec interdum.
                        </p>
                      </div>
                    </div>
                    <div class="d-flex flex-column flex-lg-row comment-item">
                      <div class="comment-img">
                        <img src="assets/img/frontend/review-avatar.jpg" alt="comment avatar" class="img-fluid">
                        <span class="mt-3 d-block ">John</span>
                      </div>
                      <div class="comment-body">
                        <p class="font500">08/31/2021</p>
                        <ul class="list-inline list-rating">
                          <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star-fill"></i></a></li>
                          <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star-fill"></i></a></li>
                          <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star-fill"></i></a></li>
                          <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star-fill"></i></a></li>
                          <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star-fill"></i></a></li>
                        </ul>
                        <p class="page-text-sm">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed in maximus libero. Fusce
                          vulputate, lectus vitae rhoncus bibendum, eros purus dignissim sapien, sit amet sollicitudin
                          nulla felis sit amet sem. Proin augue felis, luctus vitae enim eu, consectetur rhoncus ligula.
                          Donec elementum fringilla rhoncus. Vestibulum in accumsan velit. Donec interdum.
                          onec elementum fringilla rhoncus. Vestibulum in accumsan velit. Donec interdum.
                        </p>
                      </div>
                    </div>

                    <div class="d-flex flex-column flex-lg-row comment-item">
                      <div class="comment-img">
                        <img src="assets/img/frontend/review-avatar.jpg" alt="comment avatar" class="img-fluid">
                        <span class="mt-3 d-block ">John</span>
                      </div>
                      <div class="comment-body">
                        <p class="font500">08/31/2021</p>
                        <ul class="list-inline list-rating">
                          <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star-fill"></i></a></li>
                          <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star-fill"></i></a></li>
                          <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star-fill"></i></a></li>
                          <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star-fill"></i></a></li>
                          <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star-fill"></i></a></li>
                        </ul>
                        <p class="page-text-sm">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed in maximus libero. Fusce
                          vulputate, lectus vitae rhoncus bibendum, eros purus dignissim sapien, sit amet sollicitudin
                          nulla felis sit amet sem. Proin augue felis, luctus vitae enim eu, consectetur rhoncus ligula.
                          Donec elementum fringilla rhoncus. Vestibulum in accumsan velit. Donec interdum.
                          onec elementum fringilla rhoncus. Vestibulum in accumsan velit. Donec interdum.
                        </p>
                      </div>
                    </div>

                    <div class="d-flex flex-column flex-lg-row comment-item">
                      <div class="comment-img">
                        <img src="assets/img/frontend/review-avatar.jpg" alt="comment avatar" class="img-fluid">
                        <span class="mt-3 d-block">John</span>
                      </div>
                      <div class="comment-body">
                        <p class="font500">08/31/2021</p>
                        <ul class="list-inline list-rating">
                          <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star-fill"></i></a></li>
                          <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star-fill"></i></a></li>
                          <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star-fill"></i></a></li>
                          <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star-fill"></i></a></li>
                          <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star-fill"></i></a></li>
                        </ul>
                        <img src="assets/img/frontend/review-img-comment.svg" alt="comment avatar" class="img-fluid">
                        <p class="page-text-sm">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed in maximus libero. Fusce
                          vulputate, lectus vitae rhoncus bibendum, eros purus dignissim sapien, sit amet sollicitudin
                          nulla felis sit amet sem. Proin augue felis, luctus vitae enim eu, consectetur rhoncus ligula.
                          Donec elementum fringilla rhoncus. Vestibulum in accumsan velit. Donec interdum.
                          onec elementum fringilla rhoncus. Vestibulum in accumsan velit. Donec interdum.
                        </p>
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
                    <div class="custom-select choose-perpage">
                    <select>
                        <option value="10" selected>10</option>
                        <option value="20" >20</option>
                        <option value="30" >30</option>
                        <option value="40" >40</option>
                        <option value="50" >50</option>
                    </select>
                    </div>
                    <span class="ms-2">/</span>
                    <span class=""> Page</span>
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
</main>
<?php $this->load->view('frontend/includes/footer'); ?>