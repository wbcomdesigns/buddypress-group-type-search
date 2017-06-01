<?php
/**
 * Defining class if not exist for admin setting
 */
if (!class_exists('WbCom_BP_Group_Type_Search_Setting')) {

	class WbCom_BP_Group_Type_Search_Setting {
		/**
		 * Constructor
		 */
		public function __construct() {
			/**
			 * You need to hook bp_register_admin_settings to register your settings
			 */
			//add_action('bp_register_admin_settings', array(&$this, 'bpgts_group_type_search_section_settings'), 100);
			add_action('bp_register_admin_settings', array(&$this, 'bpgts_group_type_search_section_settings'), 100);
		}

		/**
		 * Your setting main function
		 */		
		function bpgts_group_type_search_section_settings() {  
		
			add_settings_section(  
				'bpgts_group_type_search_section', // Section ID 
				'Group Type Search Setting', // Section Title				
				array(&$this,'bpgts_group_search_setting_section_callback'),
				'buddypress' // What Page?  This makes the section show up on the Buddypress Settings Page
			);

			add_settings_field( // Option 1
				'bpgts_group_type_search_field_1', // Option ID
				'Textbox', // Label
				array(&$this,'bp_group_search_setting_field_callback'),
				'buddypress', // Page it will be displayed (buddypress Settings)
				'bpgts_group_type_search_section', // Name of our section
				array( // The $args
					'bpgts_group_type_search_field_1' // Should match Option ID
				)  
			); 

			add_settings_field( // Option 2
				'bpgts_group_type_search_field_2', // Option ID
				'Group Type Select', // Label
				array(&$this,'bp_group_search_setting_field_callback'),
				'buddypress', // Page it will be displayed
				'bpgts_group_type_search_section', // Name of our section (buddypress Settings)
				array( // The $args
					'bpgts_group_type_search_field_2' // Should match Option ID
				)  
			); 

			add_settings_field( // Option 3
				'bpgts_group_type_search_field_3', // Option ID
				'Both', // Label
				array(&$this,'bp_group_search_setting_field_callback'),
				'buddypress', // Page it will be displayed
				'bpgts_group_type_search_section', // Name of our section (buddypress Settings)
				array( // The $args
					'bpgts_group_type_search_field_3' // Should match Option ID
				)  
			); 
			
			add_settings_field( // Option 3
				'bpgts_group_per_page', // Option ID
				'Pagination (Group per page)', // Label
				array(&$this,'bpgts_group_per_page_setting_field_callback'),
				'buddypress', // Page it will be displayed
				'bpgts_group_type_search_section', // Name of our section (buddypress Settings)
				array( // The $args
					'bpgts_group_per_page' // Should match Option ID
				)  
			); 
			
			register_setting('buddypress','bpgts_group_type_search_field_1', 'intval');
			register_setting('buddypress','bpgts_group_type_search_field_2', 'intval');
			register_setting('buddypress','bpgts_group_type_search_field_3', 'intval');
			register_setting('buddypress','bpgts_group_per_page', 'intval');
		}

		function bpgts_group_search_setting_section_callback() { // Section Callback
			?>
			<p id="bpgts_group_type_search_filter" class="description">
		    	<?php _e('You can set here which type of search filter (text, select or both) will be shown on front-end by default also you can set the number of groups shown in a single page. '); ?>
		    </p>  
			<?
		}

		function bp_group_search_setting_field_callback($args) {  // Radio Callback
			$option = bp_get_option($args[0]);			
			if($option == 1)
				echo '<input onclick="setVal('."'".trim($args[0])."'".')" checked="checked" type="checkbox" id="'. $args[0] .'" name="'. $args[0] .'" value="' . $option . '" />';	
			else
				echo '<input onclick="setVal('."'".trim($args[0])."'".')" type="checkbox" id="'. $args[0] .'" name="'. $args[0] .'" value="' . $option . '" />';			
			?>
			<script>
			function setVal(id)
			{
				if(id == 'bpgts_group_type_search_field_3') {
					
					if(jQuery('#'+id).is(':checked'))
					{
						jQuery('#bpgts_group_type_search_field_1').val(1);
						jQuery('#bpgts_group_type_search_field_1').prop('checked', true);
						
						jQuery('#bpgts_group_type_search_field_2').val(1);
						jQuery('#bpgts_group_type_search_field_2').prop('checked', true);
						
						jQuery('#bpgts_group_type_search_field_3').val(1);
						jQuery('#bpgts_group_type_search_field_3').prop('checked', true);
					}
				}
				else
				{
					if(jQuery('#bpgts_group_type_search_field_1').is(':checked') && jQuery('#bpgts_group_type_search_field_2').is(':checked'))
					{			
						/*jQuery('#bpgts_group_type_search_field_1').val(0);
						jQuery('#bpgts_group_type_search_field_1').prop('checked', false);
						
						jQuery('#bpgts_group_type_search_field_2').val(0);
						jQuery('#bpgts_group_type_search_field_2').prop('checked', false);*/
						
						jQuery('#bpgts_group_type_search_field_3').val(1);
						jQuery('#bpgts_group_type_search_field_3').prop('checked', true);
					}
					else
					if(jQuery('#'+id).is(':checked'))
					{
						jQuery('#'+id).val(1);
						jQuery('#'+id).prop('checked', true);
						
						jQuery('#bpgts_group_type_search_field_3').val(0);
						jQuery('#bpgts_group_type_search_field_3').prop('checked', false);
					}
					else
					{
						jQuery('#'+id).val(0);
						jQuery('#'+id).prop('checked', false);
						jQuery('#bpgts_group_type_search_field_3').val(0);
						jQuery('#bpgts_group_type_search_field_3').prop('checked', false);
					}
				}
			}
			</script>
			<?
		}
		
		function bpgts_group_per_page_setting_field_callback($args) {  // Radio Callback
			
			$option = bp_get_option($args[0]);			
			if($option)
				echo '<input type="number" id="'. $args[0] .'" name="'. $args[0] .'" value="' . $option . '" />';	
			else
				echo '<input type="number" id="'. $args[0] .'" name="'. $args[0] .'" value="10" />';		
		}		
	}
}

if (class_exists('WbCom_BP_Group_Type_Search_Setting')) {
	$admin_setting_obj = new WbCom_BP_Group_Type_Search_Setting();
}
?>