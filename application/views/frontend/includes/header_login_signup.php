<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://apis.google.com/js/platform.js" async defer></script>
    <meta name="google-signin-client_id" content="<?php echo KEY_GG ?>.apps.googleusercontent.com">
    <title><?php if (!empty($title)) { echo $title;  } ?></title>
    <base data-href="<?php echo site_url(HOME_URL); ?>" id="baseHomeUrl" />
    <?php $this->load->view('frontend/includes/favicon'); ?>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="assets/css/frontend/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/frontend/owl.carousel.min.css" />
    <link rel="stylesheet" href="assets/css/frontend/animate.min.css" />
    <link rel="stylesheet" href="assets/css/frontend/nice-select.min.css" />
    <link rel="stylesheet" href="assets/css/frontend/tempusdominus-bootstrap-4.min.css" />
    <link rel="stylesheet" href="assets/css/frontend/bootstrap-icons.min.css" />
    <link rel="stylesheet" href="assets/css/frontend/main.css?version=<?php echo time(); ?>">
    <link rel="stylesheet" href="assets/css/frontend/edit.css?version=<?php echo time(); ?>">
    <link rel="stylesheet" href="assets/css/frontend/custom.css?version=<?php echo time(); ?>">    
    <link rel="stylesheet" href="assets/vendor/plugins/pnotify/pnotify.custom.min.css"/>
</head>

<body>