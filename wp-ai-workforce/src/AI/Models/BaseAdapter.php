<?php
declare(strict_types=1);

namespace NexusAI\Workforce\AI\Models;

/**
 * Basic adapter with common functionality for AI providers.
 */
abstract class BaseAdapter implements AIModelInterface {

	/**
	 * @var string
	 */
	protected $api_key;

	/**
	 * Constructor.
	 *
	 * @param string $api_key Encrypted or raw API key.
	 */
	public function __construct( string $api_key ) {
		$this->api_key = $api_key;
	}

	/**
	 * Log API errors.
	 */
	protected function log_error( string $message, array $context = [] ): void {
		if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
			error_log( sprintf( '[Nexus AI] %s: %s', $this->get_id(), $message ) );
		}
	}
}
