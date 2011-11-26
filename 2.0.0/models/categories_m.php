<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * This is a store module for PyroCMS
 *
 * @author 		Jaap Jolman And Kevin Meier - pyrocms-store Team
 * @website		http://jolman.eu
 * @package 	PyroCMS
 * @subpackage 	Store Module
**/
class Categories_m extends MY_Model {

	protected $_table		=	'store_categories';
	protected $primary_key	=	'categories_id';
	protected $_store;

	public function __construct()
	{		
		parent::__construct();
		
		$this->load->library('store_settings');
		$this->_store = $this->store_settings->item('store_id');
	}
	
	public function make_categories_dropdown()
	{
		$this->query = $this->db->get('store_categories');
		if ($this->query->num_rows() == 0):

			return array();

		else:

			$this->data  = array('0'=>'Select');
			foreach($this->query->result() as $this->row):

				$this->data[$this->row->categories_id] = $this->row->name;

			endforeach;

			return $this->data;
			
		endif;

	}
}