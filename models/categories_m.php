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
	
	// get_all(), count_all(), inherited from MY_Model when $_table is set	
	
	
	
	public function make_categories_dropdown($categories_id=0)
	{
		$categories = $this->db->get('store_categories');
		$selected_cat; $parent_cat;
		
		if($categories_id) { 
			$selected_cat = $this->categories_m->get($categories_id);
			$parent_cat = $this->categories_m->get($selected_cat->parent_id);
		} 
		
		if ($categories->num_rows() == 0):
			return array();
		else:
			if(isset($parent_cat) && $parent_cat ){  // if there is a parent category
				// set that as the first in the dropdown
				$this->data = array( $parent_cat->categories_id => $parent_cat->name); 
				
				foreach($categories->result() as $category):
					if( ! ( $parent_cat->name == $category->name || $selected_cat->name == $category->name ) ){
						$this->data[$category->categories_id] = $category->name;
					}
				endforeach;	
			
				return $this->data;
			}
			else {
				$this->data  = array('0'=>'Select');
				foreach($categories->result() as $category):
					if(isset($selected_cat)){
						if( ! ($category->name == $selected_cat->name) ){
							$this->data[$category->categories_id] = $category->name;
						}
					}
					else { 
						$this->data[$category->categories_id] = $category->name;
					}
				endforeach;

				return $this->data;				
			}
		endif;
	}
	
	
	public function add_category()
	{	
		$this->data = $this->input->post();// get all post fields
		array_pop($this->data);// remove the submit button field
		if ($this->db->insert($this->_table, $this->data)){ 
			return $this->db->insert_id(); 
		}
		else { return false; } 
	}
	
	
	
	
}