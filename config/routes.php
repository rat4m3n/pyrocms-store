<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * This is a store module for PyroCMS
 *
 * @author 		pyrocms-store Team - Jaap Jolman - Kevin Meier - Rudolph Arthur Hernandez - Gary Hussey
 * @website		http://www.odin-ict.nl/
 * @package 	pyrocms-store
 * @subpackage 	Store Module
**/

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