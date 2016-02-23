<?php

class Particle_Settings {

	public function __construct() {
		add_action( 'admin_init', array( $this, 'settings_api_init' ) );
	}

	public static function get_options() {
		$options = array(
			'particle_light_red' => __( 'Red Light', 'particle-api'),
			'particle_light_green' => __( 'Green Light', 'particle-api'),
			'particle_switch_one' => __( 'Switch 1', 'particle-api'),
			'particle_switch_two' => __( 'Switch 2', 'particle-api'),
			'particle_switch_three' => __( 'Switch 3', 'particle-api'),
		);

		return $options;
	}

	/**
	 * Add all your sections, fields and settings during admin_init
	 */
	public function settings_api_init() {
		// Add the section to reading settings so we can add our
		// fields to it
		add_settings_section(
			'particle_api_setting_section',
			__( 'Particle API Settings', 'particle-api' ),
			array( $this, 'setting_section_callback_function' ),
			'reading'
		);

		$this->add_register_settings();

	} // settings_api_init()

	private function add_register_settings() {

		foreach ( Particle_Settings::get_options() as $key => $option ) {
			// Add the field with the names and function to use for our new
			// settings, put it in our new section
			add_settings_field(
				$key,
				$option,
				array( $this, "{$key}_callback_function" ),
				'reading',
				'particle_api_setting_section'
			);

			// Register our setting so that $_POST handling is done for us and
			// our callback function just has to echo the <input>
			register_setting( 'reading', $key );
		}
	}


	/**
	 * Settings section callback function
	 */
	public function setting_section_callback_function() {
		echo '<p>' . __( 'Example Settings', 'particle-api' ) . '</p>';
	}

	/**
	 * Callback function for our example setting
	 * @param $key
	 */
	private function setting_callback_function( $key ) {
		$option = '' === get_option( $key ) ? 'false' : get_option( $key ); ?>
		<label for="<?php esc_attr_e( $key ); ?>-true"><?php _e( 'True', 'particle-api' ); ?></label>
		<input type="radio" id="<?php esc_attr_e( $key ); ?>-true" name="<?php esc_attr_e( $key ); ?>" value="true" <?php checked( 'true' === $option ); ?> />
		<label for="<?php esc_attr_e( $key ); ?>-false"><?php _e( 'False', 'particle-api' ); ?></label>
		<input type="radio" id="<?php esc_attr_e( $key ); ?>-false" name="<?php esc_attr_e( $key ); ?>" value="false" <?php checked( 'false' === $option ); ?> /><?php
	}

	public function particle_light_red_callback_function() {
		$this->setting_callback_function( 'particle_light_red' );
	}

	public function particle_light_green_callback_function() {
		$this->setting_callback_function( 'particle_light_green' );
	}

	public function particle_switch_one_callback_function() {
		$this->setting_callback_function( 'particle_switch_one' );
	}

	public function particle_switch_two_callback_function() {
		$this->setting_callback_function( 'particle_switch_two' );
	}

	public function particle_switch_three_callback_function() {
		$this->setting_callback_function( 'particle_switch_three' );
	}

	public static function add_options() {

		foreach ( self::get_options() as $key => $option ) {
			add_option( $key, false );
		}
	}

	public static function delete_options() {

		foreach ( self::get_options() as $key => $option ) {
			delete_option( $key );
		}
	}
}