<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * This is a store module for PyroCMS
 *
 * @author 		pyrocms-store Team - Jaap Jolman - Kevin Meier - Rudolph Arthur Hernandez - Gary Hussey
 * @website		http://www.odin-ict.nl/
 * @package 	pyrocms-store
 * @subpackage 	Store Module
**/
class Admin_products extends Admin_Controller
{
	protected $section = 'products';
	protected $upload_config;
	protected $upload_path = 'uploads/store/products/';

	public function __construct()
	{
		parent::__construct();

		// Load all the required classes
		$this->load->model('categories_m');		
		$this->load->model('products_m');
		$this->load->model('images_m');
		$this->load->library('form_validation');
		$this->load->library('store_settings');
		$this->load->language('store');
		$this->load->helper('date');
		
		// added to install.  this can be removed, just let upload path be set to products
		if (is_dir($this->upload_path) OR @mkdir($this->upload_path,0777,TRUE)){
			$this->upload_config['upload_path'] = './'. $this->upload_path;
		}
		else { $this->upload_config['upload_path'] = './uploads/store/'; }

		$this->upload_config['allowed_types'] = 'gif|jpg|png';
		$this->upload_config['max_size']	= '1024';
		$this->upload_config['max_width'] = '1024';
		$this->upload_config['max_height'] = '768';		
		
		
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

	// tack on the individual images here (if any)
		foreach ($products as $product){

			$image = $this->images_m->get_image($product->images_id); 	
							
			if($image){
				$source_image_path = $this->upload_config['upload_path'] . $image->filename;
				$this->images_m->create_thumb($source_image_path);								
				$output = '<a href="uploads/store/products/' . $image->filename;
				$output .= '" rel="cbox_images" class="product_images';// for use with colorbox 
				$output .= '" >';
				$output .= '<img class="products" src="uploads/store/products/' . $image->name . '_thumb' . $image->extension; 
				$output .= '" alt="' . $image->name;
				$output .= '" /></a>';
				$product->image = $output;
			}	
			
			$category = $this->categories_m->get_category_name($product->categories_id);
			if($category) { $product->category_name = $category->name; }
		}

		$this->data = array(
			'products'	=>	$products
		);
		
		$this->template->build('admin/products/index', $this->data);
	}
	
	
	// modified by Rudolph Arthur to upload images.
	public function add()
	{
		$id = $this->store_settings->item('store_id');
		$this->load->model('images_m');
		
		$this->load->library('upload', $this->upload_config);		

		if ( $this->form_validation->run('add_product')  )
		{
			if ($this->upload->do_upload('userfile')) {
				$image_file = $this->upload->data();
				if ($image_file) {
					$new_image_id = $this->images_m->add_image($image_file, 'product');
				}
			}
			else { $new_image_id = 0; }
			
			// add the product to the database
			if ( $this->products_m->add_product($new_image_id) )
			{
				$this->session->set_flashdata('success', sprintf(lang('store_product_add_success'), $this->input->post('name')));
				redirect('admin/store/products');
			}
			else
			{
				$this->session->set_flashdata(array('error'=> lang('store_product_add_error')));
			}
		}
		else
		{
			$this->data = array( 'categories' => $this->products_m->make_categories_dropdown(0) );
			$this->template
				->append_metadata($this->load->view('fragments/wysiwyg', $this->data, TRUE))
				->build('admin/products/add', $this->data);						
		}
	}// end add()

	
	/**
	 * Edit a product, specified by an ID.
	 *
	 * @param integer $products_id The row's ID
	 * @return none
	 * @author Rudolph Arthur Hernandez
	 */
	public function edit($products_id, $ajax=false)
	{
		$this->load->model('images_m');
		$this->load->library('upload', $this->upload_config);	

		// if validation is good, and the upload went without a hitch
		if ( $this->form_validation->run('add_product') )
		{
			if ($this->upload->do_upload('userfile')) {
				$image_file = $this->upload->data();
				if ($image_file) {
					$new_image_id = $this->images_m->add_image($image_file, 'product');
				}
			}
			else { $new_image_id = 0; }
			
			// update
			if ( $this->products_m->update_product($products_id, $new_image_id) )
			{
				$this->session->set_flashdata('success', sprintf(lang('store_product_add_success'), $this->input->post('name')));
				$product = $this->products_m->get_product($products_id);
				$category_name = $this->categories_m->get_category($product->categories_id)->name;
				$route = 'admin/store/category/' . str_replace(' ', '-', $category_name);		
				redirect($route);
			}
			else
			{
				$this->session->set_flashdata(array('error'=> lang('store_product_add_error')));
			}
		}
		else
		{
			// else setup edit page
			$product = $this->products_m->get_product($products_id);
			$product_image = $this->images_m->get_image($product->images_id);
			if($product_image){
				$source_image_path = $this->upload_config['upload_path'] . $product_image->filename;
				$this->images_m->create_thumb($source_image_path);
			}
								
			$categories = $this->products_m->make_categories_dropdown($product->categories_id);
			
			$this->data = array( 
				'product' => $product,
				'product_image' => $product_image,
				'categories' => $categories				
			);
			
			if( ! $ajax ) {
				$this->template
				->append_metadata($this->load->view('fragments/wysiwyg', $this->data, TRUE))
				->build('admin/products/edit', $this->data);						
			}
			else { 
				//$output = $this->load->view('fragments/wysiwyg', $this->data, TRUE);
				$output = $this->load->view('admin/products/edit', $this->data, true);
				echo $output;
			}			
		}
	}// end edit()	
	

	public function delete($products_id){
		$this->products_m->delete_product($products_id);		
		redirect('admin/store/products');
	}
	
	
	
	
	
	public function category_products($category_name) { // view a single category
	
		$category_name = str_replace('-', ' ', $category_name);
		$category = $this->categories_m->get_category_by_name($category_name);
		
		if($category){
			// get the products associated with the category
			$products = $this->products_m->get_products($category->categories_id);
			foreach ($products as $product){
				$image = $this->images_m->get_image($product->images_id); 				
				if($image){ 
					$product->image = $this->images_m->get_thumb_anchor($image, 'uploads/store/products/'); 
				}					
			}
			
			$this->data = array( 
				'category' => $category,
				'section_title' => lang('store_title_list_products') . '&nbsp&nbsp-&nbsp&nbsp' . ucfirst($category->name),
				'products' => $products
			);
			
			$this->template
			//->append_metadata($this->load->view('fragments/wysiwyg', '', TRUE))
								->build('admin/products/index_category', $this->data);
		}
		else { redirect('admin/store/categories'); }
		
	}	
	
	
////////////////


	
}
