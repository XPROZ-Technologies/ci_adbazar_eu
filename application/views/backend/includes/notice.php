<?php if(isset($txtSuccess)){ ?>
    <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <?php echo $txtSuccess; ?>
    </div>
<?php } ?>
<?php if(isset($txtError)){ ?>
    <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <?php echo $txtError; ?>
    </div>
<?php } ?>