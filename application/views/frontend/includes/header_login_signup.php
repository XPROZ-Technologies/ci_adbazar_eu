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
    <link rel="stylesheet" href="assets/css/frontend/bootstrap-icons.min.css" />
    <link rel="stylesheet" href="assets/css/frontend/main.css">
    <link rel="stylesheet" href="assets/css/frontend/edit.css?version=4">
    <?php if (isset($scriptHeader)) outputScript($scriptHeader); ?>
</head>