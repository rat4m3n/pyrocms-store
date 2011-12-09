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

<script type="text/javascript" >
 
$(document).ready(function() {
// vertical tabs by mehdi mousavi
	var $items = $('#vtab>ul>li');
	
// set the menu buttons click function (used to be mouseover)
	$items.click(function() {
   	$items.removeClass('selected');
   	$(this).addClass('selected');
		var index = $items.index($(this));

	 	if($(document).scrollTop() > ($('#menu').height()/2)){
    		$('body,html').animate({ scrollTop: 0 }, 800, function(){ 
				$('#vtab>div').fadeOut(0).eq(index).fadeIn(0);    				
    		});
    		
    	}
    	else { $('#vtab>div').fadeOut(0).eq(index).fadeIn(); }
    	
	}).eq(0).click();// click the first element of the menu
	
 	$('#menu').stickyfloat({ duration: 800, offsetY: 250 });

	// make the message box disappear after 3 seconds. 	
	setTimeout(function(){ $('.alert').slideUp('slow');  }, 3000); 
		

 });// end document ready
</script>

<section class="title">
	<h4><?php echo lang('store_title_store_index')?></h4>
</section>

<section class="item">
	
<?php echo form_open(uri_string(), 'class="crud"'); ?>

<div id="vtab">
	<ul id="menu">	
		<li class="general"></li>
		<li class="payment"></li>
		<li class="extra"></li>
	</ul>
		<!-- index tab -->
	<div>
		<h4><?php echo lang('store_tab_config');?></h4>	
		<div class="" id="general">
		<fieldset>
		<ul>
            <?php foreach($this->store_settings->settings_manager_retrieve('general')->result() as $this->setting) { ?>
            <?php switch($this->setting->type) { case 'text': ?>
                     
                <li class="<?php echo alternator('even', ''); ?>">
                    <?php echo lang('store_settings_'.$this->setting->slug,$this->setting->slug); ?> 
                    <?php echo form_input($this->setting->slug,set_value($this->setting->slug,$this->setting->value),'class="text"'); ?>				
                </li>
                
			<?php break; case 'dropdown': ?>
                     
                <li class="<?php echo alternator('even', ''); ?>">
                    <?php echo lang('store_settings_'.$this->setting->slug,$this->setting->slug); ?> 
                    <?php echo form_dropdown($this->setting->slug,$this->store_settings->generate_dropdown($this->setting->slug), set_value($this->setting->slug,$this->setting->value),'class="dropdown"'); ?>				
				</li>
			<?php break; case 'radio': ?>
                     
                <li class="<?php echo alternator('even', ''); ?>">
                    <?php echo lang('store_settings_'.$this->setting->slug,$this->setting->slug); ?> 
                    <?php if($this->setting->value == 1) { echo form_radio($this->setting->slug,'1',TRUE).$this->lang->line('store_radio_yes'); echo form_radio($this->setting->slug,'0',FALSE).$this->lang->line('store_radio_no'); } else { echo form_radio($this->setting->slug,'1',FALSE).$this->lang->line('store_radio_yes'); echo form_radio($this->setting->slug,'0',TRUE).$this->lang->line('store_radio_no'); } ?>			
				</li>
			<?php break; case 'checkbox': ?>
                     
                <li class="<?php echo alternator('even', ''); ?>">
                    <?php echo lang('store_settings_'.$this->setting->slug,$this->setting->slug); ?> 
                    <?php if($this->setting->value == 1) { echo form_checkbox($this->setting->slug,'1',TRUE); } else { echo form_checkbox($this->setting->slug,'0',TRUE); } ?>				
				</li>
			<?php break; case 'textarea': ?>
                     
                <li class="<?php echo alternator('even', ''); ?>">
                    <?php echo lang('store_settings_'.$this->setting->slug,$this->setting->slug); ?> 
                    <?php echo form_textarea($this->setting->slug,set_value($this->setting->slug,$this->setting->value),'rows="7"'); ?>			
				</li>
                
			<?php break; case 'wysiwyg|simple': ?>
                     
                <li class="<?php echo alternator('even', ''); ?>">
                    <?php echo lang('store_settings_'.$this->setting->slug,$this->setting->slug); ?> 
                    <?php echo form_textarea($this->setting->slug,set_value($this->setting->slug,$this->setting->value),'rows="7" class="wysiwyg-simple"'); ?>		
				</li>
                
			<?php break; case 'wysiwyg|advanced': ?>
                     
                <li class="<?php echo alternator('even', ''); ?>">
                    <?php echo lang('store_settings_'.$this->setting->slug,$this->setting->slug); ?> 
                    <?php echo form_textarea($this->setting->slug,set_value($this->setting->slug,$this->setting->value),'rows="7" class="wysiwyg-advanced"'); ?>			
				</li>
                    
			<?php break; } } ?>
		</ul>
		</fieldset>
		</div>	
	</div>
	
   <!-- Payment Gateways tab -->	
	<div>
	   <h4><?php echo lang('store_tab_payment_gateways');?></h4> 
		<div class="" id="payment-gateways">
		<fieldset>
		<ul>
            <?php foreach($this->store_settings->settings_manager_retrieve('payment-gateways')->result() as $this->setting) { ?>
            
            <?php switch($this->setting->type) { case 'text': ?>
                     
                <li class="<?php echo alternator('even', ''); ?>">
                    <?php echo lang('store_settings_'.$this->setting->slug,$this->setting->slug); ?> 
                    <?php echo form_input($this->setting->slug,set_value($this->setting->slug,$this->setting->value),'class="text"'); ?>				
                </li>
                
			<?php break; case 'dropdown': ?>
                     
                <li class="<?php echo alternator('even', ''); ?>">
                    <?php echo lang('store_settings_'.$this->setting->slug,$this->setting->slug); ?> 
                    <?php echo form_dropdown($this->setting->slug,$this->store_settings->generate_dropdown($this->setting->slug), set_value($this->setting->slug,$this->setting->value),'class="dropdown"'); ?>				
				</li>
			<?php break; case 'radio': ?>
                     
                <li class="<?php echo alternator('even', ''); ?>">
                    <?php echo lang('store_settings_'.$this->setting->slug,$this->setting->slug); ?> 
                    <?php if($this->setting->value == 1) { echo form_radio($this->setting->slug,'1',TRUE).$this->lang->line('store_radio_yes'); echo form_radio($this->setting->slug,'0',FALSE).$this->lang->line('store_radio_no'); } else { echo form_radio($this->setting->slug,'1',FALSE).$this->lang->line('store_radio_yes'); echo form_radio($this->setting->slug,'0',TRUE).$this->lang->line('store_radio_no'); } ?>				
				</li><?php if($this->setting->slug == "paypal_developer_mode" || $this->setting->slug == "authorize_developer_mode" ) { echo "<hr />"; } ?>
			<?php break; case 'checkbox': ?>
                     
                <li class="<?php echo alternator('even', ''); ?>">
                    <?php echo lang('store_settings_'.$this->setting->slug,$this->setting->slug); ?> 
                    <?php if($this->setting->value == 1) { echo form_checkbox($this->setting->slug,'1',TRUE); } else { echo form_checkbox($this->setting->slug,'0',TRUE); } ?>				
				</li>
			<?php break; case 'textarea': ?>
                     
                <li class="<?php echo alternator('even', ''); ?>">
                    <?php echo lang('store_settings_'.$this->setting->slug,$this->setting->slug); ?> 
                    <?php echo form_textarea($this->setting->slug,set_value($this->setting->slug,$this->setting->value),'rows="7"'); ?>			
				</li>
                
			<?php break; case 'wysiwyg|simple': ?>
                     
                <li class="<?php echo alternator('even', ''); ?>">
                    <?php echo lang('store_settings_'.$this->setting->slug,$this->setting->slug); ?> 
                    <?php echo form_textarea($this->setting->slug,set_value($this->setting->slug,$this->setting->value),'rows="7" class="wysiwyg-simple"'); ?>				
				</li>
                
			<?php break; case 'wysiwyg|advanced': ?>
                     
                <li class="<?php echo alternator('even', ''); ?>">
                    <?php echo lang('store_settings_'.$this->setting->slug,$this->setting->slug); ?> 
                    <?php echo form_textarea($this->setting->slug,set_value($this->setting->slug,$this->setting->value),'rows="7" class="wysiwyg-advanced"'); ?>				
				</li>
                    
			<?php break; } } ?>
		</ul>
		</fieldset>
		</div>     
	</div>
	
	    <!-- Extra tab -->
	<div>
		<h4><?php echo lang('store_tab_additional_info');?></h4>
		<div class="" id="extra">
		<fieldset>
		<ul>
            <?php foreach($this->store_settings->settings_manager_retrieve('extra')->result() as $this->setting) { ?>
            <?php switch($this->setting->type) { case 'text': ?>
                     
                <li class="<?php echo alternator('even', ''); ?>">
                    <?php echo lang('store_settings_'.$this->setting->slug,$this->setting->slug); ?> 
                    <?php echo form_input($this->setting->slug,set_value($this->setting->slug,$this->setting->value),'class="text"'); ?>				
                </li>
                
			<?php break; case 'dropdown': ?>
                     
                <li class="<?php echo alternator('even', ''); ?>">
                    <?php echo lang('store_settings_'.$this->setting->slug,$this->setting->slug); ?> 
                    <?php echo form_dropdown($this->setting->slug,$this->store_settings->generate_dropdown($this->setting->slug), set_value($this->setting->slug,$this->setting->value),'class="dropdown"'); ?>			
				</li>
			<?php break; case 'radio': ?>
                     
                <li class="<?php echo alternator('even', ''); ?>">
                    <?php echo lang('store_settings_'.$this->setting->slug,$this->setting->slug); ?> 
                    <?php if($this->setting->value == 1) { echo form_radio($this->setting->slug,'1',TRUE).$this->lang->line('store_radio_yes'); echo form_radio($this->setting->slug,'0',FALSE).$this->lang->line('store_radio_no'); } else { echo form_radio($this->setting->slug,'1',FALSE).$this->lang->line('store_radio_yes'); echo form_radio($this->setting->slug,'0',TRUE).$this->lang->line('store_radio_no'); } ?>			
				</li>
			<?php break; case 'checkbox': ?>
                     
                <li class="<?php echo alternator('even', ''); ?>">
                    <?php echo lang('store_settings_'.$this->setting->slug,$this->setting->slug); ?> 
                    <?php if($this->setting->value == 1) { echo form_checkbox($this->setting->slug,'1',TRUE); } else { echo form_checkbox($this->setting->slug,'0',TRUE); } ?>			
				</li>
			<?php break; case 'textarea': ?>
                     
                <li class="<?php echo alternator('even', ''); ?>">
                    <?php echo lang('store_settings_'.$this->setting->slug,$this->setting->slug); ?> 
                    <?php echo form_textarea($this->setting->slug,set_value($this->setting->slug,$this->setting->value),'rows="7"'); ?>			
				</li>
                
			<?php break; case 'wysiwyg|simple': ?>
                     
                <li class="<?php echo alternator('even', ''); ?>">
                    <?php echo lang('store_settings_'.$this->setting->slug,$this->setting->slug); ?> 
                    <?php echo form_textarea($this->setting->slug,set_value($this->setting->slug,$this->setting->value),'rows="7" class="wysiwyg-simple"'); ?>			
				</li>
                
			<?php break; case 'wysiwyg|advanced': ?>
                     
                <li class="<?php echo alternator('even', ''); ?>">
                    <?php echo lang('store_settings_'.$this->setting->slug,$this->setting->slug); ?> 
                    <?php echo form_textarea($this->setting->slug,set_value($this->setting->slug,$this->setting->value),'rows="7" class="wysiwyg-advanced"'); ?>			
				</li>
                    
			<?php break; } } ?>
		</ul>
		</fieldset>
		</div>		
	</div>
	
</div>


    



<div class="buttons float-right padding-top">
	<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'save_exit', 'cancel'))); ?>
</div>

<?php echo form_close(); ?>

</section>