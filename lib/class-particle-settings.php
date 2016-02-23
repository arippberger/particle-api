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
			'particle_light_setting_section',
			__( 'Particle API LED Settings', 'particle-api' ),
			array( $this, 'light_setting_section_callback_function' ),
			'reading'
		);

		add_settings_section(
			'particle_switch_setting_section',
			__( 'Particle API Switch Settings', 'particle-api' ),
			array( $this, 'switch_setting_section_callback_function' ),
			'reading'
		);

		$this->add_register_settings();

	} // settings_api_init()

	private function add_register_settings() {
		$options = Particle_Settings::get_options();
		$this->add_settings_field_to_section( $options );
	}

	private function add_settings_field_to_section( $options, $passed_section = null ) {

		$section = null;
		foreach ( $options as $key => $option ) {

			// if no section has been passed add to setting to the section based on the beginning of its name.
			if ( empty( $passed_section ) ) {
				$start_of_key = substr( $key, 0, 14 );

				switch ( $start_of_key ) {
					case 'particle_light' :
						$section = 'particle_light_setting_section';

						break;
					case 'particle_switc' :
						$section = 'particle_switch_setting_section';
						break;
				}
			} else {
				$section = $passed_section;
			}

			// Add the field
			add_settings_field(
				$key,
				$option,
				array( $this, "{$key}_callback_function" ),
				'reading',
				$section
			);

			// Register our setting so that $_POST handling is done for us and
			// our callback function just has to echo the <input>
			register_setting( 'reading', $key );
		}
	}


	/**
	 * Settings section callback function
	 */
	public function light_setting_section_callback_function() {
		echo '<p>' . __( 'Settings for the board LED lights.
						Updating a setting here will either cause the LED to turn on or off.
						However, there is no way to update these settings from the board.
						Settings -> board relationship.', 'particle-api' ) . '</p>';
	}

	/**
	 * Settings section callback function
	 */
	public function switch_setting_section_callback_function() {
		echo '<p>' . __( 'Settings for the board switches.
						Switching a switch will cause the settings shown here to update on refresh.
						However, updating a setting here will not cause the switch to update.
						Board -> settings relationship.', 'particle-api' ) . '</p>';
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