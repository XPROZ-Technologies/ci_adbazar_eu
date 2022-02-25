<?php $this->load->view('frontend/includes/header_login_signup'); ?>
<main class="signup-box">
    <div class="page-signup">
        <div class="signup-img">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <a href="<?php echo base_url(HOME_URL); ?>">
                            <img src="<?php echo CONFIG_PATH . $configs['LOGO_IMAGE_HEADER']; ?>" alt="<?php echo $configs['TEXT_LOGO_HEADER']; ?>" class="img-fluid">
                        </a>
                        <h2 class="text-center mb-20 page-title-sm v1"><?php echo $this->lang->line('update_customer_email'); ?></h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="signup-form">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <form action="#">
                            <input type="hidden" id="customerId" value="" />
                            
                            <div class="form-group mb-40 rePasswordContent"> <!-- has-validation -->
                                <label for="inputCustomerEmail" class="form-label"><?php echo $this->lang->line('email'); ?></label>
                                <div class="position-relative">
                                    <input type="email" class="form-control " id="inputCustomerEmail" placeholder="<?php echo $this->lang->line('confirm_password'); ?>"><!-- is-invalid -->
                                    <!-- 
                                    <div class="invalid-feedback">
                                        *Your password doesn't match. Please try again.
                                    </div> -->
                                </div>
                            </div>

                            <div class="d-flex justify-content-center">
                                <button type="button" class="btn btn-red px-5 btn-update-email"><?php echo $this->lang->line('submit'); ?></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php $this->load->view('frontend/includes/popup_noti'); ?>
</main>
<?php $this->load->view('frontend/includes/footer_login_signup'); ?>
<script>
    $('.btn-update-email').click(function(e) {
        e.preventDefault();
        var customer_email = $("#inputCustomerEmail").val();
        
        var regEmail = /\S+@\S+\.\S+/;
        if (! regEmail.test(customer_email) && customer_email != '') {
            $(".notiPopup .text-secondary").html('Wrong email');
            $(".ico-noti-success").removeClass('ico-hidden');
            $(".notiPopup").fadeIn('slow').fadeOut(5000);
        }

        $.ajax({
            type: 'POST',
            url: '<?php echo base_url('submit-update-email'); ?>',
            data: {
                customer_email: customer_email
            },
            dataType: "json",
            success: function(data) {
                if (data.code == 1) {
                    $(".notiPopup .text-secondary").html(data.message);
                    $(".ico-noti-success").removeClass('ico-hidden');
                    $(".notiPopup").fadeIn('slow').fadeOut(5000);
                    redirect(false, '<?php echo base_url('login.html') ?>');
                } else {
                    $(".notiPopup .text-secondary").html(data.message);
                    $(".ico-noti-error").removeClass('ico-hidden');
                    $(".notiPopup").fadeIn('slow').fadeOut(5000);
                    redirect(true);
                }
            },
            error: function(data) {
                $(".notiPopup .text-secondary").html("Failed");
                $(".ico-noti-error").removeClass('ico-hidden');
                $(".notiPopup").fadeIn('slow').fadeOut(5000);
                redirect(true);
            }
        });
    });
</script>