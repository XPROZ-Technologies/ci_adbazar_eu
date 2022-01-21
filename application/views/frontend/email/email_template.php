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
        padding: 32px;background: #fff;margin: 0 auto 16px;
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
<body style="background: #F5F5F5;overflow: auto; font-family: 'Roboto', sans-serif;">
    <div style="text-align: center;background: #C20000;padding: 20px 0;width: 640px;margin: 0 auto 16px;">
        <img src="<?php echo base_url('assets/img/frontend/logo-email-adb.png'); ?>" alt="">
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

    <table width="100%">
        <tbody>
            <tr>
                <td align="center" width="640">
                    <table class="logo" cellpadding="0" cellspacing="0" width="640">
                        <tbody>
                            <tr>
                                <td><img src="http://adb-local.com/assets/img/frontend/logo-email-adb.png" alt=""></td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td align="center" width="640">
                    <table class="content" cellpadding="0" cellspacing="0" width="640">
                        <tbody>
                            <tr>
                                <td>
                                    <p style="margin-bottom:32px;font-weight:bold;font-size:20px;line-height:24px;text-align:center">Password assistance</p>
                                    <p>Hello ,</p>
                                    <p>We have received your request to change your password. 
                                    Please click the button below to set up your new password. 
                                    If you did not make this request, please reach out to us immediately.</p>
                                    <p>Best,<br>AdBazar.</p>
                                    <div style="text-align:center;margin-top:32px">
                                        <a href="https://adb.xproz.com/password-assistance?token=6ab70547-c003-43dc-87ba-124de85b2015" style="background:#c20000;font-style:normal;font-weight:500;font-size:18px;line-height:21px;text-decoration:inherit;border-radius:2px;padding:10px 20px;color:#fff" target="_blank" data-saferedirecturl="https://www.google.com/url?q=https://adb.xproz.com/password-assistance?token%3D6ab70547-c003-43dc-87ba-124de85b2015&amp;source=gmail&amp;ust=1642825700218000&amp;usg=AOvVaw3T6ktaFdNZk5tJNrtPSyvF">Reset Password</a>
                                    </div> 
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td align="center" width="640">
                    <table class="social" cellpadding="0" cellspacing="0" width="640">
                        <tbody>
                            <tr class="list-link">
                                <td>
                                    <a href="#" style=""> <img src="http://adb-local.com/assets/img/frontend/icon-email1.png" alt="Facebook AdBazar"></a>
                                    <a href="#" style=""> <img src="http://adb-local.com/assets/img/frontend/icon-email2.png" alt="Instagram AdBazar"></a>
                                    <a href="#" style=""> <img src="http://adb-local.com/assets/img/frontend/icon-email3.png" alt="Tiktok AdBazar"></a>
                                    <a href="#" style=""> <img src="http://adb-local.com/assets/img/frontend/icon-email4.png" alt="Twitter AdBazar"></a>
                                    <a href="#" style=""> <img src="http://adb-local.com/assets/img/frontend/icon-email5.png" alt="Pinterest AdBazar"></a>
                                </td>
                                
                            </tr>
                            <tr class="site-domain">
                                <td>www.adbazar.eu</td>
                            </tr>
                            <tr>
                                <td style="text-align: center;">Svatý Kříž 281, 35002 Cheb, Czech Republic</td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
</body>
</html>