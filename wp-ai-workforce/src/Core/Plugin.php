<?php
declare(strict_types=1);

namespace NexusAI\Workforce\Core;

class Plugin {
	private static $instance = null;

	public static function instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	public function init() {
		$this->register_hooks();
		$this->init_components();
	}

	private function register_hooks() {
		add_action( 'admin_menu', [ $this, 'add_admin_menu' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_admin_assets' ] );
	}

	private function init_components() {
		// Initialize REST API
		if ( class_exists( 'NexusAI\\Workforce\\API\\RestHandler' ) ) {
			( new \NexusAI\Workforce\API\RestHandler() )->init();
		}
	}

	public function add_admin_menu() {
		add_menu_page(
			__( 'Nexus AI', 'nexus-ai-workforce' ),
			__( 'Nexus AI', 'nexus-ai-workforce' ),
			'manage_options',
			'nexus-ai-workforce',
			[ $this, 'render_overview_page' ],
			'dashicons-superhero',
			2
		);

		add_submenu_page(
			'nexus-ai-workforce',
			__( 'Workforce', 'nexus-ai-workforce' ),
			'Hire AI Agents',
			'manage_options',
			'nexus-ai-workforce-employees',
			[ $this, 'render_workforce_page' ]
		);

		add_submenu_page(
			'nexus-ai-workforce',
			__( 'Knowledge Base', 'nexus-ai-workforce' ),
			'Company Brain',
			'manage_options',
			'nexus-ai-workforce-kb',
			[ $this, 'render_kb_page' ]
		);

		add_submenu_page(
			'nexus-ai-workforce',
			__( 'Workflows', 'nexus-ai-workforce' ),
			'Automations',
			'manage_options',
			'nexus-ai-workforce-workflows',
			[ $this, 'render_workflows_page' ]
		);

		add_submenu_page(
			'nexus-ai-workforce',
			__( 'Settings', 'nexus-ai-workforce' ),
			'System Config',
			'manage_options',
			'nexus-ai-workforce-settings',
			[ $this, 'render_settings_page' ]
		);
	}

	public function render_admin_page() {
		echo '<div id="nexus-ai-admin-root"></div>';
	}

	public function render_workforce_page() {
		if ( class_exists( 'NexusAI\\Workforce\\UI\\AdminRenderer' ) ) {
			( new \NexusAI\Workforce\UI\AdminRenderer() )->render_workforce_page();
		}
	}

	public function render_settings_page() {
		if ( class_exists( 'NexusAI\\Workforce\\UI\\AdminRenderer' ) ) {
			( new \NexusAI\Workforce\UI\AdminRenderer() )->render_settings_page();
		}
	}

	public function render_kb_page() {
		if ( class_exists( 'NexusAI\\Workforce\\UI\\AdminRenderer' ) ) {
			( new \NexusAI\Workforce\UI\AdminRenderer() )->render_kb_page();
		}
	}

	public function render_overview_page() {
		if ( class_exists( 'NexusAI\\Workforce\\UI\\AdminRenderer' ) ) {
			( new \NexusAI\Workforce\UI\AdminRenderer() )->render_overview_page();
		}
	}

	public function render_workflows_page() {
		if ( class_exists( 'NexusAI\\Workforce\\UI\\AdminRenderer' ) ) {
			( new \NexusAI\Workforce\UI\AdminRenderer() )->render_workflows_page();
		}
	}

	public function enqueue_admin_assets( $hook ) {
		if ( strpos( $hook, 'nexus-ai-workforce' ) === false ) {
			return;
		}

		// Enqueue Tailwind CDN for immediate preview in development
		wp_enqueue_script( 'nexus-ai-tailwind', 'https://cdn.tailwindcss.com', [], '3.3.0' );

		wp_enqueue_style( 'nexus-ai-premium', plugins_url( 'assets/css/nexus-ui.css', dirname( __FILE__, 2 ) ), [], '1.0.0' );

		// Enqueue React build (assuming webpack output)
		if ( file_exists( dirname( __FILE__, 2 ) . '/assets/js/admin.js' ) ) {
			wp_enqueue_script( 'nexus-ai-admin', plugins_url( 'assets/js/admin.js', dirname( __FILE__, 2 ) ), [ 'wp-element', 'wp-api-fetch' ], '1.0.0', true );
		}
	}
}
