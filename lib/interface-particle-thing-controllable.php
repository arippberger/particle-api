<?php

namespace ParticleAPI;

interface Particle_Thing_Controllable {
	public function register_routes();
	public function get_items( $request );
	public function get_item( $request );
	public function update_item( $request );
	public function get_items_permissions_check( $request );
	public function get_item_permissions_check( $request );
	public function update_item_permissions_check( $request );
	public function prepare_item_for_response( $item, $request );
	public function get_collection_params();
	public function get_public_item_schema();
}