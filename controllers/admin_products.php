<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * This is a store module for PyroCMS
 *
 * @author 		Jaap Jolman And Kevin Meier - pyrocms-store Team
 * @website		http://jolman.eu
 * @package 	PyroCMS
 * @subpackage 	Store Module
**/
class Admin_products extends Admin_Controller
{
	protected $section = 'products';

	public function __construct()
	{
		parent::__construct();

		// Load all the required classes
		$this->load->model('products_m');
		$this->load->library('form_validation');
		$this->load->library('store_settings');
		$this->load->language('store');
		$this->load->helper('date');
		
		// We'll set the partials and metadata here since they're used everywhere
		$this->template->set_partial('shortcuts', 'admin/partials/shortcuts')
						->append_metadata(js('admin.js', 'store'))
						->append_metadata(css('admin.css', 'store'));
	}
	
	public function index()
	{
		$this->load->model('store_m');// for now
		$store_id = $this->store_settings->item('store_id');
		$products = $this->products_m->get_all();

		$this->data = array(
			'products'	=>	$products
		);
		
		$this->template->build('admin/products/index', $this->data);
	}
	
	public function add()
	{
		$id = $this->store_settings->item('store_id');

		if ( ! $this->form_validation->run('add_product') )
		{
			$this->data = array( 'categories' => $this->products_m->make_categories_dropdown(0) );
			$this->template
				->append_metadata($this->load->view('fragments/wysiwyg', $this->data, TRUE))
				->build('admin/products/add', $this->data);
		}
		else
		{
			if ( $this->products_m->add_product() )
			{
				$this->session->set_flashdata('success', sprintf(lang('store_product_add_success'), $this->input->post('name')));
				redirect('admin/store/products');
			}
			else
			{
				$this->session->set_flashdata(array('error'=> lang('store_product_add_error')));
			}
		}
	}// end add()

	
	/**
	 * Edit a product, specified by an ID.
	 *
	 * @param integer $products_id The row's ID
	 * @return none
	 * @author Rudolph Arthur Hernandez
	 */
	public function edit($products_id)
	{
		$product = $this->products_m->get_product($products_id);

		if ( ! $this->form_validation->run('add_product') )
		{
			$categories = $this->products_m->make_categories_dropdown($product->categories_id);
			$this->data = array( 'categories' => $categories, 'product' => $product );
			$this->template
				->append_metadata($this->load->view('fragments/wysiwyg', $this->data, TRUE))
				->build('admin/products/edit', $this->data);
		}
		else
		{
			if ( $this->products_m->update_product($products_id) )
			{
				$this->session->set_flashdata('success', sprintf(lang('store_product_add_success'), $this->input->post('name')));
				redirect('admin/store/products');
			}
			else
			{
				$this->session->set_flashdata(array('error'=> lang('store_product_add_error')));
			}
		}
	}// end edit()	
	
	public function delete($products_id){
		$this->products_m->delete_product($products_id);		
		redirect('admin/store/products');
	}
	
}
