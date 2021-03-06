<?php $this->load->view('frontend/includes/header'); ?>
<main class="main-customer">
    <div class="position-relative banner-about">
        <img src="<?php echo $about['img_banner']; ?>" alt="<?php echo $this->lang->line('about_us'); ?>">
        <div class="banner-about-box">
        <span><?php echo $this->lang->line('about_us'); ?></span>
        </div>
    </div>
    <div class="page-customer-service">
        <div class="customer-service-grid about-page">
            <div class="container">
                
                <div class="row col-mar-30 mb-40">
                    <div class="col-md-5  order-md-last <?php if(empty($about['child_img_1'])){ ?>d-none d-sm-block<?php } ?>">
                        <div class="c-img pt-66">
                            <?php if(!empty($about['child_img_1'])){ ?>
                                <img src="<?php echo $about['child_img_1']; ?>" alt="<?php echo $this->lang->line('about_us'); ?>">
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-md-7 order-md-first pt-30">
                        <p><?php echo nl2br($about['child_text_1']); ?></p>
                    </div>
                </div>
                <div class="row col-mar-30  mb-40">
                    <div class="col-md-5 <?php if(empty($about['child_img_2'])){ ?>d-none d-sm-block<?php } ?>">
                        <div class="c-img pt-66">
                            <?php if(!empty($about['child_img_2'])){ ?>
                                <img src="<?php echo $about['child_img_2']; ?>" alt="<?php echo $this->lang->line('about_us'); ?>">
                            <?php }  ?>
                        </div>
                    </div>
                    <div class="col-md-7 pt-10">
                        <p><?php echo nl2br($about['child_text_2']); ?></p>
                    </div>
                </div>
                <div class="row col-mar-30  mb-40 d-flex align-items-center">
                    <div class="col-md-12">
                        <p class="about-page-box"><?php echo $about['about_text_bottom']; ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?php $this->load->view('frontend/includes/footer'); ?>