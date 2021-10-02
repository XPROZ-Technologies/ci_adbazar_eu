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
                        <div class="bp-gallery">
                            <ul class="nav nav-pills justify-content-center page-text-lg" id="pills-tab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="pills-photo-tab" data-bs-toggle="pill" data-bs-target="#pills-photo" type="button" role="tab" aria-controls="pills-photo" aria-selected="true">Photos</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="pills-video-tab" data-bs-toggle="pill" data-bs-target="#pills-video" type="button" role="tab" aria-controls="pills-video" aria-selected="false">Videos</button>
                                </li>
                            </ul>
                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="pills-photo" role="tabpanel" aria-labelledby="pills-photo-tab">
                                    <div class="tab-photo-wrap">
                                        <?php if (!empty($businessPhotos)) { ?>
                                            <div class="photo-list">
                                                <div class="row g-3">
                                                    <!-- photo item -->
                                                    <?php
                                                    foreach ($businessPhotos as $itemPhoto) { ?>
                                                        <div class="col-6 col-lg-3">
                                                            <div class="photo-item">
                                                                <a data-id="<?php echo $itemPhoto['id']; ?>" data-business="<?php echo $businessInfo['id']; ?>" class="d-block">
                                                                    <img src="<?php if (!empty($itemPhoto['photo_image'])) {
                                                                                    echo BUSINESS_PROFILE_PATH . $itemPhoto['photo_image'];
                                                                                } else {
                                                                                    echo BUSINESS_PROFILE_PATH . NO_IMAGE;
                                                                                } ?>" alt="<?php echo $businessInfo['business_name']; ?>" class="img-fluid">
                                                                </a>
                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                    <!-- END. photo item -->

                                                </div>

                                                <!-- Pagination
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
                                            END. Pagination -->

                                            </div>
                                        <?php } else { ?>
                                            <div class="gallery-zero zero-box">
                                                <img src="assets/img/frontend/img-empty-box.svg" alt="img-empty-box" class="img-fluid mx-auto d-block">
                                                <p class="text-secondary page-text-lg text-center"><php echo $businessInfo['business_name']; ?> not have any photo yet. </p>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="pills-video" role="tabpanel" aria-labelledby="pills-video-tab">
                                    <div class="tab-video-wrap">
                                        <?php if (!empty($businessVideos)) { ?>
                                            <div class="tab-video-list">
                                                <div class="row g-3">
                                                    <?php foreach ($businessVideos as $itemVideo) { ?>
                                                        <div class="col-6">
                                                            <div class="video-item">
                                                                <a class="icon-video js-play-video" data-id="<?php echo $itemVideo['id'] ?>" data-business="<?php echo $businessInfo['id']; ?>">
                                                                    <img src="assets/img/frontend/ic-play-video-white.png" alt="icon play" class="img-fluid">
                                                                </a>
                                                                <img src="https://img.youtube.com/vi/<?php echo $itemVideo['video_code'] ?>/hqdefault.jpg" alt="<?php echo $businessInfo['business_name']; ?>" class="img-fluid">
                                                            </div>
                                                        </div>
                                                    <?php } ?>

                                                </div>

                                                <!-- Pagination 
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
                                            END. Pagination -->

                                            </div>
                                        <?php } else { ?>
                                            <div class="gallery-zero zero-box">
                                                <img src="assets/img/frontend/img-empty-box.svg" alt="img-empty-box" class="img-fluid mx-auto d-block">
                                                <p class="text-secondary page-text-lg text-center"><php echo $businessInfo['business_name']; ?> does not have any video yet. </p>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?php $this->load->view('frontend/includes/footer'); ?>
<div class="posting">
    <div class="posting-box">
        <div class="close_posting"><button type="button" class="btn-close"></button></div>
        <div class="slider">
            <!-- photo item -->
            <?php if (!empty($businessPhotos)) {
                foreach ($businessPhotos as $itemPhoto) { ?>
                    <div class="photo-item">
                        <a class="d-block">
                            <img src="<?php if (!empty($itemPhoto['photo_image'])) {
                                            echo BUSINESS_PROFILE_PATH . $itemPhoto['photo_image'];
                                        } else {
                                            echo BUSINESS_PROFILE_PATH . NO_IMAGE;
                                        } ?>" alt="<?php echo $businessInfo['business_name']; ?>" class="img-fluid">
                        </a>
                        <span><?php echo $itemPhoto['photo_image']; ?></span>
                    </div>
            <?php }
            } ?>
            <!-- END. photo item -->
        </div>
        <div class="slider1">
            <!-- photo item -->
            <?php if (!empty($businessPhotos)) {
                foreach ($businessPhotos as $itemPhoto) { ?>
                    <div class="photo-item">
                        <a class="d-block">
                            <img src="<?php if (!empty($itemPhoto['photo_image'])) {
                                            echo BUSINESS_PROFILE_PATH . $itemPhoto['photo_image'];
                                        } else {
                                            echo BUSINESS_PROFILE_PATH . NO_IMAGE;
                                        } ?>" alt="<?php echo $businessInfo['business_name']; ?>" class="img-fluid">
                        </a>
                    </div>
            <?php }
            } ?>
            <!-- END. photo item -->
        </div>

        <div class="slider2">
            <?php if (!empty($businessVideos)) {
                foreach ($businessVideos as $itemVideo) { ?>
                    <div class="video-item" data-width="100%" data-height="auto" data-src="<?php echo $itemVideo['video_code'] ?>">
                        <div class="video-item-ct">
                            <a class="icon-video js-play-video">
                                <img src="assets/img/frontend/ic-play-video-white.png" alt="icon play" class="img-fluid">
                            </a>
                            <img src="https://img.youtube.com/vi/<?php echo $itemVideo['video_code'] ?>/hqdefault.jpg" alt="<?php echo $businessInfo['business_name']; ?>" class="img-video">
                        </div>
                        <a href="https://www.youtube.com/watch?v=<?php echo $itemVideo['video_code']; ?>">https://www.youtube.com/watch?v=<?php echo $itemVideo['video_code']; ?></a>
                    </div>
            <?php }
            } ?>

        </div>
        <div class="slider3">

            <?php if (!empty($businessVideos)) {
                foreach ($businessVideos as $itemVideo) { ?>
                    <div class="video-item">
                        <a class="icon-video js-play-video">
                            <img src="assets/img/frontend/ic-play-video-white.png" alt="icon play" class="img-fluid">
                        </a>
                        <img src="https://img.youtube.com/vi/<?php echo $itemVideo['video_code'] ?>/hqdefault.jpg" alt="<?php echo $businessInfo['business_name']; ?>" class="img-fluid">
                    </div>
            <?php }
            } ?>

        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        if ($('.posting').length > 0) {
            $('.slider').slick({
                infinite: true,
                slidesToShow: 1,
                slidesToScroll: 1,
                asNavFor: '.slider1',
                prevArrow: '<img src="./assets/img/frontend/left1.png" class="icon-left">',
                nextArrow: '<img src="./assets/img/frontend/right1.png" class="icon-right">',
            });
            $('.slider1').slick({
                infinite: true,
                slidesToShow: 5,
                slidesToScroll: 5,
                asNavFor: '.slider',
                centerMode: false,
                swipeToSlide: true,
                focusOnSelect: true,
                infinity: false,
                prevArrow: '<img src="./assets/img/frontend/left2.png" class="icon-left1">',
                nextArrow: '<img src="./assets/img/frontend/right2.png" class="icon-right1">',
                centerMode: true,
                centerPadding: '0px',
                responsive: [{
                    breakpoint: 576,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 3
                    }
                }]
            });
            $('.slider2').slick({
                infinite: true,
                slidesToShow: 1,
                slidesToScroll: 1,
                asNavFor: '.slider3',
                prevArrow: '<img src="./assets/img/frontend/left1.png" class="icon-left">',
                nextArrow: '<img src="./assets/img/frontend/right1.png" class="icon-right">',
            });
            $('.slider3').slick({
                infinite: true,
                slidesToShow: 3,
                slidesToScroll: 3,
                asNavFor: '.slider2',
                centerMode: false,
                swipeToSlide: true,
                focusOnSelect: true,
                infinity: false,
                prevArrow: '<img src="./assets/img/frontend/left2.png" class="icon-left1">',
                nextArrow: '<img src="./assets/img/frontend/right2.png" class="icon-right1">',
                centerMode: true,
                centerPadding: '0px',
            });

            $('.photo-list .row .col-6').click(function(event) {
                event.stopPropagation();
                $('.slider').show();
                $('.slider1').show();
                $('.slider2').hide();
                $('.slider3').hide();
                var id = $(this).find('a').attr('data-id');
                $("body").css("overflow", "hidden");
                $('.posting')
                    .toggle("slow", function() {
                        $('.slider').resize();
                    });
                $('.slider').slick("slickGoTo", id - 1);
            });
            $('.tab-video-list .row .col-6').click(function(event) {
                event.stopPropagation();
                $('.slider').hide();
                $('.slider1').hide();
                $('.slider2').show();
                $('.slider3').show();
                var id = $(this).find('a').attr('data-id');
                $("body").css("overflow", "hidden");
                $('.posting')
                    .toggle("slow", function() {
                        $('.slider2').resize();
                    });
                $('.slider2').slick("slickGoTo", id - 1);
            });
            $('.close_posting').click(function() {
                $("body").css("overflow", "auto");
                $('.posting').hide();
                $('.slider').resize();
                $('.slider2').resize();
            });
            $('.posting').click(function(event) {
                event.stopPropagation();
            });
        }

    });
</script>