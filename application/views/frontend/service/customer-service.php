<?php $this->load->view('frontend/includes/header'); ?>
    <main class="main-customer">
        <div class="page-customer-service">
            <div class="customer-service-grid">
                <div class="container">
                    <h2 class="page-heading page-title-md text-black fw-bold">Services</h2>
                    <div class="row">
                        <?php if(!empty($services) && count($services) > 0){ ?>
                          <?php for($i = 0; $i < count($services); $i++){ $serviceUrl = base_url('service/'.makeSlug($services[$i]['service_slug']).'-'.$services[$i]['id']).'.html'; ?>
                            <!-- service item -->
                            <div class="col-md-6 col-lg-3">
                                <a href="<?php echo $serviceUrl; ?>" class="card customer-service-item">
                                    <span class="customer-service-img">
                                        <img src="<?php echo SERVICE_PATH.$services[$i]['service_image'] ?>" class="card-img-top img-fluid"
                                            alt="<?php echo $services[$i]['service_name']; ?>">
                                    </span>
                                    <div class="card-body text-center">
                                        <h5 class="card-title">
                                            <span><?php echo $services[$i]['service_name']; ?></span>
                                        </h5>
        
                                    </div>
                                </a>
                            </div>
                            <!-- END. service item -->
                            <?php } ?>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <?php $this->load->view('frontend/includes/footer'); ?>