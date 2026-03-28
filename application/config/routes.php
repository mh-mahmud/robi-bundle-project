<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
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
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = "parent_controller";
$route['confirmation'] = "parent_controller/show_confirmation";

# user authentication
$route['login'] = 'parent_controller/login';
$route['logout'] = 'parent_controller/logout';
$route['change_password'] = 'parent_controller/change_password';
$route['change_password/:any'] = 'parent_controller/change_password';
$route['forgot_password'] = 'parent_controller/forgot_password';

# user management
$route['create_user']='master_controller/create_user';
$route['manage_user']='master_controller/manage_user';
$route['manage_user/:any']='master_controller/manage_user';
$route['create_role']='master_controller/create_role';
$route['manage_role']='master_controller/manage_role';
$route['manage_role/:any']='master_controller/manage_role';

# configuration
$route['create_option']='master_controller/create_option';
$route['manage_option']='master_controller/manage_option';
$route['manage_option/:any']='master_controller/manage_option';
$route['create_service']='master_controller/create_service';
$route['manage_service']='master_controller/manage_service';
$route['manage_service/:any']='master_controller/manage_service';

# bundle
$route['create_bundle']='bundle_controller/create_bundle';
$route['manage_bundle']='bundle_controller/manage_bundle';
$route['manage_bundle/:any']='bundle_controller/manage_bundle';
$route['details_bundle/:any']='bundle_controller/details_bundle';

$route['create_bundle_forecast']='bundle_controller/create_bundle_forecast';
$route['print_bundle_forecast']='bundle_controller/print_bundle_forecast';
$route['bundle_forecast/:any']='bundle_controller/bundle_forecast';
$route['view_forecast_data']='bundle_controller/view_forecast_data';
$route['details_forecast_data/:any']='bundle_controller/details_forecast_data';

$route['upload_sale_batch']='bundle_controller/upload_sale_batch';
$route['manage_sale']='bundle_controller/manage_sale';
$route['manage_sale/:any']='bundle_controller/manage_sale';

$route['upload_sale_individual']='bundle_controller/upload_sale_individual';


# report
$route['fv_allocation']='bundle_controller/fv_allocation';

$route['fv_deferment']='bundle_controller/fv_deferment';
$route['fv_deferment_summary']='bundle_controller/fv_deferment_summary';

$route['fv_summary']='bundle_controller/fv_summary';

$route['individual_jv']='bundle_controller/individual_jv';
$route['summary_jv']='bundle_controller/summary_jv';

$route['recognition_jv']='bundle_controller/recognition_jv';


# $route[':any'] = "parent_controller/index";

/* End of file routes.php */
/* Location: ./application/config/routes.php */