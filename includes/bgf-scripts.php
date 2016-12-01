<?php
// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

//Class to add custom scripts and styles
if( !class_exists( 'BGFScriptsStyles' ) ) {
	class BGFScriptsStyles{

		//Constructor
		function __construct() {
			$curr_url = $_SERVER['REQUEST_URI'];
			if( strpos($curr_url, 'groups') !== false ) {
				add_action( 'wp_enqueue_scripts', array( $this, 'bgf_custom_variables' ) );
			}
		}

		//Actions performed for enqueuing scripts and styles for site front
		function bgf_custom_variables() {
			wp_enqueue_script('bgf-js-front',BGF_PLUGIN_URL.'assets/js/bgf-front.js', array('jquery'));
			wp_enqueue_style('bgf-front-css', BGF_PLUGIN_URL.'assets/css/bgf-front.css');
			wp_enqueue_style('bgf-font-awesome', BGF_PLUGIN_URL.'assets/css/font-awesome.min.css');
		}
	}
	new BGFScriptsStyles();
}