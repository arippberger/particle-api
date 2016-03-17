<?php

namespace ParticleAPI;

class Particle_Shortcode {

	/**
	 * Particle_Shortcode constructor.
	 */
	public function __construct() {
		add_shortcode( 'particle-api', [ $this, 'particle_shortcode' ] );
	}

	/**
	 * Outputs a div to tie our JS to
	 *
	 * @return string
	 */
	public function particle_shortcode() {
		return '<div class="particle-api-shortcode"></div>';
	}
}