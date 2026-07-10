<?php
declare(strict_types=1);

namespace NexusAI\Workforce\API;

use WP_REST_Request;
use WP_REST_Response;
use NexusAI\Workforce\AI\RAG\Parser;
use NexusAI\Workforce\AI\RAG\Chunker;
use NexusAI\Workforce\Repositories\DocumentRepository;

/**
 * Controller for Knowledge Base ingestion.
 */
class KBController {

	private $parser;
	private $chunker;
	private $repository;

	public function __construct() {
		$this->parser     = new Parser();
		$this->chunker    = new Chunker();
		$this->repository = new DocumentRepository();
	}

	/**
	 * Handle document ingestion.
	 */
	public function ingest_item( WP_REST_Request $request ): WP_REST_Response {
		$params = $request->get_params();
		$url    = esc_url_raw( $params['url'] ?? '' );

		if ( empty( $url ) ) {
			return new WP_REST_Response( [ 'message' => 'URL is required' ], 400 );
		}

		// 1. Fetch content (Scraper Logic)
		$response = wp_remote_get( $url );
		if ( is_wp_error( $response ) ) {
			return new WP_REST_Response( [ 'message' => 'Failed to fetch URL' ], 500 );
		}

		$html = wp_remote_retrieve_body( $response );
		$text = wp_strip_all_tags( $html );

		// 2. Chunk text
		$chunks = $this->chunker->chunk( $text );

		// 3. Store document metadata
		$doc_id = $this->repository->create( [
			'kb_id'       => 1, // Default Global KB
			'type'        => 'url',
			'source_path' => $url,
			'status'      => 'indexed',
		] );

		// 4. Store chunks
		global $wpdb;
		foreach ( $chunks as $chunk ) {
			$wpdb->insert( $wpdb->prefix . 'ai_knowledge_chunks', [
				'doc_id'  => $doc_id,
				'content' => $chunk,
			] );
		}

		return new WP_REST_Response( [ 'success' => true, 'doc_id' => $doc_id, 'chunks' => count( $chunks ) ], 200 );
	}

	/**
	 * Handle file upload for RAG.
	 */
	public function upload_item( WP_REST_Request $request ): WP_REST_Response {
		$files = $request->get_file_params();
		if ( empty( $files['file'] ) ) {
			return new WP_REST_Response( [ 'message' => 'No file uploaded' ], 400 );
		}

		$file = $files['file'];
		$ext  = pathinfo( $file['name'], PATHINFO_EXTENSION );
		$text = $this->parser->parse( $file['tmp_name'], $ext );

		if ( empty( $text ) ) {
			return new WP_REST_Response( [ 'message' => 'Failed to parse file or file empty' ], 400 );
		}

		$chunks = $this->chunker->chunk( $text );
		$doc_id = $this->repository->create( [
			'kb_id'       => 1,
			'type'        => 'file',
			'source_path' => $file['name'],
			'status'      => 'indexed',
		] );

		global $wpdb;
		foreach ( $chunks as $chunk ) {
			$wpdb->insert( $wpdb->prefix . 'ai_knowledge_chunks', [
				'doc_id'  => $doc_id,
				'content' => $chunk,
			] );
		}

		return new WP_REST_Response( [ 'success' => true, 'doc_id' => $doc_id, 'chunks' => count( $chunks ) ], 200 );
	}
}
