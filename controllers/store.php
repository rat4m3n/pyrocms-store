<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * This is a store module for PyroCMS
 *
 * @author 		Jaap Jolman And Kevin Meier - pyrocms-store Team
 * @website		http://jolman.eu
 * @package 	PyroCMS
 * @subpackage 	Store Module
**/
class Store extends Public_Controller
{

	public function __construct(){

		parent::__construct();

		// Load the required classes
		$this->load->library('cart');
		
		// load required models
		$this->load->model('store_m');
		$this->load->model('categories_m');		
		$this->load->model('products_m');

		$this->load->language('store');
		$this->load->library('store_settings');
		$this->load->helper('date');
		
		$this->template->append_metadata(css('store.css', 'store'))
						->append_metadata(js('store.js', 'store'));
	}

	// display the categories of the store
	public function index(){
		$categories = $this->categories_m->get_all();
		$this->data = array( 'categories' =>	$categories );
		$this->template->build('index', $this->data);
	}
	
	// display the products associated with the category id
	public function category($categories_id){
		$products = $this->products_m->get_products($categories_id);
		$this->data = array( 'products'	=>	$products );
		$this->template->build('category', $this->data);
	}
	
	// display specific product given by $products_id
	public function product($products_id){
		$product = $this->products_m->get_product($products_id);
		$this->data = array( 'product' =>	$product );
		$this->template->build('product', $this->data);
	}
	
	public function show_cart(){

		$this->data = array(
			''	=>	''
		);
		
		$this->template->build('cart', $this->data);
	}
	
	public function checkout_cart(){
		$this->store_m->build_order();
	}
	
	public function update_cart(){
		$this->redirect = $this->input->post('redirect');
		$this->data = $this->input->post();
		$this->cart->update($this->data);
		redirect($this->redirect);
	}
	
	public function insert_cart($product){
		$this->redirect = $this->input->post('redirect');
		$this->data = $this->store_m->get_product_in_cart($product);
		$this->cart->insert($this->data);
		redirect($this->redirect);
	}
}