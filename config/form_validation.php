<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

$config = array(

	'store_index'=> array(	// validation rules for store index (admin) form	
			array('field' => 'name',
					'label' => 'lang:store_field_name',
					'rules' => 'trim|max_length[50]|required' ),
					
			array('field' => 'email',
					'label' => 'lang:store_field_email',
					'rules' => 'trim|max_length[100]|required|valid_email' ),
					
			array('field' => 'additional_emails',
					'label' => 'lang:store_field_additional_emails',	
					'rules' => 'trim|max_length[100]|valid_emails' ),
					
			array('field' => 'currency',
					'label' => 'lang:store_field_currency',
					'rules' => 'trim|max_length[10]|required|is_natural_no_zero') ,
					
			array('field' => 'item_per_page',
					'label' => 'lang:store_field_item_per_page',
					'rules' => 'trim|max_length[10]|required' ),
					
			array('field' => 'show_with_tax',
					'label' => 'lang:store_field_show_with_tax',
					'rules' => 'required'),
					
			array('field' => 'display_stock',
					'label' => 'lang:store_field_display_stock',
					'rules' => 'required' ),
					
			array('field' => 'allow_comments',
					'label' => 'lang:store_field_allow_comments',
					'rules' => 'required'),
					
			array('field' => 'new_order_mail_alert',
					'label' => 'lang:store_field_new_order_mail_alert',
					'rules' => 'required'),
					
			array('field' => 'active',
					'label' => 'lang:store_field_active',
					'rules' => 'required'),
					
			array('field' => 'terms_and_conditions',
					'label' => 'lang:store_field_agb',
					'rules' => 'required'),
					
			array('field' => 'privacy_policy',
					'label' => 'lang:store_field_privacy_policy',
					'rules' => 'required'),
					
			array('field' => 'delivery_information',
					'label' => 'lang:store_field_delivery_information',
					'rules' => 'required')
				
		),// end store_index
		
	'add_category' => array(// validation rules for admin/add_category
			array('field' => 'name',
					'label' => 'store_cat_add_name',
					'rules' => 'trim|max_length[50]|required' ),
					
			array('field' => 'html',
					'label' => 'store_cat_add_html',
					'rules' => 'trim|max_length[1000]|required' ),
					
			array('field' => 'parent_id',
					'label' => 'store_cat_add_parent_id',
					'rules' => 'trim|max_length[10]|' ),
					
			array('field' => 'images_id',
					'label' => 'store_cat_add_images_id',
					'rules' => 'trim|max_length[10]|' ),
					
			array('field' => 'thumbnail_id',
					'label' => 'store_cat_add_thumbnail_id',
					'rules' => 'trim|max_length[10]|' ),
					
			array('field' => 'store_store_id',
					'label' => 'store_cat_add_store_store_id',
					'rules' => 'trim|max_length[10]|' )
	
		),// end add_category
		
	'add_product' => array( // validation rules for admin/add_product
			array('field' => 'name', 
					'label' => 'store_product_add_name', 
					'rules' => 'trim|max_length[50]|required'),
					
			array('field' => 'html', 
					'label' => 'store_product_add_html', 
					'rules' => 'trim|max_length[1000]|required'),
					
			array('field' => 'categories_id', 
					'label' => 'store_product_add_categories_id', 
					'rules' => 'trim|max_length[10]|required'),
					
			array('field' => 'images_id', 
					'label' => 'store_product_add_images_id',
					'rules' => 'trim|max_length[10]|'),
					
			array('field' => 'thumbnail_id',
					'label' => 'store_product_add_thumbnail_id',
					'rules' => 'trim|max_length[10]|'),
					
			array('field' => 'config_id',
					'label' => 'store_product_add_store_config_id',
					'rules' => 'trim|max_length[10]|'),
					
			array('field' => 'products_id',
					'label' => 'store_product_add_store_products_id',
					'rules' => 'trim|max_length[10]|'),
					
			array('field' => 'attributes_id',
					'label' => 'store_product_add_store_attributes_id',
					'rules' => 'trim|max_length[10]|'),
					
			array('field' => 'meta_description',
					'label' => 'store_product_add_meta_description',
					'rules' => 'trim|max_length[1000]|'),
					
			array('field' => 'meta_keywords',
					'label' => 'store_product_add_meta_keywords',
					'rules' => 'trim|max_length[1000]|'),
					
			array('field' => 'price',
					'label' => 'store_product_add_price',
					'rules' => 'trim|max_length[10]|required'),
					
			array('field' => 'stock',
					'label' => 'store_product_add_stock',
					'rules' => 'trim|max_length[10]|'),
			
			array('field' => 'limited',
					'label' => 'store_product_add_limited',
					'rules' => 'trim|max_length[10]|'),
					
			array('field' => 'limited_used',
					'label' => 'store_product_add_limited_used',
					'rules' => 'trim|max_length[10]|'),
					
			array('field' => 'discount',
					'label' => 'store_product_add_discount',
					'rules' => 'trim|max_length[10]|'),

			array('field' => 'images_id',
					'label' => 'store_product_add_images_id',
					'rules' => 'trim|max_length[10]|'),
					
			array('field' => 'thumbnail_id',
					'label' => 'store_product_add_thumbnail_id',
					'rules' => 'trim|max_length[10]|'),
					
			array('field' => 'allow_comments',
					'label' => 'store_product_add_allow_comments',
					'rules' => 'trim|max_length[10]|required')
					
		)// end add_product
);

?>