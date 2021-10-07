<?php $this->load->view('frontend/includes/header'); ?>
<main>
    <div class="page-business-manager">
        <div class="bm-content">
            <div class="container">
                <?php $this->load->view('frontend/includes/bm_header'); ?>

                <div class="row">
                    <div class="col-lg-3">
                        <?php $this->load->view('frontend/includes/business_manage_nav_sidebar'); ?>
                    </div>
                    <div class="col-lg-9">
                        <div class="bm-gallery">
                            <div class="d-flex justify-content-end add-gallery">
                                <button class="btn btn-red" data-bs-toggle="modal" data-bs-target="#addGalleryModal"><img src="assets/img/frontend/ic-upload.png" alt="ic-upload"> Add photos/videos</button>
                            </div>
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
                                                        <?php foreach ($businessPhotos as $itemPhoto) { ?>
                                                            <div class="col-6 col-lg-3">
                                                                <div class="photo-item">
                                                                    <a href="javascript:void(0)" class="d-block c-img">
                                                                        <img src="<?php if (!empty($itemPhoto['photo_image'])) {
                                                                                        echo BUSINESS_PROFILE_PATH . $itemPhoto['photo_image'];
                                                                                    } else {
                                                                                        echo BUSINESS_PROFILE_PATH . NO_IMAGE;
                                                                                    } ?>" alt="<?php echo $businessInfo['business_name']; ?>" alt="photo image" class="img-fluid">
                                                                    </a>
                                                                    <a href="javascript:void(0)" class="photo-icon js-dropdown-gallery">
                                                                        <img src="assets/img/frontend/ic-edit-gallery.png" alt="ic-edit-gallery">
                                                                    </a>
                                                                    <ul class="dropdown-menu dropdown-gallery">
                                                                        <li><a class="dropdown-item" href="javascript:void(0)"><img src="assets/img/frontend/ic-gallery-user.svg" alt="ic-gallery-user">Use as profile
                                                                                photo</a></li>
                                                                        <li><a class="dropdown-item" href="javascript:void(0)"><img src="assets/img/frontend/ic-gallery-cover.svg" alt="ic-gallery-user">Use as cover
                                                                                photo</a></li>
                                                                        <li><a class="dropdown-item" href="javascript:void(0)"><img src="assets/img/frontend/ic-gallery-download.svg" alt="ic-gallery-user">Download</a></li>
                                                                        <li><a class="dropdown-item" data-bs-toggle="modal" href="#deletePhotoModal"><img src="assets/img/frontend/ic-gallery-trash.svg" alt="ic-gallery-user">Delete</a>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        <?php } ?>
                                                        <!-- END. photo item -->

                                                    </div>
                                                    <!--
                                                    <div class="d-flex align-items-center flex-column flex-md-row justify-content-between page-pagination">
                                                        <div class="d-flex align-items-center pagination-left">
                                                            <p class="page-text-sm mb-0 me-3">Showing <span class="fw-500">1 – 10</span> of <span class="fw-500">50</span>
                                                                results</p>
                                                            <div class="page-text-sm mb-0 d-flex align-items-center">
                                                                <div class="custom-select choose-perpage">
                                                                <select>
                                                                    <option value="10" selected>10</option>
                                                                    <option value="20" >20</option>
                                                                    <option value="30" >30</option>
                                                                    <option value="40" >40</option>
                                                                    <option value="50" >50</option>
                                                                </select>
                                                                </div>
                                                                <span class="ms-2">/</span>
                                                                <span class=""> Page</span>
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
                                                    -->
                                                </div>

                                            <?php } else { ?>
                                                <div class="gallery-zero zero-box">
                                                    <img src="assets/img/frontend/img-empty-box.svg" alt="img-empty-box" class="img-fluid mx-auto d-block">
                                                    <p class="text-secondary page-text-lg text-center">
                                                        <php echo $businessInfo['business_name']; ?> not have any photo yet.
                                                    </p>
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
                                                            <div class="col-lg-6">
                                                                <div class="video-item">
                                                                    <a class="icon-video js-play-video" data-id="<?php echo $itemVideo['id'] ?>" data-business="<?php echo $businessInfo['id']; ?>">
                                                                        <img src="assets/img/frontend/ic-play-video-white.png" alt="icon play" class="img-fluid">
                                                                    </a>
                                                                    <img src="https://img.youtube.com/vi/<?php echo $itemVideo['video_code'] ?>/hqdefault.jpg" alt="<?php echo $businessInfo['business_name']; ?>" class="img-fluid">
                                                                    <a href="#deleteVideoModal" data-bs-toggle="modal" class="icon-delete">
                                                                        <img src="assets/img/frontend/ic-trash-white.png" alt="icon delete" class="img-fluid">
                                                                    </a>
                                                                </div>
                                                                
                                                            </div>
                                                        <?php } ?>

                                                    </div>
                                                    <!--
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
                                                     -->
                                                </div>
                                            <?php } else { ?>
                                                <div class="gallery-zero zero-box">
                                                    <img src="assets/img/frontend/img-empty-box.svg" alt="img-empty-box" class="img-fluid mx-auto d-block">
                                                    <p class="text-secondary page-text-lg text-center">
                                                        <php echo $businessInfo['business_name']; ?> does not have any video yet.
                                                    </p>
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
    </div>
</main>
<?php $this->load->view('frontend/includes/footer'); ?>

<div class="uploading">
    <div class="uploading-head">
        <p class="mb-0">Uploading (<span></span>) files</p>
        <a href="javascript:void(0)" class="hide-loading">
            <img src="assets/img/frontend/ic_ remove_upload.png" alt="icon delete" class="img-fluid">
        </a>
    </div>
    <div class="uploading-body">
        <table class="m-0 w-100">

        </table>
    </div>
</div>
<!-- Modal Upload Photo/Video -->
<div class="modal fade bmGalleryModal" id="addGalleryModal" tabindex="-1" aria-labelledby="addGalleryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-bottom-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul class="nav nav-pills justify-content-center" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Upload Photos</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Upload Videos</button>
                    </li>
                </ul>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                        <!-- <form action="#"> -->
                        <div id="image_preview"></div>
                        <div class="upload-more">
                            <div class="text-right">
                                <div class="position-relative">
                                    <div class="drop-zone__prompt">
                                        <img src="assets/img/frontend/ic-cloud.png" alt="ic-cloud image" class="img-fluid">
                                        <p class="mb-2 text-black fw-500">Drop files to upload or
                                            <span>browse</span>
                                        </p>
                                        <span class="d-block page-text-xs text-black">Supports JPEG, PNG,
                                            GIF</span>
                                    </div>
                                    <div class="add-more-img text-center mt-3">
                                        <p><img src="assets/img/frontend/iconimg.png" alt=""> + Add more photos</p>
                                    </div>
                                    <input type="file" id="files" name="files[]" multiple />
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-center border-0 p-0 upload-more-img">
                            <button type="submit" class="btn btn-red">
                                <img src="assets/img/frontend/ic-upload.png" alt="ic-upload">
                                Upload</button>
                        </div>
                        <!-- </form> -->
                    </div>
                    <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                        <form action="#" id="list-url">
                            <div class="form-group">
                                <label for="" class="form-label">Video URL</label>
                                <input type="url" class="form-control form-control-lg mb-3">
                            </div>
                            <!--
                            <div class="form-group has-validation">
                                <label for="" class="form-label">Video URL</label>
                                <input type="url" class="form-control form-control-lg mb-3 is-invalid">
                                <div class="invalid-feedback">This video URL already existed, please choose
                                    another one.</div>
                            </div>
                            -->
                            <div class="text-center">
                                <a href="#" class="text-underline add-more fw-500">+ Add more </a>
                            </div>
                            <div class="modal-footer justify-content-center border-0 p-0">
                                <button type="submit" class="btn btn-red">
                                    <img src="assets/img/frontend/ic-upload.png" alt="ic-upload">
                                    Upload</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<!-- End Modal Upload Photo/Video -->

<!-- Modal Delete Video -->
<div class="modal fade bmDeleteModal" id="deleteVideoModal" tabindex="-1" aria-labelledby="deleteVideoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-bottom-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="mb-0 text-center page-text-lg">
                    Are you sure that you want to delete the video
                    <b class="d-block fw-500">https://www.youtube.com/watch?v=semp2yGKmsk</b>
                </p>
                <div class="video-item">
                    <a href="#" class="icon-video js-play-video">
                        <img src="assets/img/frontend/ic-play-video-white.png" alt="icon play" class="img-fluid">
                    </a>
                    <video poster="assets/img/frontend/poster-video2.png" class="js-video">
                        <source src="assets/img/frontend/demo.mp4" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                </div>

                <div class="modal-footer justify-content-center border-0 p-0">
                    <button type="button" class="btn btn-red">Yes</button>
                    <button type="button" class="btn btn-outline-red" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Modal Delete Video -->

<!-- Modal Delete Photo -->
<div class="modal fade bmDeleteModal" id="deletePhotoModal" tabindex="-1" aria-labelledby="deletePhotoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-bottom-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="mb-0 text-center page-text-lg">
                    Are you sure that you want to delete the photo
                    <b class="d-block fw-500">62fff943d7e386c33823.png</b>
                </p>

                <div class="photo-item">
                    <a href="#" class="d-block">
                        <img src="assets/img/frontend/photo1.png" alt="photo image" class="img-fluid">
                    </a>
                </div>

                <div class="modal-footer justify-content-center border-0 p-0">
                    <button type="button" class="btn btn-red">Yes</button>
                    <button type="button" class="btn btn-outline-red" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Modal Delete Photo -->