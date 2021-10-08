<div class="bp-tabs-left show-mobile-ic">
    <div class="text-center">
        <a href="javascript:void(0)" class="icon-show-mobile"><img src="assets/img/frontend/icon-mobile.png" alt=""></a>
    </div>
    <aside class="bp-sidebar">
        <ul class="list-unstyled">
            <li class="<?php if (isset($activeBusinessMenu) && $activeBusinessMenu == 'about-us') {
                            echo 'active';
                        } ?>"><a href="<?php echo base_url(BUSINESS_PROFILE_URL . $businessInfo['business_url']); ?>">About us</a></li>
            <li class="<?php if (isset($activeBusinessMenu) && $activeBusinessMenu == 'gallery') {
                            echo 'active';
                        } ?>"><a href="<?php echo base_url('business/' . $businessInfo['business_url'] . '/gallery'); ?>">Gallery</a></li>
            <li class="<?php if (isset($activeBusinessMenu) && $activeBusinessMenu == 'coupons') {
                            echo 'active';
                        } ?>"><a href="<?php echo base_url('business/' . $businessInfo['business_url'] . '/coupons'); ?>">Coupons</a></li>
            <li class="<?php if (isset($activeBusinessMenu) && $activeBusinessMenu == 'events') {
                            echo 'active';
                        } ?>"><a href="<?php echo base_url('business/' . $businessInfo['business_url'] . '/events'); ?>">Events</a></li>
            
            <li class="<?php if (isset($activeBusinessMenu) && $activeBusinessMenu == 'reviews') {
                            echo 'active';
                        } ?>"><a href="<?php echo base_url('business/' . $businessInfo['business_url'] . '/reviews'); ?>">Reviews</a></li>
            <li class="<?php if (isset($activeBusinessMenu) && $activeBusinessMenu == 'reservation') {
                            echo 'active';
                        } ?>"><a href="<?php echo base_url('business/' . $businessInfo['business_url'] . '/reservation'); ?>">Reservation</a></li>
            
        </ul>
    </aside>
</div>