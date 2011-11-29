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
	<h4><?php echo lang('store_title_store_index')?></h4>
</section>

<section class="item">
	
<?php echo form_open(uri_string(), 'class="crud"'); ?>
<div class="tabs">

	<ul class="tab-menu">
		<li><a href="#general"><span><?php echo lang('store_tab_config');?></span></a></li>
		<li><a href="#payment-gateways"><span><?php echo lang('store_tab_payment_gateways');?></span></a></li>
		<li><a href="#extra"><span><?php echo lang('store_tab_additional_info');?></span></a></li>

	</ul>
	
	<!-- Content tab -->
	<div class="form_inputs" id="general">
		
		<fieldset>
	
		<ul>
      	<?php foreach($general_settings as $setting) { ?>
            <?php switch($setting->type) { case 'text': ?>
                     
                <li class="<?php echo alternator('even', ''); ?>">
                    <label for="title"><?php echo lang('store_settings_'.$setting->slug,$setting->slug); ?> <span>*</span></label>
                    <div class="input"><?php echo form_input($setting->slug,set_value($setting->slug,$setting->value),'class="text"'); ?></div>				
                </li>
                
			<?php break; case 'dropdown': ?>
                     
                <li class="<?php echo alternator('even', ''); ?>">
                    <label for="title"><?php echo lang('store_settings_'.$setting->slug,$setting->slug); ?> <span>*</span></label>
                    <div class="input"><?php echo form_dropdown($setting->slug,$this->store_settings->generate_dropdown($setting->slug), set_value($setting->slug,$setting->value),'class="dropdown"'); ?></div>				
				</li>
			<?php break; case 'radio': ?>
                     
                <li class="<?php echo alternator('even', ''); ?>">
                    <label for="title"><?php echo lang('store_settings_'.$setting->slug,$setting->slug); ?> <span>*</span></label>
                    <div class="input"><?php if($setting->value == 1) { echo form_radio($setting->slug,'1',TRUE).$this->lang->line('store_radio_yes'); echo form_radio($setting->slug,'0',FALSE).$this->lang->line('store_radio_no'); } else { echo form_radio($setting->slug,'1',FALSE).$this->lang->line('store_radio_yes'); echo form_radio($setting->slug,'0',TRUE).$this->lang->line('store_radio_no'); } ?></div>				
				</li>
			<?php break; case 'checkbox': ?>
                     
                <li class="<?php echo alternator('even', ''); ?>">
                    <label for="title"><?php echo lang('store_settings_'.$setting->slug,$setting->slug); ?> <span>*</span></label>
                    <div class="input"><?php if($setting->value == 1) { echo form_checkbox($setting->slug,'1',TRUE); } else { echo form_checkbox($setting->slug,'0',TRUE); } ?></div>				
				</li>
			<?php break; case 'textarea': ?>
                     
                <li class="<?php echo alternator('even', ''); ?>">
                    <label for="title"><?php echo lang('store_settings_'.$setting->slug,$setting->slug); ?> <span>*</span></label>
                    <div class="input"><?php echo form_textarea($setting->slug,set_value($setting->slug,$setting->value),'rows="7"'); ?></div>				
				</li>
                
			<?php break; case 'wysiwyg|simple': ?>
                     
                <li class="<?php echo alternator('even', ''); ?>">
                    <label for="title"><?php echo lang('store_settings_'.$setting->slug,$setting->slug); ?> <span>*</span></label>
                    <div class="input"><?php echo form_textarea($setting->slug,set_value($setting->slug,$setting->value),'rows="7" class="wysiwyg-simple"'); ?></div>				
				</li>
                
			<?php break; case 'wysiwyg|advanced': ?>
                     
                <li class="<?php echo alternator('even', ''); ?>">
                    <label for="title"><?php echo lang('store_settings_'.$setting->slug,$setting->slug); ?> <span>*</span></label>
                    <div class="input"><?php echo form_textarea($setting->slug,set_value($setting->slug,$setting->value),'rows="7" class="wysiwyg-advanced"'); ?></div>				
				</li>
                    
			<?php break; } } ?>
		</ul>
		
		</fieldset>
		
	</div>
    
    <!-- Payment Gateways tab -->
	<div class="form_inputs" id="payment-gateways">
		
		<fieldset>
	
		<ul>
            <?php foreach($payment_gateways_settings as $setting) { ?>
            <?php switch($setting->type) { case 'text': ?>
                     
                <li class="<?php echo alternator('even', ''); ?>">
                    <label for="title"><?php echo lang('store_settings_'.$setting->slug,$setting->slug); ?> <span>*</span></label>
                    <div class="input"><?php echo form_input($setting->slug,set_value($setting->slug,$setting->value),'class="text"'); ?></div>				
                </li>
                
			<?php break; case 'dropdown': ?>
                     
                <li class="<?php echo alternator('even', ''); ?>">
                    <label for="title"><?php echo lang('store_settings_'.$setting->slug,$setting->slug); ?> <span>*</span></label>
                    <div class="input"><?php echo form_dropdown($setting->slug,$this->store_settings->generate_dropdown($setting->slug), set_value($setting->slug,$setting->value),'class="dropdown"'); ?></div>				
				</li>
			<?php break; case 'radio': ?>
                     
                <li class="<?php echo alternator('even', ''); ?>">
                    <label for="title"><?php echo lang('store_settings_'.$setting->slug,$setting->slug); ?> <span>*</span></label>
                    <div class="input"><?php if($setting->value == 1) { echo form_radio($setting->slug,'1',TRUE).$this->lang->line('store_radio_yes'); echo form_radio($setting->slug,'0',FALSE).$this->lang->line('store_radio_no'); } else { echo form_radio($setting->slug,'1',FALSE).$this->lang->line('store_radio_yes'); echo form_radio($setting->slug,'0',TRUE).$this->lang->line('store_radio_no'); } ?></div>				
				</li>
			<?php break; case 'checkbox': ?>
                     
                <li class="<?php echo alternator('even', ''); ?>">
                    <label for="title"><?php echo lang('store_settings_'.$setting->slug,$setting->slug); ?> <span>*</span></label>
                    <div class="input"><?php if($setting->value == 1) { echo form_checkbox($setting->slug,'1',TRUE); } else { echo form_checkbox($setting->slug,'0',TRUE); } ?></div>				
				</li>
			<?php break; case 'textarea': ?>
                     
                <li class="<?php echo alternator('even', ''); ?>">
                    <label for="title"><?php echo lang('store_settings_'.$setting->slug,$setting->slug); ?> <span>*</span></label>
                    <div class="input"><?php echo form_textarea($setting->slug,set_value($setting->slug,$setting->value),'rows="7"'); ?></div>				
				</li>
                
			<?php break; case 'wysiwyg|simple': ?>
                     
                <li class="<?php echo alternator('even', ''); ?>">
                    <label for="title"><?php echo lang('store_settings_'.$setting->slug,$setting->slug); ?> <span>*</span></label>
                    <div class="input"><?php echo form_textarea($setting->slug,set_value($setting->slug,$setting->value),'rows="7" class="wysiwyg-simple"'); ?></div>				
				</li>
                
			<?php break; case 'wysiwyg|advanced': ?>
                     
                <li class="<?php echo alternator('even', ''); ?>">
                    <label for="title"><?php echo lang('store_settings_'.$setting->slug,$setting->slug); ?> <span>*</span></label>
                    <div class="input"><?php echo form_textarea($setting->slug,set_value($setting->slug,$setting->value),'rows="7" class="wysiwyg-advanced"'); ?></div>				
				</li>
                    
			<?php break; } } ?>
		</ul>
		
		</fieldset>
		
	</div>
    
    <!-- Extra tab -->
	<div class="form_inputs" id="extra">
		
		<fieldset>
	
		<ul>
            <?php foreach($extra_settings as $setting) { ?>
            <?php switch($setting->type) { case 'text': ?>
                     
                <li class="<?php echo alternator('even', ''); ?>">
                    <label for="title"><?php echo lang('store_settings_'.$setting->slug,$setting->slug); ?> <span>*</span></label>
                    <div class="input"><?php echo form_input($setting->slug,set_value($setting->slug,$setting->value),'class="text"'); ?></div>				
                </li>
                
			<?php break; case 'dropdown': ?>
                     
                <li class="<?php echo alternator('even', ''); ?>">
                    <label for="title"><?php echo lang('store_settings_'.$setting->slug,$setting->slug); ?> <span>*</span></label>
                    <div class="input"><?php echo form_dropdown($setting->slug,$this->store_settings->generate_dropdown($setting->slug), set_value($setting->slug,$setting->value),'class="dropdown"'); ?></div>				
				</li>
			<?php break; case 'radio': ?>
                     
                <li class="<?php echo alternator('even', ''); ?>">
                    <label for="title"><?php echo lang('store_settings_'.$setting->slug,$setting->slug); ?> <span>*</span></label>
                    <div class="input"><?php if($setting->value == 1) { echo form_radio($setting->slug,'1',TRUE).$this->lang->line('store_radio_yes'); echo form_radio($setting->slug,'0',FALSE).$this->lang->line('store_radio_no'); } else { echo form_radio($setting->slug,'1',FALSE).$this->lang->line('store_radio_yes'); echo form_radio($setting->slug,'0',TRUE).$this->lang->line('store_radio_no'); } ?></div>				
				</li>
			<?php break; case 'checkbox': ?>
                     
                <li class="<?php echo alternator('even', ''); ?>">
                    <label for="title"><?php echo lang('store_settings_'.$setting->slug,$setting->slug); ?> <span>*</span></label>
                    <div class="input"><?php if($setting->value == 1) { echo form_checkbox($setting->slug,'1',TRUE); } else { echo form_checkbox($setting->slug,'0',TRUE); } ?></div>				
				</li>
			<?php break; case 'textarea': ?>
                     
                <li class="<?php echo alternator('even', ''); ?>">
                    <label for="title"><?php echo lang('store_settings_'.$setting->slug,$setting->slug); ?> <span>*</span></label>
                    <div class="input"><?php echo form_textarea($setting->slug,set_value($setting->slug,$setting->value),'rows="7"'); ?></div>				
				</li>
                
			<?php break; case 'wysiwyg|simple': ?>
                     
                <li class="<?php echo alternator('even', ''); ?>">
                    <label for="title"><?php echo lang('store_settings_'.$setting->slug,$setting->slug); ?> <span>*</span></label>
                    <div class="input"><?php echo form_textarea($setting->slug,set_value($setting->slug,$setting->value),'rows="7" class="wysiwyg-simple"'); ?></div>				
				</li>
                
			<?php break; case 'wysiwyg|advanced': ?>
                     
                <li class="<?php echo alternator('even', ''); ?>">
                    <label for="title"><?php echo lang('store_settings_'.$setting->slug,$setting->slug); ?> <span>*</span></label>
                    <div class="input"><?php echo form_textarea($setting->slug,set_value($setting->slug,$setting->value),'rows="7" class="wysiwyg-advanced"'); ?></div>				
				</li>
                    
			<?php break; } } ?>
		</ul>
		
		</fieldset>
		
	</div>

<div class="buttons float-right padding-top">
	<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'save_exit', 'cancel'))); ?>
</div>

<?php echo form_close(); ?>

</section>