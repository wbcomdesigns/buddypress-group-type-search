<?php
// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

//Class to add custom scripts and styles
if( !class_exists( 'BPGTSAjax' ) ) {
	class BPGTSAjax{

		//Constructor
		function __construct() {
			//Search Groups
			add_action( 'wp_ajax_bgf_search_groups', array( $this, 'bpgts_search_groups' ) );
			add_action( 'wp_ajax_nopriv_bgf_search_groups', array( $this, 'bpgts_search_groups' ) );
		}

		//Actions performed to search groups
		function bpgts_search_groups() {
			if( isset( $_POST['action'] ) && $_POST['action'] === 'bgf_search_groups' ) {
				$search_txt = sanitize_text_field( $_POST['search_txt'] );
				$group_type = sanitize_text_field( $_POST['group_type'] );
				$groups_order_by = sanitize_text_field( $_POST['groups_order_by'] );
				$group_page_no = sanitize_text_field( $_POST['group_page_no'] );
				$group_per_page = sanitize_text_field( $_POST['group_per_page'] );
				/* Check group order and set default order (if order is not set or blank) */
				if( $groups_order_by == '' )
					$groups_order_by = 'alphabetical';
				/*
					Check for user and show the hidden groups only if
					1. user is logged in
					2. user is moderate / allowed to see the hidden groups
					3. user_id is set in the session
					otherwise
					do not show the hidden groups
				*/
				if ( !is_user_logged_in() || ( !bp_current_user_can( 'bp_moderate' ) && ( $user_id != bp_loggedin_user_id() ) ) )
					$hidden = false;
				else
					$hidden = true;
				$result = array();
				if( $group_type == 'all' ) {
					$groups = BP_Groups_Group::get(
						array(
							'type' => $groups_order_by,
							'page' => $group_page_no,
							'per_page' => $group_per_page,
							'show_hidden' => $hidden,
							'search_terms' => $search_txt,
						)
					);
				} else {
					$groups = BP_Groups_Group::get(
						array(
							'type' => $groups_order_by,
							'page' => $group_page_no,
							'per_page' => $group_per_page,
							'group_type' => $group_type,
							'show_hidden' => $hidden,
							'search_terms' => $search_txt,
						)
					);
				}
				
				if( !empty( $groups['groups'] ) ) {
					$grps = $groups['groups'];

				if( !empty( $groups['total'] ) ) {
						$result['total'] = $groups['total'];
					}

					/**
					 * If search text is empty
					 * then, only group type will work here
					 */
					if( $search_txt == '' ) {
						foreach ($grps as $key => $grp) {
							$temp = array();
							$members = groups_get_groupmeta( $grp->id, 'total_member_count' );
							//Group Thumbnail
							$avatar = bp_core_fetch_avatar(
								array(
									'item_id' => $grp->id,
									'object' => 'group',
									'html' => false
								)
							);
							//Last active
							$last_active = groups_get_groupmeta( $grp->id, 'last_activity' );
							$lst_actv = bp_core_time_since( $last_active );

							$temp = array(
								'id' => $grp->id,
								'title' => $grp->name,
								'status' => ucfirst( $grp->status ),
								'description' => $grp->description,
								'member_str' => $members > 1 ? "$members members" : "$members member",
								'permalink' => home_url().'/groups/'.$grp->slug.'/',
								'thumbnail' => $avatar,
								'last_active' => $lst_actv
							);
							$result['groups'][] = $temp;
						}
						$result['found'] = 'yes';
						$result['msg'] = 'Groups Found!';
					} else {
						/**
						 * If group type is selected
						 * and search text has also been provided,
						 * then, groups based on both the criterias will be fetched
						 */
						foreach ($grps as $key => $grp) {
							$temp = array();
							$title_pos = $desc_pos = false;
							$title_pos = stripos( $grp->name, $search_txt );
							$desc_pos = stripos( $grp->description, $search_txt );
							if( $title_pos !== false || $desc_pos !== false ) {
								$members = groups_get_groupmeta( $grp->id, 'total_member_count' );

								//Group Thumbnail
								$avatar = bp_core_fetch_avatar(
									array(
										'item_id' => $grp->id,
										'object' => 'group',
										'html' => false
									)
								);

								//Last active
								$last_active = groups_get_groupmeta( $grp->id, 'last_activity' );
								$lst_actv = bp_core_time_since( $last_active );

								$temp = array(
									'id' => $grp->id,
									'title' => $grp->name,
									'status' => ucfirst( $grp->status ),
									'description' => $grp->description,
									'member_str' => $members > 1 ? "$members members" : "$members member",
									'permalink' => home_url().'/groups/'.$grp->slug.'/',
									'thumbnail' => $avatar,
									'last_active' => $lst_actv
								);
								$result['groups'][] = $temp;
							}
						}
						$result['found'] = 'yes';
						$result['msg'] = 'Groups Found!';
						if( empty( $result['groups'] ) ) {
							$result = array(
								'found' => 'no',
								'msg' => __( 'No Groups Matched Your Query!', 'bp-group-filter' ),
								'groups' => array()
							);
						}
					}
				} else {
					/**
					 * If no groups are created, then...
					 */
					$result = array(
						'found' => 'no',
						'msg' => __( 'No Groups Found!', 'bp-group-filter' ),
						'groups' => array()
					);
				}				
				echo json_encode( $result );
				die;
			}
		}
	}
	new BPGTSAjax();
}
