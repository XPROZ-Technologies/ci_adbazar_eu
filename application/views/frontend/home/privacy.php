<?php $this->load->view('frontend/includes/header'); ?>
<main class="main-customer">
    <div class="page-customer-service">
        <div class="customer-service-grid">
            <div class="container">
                <h2 class="page-heading page-title-md text-black fw-bold"><?php echo $this->lang->line('about_us'); ?></h2>
                <div class="row">
                    <div class="">
                        <p class="page-text-lg"><?php 
                                 echo $content; 
                            ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?php $this->load->view('frontend/includes/footer'); ?>