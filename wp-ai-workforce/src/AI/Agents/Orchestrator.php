<?php
declare(strict_types=1);

namespace NexusAI\Workforce\AI\Agents;

use NexusAI\Workforce\AI\Models\AIModelInterface;

/**
 * Orchestrates multi-agent interactions and task delegation.
 */
class Orchestrator {

	/**
	 * @var AIModelInterface
	 */
	private $model;

	public function __construct( AIModelInterface $model ) {
		$this->model = $model;
	}

	/**
	 * Process a complex request by delegating to specialized agents.
	 *
	 * @param string $request   The user request.
	 * @param array  $agent_data The primary agent data (employee).
	 * @param string $company_context General company context.
	 * @return string           Final response.
	 */
	public function process_request( string $request, array $agent_data, string $company_context = '' ): string {
		$system_prompt = $this->build_system_prompt( $agent_data, $company_context );

		$messages = [
			[ 'role' => 'system', 'content' => $system_prompt ],
			[ 'role' => 'user', 'content' => $request ],
		];

		$result = $this->model->generate_completion( $messages, $this->parse_settings( $agent_data['model_settings'] ?? '{}' ) );
		return $result['content'] ?? 'Error in orchestration';
	}

	/**
	 * Build a comprehensive system prompt for the agent.
	 */
	private function build_system_prompt( array $agent_data, string $company_context ): string {
		$prompt = "Identity: " . ( $agent_data['name'] ?? 'AI Assistant' ) . "\n";
		$prompt .= "Role: " . ( $agent_data['position'] ?? 'Expert' ) . "\n\n";
		$prompt .= "Mission: " . ( $agent_data['role_description'] ?? 'Help the user.' ) . "\n\n";

		if ( ! empty( $agent_data['responsibilities'] ) ) {
			$prompt .= "Responsibilities:\n" . $agent_data['responsibilities'] . "\n\n";
		}

		if ( ! empty( $company_context ) ) {
			$prompt .= "Company Context:\n" . $company_context . "\n\n";
		}

		$prompt .= "Instructions: Always remain in character. Use the knowledge provided. If you don't know something, say you don't know.";

		return $prompt;
	}

	/**
	 * Parse model settings from JSON.
	 */
	private function parse_settings( $settings ): array {
		if ( is_string( $settings ) ) {
			return json_decode( $settings, true ) ?: [];
		}
		return (array) $settings;
	}
}
