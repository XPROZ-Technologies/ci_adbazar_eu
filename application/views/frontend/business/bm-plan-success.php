<?php $this->load->view('frontend/includes/header'); ?>
    <main>
        <div class="page-business-manager">
            
            <?php $this->load->view('frontend/includes/bm_top_header'); ?>

            <div class="bm-plan-success">
                <div class="container">
                    <div class="row justify-content-center text-center">
                        <div class="col-lg-8 d-flex flex-column justify-content-center align-items-center">
                            <h3 class="page-title mb-0 fw-bold">CONGRATULATIONS</h3>
                            <p>You have successfully started your one-month free trial. You won’t be charged anything until your trial period ends. We will send you a notification to remind you when it’s time to pay for your plan. </p>
                            <a href="<?php echo base_url('business-profile/create-new-business?plan='.$plan); ?>" class="btn btn-red btn-create-bp">+ Create a business profile</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <?php $this->load->view('frontend/includes/footer'); ?>