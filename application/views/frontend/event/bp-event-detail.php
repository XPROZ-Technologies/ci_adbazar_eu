<?php $this->load->view('frontend/includes/header'); ?>
<main>
    <div class="page-user-manager">
        <div class="um-event-detail">
            <div class="container">
                <div class="bp-event-back mb-3 mb-md-4">
                    <a href="bp-event.html" class="text-dark text-decoration-underline">
                        <img src="assets/img/frontend/icon-goback.png" alt="icon-goback" class="img-fluid me-1">Back
                    </a>
                </div>
                <div class="row">
                    <div class="col-lg-4 mb-3 mb-lg-0">
                        <div class="um-event-detail-left">
                            <div class="detail-img">
                                <img src="assets/img/frontend/bp-event-detail.jpg" alt="even detail image" class="img-fluid w-100">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="um-event-detail-right">
                            <h3 class="page-title-md fw-bold"><?php echo $detailInfo['event_subject']; ?></h3>
                            <p class="mb-0 page-text-lg">By <a href="<?php echo base_url(BUSINESS_PROFILE_URL.$businessInfo['business_url']); ?>" class="fw-bold"><?php echo $businessInfo['business_name']; ?></a></p>
                            <hr>
                            <div class="d-flex flex-column flex-lg-row align-items-lg-end justify-content-lg-between info">
                                <ul class="list-unstyled mb-0 page-text-md">
                                    <li class="font500"><?php echo ddMMyyyy($detailInfo['start_date'], 'M d, Y'); ?> - <?php echo ddMMyyyy($detailInfo['end_date'], 'M d, Y'); ?></li>
                                    <li class="font500"><?php echo ddMMyyyy($detailInfo['start_time'], 'H:i'); ?> - <?php echo ddMMyyyy($detailInfo['end_time'], 'H:i'); ?></li>
                                    <li><?php echo priceFormat($detailInfo['event_join']); ?> others are going</li>
                                </ul>
                                <div>
                                    <?php if (empty($customerEvent)) { ?>
                                        <button type="button" class="btn btn-red btn-join btn-join-event" data-id="<?php echo $detailInfo['id']; ?>" data-customer="<?php echo $customer['id']; ?>">Join</button>
                                        <button type="button" class="btn btn-red btn-red-disabled btn-join btn-saved btn-hidden" disabled>Joined</button>
                                    <?php } else { ?>
                                        <button type="button" data-bs-toggle="modal" data-bs-target="#removeEventModal" class="btn btn-outline-red">Remove</button>
                                    <?php } ?>
                                </div>
                            </div>
                            <hr>

                            <div class="d-flex align-items-center detail-horizontal">
                                <div class="horizontal-img">
                                    <img src="<?php echo BUSINESS_PROFILE_PATH . $businessInfo['business_avatar'] ?>" alt="<?php echo $businessInfo['business_name']; ?>" class="img-fluid">
                                </div>
                                <div class="horizontal-body">
                                    <h6 class="mb-0 card-title page-text-lg"><a href="<?php echo base_url(BUSINESS_PROFILE_URL.$businessInfo['business_url']); ?>"><?php echo $businessInfo['business_name']; ?></a></h6>
                                    <p class="my-3 card-text page-text-sm"><?php echo $businessInfo['business_phone']; ?></p>
                                    <p class="mb-0 card-text page-text-sm"><?php echo $businessInfo['business_address']; ?></p>
                                </div>
                            </div>

                            <hr>

                            <h5 class="mb-3 page-text-lg">Conditions and Descriptions:</h5>
                            <p class="page-text-md mb-0"><?php echo $detailInfo['event_description']; ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal confirm remove -->
    <div class="modal fade" id="removeEventModal" tabindex="-1" aria-labelledby="removeEventModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-medium">
            <div class="modal-content">
                <div class="modal-header border-bottom-0">
                    <!-- <h5 class="modal-title" id="savedCouponModalLabel">Modal title</h5> -->
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="text-center">Are you sure want to remove the coupon
                        "<b><?php echo $detailInfo['event_subject']; ?></b>"</p>
                    <div class="d-flex justify-content-center">
                        <a href="javascript:void(0)" class="btn btn-red btn-yes btn-remove-event" data-bs-dismiss="modal">Yes</a>
                        <a href="javascript:void(0)" class="btn btn-outline-red btn-cancel" data-bs-dismiss="modal">Cancel</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal confirm remove -->
</main>
<?php $this->load->view('frontend/includes/footer'); ?>
<script>
    $('.btn-join-event').click(function() {
        var button = $(this);
        $.ajax({
            type: "POST",
            url: '<?php echo base_url('customer-join-event'); ?>',
            data: {
                event_id: <?php echo $detailInfo['id']; ?>,
                customer_id: <?php echo $customer['id']; ?>
            },
            dataType: "json",
            success: function(response) {
                if (response.code == 1) {
                    button.addClass('btn-hidden');
                    $('.btn-saved').removeClass('btn-hidden');
                    $("#eventModal").modal("show");
                }

            },
            error: function(response) {
                // showNotification($('input#errorCommonMessage').val(), 0);
                // $('.submit').prop('disabled', false);
            }
        });
    });

    $('.btn-remove-event').click(function() {
        $.ajax({
            type: "POST",
            url: '<?php echo base_url('customer-left-event'); ?>',
            data: {
                event_id: <?php echo $detailInfo['id']; ?>,
                customer_id: <?php echo $customer['id']; ?>
            },
            dataType: "json",
            success: function(response) {
                if (response.code == 1) {
                    //$("#removeEventModal").modal("show");
                    redirect(true);
                }

            },
            error: function(response) {
                // showNotification($('input#errorCommonMessage').val(), 0);
                // $('.submit').prop('disabled', false);
            }
        });
    });
    /*
    $('.btn-close-removed').click(function() {
        $("#removeEventModal").modal("hide");
        redirect(true);
    });
    */
</script>