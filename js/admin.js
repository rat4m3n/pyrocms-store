/**
 * This is a store module for PyroCMS
 *
 * @author 		pyrocms-store Team - Jaap Jolman - Kevin Meier - Rudolph Arthur Hernandez - Gary Hussey
 * @website		http://www.odin-ict.nl/
 * @package 	pyrocms-store
 * @subpackage 	Store Module
**/

$(document).ready(function(){

	$('a.edit_product').colorbox({ 
		transition: 'none', 
		//rel: 'edit', 
		//width:'70%', 
		//height: '90%',
		current: "edit page {current} of {total}",
		speed: 0,
		scrolling: false
		//fastIframe: false
	 	
	 });

	$('a.product_images').colorbox({
		transition: 'none',
		rel: 'cbox_images',
		current: "{current} of {total} products",
		//height: '90%', // better usability with w&h.
		//width:'70%'
	});


});