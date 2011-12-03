<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * This is a store module for PyroCMS
 *
 * @author 		pyrocms-store Team - Jaap Jolman - Kevin Meier - Rudolph Arthur Hernandez - Gary Hussey
 * @website		http://www.odin-ict.nl/
 * @package 	pyrocms-store
 * @subpackage 	Store Module
**/
class Store_m extends MY_Model {

	public function __construct()
	{		
		parent::__construct();

		$this->_table = array(
			'store_config'					=> 'store_config',
			'store_categories'				=> 'store_categories',
			'store_products'				=> 'store_products',
			'store_tags'					=> 'store_tags',
			'store_products_has_store_tags'	=> 'store_products_has_store_tags',
			'store_attributes'				=> 'store_attributes',
			'store_orders'					=> 'store_orders',
			'store_users_adresses'			=> 'store_users_adresses',
			'store_order_adresses'			=> 'store_order_adresses',
			'core_sites'					=> 'core_sites',
			'core_stores'					=> 'core_stores'
		);
	}

    /**  
	 * Get a specific Store
     * @param int $id
     * @return array 
     */	
	public function get_store() {
		return $this->db->get($this->_table['store_config'])->row();	
	}

    /**
	 * Get all available Stores
     * @return array
     */
	public function get_store_all() {
		return $this->db->get('store_config')->result();
    }	



    /**   
	 * Get number of pending orders in a store
     * @param int $id
     * @return string 
     */		
	public function count_pending_orders(){
		$this->db->where('status', 1); 
		return $this->db->count_all_results('store_orders'); 
	}
    /**   
	 * Get Category Name from product_id
     * @param int $id
     * @return string 
     */		

	
	
	
	private function get_core_site_id($site_ref)
	{
		$this->query = $this->db->query("SELECT * FROM " . $this->_table['core_sites']. " WHERE ref='" . $site_ref . "';");
		foreach($this->query->result() as $this->item)
		{
			return $this->item->id;
		}
	}
	
	public function get_product_in_cart($product)
	{
		$this->db->where('products_id',$product);
		$this->query = $this->db->get('store_products');
		foreach($this->query->result() as $this->product)
		{
			$this->items = array(
				'id' => $this->product->products_id,
				'qty' => $this->input->post('qty'),
				'price' => $this->product->price,
				'name' => $this->product->name,
				'options' => $this->get_product_attributes($this->product->attributes_id)
			);
			return $this->items;
		}
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