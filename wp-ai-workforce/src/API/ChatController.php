<?php
declare(strict_types=1);

namespace NexusAI\Workforce\API;

use WP_REST_Request;
use WP_REST_Response;
use NexusAI\Workforce\Repositories\ConversationRepository;
use NexusAI\Workforce\Repositories\MessageRepository;
use NexusAI\Workforce\Repositories\EmployeeRepository;
use NexusAI\Workforce\AI\Agents\Orchestrator;
use NexusAI\Workforce\AI\Models\OpenAIAdapter;
use NexusAI\Workforce\Utils\Encryption;
use NexusAI\Workforce\Repositories\SettingsRepository;

/**
 * Controller for Chat and Multi-Agent interactions.
 */
class ChatController {

	private $conversations;
	private $messages;
	private $employees;
	private $settings;

	public function __construct() {
		$this->conversations = new ConversationRepository();
		$this->messages      = new MessageRepository();
		$this->employees     = new EmployeeRepository();
		$this->settings      = new SettingsRepository();
	}

	public function get_conversations( WP_REST_Request $request ): WP_REST_Response {
		$user_id = get_current_user_id();
		$items = $this->conversations->get_user_conversations( $user_id );
		return new WP_REST_Response( $items, 200 );
	}

	public function send_message( WP_REST_Request $request ): WP_REST_Response {
		$user_id = get_current_user_id();
		$params  = $request->get_params();

		$conversation_id = (int) ( $params['conversation_id'] ?? 0 );
		$employee_id     = (int) ( $params['employee_id'] ?? 0 );
		$content         = sanitize_textarea_field( $params['message'] ?? '' );

		if ( ! $conversation_id ) {
			$conversation_id = $this->conversations->create( [
				'user_id' => $user_id,
				'title'   => mb_substr( $content, 0, 50 ),
				'status'  => 'active',
			] );
		}

		// Store User Message
		$this->messages->create( [
			'conversation_id' => $conversation_id,
			'sender_type'     => 'user',
			'sender_id'       => $user_id,
			'content'         => $content,
		] );

		// Process with AI
		$employee = $this->employees->get_by_id( $employee_id );
		$orchestrator = $this->get_orchestrator();

		$response = $orchestrator->process_request( $content, $employee ?: [] );

		// Store AI Message
		$this->messages->create( [
			'conversation_id' => $conversation_id,
			'sender_type'     => 'ai',
			'sender_id'       => $employee_id,
			'content'         => $response,
		] );

		$this->conversations->update_last_message_at( $conversation_id );

		return new WP_REST_Response( [ 'response' => $response, 'conversation_id' => $conversation_id ], 200 );
	}

	private function get_orchestrator(): Orchestrator {
		$encryption = new Encryption();
		$api_key = $encryption->decrypt( $this->settings->get( 'openai_api_key', '' ) );
		$model = new OpenAIAdapter( $api_key );
		return new Orchestrator( $model );
	}
}
