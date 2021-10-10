<!doctype html>
<html lang="en">
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <title>email</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <link href='http://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
</head>
<style>
</style>
<body style="background: #F5F5F5;overflow: auto; font-family: 'Roboto', sans-serif;">
    <div style="text-align: center;background: #C20000;padding: 20px 0;width: 640px;margin: 0 auto 16px;">
        <img src="<?php echo base_url('assets/img/frontend/e-logo.png'); ?>" alt="">
    </div>
    <div style="padding: 32px;background: #fff;width: 576px;margin: 0 auto 16px;">
        <?php echo $content; ?>
    </div>
    <div style="text-align: center;background: #C20000;padding: 20px 0;width: 640px;margin: auto;
    font-size: 10px;line-height: 12px;color: #FFFFFF;">
        <div style="margin-bottom: 16px;">
            <a href="<?php echo $configs['FACEBOOK_URL']; ?>" style="padding: 0 12px;"> <img src="<?php echo base_url('assets/img/frontend/icon-email1.png'); ?>" alt="Facebook AdBazar"></a>
            <a href="<?php echo $configs['INSTAGRAM_URL']; ?>" style="padding: 0 12px;"> <img src="<?php echo base_url('assets/img/frontend/icon-email2.png'); ?>" alt="Instagram AdBazar"></a>
            <a href="<?php echo $configs['TIKTOK_URL']; ?>" style="padding: 0 12px;"> <img src="<?php echo base_url('assets/img/frontend/icon-email3.png'); ?>" alt="Tiktok AdBazar"></a>
            <a href="<?php echo $configs['TWITTER_URL']; ?>" style="padding: 0 12px;"> <img src="<?php echo base_url('assets/img/frontend/icon-email4.png'); ?>" alt="Twitter AdBazar"></a>
            <a href="<?php echo $configs['PINTEREST_URL']; ?>" style="padding: 0 12px;"> <img src="<?php echo base_url('assets/img/frontend/icon-email5.png'); ?>" alt="Pinterest AdBazar"></a>
        </div>
        <div style="margin-bottom: 16px;text-align: center;">
            www.adbazar.eu
        </div>
        <div style="text-align: center;">
            <?php echo $configs['ADDRESS_FOOTER']; ?>
        </div>
    </div>
</body>
</html>