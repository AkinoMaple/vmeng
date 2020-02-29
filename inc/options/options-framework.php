<?php
/**
 * Options Framework
 *
 * @package   Options Framework
 * @author    Devin Price <devin@wptheming.com>
 * @license   GPL-2.0+
 * @link      http://wptheming.com
 * @copyright 2010-2016 WP Theming
 *
 * @wordpress-plugin
 * Plugin Name: Options Framework
 * Plugin URI:  http://wptheming.com
 * Description: A framework for building theme options.
 * Version:     1.8.5
 * Author:      Devin Price
 * Author URI:  http://wptheming.com
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: options-framework
 * Domain Path: /languages
 */

// If this file is called directly, abort.
if ( !function_exists( 'optionsframework_init' ) ) {
	define( 'OPTIONS_FRAMEWORK_DIRECTORY', get_template_directory_uri() . '/inc/options/' );
	
if ( ! defined( 'WPINC' ) ) {
	die;
}

function optionsframework_init() {

	//  If user can't edit theme options, exit
	if ( !current_user_can( 'edit_theme_options' ) )
		return;
	// Loads the required Options Framework classes.
	require plugin_dir_path( __FILE__ ) . 'includes/class-options-framework.php';
	require plugin_dir_path( __FILE__ ) . 'includes/class-options-framework-admin.php';
	require plugin_dir_path( __FILE__ ) . 'includes/class-options-interface.php';
	require plugin_dir_path( __FILE__ ) . 'includes/class-options-media-uploader.php';
	require plugin_dir_path( __FILE__ ) . 'includes/class-options-sanitization.php';

	// Instantiate the main plugin class.
	$options_framework = new Options_Framework;
	$options_framework->init();

	// Instantiate the options page.
	$options_framework_admin = new Options_Framework_Admin;
	$options_framework_admin->init();

	// Instantiate the media uploader class
	$options_framework_media_uploader = new Options_Framework_Media_Uploader;
	$options_framework_media_uploader->init();

}
add_action( 'init', 'optionsframework_init', 20 );

if ( ! function_exists( 'vm_get_option' ) ) :

	function vm_get_option( $name, $default = false ) {
		$config = get_option( 'optionsframework' );
	
		if ( ! isset( $config['id'] ) ) {
			return $default;
		}
	
		$options = get_option( $config['id'] );
	
		if ( isset( $options[$name] ) ) {
			return $options[$name];
		}
	
		return $default;
	}
	
	endif;
	
	
	}
	
	
	/*
	 * This is an example of how to override a default filter
	 * for 'textarea' sanitization and $allowedposttags + embed and script.
	 */
	add_action('admin_init','optionscheck_change_santiziation', 100);
	
	
	function optionscheck_change_santiziation() {
	   remove_filter( 'of_sanitize_textarea', 'of_sanitize_textarea' );
	   add_filter( 'of_sanitize_textarea', create_function('$input', 'return $input;') );
	}