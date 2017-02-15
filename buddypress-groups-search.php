<?php

/*
  Plugin Name: BuddyPress Group Type Search
  Plugin URI: https://wbcomdesigns.com/contact/
  Description: This plugin allows site visitors to search for BuddyPress groups that includes searching based on buddypress group types in the site.
  Version: 1.0.1
  Author: Wbcom Designs
  Author URI: http://wbcomdesigns.com
  License: GPLv2+
  Text Domain: bp-group-filter
  Domain Path: /languages
 */
if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

//Load plugin textdomain ( @since 1.0.0 )
add_action('init', 'bgf_load_textdomain');

function bgf_load_textdomain() {
    $domain = "bp-group-filter";
    $locale = apply_filters('plugin_locale', get_locale(), $domain);
    load_textdomain($domain, 'languages/' . $domain . '-' . $locale . '.mo');
    $var = load_plugin_textdomain($domain, false, plugin_basename(dirname(__FILE__)) . '/languages');
}

//Constants used in the plugin
define('BGF_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('BGF_PLUGIN_URL', plugin_dir_url(__FILE__));
if (!defined('BP_ENABLE_MULTIBLOG')) {
    define('BP_ENABLE_MULTIBLOG', false);
}
//Include needed files on init
add_action('init', 'bgf_include_files');
add_action('admin_init', 'bgf_include_files');

function bgf_include_files() {
    $include_files = array(
        'includes/bgf-scripts.php',
        'includes/bgf-filters.php',
        'includes/bgf-ajax.php'
    );
    foreach ($include_files as $include_file)
        include $include_file;
}

//Plugin Activation
register_activation_hook(__FILE__, 'bgf_plugin_activation');

function bgf_plugin_activation() {
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
    } else{
        if (!in_array('buddypress/bp-loader.php', apply_filters('active_plugins', get_option('active_plugins'))) || !in_array('bp-create-group-type/bp-add-group-types.php', apply_filters('active_plugins', get_option('active_plugins')))) {
            //Buddypress Plugin is inactive, hence deactivate this plugin
            deactivate_plugins(plugin_basename(__FILE__));
            wp_die(__('The <b>BuddyPress Group Type Search</b> plugin requires <b>Buddypress</b> and <b>BuddyPress Add Group Types</b> plugin to be installed and active. Return to <a href="' . admin_url('plugins.php') . '">Plugins</a>', 'bp-profile-filter'));
        }
    }
}