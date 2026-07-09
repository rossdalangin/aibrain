<?php
declare(strict_types=1);

namespace NexusAI\Workforce\AI\Models;

/**
 * Adapter for OpenAI API.
 */
class OpenAIAdapter extends BaseAdapter {

	/**
	 * @var string
	 */
	private $base_url = 'https://api.openai.com/v1/';

	public function get_id(): string {
		return 'openai';
	}

	public function generate_completion( array $messages, array $settings ): array {
		$model = $settings['model'] ?? 'gpt-4o';

		$body_params = [
			'model'       => $model,
			'messages'    => $messages,
			'temperature' => (float) ( $settings['temperature'] ?? 0.7 ),
			'max_tokens'  => (int) ( $settings['max_tokens'] ?? 2000 ),
		];

		if ( ! empty( $settings['tools'] ) ) {
			$body_params['tools'] = $settings['tools'];
		}

		$response = wp_remote_post( $this->base_url . 'chat/completions', [
			'headers' => [
				'Authorization' => 'Bearer ' . $this->api_key,
				'Content-Type'  => 'application/json',
			],
			'body'    => wp_json_encode( $body_params ),
			'timeout' => 60,
		] );

		if ( is_wp_error( $response ) ) {
			$this->log_error( $response->get_error_message() );
			throw new \Exception( $response->get_error_message() );
		}

		$body = json_decode( wp_remote_retrieve_body( $response ), true );

		if ( isset( $body['error'] ) ) {
			$this->log_error( $body['error']['message'] );
			throw new \Exception( $body['error']['message'] );
		}

		return [
			'content'    => $body['choices'][0]['message']['content'] ?? '',
			'tool_calls' => $body['choices'][0]['message']['tool_calls'] ?? [],
			'usage'      => $body['usage'] ?? [],
		];
	}

	public function generate_embeddings( string $text ): array {
		$response = wp_remote_post( $this->base_url . 'embeddings', [
			'headers' => [
				'Authorization' => 'Bearer ' . $this->api_key,
				'Content-Type'  => 'application/json',
			],
			'body'    => wp_json_encode( [
				'model' => 'text-embedding-3-small',
				'input' => $text,
			] ),
			'timeout' => 30,
		] );

		if ( is_wp_error( $response ) ) {
			throw new \Exception( $response->get_error_message() );
		}

		$body = json_decode( wp_remote_retrieve_body( $response ), true );

		return $body['data'][0]['embedding'] ?? [];
	}
}
