<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * This is a store module for PyroCMS
 *
 * @author 		pyrocms-store Team - Jaap Jolman - Kevin Meier - Rudolph Arthur Hernandez - Gary Hussey
 * @website		http://www.odin-ict.nl/
 * @package 	pyrocms-store
 * @subpackage 	Store Module
**/
class Categories_m extends MY_Model {

	protected $_table		=	'store_categories';
	protected $primary_key	=	'categories_id';
	protected $_store;
	protected $images_path = 'uploads/store/categories/';

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
	
	
	public function add_category($new_image_id)
	{	
		$this->data = $this->input->post();// get all post fields
		array_pop($this->data);// remove the submit button field
		unset($this->data['userfile']);
		
		if ($new_image_id) { $this->data['images_id'] = $new_image_id; }
		
		return $this->db->insert($this->_table, $this->data) ? $this->db->insert_id() : false;  
	}
	
	
	/*  Function: update_category */
	public function update_category($categories_id, $new_image_id=0)
	{
		$this->data = $this->input->post();// get all post fields
		array_pop($this->data);// remove the submit button field
		unset($this->data['userfile']);
		
		if ( ! ($new_image_id == 0 ) ) { 

			$category = $this->get_category($categories_id);
				
			$this->images_m->delete_image($category->images_id, $this->images_path);

			$this->data['images_id'] = $new_image_id; 
		}
				
		return $this->db->where('categories_id', $categories_id)
							 ->update($this->_table, $this->data);		
	}
	
	
	public function get_category($categories_id)
	{
		return $this->db->where('categories_id', $categories_id)->limit(1)->get($this->_table)->row();
	}

	public function get_category_by_name($category_name)
	{
		return $this->db->where('name', $category_name)->limit(1)->get($this->_table)->row();
	}


	public function delete_category($categories_id){

		$category = $this->get_category($categories_id);// get the product
		
		$this->images_m->delete_image($category->images_id, $this->images_path);
		
		// then delete record in table
		return $this->db->where('categories_id', $categories_id)->delete($this->_table);
	}	



	public function get_category_name($categories_id){
		return $this->db->where('categories_id', $categories_id)
							 ->limit(1)
							 ->get($this->_table)
							 ->row();
	}	









	
	
}