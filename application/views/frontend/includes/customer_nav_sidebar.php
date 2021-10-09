<div class="um-left">
    <div class="um-links">
        <ul class="list-unstyled">
            <li class="<?php if(isset($activeCustomerNav) && $activeCustomerNav == 'general-information'){ echo "active"; } ?>"><a href="<?php echo base_url('customer/general-information') ?>"><?php echo $this->lang->line('general_information'); ?></a></li>
            <li class="<?php if(isset($activeCustomerNav) && $activeCustomerNav == 'change-password'){ echo "active"; } ?>"><a href="<?php echo base_url('customer/change-password') ?>"><?php echo $this->lang->line('change_password'); ?></a></li>
            <li class="<?php if(isset($activeCustomerNav) && $activeCustomerNav == 'my-coupons'){ echo "active"; } ?>"><a href="<?php echo base_url('customer/my-coupons') ?>"><?php echo $this->lang->line('my_coupons'); ?></a></li>
            <li class="<?php if(isset($activeCustomerNav) && $activeCustomerNav == 'my-events'){ echo "active"; } ?>"><a href="<?php echo base_url('customer/my-events') ?>"><?php echo $this->lang->line('my_events'); ?></a></li>
            <li class="<?php if(isset($activeCustomerNav) && $activeCustomerNav == 'my-reservation'){ echo "active"; } ?>"><a href="<?php echo base_url('customer/my-reservation') ?>"><?php echo $this->lang->line('my_reservations'); ?></a></li>
            <li style="display:none;" class="<?php if(isset($activeCustomerNav) && $activeCustomerNav == 'general-information'){ echo "active"; } ?>"><a href="<?php echo base_url('customer-logout') ?>" class="btn btn-outline-red btn-logout"><?php echo $this->lang->line('logout'); ?></a></li>
        </ul>
    </div>
</div>