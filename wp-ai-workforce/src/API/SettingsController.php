<?php
declare(strict_types=1);

namespace NexusAI\Workforce\API;

use WP_REST_Request;
use WP_REST_Response;
use NexusAI\Workforce\Repositories\SettingsRepository;
use NexusAI\Workforce\Utils\Encryption;

/**
 * Controller for managing plugin settings.
 */
class SettingsController {

	/**
	 * @var SettingsRepository
	 */
	private $repository;

	/**
	 * @var Encryption
	 */
	private $encryption;

	public function __construct() {
		$this->repository = new SettingsRepository();
		$this->encryption = new Encryption();
	}

	public function get_items( WP_REST_Request $request ): WP_REST_Response {
		$settings = $this->repository->get_all();

		$sensitive_keys = [ 'openai_api_key', 'claude_api_key', 'gemini_api_key', 'openrouter_api_key' ];

		// Mask sensitive data
		foreach ( $sensitive_keys as $key ) {
			if ( ! empty( $settings[ $key ] ) ) {
				$settings[ $key ] = '********';
			}
		}

		return new WP_REST_Response( $settings, 200 );
	}

	public function update_item( WP_REST_Request $request ): WP_REST_Response {
		$params = $request->get_params();
		$data = [];

		$sensitive_keys = [ 'openai_api_key', 'claude_api_key', 'gemini_api_key', 'openrouter_api_key' ];

		foreach ( $sensitive_keys as $key ) {
			if ( isset( $params[ $key ] ) && $params[ $key ] !== '********' ) {
				$data[ $key ] = $this->encryption->encrypt( $params[ $key ] );
			}
		}

		if ( isset( $params['default_model'] ) ) {
			$data['default_model'] = sanitize_text_field( $params['default_model'] );
		}

		if ( isset( $params['company_name'] ) ) {
			$data['company_name'] = sanitize_text_field( $params['company_name'] );
		}

		$success = $this->repository->update( $data );
		return new WP_REST_Response( [ 'success' => $success ], 200 );
	}
}
