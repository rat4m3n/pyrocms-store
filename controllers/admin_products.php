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
		$this->load->model('store_m');
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
		
		$id = $this->store_settings->item('store_id');
		$this->sql = $this->store_m->list_products($id);

		$this->data = array(
			'sql'	=>	$this->sql
		);
		
		$this->template->build('admin/list_products', $this->data);
	}
	
	public function add()
	{
		
		$id = $this->store_settings->item('store_id');
		$this->validation_rules = array(
				array('field' => 'name',					'label' => 'store_product_add_name',					'rules' => 'trim|max_length[50]|required'),
				array('field' => 'html',					'label' => 'store_product_add_html',					'rules' => 'trim|max_length[1000]|required'),
				array('field' => 'categories_id',			'label' => 'store_product_add_categories_id',			'rules' => 'trim|max_length[10]|required'),
				array('field' => 'images_id',				'label' => 'store_product_add_images_id',				'rules' => 'trim|max_length[10]|'),
				array('field' => 'thumbnail_id',			'label' => 'store_product_add_thumbnail_id',			'rules' => 'trim|max_length[10]|'),
				array('field' => 'config_id',				'label' => 'store_product_add_store_config_id',			'rules' => 'trim|max_length[10]|'),
				array('field' => 'products_id',				'label' => 'store_product_add_store_products_id',		'rules' => 'trim|max_length[10]|'),
				array('field' => 'attributes_id',			'label' => 'store_product_add_store_attributes_id',		'rules' => 'trim|max_length[10]|'),
				array('field' => 'meta_description',		'label' => 'store_product_add_meta_description',		'rules' => 'trim|max_length[1000]|'),
				array('field' => 'meta_keywords',			'label' => 'store_product_add_meta_keywords',			'rules' => 'trim|max_length[1000]|'),
				array('field' => 'price',					'label' => 'store_product_add_price',					'rules' => 'trim|max_length[10]|required'),
				array('field' => 'stock',					'label' => 'store_product_add_stock',					'rules' => 'trim|max_length[10]|'),
				array('field' => 'limited',					'label' => 'store_product_add_limited',					'rules' => 'trim|max_length[10]|'),
				array('field' => 'limited_used',			'label' => 'store_product_add_limited_used',			'rules' => 'trim|max_length[10]|'),
				array('field' => 'discount',				'label' => 'store_product_add_discount',				'rules' => 'trim|max_length[10]|'),
				array('field' => 'images_id',				'label' => 'store_product_add_images_id',				'rules' => 'trim|max_length[10]|'),
				array('field' => 'thumbnail_id',			'label' => 'store_product_add_thumbnail_id',			'rules' => 'trim|max_length[10]|'),
				array('field' => 'allow_comments',			'label' => 'store_product_add_allow_comments',			'rules' => 'trim|max_length[10]|required')
		);

		$this->form_validation->set_rules($this->validation_rules);
		if ($this->form_validation->run()==FALSE)
		{
			$this->template
				->append_metadata($this->load->view('fragments/wysiwyg', $this->data, TRUE))
				->build('admin/add_product', $this->data);
		}
		else
		{
			if ($this->store_m->add_product()==TRUE)
			{
				$this->session->set_flashdata('success', sprintf(lang('store_product_add_success'), $this->input->post('name')));
				redirect('admin/store');
			}
			else
			{
				$this->session->set_flashdata(array('error'=> lang('store_product_add_error')));
			}
		}
	}
}
