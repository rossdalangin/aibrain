<?php
declare(strict_types=1);

namespace NexusAI\Workforce\API;

use WP_REST_Server;

/**
 * Handles registration of Nexus AI REST API endpoints.
 */
class RestHandler {

	/**
	 * @var string
	 */
	private $namespace = 'nexus-ai/v1';

	/**
	 * Initialize the REST API.
	 */
	public function init(): void {
		add_action( 'rest_api_init', [ $this, 'register_routes' ] );
	}

	/**
	 * Register all routes.
	 */
	public function register_routes(): void {
		$employee_controller = new EmployeeController();
		$chat_controller = new ChatController();
		$settings_controller = new SettingsController();
		$status_controller = new StatusController();
		$marketplace_controller = new MarketplaceController();
		$kb_controller = new KBController();
		$billing_controller = new BillingController();

		register_rest_route( $this->namespace, '/settings', [
			[
				'methods'             => WP_REST_Server::READABLE,
				'callback'            => [ $settings_controller, 'get_items' ],
				'permission_callback' => [ $this, 'check_permission' ],
			],
			[
				'methods'             => WP_REST_Server::EDITABLE,
				'callback'            => [ $settings_controller, 'update_item' ],
				'permission_callback' => [ $this, 'check_permission' ],
			],
		] );

		register_rest_route( $this->namespace, '/billing/plans', [
			[
				'methods'             => WP_REST_Server::READABLE,
				'callback'            => [ $billing_controller, 'get_plans' ],
				'permission_callback' => [ $this, 'check_permission' ],
			],
		] );

		register_rest_route( $this->namespace, '/billing/coupon', [
			[
				'methods'             => WP_REST_Server::CREATABLE,
				'callback'            => [ $billing_controller, 'apply_coupon' ],
				'permission_callback' => [ $this, 'check_permission' ],
			],
		] );

		register_rest_route( $this->namespace, '/kb/ingest', [
			[
				'methods'             => WP_REST_Server::CREATABLE,
				'callback'            => [ $kb_controller, 'ingest_item' ],
				'permission_callback' => [ $this, 'check_permission' ],
			],
		] );

		register_rest_route( $this->namespace, '/marketplace/export/(?P<id>\d+)', [
			[
				'methods'             => WP_REST_Server::READABLE,
				'callback'            => [ $marketplace_controller, 'export_item' ],
				'permission_callback' => [ $this, 'check_permission' ],
			],
		] );

		register_rest_route( $this->namespace, '/marketplace/import', [
			[
				'methods'             => WP_REST_Server::CREATABLE,
				'callback'            => [ $marketplace_controller, 'import_item' ],
				'permission_callback' => [ $this, 'check_permission' ],
			],
		] );

		register_rest_route( $this->namespace, '/status', [
			[
				'methods'             => WP_REST_Server::READABLE,
				'callback'            => [ $status_controller, 'get_status' ],
				'permission_callback' => [ $this, 'check_permission' ],
			],
		] );

		register_rest_route( $this->namespace, '/conversations', [
			[
				'methods'             => WP_REST_Server::READABLE,
				'callback'            => [ $chat_controller, 'get_conversations' ],
				'permission_callback' => [ $this, 'check_permission' ],
			],
			[
				'methods'             => WP_REST_Server::CREATABLE,
				'callback'            => [ $chat_controller, 'send_message' ],
				'permission_callback' => [ $this, 'check_permission' ],
			],
		] );

		register_rest_route( $this->namespace, '/employees', [
			[
				'methods'             => WP_REST_Server::READABLE,
				'callback'            => [ $employee_controller, 'get_items' ],
				'permission_callback' => [ $this, 'check_permission' ],
			],
			[
				'methods'             => WP_REST_Server::CREATABLE,
				'callback'            => [ $employee_controller, 'create_item' ],
				'permission_callback' => [ $this, 'check_permission' ],
			],
		] );

		register_rest_route( $this->namespace, '/workflows', [
			[
				'methods'             => WP_REST_Server::CREATABLE,
				'callback'            => function( \WP_REST_Request $request ) {
					$params = $request->get_params();
					$repo = new \NexusAI\Workforce\Repositories\WorkflowRepository();
					$id = $repo->create( [
						'name'       => sanitize_text_field( $params['name'] ),
						'definition' => wp_json_encode( $params['steps'] ),
						'status'     => 'active'
					] );
					return new \WP_REST_Response( [ 'id' => $id ], 201 );
				},
				'permission_callback' => [ $this, 'check_permission' ],
			],
		] );

		register_rest_route( $this->namespace, '/employees/(?P<id>\d+)', [
			[
				'methods'             => WP_REST_Server::READABLE,
				'callback'            => [ $employee_controller, 'get_item' ],
				'permission_callback' => [ $this, 'check_permission' ],
			],
			[
				'methods'             => WP_REST_Server::EDITABLE,
				'callback'            => [ $employee_controller, 'update_item' ],
				'permission_callback' => [ $this, 'check_permission' ],
			],
			[
				'methods'             => WP_REST_Server::DELETABLE,
				'callback'            => [ $employee_controller, 'delete_item' ],
				'permission_callback' => [ $this, 'check_permission' ],
			],
		] );
	}

	/**
	 * Check if the user has permission to access the API.
	 */
	public function check_permission(): bool {
		return current_user_can( 'manage_options' );
	}
}
