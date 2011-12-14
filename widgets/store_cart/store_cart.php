<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * This is a store module for PyroCMS
 *
 * @author 		pyrocms-store Team - Jaap Jolman - Kevin Meier - Rudolph Arthur Hernandez - Gary Hussey
 * @website		http://www.odin-ict.nl/
 * @package 	pyrocms-store
 * @subpackage 	Store Module
**/
class Widget_Store_cart extends Widgets {

	public $title = array(
		'en' => 'Shopping Cart',
		'nl' => 'Winkel mand',
		'de' => 'Shopping Cart'
	);
	public $description	= array(
		'en' => 'Display the Shopping Cart',
		'nl' => 'Toon de Winkel mand',
		'de' => 'Zeigen Sie die Shopping Cart'
	);
	public $author		= 'Jaap Jolman - Kevin Meier - Rudolph Arthur Hernandez - Gary Hussey';
	public $website		= 'http://www.odin-ict.nl/';
	public $version		= '1.0';
	
	public $fields = array(
	);
	
	public function __construct()
	{
		parent::__construct();
	}
	
	public function form($options)
	{		
		return array(
		);
	}
	public function run($options)
	{
		return	$options;
	}
}