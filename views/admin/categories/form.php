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
<?php if ($this->controller == 'admin_categories' && $this->method === 'edit'): ?>
        <h4><?php echo lang('store_categories_title_edit');?></h4>
<?php else: ?>
        <h4><?php echo lang('store_categories_title_add');?></h4>
<?php endif; ?>
</section>

<section class="item">
<?php echo form_open($this->uri->uri_string(), 'class="crud" id="categories"'); ?>

<div class="form_inputs">

	<ul>
		<li class="even">
			<label for="name"><?php echo lang('store_cat_add_name'); ?> <span>*</span></label>
			<div class="input"><?php echo form_input('name',$categories->name,'class="text" maxlength="50"'); ?></div>
		</li>
		<li class="odd">
			<label for="html"><?php echo lang('store_cat_add_html'); ?> <span>*</span></label>
			<div class="input"><?php echo form_textarea('html',$categories->html,'class="wysiwyg-simple" maxlength="1000"'); ?></div>
		</li>
		<li class="even">
			<label for="parent_id"><?php echo lang('store_cat_add_parent_id'); ?> </label>
			<div class="input"><?php echo form_dropdown('parent_id',$dropdown,$categories->parent_id,'class="text" maxlength="10"'); ?></div>
		</li>
		<li class="odd">
			<label for="images_id"><?php echo lang('store_cat_add_images_id'); ?> </label>
			<div class="input"><?php echo form_input('images_id',$categories->images_id,'class="text" maxlength="10"'); ?></div>
		</li>
		<li class="even">
			<label for="thumbnail_id"><?php echo lang('store_cat_add_thumbnail'); ?> </label>
			<div class="input"><?php echo form_input('thumbnail_id',$categories->thumbnail_id,'class="text" maxlength="10"'); ?></div>
		</li>
	</ul>
	
</div>

	<div><?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )); ?></div>

<?php echo form_close(); ?>
</section>