<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $title; ?></title>
    <base href="<?php echo base_url();?>"/>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <?php $this->load->view('backend/includes/favicon'); ?>
    <meta name="robots" content="noindex, follow">
    <link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/vendor/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/vendor/plugins/pnotify/pnotify.custom.css" />
    <link rel="stylesheet" href="assets/vendor/dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="assets/vendor/plugins/iCheck/square/blue.css">
    <link rel="stylesheet" href="assets/vendor/plugins/pace/pace.min.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        <img src="assets/img/adbazar.eu.png" width="120px" class="mgr-5">
    </div>
    <div class="login-box-body">
        <p class="login-box-msg">Log in to the system</p>
        <?php echo form_open('backend/user/checkLogin', array('id' => 'userForm')); ?>
        <div class="form-group has-feedback">
            <input type="text" name="user_name" class="form-control hmdrequired" value="<?php echo $userName; ?>" placeholder="User name, Phone number" data-field="User name, Phone number" autocomplete="off">
            <span class="glyphicon glyphicon-phone-alt form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
            <input type="password" name="user_pass" class="form-control hmdrequired" value="<?php echo $userPass; ?>" placeholder="Password" data-field="Password" autocomplete="off">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
        <div class="row">
            <div class="col-xs-8">
                <div class="checkbox icheck">
                    <label>
                        <input type="checkbox" name="is_remember" class="iCheck" checked="checked"> Remember
                    </label>
                </div>
            </div>
            <div class="col-xs-4">
                <button type="submit" class="btn btn-primary btn-block btn-flat">Login</button>
                <input type="text" hidden="hidden" name="is_get_configs" value="1">
            </div>
        </div>
        <?php echo form_close(); ?>
        <input type="text" hidden="hidden" id="dashboardUrl" value="<?php echo base_url('sys-admin/dashboard'); ?>">
        <input type="text" hidden="hidden" id="siteName" value="">
    </div>
</div>
<noscript><meta http-equiv="refresh" content="0; url=<?php echo base_url('backend/user/permission'); ?>" /></noscript>
<script src="assets/vendor/plugins/jQuery/jquery-2.2.3.min.js"></script>
<script src="assets/vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/vendor/plugins/pace/pace.min.js"></script>
<script src="assets/vendor/plugins/pnotify/pnotify.custom.js"></script>
<script src="assets/vendor/plugins/iCheck/icheck.min.js"></script>
<script type="text/javascript" src="assets/js/backend/common.js?20171022"></script>
<script type="text/javascript" src="assets/js/backend/user/login.js"></script>
</body>
</html>
