<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * This is a store module for PyroCMS
 *
 * @author 		pyrocms-store Team - Jaap Jolman - Kevin Meier - Rudolph Arthur Hernandez - Gary Hussey
 * @website		http://www.odin-ict.nl/
 * @package 	pyrocms-store
 * @subpackage 	Store Module
**/
	$html='<link href="/'.SHARED_ADDONPATH.'modules/store/css/widget_store_cart.css" type="text/css" rel="stylesheet" />';
	$html.='<script type="text/javascript" src="/'.SHARED_ADDONPATH.'modules/store/js/widget_store_cart.js"></script>';
	$html.='<div id="widget_store_cart">';
	if($this->cart->contents())
	{
		$html .= form_open('/store/update_cart/')."\n";
		$html .= form_hidden('redirect', current_url());
		$html .= '	<div id="widget_contents">'."\n";
		$html .= '		<div id="widget_header_qty">'.$this->lang->line('store_label_widget_cart_qty').'</div>'."\n";
		$html .= '		<div id="widget_header_name">'.$this->lang->line('store_label_widget_cart_name').'</div>'."\n";
		$html .= '		<ul id="widget_cart_list">'."\n";
		
		$i=1;
		foreach($this->cart->contents() as $items)
		{
			$html .= '			'.form_hidden($i.'[rowid]', $items['rowid'])."\n";
			$html .= '			<li class="widget_cart_items">'."\n";
			$html .= '				<div class="widget_cart_item_qty">'.form_input(array(
																													'name'		=> $i.'[qty]',
																													'value'		=> $items['qty'],
																													'maxlength'	=> '3',
																													'class'		=> 'widget_input_qty')
																												).'</div>'."\n";
			$html .= '				<div class="widget_cart_item_name">'.$items['name'].'</div>'."\n";
			$html .= '			</li>'."\n";
			
			$i++;
		}
		$html .= '		</ul>'."\n";
	
		$html .= '	</div>'."\n";
		$html .= '	<div id="widget_cart_controls">'."\n";
		$html .= '		'.anchor('/store/show_cart/','&nbsp;','class="" id="widget_button_details"')."\n";
		$html .= '		'.form_submit('','','id="widget_button_update"')."\n";
		$html .= '	</div>'."\n";
		$html .= '	'.form_close()."\n";
	}
	else
	{
		$html .= $this->lang->line('store_label_widget_cart_empty');
	}
	$html .= '</div>';
	print $html;
?>