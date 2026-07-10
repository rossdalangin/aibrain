<?php
declare(strict_types=1);

namespace NexusAI\Workforce\AI\RAG;

/**
 * Handles retrieval of relevant context from the vector database.
 */
class Searcher {

	/**
	 * Search for context chunks relevant to a query.
	 *
	 * @param string $query    The user question.
	 * @param array  $filters  Search filters (agent_id, dept_id).
	 * @return string          Concatenated context.
	 */
	public function search( string $query, array $filters = [] ): string {
		global $wpdb;

		// 1. Keyword-based matching as a robust fallback for SQLite-vss
		$table = $wpdb->prefix . 'ai_knowledge_chunks';

		$results = $wpdb->get_results( $wpdb->prepare(
			"SELECT content FROM $table WHERE content LIKE %s LIMIT 3",
			'%' . $wpdb->esc_like( $query ) . '%'
		), ARRAY_A );

		if ( empty( $results ) ) {
			return "";
		}

		$context = "Relevant information from Knowledge Base:\n";
		foreach ( $results as $row ) {
			$context .= "- " . $row['content'] . "\n";
		}

		return $context;
	}
}
