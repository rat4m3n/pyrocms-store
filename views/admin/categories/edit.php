<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * This is a store module for PyroCMS
 *
 * @author 		Jaap Jolman And Kevin Meier - pyrocms-store Team
 * @website		http://jolman.eu
 * @package 	PyroCMS
 * @subpackage 	Store Module
 *
 * added and modified by Rudolph Arthur Hernandez - 11/27/2011
**/
?>


    <section class="title">
        <h4><?php echo lang('store_title_edit_category');?></h4>
    </section>

<section class="item">
	<?php echo form_open_multipart($this->uri->uri_string(), 'class="crud"'); ?>
	<div>
		<ol>
			<li class="<?php echo alternator('even', ''); ?>">
				<?php echo lang('store_cat_add_name','name'); ?>
				<?php echo form_input('name',set_value('name',$category->name),'class="text" maxlength="50"'); ?>
				<span class="required-icon tooltip"><?php echo lang('required_label');?></span>
            </li>
            <li class="<?php echo alternator('even', ''); ?>">
                <?php echo lang('store_cat_add_html','html'); ?>
                <?php echo form_textarea('html',set_value('html',$category->html),'class="wysiwyg-simple" maxlength="1000"'); ?>
                <span class="required-icon tooltip"><?php echo lang('required_label');?></span>
            </li>
            
            <li class="<?php echo alternator('even', ''); ?>">
                <?php echo lang('store_cat_add_parent_id','parent_id'); ?>
                <?php echo form_dropdown('parent_id',$dropdown,'class="text" maxlength="10"'); ?>
                
            </li>
            <li class="<?php echo alternator('even', ''); ?>">
                <?php echo lang('store_cat_add_images_id','images_id'); ?>
					<?php 
						if(isset($category->image)){ echo $category->image; }
					?>
					<?php echo form_upload('userfile'); ?>

            </li>
            <li class="<?php echo alternator('even', ''); ?>">
                <?php echo lang('store_cat_add_thumbnail','thumbnail_id'); ?>
                <?php echo form_input('thumbnail_id', set_value('thumbnail_id', $category->thumbnail_id),'class="text" maxlength="10"'); ?>
                
            </li>
        </ol>
        <div class="buttons float-right padding-top">
            <?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )); ?>
        </div>
    </div>
	<?php echo form_close(); ?>
</section>