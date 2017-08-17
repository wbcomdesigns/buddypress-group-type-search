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
// add_action('plugins_loaded', 'bpgts_group_type_search_plugin_init');
function bpgts_group_type_search_plugin_init() {
    
  $bpgt_active = in_array('bp-create-group-type/bp-add-group-types.php', get_option('active_plugins'));
  bpgts_run_bp_group_type_search();
  //Settings link for this plugin
  add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'bpgts_bpcg_settings_link' );
}

function bpgts_bpcg_settings_link( $links ) {
	$settings_link = '<a href="' . admin_url("admin.php?page=bp-settings#bpgts_group_type_search_filter") . '">' . __('Settings', 'bp-activity-filter') . '</a>';
	array_unshift($links, $settings_link); // before other links
	return $links;
}