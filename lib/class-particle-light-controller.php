<?php

namespace ParticleAPI;

class Particle_Light_Controller extends \WP_REST_Controller implements Particle_Thing_Controllable {

	public static $lights = array(
		'red'   => 'particle_light_red',
		'green' => 'particle_light_green',
	);

	/**
	 * Register the routes for the objects of the controller.
	 */
	public function register_routes() {
		$version   = '1';
		$namespace = 'particle-api/v' . $version;
		$base      = 'light';
		register_rest_route( $namespace, '/' . $base, array(
			array(
				'methods'             => \WP_REST_Server::READABLE,
				'callback'            => array( $this, 'get_items' ),
				'permission_callback' => array( $this, 'get_items_permissions_check' ),
				'args'                => array(),
			),
		) );
		register_rest_route( $namespace, '/' . $base . '/([a-z]*)', array(
			array(
				'methods'             => \WP_REST_Server::READABLE,
				'callback'            => array( $this, 'get_item' ),
				'permission_callback' => array( $this, 'get_item_permissions_check' ),
				'args'                => array(
					'context' => array(
						'default' => 'view',
					),
				),
			),
			array(
				'methods'             => \WP_REST_Server::EDITABLE,
				'callback'            => array( $this, 'update_item' ),
				'permission_callback' => array( $this, 'update_item_permissions_check' ),
				'args'                => $this->get_endpoint_args_for_item_schema( false ),
			),
		) );
		register_rest_route( $namespace, '/' . $base . '/schema', array(
			'methods'  => \WP_REST_Server::READABLE,
			'callback' => array( $this, 'get_public_item_schema' ),
		) );
	}

	/**
	 * Get a collection of items
	 *
	 * @param \WP_REST_Request $request Full data about the request.
	 *
	 * @return \WP_Error|\WP_REST_Response
	 */
	public function get_items( $request ) {

		$lights = array();
		$data   = array();

		foreach ( self::$lights as $key => $light ) {
			$lights[ $key ] = get_option( $light );
		}

		foreach ( $lights as $key => $light ) {
			$object         = new \stdClass();
			$light_data     = $this->prepare_item_for_response( $light, $request );
			$object->status = $this->prepare_response_for_collection( $light_data );
			$data[ $key ]   = $object;
		}

		return new \WP_REST_Response( $data, 200 );
	}

	/**
	 * Get one item from the collection
	 *
	 * @param \WP_REST_Request $request Full data about the request.
	 *
	 * @return \WP_Error|\WP_REST_Response
	 */
	public function get_item( $request ) {
		//get parameters from request
		$params         = $request->get_params();
		$object         = new \stdClass();
		$light          = get_option( self::$lights[ $params[ 0 ] ] );
		$object->status = $this->prepare_item_for_response( $light, $request );

		//return a response or error based on some conditional
		if ( 1 == 1 ) {
			return new \WP_REST_Response( $object, 200 );
		} else {
			return new \WP_Error( 'code', __( 'message', 'particle-api' ) );
		}
	}

	/**
	 * Update one item from the collection
	 *
	 * @param \WP_REST_Request $request Full data about the request.
	 *
	 * @return \WP_Error|\WP_REST_Request
	 */
	public function update_item( $request ) {

		$params = $request->get_params();
		$color  = $params[ 0 ];

		if ( ! array_key_exists( $color, self::$lights ) ) {
			return new \WP_Error( 'cant-update', __( 'message', 'particle-api' ), array( 'status' => 500 ) );
		}

		$json          = json_decode( $request->get_body() );
		$status        = isset( $json->status ) ? $json->status : null;
		$string_status = ( $status ) ? 'true' : 'false';
		$data          = new \stdClass();
		
		update_option( self::$lights[ $color ], $string_status );

		$data->status = $status;

		if ( is_object( $data ) ) {
			return new \WP_REST_Response( $data, 200 );
		}

		return new \WP_Error( 'cant-update', __( 'message', 'particle-api' ), array( 'status' => 500 ) );
	}

	/**
	 * Check if a given request has access to get items
	 *
	 * @param \WP_REST_Request $request Full data about the request.
	 *
	 * @return \WP_Error|bool
	 */
	public function get_items_permissions_check( $request ) {
		//$current_user_can = current_user_can( 'edit_posts' );
		$current_user_can = true; // everyone should be able to read
		return $current_user_can;

	}

	/**
	 * Check if a given request has access to get a specific item
	 *
	 * @param \WP_REST_Request $request Full data about the request.
	 *
	 * @return \WP_Error|bool
	 */
	public function get_item_permissions_check( $request ) {
		return $this->get_items_permissions_check( $request );
	}

	/**
	 * Check if a given request has access to update a specific item
	 *
	 * @param \WP_REST_Request $request Full data about the request.
	 *
	 * @return \WP_Error|bool
	 */
	public function update_item_permissions_check( $request ) {
		$current_user_can = current_user_can( 'edit_posts' );

		return $current_user_can;
	}

	/**
	 * Prepare the item for create or update operation
	 *
	 * @param \WP_REST_Request $request Request object
	 *
	 * @return \WP_Error|object $prepared_item
	 */
	protected function prepare_item_for_database( $request ) {
		return array();
	}

	/**
	 * Prepare the item for the REST response
	 *
	 * @param mixed $item WordPress representation of the item.
	 * @param \WP_REST_Request $request Request object.
	 *
	 * @return mixed
	 */
	public function prepare_item_for_response( $item, $request ) {
		return $item;
	}

	/**
	 * @return array
	 */
	public function get_public_item_schema() {
		return parent::get_public_item_schema(); // TODO: Change the autogenerated stub
	}

	/**
	 * Get the query params for collections
	 *
	 * @return array
	 */
	public function get_collection_params() {
		return array(
			'page'     => array(
				'description'       => 'Current page of the collection.',
				'type'              => 'integer',
				'default'           => 1,
				'sanitize_callback' => 'absint',
			),
			'per_page' => array(
				'description'       => 'Maximum number of items to be returned in result set.',
				'type'              => 'integer',
				'default'           => 10,
				'sanitize_callback' => 'absint',
			),
			'search'   => array(
				'description'       => 'Limit results to those matching a string.',
				'type'              => 'string',
				'sanitize_callback' => 'sanitize_text_field',
			),
		);
	}
}