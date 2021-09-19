<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <title>Asia Dragon Bazar</title>
   <title><?php echo $title; ?></title>
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
      <nav class="navbar navbar-expand-xl">
        <div class="container">
          <a class="navbar-brand" href="#">
            <img src="assets/img/frontend/footer-logo.svg" alt="logo image" class="img-fluid">
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
                <a class="nav-link active" aria-current="page" href="index.html">Homepage</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">About Us</a>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="" id="serviceDropdown" role="button" data-bs-toggle="dropdown"
                  aria-expanded="false">
                  Services
                </a>
                <ul class="dropdown-menu" aria-labelledby="serviceDropdown">
                  <li><a class="dropdown-item" href="customer-service.html">Services</a></li>
                  <li><a class="dropdown-item" href="customer-service-list.html">Beauty Salons</a></li>
                  <li><a class="dropdown-item active" href="#">Restaurants</a></li>
                  <li><a class="dropdown-item" href="#">Shops</a></li>
                  <li><a class="dropdown-item" href="#">Casinos</a></li>
                  <li><a class="dropdown-item" href="#">Hotels</a></li>
                  <li><a class="dropdown-item" href="#">Pharmacies</a></li>
                  <li><a class="dropdown-item" href="#">Others</a></li>
                </ul>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="customer-coupon.html">Coupons</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="customer-event.html">Events</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Contact us</a>
              </li>
            </ul>
            <!-- navbar right -->
            <div class="d-flex align-items-center navbar-right">
              
    
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
                    <a class="nav-link " aria-current="page" href="index.html">Homepage</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#">About Us</a>
                  </li>
                  <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle active" href="#" id="serviceDropdown" role="button" data-bs-toggle="dropdown"
                      aria-expanded="false">
                      Services
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="serviceDropdown">
                      <li><a class="dropdown-item" href="customer-service.html">Services</a></li>
                      <li><a class="dropdown-item" href="customer-service-list.html">Beauty Salons</a></li>
                      <li><a class="dropdown-item active" href="#">Restaurants</a></li>
                      <li><a class="dropdown-item" href="#">Shops</a></li>
                      <li><a class="dropdown-item" href="#">Casinos</a></li>
                      <li><a class="dropdown-item" href="#">Hotels</a></li>
                      <li><a class="dropdown-item" href="#">Pharmacies</a></li>
                      <li><a class="dropdown-item" href="#">Others</a></li>
                    </ul>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="customer-coupon.html">Coupons</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="customer-event.html">Events</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#">Contact us</a>
                  </li>
                </ul>
             
              </div>
          </nav>
        </div>
      </div>
    </header>