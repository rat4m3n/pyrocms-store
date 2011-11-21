<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * This is a store module for PyroCMS
 *
 * @author 		Jaap Jolman And Kevin Meier - pyrocms-store Team
 * @website		http://jolman.eu
 * @package 	PyroCMS
 * @subpackage 	Store Module
**/
class Admin_categories extends Admin_Controller
{
	protected $section = 'categories';

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
		$this->sql = $this->store_m->list_categories($id);

		$this->data = array(
			'sql'	=>	$this->sql
		);
		
		$this->template->build('admin/list_categories', $this->data);
	}

	public function add()
	{
		$id = $this->store_settings->item('store_id');
		$this->validation_rules = array(
				array('field' => 'name',					'label' => 'store_cat_add_name',					'rules' => 'trim|max_length[50]|required'),
				array('field' => 'html',					'label' => 'store_cat_add_html',					'rules' => 'trim|max_length[1000]|required'),
				array('field' => 'parent_id',				'label' => 'store_cat_add_parent_id',				'rules' => 'trim|max_length[10]|'),
				array('field' => 'images_id',				'label' => 'store_cat_add_images_id',				'rules' => 'trim|max_length[10]|'),
				array('field' => 'thumbnail_id',			'label' => 'store_cat_add_thumbnail_id',			'rules' => 'trim|max_length[10]|'),
				array('field' => 'store_store_id',			'label' => 'store_cat_add_store_store_id',			'rules' => 'trim|max_length[10]|')
		);

		$this->form_validation->set_rules($this->validation_rules);
		if ($this->form_validation->run()==FALSE)
		{
			if($id){$this->data->parent_id = $id;}else{$this->data->parent_id = '';}
			$this->data->categories = $this->store_m->make_categories_dropdown();
			
			$this->template
				->append_metadata($this->load->view('fragments/wysiwyg', $this->data, TRUE))
				->build('admin/add_category', $this->data);	
		}
		else
		{
			if ($this->store_m->add_category()==TRUE)
			{
				$this->session->set_flashdata('success', sprintf(lang('store_cat_add_success'), $this->input->post('name')));
				redirect('admin/store');
			}
			else
			{
				$this->session->set_flashdata(array('error'=> lang('store_cat_add_error')));
			}
		}
	}
}
