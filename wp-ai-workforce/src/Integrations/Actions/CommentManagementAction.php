<?php
declare(strict_types=1);

namespace NexusAI\Workforce\Integrations\Actions;

/**
 * Action to moderate and reply to WordPress comments.
 */
class CommentManagementAction extends BaseAction {

	public function get_name(): string {
		return 'manage_comments';
	}

	public function get_description(): string {
		return 'Moderate, approve, trash, or reply to WordPress comments.';
	}

	public function get_parameters(): array {
		return [
			'type'       => 'object',
			'properties' => [
				'action'     => [
					'type'        => 'string',
					'enum'        => [ 'approve', 'hold', 'spam', 'trash', 'reply' ],
					'description' => 'The action to perform on the comment.',
				],
				'comment_id' => [
					'type'        => 'integer',
					'description' => 'The ID of the comment to manage.',
				],
				'content'    => [
					'type'        => 'string',
					'description' => 'The reply content (required if action is "reply").',
				],
			],
			'required'   => [ 'action', 'comment_id' ],
		];
	}

	public function execute( array $args ) {
		$comment_id = (int) $args['comment_id'];
		$action     = $args['action'];

		if ( ! get_comment( $comment_id ) ) {
			return [
				'success' => false,
				'message' => "Comment ID $comment_id not found.",
			];
		}

		switch ( $action ) {
			case 'approve':
				wp_set_comment_status( $comment_id, 'approve' );
				return [ 'success' => true, 'message' => "Comment $comment_id approved." ];
			case 'hold':
				wp_set_comment_status( $comment_id, 'hold' );
				return [ 'success' => true, 'message' => "Comment $comment_id held for moderation." ];
			case 'spam':
				wp_set_comment_status( $comment_id, 'spam' );
				return [ 'success' => true, 'message' => "Comment $comment_id marked as spam." ];
			case 'trash':
				wp_trash_comment( $comment_id );
				return [ 'success' => true, 'message' => "Comment $comment_id moved to trash." ];
			case 'reply':
				if ( empty( $args['content'] ) ) {
					return [ 'success' => false, 'message' => 'Reply content is required.' ];
				}
				$user = wp_get_current_user();
				$data = [
					'comment_post_ID'      => get_comment( $comment_id )->comment_post_ID,
					'comment_author'       => $user->display_name,
					'comment_author_email' => $user->user_email,
					'comment_content'      => $args['content'],
					'comment_parent'       => $comment_id,
					'user_id'              => $user->ID,
					'comment_approved'     => 1,
				];
				$new_comment_id = wp_insert_comment( $data );
				return [
					'success'    => true,
					'message'    => 'Reply posted successfully.',
					'comment_id' => $new_comment_id,
				];
			default:
				return [ 'success' => false, 'message' => 'Invalid action.' ];
		}
	}
}
