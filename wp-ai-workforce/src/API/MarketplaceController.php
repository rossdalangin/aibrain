<?php
declare(strict_types=1);

namespace NexusAI\Workforce\API;

use WP_REST_Request;
use WP_REST_Response;
use NexusAI\Workforce\Repositories\EmployeeRepository;

/**
 * Controller for Exporting/Importing AI agents.
 */
class MarketplaceController {

	private $repository;

	public function __construct() {
		$this->repository = new EmployeeRepository();
	}

	/**
	 * Export an employee as a JSON Bundle.
	 */
	public function export_item( WP_REST_Request $request ): WP_REST_Response {
		$id = (int) $request['id'];
		$item = $this->repository->get_by_id( $id );

		if ( ! $item ) {
			return new WP_REST_Response( [ 'message' => 'Agent not found' ], 404 );
		}

		// Strip IDs and internal timestamps
		unset( $item['id'], $item['created_at'] );

		$bundle = [
			'version' => '1.0',
			'type'    => 'nexus-ai-bundle',
			'data'    => $item,
		];

		return new WP_REST_Response( $bundle, 200 );
	}

	/**
	 * Import an employee from a JSON Bundle.
	 */
	public function import_item( WP_REST_Request $request ): WP_REST_Response {
		$bundle = $request->get_json_params();

		if ( ! isset( $bundle['type'] ) || $bundle['type'] !== 'nexus-ai-bundle' ) {
			return new WP_REST_Response( [ 'message' => 'Invalid bundle format' ], 400 );
		}

		$data = $bundle['data'];
		$id = $this->repository->create( $data );

		return new WP_REST_Response( [ 'id' => $id, 'success' => true ], 201 );
	}
}
