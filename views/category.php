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
<div id="category">
	<ul>
	<?php foreach($products as $product) { ?>
		<li>
			<div>
				<a href="<?php echo site_url(); ?>store/product/<?php echo $product->products_id; ?>/" 
					title="<?php echo $product->name; ?>"><?php echo $product->name; ?></a>
			</div>
			<div>
				<img src="" alt="<?php echo $product->name; ?>" />
			</div>
		</li>
	<?php } ?>
	</ul>
</div>
