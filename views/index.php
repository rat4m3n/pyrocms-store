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
<div id="categories">
	<ul>
		<?php foreach($categories as $category) { ?>
		<li>
			<div>
				<a href="<?php echo site_url(); ?>store/category/<?php echo $category->categories_id; ?>/" 
					title="<?php echo $category->name; ?>"><?php echo $category->name; ?>
				</a>
			</div>
			<div>
				<img src="" alt="<?php echo $category->name; ?>" />
			</div>
		</li>
		<?php } ?>
	</ul>
</div>