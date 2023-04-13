<?php
/*
Plugin Name: Rainbowit Demo Importer Helper
Plugin URI:  #
Description: Uninstall this plugin after you've finished importing demo contents
Version: 2.0
Author: Rainbow-Themes
Author URI: https://themeforest.net/user/rainbow-themes
*/
if ( ! defined( 'ABSPATH' ) ) exit;
	if ( ! defined( 'RAINBOWIT' ) ) {
		define( 'RAINBOWIT',  					 ( WP_DEBUG ) ? time() : '1.0' );
		define( 'RAINBOWIT_PREVIEW', 			'https://rainbowit.net/themes/inbio/demo/preview/');	
		define( 'RAINBOWIT_PREVIEW_LINK', 		'https://rainbowit.net/themes/inbio/');	
		define( 'RAINBOWIT_DEMO_DATA_URL', 		'https://rainbowit.net/themes/inbio/demo/');	
		define( 'RAINBOWIT_PREFIX',      		'rainbowitdemo' );
		define( 'RAINBOWIT_DEMO_HELPER_URL', 			plugin_dir_url( __FILE__ ) );
		define( 'RAINBOWIT_DEMO_HELPER_ASSETS', 		trailingslashit( RAINBOWIT_DEMO_HELPER_URL . 'assets' ) );			
	}

if ( is_admin() && !defined( 'FW' ) ) {
	require_once dirname(__FILE__) . '/unyson/framework/bootstrap.php';
	add_filter( 'fw_framework_directory_uri', 'rainbowit_fw_framework_directory_uri' );
	add_action( 'admin_menu',                 'rainbowit_remove_unyson_menus', 12 );
	add_action( 'network_admin_menu',         'rainbowit_remove_unyson_menus', 12 );
	add_action( 'after_setup_theme',          'rainbowit_remove_unyson_footer_version', 12 );
	add_action( 'admin_enqueue_scripts',      'rainbowit_fw_admin_styles', 20 );
	// skip image import
	//add_filter( 'fw:ext:backups:add-restore-task:image-sizes-restore', '__return_false' );
	add_action( 'plugins_loaded', 			  'rainbowit_unyson_demo_importer', 20 );		
}

add_action( 'plugins_loaded', 	'rainbowit_elementor_textdomain', 16 );

function rainbowit_elementor_textdomain() {
		load_plugin_textdomain( 'rainbowitdemo', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' ); 
	}

function rainbowit_fw_framework_directory_uri() {
	return plugin_dir_url( __FILE__ ) . 'unyson/framework';
}

function rainbowit_remove_unyson_menus() {
	remove_menu_page( 'fw-extensions' );
	remove_menu_page( 'fw-extensions' );
	remove_submenu_page( 'tools.php', 'fw-backups' );
}
function rainbowit_remove_unyson_footer_version() {
	$rainbowit_obj = fw();
	remove_filter( 'update_footer', array( $rainbowit_obj->backend, '_filter_footer_version'), 11 );
}
function rainbowit_fw_admin_styles(){ 
	wp_enqueue_style('rainbowit-demo-helper',   RAINBOWIT_DEMO_HELPER_ASSETS . '/demo.css');	
}
function rainbowit_unyson_demo_importer() {
	require_once 'unyson-demo-importer.php';
}