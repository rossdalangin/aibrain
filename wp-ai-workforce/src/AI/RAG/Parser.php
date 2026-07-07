<?php
declare(strict_types=1);

namespace NexusAI\Workforce\AI\RAG;

/**
 * Handles text extraction from various document types.
 */
class Parser {

	/**
	 * Parse a file and return its text content.
	 *
	 * @param string $filepath Path to the file.
	 * @param string $type     File type (pdf, docx, txt).
	 * @return string
	 */
	public function parse( string $filepath, string $type ): string {
		if ( ! file_exists( $filepath ) ) {
			return '';
		}

		switch ( strtolower( $type ) ) {
			case 'txt':
			case 'md':
				return file_get_contents( $filepath ) ?: '';
			// In a full implementation, we would use specialized libraries for PDF/DOCX
			default:
				return '';
		}
	}
}
