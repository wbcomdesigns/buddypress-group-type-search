<?php
// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

//Class to add custom scripts and styles
if( !class_exists( 'BGFFilters' ) ) {
	class BGFFilters{

		//Constructor
		function __construct() {
			add_filter( 'bp_directory_groups_search_form', array( $this, 'bgf_modified_group_search_form' ) );
		}

		//Actions performed for modifying the group search form template
		function bgf_modified_group_search_form() {
			global $bp;
			$group_types = bp_groups_get_group_types();
			?>
			<div class="bgf-grp-search-form-template">
				<div class="bgf-input-error">
					<span>
						<?php echo __( 'Please provide some input to search groups!', 'bp-group-filter' );?>
					</span>
				</div>
				<label for="groups_search" class="bp-screen-reader-text">
					<?php echo __( 'Search Groups...', 'bp-group-filter' );?>
				</label>
				<div class="custom-wrap">
					<input id="bgf-groups-search-txt" placeholder="<?php echo __( 'Search Groups...', 'bp-group-filter' );?>" type="text">
					<span class="ajax-loader"><i class="fa fa-spinner fa-spin"></i></span>
				</div>
				<select id="group-type">
					<option value="">
						<?php _e( '--Select--', 'bp-group-filter' );?>
					</option>
					<option value="all">
						<?php _e( 'All Types', 'bp-group-filter' );?>
					</option>
					<?php if( !empty( $group_types ) ) {?>
						<?php foreach( $group_types as $index => $group_type ) {?>
							<option value="<?php echo $index;?>">
								<?php echo ucfirst( $group_type );?>
							</option>
						<?php }?>
					<?php }?>
				</select>
				<a  id="bgf-groups-search" href="javascript:void(0);">
					<span><i class="fa fa-search"></i></span>
				</a>
			</div>
			<?php
		}
	}
	new BGFFilters();
}