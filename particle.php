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

	public function __construct() {
		$this->include_files();
	}

	public function run() {
		add_action( 'plugins_loaded', array( $this, 'include_api_files' ) );
		add_action( 'rest_api_init', array( $this, 'register_routes' ) );

		new Particle_Settings();
	}

	/**
	 * Include files that depend on WordPress API
	 */
	public function include_api_files() {
		include plugin_dir_path( __FILE__ ) . "lib/interface-particle-thing-controllable.php";
		include plugin_dir_path( __FILE__ ) . "lib/class-particle-light-controller.php";
		include plugin_dir_path( __FILE__ ) . "lib/class-particle-switch-controller.php";
	}

	/**
	 * Include other plugin files
	 */
	private function include_files() {
		include plugin_dir_path( __FILE__ ) . "lib/class-particle-settings.php";
	}

	public function register_routes() {
		$particle_light_controller = new Particle_Light_Controller();
		$particle_light_controller->register_routes();
		$particle_switch_controller = new Particle_Switch_Controller();
		$particle_switch_controller->register_routes();
	}

	public function activation() {
		Particle_Settings::add_options();
	}

	public function deactivation() {
		Particle_Settings::delete_options();
	}
}

$particle_api = new Particle_API();
register_activation_hook( __FILE__, array( $particle_api, 'activation' ) );
register_deactivation_hook( __FILE__, array( $particle_api, 'deactivation' ) );
$particle_api->run();


