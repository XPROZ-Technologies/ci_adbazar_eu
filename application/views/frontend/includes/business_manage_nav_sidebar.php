<?php 
    $expiredDateSidebar = strtotime(ddMMyyyy($businessInfo['expired_date'], 'Y-m-d'));
    $currentDateSidebar = strtotime(date('Y-m-d'));
    $isExpiredSidebar = 0;
    if($businessInfo['business_status_id'] != STATUS_ACTIVED && $currentDateSidebar > $expiredDateSidebar) {
      $isExpiredSidebar = 1;
    }
?>
<div class="bm-left show-mobile-ic">
    <div class="text-center">
        <a href="javascript:void(0)" class="icon-show-mobile"><img src="assets/img/frontend/icon-mobile.svg" alt=""></a>
    </div>
    <aside class="bp-sidebar">
        <ul class="list-unstyled">
            <li class="<?php if(isset($activeBusinessMenu) && $activeBusinessMenu == 'about-us'){ echo 'active'; } ?> "><a href="<?php echo base_url('business-management/' . $businessInfo['business_url'] . '/about-us') ?>" class="btn-join-as-guest">My profile</a></li>
            <li class="<?php if(isset($activeBusinessMenu) && $activeBusinessMenu == 'gallery'){ echo 'active'; } ?> <?php if($isExpiredSidebar == 1){ echo 'expired-menu'; } ?>"><a href="<?php if($isExpiredSidebar == 0){ echo base_url('business-management/' . $businessInfo['business_url'] . '/gallery'); }else{ echo 'javascript:void(0)'; } ?>" class="btn-join-as-guest">Gallery</a></li>
            <li class="<?php if(isset($activeBusinessMenu) && $activeBusinessMenu == 'events'){ echo 'active'; } ?> <?php if($isExpiredSidebar == 1){ echo 'expired-menu'; } ?>"><a href="<?php if($isExpiredSidebar == 0){ echo base_url('business-management/' . $businessInfo['business_url'] . '/events'); }else{ echo 'javascript:void(0)'; } ?>" class="btn-join-as-guest">Events</a></li>
            <li class="<?php if(isset($activeBusinessMenu) && $activeBusinessMenu == 'coupons'){ echo 'active'; } ?> <?php if($isExpiredSidebar == 1){ echo 'expired-menu'; } ?>"><a href="<?php if($isExpiredSidebar == 0){ echo base_url('business-management/' . $businessInfo['business_url'] . '/coupons'); }else{ echo 'javascript:void(0)'; } ?>" class="btn-join-as-guest">Coupons</a></li>
            <li class="<?php if(isset($activeBusinessMenu) && $activeBusinessMenu == 'reviews'){ echo 'active'; } ?> <?php if($isExpiredSidebar == 1){ echo 'expired-menu'; } ?>"><a href="<?php if($isExpiredSidebar == 0){ echo base_url('business-management/' . $businessInfo['business_url'] . '/reviews'); }else{ echo 'javascript:void(0)'; } ?>" class="btn-join-as-guest"><?php echo $this->lang->line('reviews'); ?></a></li>
            <li class="<?php if(isset($activeBusinessMenu) && $activeBusinessMenu == 'reservations'){ echo 'active'; } ?> <?php if($isExpiredSidebar == 1){ echo 'expired-menu'; } ?>"><a href="<?php if($isExpiredSidebar == 0){ echo base_url('business-management/' . $businessInfo['business_url'] . '/reservations'); }else{ echo 'javascript:void(0)'; } ?>" class="btn-join-as-guest"><?php echo $this->lang->line('reservations'); ?></a></li>
            <li class="<?php if(isset($activeBusinessMenu) && $activeBusinessMenu == 'subscriptions'){ echo 'active'; } ?>"><a href="<?php echo base_url('business-management/' . $businessInfo['business_url'] . '/subscriptions') ?>" class="btn-join-as-guest">Subcription</a></li>
            <li></li>
        </ul>
    </aside>
</div>