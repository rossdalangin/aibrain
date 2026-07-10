<?php
declare(strict_types=1);

namespace NexusAI\Workforce\AI\Workflows;

use NexusAI\Workforce\AI\Agents\Orchestrator;

/**
 * Executes multi-agent sequential workflows.
 */
class ExecutionEngine {

	private $orchestrator;

	public function __construct( Orchestrator $orchestrator ) {
		$this->orchestrator = $orchestrator;
	}

	/**
	 * Run a defined workflow.
	 *
	 * @param array $workflow_definition JSON-decoded definition (steps, agents).
	 * @param string $input              The initial trigger input.
	 * @return array                     The final state and results of each step.
	 */
	public function run( array $workflow_definition, string $input ): array {
		$state = [ 'initial_input' => $input ];
		$results = [];

		foreach ( $workflow_definition['steps'] as $step ) {
			$agent_id = $step['agent_id'];
			$task     = $step['task_description'];

			// Contextualize task with previous step output
			$task_with_context = "Task: $task\n\nContext from previous steps: " . json_encode( $state );

			// For MVP, we assume agents are loaded/passed in
			$agent_data = [ 'id' => $agent_id, 'name' => "Agent $agent_id" ];

			$output = $this->orchestrator->process_request( $task_with_context, $agent_data );

			$results[] = [
				'step'   => $step['name'],
				'output' => $output,
			];

			$state[ $step['name'] ] = $output;
		}

		return [
			'status'  => 'completed',
			'results' => $results,
		];
	}
}
