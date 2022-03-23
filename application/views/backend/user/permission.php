<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo isset($title) ? $title : 'Không có quyền truy cập'; ?></title>
    <base href="<?php echo base_url(); ?>"/>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="assets/vendor/dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="assets/vendor/dist/css/skins/_all-skins.min.css">
    <link rel="stylesheet" href="assets/vendor/dist/css/style.css">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->
<body class="hold-transition skin-blue layout-top-nav">
<div class="wrapper">
    <header class="main-header">
        <nav class="navbar navbar-static-top">
            <div class="container">
                <div class="navbar-header">
                    <a href="javascript:void(0)" class="navbar-brand"><b>Sales</b> Sys</a>
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                            data-target="#navbar-collapse">
                        <i class="fa fa-bars"></i>
                    </button>
                </div>
                <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
                    <ul class="nav navbar-nav"></ul>
                </div>
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <?php 
                        if($this->session->userdata('user') && $this->session->userdata('userFake')){
                            $user = $this->session->userdata('userFake');
                        }else if($this->session->userdata('user') && !$this->session->userdata('userFake')){
                            $user = $this->session->userdata('user');
                        }
                        
                        if($user){ ?>
                        <li class="dropdown user user-menu">
                            <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">
                                <?php $avatar = USER_PATH . ((!empty($user['Avatar'])) ? $user['Avatar'] : NO_IMAGE); ?>
                                <img src="<?php echo $avatar; ?>" alt="<?php echo $user['FullName']; ?>"
                                     class="user-image">
                                <span class="hidden-xs"><?php echo $user['FullName']; ?></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="user-header">
                                    <img src="<?php echo $avatar; ?>" alt="<?php echo $user['FullName']; ?>"
                                         class="img-circle">
                                    <p>
                                        <?php echo $user['FullName']; ?>
                                        <small><?php // echo $this->Mconstants->roles[$user['RoleId']]; ?></small>
                                    </p>
                                </li>
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <a href="<?php echo site_url('user/profile'); ?>"
                                           class="btn btn-default btn-flat">Trang cá nhân</a>
                                    </div>
                                    <div class="pull-right">
                                        <a href="<?php echo site_url('user/logout'); ?>"
                                           class="btn btn-default btn-flat">Đăng xuất</a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                        <?php } ?>
                        <li><a href="<?php echo base_url(); ?>" target="_blank">Trang chủ</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <div class="content-wrapper">
        <div class="container">
            <section class="content">
                <div class="callout callout-danger">
                    <h4>Cảnh báo!</h4>
                    <p>Trang này không tìm thấy hoặc bạn không có quyền truy cập hoặc bạn phải bật Javascript</p>
                </div>
            </section>
        </div>
    </div>
    <?php $siteName = 'Đặt hàng 86';
    $phoneCare = '0462 596 966 - 0928 521 333';
    $email = 'dathang86@gmail.com';
    $facebook = 'https://www.facebook.com/Dathang86/?fref=ts';
    $configs = $this->session->userdata('configs');
    if ($configs) {
        if (isset($configs['SITE_NAME'])) $siteName = $configs['SITE_NAME'];
        if (isset($configs['PHONE_CARE'])) $phoneCare = $configs['PHONE_CARE'];
        if (isset($configs['FACEBOOK'])) $email = $configs['EMAIL_COMPANY'];
        if (isset($configs['EMAIL_COMPANY'])) $facebook = $configs['EMAIL_COMPANY'];
    } ?>
    <footer class="main-footer">
        <div class="container">
            <div class="pull-right hidden-xs">
                <b>Version</b> 2.0.0
            </div>
            <strong>Copyright &copy; 2016 <a href="http://hoanmuada.com">Hoàn Mưa Đá</a>.</strong> All rights reserved.
            - <strong>CSKH</strong>: <?php echo $phoneCare; ?> . <strong>Email: <a
                    href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a></strong>.
            <strong>Facebook</strong>: <a href="<?php echo $facebook; ?>" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a>
        </div>
    </footer>
</div>
<script src="assets/vendor/plugins/jQuery/jquery-2.2.3.min.js"></script>
<script src="assets/vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/vendor/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<script src="assets/vendor/plugins/fastclick/fastclick.js"></script>
<script src="assets/vendor/dist/js/app.min.js"></script>
</body>
</html>