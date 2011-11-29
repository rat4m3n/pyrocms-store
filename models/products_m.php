<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * This is a store module for PyroCMS
 *
 * @author 		Jaap Jolman And Kevin Meier - pyrocms-store Team
 * @website		http://jolman.eu
 * @package 	PyroCMS
 * @subpackage 	Store Module
 * 
 * Modified by : Rudolph Arthur Hernandez (11/27/2011)
**/

class Products_m extends MY_Model {

	protected $_table		=	'store_products';

	public function __construct()
	{		
		parent::__construct();
		$this->load->library('store_settings');
		$this->_store = $this->store_settings->item('store_id');		
	}

	// get_all(), count_all(), inherited from MY_Model when $_table is set	
	
	public function update_product($products_id)
	{
		$this->data = $this->input->post();// get all post fields
		array_pop($this->data);// remove the submit button field
		$this->db->where('products_id', $products_id);
		return $this->db->update($this->_table, $this->data);		
	}
	
	public function add_product()
	{
		$this->data = $this->input->post();// get all post fields
		array_pop($this->data);// remove the submit button field
		if ($this->db->insert($this->_table, $this->data)){
			return $this->db->insert_id();
		}
		else return false;
	}
	
	public function delete_product($products_id){
		return $this->db->where('products_id', $products_id)->delete($this->_table);
	}	
	
	
	/**
	 * Make categories dropdown for products pages, specified by an ID.
	 *
	 * @param integer $selected_id
	 * @return array $data of category objects
	 * @author Rudolph Arthur Hernandez
	 */
	public function make_categories_dropdown($selected_id=0){
      
      $this->load->model('categories_m');
      $categories = $this->db->get('store_categories');
      if($selected_id) { $selected_cat = $this->categories_m->get($selected_id); }
      
      if ($categories->num_rows() == 0) { return array(); }
      else {
      	if(isset($selected_cat)){ $data  = array( $selected_cat->categories_id => $selected_cat->name); }
      	else { $data  = array('0'=>'Select'); }
      	
      	// now go through the rest, excluding the selected cat (if any)
         foreach($categories->result() as $category){
         	if(isset($selected_cat)){
         		if(! ($selected_cat->name == $category->name) ){
             		$data[$category->categories_id] = $category->name;
             	}
            }
            else { $data[$category->categories_id] = $category->name; }
         }
         return $data;      	 	
      }
   }	
	
	
	public function get_products($categories_id)
	{
		return $this->db->where('categories_id', $categories_id)->get($this->_table)->result();
	}
	
	public function get_product($products_id)
	{
		return $this->db->where('products_id', $products_id)->limit(1)->get($this->_table)->row();
	}
	
	public function get_product_in_cart($products_id)
	{
		$product = $this->db->where('products_id', $products_id)
								  ->limit(1)								  
								  ->get('store_products')->row();
								  
		$this->items = array(
				'id'      => $product->products_id,
				'qty'     => $this->input->post('qty'),
				'price'   => $product->price,
				'name'    => $product->name,
				'options' => $this->get_product_attributes($product->attributes_id)
		);
		return $this->items;
		
	}
	
	public function get_product_attributes($attributes)
	{
		$this->db->where('attributes_id',$attributes);
		$this->query = $this->db->get('store_attributes');
		
		foreach($this->query->result() as $this->attribute)
		{
			$this->result = array();
			$this->items = explode("|", $this->attribute->html);
			
			foreach($this->items as $this->item)
			{
				$this->temp = explode("=", $this->item);
				$this->result[$this->temp[0]] = $this->temp[1];
			}
			
			return $this->result;
		}
	}
	
	public function build_order()
	{
		$this->data = array(
			'users_id'			=>	$this->user->id,
			'invoice_nr'		=>	rand(1, 100),
			'ip_address'		=>	$this->input->ip_address(),
			'telefone'			=>	'0',
			'status'			=>	'0',
			'comments'			=>	'0',
			'date_added'		=>	mdate("%Y-%m-%d %H:%i:%s",time()),
			'date_modified'		=>	mdate("%Y-%m-%d %H:%i:%s",time()),
			'payment_address'	=>	'0',
			'shipping_address'	=>	'0',
			'payment_method'	=>	'0',
			'shipping_method'	=>	'0',
			'tax'				=>	'0',
			'shipping_cost'		=>	'0',
		);
		
		$this->db->insert('store_orders',$this->data);
		$this->order_id = $this->db->insert_id();
		
		foreach($this->cart->contents() as $items)
		{
			$this->data = array(
				'orders_id'		=>	$this->order_id,
				'users_id'		=>	$this->user->id,
				'products_id'	=>	$items['id'],
				'number'		=>	$items['qty']
			);
			$this->db->insert('store_orders_has_store_products',$this->data);
		}
		
		redirect('/store/checkout/process/' . $this->input->post('gateway') . '/' . $this->order_id . '/');
	}
	
	public function ipn_paypal_success($orders_id)
	{
	}
	
	public function ipn_paypal_failure($orders_id,$ipn_data)
	{
	}
	
	public function ipn_authorize_success($orders_id)
	{
	}
	
	public function ipn_authorize_failure($orders_id,$ipn_data)
	{
	}
	
	public function ipn_twoco_success($orders_id)
	{
	}
	
	public function ipn_twoco_failure($orders_id,$ipn_data)
	{
	}
	
	public function get_order($orders_id)
	{
		$this->db->where('orders_id',$orders_id);
		$this->query = $this->db->get('store_orders_has_store_products');
		return $this->query;
	}
	
	public function get_orders_product_name($orders_id)
	{
		$this->db->where('orders_id',$orders_id);
		$this->db->limit(1);
		$this->orders = $this->db->get('store_orders_has_store_products');
		foreach($this->orders->result() as $this->order)
		{
			$this->db->where('products_id',$this->order->products_id);
			$this->products = $this->db->get('store_products');
			foreach($this->products->result() as $this->product)
			{
				return $this->product->name;
			}
		}
	}
	
	public function get_orders_product_price($orders_id)
	{
		$this->db->where('orders_id',$orders_id);
		$this->db->limit(1);
		$this->orders = $this->db->get('store_orders_has_store_products');
		foreach($this->orders->result() as $this->order)
		{
			$this->db->where('products_id',$this->order->products_id);
			$this->products = $this->db->get('store_products');
			foreach($this->products->result() as $this->product)
			{
				return $this->product->price;
			}
		}
	}
	
	public function get_orders_users($users_id)
	{
		$this->db->where('id',$users_id);
		$this->db->limit(1);
		$this->query = $this->db->get('users');
		foreach($this->query->result() as $this->item)
		{
			return $this->item->username;
		}
	}
}