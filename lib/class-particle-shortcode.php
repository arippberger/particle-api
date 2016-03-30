<?php

namespace ParticleAPI;

class Particle_Shortcode {

	public $add_script;

	/**
	 * Particle_Shortcode constructor.
	 */
	public function __construct() {
		$this->add_script = false;

		add_shortcode( 'particle-api', [ $this, 'particle_shortcode' ] );
		add_action( 'init', [ $this, 'register_scripts' ] );
		add_action( 'wp_footer', [ $this, 'print_scripts' ] );
	}

	/**
	 * Outputs a div to tie our JS tox
	 *
	 * @return string
	 */
	public function particle_shortcode() {
		$this->add_script = true;
		return '<div id="particle-api-shortcode"></div>';
	}

	/**
	 * Register shortcode scripts
	 */
	public function register_scripts() {
		wp_register_script( 'api-shortcode', plugins_url( 'assets/js/dist/particle-api.js', dirname( __FILE__ ) ) );
	}

	/**
	 * Print shortcode scripts
	 *
	 * @return bool
	 */
	public function print_scripts() {
		if ( $this->add_script ) {
			wp_print_scripts( 'api-shortcode' );
		}
	}
}