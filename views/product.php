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
<div id="product">
	<ul>
		<?php echo form_open('/store/insert_cart/' . $product->products_id . '/'); ?>
		<?php echo form_hidden('redirect', current_url()); ?>
		<li>
			<div>
				<h2><?php echo $product->name; ?></h2>
			</div>
			<div>
			<?php if(isset($product->image)) : ?>
				<?php $name = $product->image->name; $id = $product->image->id; 
						$extension = $product->image->extension; ?>			
				<img src="<?=base_url();?>uploads/store/products/<?=$name . $extension;?>" alt="<?php echo $product->name; ?>" />
			<?php endif; ?>				
				<?php echo $product->html; ?>
			</div>
			<div>
				<span><?php echo $this->cart->format_number($product->price); ?></span>
				<?php echo form_input('qty','1') . form_submit('','Add to Cart'); ?>
			</div>
		</li>
		<?php echo form_close(); ?>
	</ul>
</div>











