<?php $this->load->view('frontend/includes/header'); ?>
    <main>
        <div class="page-customer-service">
            <div class="customer-service-grid">
                <div class="container">
                    <h2 class="page-heading page-title-md text-black fw-bold">Services</h2>
                    <div class="row">
                        <?php if(!empty($services) && count($services) > 0){ ?>
                          <?php for($i = 0; $i < count($services); $i++){ $serviceUrl = base_url('service/'.makeSlug($services[$i]['service_slug']).'-'.$services[$i]['id']).'.html'; ?>
                            <!-- service item -->
                            <div class="col-md-6 col-lg-3">
                                <div class="card customer-service-item">
                                    <a href="<?php echo $serviceUrl; ?>" class="customer-service-img">
                                        <img src="<?php echo SERVICE_PATH.$services[$i]['service_image'] ?>" class="card-img-top img-fluid"
                                            alt="<?php echo $services[$i]['service_name']; ?>">
                                    </a>
                                    <div class="card-body text-center">
                                        <h5 class="card-title">
                                            <a href="<?php echo $serviceUrl; ?>"><?php echo $services[$i]['service_name']; ?></a>
                                        </h5>
        
                                    </div>
                                </div>
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