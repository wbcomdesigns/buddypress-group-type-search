<?php
/**
 * Defining class for Filter dropdown option for public setting
 */
if (!class_exists('WbCom_BP_Group_Type_Search_Setting_Save')) {
	class WbCom_BP_Group_Type_Search_Setting_Save {
		/**
		 * Constructor
		 */		
		public function __construct() { 
			/**
			 * Saving option values
			 */
			add_action('bp_admin_init', array(&$this, 'bpgts_core_group_search_admin_settings_save'), 10);
		}
		
		/**
		 * Saving options
		 */		
		public function bpgts_core_group_search_admin_settings_save() {
			if (!empty($_POST['submit'])) {
				
				$bp_group_type_search_field_1 = sanitize_text_field( $_POST['bp_group_type_search_field_1'] );
				bp_update_option('bp_group_type_search_field_1', $bp_group_type_search_field_1);
								
				$bp_group_type_search_field_2 = sanitize_text_field( $_POST['bp_group_type_search_field_2'] );				
				bp_update_option('bp_group_type_search_field_2', $bp_group_type_search_field_2);
				
				$bp_group_type_search_field_3 = sanitize_text_field( $_POST['bp_group_type_search_field_3'] );
				bp_update_option('bp_group_type_search_field_3', $bp_group_type_search_field_3);
				
				$bp_group_per_page = sanitize_text_field( $_POST['bp_group_per_page'] );				
				bp_update_option('bp_group_per_page', $bp_group_per_page);
			}
		}
	}
}
if (class_exists('WbCom_BP_Group_Type_Search_Setting_Save')) {
	$admin_setting_save_obj = new WbCom_BP_Group_Type_Search_Setting_Save();
}
?>
