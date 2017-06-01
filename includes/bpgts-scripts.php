<?php
// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

//Class to add custom scripts and styles
if( !class_exists( 'BPGTSScriptsStyles' ) ) {
	class BPGTSScriptsStyles{

		//Constructor
		function __construct() {
			$curr_url = $_SERVER['REQUEST_URI'];
			if( strpos($curr_url, 'groups') !== false ) {
				add_action( 'wp_enqueue_scripts', array( $this, 'bpgts_custom_variables' ) );
			}
		}

		//Actions performed for enqueuing scripts and styles for site front
		function bpgts_custom_variables() {
			wp_enqueue_script('bpgts-js-front',BPGTS_PLUGIN_URL.'assets/js/bpgts-front.js', array('jquery'));
			wp_enqueue_style('bpgts-front-css', BPGTS_PLUGIN_URL.'assets/css/bpgts-front.css');
			wp_enqueue_style('bpgts-font-awesome', BPGTS_PLUGIN_URL.'assets/css/font-awesome.min.css');

			//One Social CSS
			if( get_option( 'template' ) == 'onesocial' ) {
				wp_enqueue_style('bpgts-onesocial-css', BPGTS_PLUGIN_URL.'assets/css/bpgts-onesocial.css');
			}

			//Boss CSS
			if( get_option( 'template' ) == 'boss' ) {
				wp_enqueue_style('bpgts-boss-css', BPGTS_PLUGIN_URL.'assets/css/bpgts-boss.css');
			}
		}
	}
	new BPGTSScriptsStyles();
}
