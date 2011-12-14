<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * This is a store module for PyroCMS
 *
 * @author 		pyrocms-store Team - Jaap Jolman - Kevin Meier - Rudolph Arthur Hernandez - Gary Hussey
 * @website		http://www.odin-ict.nl/
 * @package 	pyrocms-store
 * @subpackage 	Store Module
**/
	$html='<link href="/'.SHARED_ADDONPATH.'modules/store/css/widget_store_search.css" type="text/css" rel="stylesheet" />';
	$html.='<script type="text/javascript" src="/'.SHARED_ADDONPATH.'modules/store/js/widget_store_search.js"></script>';
	$html.='<div id="widget_store_search">';
	$html .= '</div>';
	print $html;
?>