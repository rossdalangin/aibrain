<?php
declare(strict_types=1);

namespace NexusAI\Workforce\AI\Agents;

use NexusAI\Workforce\AI\Models\AIModelInterface;
use NexusAI\Workforce\Integrations\ActionRegistry;
use NexusAI\Workforce\AI\Prompting\PromptBuilder;
use NexusAI\Workforce\AI\RAG\Searcher;

/**
 * Orchestrates multi-agent interactions and task delegation.
 */
class Orchestrator {

	/**
	 * @var AIModelInterface
	 */
	private $model;

	/**
	 * @var ActionRegistry
	 */
	private $action_registry;

	/**
	 * @var PromptBuilder
	 */
	private $prompt_builder;

	/**
	 * @var Searcher
	 */
	private $searcher;

	public function __construct( AIModelInterface $model ) {
		$this->model = $model;
		$this->action_registry = new ActionRegistry();
		$this->prompt_builder = new PromptBuilder();
		$this->searcher = new Searcher();
	}

	/**
	 * Facilitate a multi-agent meeting.
	 *
	 * @param string $topic  The discussion topic.
	 * @param array  $agents Array of agent data.
	 * @return array         Transcript of the meeting.
	 */
	public function facilitate_meeting( string $topic, array $agents ): array {
		$transcript = [];
		$context = "Meeting Topic: $topic\n\nParticipants:\n";

		foreach ( $agents as $agent ) {
			$context .= "- " . $agent['name'] . " (" . $agent['position'] . ")\n";
		}

		// Simplified Round-robin debate for MVP
		foreach ( $agents as $agent ) {
			$prompt = $context . "\nTranscript so far:\n";
			foreach ( $transcript as $entry ) {
				$prompt .= $entry['agent'] . ": " . $entry['content'] . "\n";
			}
			$prompt .= "\n" . $agent['name'] . ", what is your opinion on this?";

			$response = $this->process_request( $prompt, $agent );
			$transcript[] = [
				'agent'   => $agent['name'],
				'content' => $response,
			];
		}

		return $transcript;
	}

	/**
	 * Process a complex request by delegating to specialized agents.
	 *
	 * @param string $request   The user request.
	 * @param array  $agent_data The primary agent data (employee).
	 * @param string $company_context General company context.
	 * @return string           Final response.
	 */
	public function process_request( string $request, array $agent_data, string $company_context = '', string $department_context = '' ): string {
		// 1. Perform RAG search
		$kb_context = $this->searcher->search( $request, [ 'agent_id' => $agent_data['id'] ?? 0 ] );

		// 2. Build system prompt with context layers
		$system_prompt = $this->prompt_builder->build( array_merge( $agent_data, [
			'company_context'    => $company_context,
			'department_context' => $department_context,
			'kb_context'         => $kb_context
		] ) );

		$messages = [
			[ 'role' => 'system', 'content' => $system_prompt ],
			[ 'role' => 'user', 'content' => $request ],
		];

		$settings = $this->parse_settings( $agent_data['model_settings'] ?? '{}' );
		$settings['tools'] = $this->action_registry->get_tools_definition();

		$result = $this->model->generate_completion( $messages, $settings );

		// Handle tool calls if any (Conceptual for MVP)
		if ( ! empty( $result['tool_calls'] ) ) {
			foreach ( $result['tool_calls'] as $tool_call ) {
				$name = $tool_call['function']['name'];
				$args = json_decode( $tool_call['function']['arguments'], true );
				$this->action_registry->execute( $name, $args );
			}
		}

		return $result['content'] ?? 'Action completed.';
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
