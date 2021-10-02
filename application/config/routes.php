<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'frontend/home';
$route['404_override'] = '';//'user/permission';
$route['translate_uri_dashes'] = FALSE;
//===============================================================
/**
 * BACK-END ROUTES
 */
$route['sys-admin'] = 'backend/user';

// dashboard
$route['sys-admin/dashboard'] = 'backend/dashboard';

// login
$route['sys-admin/login'] = 'backend/user/checkLogin';

// action
$route['sys-admin/action'] = 'backend/action';
$route['sys-admin/action/insert-update'] = 'backend/action/update';
$route['sys-admin/action/delete'] = 'backend/action/delete';

// config
$route['sys-admin/config'] = 'backend/config';
$route['sys-admin/config/abount'] = 'backend/config/abount';
$route['sys-admin/config/update/(:num)'] = 'backend/config/update/$1';
$route['sys-admin/config/change-language-abount'] = 'backend/config/changeLanguageAbount';

// service
$route['sys-admin/service'] = 'backend/service';
$route['sys-admin/service-create'] = 'backend/service/add';
$route['sys-admin/service-update'] = 'backend/service/edit';
$route['sys-admin/service/get-list'] = 'backend/service/getListSelect2Ajax';
$route['sys-admin/service/get-list-service-type'] = 'backend/service/getListServiceTypeSelect2Ajax'; 

// location
$route['sys-admin/location'] = 'backend/location';
$route['sys-admin/location-create'] = 'backend/location/add';
$route['sys-admin/location-update'] = 'backend/location/edit';
$route['sys-admin/location/get-location-not-in-business-profile'] = 'backend/location/getLocationNotInBusinessProfile';

// sider
$route['sys-admin/slider/(:num)'] = 'backend/slider/index';

// staff
$route['sys-admin/staff'] = 'backend/user/staff';
$route['sys-admin/staff-create'] = 'backend/user/add';
$route['sys-admin/staff-update/(:num)'] = 'backend/user/edit/$1';
$route['sys-admin/staff/insert-update'] = 'backend/user/update';
$route['sys-admin/staff/change-status'] = 'backend/user/changeStatus';

// customer
$route['sys-admin/customer'] = 'backend/customer';
$route['sys-admin/customer/get-list'] = 'backend/customer/getListSelect2Ajax';
$route['sys-admin/customer-create'] = 'backend/customer/add';
$route['sys-admin/customer-update/(:num)'] = 'backend/customer/edit/$1';
$route['sys-admin/customer/insert-update'] = 'backend/customer/update';
$route['sys-admin/customer/change-status'] = 'backend/customer/changeStatus'; 

// business-profile
$route['sys-admin/business-profile'] = 'backend/businessprofile';
$route['sys-admin/business-profile-add'] = 'backend/businessprofile/add';
$route['sys-admin/business-profile-update/(:num)'] = 'backend/businessprofile/edit/$1';
$route['sys-admin/business-profile/insert-update'] = 'backend/businessprofile/update';
$route['sys-admin/business-profile/change-status'] = 'backend/businessprofile/changeStatus'; 
$route['sys-admin/business-profile/get-business-profile-not-in-location'] = 'backend/businessprofile/getBusinessProfileNotInLocation'; 
$route['sys-admin/business-profile/is-hot'] = 'backend/businessprofile/isHot'; 

$route['sys-admin/phone-code/get-list'] = 'backend/phonecode/getListSelect2Ajax';

$route['sys-admin/coupon'] = 'backend/coupon';
$route['sys-admin/coupon-create'] = 'backend/coupon/add';
$route['sys-admin/coupon-update/(:num)'] = 'backend/coupon/edit/$1';
$route['sys-admin/coupon/insert-update'] = 'backend/coupon/update'; 
$route['sys-admin/coupon/get-list-business-profile'] = 'backend/coupon/getListSelect2BuinessProfile';
$route['sys-admin/coupon/is-hot'] = 'backend/coupon/isHot';
$route['sys-admin/coupon/change-status'] = 'backend/coupon/changeStatus'; 

//event
$route['sys-admin/event'] = 'backend/event';
$route['sys-admin/event-create'] = 'backend/event/add';
$route['sys-admin/event-update/(:num)'] = 'backend/event/edit/$1';
$route['sys-admin/event/insert-update'] = 'backend/event/update'; 
$route['sys-admin/event/change-status'] = 'backend/event/changeStatus';

/**
 * FRONT-END ROUTES
 */

$route['change-customer-language'] = 'frontend/site/changeLanguage';


$route['customer-login'] = 'frontend/customer/checkLogin';
$route['customer-signup'] = 'frontend/customer/register';
$route['customer-logout'] = 'frontend/customer/logout';
$route['customer-get-coupon'] = 'frontend/customer/customerGetCoupon';
$route['customer-remove-coupon'] = 'frontend/customer/customerRemoveCoupon';
$route['customer-join-event'] = 'frontend/customer/customerJoinEvent';
$route['customer-left-event'] = 'frontend/customer/customerLeftEvent';

//user management
$route['customer/my-coupons'] = 'frontend/customer/my_coupons';
$route['customer/general-information'] = 'frontend/customer/general_information';
$route['customer/change-password'] = 'frontend/customer/change_password';
$route['customer/my-events'] = 'frontend/customer/my_events';

$route['notifications.html'] = 'frontend/notification/index';

$route['login.html'] = 'frontend/login';
$route['signup.html'] = 'frontend/signup';

$route['home'] = 'frontend/home';
$route['term-of-use.html'] = 'frontend/home/term';
$route['privacy-policy.html'] = 'frontend/home/privacy';

//services
$route['services.html'] = 'frontend/service/index';
$route['service/(:any)-(:num)\.html'] = 'frontend/service/detail/$1/$2';

//events
$route['events.html'] = 'frontend/event/index';
$route['event/(:any)-(:num)\.html'] = 'frontend/event/detail/$1/$2';

//coupons
$route['coupons.html'] = 'frontend/coupon/index';
$route['coupon/(:any)-(:num)\.html'] = 'frontend/coupon/detail/$1/$2';


$route['fb-login'] = 'frontend/customer/loginFb';
$route['fb-logout'] = 'frontend/customer/logout';
