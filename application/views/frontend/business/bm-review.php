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
                          <div class="star-rate" data-rate="<?php echo $overall_rating; ?>"></div>
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
                    <span class="fw-bold star-rating-number">(<?php echo $count_five_star; ?>)</span>
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
                    <span class="fw-bold star-rating-number">(<?php echo $count_four_star; ?>)</span>
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
                    <span class="fw-bold star-rating-number">(<?php echo $count_three_star; ?>)</span>
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
                    <span class="fw-bold star-rating-number">(<?php echo $count_two_star; ?>)</span>
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
                    <span class="fw-bold star-rating-number">(<?php echo $count_one_star; ?>)</span>
                  </div>
                </div>
              </div>

              <div class="bp-comment">
                <h4 class="page-title-rv">Reviews (<?php echo $rowCount; ?>)</h4>
                <div class="bp-inner-content">
                  <?php if (!empty($lists) > 0) { ?>
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
                        <div class="custom-select mb-0 choose-order">
                          <select>
                            <option value="desc">Newest</option>
                            <option value="asc" <?php if (isset($order_by) && $order_by == 'asc') {
                                                  echo 'selected="selected"';
                                                } ?>>Oldest</option>
                          </select>
                        </div>
                      </div>

                    </div>

                    <div class="list-comment">

                      <!-- ITEM COMMENT -->
                      <?php foreach ($lists as $itemReview) { ?>
                        <!-- comment -->
                        <div class="d-flex flex-column flex-lg-row comment-item comment-item-<?php echo $itemReview['id']; ?>">
                          <div class="comment-img">
                            <?php
                            $customerImg = CUSTOMER_PATH . NO_IMAGE;
                            if (!empty($itemReview['customer_avatar'])) {
                              $customerImg = CUSTOMER_PATH . $itemReview['customer_avatar'];
                            }
                            ?>
                            <img src="<?php echo $customerImg; ?>" alt="comment avatar" class="img-fluid">
                            <span class="mt-3 d-block"><?php echo $itemReview['customerInfo']['customer_first_name']; ?></span>
                          </div>
                          <div class="comment-body">
                            <p class="font500"><?php echo ddMMyyyy($itemReview['created_at'], 'd/m/Y H:i'); ?></p>
                            <div class="star-rating on line relative mr-8px">
                              <div class="star-base">
                                <div class="star-rate" data-rate="<?php echo $itemReview['review_star']; ?>"></div>
                                <a dt-value="1" href="#1"></a>
                                <a dt-value="2" href="#2"></a>
                                <a dt-value="3" href="#3"></a>
                                <a dt-value="4" href="#4"></a>
                                <a dt-value="5" href="#5"></a>
                              </div>
                            </div>
                            <p class="page-text-sm"><?php echo $itemReview['customer_comment']; ?>
                            </p>

                            <div class="text-right">
                              <?php if (empty($itemReview['business_comment'])) { ?>
                                <a href="javascript:void(0)" title="" class="btn btn-red d-inline-block reply-comment" data-review="<?php echo $itemReview['id']; ?>">Reply</a>
                              <?php } ?>
                              <a href="javascript:void(0)" title="" class="btn btn-outline-red d-inline-block delete-comment" data-review="<?php echo $itemReview['id']; ?>" ><img src="assets/img/frontend/icon-del.png" alt=""> Delete</a>
                            </div>

                          </div>
                        </div>

                        <!-- reply -->
                        <?php if (!empty($itemReview['business_comment'])) { ?>
                          <div class="d-flex flex-column flex-lg-row comment-item no-avatar">
                            <div class="comment-body">
                              <p class="font500"><?php echo ddMMyyyy($itemReview['updated_at'], 'd/m/Y H:i'); ?></p>
                              <ul class="list-inline list-rating">
                                <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star-fill"></i></a></li>
                                <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star-fill"></i></a></li>
                                <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star-fill"></i></a></li>
                                <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star-fill"></i></a></li>
                                <li class="list-inline-item me-0"><a href="#"><i class="bi bi-star-fill"></i></a></li>
                              </ul>
                              <p class="page-text-sm"><?php echo $itemReview['business_comment']; ?></p>
                            </div>
                          </div>
                        <?php } else { ?>
                          <div class="comment-item no-avatar comment-reply comment-reply-<?php echo $itemReview['id']; ?>">
                            <div class="d-flex align-items-center justify-content-between">
                              <p class="page-text-md text-secondary mb-2">Reply to customer:</p>
                              <div class="d-flex mb-10">
                                <button type="button" class="btn btn-red btn-bm-reply" data-id="<?php echo $itemReview['id']; ?>">Submit</button>
                                <button type="submit" class="btn btn-outline-red ml-8px reply-cancel">cancel</button>
                              </div>
                            </div>
                            <textarea name="comment-post" id="bmReplyComment-<?php echo $itemReview['id']; ?>"></textarea>
                          </div>
                        <?php } ?>
                      <?php } ?>
                      <!-- END. ITEM COMMENT -->

                    </div>

                  <?php } else { ?>
                    <div class="zero-event zero-box">
                      <img src="assets/img/frontend/img-empty-box.svg" alt="img-empty-box" class="img-fluid d-block mx-auto">
                      <p class="text-secondary page-text-lg">No reviews</p>
                    </div>
                  <?php } ?>

                </div>
              </div>
            </div>

            <!-- Pagination -->
            <?php if (!empty($lists) > 0) { ?>
              <div class="d-flex align-items-center flex-column flex-md-row justify-content-between page-pagination">
                <div class="d-flex align-items-center pagination-left">
                  <p class="page-text-sm mb-0 me-3">Showing <span class="fw-500"><?php echo ($page - 1) * $perPage + 1; ?> – <?php echo ($page - 1) * $perPage + count($lists); ?></span> of <span class="fw-500"><?php echo number_format($rowCount); ?></span>
                    results</p>
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
</main>
<!-- Button trigger modal
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#leaveReview">
  Launch demo modal
</button>
 -->

<input type="hidden" id="businessId" value="<?php echo $businessInfo['id']; ?>" />
<input type="hidden" id="currentBaseUrl" value="<?php echo $basePagingUrl; ?>" />
<?php $this->load->view('frontend/includes/footer'); ?>

<script>
  $(document).ready(function() {
    var editorGroup = [];
    <?php if (!empty($lists)) {
      foreach ($lists as $itemReview) { ?>
        //editor

        const replyComment_<?php echo $itemReview['id']; ?> = document.querySelector("#bmReplyComment-<?php echo $itemReview['id']; ?>");
        if (replyComment_<?php echo $itemReview['id']; ?>) {
          ClassicEditor.create(replyComment_<?php echo $itemReview['id']; ?>).then(newEditor => {
            let editorReply;
            editorReply = newEditor;
            editorGroup[<?php echo $itemReview['id']; ?>] = editorReply;
          });
        }
    <?php }
    } ?>

    //business leave a reply
    $('.btn-bm-reply').click(function(e) {
      var business_id = $("#businessId").val();
      var review_id = $(this).data('id');
      var business_comment = editorGroup[review_id].getData();
      
      if (review_id == 0) {
        $(".notiPopup .text-secondary").html("Review not exist");
        $(".ico-noti-error").removeClass('ico-hidden');
        $(".notiPopup").fadeIn('slow').fadeOut(4000);

        redirect(false, '<?php echo base_url(HOME_URL); ?>');
      }

      $.ajax({
        type: 'POST',
        url: '<?php echo base_url('business/leave-a-reply'); ?>',
        data: {
          review_id: review_id,
          business_id: business_id,
          business_comment: business_comment
        },
        dataType: "json",
        success: function(data) {
          $('.comment-reply-' + review_id).hide();

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
          $(".notiPopup .text-secondary").html("Reply review failed");
          $(".ico-noti-error").removeClass('ico-hidden');
          $(".notiPopup").fadeIn('slow').fadeOut(4000);

          redirect(true);
        }
      });

    });

    //business remove review
    $('.delete-comment').click(function(e) {
      var business_id = $("#businessId").val();
      var review_id = $(this).data('review');

      if (review_id == 0) {
        $(".notiPopup .text-secondary").html("Review not exist");
        $(".ico-noti-error").removeClass('ico-hidden');
        $(".notiPopup").fadeIn('slow').fadeOut(4000);

        redirect(false, '<?php echo base_url(HOME_URL); ?>');
      }

      $.ajax({
        type: 'POST',
        url: '<?php echo base_url('business/remove-review'); ?>',
        data: {
          review_id: review_id,
          business_id: business_id
        },
        dataType: "json",
        success: function(data) {
          $('.comment-item-' + review_id).hide();
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
          $(".notiPopup .text-secondary").html("Reply review failed");
          $(".ico-noti-error").removeClass('ico-hidden');
          $(".notiPopup").fadeIn('slow').fadeOut(4000);

          redirect(true);
        }
      });

    });

  });
</script>