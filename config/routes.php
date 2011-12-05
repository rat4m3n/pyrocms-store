<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
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
| 	www.your-site.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://www.codeigniter.com/user_guide/general/routing.html
*/

// admin
$route['store/admin/categories(/:any)?']	= 'admin_categories$1';
$route['store/admin/products(/:any)?']		= 'admin_products$1';

// admin list products
$route['store/admin/preview_product(/:any)?'] = 'store/product$1';
$route['store/admin/edit_product(/:any)?'] = 'admin_products/edit$1';
$route['store/admin/delete_product(/:any)?'] = 'admin_products/delete$1';

// admin list categories
$route['store/admin/preview_category(/:any)?'] = 'store/category$1';
$route['store/admin/edit_category(/:any)?'] = 'admin_categories/edit$1';
$route['store/admin/delete_category(/:any)?'] = 'admin_categories/delete$1';

$route['store/admin/category(/:any)?'] = 'admin_products/category_products$1';
