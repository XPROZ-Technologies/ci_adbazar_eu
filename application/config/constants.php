<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS')        OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code

//common
define('STATUS_FREE_TRIAL', 0);
define('STATUS_ACTIVED', 2);
define('STATUS_NUMBER_ONE', 1);
define('STATUS_NUMBER_THREE', 3);
define('STATUS_NUMBER_FOR', 4);
define('NO_IMAGE', 'no_image.png');
define('DEFAULT_LIMIT', 20);
define('LIMIT_PER_PAGE', 10);
define('DEFAULT_LIMIT_BUSINESS_PROFILE', 10);
define('DEFAULT_LIMIT_BUSINESS_PROFILE_MAP', 4);
define('DEFAULT_LIMIT_COUPON', 50);
define('DEFAULT_LIMIT_NOTIFICATION', 10);
//define('API_VERSION', '1.0');
//message
define('ERROR_COMMON_MESSAGE', 'An error occurred during execution');
define('ERROR_NO_DATA', 'Data does not exist');
//path
define('HOME_URL', '');
define('ROOT_PATH', dirname($_SERVER['SCRIPT_NAME']) . '/');
define('USER_PATH', 'assets/uploads/users/');
define('CUSTOMER_PATH', 'assets/uploads/customers/');
define('FILE_PATH', 'assets/uploads/files/');
define('SLIDER_PATH', 'assets/uploads/sliders/');
define('CONFIG_PATH', 'assets/uploads/configs/');
define('SERVICE_PATH', 'assets/uploads/services/');
define('BUSINESS_PROFILE_PATH', 'assets/uploads/busines_profile/');
define('REVIEW_PATH', 'assets/uploads/reviews/');
define('COUPONS_PATH', 'assets/uploads/coupons/');
define('EVENTS_PATH', 'assets/uploads/events/');
define('BUSINESS_PROFILE_URL', '');
define('PRODUCT_PATH', 'assets/uploads/products/');


define('DEFAULT_IMG', '');

define('URL_API', '');

// key api
define('KEY_GOOGLE_MAP', 'AIzaSyDNrnR2a_Hy-BBcCo1hMXvxa9vuzNsDSxE');
define('KEY_YOUTUBE_V3', 'AIzaSyAWR3oe6AzQfm3k_XYuwm-_wvjmQkq2ylg');
define('KEY_GG', '1001160309619-f30jgqido5nq8v2nt3gbdd0d7pr5hp7c');

// lat and lng map admin
define('LAT_MAP_ADMIN', 50.0473111);
define('LNG_MAP_ADMIN', 12.3523245);
define('ZOOM_MAP_ADMIN', 17);


//email default
define('EMAIL_FROM', 'server@adbazar.eu');
define('EMAIL_FROM_NAME', 'AdBazar.eu');

// //email server
// define('EMAIL_USER', 'server@adbazar.eu');
// define('EMAIL_PASS', 'changeM3!!Adbazar12345');
// define('EMAIL_HOST', 'ssl://smtpout.asia.secureserver.net');
// define('EMAIL_PORT', '465');

//email server
define('EMAIL_USER', 'mailout.dkh@gmail.com');
define('EMAIL_PASS', 'fqvpygxkmeotvqfz');
define('EMAIL_HOST', 'ssl://smtp.googlemail.com');
define('EMAIL_PORT', '465');

//paypal
define('PAYPAL_CLIENT_KEY', 'AQjmozIDkpBmPkl3Pkgv2qlRWKSAr2Sq1e3C_X0J2A4Iv_PLZcjrD6_5PFPNDasoUjF21_0s8TDN6gjX');
define('PAYPAL_SEC_KEY', 'EJm5Up0WU7u3KJdO9NfwWVDzB0tVf8LUF1v3eLspA9gQVx83XKSxRCS83uIyQa9iX2JqBK3t7Xh1O1P3');
define('PAYPAL_HOST', 'https://api-m.sandbox.paypal.com');
define('PAYPAL_PROD_ID', 'PROD-4NX43137GP917693J');
define('PAYPAL_PLAN_DEFAULT', 'P-8L942028P24070304MGAB6XY');

// GOOGLE CREDENTIAL
define('GOOGLE_SECRET', 'b82BAjvFggoRlQ2LBRrofhxl');
define('FACEBOOK_ID', '177851481129433');
define('FACEBOOK_SECRET', 'abea49b547059b4008edad2f8c2fc0b5');
define('GRAPH_version', 'v2.5');