<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * This is a store module for PyroCMS
 *
 * @author 		pyrocms-store Team - Jaap Jolman - Kevin Meier - Rudolph Arthur Hernandez - Gary Hussey
 * @website		http://www.odin-ict.nl/
 * @package 	pyrocms-store
 * @subpackage 	Store Module
**/
?>

<?php echo js('ckeditor/ckeditor.js'); ?>
<?php echo js('ckeditor/adapters/jquery.js'); ?>
<section class="title">
	<h4><?=$section_title;?></h4>
</section>

<section class="item">
<?php if ($products): ?>

	<?php echo form_open('admin/store/list_products'); ?>

	<table border="0" class="table-list">
		<thead>
			<tr>
				<th width="20"><?php echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all')); ?></th>
				<th><?php echo lang('store_product_list_thumbnail'); ?></th>
				<th><?php echo lang('store_product_list_name'); ?></th>
				<th><?php echo lang('store_product_list_price'); ?></th>
				<th>Stock</th>				
				<th><?php echo lang('store_product_list_discount'); ?></th>
				<th width="320" class="align-center"><span><?php echo lang('store_product_list_actions'); ?></span></th>
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
			<?php foreach($products as $product) { ?>
				<tr>
					<td><?php echo form_checkbox('action_to[]', $product->products_id); ?></td>
					<td><?php if (isset($product->image)) { echo $product->image; } 
								 else { echo $this->images_m->no_image(); } ?></td>
					<td><?php echo $product->name; ?></td>
					<td><?php echo $product->price; ?></td>
					<td><?php echo $product->stock; ?></td>
					<td><?php echo $product->discount; ?></td>
					<td class="align-center buttons buttons-small">
						<?php echo anchor('admin/store/preview_product/' . $product->products_id, lang('store_button_view'), 'rel="modal-large" class="iframe button preview" target="_blank"'); ?>
						<?php echo anchor('admin/store/edit_product/' . $product->products_id . '/true', lang('store_button_edit'), 'class="edit_product button edit"'); ?>
						<?php echo anchor('admin/store/delete_product/' . $product->products_id, lang('store_button_delete'), array('class'=>'confirm button delete')); ?>
					</td>
				</tr>
			<?php } ?>
		</tbody>
	</table>

	<div class="table_action_buttons">
		<?php $this->load->view('admin/partials/buttons', array('buttons' => array('delete'))); ?>
	</div>

	<?php echo form_close(); ?>

<?php else: ?>
	<div class="blank-slate">
		<h2><?php echo lang('store_currently_no_products'); ?></h2>
	</div>
<?php endif; ?>
</section>