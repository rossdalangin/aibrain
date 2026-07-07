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
	 * @param string $request The user request.
	 * @param array  $agents  Available agents (employees).
	 * @return string         Final response.
	 */
	public function process_request( string $request, array $agents ): string {
		// 1. Analyze request and create a plan (High-level reasoning)
		// 2. Select agents and dispatch tasks
		// 3. Synthesize results

		// For MVP, we pass it through to the primary model with context
		$messages = [
			[ 'role' => 'system', 'content' => 'You are the Nexus AI Orchestrator. Manage the available agents to solve the user request.' ],
			[ 'role' => 'user', 'content' => $request ],
		];

		$result = $this->model->generate_completion( $messages, [] );
		return $result['content'] ?? 'Error in orchestration';
	}
}
