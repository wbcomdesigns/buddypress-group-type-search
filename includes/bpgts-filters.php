<?php
// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

//Class to add custom scripts and styles
if( !class_exists( 'BPGTSFlters' ) ) {
	class BPGTSFlters{

		//Constructor
		function __construct() {
			add_filter( 'bp_directory_groups_search_form', array( $this, 'bpgts_modified_group_search_form' ) );			
		}
		//Actions performed for modifying the group search form template
		function bpgts_modified_group_search_form() {
			$query_arg = bp_core_get_component_search_query_arg( 'groups' );
			global $bp;
			$all_group_types = bp_groups_get_group_types(bp_get_current_group_id(), false);
			$group_types = array();
			foreach($all_group_types as $key=>$gt){
				$group_types[$key] = $gt->labels['name'];
			}
			$group_per_page = get_option( 'bpgts_group_per_page' );
			if($group_per_page == '' || $group_per_page == 0)
				$group_per_page = 10;
			$group_type_search = get_option( 'bpgts_group_type_search_field_1' );
			$group_type_select = get_option( 'bpgts_group_type_search_field_2' );
			$both = get_option( 'bpgts_group_type_search_field_3' );
			if($group_type_search == '' && $group_type_select == '' && $both == '')
				$both = 1;
			?>
			<div class="bpgts-grp-search-form-template">
				<div class="bpgts-input-error">
					<span>
						<?php echo __( 'Please provide some input to search groups!', 'bp-group-filter' );?>
					</span>
				</div>

				<?php
					if($group_type_search || $both)
					{ ?>
				<label for="groups_search" class="bp-screen-reader-text">
					<?php echo __( 'Search Groups...', 'bp-group-filter' );?>
				</label>
				<div class="custom-wrap">
					<input id="bpgts-groups-search-txt" placeholder="<?php echo __( 'Search Groups...', 'bp-group-filter' );?>" type="text">
					<!--<span class="ajax-loader"><i class="fa fa-spinner fa-spin"></i></span>-->
				</div>
				<? } ?>

				<?php
				if($group_type_select || $both)
				{ ?>
				<select id="bpgts-group-type">
					<option value="">
						<?php _e( '--Select--', 'bp-group-filter' );?>
					</option>
					<option value="all">
						<?php _e( 'All Types', 'bp-group-filter' );?>
					</option>
					<?php if( !empty( $group_types ) ) { ?>
						<?php foreach( $group_types as $index=> $group_type ) {?>
							<option value="<?php echo $index; ?>">
								<?php echo ucfirst( $group_type );?>
							</option>
						<?php } ?>
					<?php } ?>
				</select>
				<? } ?>

				<?php if($group_type_search || $group_type_select || $both) { ?>
				<input id="bpgts-group-page-no" type="hidden" name="group_page_no" value="1"/>
				<input id="bpgts-group-per-page" type="hidden" name="group-per-page" value="<?=$group_per_page?>"/>
				<a  id="bpgts-groups-search" href="javascript:void(0);">
					<?php if( get_option( 'template' ) == 'onesocial' ) {?>
						<span><i class="bb-icon-search"></i></span>
					<?php } else {?>
						<span><i class="fa fa-search"></i></span>
					<?php } ?>
				</a>
				<? } ?>

				<span class="ajax-loader"><i class="fa fa-spinner fa-spin"></i></span>

			</div>
			<?php
		}
	}
	new BPGTSFlters();
}
?>