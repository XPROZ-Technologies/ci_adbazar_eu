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
                                <button class="btn btn-red" data-bs-toggle="modal" data-bs-target="#addGalleryModal"><img src="assets/img/frontend/ic-upload.png" alt="ic-upload"><?php echo $this->lang->line('add_photos_videos'); ?></button>
                            </div>
                            <div class="bp-gallery">
                                <ul class="nav nav-pills justify-content-center page-text-lg" id="pills-tab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link <?php if(!isset($_GET['tab']) || isset($_GET['tab']) && $_GET['tab'] != 'video'){ echo 'active'; } ?>" id="pills-photo-tab" data-bs-toggle="pill" data-bs-target="#pills-photo" type="button" role="tab" aria-controls="pills-photo" aria-selected="true"><?php echo $this->lang->line('photos'); ?></button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link <?php if(isset($_GET['tab']) && $_GET['tab'] == 'video'){ echo 'active'; } ?>" id="pills-video-tab" data-bs-toggle="pill" data-bs-target="#pills-video" type="button" role="tab" aria-controls="pills-video" aria-selected="false"><?php echo $this->lang->line('videos'); ?></button>
                                    </li>
                                </ul>
                                <div class="tab-content" id="pills-tabContent">
                                    <div class="tab-pane fade <?php if(!isset($_GET['tab']) || isset($_GET['tab']) && $_GET['tab'] != 'video'){ echo 'show active'; } ?>" id="pills-photo" role="tabpanel" aria-labelledby="pills-photo-tab">
                                        <div class="tab-photo-wrap">
                                            <?php if (!empty($businessPhotos)) { ?>
                                                <div class="photo-list">
                                                    <div class="row g-3">
                                                        <!-- photo item -->
                                                        <?php foreach ($businessPhotos as $itemPhoto) { ?>
                                                            <div class="col-6 col-lg-3">
                                                                <div class="photo-item">
                                                                    <a href="javascript:void(0)" class="d-block c-img">
                                                                        <?php
                                                                            $imgName = "";
                                                                            if (!empty($itemPhoto['photo_image'])) {
                                                                                $imgItemUrl = BUSINESS_PROFILE_PATH . $itemPhoto['photo_image'];
                                                                                $imgName = $itemPhoto['photo_image'];
                                                                            } else {
                                                                                $imgItemUrl = BUSINESS_PROFILE_PATH . NO_IMAGE;
                                                                            }
                                                                        ?>
                                                                        <img src="<?php echo $imgItemUrl; ?>" alt="<?php echo $businessInfo['business_name']; ?>" alt="photo image" class="img-fluid">
                                                                    </a>
                                                                    <a href="javascript:void(0)" class="photo-icon js-dropdown-gallery">
                                                                        <img src="assets/img/frontend/ic-edit-gallery.png" alt="ic-edit-gallery">
                                                                    </a>
                                                                    <ul class="dropdown-menu dropdown-gallery">
                                                                        <li><a class="dropdown-item" href="javascript:void(0)"><img src="assets/img/frontend/ic-gallery-user.svg" alt="ic-gallery-user"><?php echo $this->lang->line('use_as_profile_photo'); ?></a></li>
                                                                        <li><a class="dropdown-item" href="javascript:void(0)"><img src="assets/img/frontend/ic-gallery-cover.svg" alt="ic-gallery-user"><?php echo $this->lang->line('use_as_cover_photo'); ?></a></li>
                                                                        <li><a class="dropdown-item" href="javascript:void(0)"><img src="assets/img/frontend/ic-gallery-download.svg" alt="ic-gallery-user"><?php echo $this->lang->line('download'); ?></a></li>
                                                                        <li><a class="dropdown-item js-delete-image" data-bs-toggle="modal" href="javascript:void(0)" data-id="<?php echo $itemPhoto['id']; ?>" data-name="<?php echo $imgName; ?>" data-img="<?php echo $imgItemUrl; ?>"><img src="assets/img/frontend/ic-gallery-trash.svg" alt="ic-gallery-user"><?php echo $this->lang->line('delete'); ?></a></li>
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
                                                        <?php echo $businessInfo['business_name']; ?> not have any photo yet.
                                                    </p>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade <?php if(isset($_GET['tab']) && $_GET['tab'] == 'video'){ echo 'show active'; } ?>" id="pills-video" role="tabpanel" aria-labelledby="pills-video-tab">
                                        <div class="tab-video-wrap">
                                            <?php if (!empty($businessVideos)) { ?>
                                                <div class="tab-video-list">
                                                    <div class="row g-3">
                                                        <?php foreach ($businessVideos as $itemVideo) { ?>
                                                            <div class="col-lg-6">
                                                                <div class="video-item">
                                                                    <a class="icon-video js-play-video">
                                                                        <img src="assets/img/frontend/ic-play-video-white.png" alt="icon play" class="img-fluid">
                                                                    </a>
                                                                    <img src="https://img.youtube.com/vi/<?php echo $itemVideo['video_code'] ?>/hqdefault.jpg" alt="<?php echo $businessInfo['business_name']; ?>" class="img-fluid">
                                                                    <a href="javascript:void(0)" data-bs-toggle="modal" class="icon-delete js-delete-video" data-id="<?php echo $itemVideo['id'] ?>" data-url="<?php echo $itemVideo['video_url'] ?>" data-img="https://img.youtube.com/vi/<?php echo $itemVideo['video_code'] ?>/hqdefault.jpg">
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
                                                        <?php echo $businessInfo["business_name"]; ?> does not have any video yet.
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
        <?php 
            $uploading_3_files =  $this->lang->line('uploading_3_files'); 
            $expuploading_3_files = explode("<(3)>", $uploading_3_files);
        ?>
        <p class="mb-0"><?php echo $expuploading_3_files[0]; ?>(<span></span>) <?php echo $expuploading_3_files[1]; ?></p>
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
                        <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true"><?php echo $this->lang->line('upload_photos'); ?></button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Upload Videos</button>
                    </li>
                </ul>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                        <form method="POST" id="formImages" action="<?php echo base_url('business-management/' . $businessInfo['business_url'] . '/update-gallery'); ?>">
                            <div id="image_preview"></div>
                            <div class="upload-more">
                                <div class="text-right">
                                    <div class="position-relative">
                                        <div class="drop-zone__prompt">
                                            <img src="assets/img/frontend/ic-cloud.png" alt="ic-cloud image" class="img-fluid">
                                            <p class="mb-2 text-black fw-500"><?php echo $this->lang->line('drop_files_to_upload_or_browse'); ?>
                                            </p>
                                            <span class="d-block page-text-xs text-black"><?php echo $this->lang->line('supports_jpeg_png_gif_jpg'); ?></span>
                                        </div>
                                        <div class="add-more-img text-center mt-3">
                                            <p><img src="assets/img/frontend/iconimg.png" alt=""> + <?php echo $this->lang->line('add_more_photos'); ?></p>
                                        </div>
                                        <input type="file" id="files" name="files[]" multiple />
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer justify-content-center border-0 p-0 upload-more-img">
                                <button type="button" class="btn btn-red">
                                    <img src="assets/img/frontend/ic-upload.png" alt="ic-upload">
                                    <?php echo $this->lang->line('upload'); ?></button>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                        <form method="POST" id="formVideos" action="<?php echo base_url('business-management/' . $businessInfo['business_url'] . '/update-video'); ?>">
                            <div class="form-group">
                                <label for="" class="form-label">Video URL</label>
                                <input name="" type="url" class="form-control form-control-lg mb-3 videoItem">
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
                                <a href="#" class="text-underline add-more fw-500">+ <?php echo $this->lang->line('add_more'); ?> </a>
                            </div>
                            <div class="modal-footer justify-content-center border-0 p-0 upload-more-video">
                                <button type="button" class="btn btn-red">
                                    <img src="assets/img/frontend/ic-upload.png" alt="ic-upload">
                                    <?php echo $this->lang->line('upload'); ?></button>
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
            <?php $are_you_sure_that_you_want_to_video = $this->lang->line('are_you_sure_that_you_want_to_video'); 
                $are_you_sure_that_you_want_to_video = explode('<URL>', $are_you_sure_that_you_want_to_video);
            ?>
                <p class="mb-0 text-center page-text-lg">
                    <?php echo $are_you_sure_that_you_want_to_video[0]; ?>
                    <b class="d-block fw-500 video-url-delete"></b>
                    <?php echo $are_you_sure_that_you_want_to_video[1]; ?>
                </p>
                <div class="video-item">
                    <!--
                    <a href="#" class="icon-video js-play-video">
                        <img src="assets/img/frontend/ic-play-video-white.png" alt="icon play" class="img-fluid">
                    </a>
                    -->
                    <img src="https://img.youtube.com/vi/semp2yGKmsk/hqdefault.jpg" alt="" class="img-fluid video-img-delete">
                </div>
                <input type="hidden" id="deleteVideoId" value="0" />
                <div class="modal-footer justify-content-center border-0 p-0">
                    <button type="button" class="btn btn-red btn-delete-video"><?php echo $this->lang->line('yes'); ?></button>
                    <button type="button" class="btn btn-outline-red" data-bs-dismiss="modal"><?php echo $this->lang->line('cancel'); ?></button>
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
            <?php $are_you_sure_that_you_want_to_photo = $this->lang->line('are_you_sure_that_you_want_to_photo'); 
                $are_you_sure_that_you_want_to_photo = explode('<3d7e386c33823.png>', $are_you_sure_that_you_want_to_photo);
            ?>
                <p class="mb-0 text-center page-text-lg">
                <?php echo $are_you_sure_that_you_want_to_photo[0]; ?>
                    <b class="d-block fw-500 img-name-delete"></b>
                    <?php echo isset($are_you_sure_that_you_want_to_photo[1]) ? $are_you_sure_that_you_want_to_photo[1]:''; ?>
                </p>

                <div class="photo-item">
                    <a href="javascript:void(0)" class="d-block">
                        <img src="assets/img/frontend/photo1.png" alt="photo image" class="img-fluid img-img-delete">
                    </a>
                </div>
                <input type="hidden" id="deleteImgId" value="0" />
                <div class="modal-footer justify-content-center border-0 p-0">
                    <button type="button" class="btn btn-red btn-delete-image"><?php echo $this->lang->line('yes'); ?></button>
                    <button type="button" class="btn btn-outline-red" data-bs-dismiss="modal"><?php echo $this->lang->line('cancel'); ?></button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Modal Delete Photo -->
<script>
    $(document).ready(function() {
        if (window.File && window.FileList && window.FileReader) {
            $("#files").on("change", function(e) {
                var files = e.target.files,
                    filesLength = files.length;
                for (var i = 0; i < filesLength; i++) {
                    var f = files[i]
                    var fileReader = new FileReader();
                    fileReader.onload = (function(e) {
                        $('#image_preview').append("<span class='pip position-relative'><img src='" + e.target.result + "'><span class=\"remove-img\"><img src='assets/img/frontend/ic-remove.svg'></span></span>");
                        $(".remove-img").click(function() {
                            $(this).parent(".pip").remove();
                            if ($('#image_preview .pip').length == 0) {
                                $('.drop-zone__prompt').show();
                                $('.add-more-img').hide();
                                $('.upload-more-img').hide();
                            }
                        });
                        $('.drop-zone__prompt').hide();
                        $('.add-more-img').show();
                        $('.upload-more-img').show();
                    });
                    fileReader.readAsDataURL(f);
                }
            });
            $('.hide-loading').click(function(e) {
                e.stopPropagation();
                $(this).closest('.uploading').hide();
            })
            $('.upload-more-img button').click(function(e) {
                e.stopPropagation();
                $('#addGalleryModal').modal('hide');
                $('.uploading .uploading-body table').empty();
                var count = 0;
                var imageLists = [];
                $('#image_preview .pip ').each(function(index, element) {
                    count += 1;
                    var html = ``;
                    var src = $(this).find('img').attr('src');
                    imageLists.push(src);
                    html = `<tr>
                    <td><img src="${src}" alt=""></td>
                    <td>${src}</td>
                    <td class="text-right"><img src="assets/img/frontend/spinner.gif" alt=""></td>
                    </tr>`;
                    $('.uploading .uploading-body table').append(html);
                })
                $('.uploading-head p span').text(count);
                $('.uploading').show();

                if (imageLists.length > 0) {

                    $.ajax({
                        type: 'POST',
                        url: $("#formImages").attr('action'),
                        data: {
                            images: JSON.stringify(imageLists)
                        },
                        dataType: "json",
                        success: function(data) {

                            $('.uploading .uploading-body tr td.text-right img').attr("src", "assets/img/frontend/ic-check-mask.png");

                            redirect(true);
                        },
                        error: function(data) {

                        }
                    });
                }


            });
        }

        // Dropdown photo gallery
        $(".js-dropdown-gallery").each(function() {
            $(this).click(function(e) {
                $(".dropdown-gallery").removeClass("show");
                e.preventDefault();
                $(this).parents(".photo-item").find(".dropdown-gallery").addClass("show");
            });
        });

        $(".dropdown-gallery .dropdown-item").click(function() {
            $(".dropdown-gallery .dropdown-item").removeClass("active");
            $(this).addClass("active");
            $(".dropdown-gallery").removeClass("show");
        });

        $(document).on("click", function(event) {
            var $trigger = $(".photo-item");
            if ($trigger !== event.target && !$trigger.has(event.target).length) {
                $(".dropdown-gallery").removeClass("show");
            }
        });

        // Add more input video url
        $(".add-more").click(function(e) {
            e.preventDefault();
            $("#formVideos .form-group").append('<input type="url" class="form-control form-control-lg mb-3 videoItem">');
        });

        //do upload videos
        $('.upload-more-video button').click(function(e) {
            e.stopPropagation();
            $('#addGalleryModal').modal('hide');
            var videoLists = [];
            $('.videoItem').each(function(index, element) {
                videoLists.push($(this).val());
            });
            if (videoLists.length > 0) {
                $.ajax({
                    type: 'POST',
                    url: $("#formVideos").attr('action'),
                    data: {
                        videos: JSON.stringify(videoLists)
                    },
                    dataType: "json",
                    success: function(data) {
                        $("#formVideos .form-group").append('<label for="" class="form-label">Video URL</label><input type="url" class="form-control form-control-lg mb-3 videoItem">');

                        if (data.code == 1) {
                            $(".notiPopup .text-secondary").html(data.message);
                            $(".ico-noti-success").removeClass('ico-hidden');
                            $(".notiPopup").fadeIn('slow').fadeOut(4000);
                        } else {
                            $(".notiPopup .text-secondary").html(data.message);
                            $(".ico-noti-error").removeClass('ico-hidden');
                            $(".notiPopup").fadeIn('slow').fadeOut(4000);
                        }

                        redirect(true);
                    },
                    error: function(data) {
                        $("#formVideos .form-group").append('<label for="" class="form-label">Video URL</label><input type="url" class="form-control form-control-lg mb-3 videoItem">');

                        $(".notiPopup .text-secondary").html("Upload video failed");
                        $(".ico-noti-error").removeClass('ico-hidden');
                        $(".notiPopup").fadeIn('slow').fadeOut(4000);
                    }
                });
            }


        });

        //confirm delete video
        $('.js-delete-video').click(function(e) {
            $("#deleteVideoId").val($(this).data('id'));
            $(".img-name-delete").html($(this).data('name'));
            $(".img-img-delete").attr('src', $(this).data('img'));
            $('#deleteVideoModal').modal('show');
        });

        //delete video
        $('.btn-delete-video').click(function(e) {
            var videoId = $("#deleteVideoId").val();

            if (videoId == 0) {
                $(".notiPopup .text-secondary").html("Video not exist");
                $(".ico-noti-error").removeClass('ico-hidden');
                $(".notiPopup").fadeIn('slow').fadeOut(4000);
            }

            $('#deleteVideoModal').modal('hide');

            $.ajax({
                type: 'POST',
                url: '<?php echo base_url('business-management/delete-video'); ?>',
                data: {
                    video_id: videoId
                },
                dataType: "json",
                success: function(data) {
                    if (data.code == 1) {
                        $(".notiPopup .text-secondary").html(data.message);
                        $(".ico-noti-success").removeClass('ico-hidden');
                        $(".notiPopup").fadeIn('slow').fadeOut(4000);
                    } else {
                        $(".notiPopup .text-secondary").html(data.message);
                        $(".ico-noti-error").removeClass('ico-hidden');
                        $(".notiPopup").fadeIn('slow').fadeOut(4000);
                    }
                    redirect(false, '<?php echo base_url('business-management/'.$businessInfo['business_url'].'/gallery?tab=video'); ?>');
                },
                error: function(data) {
                    $(".notiPopup .text-secondary").html("Delete video failed");
                    $(".ico-noti-error").removeClass('ico-hidden');
                    $(".notiPopup").fadeIn('slow').fadeOut(4000);
                    redirect(false, '<?php echo base_url('business-management/'.$businessInfo['business_url'].'/gallery?tab=video'); ?>');
                }
            });
        });

        //confirm delete image
        $('.js-delete-image').click(function(e) {
            $("#deleteImgId").val($(this).data('id'));
            $(".video-url-delete").html($(this).data('url'));
            $(".img-img-delete").attr('src', $(this).data('img'));
            $('#deletePhotoModal').modal('show');
        });

        //delete image
        $('.btn-delete-image').click(function(e) {
            var imgId = $("#deleteImgId").val();

            if (imgId == 0) {
                $(".notiPopup .text-secondary").html("Video not exist");
                $(".ico-noti-error").removeClass('ico-hidden');
                $(".notiPopup").fadeIn('slow').fadeOut(4000);
            }

            $('#deletePhotoModal').modal('hide');

            $.ajax({
                type: 'POST',
                url: '<?php echo base_url('business-management/delete-image'); ?>',
                data: {
                    image_id: imgId
                },
                dataType: "json",
                success: function(data) {
                    if (data.code == 1) {
                        $(".notiPopup .text-secondary").html(data.message);
                        $(".ico-noti-success").removeClass('ico-hidden');
                        $(".notiPopup").fadeIn('slow').fadeOut(4000);
                    } else {
                        $(".notiPopup .text-secondary").html(data.message);
                        $(".ico-noti-error").removeClass('ico-hidden');
                        $(".notiPopup").fadeIn('slow').fadeOut(4000);
                    }
                    redirect(false, '<?php echo base_url('business-management/'.$businessInfo['business_url'].'/gallery'); ?>');
                },
                error: function(data) {
                    $(".notiPopup .text-secondary").html("Delete video failed");
                    $(".ico-noti-error").removeClass('ico-hidden');
                    $(".notiPopup").fadeIn('slow').fadeOut(4000);
                    redirect(false, '<?php echo base_url('business-management/'.$businessInfo['business_url'].'/gallery'); ?>');
                }
            });
        });
    });
</script>