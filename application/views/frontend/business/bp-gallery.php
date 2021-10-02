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
                                        <div class="photo-list">
                                            <div class="row g-3">
                                                <div class="col-6 col-lg-3">
                                                    <div class="photo-item">
                                                        <a data-id="1" class="d-block">
                                                            <img src="assets/img/frontend/photo1.png" alt="photo image" class="img-fluid">
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="col-6 col-lg-3">
                                                    <div class="photo-item">
                                                        <a data-id="2" class="d-block">
                                                            <img src="assets/img/frontend/photo2.png" alt="photo image" class="img-fluid">
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="col-6 col-lg-3">
                                                    <div class="photo-item">
                                                        <a data-id="3" class="d-block">
                                                            <img src="assets/img/frontend/photo3.png" alt="photo image" class="img-fluid">
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="col-6 col-lg-3">
                                                    <div class="photo-item">
                                                        <a data-id="4" class="d-block">
                                                            <img src="assets/img/frontend/photo4.png" alt="photo image" class="img-fluid">
                                                        </a>
                                                    </div>
                                                </div>


                                                <div class="col-6 col-lg-3">
                                                    <div class="photo-item">
                                                        <a data-id="5" class="d-block">
                                                            <img src="assets/img/frontend/photo5.png" alt="photo image" class="img-fluid">
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="col-6 col-lg-3">
                                                    <div class="photo-item">
                                                        <a data-id="6" class="d-block">
                                                            <img src="assets/img/frontend/photo6.png" alt="photo image" class="img-fluid">
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="col-6 col-lg-3">
                                                    <div class="photo-item">
                                                        <a data-id="7" class="d-block">
                                                            <img src="assets/img/frontend/photo7.png" alt="photo image" class="img-fluid">
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="col-6 col-lg-3">
                                                    <div class="photo-item">
                                                        <a data-id="8" class="d-block">
                                                            <img src="assets/img/frontend/photo8.png" alt="photo image" class="img-fluid">
                                                        </a>
                                                    </div>
                                                </div>


                                                <div class="col-6 col-lg-3">
                                                    <div class="photo-item">
                                                        <a data-id="9" class="d-block">
                                                            <img src="assets/img/frontend/photo1.png" alt="photo image" class="img-fluid">
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="col-6 col-lg-3">
                                                    <div class="photo-item">
                                                        <a data-id="10" class="d-block">
                                                            <img src="assets/img/frontend/photo2.png" alt="photo image" class="img-fluid">
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="col-6 col-lg-3">
                                                    <div class="photo-item">
                                                        <a data-id="11" class="d-block">
                                                            <img src="assets/img/frontend/photo3.png" alt="photo image" class="img-fluid">
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="col-6 col-lg-3">
                                                    <div class="photo-item">
                                                        <a data-id="12" class="d-block">
                                                            <img src="assets/img/frontend/photo4.png" alt="photo image" class="img-fluid">
                                                        </a>
                                                    </div>
                                                </div>


                                                <div class="col-6 col-lg-3">
                                                    <div class="photo-item">
                                                        <a data-id="13" class="d-block">
                                                            <img src="assets/img/frontend/photo5.png" alt="photo image" class="img-fluid">
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="col-6 col-lg-3">
                                                    <div class="photo-item">
                                                        <a data-id="14" class="d-block">
                                                            <img src="assets/img/frontend/photo6.png" alt="photo image" class="img-fluid">
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="col-6 col-lg-3">
                                                    <div class="photo-item">
                                                        <a data-id="15" class="d-block">
                                                            <img src="assets/img/frontend/photo7.png" alt="photo image" class="img-fluid">
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="col-6 col-lg-3">
                                                    <div class="photo-item">
                                                        <a data-id="16" class="d-block">
                                                            <img src="assets/img/frontend/photo8.png" alt="photo image" class="img-fluid">
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="col-6 col-lg-3">
                                                    <div class="photo-item">
                                                        <a data-id="17" class="d-block">
                                                            <img src="assets/img/frontend/photo1.png" alt="photo image" class="img-fluid">
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="col-6 col-lg-3">
                                                    <div class="photo-item">
                                                        <a data-id="18" class="d-block">
                                                            <img src="assets/img/frontend/photo2.png" alt="photo image" class="img-fluid">
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="col-6 col-lg-3">
                                                    <div class="photo-item">
                                                        <a data-id="19" class="d-block">
                                                            <img src="assets/img/frontend/photo3.png" alt="photo image" class="img-fluid">
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="col-6 col-lg-3">
                                                    <div class="photo-item">
                                                        <a data-id="20" class="d-block">
                                                            <img src="assets/img/frontend/photo4.png" alt="photo image" class="img-fluid">
                                                        </a>
                                                    </div>
                                                </div>



                                            </div>

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
                                                    <!-- Page pagination -->
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
                                                    <!-- End Page pagination -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="pills-video" role="tabpanel" aria-labelledby="pills-video-tab">
                                    <div class="tab-video-wrap">
                                        <div class="tab-video-list">
                                            <div class="row g-3">
                                                <div class="col-6">
                                                    <div class="video-item">
                                                        <a class="icon-video js-play-video" data-id="1">
                                                            <img src="assets/img/frontend/ic-play-video-white.png" alt="icon play" class="img-fluid">
                                                        </a>
                                                        <img src="assets/img/frontend/poster-video1.png" alt="icon play" class="img-fluid">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="video-item">
                                                        <a class="icon-video js-play-video" data-id="2">
                                                            <img src="assets/img/frontend/ic-play-video-white.png" alt="icon play" class="img-fluid">
                                                        </a>
                                                        <img src="assets/img/frontend/poster-video2.png" alt="icon play" class="img-fluid">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="video-item">
                                                        <a class="icon-video js-play-video" data-id="3">
                                                            <img src="assets/img/frontend/ic-play-video-white.png" alt="icon play" class="img-fluid">
                                                        </a>
                                                        <img src="assets/img/frontend/poster-video3.png" alt="icon play" class="img-fluid">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="video-item">
                                                        <a class="icon-video js-play-video" data-id="4">
                                                            <img src="assets/img/frontend/ic-play-video-white.png" alt="icon play" class="img-fluid">
                                                        </a>
                                                        <img src="assets/img/frontend/poster-video4.png" alt="icon play" class="img-fluid">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="video-item">
                                                        <a class="icon-video js-play-video" data-id="5">
                                                            <img src="assets/img/frontend/ic-play-video-white.png" alt="icon play" class="img-fluid">
                                                        </a>
                                                        <img src="assets/img/frontend/poster-video5.png" alt="icon play" class="img-fluid">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="video-item">
                                                        <a class="icon-video js-play-video" data-id="6">
                                                            <img src="assets/img/frontend/ic-play-video-white.png" alt="icon play" class="img-fluid">
                                                        </a>
                                                        <img src="assets/img/frontend/poster-video6.png" alt="icon play" class="img-fluid">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="video-item">
                                                        <a class="icon-video js-play-video" data-id="7">
                                                            <img src="assets/img/frontend/ic-play-video-white.png" alt="icon play" class="img-fluid">
                                                        </a>
                                                        <img src="assets/img/frontend/poster-video7.png" alt="icon play" class="img-fluid">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="video-item">
                                                        <a class="icon-video js-play-video" data-id="8">
                                                            <img src="assets/img/frontend/ic-play-video-white.png" alt="icon play" class="img-fluid">
                                                        </a>
                                                        <img src="assets/img/frontend/poster-video8.png" alt="icon play" class="img-fluid">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="video-item">
                                                        <a class="icon-video js-play-video" data-id="9">
                                                            <img src="assets/img/frontend/ic-play-video-white.png" alt="icon play" class="img-fluid">
                                                        </a>
                                                        <img src="assets/img/frontend/poster-video9.png" alt="icon play" class="img-fluid">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="video-item">
                                                        <a class="icon-video js-play-video" data-id="10">
                                                            <img src="assets/img/frontend/ic-play-video-white.png" alt="icon play" class="img-fluid">
                                                        </a>
                                                        <img src="assets/img/frontend/poster-video10.png" alt="icon play" class="img-fluid">
                                                    </div>
                                                </div>
                                            </div>

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
                                                    <!-- Page pagination -->
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
                                                    <!-- End Page pagination -->
                                                </div>
                                            </div>
                                        </div>
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
<div class="posting">
    <div class="posting-box">
        <div class="close_posting"><button type="button" class="btn-close"></button></div>
        <div class="slider">
            <div class="photo-item">
                <a class="d-block">
                    <img src="assets/img/frontend/photo1.png" alt="photo image" class="img-fluid">
                </a>
                <span>62fff943d7e386c33823.png</span>
            </div>
            <div class="photo-item">
                <a class="d-block">
                    <img src="assets/img/frontend/photo2.png" alt="photo image" class="img-fluid">
                </a>
                <span>62fff943d7e386c33823.png</span>
            </div>
            <div class="photo-item">
                <a class="d-block">
                    <img src="assets/img/frontend/photo3.png" alt="photo image" class="img-fluid">
                </a>
                <span>62fff943d7e386c33823.png</span>
            </div>
            <div class="photo-item">
                <a class="d-block">
                    <img src="assets/img/frontend/photo4.png" alt="photo image" class="img-fluid">
                </a>
                <span>62fff943d7e386c33823.png</span>
            </div>
            <div class="photo-item">
                <a class="d-block">
                    <img src="assets/img/frontend/photo5.png" alt="photo image" class="img-fluid">
                </a>
                <span>62fff943d7e386c33823.png</span>
            </div>
            <div class="photo-item">
                <a class="d-block">
                    <img src="assets/img/frontend/photo6.png" alt="photo image" class="img-fluid">
                </a>
                <span>62fff943d7e386c33823.png</span>
            </div>
            <div class="photo-item">
                <a class="d-block">
                    <img src="assets/img/frontend/photo7.png" alt="photo image" class="img-fluid">
                </a>
                <span>62fff943d7e386c33823.png</span>
            </div>
            <div class="photo-item">
                <a class="d-block">
                    <img src="assets/img/frontend/photo8.png" alt="photo image" class="img-fluid">
                </a>
                <span>62fff943d7e386c33823.png</span>
            </div>
            <div class="photo-item">
                <a class="d-block">
                    <img src="assets/img/frontend/photo1.png" alt="photo image" class="img-fluid">
                </a>
                <span>62fff943d7e386c33823.png</span>
            </div>
            <div class="photo-item">
                <a class="d-block">
                    <img src="assets/img/frontend/photo2.png" alt="photo image" class="img-fluid">
                </a>
                <span>62fff943d7e386c33823.png</span>
            </div>
            <div class="photo-item">
                <a class="d-block">
                    <img src="assets/img/frontend/photo3.png" alt="photo image" class="img-fluid">
                </a>
                <span>62fff943d7e386c33823.png</span>
            </div>
            <div class="photo-item">
                <a class="d-block">
                    <img src="assets/img/frontend/photo4.png" alt="photo image" class="img-fluid">
                </a>
                <span>62fff943d7e386c33823.png</span>
            </div>
            <div class="photo-item">
                <a class="d-block">
                    <img src="assets/img/frontend/photo5.png" alt="photo image" class="img-fluid">
                </a>
                <span>62fff943d7e386c33823.png</span>
            </div>
            <div class="photo-item">
                <a class="d-block">
                    <img src="assets/img/frontend/photo6.png" alt="photo image" class="img-fluid">
                </a>
                <span>62fff943d7e386c33823.png</span>
            </div>
            <div class="photo-item">
                <a class="d-block">
                    <img src="assets/img/frontend/photo7.png" alt="photo image" class="img-fluid">
                </a>
                <span>62fff943d7e386c33823.png</span>
            </div>
            <div class="photo-item">
                <a class="d-block">
                    <img src="assets/img/frontend/photo8.png" alt="photo image" class="img-fluid">
                </a>
                <span>62fff943d7e386c33823.png</span>
            </div>
            <div class="photo-item">
                <a class="d-block">
                    <img src="assets/img/frontend/photo1.png" alt="photo image" class="img-fluid">
                </a>
                <span>62fff943d7e386c33823.png</span>
            </div>
            <div class="photo-item">
                <a class="d-block">
                    <img src="assets/img/frontend/photo2.png" alt="photo image" class="img-fluid">
                </a>
                <span>62fff943d7e386c33823.png</span>
            </div>
            <div class="photo-item">
                <a class="d-block">
                    <img src="assets/img/frontend/photo3.png" alt="photo image" class="img-fluid">
                </a>
                <span>62fff943d7e386c33823.png</span>
            </div>
            <div class="photo-item">
                <a class="d-block">
                    <img src="assets/img/frontend/photo4.png" alt="photo image" class="img-fluid">
                </a>
                <span>62fff943d7e386c33823.png</span>
            </div>
        </div>
        <div class="slider1">
            <div class="photo-item">
                <a class="d-block">
                    <img src="assets/img/frontend/photo1.png" alt="photo image" class="img-fluid">
                </a>
            </div>
            <div class="photo-item">
                <a class="d-block">
                    <img src="assets/img/frontend/photo2.png" alt="photo image" class="img-fluid">
                </a>
            </div>
            <div class="photo-item">
                <a class="d-block">
                    <img src="assets/img/frontend/photo3.png" alt="photo image" class="img-fluid">
                </a>
            </div>
            <div class="photo-item">
                <a class="d-block">
                    <img src="assets/img/frontend/photo4.png" alt="photo image" class="img-fluid">
                </a>
            </div>
            <div class="photo-item">
                <a class="d-block">
                    <img src="assets/img/frontend/photo5.png" alt="photo image" class="img-fluid">
                </a>
            </div>
            <div class="photo-item">
                <a class="d-block">
                    <img src="assets/img/frontend/photo6.png" alt="photo image" class="img-fluid">
                </a>
            </div>
            <div class="photo-item">
                <a class="d-block">
                    <img src="assets/img/frontend/photo7.png" alt="photo image" class="img-fluid">
                </a>
            </div>
            <div class="photo-item">
                <a class="d-block">
                    <img src="assets/img/frontend/photo8.png" alt="photo image" class="img-fluid">
                </a>
            </div>
            <div class="photo-item">
                <a class="d-block">
                    <img src="assets/img/frontend/photo1.png" alt="photo image" class="img-fluid">
                </a>
            </div>
            <div class="photo-item">
                <a class="d-block">
                    <img src="assets/img/frontend/photo2.png" alt="photo image" class="img-fluid">
                </a>
            </div>
            <div class="photo-item">
                <a class="d-block">
                    <img src="assets/img/frontend/photo3.png" alt="photo image" class="img-fluid">
                </a>
            </div>
            <div class="photo-item">
                <a class="d-block">
                    <img src="assets/img/frontend/photo4.png" alt="photo image" class="img-fluid">
                </a>
            </div>
            <div class="photo-item">
                <a class="d-block">
                    <img src="assets/img/frontend/photo5.png" alt="photo image" class="img-fluid">
                </a>
            </div>
            <div class="photo-item">
                <a class="d-block">
                    <img src="assets/img/frontend/photo6.png" alt="photo image" class="img-fluid">
                </a>
            </div>
            <div class="photo-item">
                <a class="d-block">
                    <img src="assets/img/frontend/photo7.png" alt="photo image" class="img-fluid">
                </a>
            </div>
            <div class="photo-item">
                <a class="d-block">
                    <img src="assets/img/frontend/photo8.png" alt="photo image" class="img-fluid">
                </a>
            </div>
            <div class="photo-item">
                <a class="d-block">
                    <img src="assets/img/frontend/photo1.png" alt="photo image" class="img-fluid">
                </a>
            </div>
            <div class="photo-item">
                <a class="d-block">
                    <img src="assets/img/frontend/photo2.png" alt="photo image" class="img-fluid">
                </a>
            </div>
            <div class="photo-item">
                <a class="d-block">
                    <img src="assets/img/frontend/photo3.png" alt="photo image" class="img-fluid">
                </a>
            </div>
            <div class="photo-item">
                <a class="d-block">
                    <img src="assets/img/frontend/photo4.png" alt="photo image" class="img-fluid">
                </a>
            </div>
        </div>
        <div class="slider2">
            <div class="video-item" data-width="100%" data-height="auto" data-src="Hv6EMd8dlQk">
                <div class="video-item-ct">
                    <a class="icon-video js-play-video">
                        <img src="assets/img/frontend/ic-play-video-white.png" alt="icon play" class="img-fluid">
                    </a>
                    <img src="assets/img/frontend/poster-video1.png" class="img-video">
                </div>
                <a href="">https://www.youtube.com/watch?v=Hv6EMd8dlQk</a>
            </div>
            <div class="video-item" data-width="100%" data-height="auto" data-src="cClgQ9kGfAQ">
                <div class="video-item-ct">
                    <a class="icon-video js-play-video">
                        <img src="assets/img/frontend/ic-play-video-white.png" alt="icon play" class="img-fluid">
                    </a>
                    <img src="assets/img/frontend/poster-video2.png" class="img-video">
                </div>
                <a href="">https://www.youtube.com/watch?v=Hv6EMd8dlQk</a>
            </div>
            <div class="video-item" data-width="100%" data-height="auto" data-src="cClgQ9kGfAQ">
                <div class="video-item-ct">
                    <a class="icon-video js-play-video">
                        <img src="assets/img/frontend/ic-play-video-white.png" alt="icon play" class="img-fluid">
                    </a>
                    <img src="assets/img/frontend/poster-video3.png" class="img-video">
                </div>
                <a href="">https://www.youtube.com/watch?v=Hv6EMd8dlQk</a>
            </div>
            <div class="video-item" data-width="100%" data-height="auto" data-src="cClgQ9kGfAQ">
                <div class="video-item-ct">
                    <a class="icon-video js-play-video">
                        <img src="assets/img/frontend/ic-play-video-white.png" alt="icon play" class="img-fluid">
                    </a>
                    <img src="assets/img/frontend/poster-video4.png" class="img-video">
                </div>
                <a href="">https://www.youtube.com/watch?v=Hv6EMd8dlQk</a>
            </div>
            <div class="video-item" data-width="100%" data-height="auto" data-src="cClgQ9kGfAQ">
                <div class="video-item-ct">
                    <a class="icon-video js-play-video">
                        <img src="assets/img/frontend/ic-play-video-white.png" alt="icon play" class="img-fluid">
                    </a>
                    <img src="assets/img/frontend/poster-video5.png" class="img-video">
                </div>
                <a href="">https://www.youtube.com/watch?v=Hv6EMd8dlQk</a>
            </div>
            <div class="video-item" data-width="100%" data-height="auto" data-src="cClgQ9kGfAQ">
                <div class="video-item-ct">
                    <a class="icon-video js-play-video">
                        <img src="assets/img/frontend/ic-play-video-white.png" alt="icon play" class="img-fluid">
                    </a>
                    <img src="assets/img/frontend/poster-video6.png" class="img-video">
                </div>
                <a href="">https://www.youtube.com/watch?v=Hv6EMd8dlQk</a>
            </div>
            <div class="video-item" data-width="100%" data-height="auto" data-src="cClgQ9kGfAQ">
                <div class="video-item-ct">
                    <a class="icon-video js-play-video">
                        <img src="assets/img/frontend/ic-play-video-white.png" alt="icon play" class="img-fluid">
                    </a>
                    <img src="assets/img/frontend/poster-video7.png" class="img-video">
                </div>
                <a href="">https://www.youtube.com/watch?v=Hv6EMd8dlQk</a>
            </div>
            <div class="video-item" data-width="100%" data-height="auto" data-src="cClgQ9kGfAQ">
                <div class="video-item-ct">
                    <a class="icon-video js-play-video">
                        <img src="assets/img/frontend/ic-play-video-white.png" alt="icon play" class="img-fluid">
                    </a>
                    <img src="assets/img/frontend/poster-video8.png" class="img-video">
                </div>
                <a href="">https://www.youtube.com/watch?v=Hv6EMd8dlQk</a>
            </div>
            <div class="video-item" data-width="100%" data-height="auto" data-src="cClgQ9kGfAQ">
                <div class="video-item-ct">
                    <a class="icon-video js-play-video">
                        <img src="assets/img/frontend/ic-play-video-white.png" alt="icon play" class="img-fluid">
                    </a>
                    <img src="assets/img/frontend/poster-video9.png" class="img-video">
                </div>
                <a href="">https://www.youtube.com/watch?v=Hv6EMd8dlQk</a>
            </div>
            <div class="video-item" data-width="100%" data-height="auto" data-src="cClgQ9kGfAQ">
                <div class="video-item-ct">
                    <a class="icon-video js-play-video">
                        <img src="assets/img/frontend/ic-play-video-white.png" alt="icon play" class="img-fluid">
                    </a>
                    <img src="assets/img/frontend/poster-video10.png" class="img-video">
                </div>
                <a href="">https://www.youtube.com/watch?v=Hv6EMd8dlQk</a>
            </div>
        </div>
        <div class="slider3">
            <div class="video-item">
                <a class="icon-video js-play-video">
                    <img src="assets/img/frontend/ic-play-video-white.png" alt="icon play" class="img-fluid">
                </a>
                <img src="assets/img/frontend/poster-video1.png" alt="icon play" class="img-fluid">
            </div>
            <div class="video-item">
                <a class="icon-video js-play-video">
                    <img src="assets/img/frontend/ic-play-video-white.png" alt="icon play" class="img-fluid">
                </a>
                <img src="assets/img/frontend/poster-video2.png" alt="icon play" class="img-fluid">
            </div>
            <div class="video-item">
                <a class="icon-video js-play-video">
                    <img src="assets/img/frontend/ic-play-video-white.png" alt="icon play" class="img-fluid">
                </a>
                <img src="assets/img/frontend/poster-video3.png" alt="icon play" class="img-fluid">
            </div>
            <div class="video-item">
                <a class="icon-video js-play-video">
                    <img src="assets/img/frontend/ic-play-video-white.png" alt="icon play" class="img-fluid">
                </a>
                <img src="assets/img/frontend/poster-video4.png" alt="icon play" class="img-fluid">
            </div>
            <div class="video-item">
                <a class="icon-video js-play-video">
                    <img src="assets/img/frontend/ic-play-video-white.png" alt="icon play" class="img-fluid">
                </a>
                <img src="assets/img/frontend/poster-video5.png" alt="icon play" class="img-fluid">
            </div>
            <div class="video-item">
                <a class="icon-video js-play-video">
                    <img src="assets/img/frontend/ic-play-video-white.png" alt="icon play" class="img-fluid">
                </a>
                <img src="assets/img/frontend/poster-video6.png" alt="icon play" class="img-fluid">
            </div>
            <div class="video-item">
                <a class="icon-video js-play-video">
                    <img src="assets/img/frontend/ic-play-video-white.png" alt="icon play" class="img-fluid">
                </a>
                <img src="assets/img/frontend/poster-video7.png" alt="icon play" class="img-fluid">
            </div>
            <div class="video-item">
                <a class="icon-video js-play-video">
                    <img src="assets/img/frontend/ic-play-video-white.png" alt="icon play" class="img-fluid">
                </a>
                <img src="assets/img/frontend/poster-video8.png" alt="icon play" class="img-fluid">
            </div>
            <div class="video-item">
                <a class="icon-video js-play-video">
                    <img src="assets/img/frontend/ic-play-video-white.png" alt="icon play" class="img-fluid">
                </a>
                <img src="assets/img/frontend/poster-video9.png" alt="icon play" class="img-fluid">
            </div>
            <div class="video-item">
                <a class="icon-video js-play-video">
                    <img src="assets/img/frontend/ic-play-video-white.png" alt="icon play" class="img-fluid">
                </a>
                <img src="assets/img/frontend/poster-video10.png" alt="icon play" class="img-fluid">
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('frontend/includes/footer'); ?>