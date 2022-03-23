<div class="bp-tabs-left show-mobile-ic">
    <div class="text-center">
        <a href="javascript:void(0)" class="icon-show-mobile"><img src="assets/img/frontend/icon-mobile.svg" alt=""></a>
    </div>
    <aside class="bp-sidebar">
        <ul class="list-unstyled">
            <li class="<?php if (isset($activeBusinessMenu) && $activeBusinessMenu == 'about-us') {
                            echo 'active';
                        } ?>"><a href="<?php echo base_url(BUSINESS_PROFILE_URL . $businessInfo['business_url']); ?>"><?php echo $this->lang->line('about_us'); ?></a></li>
            <li class="<?php if (isset($activeBusinessMenu) && $activeBusinessMenu == 'gallery') {
                            echo 'active';
                        } ?>"><a href="<?php echo base_url('business/' . $businessInfo['business_url'] . '/gallery'); ?>"><?php echo $this->lang->line('gallery'); ?></a></li>
            <li class="<?php if (isset($activeBusinessMenu) && $activeBusinessMenu == 'coupons') {
                            echo 'active';
                        } ?>"><a href="<?php echo base_url('business/' . $businessInfo['business_url'] . '/coupons'); ?>"><?php echo $this->lang->line('coupons'); ?></a></li>
            <li class="<?php if (isset($activeBusinessMenu) && $activeBusinessMenu == 'events') {
                            echo 'active';
                        } ?>"><a href="<?php echo base_url('business/' . $businessInfo['business_url'] . '/events'); ?>"><?php echo $this->lang->line('events'); ?></a></li>
            
            <li class="<?php if (isset($activeBusinessMenu) && $activeBusinessMenu == 'reviews') {
                            echo 'active';
                        } ?>"><a href="<?php echo base_url('business/' . $businessInfo['business_url'] . '/reviews'); ?>"><?php echo $this->lang->line('reviews'); ?></a></li>
            <?php if(isset($customer['id']) && $customer['id'] > 0){ ?>
            <li class="<?php if (isset($activeBusinessMenu) && $activeBusinessMenu == 'reservation') {
                            echo 'active';
                        } ?>"><a href="<?php echo base_url('business/' . $businessInfo['business_url'] . '/reservation'); ?>"><?php echo $this->lang->line('reservations'); ?></a></li>
            <?php } ?>
        </ul>
    </aside>
</div>