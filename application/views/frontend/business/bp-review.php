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
                    <h5 class="page-title-xs"><?php echo $this->lang->line('overall_rating'); ?></h5>
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

                <div class="col-review">
                  <div class="d-flex justify-content-lg-end">
                    <?php if (isset($customer['id']) && $customer['id'] > 0 && $allowReview == true) { ?>
                      <a href="javascript:void(0)" class="review-btn btn btn-red" data-bs-target="#leaveReview" data-bs-toggle="modal">
                        <img src="assets/img/frontend/icon-up.png" alt="icon-edit" class="img-fluid me-2">
                        <?php echo $this->lang->line('leave_a_review'); ?>
                      </a>
                    <?php } else if (!isset($customer['id']) || $customer['id'] == 0) { ?>
                      <a href="<?php echo base_url('login.html?requiredLogin=1&redirectUrl=' . current_url()) ?>" class="review-btn btn btn-red">
                        <img src="assets/img/frontend/icon-up.png" alt="icon-edit" class="img-fluid me-2">
                        <?php echo $this->lang->line('leave_a_review'); ?>
                      </a>
                    <?php } else if (isset($allowReview) && $allowReview == false) { ?>
                      <a href="javascript:void(0)" class="review-btn btn btn-red disabled" data-bs-target="#cannotReview" data-bs-toggle="modal">
                        <img src="assets/img/frontend/icon-up.png" alt="icon-edit" class="img-fluid me-2">
                        <?php echo $this->lang->line('leave_a_review'); ?>
                      </a>
                    <?php } ?>
                  </div>
                </div>
              </div>

              <div class="bp-comment">
                <h4 class="page-title-rv"><?php echo $this->lang->line('reviews'); ?> (<?php echo $rowCount; ?>)</h4>
                <div class="bp-inner-content">
                  <?php if (!empty($lists) > 0) { ?>
                    <div class="notification-wrapper-filter d-flex align-items-center justify-content-md-between">
                      <div class="d-flex align-items-center inner-filter">
                        <span class="me-2 page-text-lg fw-bold"><?php echo $this->lang->line('filter_by'); ?></span>
                        <div class="notification-filter">
                          <div class="custom-select mb-0 choose-star">
                            <select>
                              <option value="0"><?php echo $this->lang->line('1310_all'); ?></option>
                              <option value="5" <?php if (isset($review_star) && $review_star == 5) {
                                                  echo 'selected';
                                                } ?>>5 *</option>
                              <option value="4" <?php if (isset($review_star) && $review_star == 4) {
                                                  echo 'selected';
                                                } ?>>4 *</option>
                              <option value="3" <?php if (isset($review_star) && $review_star == 3) {
                                                  echo 'selected';
                                                } ?>>3 *</option>
                              <option value="2" <?php if (isset($review_star) && $review_star == 2) {
                                                  echo 'selected';
                                                } ?>>2 *</option>
                              <option value="1" <?php if (isset($review_star) && $review_star == 1) {
                                                  echo 'selected';
                                                } ?>>1 *</option>
                              <option value="6" <?php if (isset($review_star) && $review_star == 6) {
                                                  echo 'selected';
                                                } ?>>Photo</option>
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="d-flex align-items-center notification-sort">
                        <img src="assets/img/frontend/ic-sort.png" alt="sort icon" class="img-fluid me-2">
                        <div class="custom-select mb-0 choose-order">
                          <select>
                            <option value="desc"><?php echo $this->lang->line('1310_newest'); ?></option>
                            <option value="asc" <?php if (isset($order_by) && $order_by == 'asc') {
                                                  echo 'selected="selected"';
                                                } ?>><?php echo $this->lang->line('1310_oldest'); ?></option>
                          </select>
                        </div>
                      </div>
                    </div>


                    <div class="list-comment">

                      <!-- ITEM COMMENT -->
                      <?php foreach ($lists as $itemReview) { ?>
                        <!-- comment -->
                        <div class="d-flex flex-column flex-lg-row comment-item">
                          <div class="comment-img">
                            <?php
                            $customerImg = CUSTOMER_PATH . NO_IMAGE;
                            if (!empty($itemReview['customer_avatar'])) {
                              $customerImg = CUSTOMER_PATH . $itemReview['customer_avatar'];
                            }
                            ?>
                            <img src="<?php echo $customerImg; ?>" alt="comment avatar" class="img-fluid">
                            <span class="mt-3 d-block"><?php if (!empty($itemReview['customerInfo'])) {
                                                          echo $itemReview['customerInfo']['customer_first_name'];
                                                        }  ?></span>
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
                          </div>
                        </div>
                        <!-- reply -->
                        <?php if (!empty($itemReview['business_comment'])) { ?>
                          <div class="d-flex flex-column flex-lg-row comment-item no-avatar">
                            <div class="comment-body">
                              <p class="font500"><?php echo ddMMyyyy($itemReview['updated_at'], 'd/m/Y H:i'); ?></p>
                              <p class="page-text-sm"><?php echo $itemReview['business_comment']; ?></p>
                            </div>
                          </div>
                        <?php } ?>
                      <?php } ?>
                      <!-- END. ITEM COMMENT -->



                    </div>
                  <?php } else { ?>
                    <div class="zero-event zero-box">
                      <img src="assets/img/frontend/img-empty-box.svg" alt="img-empty-box" class="img-fluid d-block mx-auto">
                      <p class="text-secondary page-text-lg"><?php echo $this->lang->line('no-reviews1635566199'); ?></p>
                    </div>
                  <?php } ?>
                </div>
              </div>
            </div>

            <!-- Pagination -->
            <?php if (!empty($lists) > 0) { ?>
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
            <?php } ?>
            <!-- END. Pagination -->

          </div>
        </div>
      </div>
    </div>
  </div>
</main>
<input type="hidden" id="currentBaseUrl" value="<?php echo $basePagingUrl; ?>" />
<?php $this->load->view('frontend/includes/footer'); ?>

<!-- Modal review -->
<div class="modal fade" id="leaveReview" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <h2><?php echo $this->lang->line('leave_a_review'); ?></h2>
      <div class="d-flex align-items-center justify-content-center">
        <div class="star-rating on line  mr-8px relative">
          <div class="star-base">
            <div class="star-rate" data-rate="5"></div>
            <a dt-value="1" href="javascript:void(0)"></a>
            <a dt-value="2" href="javascript:void(0)"></a>
            <a dt-value="3" href="javascript:void(0)"></a>
            <a dt-value="4" href="javascript:void(0)"></a>
            <a dt-value="5" href="javascript:void(0)"></a>
          </div>
        </div>
      </div>
      <p class="leaveReview-text"><?php echo $this->lang->line('write_your_review'); ?></p>

      <input type="hidden" id="rankStar" value="5" />
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
        <button type="button" class="btn btn-red btn-leave-review"><?php echo $this->lang->line('submit'); ?></button>
        <button type="button" class="btn btn-outline-red ml-8px reply-cancel" data-bs-dismiss="modal" aria-label="Close"><?php echo $this->lang->line('cancel'); ?></button>
      </div>
    </div>
  </div>
</div>
<!-- END. Modal review -->

<!-- Modal cannot review -->
<div class="modal fade" id="cannotReview" tabindex="-1" aria-labelledby="cannotReviewLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body">
        <p class="page-text-lg text-center"><?php echo $this->lang->line('you-have-already-rated-this-bu1635566199'); ?></p>
      </div>
    </div>
  </div>
</div>
<!-- End. Modal cannot review -->

<script>
  $(document).ready(function() {
    // star rating
    $('#leaveReview .star-base a').click(function(e) {
      var rate = $(this).attr('dt-value');
      var width = 0;
      width = rate * 21.43;
      $("#rankStar").val(rate);
      $(this).closest('.star-base').find('.star-rate').css('width', width);
    });

    // editor
    if (CKEDITOR.env.ie && CKEDITOR.env.version < 9)
      CKEDITOR.tools.enableHtml5Elements(document);
    CKEDITOR.config.height = 150;
    CKEDITOR.config.width = 'auto';

    var wysiwygareaAvailable = isWysiwygareaAvailable(),
      isBBCodeBuiltIn = !!CKEDITOR.plugins.get('bbcode');
    var editorElement = CKEDITOR.document.getById('leaveReviewComment');
    if (isBBCodeBuiltIn) {
      editorElement.setHtml();
    }
    if (wysiwygareaAvailable) {
      CKEDITOR.replace('leaveReviewComment');
    } else {
      editorElement.setAttribute('contenteditable', 'true');
      CKEDITOR.inline('leaveReviewComment');

    }

    function isWysiwygareaAvailable() {
      if (CKEDITOR.revision == ('%RE' + 'V%')) {
        return true;
      }

      return !!CKEDITOR.plugins.get('wysiwygarea');
    }
    // let editorReview;
    // const leaveReviewComment = document.querySelector("#leaveReviewComment");
    // if (leaveReviewComment) {
    //   ClassicEditor.create(leaveReviewComment).then(newEditor => {
    //     editorReview = newEditor;
    //   });
    // }

    //customer leave a review
    $('.btn-leave-review').click(function(e) {
      var business_id = $("#businessId").val();
      var customer_id = $("#customerId").val();
      var customer_comment = CKEDITOR.instances['leaveReviewComment'].getData();
      var review_star = $("#rankStar").val();

      if (business_id == 0) {
        $(".notiPopup .text-secondary").html(<?php echo $this->lang->line('business-profile-does-not-exis1635566199'); ?>);
        $(".ico-noti-error").removeClass('ico-hidden');
        $(".notiPopup").fadeIn('slow').fadeOut(5000);

        redirect(false, '<?php echo base_url(HOME_URL); ?>');
      }

      if (customer_id == 0) {
        $(".notiPopup .text-secondary").html(<?php echo $this->lang->line('please-login-to-leave-a-review1635566199'); ?>);
        $(".ico-noti-error").removeClass('ico-hidden');
        $(".notiPopup").fadeIn('slow').fadeOut(5000);
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
            $(".notiPopup").fadeIn('slow').fadeOut(5000);
          } else {
            $(".notiPopup .text-secondary").html(data.message);
            $(".ico-noti-error").removeClass('ico-hidden');
            $(".notiPopup").fadeIn('slow').fadeOut(5000);
          }
          redirect(true);
        },
        error: function(data) {
          $(".notiPopup .text-secondary").html(<?php echo $this->lang->line('failed-leaving-a-review1635566199'); ?>);
          $(".ico-noti-error").removeClass('ico-hidden');
          $(".notiPopup").fadeIn('slow').fadeOut(5000);

          redirect(true);
        }
      });

    });

  });
</script>