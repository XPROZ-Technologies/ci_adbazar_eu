<?php $this->load->view('frontend/includes/header'); ?>
<main>
    <div class="page-business-profile v2">
        <?php $this->load->view('frontend/includes/bm_top_header'); ?>

        <div class="bm-list">
            <div class="container">
                <div class="bm-innner-list grid-40">
                    <!-- If item < 2 please add class 'justify-content-center' to class row below -->
                    <div class="row">
                        <?php if (!empty($businessProfiles)) { foreach($businessProfiles as $itemBusiness){ ?>
                            <?php if(empty($itemBusiness['business_avatar'])) { $itemBusiness['business_avatar'] = NO_IMAGE; } ?>
                            <div class="col-sm-6 col-lg-3">
                                <div class="card bm-item">
                                    <a href="<?php echo base_url('business-management/'.$itemBusiness['business_url'].'/about-us'); ?>" class="d-block bm-item-img">
                                        <img src="<?php echo BUSINESS_PROFILE_PATH . $itemBusiness['business_avatar']; ?>" class="card-img-top img-fluid" alt="<?php echo $itemBusiness['business_name']; ?>">
                                    </a>
                                    <div class="card-body pt-0">
                                        <h5 class="card-title page-text-lg text-black text-center"><?php echo $itemBusiness['business_name']; ?></h5>
                                        <div class="text-center">
                                            <a href="<?php echo base_url('business-management/'.$itemBusiness['business_url'].'/about-us'); ?>" class="btn btn-red btn-manager btn-red-md"><?php echo $this->lang->line('manage'); ?></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } } ?>
                        <!-- Create new Business Profiles -->
                        <div class="col-sm-6 col-lg-3">
                            <div class="card bm-item bm-item-add">
                                <img src="assets/img/frontend/bm-plus.png" alt="plus icon">
                            </div>
                        </div>
                        <!-- END. Create new Business Profiles -->
                    </div>
                    <!-- Pagination
                        <div class="w-100">
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
                                  
                                </div>
                            </div>
                        </div>
                        END. Pagination -->
                </div>
            </div>
        </div>
    </div>
</main>
<?php $this->load->view('frontend/includes/footer'); ?>

<!-- Modal cannot create -->
<div class="modal fade" id="bmCannotCreateModal" tabindex="-1" aria-labelledby="bmCannotCreateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <p class="page-text-lg text-center"><?php echo $this->lang->line('manage'); ?><?php echo $this->lang->line('you_cannot_create_a_second_bus'); ?></p>
                    <a href="<?php echo base_url(HOME_URL); ?>#contact-us" class="btn btn-red btn-contact-ad"><?php echo $this->lang->line('contact_us'); ?></a>
            </div>
        </div>
    </div>
</div>
<!-- End Modal cannot create -->
<script>
    $('.bm-item-add').click(function() {
        <?php if (!empty($businessProfiles) && count($businessProfiles) > 0) { ?>
            $("#bmCannotCreateModal").modal('show');
        <?php }else{ ?>
            redirect(false, '<?php echo base_url('business-profile/select-plan'); ?>');
        <?php } ?>
    });
</script>