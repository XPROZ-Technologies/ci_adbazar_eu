<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <meta name="format-detection" content="telephone=no"> 
        <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=no;">
        <meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=EDGE" />
        <title>email</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <link href='http://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
        <style type="text/css">
            .body {
                background: #F5F5F5;overflow: auto; font-family: 'Roboto', sans-serif;
            }
            .logo {
                text-align: center;background: #C20000;padding: 20px 0;width: 640px;margin: 0 auto 16px;
            }
            .content {
                padding: 32px;background: #fff;margin: 0 auto 16px;text-align: justify;
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
    </head>
    <body style="background: #F5F5F5;overflow: auto; font-family: 'Roboto', sans-serif;">
        <table width="100%">
            <tbody>
                <tr>
                    <td align="center" width="640" style="max-width: 100%">
                        <table class="logo" cellpadding="0" cellspacing="0" width="640">
                            <tbody>
                                <tr>
                                    <td><img src="https://adbazar.eu/assets/img/frontend/logo-email-adb.png" alt=""></td>
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
                                        <?php echo $content; ?>
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
                                        <a href="<?php echo $configs['FACEBOOK_URL']; ?>"> <img src="https://adbazar.eu/assets/img/frontend/icon-email1.png" alt="Facebook AdBazar"></a>
                                        <a href="<?php echo $configs['INSTAGRAM_URL']; ?>"> <img src="https://adbazar.eu/assets/img/frontend/icon-email2.png" alt="Instagram AdBazar"></a>
                                        <a href="<?php echo $configs['TIKTOK_URL']; ?>"> <img src="https://adbazar.eu/assets/img/frontend/icon-email3.png" alt="Tiktok AdBazar"></a>
                                        <a href="<?php echo $configs['TWITTER_URL']; ?>"> <img src="https://adbazar.eu/assets/img/frontend/icon-email4.png" alt="Twitter AdBazar"></a>
                                        <a href="<?php echo $configs['PINTEREST_URL']; ?>"> <img src="https://adbazar.eu/assets/img/frontend/icon-email5.png" alt="Pinterest AdBazar"></a>
                                    </td>
                                    
                                </tr>
                                <tr class="site-domain">
                                    <td><p>www.adbazar.eu</p></td>
                                </tr>
                                <tr>
                                    <td style="text-align: center;"><?php echo $configs['ADDRESS_FOOTER']; ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
    </body>
</html>