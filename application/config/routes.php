<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'admin';
$route['404_override'] = 'admin/page404';
$route['translate_uri_dashes'] = FALSE;

$route[LOGIN_URL] = 'admin/login';
$route[ADMIN_URL . '/logout'] = 'admin/logout';
$route[ADMIN_URL .'/dashboard'] = 'admin';

$route[ADMIN_URL .'/add-category'] = 'admin/add_category';
$route[ADMIN_URL .'/all-categories'] = 'admin/category';
$route[ADMIN_URL .'/edit-category/(:num)'] = 'admin/edit_category/$1';

$route[ADMIN_URL .'/add-opportunity'] = 'admin/add_opportunity';
$route[ADMIN_URL .'/all-opportunities'] = 'admin/opportunity_new';//opportunity';
$route[ADMIN_URL .'/edit-opportunity/(:num)'] = 'admin/edit_opprotunity/$1';

$route[ADMIN_URL .'/import'] = 'admin/import';
$route[ADMIN_URL .'/jd-import'] = 'admin/jd_import';

$route[ADMIN_URL . '/dlt'] = 'admin/dlt';
$route[ADMIN_URL . '/publish-job'] = 'admin/publish_post';

$route[ADMIN_URL . '/data-import'] = 'admin/data_import';
$route[ADMIN_URL .'/opportunities-temp'] = 'admin/opportunity_temp';
$route[ADMIN_URL .'/edit-opportunity-temp/(:num)'] = 'admin/edit_opprotunity_temp/$1';

$route[ADMIN_URL .'/publish-opportunity'] = 'admin/publish_opportunity';
$route[ADMIN_URL .'/post-updates'] = 'admin/post_updates';

$route[ADMIN_URL . '/manual-import'] = 'admin/manual_import';


// DEMO
$route[ADMIN_URL . '/demo-unpublished'] = 'Demo';
$route[ADMIN_URL . '/demo-published'] = 'Demo/published';


$route[ADMIN_URL . '/add-foreign-key'] = 'Demo/add_foreign_key';
$route[ADMIN_URL .'/check-post'] = 'admin/checkJob';