<?php
/**
 * Plugin Name: Particle API
 * Version: 0.1-alpha
 * Description: Plugin provides API endpoints and a front end interface for interacting with a Particle Photon Wi-Fi device.
 * Author: Alec Rippberger
 * Author URI: http://alecrippberger.com
 * Plugin URI: http://alecrippberger.com
 * Text Domain: particle-api
 * Domain Path: /languages
 * @package Particle-API
 */

class Particle_API {

	public static $options = array(
		'particle_light_red',
		'particle_light_green',
		'particle_switch_one',
		'particle_switch_two',
		'particle_switch_three'
	);

	public function __construct() {

	}

	public function run() {
		add_action( 'plugins_loaded', array( $this, 'include_files' ) );
		add_action( 'rest_api_init', array( $this, 'register_routes' ) );
	}

	public function include_files() {
		include plugin_dir_path( __FILE__ ) . "lib/interface-particle-thing-controllable.php";
		include plugin_dir_path( __FILE__ ) . "lib/class-particle-light-controller.php";
		include plugin_dir_path( __FILE__ ) . "lib/class-particle-switch-controller.php";
	}

	public function register_routes() {
		$particle_light_controller = new Particle_Light_Controller();
		$particle_light_controller->register_routes();
		$particle_switch_controller = new Particle_Switch_Controller();
		$particle_switch_controller->register_routes();
	}

	public static function activation() {

		foreach ( self::$options as $option ) {
			add_option( $option, false );
		}
	}

	public static function deactivation() {

		foreach ( self::$options as $option ) {
			delete_option( $option );
		}
	}
}

register_activation_hook( __FILE__, array( 'Particle_API', 'activation' ) );
register_deactivation_hook( __FILE__, array( 'Particle_API', 'deactivation' ) );

$particle_api = new Particle_API();
$particle_api->run();


