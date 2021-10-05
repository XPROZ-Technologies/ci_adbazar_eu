<div class="bp-top">
    <div class="container">
        <img src="<?php if (!empty($businessInfo['business_image_cover'])) {
                        echo BUSINESS_PROFILE_PATH . $businessInfo['business_image_cover'];
                    } else {
                        echo BUSINESS_PROFILE_PATH . NO_IMAGE;
                    } ?>" alt="<?php echo $businessInfo['business_name']; ?>" class="img-fluid">
    </div>
</div>
<div class="bp-top-img">
    <div class="bp-header">
        <img src="<?php if (!empty($businessInfo['business_avatar'])) {
                        echo BUSINESS_PROFILE_PATH . $businessInfo['business_avatar'];
                    } else {
                        echo BUSINESS_PROFILE_PATH . NO_IMAGE;
                    } ?>" alt="<?php echo $businessInfo['business_name']; ?>" class="img-fluid">
        <h3 class="text-center page-title fw-bold text-black"><?php echo $businessInfo['business_name']; ?></h3>
        <p class="mb-0 page-text-lg text-black text-center"><?php echo $businessInfo['business_slogan']; ?></p>
    </div>
</div>