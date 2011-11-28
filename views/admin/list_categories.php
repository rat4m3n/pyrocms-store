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
<h3><?php echo lang('store_title_list_category')?></h3>

<?php if ($sql): ?>

	<?php echo form_open('admin/store/list_categories'); ?>

	<table border="0" class="table-list">
		<thead>
			<tr>
				<th width="20"><?php echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all')); ?></th>
				<th><?php echo lang('store_categories_list_thumbnail'); ?></th>
				<th><?php echo lang('store_categories_list_name'); ?></th>
				<th><?php echo lang('store_categories_list_category_id'); ?></th>
				<th><?php echo lang('store_categories_list_parent'); ?></th>
				<th width="320" class="align-center"><span><?php echo lang('store_categories_list_actions'); ?></span></th>
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
			<?php foreach($sql->result() as $this->category) { ?>
				<tr>
					<td><?php echo form_checkbox('action_to[]', $this->category->categories_id); ?></td>
					<td><?php echo $this->category->thumbnail_id; ?></td>
					<td><?php echo $this->category->name; ?></td>
					<td><?php echo $this->category->categories_id; ?></td>
					<td><?php echo $this->category->parent_id; ?></td>
					<td class="align-center buttons buttons-small">
						<?php echo anchor('admin/store/preview_product/' . $this->category->categories_id, lang('store_button_view'), 'rel="modal-large" class="iframe button preview" target="_blank"'); ?>
						<?php echo anchor('admin/store/edit_product/' . $this->category->categories_id, lang('store_button_edit'), 'class="button edit"'); ?>
						<?php echo anchor('admin/store/delete_product/' . $this->category->categories_id, lang('store_button_delete'), array('class'=>'confirm button delete')); ?>
					</td>
				</tr>
			<?php } ?>
		</tbody>
	</table>

	<div class="buttons align-right padding-top">
		<?php $this->load->view('admin/partials/buttons', array('buttons' => array('delete'))); ?>
	</div>

	<?php echo form_close(); ?>

<?php else: ?>
	<div class="blank-slate">
		<h2><?php echo lang('store_currently_no_categories'); ?></h2>
	</div>
<?php endif; ?>
