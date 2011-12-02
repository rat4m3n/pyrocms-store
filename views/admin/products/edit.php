<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * This is a store module for PyroCMS
 *
 * @author 		Jaap Jolman And Kevin Meier - pyrocms-store Team
 * @website		http://jolman.eu
 * @package 	PyroCMS
 * @subpackage 	Store Module
**/
?>

<section class="title">
	<h4><?php echo lang('store_title_edit_product');?></h4>
</section>

<section class="item">
<?php echo form_open_multipart($this->uri->uri_string(), 'class="crud"'); ?>

<div>
	<ol>
		<li class="<?php echo alternator('even', ''); ?>">
			<?php echo lang('store_product_add_category_id','categories_id'); ?>
			<?php echo form_dropdown('categories_id', $categories ,'class="text" maxlength="50"'); ?>
			<span class="required-icon tooltip"><?php echo lang('required_label');?></span>
		</li>	
		<li class="<?php echo alternator('even', ''); ?>">
			<?php echo lang('store_product_add_name','name'); ?>
			<?php echo form_input('name',set_value('name', $product->name),'class="text" maxlength="50"'); ?>
			<span class="required-icon tooltip"><?php echo lang('required_label');?></span>
		</li>
		<li class="<?php echo alternator('even', ''); ?>">
			<?php echo lang('store_product_add_html','html'); ?>
			<span class="required-icon tooltip"><?php echo lang('required_label');?></span>			
			<?php echo form_textarea('html',set_value('html', $product->html),'class="wysiwyg-simple" maxlength="1000" rows="7"'); ?>
		</li>

		<li class="<?php echo alternator('even', ''); ?>">
			<?php echo lang('store_product_add_meta_description','meta_description'); ?>
			<?php echo form_textarea('meta_description', 
											set_value('meta_description',$product->meta_description),
											' class="" maxlength="1000" rows="3"');?>
		</li>
		<li class="<?php echo alternator('even', ''); ?>">
			<?php echo lang('store_product_add_meta_keywords','meta_keywords'); ?>
			<?php echo form_input('meta_keywords',set_value('meta_keywords',$product->meta_keywords),
										 'class="text" maxlength="50"'); ?>
		</li>
		<li class="<?php echo alternator('even', ''); ?>">
			<?php echo lang('store_product_add_attributes_id','attributes_id'); ?>
			<?php echo form_input('attributes_id',set_value('attributes_id',$product->attributes_id),'class="text" maxlength="50"'); ?>
		</li>		
		<li class="<?php echo alternator('even', ''); ?>">
			<?php echo lang('store_product_add_price','price'); ?>
			<?php echo form_input('price',set_value('price',$product->price),'class="text" maxlength="10"'); ?>
			<span class="required-icon tooltip"><?php echo lang('required_label');?></span>
		</li>
		<li class="<?php echo alternator('even', ''); ?>">
			<?php echo lang('store_product_add_discount','discount'); ?>
			<?php echo form_input('discount',set_value('discount',$product->discount),'class="text" maxlength="10"'); ?>
		</li>	
		<li class="<?php echo alternator('even', ''); ?>">
			<?php echo lang('store_product_add_stock','stock'); ?>
			<?php echo form_input('stock',set_value('stock',$product->stock),'class="text" maxlength="10"'); ?>
		</li>
		<li class="<?php echo alternator('even', ''); ?>">
			<?php echo lang('store_product_add_limited','limited'); ?>
			<?php echo form_input('limited',set_value('limited',$product->limited),'class="text" maxlength="10"'); ?>
		</li>
		<li class="<?php echo alternator('even', ''); ?>">
			<?php echo lang('store_product_add_limited_used','limited_used'); ?>
			<?php echo form_input('limited_used',set_value('limited_used',$product->limited_used),'class="text" maxlength="10"'); ?>
		</li>
		<li class="<?php echo alternator('even', ''); ?>">
			<?php echo lang('store_product_add_images_id','images_id'); ?>
<!-- 			<?php echo form_input('images_id',set_value('images_id',$product->images_id),'class="text" maxlength="10"'); ?> -->
			<?php 
				if($product_image){
					$output = '<a href="uploads/store/products/' . $product_image->filename . '"';
					$output .= ' rel="cbox_images" class="product_images"  >';
					$output .= '<img src="uploads/store/products/' . $product_image->name . '_thumb'. $product_image->extension;
					$output .= '" alt="' . $product_image->name . '" /></a>';
					echo $output;
				}
			?>
			<?php echo form_upload('userfile'); ?>
		</li>		
		<li class="<?php echo alternator('even', ''); ?>">
			<?php echo lang('store_product_add_thumbnail','thumbnail_id'); ?>
			<?php echo form_input('thumbnail_id',set_value('thumbnail_id',$product->thumbnail_id),'class="text" maxlength="10"'); ?>			
		</li>
		<li class="<?php echo alternator('even', ''); ?>">
			<?php echo lang('store_product_add_allow_comments','allow_comments'); ?>
         <?php echo form_radio('allow_comments','1',TRUE).$this->lang->line('store_radio_yes'); ?>
         <?php echo form_radio('allow_comments','0',FALSE).$this->lang->line('store_radio_no'); ?>
		</li>		
	</ol>
	<div class="buttons float-right padding-top">
		<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )); ?>
	</div>
</div>

<?php echo form_close(); ?>
</section>
<!-- <?php $this->load->view('fragments/wysiwyg', ''); ?> -->