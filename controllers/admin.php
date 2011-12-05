<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * This is a store module for PyroCMS
 *
 * @author 		Jaap Jolman And Kevin Meier - pyrocms-store Team
 * @website		http://jolman.eu
 * @package 	PyroCMS
 * @subpackage 	Store Module
**/
class Admin extends Admin_Controller
{
	protected $section = 'store';

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
		$this->data = array();

		if ( ! $this->form_validation->run('store_index') ){
			
			$this->data = array( 
				'general_settings' => $this->store_settings->settings_manager_retrieve('general')->result(),
				'payment_gateways_settings' => $this->store_settings->settings_manager_retrieve('payment-gateways')->result(),
				'extra_settings' => $this->store_settings->settings_manager_retrieve('extra')->result()
			);
			
			$this->template
				->append_metadata($this->load->view('fragments/wysiwyg', $this->data, TRUE))
				->title($this->module_details['name'], lang('store_title_edit_store'))
				->build('admin/store/index',$this->data);
		}
		else{
			
			if ( ! $this->store_settings->settings_manager_store() ){
				$this->session->set_flashdata('success', sprintf(lang('store_messages_edit_success'), $this->input->post('name')));
				redirect('admin/store');
			}
			else
			{
				$this->session->set_flashdata(array('error'=> lang('store_cat_add_error')));
			}		
		}
	}



	

	
}
