<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title><?php echo $title; ?></title>
    <base href="<?php echo base_url(); ?>" id="baseUrl"/>
    <?php $this->load->view('backend/includes/favicon'); ?>
    <link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/vendor/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/vendor/plugins/pnotify/pnotify.custom.min.css"/>
    <link rel="stylesheet" href="assets/vendor/plugins/select2/select2.min.css"/>
    <link rel="stylesheet" href="assets/vendor/plugins/iCheck/all.css">
    <?php if (isset($scriptHeader)) outputScript($scriptHeader); ?>
    <link rel="stylesheet" href="assets/vendor/dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="assets/vendor/dist/css/skins/_all-skins.min.css">
    <link rel="stylesheet" href="assets/vendor/plugins/pace/pace.min.css">
    <link rel="stylesheet" href="assets/vendor/dist/css/style.css">
    <link rel="stylesheet" href="assets/vendor/dist/css/common.css">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="hold-transition skin-blue sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
    <?php $textLogoHeader = 'LK';
    $textLogoMenu = 'LK';
    $logoImage = 'assets/img/logo.png';
    $configs = $this->session->userdata('configs');
    if($configs){
        if(isset($configs['TEXT_LOGO_HEADER'])) $textLogoHeader = $configs['TEXT_LOGO_HEADER'];
        if(isset($configs['LOGO_IMAGE_HEADER'])) $logoImage = $configs['LOGO_IMAGE_HEADER'];
    } ?>
    <header class="main-header">
        <a href="<?php echo base_url(); ?>" class="logo">
            <img src="assets/img/logo.png" width="80px" class="mgr-5">
        </a>
        <nav class="navbar navbar-static-top">
            <a href="javascript:void(0)" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <?php $avatar = empty($user['avatar']) ? $logoImage : $user['avatar']; ?>
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                            <img src="<?php echo USER_PATH.$avatar; ?>" class="user-image" alt="<?php echo $user['full_name']; ?>">
                            <span class="hidden-xs"><?php echo $user['full_name']; ?></span>
                        </a>
                        <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <img src="<?php echo USER_PATH.$avatar; ?>" class="img-circle" alt="<?php echo $user['full_name']; ?>">
                            <p><?php echo $user['full_name']; ?></p>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                            <!-- <a href="<?php // echo base_url('backend/user/edit/'.$user['id']); ?>" class="btn btn-default btn-flat">Thông tin cá nhân</a> -->
                            </div>
                            <div class="pull-right">
                            <a href="<?php echo base_url('backend/user/logout'); ?>" class="btn btn-default btn-flat">Logout</a>
                            </div>
                        </li>
                        </ul>
                       
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <aside class="main-sidebar">
        <section class="sidebar">
        <ul class="sidebar-menu">
                <?php $listActions1 = $listActions2 = $listActions3 = array();
                foreach($listActions as $act){
                    if($act['display_order'] > 0){
                        if($act['action_level'] == 1) $listActions1[] = $act;
                        elseif($act['action_level'] == 2) $listActions2[] = $act;
                        elseif($act['action_level'] == 3) $listActions3[] = $act;
                    }
                }
                foreach($listActions1 as $act1) {
                    $listActionLv2 = array();
                    foreach($listActions2 as $act2){
                        if($act2['parent_action_id'] == $act1['id']) $listActionLv2[] = $act2;
                    }
                    if(!empty($listActionLv2)){ ?>
                        <li class="treeview">
                            <a href="javascript:void(0)">
                                <i class="fa <?php echo empty($act1['font_awesome']) ? 'fa-circle-o' : $act1['font_awesome']; ?>"></i> <span><?php echo $act1['action_name']; ?></span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <?php foreach($listActionLv2 as $act2){
                                    if($act2['display_order'] > 0){
                                        $listActionLv3 = array();
                                        foreach($listActions3 as $act3){
                                            if($act3['parent_action_id'] == $act2['id']) $listActionLv3[] = $act3;
                                        }
                                        if(!empty($listActionLv3)){ ?>
                                            <li>
                                                <a href="javascript:void(0)">
                                                    <i class="fa <?php echo empty($act2['font_awesome']) ? 'fa-circle-o' : $act2['font_awesome']; ?>"></i> <?php echo $act2['action_name']; ?>
                                                    <span class="pull-right-container">
                                                    <i class="fa fa-angle-left pull-right"></i>
                                                </span>
                                                </a>
                                                <ul class="treeview-menu">
                                                    <?php foreach($listActionLv3 as $act3){ ?>
                                                        <li><a href="<?php echo empty($act3['action_url']) ? 'javascript:void(0)' : base_url($act3['action_url']); ?>"><i class="fa <?php echo empty($act3['font_awesome']) ? 'fa-circle-o' : $act3['font_awesome']; ?>"></i> <?php echo $act3['action_name']; ?></a></li>
                                                    <?php } ?>
                                                </ul>
                                            </li>
                                        <?php } else{ ?>
                                            <li><a href="<?php echo empty($act2['action_url']) ? 'javascript:void(0)' : base_url($act2['action_url']); ?>"><i class="fa <?php echo empty($act2['font_awesome']) ? 'fa-circle-o' : $act2['font_awesome']; ?>"></i> <?php echo $act2['action_name']; ?></a></li>
                                        <?php } ?>
                                    <?php }
                                } ?>
                            </ul>
                        </li>
                    <?php } else{ ?>
                        <li><a href="<?php echo empty($act1['action_url']) ? 'javascript:void(0)' : base_url($act1['action_url']); ?>"><i class="fa <?php echo empty($act1['font_awesome']) ? 'fa-circle-o' : $act1['font_awesome']; ?>"></i> <span><?php echo $act1['action_name']; ?></span></a></li>
                    <?php }
                } ?>
            </ul>
        </section>
    </aside>