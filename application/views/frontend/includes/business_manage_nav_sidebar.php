<div class="bm-left show-mobile-ic">
    <div class="text-center">
        <a href="javascript:void(0)" class="icon-show-mobile"><img src="assets/img/frontend/icon-mobile.svg" alt=""></a>
    </div>
    <aside class="bp-sidebar">
        <ul class="list-unstyled">
            <li class="<?php if(isset($activeBusinessMenu) && $activeBusinessMenu == 'about-us'){ echo 'active'; } ?>"><a href="<?php echo base_url('business-management/' . $businessInfo['business_url'] . '/about-us') ?>" class="btn-join-as-guest">My profile</a></li>
            <li class="<?php if(isset($activeBusinessMenu) && $activeBusinessMenu == 'gallery'){ echo 'active'; } ?>"><a href="<?php echo base_url('business-management/' . $businessInfo['business_url'] . '/gallery') ?>" class="btn-join-as-guest">Gallery</a></li>
            <li class="<?php if(isset($activeBusinessMenu) && $activeBusinessMenu == 'events'){ echo 'active'; } ?>"><a href="<?php echo base_url('business-management/' . $businessInfo['business_url'] . '/events') ?>" class="btn-join-as-guest">Events</a></li>
            <li class="<?php if(isset($activeBusinessMenu) && $activeBusinessMenu == 'coupons'){ echo 'active'; } ?>"><a href="<?php echo base_url('business-management/' . $businessInfo['business_url'] . '/coupons') ?>" class="btn-join-as-guest">Coupons</a></li>
            <li class="<?php if(isset($activeBusinessMenu) && $activeBusinessMenu == 'reviews'){ echo 'active'; } ?>"><a href="<?php echo base_url('business-management/' . $businessInfo['business_url'] . '/reviews') ?>" class="btn-join-as-guest">Reviews</a></li>
            <li class="<?php if(isset($activeBusinessMenu) && $activeBusinessMenu == 'reservations'){ echo 'active'; } ?>"><a href="<?php echo base_url('business-management/' . $businessInfo['business_url'] . '/reservations') ?>" class="btn-join-as-guest">Reservations</a></li>
            <li class="<?php if(isset($activeBusinessMenu) && $activeBusinessMenu == 'subscriptions'){ echo 'active'; } ?>"><a href="<?php echo base_url('business-management/' . $businessInfo['business_url'] . '/subscriptions') ?>" class="btn-join-as-guest">Subcription</a></li>
            <li></li>
        </ul>
    </aside>
</div>