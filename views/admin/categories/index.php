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
	<h4><?php echo lang('store_categories_title_index')?></h4>
</section>

<section class="item">
	
	<?php if ($categories): ?>

		<?php echo form_open('admin/store/categories/delete'); ?>
    
        <table border="0" class="table-list">
            <thead>
                <tr>
                    <th width="20"><?php echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all')); ?></th>
                    <th><?php echo lang('store_categories_header_thumbnail'); ?></th>
                    <th><?php echo lang('store_categories_header_name'); ?></th>
                    <th><?php echo lang('store_categories_header_category_id'); ?></th>
                    <th><?php echo lang('store_categories_header_parent'); ?></th>
                    <th width="320" class="align-center"><span><?php echo lang('store_categories_header_actions'); ?></span></th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <td colspan="7">
                        <div class="inner"><?php $this->load->view('admin/partials/pagination'); ?></div>
                    </td>
                </tr>
            </tfoot>
            <tbody>
                <?php foreach($categories as $category): ?>
                    <tr>
                        <td><?php echo form_checkbox('action_to[]', $category->categories_id); ?></td>
                        <td><?php echo $category->thumbnail_id; ?></td>
                        <td><?php echo $category->name; ?></td>
                        <td><?php echo $category->categories_id; ?></td>
                        <td><?php echo $category->parent_id; ?></td>
						<td class="align-center buttons buttons-small">
                            <?php echo anchor('admin/store/categories/edit/' . $category->categories_id, lang('global:edit'), 'class="button edit"'); ?>
                            <?php echo anchor('admin/store/categories/delete/' . $category->categories_id, lang('global:delete'), 'class="confirm button delete"'); ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>

		<div class="table_action_buttons">
		<?php $this->load->view('admin/partials/buttons', array('buttons' => array('delete') )); ?>
		</div>

		<?php echo form_close(); ?>

	<?php else: ?>
		<div class="no_data"><?php echo lang('store_categories_messages_information_no_categories'); ?></div>
	<?php endif; ?>
</section>