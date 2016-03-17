<?php
/**
 * Plugin Name: Particle API
 * Version: 0.1.0
 * Description: Plugin provides API endpoints and a front end interface for interacting with a Particle Photon Wi-Fi device. Requires PHP 5.4 +
 * Author: Alec Rippberger
 * Author URI: http://alecrippberger.com
 * Plugin URI: http://alecrippberger.com
 * Text Domain: particle-api
 * Domain Path: /languages
 * Requires: php5.4+
 * @package Particle-API
 */

namespace ParticleAPI;
use Particle_Settings;

class Particle_API {

	public function __construct() {
		$this->include_files();
	}

	/**
	 * Main class method - should fire everything off
	 */
	public function run() {
		add_action( 'plugins_loaded', array( $this, 'include_api_files' ) );
		add_action( 'rest_api_init', array( $this, 'register_routes' ) );

		new Particle_Settings();
		new Particle_Shortcode();
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
		include plugin_dir_path( __FILE__ ) . "lib/class-particle-shortcode.php";
	}

	/**
	 * Register API routes
	 */
	public function register_routes() {
		( new Particle_Light_Controller() )->register_routes();
		( new Particle_Switch_Controller() )->register_routes();
	}

	/**
	 * Fired on plugin activation
	 */
	public function activation() {
		Particle_Settings::add_options();
	}

	/**
	 * Fired on plugin deactivation
	 */
	public function deactivation() {
		Particle_Settings::delete_options();
	}
}

$particle_api = new Particle_API();
register_activation_hook( __FILE__, array( $particle_api, 'activation' ) );
register_deactivation_hook( __FILE__, array( $particle_api, 'deactivation' ) );
$particle_api->run();


