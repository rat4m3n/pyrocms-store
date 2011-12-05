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
<div id="categories">
	<ul>
		<?php foreach($categories as $category) { ?>
		<li><a href="<?php echo site_url(); ?>store/items/<?=str_replace(' ', '-', $category->name); ?>/" 
					title="<?php echo $category->name; ?>">	
			<div>
			<h4 class="category_title"><?php echo ucfirst($category->name); ?></h4>
			</div>
			<div>		
			<?php if(isset($category->image)) : ?>
				<?php $name = $category->image->name; $id = $category->image->id; 
						$extension = $category->image->extension; ?>					
				<img src="uploads/store/categories/<?=$name . $id . $extension;?>" alt="<?php echo $category->name; ?>" />			
			<?php else : ?>
				<?php echo ucfirst($category->name); ?>			
			<?php endif; ?>
	
			</div>
			<div>
				<h5><?php $num_products = $this->products_m->count_products($category->categories_id); 
						if ($num_products == 0) { $output = "no items"; }
						else if($num_products == 1) { $output = $num_products . " item"; }
						else { $output = $num_products . " items"; } 
						echo $output; 
				?></h5>			
			</div>
						</a>	
		</li>
		<?php } ?>
	</ul>
</div>








