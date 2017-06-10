<?php
/*
  Plugin Name: BuddyPress Group Type Search
  Plugin URI: https://wbcomdesigns.com/contact/
  Description: This plugin allows site visitors to search for BuddyPress groups that includes searching based on buddypress group types in the site.
  Version: 1.0.2
  Author: Wbcom Designs
  Author URI: http://wbcomdesigns.com
  License: GPLv2+
  Text Domain: bp-group-filter
  Domain Path: /languages
 */
if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

//Load plugin textdomain ( @since 1.0.0 )
add_action('init', 'bpgts_load_textdomain');

function bpgts_load_textdomain() {
    $domain = "bp-group-filter";
    $locale = apply_filters('plugin_locale', get_locale(), $domain);
    load_textdomain($domain, 'languages/' . $domain . '-' . $locale . '.mo');
    $var = load_plugin_textdomain($domain, false, plugin_basename(dirname(__FILE__)) . '/languages');
}

//Constants used in the plugin
define('BPGTS_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('BPGTS_PLUGIN_URL', plugin_dir_url(__FILE__));
define('BPGTS_TEXT_DOMAIN', "bp-group-filter");

if (!defined('BPGTS_ENABLE_MULTIBLOG')) {
    define('BPGTS_ENABLE_MULTIBLOG', false);
}
//Include needed files on init
function bpgts_run_bp_group_type_search() {
  $include_files = array(
    'includes/bpgts-scripts.php',
    'includes/bpgts-filters.php',
    'includes/bpgts-ajax.php',
		'admin/class-bp-group-type-search-admin-setting.php',
		'admin/class-bp-group-type-search-admin-setting-save.php'
  );
  foreach ($include_files as $include_file) {
    include $include_file;
  }
}

/**
 * Check plugin requirement on activation
 * this plugin requires buddypress and create group type to be installed and active
 */
add_action('plugins_loaded', 'bpgts_group_type_search_plugin_init');
function bpgts_group_type_search_plugin_init() {
    if (is_multisite()) {
        global $wpdb;
        if (!is_plugin_active_for_network('buddypress/bp-loader.php') && !is_plugin_active('buddypress/bp-loader.php')) {
            //Buddypress Plugin is inactive, hence deactivate this plugin
            deactivate_plugins(plugin_basename(__FILE__));
            wp_die(__('The <b>BuddyPress Group Type Search</b> plugin requires <b>Buddypress</b> plugin to be installed and active. Return to <a href="' . admin_url('plugins.php') . '">Plugins</a>', 'bp-profile-filter'));
        }
        if(!is_plugin_active_for_network('bp-create-group-type/bp-add-group-types.php') && !is_plugin_active('bp-create-group-type/bp-add-group-types.php')){
            //Buddypress Plugin is inactive, hence deactivate this plugin
            deactivate_plugins(plugin_basename(__FILE__));
            wp_die(__('The <b>BuddyPress Group Type Search</b> plugin requires <b>BuddyPress Add Group Types</b> plugin to be installed and active. Return to <a href="' . admin_url('plugins.php') . '">Plugins</a>', 'bp-profile-filter'));
        }
    } else {
      // If BuddyPress && Create Group Type plugin is NOT active
      $bp_cg_active = in_array('bp-create-group-type/bp-add-group-types.php', get_option('active_plugins'));
	  $boddypress_cg_active = in_array('buddypress-create-group-type-master/bp-add-group-types.php', get_option('active_plugins'));
	  
	  //check for both folders GitHub and Wordpress.org
	  if($bp_cg_active === true || $boddypress_cg_active === true)
		  $cg_active = true;
	  
      $bp_active = in_array('buddypress/bp-loader.php', get_option('active_plugins'));

      if ( current_user_can('activate_plugins') && ( $cg_active !== true && $bp_active !== true ) ) {
        add_action('admin_notices', 'bpgts_both_plugin_admin_notice');
      } 
	  else if ( current_user_can('activate_plugins') && ( $cg_active !== true ) ) {
        add_action('admin_notices', 'bpgts_bp_create_group_type_plugin_admin_notice');
      }
	  else if ( current_user_can('activate_plugins') && ( $bp_active !== true ) ) {
        add_action('admin_notices', 'bpgts_bp_plugin_admin_notice');
      }
	  else {
        if (!defined('BPGTS_PLUGIN_BASENAME')) {
            define('BPGTS_PLUGIN_BASENAME', plugin_basename(__FILE__));
        }
        bpgts_run_bp_group_type_search();
        //Settings link for this plugin
        add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'bpgts_bpcg_settings_link' );
      }
    }
}

function bpgts_bpcg_settings_link( $links ) {
	$settings_link = '<a href="' . admin_url("admin.php?page=bp-settings#bpgts_group_type_search_filter") . '">' . __('Settings', 'bp-activity-filter') . '</a>';
	array_unshift($links, $settings_link); // before other links
	return $links;
}

// Throw an Alert to tell the Admin why it didn't activate
function bpgts_both_plugin_admin_notice() {
    $bpcg_plugin = "BP Group Type Search";
    $bp_plugin = "BuddyPress";
    $cg_plugin = "BP Create Group Types";
    echo '<div class="error"><p>'
    . sprintf(__('%1$s requires %2$s and %3$s to function correctly. Please activate %2$s and %3$s before activating %1$s.', BPGTS_TEXT_DOMAIN), '<strong>' . esc_html($bpcg_plugin) . '</strong>', '<strong>' . esc_html($bp_plugin) . '</strong>', '<strong>' . esc_html($cg_plugin) . '</strong>')
    . '</p></div>';
    if (isset($_GET['activate']))
        unset($_GET['activate']);
}

function bpgts_bp_create_group_type_plugin_admin_notice() {
    $bpgts_plugin = "BP Group Type Search";    
    $bpcgt_plugin = "BP Create Group Types";
    echo '<div class="error"><p>'
    . sprintf(__('%1$s requires %2$s to function correctly. Please activate %2$s before activating %1$s.', BPGTS_TEXT_DOMAIN), '<strong>' . esc_html($bpgts_plugin) . '</strong>' , '<strong>' . esc_html($bpcgt_plugin) . '</strong>')
    . '</p></div>';
    if (isset($_GET['activate']))
        unset($_GET['activate']);
}

function bpgts_bp_plugin_admin_notice() {
    $bpgts_plugin = "BP Group Type Search"; 
    $bp_plugin = "BuddyPress";
    echo '<div class="error"><p>'
    . sprintf(__('%1$s requires %2$s to function correctly. Please activate %2$s before activating %1$s.', BPGTS_TEXT_DOMAIN), '<strong>' . esc_html($bpgts_plugin) . '</strong>' , '<strong>' . esc_html($bp_plugin) . '</strong>')
    . '</p></div>';
    if (isset($_GET['activate']))
        unset($_GET['activate']);
}
