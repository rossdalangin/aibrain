<?php
declare(strict_types=1);

namespace NexusAI\Workforce\AI\Models;

/**
 * Adapter for Anthropic Claude API.
 */
class ClaudeAdapter extends BaseAdapter {

	/**
	 * @var string
	 */
	private $base_url = 'https://api.anthropic.com/v1/';

	public function get_id(): string {
		return 'claude';
	}

	public function generate_completion( array $messages, array $settings ): array {
		$model = $settings['model'] ?? 'claude-3-5-sonnet-20240620';

		$response = wp_remote_post( $this->base_url . 'messages', [
			'headers' => [
				'x-api-key'         => $this->api_key,
				'anthropic-version' => '2023-06-01',
				'content-type'      => 'application/json',
			],
			'body'    => wp_json_encode( [
				'model'      => $model,
				'messages'   => $messages,
				'max_tokens' => (int) ( $settings['max_tokens'] ?? 2048 ),
				'system'     => $settings['system_prompt'] ?? '',
			] ),
			'timeout' => 60,
		] );

		if ( is_wp_error( $response ) ) {
			throw new \Exception( $response->get_error_message() );
		}

		$body = json_decode( wp_remote_retrieve_body( $response ), true );

		if ( isset( $body['error'] ) ) {
			throw new \Exception( $body['error']['message'] );
		}

		return [
			'content' => $body['content'][0]['text'] ?? '',
			'usage'   => $body['usage'] ?? [],
		];
	}

	public function generate_embeddings( string $text ): array {
		// Anthropic does not have a native embeddings API yet
		return [];
	}
}
