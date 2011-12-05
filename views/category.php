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
<div id="category">
	<ul>
	<?php if (isset($products)) : ?>
	<?php foreach($products as $product) { ?>
		<li><a href="<?php echo site_url(); ?>store/items/<?=str_replace(' ', '-',$category_name);?>/<?=$product->slug; ?>/" 
				 title="<?php echo $product->name; ?>">
			<div>
				<h4><?=ucfirst($product->name);?></h4>
			</div>
			<div>
			<?php if(isset($product->image)) : ?>
				<?php $name = $product->image->name; $id = $product->image->id; 
						$extension = $product->image->extension; ?>
				<img src="<?=base_url();?>uploads/store/products/<?=$name . $id . $extension;?>" alt="<?php echo $product->name; ?>" />
			<?php else : ?>
				<?php echo "no image"; ?>		
			<?php endif; ?>
			</div>
			</a>
		</li>
	<?php } ?>
	<?php else : ?>
		<li style="padding: 10px 15px 10px 15px; ">
			<div><a href="store" >no products</a></div>	
		</li>
	<?php endif; ?>
	</ul>
</div>
