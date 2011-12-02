<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * This is a store module for PyroCMS
 *
 * @author 		Rudolph Arthur Hernandez
 * @package 	PyroCMS
 * @subpackage 	Store Module
 * 
 * 
**/

class Images_m extends MY_Model {

	protected $_table = array(
		'files' => 'files',
		'file_folders' => 'file_folders'	
	);
	protected $folder_id;// id of the folder 'store_images' created on install
	protected $product_images = 'store_product_images';
	protected $category_images = 'store_category_images';
	

	public function __construct()
	{		
		parent::__construct();
		$this->load->library('store_settings');
		$this->_store = $this->store_settings->item('store_id');
		
		$this->load->library('image_lib');
		$this->load->model('files/file_m');
		$this->load->model('files/file_folders_m');
			
	}

	// get_all(), count_all(), inherited from MY_Model when $_table is set	

	

	public function add_image($file, $type='product'){
		
		if($type == 'product'){ $this->folder_exists_create($this->product_images); }
		else { $this->folder_exists_create($this->category_images); }		
		
		if(!$file) { return false; }
		$data = array(
			'folder_id'		=> (int) $this->folder_id,
			'user_id'		=> 1,
			'type'			=> 'i',
			'name'			=> $file['raw_name'],
			'description'	=> $this->input->post('description') ? $this->input->post('description') : '',
			'filename'		=> $file['file_name'],
			'extension'		=> $file['file_ext'],
			'mimetype'		=> $file['file_type'],
			'filesize'		=> $file['file_size'],
			'width'			=> (int) $file['image_width'],
			'height'		=> (int) $file['image_height'],
			'date_added'	=> now()
		);	
		
		return $this->file_m->insert($data) ? $this->db->insert_id() : false;
	}
	
	public function get_image($images_id){
		return $this->db->where('id', $images_id)
							 ->where('type', 'i')->limit(1)->get($this->_table['files'])->row();
	}
	
	public function delete_image($images_id=0, $image_path){
		

		if( ! ($images_id == 0) ) {
			
			// attempt to retrieve any image associated with the product
			$image = $this->get_image($images_id);
			if($image) { // if there is an image
			
			// check for a thumbnail of the image, and remove it.
				$thumb_image_path = $image_path . $image->name . '_thumb' . $image->extension; 
				if(is_file($thumb_image_path)) { unlink($thumb_image_path); }
				
			// check for the original as well, and remove it.
				$orig_image_path = $image_path . $image->filename;				
				if(is_file($orig_image_path)) { unlink($orig_image_path); }
				
			// delete the record of the original image
				return $this->db->where('id', $images_id)
							 	  ->where('type', 'i')->limit(1)->delete($this->_table['files']);	
				
			}
						 	  
		}
		// else do nothing
	}// end delete_image
	
	
	public function create_thumb($source_image_path){
		
		$resize_config['image_library'] = 'gd2';
		$resize_config['source_image']	= $source_image_path;
		$resize_config['create_thumb'] = TRUE;
		$resize_config['maintain_ratio'] = TRUE;
		$resize_config['width']	= 75;		
		$resize_config['height']	= 50;

		$this->image_lib->initialize($resize_config);
		$this->image_lib->resize();			
	}
	
	public function get_thumb_anchor($image, $image_path){
		
		$source_image = $image_path . $image->filename;
		$thumb_image_path = $image_path . $image->name . '_thumb' . $image->extension; 
		
	// if the thumbnail hasn't been created, make it.
		if( ! is_file($thumb_image_path) ) { $this->images_m->create_thumb($source_image); }
										
		$output = '<a href="'. $image_path . $image->filename;
		$output .= '" rel="cbox_images" class="product_images';// for use with colorbox 
		$output .= '" >';
		$output .= '<img src="'. $image_path . $image->name . '_thumb' . $image->extension; 
		$output .= '" class="image_thumbs" alt="' . $image->name;
		$output .= '" /></a>';
		
		return $output;
	}
	
	
	public function folder_exists_create($image_folder_name){
			// check whether our image "folder" already exists.
		if($this->file_folders_m->exists($image_folder_name)){
			$this->folder_id = $this->db->where('name', $image_folder_name)
										 ->limit(1)
										 ->get($this->_table['file_folders'])
										 ->row()->id;
		}
		else { // otherwise make it so
			
			$data = array(
				'parent_id' => 0,
				'slug' => $image_folder_name,
				'name' => $image_folder_name,
				'date_added' => now()			
			);
			$this->db->insert($this->_table['file_folders'], $data);
			$this->folder_id = $this->db->insert_id();
		}	
	}	
	
	
	public function no_image(){
		return "<p class='no_image'>Upload Image</p>";
	}
	
	/////////////////  Categories
	
	

}