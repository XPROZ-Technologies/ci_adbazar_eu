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
            <div class="bp-review">
              <div class="review-top">
                <div class="col-review">
                  <div class="d-flex flex-column justify-content-center align-items-center overall-rate">
                    <h5 class="page-title-xs">Overall rating</h5>
                    <ul class="list-inline mb-0 list-rating">
                      <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star-fill"></i></a></li>
                      <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star-fill"></i></a></li>
                      <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star-fill"></i></a></li>
                      <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star-fill"></i></a></li>
                      <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star"></i></a></li>
                    </ul>
                  </div>
                </div>
                <div class="col-review">
                  <ul class="list-inline list-rating">
                    <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star-fill"></i></a></li>
                    <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star-fill"></i></a></li>
                    <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star-fill"></i></a></li>
                    <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star-fill"></i></a></li>
                    <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star-fill"></i></a></li>
                    <li class="list-inline-item me-0">(15)</li>
                  </ul>
                  <ul class="list-inline list-rating">
                    <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star-fill"></i></a></li>
                    <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star-fill"></i></a></li>
                    <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star-fill"></i></a></li>
                    <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star-fill"></i></a></li>
                    <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star"></i></a></li>
                    <li class="list-inline-item me-0">(10)</li>
                  </ul>
                  <ul class="list-inline list-rating">
                    <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star-fill"></i></a></li>
                    <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star-fill"></i></a></li>
                    <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star-fill"></i></a></li>
                    <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star"></i></a></li>
                    <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star"></i></a></li>
                    <li class="list-inline-item me-0">(3)</li>
                  </ul>
                  <ul class="list-inline list-rating">
                    <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star-fill"></i></a></li>
                    <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star-fill"></i></a></li>
                    <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star"></i></a></li>
                    <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star"></i></a></li>
                    <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star"></i></a></li>
                    <li class="list-inline-item me-0">(2)</li>
                  </ul>
                  <ul class="list-inline list-rating">
                    <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star-fill"></i></a></li>
                    <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star"></i></a></li>
                    <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star"></i></a></li>
                    <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star"></i></a></li>
                    <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star"></i></a></li>
                    <li class="list-inline-item me-0">(1)</li>
                  </ul>
                </div>
                <div class="col-review">
                  <div class="d-flex justify-content-lg-end">
                    <a href="javascript:void(0)" class="review-btn btn btn-red" data-bs-target="#leaveReview" data-bs-toggle="modal">
                      <img src="assets/img/frontend/icon-up.png" alt="icon-edit" class="img-fluid me-2">
                      Leave a review</a>
                  </div>
                </div>
              </div>

              <div class="bp-comment">
                <h4 class="page-title-rv">Reviews (31)</h4>
                <div class="bp-inner-content">
                  <div class="notification-wrapper-filter d-flex align-items-center justify-content-md-between">
                    <div class="d-flex align-items-center inner-filter">
                      <!--
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
                      -->
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
                          <a href="" title="" class="btn btn-red d-inline-block">Reply</a>
                          <a href="" title="" class="btn btn-outline-red d-inline-block"><img src="assets/img/frontend/icon-del.png" alt=""> Delete</a>
                        </div>
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
                      </div>
                    </div>

                    <div class="d-flex flex-column flex-lg-row comment-item no-avatar">
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
</main>
<input type="hidden" id="currentBaseUrl" value="<?php echo $basePagingUrl; ?>" />
<?php $this->load->view('frontend/includes/footer'); ?>

<!-- Modal -->
<div class="modal fade" id="leaveReview" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <h2>Leave a review</h2>
      <div class="d-flex align-items-center justify-content-center">
        <div class="star-rating on line  mr-8px relative">
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
      <p class="leaveReview-text">Write your review</p>
      <input type="hidden" id="reviewStar" value="5" />
      <input type="hidden" id="businessId" value="<?php if (isset($businessInfo['id'])) {
                                                    echo $businessInfo['id'];
                                                  } else {
                                                    echo 0;
                                                  } ?>" />
      <input type="hidden" id="customerId" value="<?php if (isset($customer['id'])) {
                                                    echo $customer['id'];
                                                  } else {
                                                    echo 0;
                                                  } ?>" />
      <textarea name="comment-post" id="leaveReviewComment"></textarea>
      <div class="d-flex align-items-center  justify-content-end mt-20">
        <button type="button" class="btn btn-red btn-leave-review">Submit</button>
        <button type="button" class="btn btn-outline-red ml-8px reply-cancel" data-bs-dismiss="modal" aria-label="Close">cancel</button>
      </div>
    </div>
  </div>
</div>

<script>
  $(document).ready(function() {

    let editorReview;
    const leaveReviewComment = document.querySelector("#leaveReviewComment");
    if (leaveReviewComment) {
      ClassicEditor.create(leaveReviewComment).then(newEditor => {
        editorReview = newEditor;
      });
    }


    $('.btn-leave-review').click(function(e) {
      var business_id = $("#businessId").val();
      var customer_id = $("#customerId").val();
      var customer_comment = editorReview.getData();
      var review_star = $("#reviewStar").val();

      if (business_id == 0) {
        $(".notiPopup .text-secondary").html("Business profile not exist");
        $(".ico-noti-error").removeClass('ico-hidden');
        $(".notiPopup").fadeIn('slow').fadeOut(4000);

        redirect(false, '<?php echo base_url(HOME_URL); ?>');
      }

      if (customer_id == 0) {
        $(".notiPopup .text-secondary").html("Please login to leave a review");
        $(".ico-noti-error").removeClass('ico-hidden');
        $(".notiPopup").fadeIn('slow').fadeOut(4000);
      }

      $('#leaveReview').modal('hide');

      $.ajax({
        type: 'POST',
        url: '<?php echo base_url('business/leave-a-review'); ?>',
        data: {
          customer_id: customer_id,
          business_id: business_id,
          customer_comment: customer_comment,
          review_star: review_star
        },
        dataType: "json",
        success: function(data) {
          if (data.code == 1) {
            $(".notiPopup .text-secondary").html(data.message);
            $(".ico-noti-success").removeClass('ico-hidden');
            $(".notiPopup").fadeIn('slow').fadeOut(4000);
          } else {
            $(".notiPopup .text-secondary").html(data.message);
            $(".ico-noti-error").removeClass('ico-hidden');
            $(".notiPopup").fadeIn('slow').fadeOut(4000);
          }
          redirect(true);
        },
        error: function(data) {
          $(".notiPopup .text-secondary").html("Leave a review failed");
          $(".ico-noti-error").removeClass('ico-hidden');
          $(".notiPopup").fadeIn('slow').fadeOut(4000);

          redirect(true);
        }
      });

    });

  });
</script>