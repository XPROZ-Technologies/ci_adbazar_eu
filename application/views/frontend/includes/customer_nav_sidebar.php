<div class="um-left show-mobile-ic mb-20">
<div class="text-center">
        <a href="javascript:void(0)" class="icon-show-mobile"><img src="assets/img/frontend/icon-mobile.png" alt=""></a>
    </div>
    <div class="um-links">
        <ul class="list-unstyled">
            <li class="<?php if(isset($activeCustomerNav) && $activeCustomerNav == 'general-information'){ echo "active"; } ?>"><a href="<?php echo base_url('customer/general-information') ?>">General information</a></li>
            <li class="<?php if(isset($activeCustomerNav) && $activeCustomerNav == 'change-password'){ echo "active"; } ?>"><a href="<?php echo base_url('customer/change-password') ?>">Change password</a></li>
            <li class="<?php if(isset($activeCustomerNav) && $activeCustomerNav == 'my-coupons'){ echo "active"; } ?>"><a href="<?php echo base_url('customer/my-coupons') ?>">My coupon</a></li>
            <li class="<?php if(isset($activeCustomerNav) && $activeCustomerNav == 'my-events'){ echo "active"; } ?>"><a href="<?php echo base_url('customer/my-events') ?>">My Event</a></li>
            <li class="<?php if(isset($activeCustomerNav) && $activeCustomerNav == 'my-reservation'){ echo "active"; } ?>"><a href="<?php echo base_url('customer/my-reservations') ?>">My Reservation</a></li>
            <li style="display:none;" class="<?php if(isset($activeCustomerNav) && $activeCustomerNav == 'general-information'){ echo "active"; } ?>"><a href="<?php echo base_url('customer-logout') ?>" class="btn btn-outline-red btn-logout">Log out</a></li>
        </ul>
    </div>
</div>