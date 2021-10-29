<!doctype html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <meta name="google-signin-client_id" content="<?php echo KEY_GG ?>.apps.googleusercontent.com">
  <title><?php if (!empty($title)) {
            echo $title . ' - ' . $configs['TEXT_LOGO_HEADER'];;
          } else {
            echo "Asia Dragon Bazar";
          } ?></title>
  <base href="<?php echo base_url(); ?>" data-href="<?php echo base_url(); ?>" id="baseUrl" />
  <base data-href="<?php echo site_url(HOME_URL); ?>" id="baseHomeUrl" />

  <?php $this->load->view('frontend/includes/favicon'); ?>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="stylesheet" href="assets/css/frontend/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/frontend/owl.carousel.min.css" />
  <link rel="stylesheet" href="assets/css/frontend/animate.min.css" />
  <link rel="stylesheet" href="assets/css/frontend/nice-select.min.css" />
  <link rel="stylesheet" href="assets/css/frontend/tempusdominus-bootstrap-4.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css" />
  <link rel="stylesheet" href="assets/vendor/plugins/lib/main.css?version=<?php echo time(); ?>">
  <link rel="stylesheet" href="assets/css/frontend/main.css?version=<?php echo time(); ?>">
  <link rel="stylesheet" href="assets/css/frontend/edit.css?version=<?php echo time(); ?>">
  <link rel="stylesheet" href="assets/css/frontend/custom.css?version=<?php echo time(); ?>">
  <?php if (isset($scriptHeader)) outputScript($scriptHeader); ?>
</head>


<body>
  <header class="page-header">
    <!-- Desktop Menu -->
    <nav class="navbar navbar-expand-xl">
      <div class="container">
        <a class="navbar-brand" href="<?php echo base_url(HOME_URL); ?>">
          <img src="<?php echo CONFIG_PATH . $configs['LOGO_IMAGE_HEADER']; ?>" alt="<?php echo $configs['TEXT_LOGO_HEADER']; ?>" class="img-fluid">
        </a>
        <div class="header-right-mobile">
          <div class="d-flex align-items-center d-xl-none">
            <!-- Notitfication -->
            <?php if (isset($customer) && $customer['is_logged_in'] == 1) { ?>
              <div class="d-flex align-items-center navbar-right">
                <div class="wrapper-notification">
                  <div class="header-notification">
                    <i class="bi bi-bell"></i>
                    <?php if(isset($notiBadge) && $notiBadge > 0){ ?>
                    <div class="badge"><?php echo $notiBadge; ?></div>
                    <?php } ?>
                  </div>
                  <div class="wrapper-notify">
                    <div class="spacer"></div>
                    <div class="inner-notify">
                      <div class="d-flex align-items-center justify-content-between notify-top">
                        <span><?php echo $this->lang->line('notifications'); ?></span>
                        <a href="javascript:void(0)"><?php echo $this->lang->line('see_all'); ?></a>
                      </div>
                      <div class="list-notify">
                      <?php if(isset($notiHeader) && !empty($notiHeader)){ ?>
                        
                        <!-- noti item -->
                          <?php 
                            foreach($notiHeader as $noti){  
                          ?>
                            <a href="<?php echo $noti['url']; ?>" class="notify-item">
                              <div class="notify-img">
                                <img src="<?php echo $noti['image']; ?>; ?>" alt="notification img" class="img-fluid">
                              </div>
                              <div class="notify-body">
                                <p><?php echo $noti['text']; ?></p>
                                <small><?php echo ddMMyyyy($noti['created_at'] ,'Y-m-d H:i'); ?></small>
                              </div>
                              <?php if($noti['notification_status_id'] == STATUS_ACTIVED){ ?>
                                <img src="assets/img/frontend/icon-new-badge.png" alt="new badge" class="notify-badge">
                              <?php } ?>
                            </a>
                          <?php } ?>
                        <!-- END. item noti -->
                       <?php } else { ?>
                        <div class="notification-zero zero-box">
                          <img src="assets/img/frontend/img-empty-box.svg" alt="empty box" class="img-fluid d-block mx-auto">
                          <p class="page-text-lg text-center text-secondary"><?php echo $this->lang->line('you_do_not_have_any_notification_yet'); ?></p>
                        </div>
                       <?php } ?>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            <?php } ?>
            <!-- END. notitfication -->

            <!-- login / signup -->
            <?php if (isset($customer) && $customer['is_logged_in'] == 0) { ?>
              <div class="d-flex btn-user">
                <a href="<?php echo base_url('login.html'); ?>" title="" class="btn btn-red btn-login l<?php echo $language_id; ?>"><?php echo $this->lang->line('sign_in'); ?></a>
                <a href="<?php echo base_url('signup.html'); ?>" title="" class="btn btn-outline-red btn-register l<?php echo $language_id; ?>"><?php echo $this->lang->line('sign_up'); ?></a>
              </div>
            <?php } ?>
            <!-- END. login / signup -->

            <!-- customer info -->
            <?php if (isset($customer) && $customer['is_logged_in'] == 1) { ?>
              <div class="user-info-img">
                <?php $avatar = empty($customer['customer_avatar']) ? NO_IMAGE : $customer['customer_avatar']; ?>
                <img src="<?php echo CUSTOMER_PATH . $avatar; ?>" alt="avatar" class="img-fluid avatar-img">
                <div class="user-info-text">
                  <a href="javascript:void(0)"><?php echo $customer['customer_first_name']; ?></a>
                  <a href="javascript:void(0)"><img src="assets/img/frontend/bot-avata.png" alt="avatar" class="img-fluid"></a>
                </div>
                <div class="user-info-box">
                  <div class="user-info-item">
                    <div class="user-info-box-top">
                      <img src="<?php echo CUSTOMER_PATH . $avatar; ?>" alt="avatar" class="img-fluid">
                      <div class="user-info-box-name">
                        <p><?php echo $customer['customer_first_name']; ?></p>
                        <a href="<?php echo base_url('customer/general-information') ?>"><?php echo $this->lang->line('see_my_profile'); ?></a>
                      </div>
                    </div>
                    <button class="btn btn-red" onclick="window.location.href='<?php echo base_url('my-business-profile'); ?>'"><?php echo $this->lang->line('my_business_profile'); ?></button>
                    
                    <?php if (isset($customer['login_type_id']) && $customer['login_type_id'] == 2) { ?>
                      <button type="button" class="btn btn-outline-red btn-logout-all g-logout" is-login="<?php echo $customer['is_logged_in'] ?>" login-type-id="<?php echo $customer['login_type_id'] ?>" onclick="signOut();"><?php echo $this->lang->line('logout'); ?></button>
                    <?php } else { ?>
                      <button class="btn btn-outline-red btn-logout-all" is-login="<?php echo $customer['is_logged_in'] ?>" login-type-id="<?php echo $customer['login_type_id'] ?>"><?php echo $this->lang->line('logout'); ?></button>
                    <?php } ?>

                  </div>
                </div>
              </div>
            <?php } ?>
            <!-- END. customer info -->

            <!-- Languages -->
            <div class="dropdown dropdown-language mx-3">
              <a href="#" class="wrapper-btn dropdown-toggle current" id="languageDropdown" data-bs-toggle="dropdown" aria-expanded="false" value="en">
                <?php if (isset($customer['language_id']) && ($customer['language_id'] == 1)) { ?><img src="assets/img/frontend/en.png" alt="English" class="img-fluid"><?php } ?>
                <?php if (isset($customer['language_id']) && ($customer['language_id'] == 2)) { ?><img src="assets/img/frontend/cre.png" alt="Czech Republic" class="img-fluid"><?php } ?>
                <?php if (isset($customer['language_id']) && ($customer['language_id'] == 3)) { ?><img src="assets/img/frontend/ger.png" alt="Germany" class="img-fluid"><?php } ?>
                <?php if (isset($customer['language_id']) && ($customer['language_id'] == 4)) { ?><img src="assets/img/frontend/vn.png" alt="Việt Nam" class="img-fluid"><?php } ?>
              </a>
              <ul class="dropdown-menu js-list-language" aria-labelledby="languageDropdown">
                <li class="change-language-menu <?php echo $customer['language_id'] == 1 ? 'selected' : ''; ?>" data-language-id="1"><a class="dropdown-item change-customer-language" href="javascript:void(0)" value="en" data-language-id="1"><img src="assets/img/frontend/en.png" alt="english flag" class="img-fluid me-2"><?php echo $this->lang->line('english'); ?></a></li>
                <li class="change-language-menu <?php echo $customer['language_id'] == 4 ? 'selected' : ''; ?>" data-language-id="4"><a class="dropdown-item change-customer-language" href="javascript:void(0)" value='vn' data-language-id="4"><img src="assets/img/frontend/vn.png" alt="vietnam flag" class="img-fluid me-2"><?php echo $this->lang->line('vietnamese'); ?></a></li>
                <li class="change-language-menu <?php echo $customer['language_id'] == 3 ? 'selected' : ''; ?>" data-language-id="3"><a class="dropdown-item change-customer-language" href="javascript:void(0)" value='ger' data-language-id="3"><img src="assets/img/frontend/ger.png" alt="germany flag" class="img-fluid me-2"><?php echo $this->lang->line('german'); ?></a></li>
                <li class="change-language-menu <?php echo $customer['language_id'] == 2 ? 'selected' : ''; ?>" data-language-id="2"><a class="dropdown-item change-customer-language" href="javascript:void(0)" value='cre' data-language-id="2"><img src="assets/img/frontend/cre.png" alt="czech flag" class="img-fluid me-2"><?php echo $this->lang->line('czech'); ?></a></li>
              </ul>
            </div>
            <!-- END. Languages -->

          </div>
          <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
            <div class="d-flex align-items-center">
              <i class="bi bi-list"></i>
              <!-- <span>Menu</span> -->
            </div>
          </button>
        </div>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link <?php if (isset($activeMenu) && $activeMenu == "about-us") {
                                    echo "active";
                                  } ?>" href="<?php echo base_url('about-us.html') ?>"><?php echo $this->lang->line('about_us'); ?></a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle  <?php if (isset($activeMenu) && $activeMenu == "services") {
                                                    echo "active";
                                                  } ?>" href="<?php echo base_url('services.html') ?>" id="serviceDropdown">
                <?php echo $this->lang->line('services'); ?>
              </a>
              <ul class="dropdown-menu" aria-labelledby="serviceDropdown">
                <?php if (!empty($menuServices) && count($menuServices) > 0) {
                  for ($i = 0; $i < count($menuServices); $i++) {
                    $menuServiceUrl = base_url('service/' . makeSlug($menuServices[$i]['service_slug']) . '-' . $menuServices[$i]['id']) . '.html'; ?>
                    <li><a class="dropdown-item <?php if (isset($activeMenuService) && $menuServices[$i]['id'] === $activeMenuService) {
                                                  echo "active";
                                                } ?>" href="<?php echo $menuServiceUrl; ?>"><?php echo $menuServices[$i]['service_name']; ?></a></li>
                <?php }
                } ?>
              </ul>
            </li>
            <li class="nav-item">
              <a class="nav-link <?php if (isset($activeMenu) && $activeMenu == "coupons") {
                                    echo "active";
                                  } ?>" href="<?php echo base_url('coupons.html'); ?>"><?php echo $this->lang->line('coupons'); ?></a>
            </li>
            <li class="nav-item">
              <a class="nav-link  <?php if (isset($activeMenu) && $activeMenu == "events") {
                                    echo "active";
                                  } ?>" href="<?php echo base_url('events.html'); ?>"><?php echo $this->lang->line('events'); ?></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?php echo base_url(HOME_URL); ?>#contact-us"><?php echo $this->lang->line('contact_us'); ?></a>
            </li>
          </ul>
          <div class="d-flex align-items-center navbar-right">
            <?php if (isset($customer) && $customer['is_logged_in'] == 0) { ?>
              <div class="d-flex btn-user">
                <a href="<?php echo base_url('login.html'); ?>" title="" class="btn btn-red btn-login l<?php echo $language_id; ?>"><?php echo $this->lang->line('sign_in'); ?></a>
                <a href="<?php echo base_url('signup.html'); ?>" title="" class="btn btn-outline-red btn-register l<?php echo $language_id; ?>"><?php echo $this->lang->line('sign_up'); ?></a>
              </div>
            <?php } ?>
            <!-- Languages -->
            <div class="dropdown dropdown-language <?php if (isset($customer) && $customer['is_logged_in'] == 0) {
                                                      echo "ml-32";
                                                    } else {
                                                      echo "mx-3";
                                                    } ?>">
              <a href="javascript:void(0)" class="wrapper-btn dropdown-toggle current" id="languageDropdown" data-bs-toggle="dropdown" aria-expanded="false" value="en">
                <?php if (isset($customer['language_id']) && ($customer['language_id'] == 1)) { ?><img src="assets/img/frontend/en.png" alt="English" class="img-fluid"><?php } ?>
                <?php if (isset($customer['language_id']) && ($customer['language_id'] == 2)) { ?><img src="assets/img/frontend/cre.png" alt="Czech Republic" class="img-fluid"><?php } ?>
                <?php if (isset($customer['language_id']) && ($customer['language_id'] == 3)) { ?><img src="assets/img/frontend/ger.png" alt="Germany" class="img-fluid"><?php } ?>
                <?php if (isset($customer['language_id']) && ($customer['language_id'] == 4)) { ?><img src="assets/img/frontend/vn.png" alt="Việt Nam" class="img-fluid"><?php } ?>
              </a>
              <?php echo form_open('change-customer-language', array('id' => 'languageForm')); ?>
              <input type="hidden" name="language_id" id="selected_lang" value="<?php echo $this->Mconstants->languageDefault; ?>" />
              <input type="hidden" name="UrlOld" value="<?php echo $this->uri->uri_string(); ?>" />
              <?php echo form_close(); ?>
              <ul class="dropdown-menu js-list-language" aria-labelledby="languageDropdown">
                <li class="change-language-menu <?php echo $customer['language_id'] == 1 ? 'selected' : ''; ?>" data-language-id="1"><a class="dropdown-item change-customer-language" href="javascript:void(0)" value="en" data-language-id="1"><img src="assets/img/frontend/en.png" alt="english flag" class="img-fluid me-2"><?php echo $this->lang->line('english'); ?></a></li>
                <li class="change-language-menu <?php echo $customer['language_id'] == 4 ? 'selected' : ''; ?>" data-language-id="4"><a class="dropdown-item change-customer-language" href="javascript:void(0)" value='vn' data-language-id="4"><img src="assets/img/frontend/vn.png" alt="vietnam flag" class="img-fluid me-2"><?php echo $this->lang->line('vietnamese'); ?></a></li>
                <li class="change-language-menu <?php echo $customer['language_id'] == 3 ? 'selected' : ''; ?>" data-language-id="3"><a class="dropdown-item change-customer-language" href="javascript:void(0)" value='ger' data-language-id="3"><img src="assets/img/frontend/ger.png" alt="germany flag" class="img-fluid me-2"><?php echo $this->lang->line('german'); ?></a></li>
                <li class="change-language-menu <?php echo $customer['language_id'] == 2 ? 'selected' : ''; ?>" data-language-id="2"><a class="dropdown-item change-customer-language" href="javascript:void(0)" value='cre' data-language-id="2"><img src="assets/img/frontend/cre.png" alt="czech flag" class="img-fluid me-2"><?php echo $this->lang->line('czech'); ?></a></li>
              </ul>
            </div>
            <!-- END. Languages -->

            <?php if (isset($customer) && $customer['is_logged_in'] == 1) { ?>
              <!-- Logged In Info -->
              <div class="user-info-img">
                <?php $avatar = empty($customer['customer_avatar']) ? NO_IMAGE : $customer['customer_avatar']; ?>
                <img src="<?php echo CUSTOMER_PATH . $avatar; ?>" alt="avatar" class="img-fluid avatar-img">
                <div class="user-info-text">
                  <a href="javascript:void(0)"><?php echo $customer['customer_first_name']; ?></a>
                  <a href=""><img src="assets/img/frontend/bot-avata.png" alt="avatar" class="img-fluid"></a>
                </div>
                <div class="user-info-box">
                  <div class="user-info-item">
                    <div class="user-info-box-top">
                      <img src="<?php echo CUSTOMER_PATH . $avatar; ?>" alt="avatar" class="img-fluid">
                      <div class="user-info-box-name">
                        <p><?php echo $customer['customer_first_name']; ?></p>
                        <a href="<?php echo base_url('customer/general-information') ?>"><?php echo $this->lang->line('see_my_profile'); ?></a>
                      </div>
                    </div>
                    <button class="btn btn-red" onclick="window.location.href='<?php echo base_url('my-business-profile'); ?>'"><?php echo $this->lang->line('my_business_profile'); ?></button>
                    <?php if (isset($customer['login_type_id']) && $customer['login_type_id'] == 2) { ?>
                      <button type="button" class="btn btn-outline-red btn-logout-all g-logout" is-login="<?php echo $customer['is_logged_in'] ?>" login-type-id="<?php echo $customer['login_type_id'] ?>" onclick="signOut();"><?php echo $this->lang->line('logout'); ?></button>
                    <?php } else { ?>
                      <button class="btn btn-outline-red btn-logout-all" is-login="<?php echo $customer['is_logged_in'] ?>" login-type-id="<?php echo $customer['login_type_id'] ?>"><?php echo $this->lang->line('logout'); ?></button>
                    <?php } ?>

                  </div>
                </div>
              </div>

              <div class="wrapper-notification">
                <div class="header-notification">
                  <i class="bi bi-bell"></i>
                  <?php if(isset($notiBadge) && $notiBadge > 0){ ?>
                    <div class="badge"><?php echo $notiBadge; ?></div>
                  <?php } ?>
                </div>
                <div class="wrapper-notify">
                  <div class="spacer"></div>
                  <div class="inner-notify">
                    <div class="d-flex align-items-center justify-content-between notify-top">
                      <span><?php echo $this->lang->line('notifications'); ?></span>
                      <a href="<?php echo base_url('notifications.html'); ?>"><?php echo $this->lang->line('see_all'); ?></a>
                    </div>

                    <!-- List noti -->
                    <div class="list-notify">
                      <?php if(isset($notiHeader) && !empty($notiHeader)){ ?>
                        
                        <!-- noti item -->
                        <?php foreach($notiHeader as $noti){ ?>
                          <a href="<?php echo $noti['url']; ?>" class="notify-item">
                            <div class="notify-img">
                              <img src="<?php echo $noti['image']; ?>" alt="notification img" class="img-fluid">
                            </div>
                            <div class="notify-body">
                              <p><?php echo $noti['text']; ?></p>
                              <small><?php echo ddMMyyyy($noti['created_at'] ,'Y-m-d H:i'); ?></small>
                            </div>
                            <?php if($noti['notification_status_id'] == STATUS_ACTIVED){ ?>
                              <img src="assets/img/frontend/icon-new-badge.png" alt="new badge" class="notify-badge">
                            <?php } ?>
                          </a>
                        <?php } ?>
                        <!-- END. noti item -->
                      
                      <?php }else{ ?>
                        <div class="notification-zero zero-box">
                          <img src="assets/img/frontend/img-empty-box.svg" alt="empty box" class="img-fluid d-block mx-auto">
                          <p class="page-text-lg text-center text-secondary"><?php echo $this->lang->line('you_do_not_have_any_notification_yet'); ?></p>
                        </div>
                      <?php } ?>
                      
                    </div>
                    <!-- END. List noti -->
                  </div>
                </div>
              </div>
              <!-- END. Logged In Info -->
            <?php } ?>

          </div>
        </div>
      </div>
    </nav>
    <!-- END. Desktop Menu -->
    <!-- Mobile Menu -->
    <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
      <div class="offcanvas-header">
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body">
        <nav class="navbar navbar-expand">
          <div class="collapse navbar-collapse">
            <ul class="navbar-nav-xl">
              <li class="nav-item">
                <a class="nav-link  <?php if (isset($activeMenu) && $activeMenu == "home") {
                                      echo "active";
                                    } ?>" aria-current="page" href="<?php echo base_url(HOME_URL); ?>"><?php echo $this->lang->line('homepage'); ?></a>
              </li>
              <li class="nav-item">
                <a class="nav-link <?php if (isset($activeMenu) && $activeMenu == "about-us") {
                                      echo "active";
                                    } ?>" href="<?php echo base_url('about-us.html') ?>"><?php echo $this->lang->line('about_us'); ?></a>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle  <?php if (isset($activeMenu) && $activeMenu == "services") {
                                                      echo "active";
                                                    } ?>" href="<?php echo base_url('services.html') ?>" id="serviceDropdown">
                  <?php echo $this->lang->line('services'); ?>
                </a>
                <span class="nav-link dropdown-toggle dropdown-toggle-mobile-not-link" role="button" data-bs-toggle="dropdown" aria-expanded="false"></span>
                <ul class="dropdown-menu" aria-labelledby="serviceDropdown">
                  <?php if (!empty($menuServices) && count($menuServices) > 0) {
                    for ($i = 0; $i < count($menuServices); $i++) {
                      $menuServiceUrl = base_url('service/' . makeSlug($menuServices[$i]['service_slug']) . '-' . $menuServices[$i]['id']) . '.html'; ?>
                      <li><a class="dropdown-item <?php if (isset($activeMenuService) && $activeMenuService === $menuServices[$i]['id']) {
                                                    echo "active";
                                                  } ?>" href="<?php echo $menuServiceUrl; ?>"><?php echo $menuServices[$i]['service_name']; ?></a></li>
                  <?php }
                  } ?>
                </ul>
              </li>
              <li class="nav-item">
                <a class="nav-link <?php if (isset($activeMenu) && $activeMenu == "coupons") {
                                      echo "active";
                                    } ?>" href="<?php echo base_url('coupons.html'); ?>"><?php echo $this->lang->line('coupons'); ?></a>
              </li>
              <li class="nav-item">
                <a class="nav-link <?php if (isset($activeMenu) && $activeMenu == "events") {
                                      echo "active";
                                    } ?>" href="<?php echo base_url('events.html'); ?>"><?php echo $this->lang->line('events'); ?></a>
              </li>
              <li class="nav-item">
                <a class="nav-link <?php if (isset($activeMenu) && $activeMenu == "home-contact-us") {
                                      echo "active";
                                    } ?>" href="<?php echo base_url(HOME_URL); ?>#contact-us"><?php echo $this->lang->line('contact_us'); ?></a>
              </li>
            </ul>

          </div>
        </nav>
      </div>
    </div>
    <!-- END. Mobile Menu -->
  </header>