<!doctype html>
<html lang="en">
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <title>email</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <link href='http://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
</head>
<style>
    .body {
        background: #F5F5F5;overflow: auto; font-family: 'Roboto', sans-serif;
    }
    .logo {
        text-align: center;background: #C20000;padding: 20px 0;width: 640px;margin: 0 auto 16px;
    }
    .content {
        padding: 32px;background: #fff;width: 576px;margin: 0 auto 16px;
    }
    .social {
        text-align: center;background: #C20000;padding: 20px 0;width: 640px;margin: auto;
    font-size: 10px;line-height: 12px;color: #FFFFFF;
    }
    .list-link {
        margin-bottom: 16px;
    }
    .list-link a {
        padding: 0 12px;
    }
    .site-domain {
        margin-bottom: 16px;text-align: center;
    }
    @media only screen and (max-width: 600px) {
        .logo, .content, .social {
            width: 100%;
        }
    }
</style>
<body class="body">
    <div class="logo" style="">
        <img src="<?php echo base_url('assets/img/frontend/logo-email-adb.png'); ?>" alt="">
    </div>
    <div class="content" style="">
        <?php echo $content; ?>
    </div>
    <div class="social" style="">
        <div class="list-link" style="">
            <a href="<?php echo $configs['FACEBOOK_URL']; ?>" style=""> <img src="<?php echo base_url('assets/img/frontend/icon-email1.png'); ?>" alt="Facebook AdBazar"></a>
            <a href="<?php echo $configs['INSTAGRAM_URL']; ?>" style=""> <img src="<?php echo base_url('assets/img/frontend/icon-email2.png'); ?>" alt="Instagram AdBazar"></a>
            <a href="<?php echo $configs['TIKTOK_URL']; ?>" style=""> <img src="<?php echo base_url('assets/img/frontend/icon-email3.png'); ?>" alt="Tiktok AdBazar"></a>
            <a href="<?php echo $configs['TWITTER_URL']; ?>" style=""> <img src="<?php echo base_url('assets/img/frontend/icon-email4.png'); ?>" alt="Twitter AdBazar"></a>
            <a href="<?php echo $configs['PINTEREST_URL']; ?>" style=""> <img src="<?php echo base_url('assets/img/frontend/icon-email5.png'); ?>" alt="Pinterest AdBazar"></a>
        </div>
        <div class="site-domain" style="">
            www.adbazar.eu
        </div>
        <div style="text-align: center;">
            <?php echo $configs['ADDRESS_FOOTER']; ?>
        </div>
    </div>
</body>
</html>