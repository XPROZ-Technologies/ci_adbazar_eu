<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <title>Asia Dragon Bazar</title>
   <title><?php if(!empty($title)){ echo $title; }else{ echo "Asia Dragon Bazar"; } ?></title>
   <base href="<?php echo base_url(); ?>" id="baseUrl"/>
   <?php $this->load->view('frontend/includes/favicon'); ?>
   <link rel="preconnect" href="https://fonts.googleapis.com">
   <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
   <link rel="stylesheet" href="assets/css/frontend/bootstrap.min.css">
   <link rel="stylesheet" href="assets/css/frontend/owl.carousel.min.css"/>
   <link rel="stylesheet" href="assets/css/frontend/animate.min.css"/>
   <link rel="stylesheet" href="assets/css/frontend/nice-select.min.css" />
   <link rel="stylesheet" href="assets/css/frontend/tempusdominus-bootstrap-4.min.css"/>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css" />
   <link rel="stylesheet" href="assets/css/frontend/main.css">
   <link rel="stylesheet" href="assets/css/frontend/edit.css?version=4">
   <?php if (isset($scriptHeader)) outputScript($scriptHeader); ?>
</head>

<body>
    <header class="page-header">
      <!-- Menus -->
      <nav class="navbar navbar-expand-xl">
        <div class="container">
          <a class="navbar-brand" href="<?php echo base_url(HOME_URL); ?>">
            <img src="<?php echo CONFIG_PATH.$configs['LOGO_IMAGE_HEADER']; ?>" alt="<?php echo $configs['TEXT_LOGO_HEADER']; ?>" class="img-fluid">
          </a>
          <div class="header-right-mobile">
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
              <div class="d-flex align-items-center">
                <i class="bi bi-list"></i>
                <!-- <span>Menu</span> -->
              </div>
            </button>
            <div class="d-flex align-items-center d-xl-none">
              <div class="dropdown dropdown-language mx-3">
                <a href="#" class="wrapper-btn dropdown-toggle current" id="languageDropdown" data-bs-toggle="dropdown" aria-expanded="false" value="en">
                  <img src="assets/img/frontend/en.png" alt="english flag" class="img-fluid">
                </a>
                <ul class="dropdown-menu js-list-language" aria-labelledby="languageDropdown">
                  <li class="selected"><a class="dropdown-item" href="#" value="en"><img src="assets/img/frontend/en.png" alt="english flag" class="img-fluid me-2">English</a></li>
                  <li><a class="dropdown-item" href="#" value='vn'><img src="assets/img/frontend/vn.png" alt="vietnam flag" class="img-fluid me-2">Vietnamese</a></li>
                  <li><a class="dropdown-item" href="#" value='ger'><img src="assets/img/frontend/ger.png" alt="germany flag" class="img-fluid me-2">German</a></li>
                  <li><a class="dropdown-item" href="#" value='cre'><img src="assets/img/frontend/cre.png" alt="czech flag" class="img-fluid me-2">Czech</a></li>
                </ul>
              </div>
              <div class="d-flex btn-user">
                <a href="signup.html" title="" class="btn btn-outline-red btn-register">Register</a>
                <a href="signin.html" title="" class="btn btn-red btn-login">Login</a>
              </div>
            </div>
          </div>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
              <li class="nav-item">
                <a class="nav-link <?php if(isset($activeMenu) && $activeMenu == "about-us"){ echo "active"; } ?>" href="#">About Us</a>
              </li>
              <!-- service menu -->
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle <?php if(isset($activeMenu) && $activeMenu == "services"){ echo "active"; } ?>" href="" id="serviceDropdown" role="button" data-bs-toggle="dropdown"
                  aria-expanded="false">
                  Services
                </a>
                <ul class="dropdown-menu" aria-labelledby="serviceDropdown">
                  <li><a class="dropdown-item  <?php if(isset($activeMenuService) && $activeMenuService === 0){ echo "active"; } ?>" href="<?php echo base_url('services.html'); ?>">Services</a></li>
                  <?php if(!empty($menuServices) && count($menuServices) > 0){ for($i = 0; $i < count($menuServices); $i++){ $menuServiceUrl = base_url('service/'.makeSlug($menuServices[$i]['service_slug']).'-'.$menuServices[$i]['id']).'.html'; ?>
                    <li><a class="dropdown-item <?php if(isset($activeMenuService) && $menuServices[$i]['id'] === $activeMenuService){ echo "active"; } ?>" href="<?php echo $menuServiceUrl; ?>"><?php echo $menuServices[$i]['service_name']; ?></a></li>
                  <?php } } ?>
                </ul>
              </li>
              <!-- END - service menu -->
              <li class="nav-item">
                <a class="nav-link <?php if(isset($activeMenu) && $activeMenu == "coupons"){ echo "active"; } ?>" href="<?php echo base_url('coupons.html'); ?>">Coupons</a>
              </li>
              <li class="nav-item">
                <a class="nav-link <?php if(isset($activeMenu) && $activeMenu == "events"){ echo "active"; } ?>" href="<?php echo base_url('events.html'); ?>">Events</a>
              </li>
              <li class="nav-item">
                <a class="nav-link <?php if(isset($activeMenu) && $activeMenu == "contact-us"){ echo "active"; } ?>" href="<?php echo base_url(HOME_URL); ?>#contact-us">Contact us</a>
              </li>
            </ul>
            <!-- navbar right -->
            <div class="d-flex align-items-center navbar-right">
              
    
              <div class="dropdown dropdown-language mx-3">
                <a href="#" class="wrapper-btn dropdown-toggle current" id="languageDropdown" data-bs-toggle="dropdown" aria-expanded="false" value="en">
                  <?php if(isset($currentLangId) && ($currentLangId == 1 || $currentLangId == $this->Mconstants->languageDefault)){ ?><img src="assets/img/frontend/en.png" alt="English" class="img-fluid"><?php } ?>
                  <?php if(isset($currentLangId) && ($currentLangId == 2 || $currentLangId == $this->Mconstants->languageDefault)){ ?><img src="assets/img/frontend/cre.png" alt="Czech Republic" class="img-fluid"><?php } ?>
                  <?php if(isset($currentLangId) && ($currentLangId == 3 || $currentLangId == $this->Mconstants->languageDefault)){ ?><img src="assets/img/frontend/ger.png" alt="Germany" class="img-fluid"><?php } ?>
                  <?php if(isset($currentLangId) && ($currentLangId == 4 || $currentLangId == $this->Mconstants->languageDefault)){ ?><img src="assets/img/frontend/vn.png" alt="Việt Nam" class="img-fluid"><?php } ?>
                </a>
                <ul class="dropdown-menu js-list-language" aria-labelledby="languageDropdown">
                  <li class="<?php echo $customer['language_id'] == 1 ? 'selected':''; ?>"><a class="dropdown-item change-customer-language" href="javascript:void(0)" value="en" data-language-id="1"><img src="assets/img/frontend/en.png" alt="english flag" class="img-fluid me-2" >English</a></li>
                  <li class="<?php echo $customer['language_id'] == 4 ? 'selected':''; ?>"><a class="dropdown-item change-customer-language" href="javascript:void(0)" value='vn' data-language-id="4"><img src="assets/img/frontend/vn.png" alt="vietnam flag" class="img-fluid me-2" >Vietnamese</a></li>
                  <li class="<?php echo $customer['language_id'] == 3 ? 'selected':''; ?>"><a class="dropdown-item change-customer-language" href="javascript:void(0)" value='ger' data-language-id="3"><img src="assets/img/frontend/ger.png" alt="germany flag" class="img-fluid me-2" >German</a></li>
                  <li class="<?php echo $customer['language_id'] == 2 ? 'selected':''; ?>"><a class="dropdown-item change-customer-language" href="javascript:void(0)" value='cre' data-language-id="2"><img src="assets/img/frontend/cre.png" alt="czech flag" class="img-fluid me-2" >Czech</a></li>
                </ul>
              </div>
              <div class="d-flex btn-user">
                <a href="<?php echo base_url('signup.html'); ?>" title="" class="btn btn-outline-red btn-register">Register</a>
                <a href="<?php echo base_url('login.html'); ?>" title="" class="btn btn-red btn-login">Login</a>
              </div>
             
            </div>
            <!-- END. navbar right -->
          </div>
        </div>
      </nav>
      
      <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
        <div class="offcanvas-header">
          <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
          <nav class="navbar navbar-expand">
              <div class="collapse navbar-collapse">
                <ul class="navbar-nav-xl">
                 
                  <li class="nav-item">
                    <a class="nav-link <?php if(isset($activeMenu) && $activeMenu == "about-us"){ echo "active"; } ?>" href="<?php echo base_url('about-us.html'); ?>">About Us</a>
                  </li>
                  <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle  <?php if(isset($activeMenu) && $activeMenu == "services"){ echo "active"; } ?>" href="#" id="serviceDropdown" role="button" data-bs-toggle="dropdown"
                      aria-expanded="false">
                      Services
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="serviceDropdown">
                      <li><a class="dropdown-item  <?php if(isset($activeMenuService) && $activeMenuService === 0){ echo "active"; } ?>" href="<?php echo base_url('services.html'); ?>">Services</a></li>
                      <?php if(!empty($menuServices) && count($menuServices) > 0){ for($i = 0; $i < count($menuServices); $i++){ $menuServiceUrl = base_url('service/'.makeSlug($menuServices[$i]['service_slug']).'-'.$menuServices[$i]['id']).'.html'; ?>
                        <li><a class="dropdown-item <?php if(isset($activeMenuService) && $activeMenuService === $menuServices[$i]['id']){ echo "active"; } ?>" href="<?php echo $menuServiceUrl; ?>"><?php echo $menuServices[$i]['service_name']; ?></a></li>
                      <?php } } ?>
                    </ul>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link <?php if(isset($activeMenu) && $activeMenu == "coupons"){ echo "active"; } ?>" href="<?php echo base_url('coupons.html'); ?>">Coupons</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link <?php if(isset($activeMenu) && $activeMenu == "events"){ echo "active"; } ?>" href="<?php echo base_url('events.html'); ?>">Events</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link <?php if(isset($activeMenu) && $activeMenu == "contact-us"){ echo "active"; } ?>" href="<?php echo base_url(); ?>#contact-us">Contact us</a>
                  </li>
                </ul>
             
              </div>
          </nav>
        </div>
      </div>
      <input type="text" hidden="hidden" id="changeCustomerLangUrl" value="<?php echo base_url('change-customer-language'); ?>">
      <!-- END - Menus -->
    </header>