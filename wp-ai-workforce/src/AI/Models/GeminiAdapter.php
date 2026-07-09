<?php
declare(strict_types=1);

namespace NexusAI\Workforce\AI\Models;

/**
 * Adapter for Google Gemini API.
 */
class GeminiAdapter extends BaseAdapter {

	/**
	 * @var string
	 */
	private $base_url = 'https://generativelanguage.googleapis.com/v1beta/models/';

	public function get_id(): string {
		return 'gemini';
	}

	public function generate_completion( array $messages, array $settings ): array {
		$model = $settings['model'] ?? 'gemini-1.5-pro';
		$api_key = $this->api_key;

		// Convert OpenAI format to Gemini format
		$contents = [];
		foreach ( $messages as $msg ) {
			$role = ( $msg['role'] === 'user' ) ? 'user' : 'model';
			$contents[] = [
				'role'  => $role,
				'parts' => [ [ 'text' => $msg['content'] ] ],
			];
		}

		$url = $this->base_url . $model . ':generateContent?key=' . $api_key;

		$response = wp_remote_post( $url, [
			'headers' => [
				'Content-Type' => 'application/json',
			],
			'body'    => wp_json_encode( [
				'contents' => $contents,
				'generationConfig' => [
					'temperature' => (float) ( $settings['temperature'] ?? 0.7 ),
					'maxOutputTokens' => (int) ( $settings['max_tokens'] ?? 2048 ),
				],
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
			'content' => $body['candidates'][0]['content']['parts'][0]['text'] ?? '',
			'usage'   => $body['usageMetadata'] ?? [],
		];
	}

	public function generate_embeddings( string $text ): array {
		$model = 'text-embedding-004';
		$url = $this->base_url . $model . ':embedContent?key=' . $this->api_key;

		$response = wp_remote_post( $url, [
			'headers' => [ 'Content-Type' => 'application/json' ],
			'body'    => wp_json_encode( [
				'model'   => 'models/' . $model,
				'content' => [ 'parts' => [ [ 'text' => $text ] ] ],
			] ),
			'timeout' => 30,
		] );

		if ( is_wp_error( $response ) ) {
			return [];
		}

		$body = json_decode( wp_remote_retrieve_body( $response ), true );

		return $body['embedding']['values'] ?? [];
	}
}
