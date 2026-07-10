<?php
declare(strict_types=1);

namespace NexusAI\Workforce\UI;

use NexusAI\Workforce\Repositories\SettingsRepository;

/**
 * Renders the visible Admin UI forms and components.
 */
class AdminRenderer {

	private $settings;

	public function __construct() {
		$this->settings = new SettingsRepository();
	}

	private function get_brand_styles(): string {
		$color = $this->settings->get( 'ui_color', '#7C3AED' );
		return "<style>:root { --nexus-violet: $color !important; } .text-nexus-violet { color: $color !important; } .bg-nexus-violet { background-color: $color !important; }</style>";
	}

	/**
	 * Render the "Overview" dashboard page.
	 */
	public function render_overview_page(): void {
		echo $this->get_brand_styles();
		global $wpdb;
		$agent_count = $wpdb->get_var( "SELECT COUNT(*) FROM {$wpdb->prefix}ai_employees WHERE is_active = 1" ) ?: 0;
		$doc_count   = $wpdb->get_var( "SELECT COUNT(*) FROM {$wpdb->prefix}ai_knowledge_documents" ) ?: 0;
		$total_cost  = $wpdb->get_var( "SELECT SUM(cost) FROM {$wpdb->prefix}ai_usage_logs" ) ?: 0.00;
		?>
		<div class="nexus-admin-body p-8">
			<div class="mb-10">
				<h2 class="text-sm font-semibold text-nexus-violet uppercase tracking-widest mb-2">Platform Command</h2>
				<h1 class="text-4xl font-bold text-white">Executive Overview</h1>
				<p class="text-gray-400 mt-2 max-w-2xl">Monitor your AI workforce productivity, token consumption, and strategic activity in real-time. This dashboard provides a high-level view of how AI is impacting your business operations.</p>
			</div>

			<!-- Key Stats: Bento Grid Layout -->
			<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-12">
				<div class="glass-panel p-8 rounded-3xl border border-nexus-border collab-wave bg-opacity-20 flex flex-col justify-between min-h-[200px] transform hover:scale-[1.02] transition-transform">
					<p class="text-xs text-white uppercase tracking-widest font-bold">Token Efficiency</p>
					<div>
						<p class="text-5xl font-black mt-2">94.2%</p>
						<p class="text-xs text-white/70 mt-2">Optimized for Scalability</p>
					</div>
				</div>
				<div class="glass-panel p-8 rounded-3xl border border-nexus-border bg-nexus-blue bg-opacity-10 flex flex-col justify-between min-h-[200px] transform hover:scale-[1.02] transition-transform text-nexus-blue">
					<p class="text-xs uppercase tracking-widest font-bold">AI Workforce</p>
					<div>
						<p class="text-5xl font-black mt-2"><?php echo (int) $agent_count; ?></p>
						<p class="text-xs text-gray-400 mt-2">Specialized Agents Active</p>
					</div>
				</div>
				<div class="glass-panel p-8 rounded-3xl border border-nexus-border bg-green-500 bg-opacity-10 flex flex-col justify-between min-h-[200px] transform hover:scale-[1.02] transition-transform text-green-500">
					<p class="text-xs uppercase tracking-widest font-bold">Company Brain</p>
					<div>
						<p class="text-5xl font-black mt-2"><?php echo (int) $doc_count; ?></p>
						<p class="text-xs text-gray-400 mt-2">Documents Ingested</p>
					</div>
				</div>
				<div class="glass-panel p-8 rounded-3xl border border-nexus-border bg-nexus-gold bg-opacity-10 flex flex-col justify-between min-h-[200px] transform hover:scale-[1.02] transition-transform text-nexus-gold">
					<p class="text-xs uppercase tracking-widest font-bold">Monthly ROI</p>
					<div>
						<p class="text-5xl font-black mt-2">$<?php echo number_format( (float) $total_cost, 2 ); ?></p>
						<p class="text-xs text-gray-400 mt-2">Value Created (Estimated)</p>
					</div>
				</div>
			</div>

			<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
				<div class="glass-panel p-8 rounded-2xl border border-nexus-border">
					<h2 class="text-xl font-semibold mb-6">Workforce Activity</h2>
					<div class="space-y-4">
						<div class="flex items-center gap-4 p-3 rounded-lg bg-nexus-elevated/50">
							<div class="w-2 h-2 rounded-full bg-nexus-violet"></div>
							<p class="text-sm">Agent <span class="font-bold">Sarah</span> updated SEO for 3 pages.</p>
							<span class="ml-auto text-xs text-gray-500">2m ago</span>
						</div>
					</div>
				</div>
				<div class="glass-panel p-8 rounded-2xl border border-nexus-border bg-nexus-violet/5">
					<h2 class="text-xl font-semibold mb-6">Quick Actions</h2>
					<div class="grid grid-cols-2 gap-4">
						<button class="p-4 rounded-xl bg-nexus-elevated border border-nexus-border hover:border-nexus-violet text-left transition-all">
							<p class="font-bold text-sm">New Strategy Meeting</p>
							<p class="text-xs text-gray-500 mt-1">Gather team.</p>
						</button>
					</div>
				</div>
			</div>
		</div>
		<?php
	}

	/**
	 * Render the "Hire Agent" workforce management page.
	 */
	public function render_workforce_page(): void {
		echo $this->get_brand_styles();
		?>
		<div class="nexus-admin-body p-8">
			<div class="mb-10 flex justify-between items-end">
				<div>
					<h2 class="text-sm font-semibold text-nexus-violet uppercase tracking-widest mb-2">Talent Management</h2>
					<h1 class="text-4xl font-bold text-white">Hire & Manage AI Agents</h1>
					<p class="text-gray-400 mt-2 max-w-2xl">Build your virtual executive team. Each agent you hire has a unique personality, specific professional goals, and access to your company knowledge.</p>
				</div>
				<div class="flex gap-2 bg-nexus-elevated p-1 rounded-xl border border-nexus-border">
					<button class="nexus-tab-btn px-6 py-2 rounded-lg text-sm font-bold bg-nexus-violet text-white" data-tab="hiring">In-House</button>
					<button class="nexus-tab-btn px-6 py-2 rounded-lg text-sm font-bold text-gray-400 hover:text-white transition-all" data-tab="marketplace">Global Marketplace</button>
				</div>
			</div>

			<div id="nexus-hiring-tab" class="nexus-tab-content grid grid-cols-1 lg:grid-cols-2 gap-8">
				<div class="glass-panel p-8 rounded-2xl border border-nexus-border">
					<div class="mb-6 flex justify-between items-start">
						<div>
							<h2 class="text-xl font-semibold">Hire New AI Agent</h2>
							<p class="text-xs text-gray-500 mt-1 italic">Pro-Tip: Agents with 'Logical' personality work best with Temperature set to 0.2.</p>
						</div>
						<a href="#" class="text-nexus-violet hover:text-white transition-colors" title="View Hiring Guide">
							<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
						</a>
					</div>

					<!-- Pre-configured Agents Dropdown -->
					<div class="mb-8 p-4 bg-nexus-violet/10 rounded-xl border border-nexus-violet/20">
						<label class="block text-sm font-bold text-nexus-violet mb-2 uppercase tracking-tighter">Fast-Hire: Select Expert Template</label>
						<select id="nexus-agent-template-selector" class="w-full bg-nexus-elevated border border-nexus-border rounded-lg p-3 text-white font-medium">
							<option value="">-- Choose an Expert --</option>
							<option value="ceo">CEO - Strategic Visionary</option>
							<option value="cmo">CMO - Growth Architect</option>
							<option value="cto">CTO - Systems Architect</option>
							<option value="cfo">CFO - Financial Strategist</option>
							<option value="seo">SEO - Search Specialist</option>
							<option value="copywriter">Copywriter - Persuasion Expert</option>
						</select>
					</div>

					<form id="nexus-hire-agent-form" class="space-y-6">
						<div>
							<label class="block text-sm font-medium text-gray-400 mb-2">Agent Name</label>
							<input type="text" name="name" class="w-full bg-nexus-elevated border border-nexus-border rounded-lg p-3 text-white" placeholder="e.g. Sarah">
						</div>
						<div>
							<label class="block text-sm font-medium text-gray-400 mb-2">Professional Position</label>
							<input type="text" name="position" class="w-full bg-nexus-elevated border border-nexus-border rounded-lg p-3 text-white" placeholder="e.g. CMO, Full Stack Developer">
						</div>
						<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
							<div>
								<label class="block text-sm font-medium text-gray-400 mb-2">Identity (Persona)</label>
								<input type="text" name="identity" class="w-full bg-nexus-elevated border border-nexus-border rounded-lg p-3 text-white" placeholder="Who is this AI?">
							</div>
							<div>
								<label class="block text-sm font-medium text-gray-400 mb-2">Mission (Primary Objective)</label>
								<input type="text" name="mission" class="w-full bg-nexus-elevated border border-nexus-border rounded-lg p-3 text-white" placeholder="What is its main goal?">
							</div>
						</div>
						<div class="grid grid-cols-2 gap-4">
							<div>
								<label class="block text-sm font-medium text-gray-400 mb-2">AI Model</label>
								<select name="model" class="w-full bg-nexus-elevated border border-nexus-border rounded-lg p-3 text-white">
									<optgroup label="OpenAI">
										<option value="gpt-4o">GPT-4o</option>
										<option value="gpt-4-turbo">GPT-4 Turbo</option>
									</optgroup>
									<optgroup label="Anthropic">
										<option value="claude-3-5-sonnet-20240620">Claude 3.5 Sonnet</option>
									</optgroup>
									<optgroup label="Google">
										<option value="gemini-1.5-pro">Gemini 1.5 Pro</option>
									</optgroup>
								</select>
							</div>
							<div>
								<label class="block text-sm font-medium text-gray-400 mb-2">Creativity (Temp)</label>
								<input type="range" name="temperature" min="0" max="1" step="0.1" value="0.7" class="w-full h-2 bg-nexus-border rounded-lg appearance-none cursor-pointer accent-nexus-violet">
							</div>
						</div>
						<button type="submit" class="w-full bg-nexus-violet hover:bg-violet-600 text-white font-bold py-3 px-6 rounded-lg transition-colors">Deploy Agent</button>
					</form>
				</div>

				<div class="space-y-8">
					<div class="glass-panel p-8 rounded-3xl border border-nexus-border bg-nexus-violet/10 flex flex-col justify-center min-h-[150px]">
						<p class="text-sm text-gray-400 uppercase tracking-widest font-bold">Workforce Strength</p>
						<p class="text-5xl font-black mt-2">Active</p>
					</div>
					<div class="glass-panel p-8 rounded-2xl border border-nexus-border">
						<h3 class="text-lg font-medium mb-4">Current Workforce</h3>
						<div class="text-sm text-gray-500 italic">No agents hired yet.</div>
					</div>
				</div>
			</div>

			<div id="nexus-marketplace-tab" class="nexus-tab-content hidden">
				<div class="grid grid-cols-1 md:grid-cols-3 gap-8">
					<!-- Marketplace Item -->
					<div class="glass-panel p-8 rounded-3xl border border-nexus-border hover:border-nexus-gold transition-all group">
						<div class="w-16 h-16 rounded-2xl bg-nexus-gold/10 flex items-center justify-center text-nexus-gold mb-6 group-hover:scale-110 transition-transform">
							<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
						</div>
						<h3 class="text-xl font-bold text-white">Grant Writer Pro</h3>
						<p class="text-sm text-gray-500 mt-2">Specialized in winning high-value federal and private grants. Trained on 5,000+ winning proposals.</p>
						<button class="nexus-marketplace-install w-full mt-8 bg-nexus-gold/20 hover:bg-nexus-gold text-nexus-gold hover:text-black font-bold py-3 rounded-xl transition-all" data-agent="grant_writer">Install for $49/mo</button>
					</div>

					<div class="glass-panel p-8 rounded-3xl border border-nexus-border hover:border-nexus-blue transition-all group">
						<div class="w-16 h-16 rounded-2xl bg-nexus-blue/10 flex items-center justify-center text-nexus-blue mb-6 group-hover:scale-110 transition-transform">
							<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"/></svg>
						</div>
						<h3 class="text-xl font-bold text-white">Legal Advisor (LLM)</h3>
						<p class="text-sm text-gray-500 mt-2">Drafts contracts, reviews TOS, and provides compliance audits based on latest EU/US regulations.</p>
						<button class="nexus-marketplace-install w-full mt-8 bg-nexus-blue/20 hover:bg-nexus-blue text-nexus-blue hover:text-white font-bold py-3 rounded-xl transition-all" data-agent="legal_advisor">Install for $99/mo</button>
					</div>

					<div class="glass-panel p-8 rounded-3xl border border-nexus-border hover:border-nexus-violet transition-all group">
						<div class="w-16 h-16 rounded-2xl bg-nexus-violet/10 flex items-center justify-center text-nexus-violet mb-6 group-hover:scale-110 transition-transform">
							<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
						</div>
						<h3 class="text-xl font-bold text-white">WP Plugin Architect</h3>
						<p class="text-sm text-gray-500 mt-2">Writes production-ready, secure WordPress code following PSR-12 and VIP standards.</p>
						<button class="nexus-marketplace-install w-full mt-8 bg-nexus-violet/20 hover:bg-nexus-violet text-nexus-violet hover:text-white font-bold py-3 rounded-xl transition-all" data-agent="wp_architect">Install for $79/mo</button>
					</div>
				</div>
			</div>
		</div>
		<?php
	}

	/**
	 * Render the "Settings" page.
	 */
	public function render_settings_page(): void {
		echo $this->get_brand_styles();
		?>
		<div class="nexus-admin-body p-8">
			<div class="mb-10">
				<h2 class="text-sm font-semibold text-nexus-gold uppercase tracking-widest mb-2">Platform Infrastructure</h2>
				<h1 class="text-4xl font-bold text-white">System Configuration</h1>
				<p class="text-gray-400 mt-2 max-w-2xl">Configure the core engines powering your AI Workforce. Manage API keys, set global defaults for model performance, and customize the platform branding.</p>
			</div>

			<div class="max-w-4xl grid grid-cols-1 md:grid-cols-2 gap-8">
				<div class="glass-panel p-8 rounded-2xl border border-nexus-border">
					<h2 class="text-xl font-semibold mb-6 text-nexus-violet">Global AI Engine</h2>
					<form id="nexus-settings-form" class="space-y-6">
						<div>
							<label class="block text-sm font-medium text-gray-400 mb-2">OpenAI API Key</label>
							<input type="password" name="openai_api_key" class="w-full bg-nexus-elevated border border-nexus-border rounded-lg p-3 text-white" placeholder="sk-...">
						</div>
						<div>
							<label class="block text-sm font-medium text-gray-400 mb-2">Anthropic API Key</label>
							<input type="password" name="claude_api_key" class="w-full bg-nexus-elevated border border-nexus-border rounded-lg p-3 text-white" placeholder="sk-ant-...">
						</div>
						<div>
							<label class="block text-sm font-medium text-gray-400 mb-2">Default Model</label>
							<select name="default_model" class="w-full bg-nexus-elevated border border-nexus-border rounded-lg p-3 text-white">
								<optgroup label="OpenAI">
									<option value="gpt-4o">GPT-4o (Most Intelligent)</option>
									<option value="gpt-4o-mini">GPT-4o Mini (Fast & Cheap)</option>
								</optgroup>
								<optgroup label="Anthropic">
									<option value="claude-3-5-sonnet-20240620">Claude 3.5 Sonnet</option>
									<option value="claude-3-opus-20240229">Claude 3 Opus</option>
								</optgroup>
								<optgroup label="Google">
									<option value="gemini-1.5-pro">Gemini 1.5 Pro</option>
									<option value="gemini-1.5-flash">Gemini 1.5 Flash</option>
								</optgroup>
								<optgroup label="OpenRouter">
									<option value="meta-llama/llama-3.1-405b-instruct">Llama 3.1 405B</option>
									<option value="x-ai/grok-1">Grok-1</option>
									<option value="deepseek/deepseek-chat">DeepSeek V2.5</option>
									<option value="mistralai/mistral-large">Mistral Large</option>
								</optgroup>
							</select>
						</div>
						<button type="submit" class="w-full bg-nexus-violet text-white font-bold py-3 rounded-lg transition-colors">Save Engine Config</button>
					</form>
				</div>

				<div class="glass-panel p-8 rounded-2xl border border-nexus-border">
					<h2 class="text-xl font-semibold mb-6 text-nexus-gold">White Label & Brand</h2>
					<div class="space-y-6">
						<div>
							<label class="block text-sm font-medium text-gray-400 mb-2">Agency Logo URL</label>
							<input type="text" name="agency_logo" class="w-full bg-nexus-elevated border border-nexus-border rounded-lg p-3 text-white" placeholder="https://...">
						</div>
						<div>
							<label class="block text-sm font-medium text-gray-400 mb-2">Primary Accent Color</label>
							<input type="color" name="ui_color" class="w-16 h-10 bg-nexus-elevated border border-nexus-border rounded-lg p-1 text-white" value="#7C3AED">
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php
	}

	/**
	 * Render the "Knowledge Base" (Company Brain) page.
	 */
	public function render_kb_page(): void {
		echo $this->get_brand_styles();
		?>
		<div class="nexus-admin-body p-8">
			<div class="mb-10">
				<h2 class="text-sm font-semibold text-nexus-blue uppercase tracking-widest mb-2">Central Intelligence</h2>
				<h1 class="text-4xl font-bold text-white">Company Brain (RAG)</h1>
				<p class="text-gray-400 mt-2 max-w-2xl">Give your AI workforce "Company Memory." Upload PDFs, SOPs, and URLs to create a shared knowledge base.</p>
			</div>

			<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
				<div class="glass-panel p-8 rounded-2xl border border-nexus-border">
					<h2 class="text-xl font-semibold mb-6">Ingest Information</h2>
					<div class="space-y-8">
						<div class="border-2 border-dashed border-nexus-border rounded-xl p-8 text-center hover:border-nexus-violet transition-colors">
							<p class="text-sm text-gray-300">Drop PDF, DOCX, or CSV files here</p>
							<button class="mt-4 bg-nexus-elevated border border-nexus-border text-white px-4 py-2 rounded-lg text-sm">Select Files</button>
						</div>
						<div>
							<label class="block text-sm font-medium text-gray-400 mb-2">Index Website URL</label>
							<div class="flex gap-2">
								<input type="url" class="flex-1 bg-nexus-elevated border border-nexus-border rounded-lg p-3 text-white" placeholder="https://...">
								<button class="bg-nexus-violet text-white px-6 py-2 rounded-lg font-medium">Index</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php
	}

	/**
	 * Render the "Workflows" (Automations) page.
	 */
	public function render_workflows_page(): void {
		global $wpdb;
		$agents = $wpdb->get_results( "SELECT id, name, position FROM {$wpdb->prefix}ai_employees WHERE is_active = 1", ARRAY_A ) ?: [];
		?>
		<div class="nexus-admin-body p-8">
			<div class="mb-10">
				<h2 class="text-sm font-semibold text-green-500 uppercase tracking-widest mb-2">Operational Efficiency</h2>
				<h1 class="text-4xl font-bold text-white">Multi-Agent Automations</h1>
				<p class="text-gray-400 mt-2 max-w-2xl">Create complex workflows where multiple AI agents collaborate to finish a task.</p>
			</div>

			<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
				<div class="lg:col-span-1 space-y-6">
					<h2 class="text-xl font-semibold mb-6">Workflow Blueprints</h2>
					<div class="glass-panel p-4 rounded-xl border border-nexus-border hover:border-nexus-violet cursor-pointer transition-all">
						<h3 class="font-bold text-nexus-violet">Content Machine</h3>
						<p class="text-xs text-gray-400 mt-1">Research -> Copywriting -> SEO -> Publish</p>
					</div>
				</div>

				<div class="lg:col-span-2">
					<div class="glass-panel p-8 rounded-2xl border border-nexus-border min-h-[500px] flex flex-col items-center justify-center text-center">
						<h2 class="text-2xl font-bold mb-2">Build Custom Workflow</h2>
						<button id="nexus-open-visual-builder" class="mt-8 bg-nexus-violet text-white font-bold py-3 px-10 rounded-xl transition-all">Open Visual Builder</button>
					</div>
				</div>
			</div>

			<!-- Visual Builder Modal -->
			<div id="nexus-visual-builder-modal" class="fixed inset-0 z-[9999] hidden">
				<div class="absolute inset-0 bg-black bg-opacity-80 backdrop-blur-sm"></div>
				<div class="absolute inset-4 glass-panel rounded-3xl border border-nexus-border flex overflow-hidden shadow-2xl">
					<div class="w-72 border-r border-nexus-border bg-nexus-surface flex flex-col p-6">
						<h3 class="font-bold text-lg text-white mb-4">Agents</h3>
						<div class="flex-1 overflow-y-auto space-y-4">
							<?php foreach ( $agents as $agent ) : ?>
								<div class="nexus-draggable-agent p-4 rounded-xl bg-nexus-elevated border border-nexus-border cursor-move" draggable="true" data-id="<?php echo (int) $agent['id']; ?>">
									<p class="font-bold text-sm text-white"><?php echo esc_html( $agent['name'] ); ?></p>
								</div>
							<?php endforeach; ?>
						</div>
					</div>
					<div class="flex-1 bg-nexus-bg p-12 flex flex-col">
						<div class="flex justify-between items-center mb-12">
							<h2 class="text-2xl font-bold text-white">Canvas</h2>
							<button id="nexus-close-builder" class="text-gray-400 hover:text-white">Close</button>
						</div>
						<div id="nexus-workflow-canvas" class="flex-1 border-2 border-dashed border-nexus-border rounded-3xl flex items-center justify-center relative">
							<p class="text-gray-500">Drop agents here</p>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php
	}

	/**
	 * Render the role-specific tutorials page.
	 */
	/**
	 * Render the "Collaboration Hub" (AI Meetings) page.
	 */
	public function render_meetings_page(): void {
		echo $this->get_brand_styles();
		global $wpdb;
		$agents = $wpdb->get_results( "SELECT id, name, position, avatar FROM {$wpdb->prefix}ai_employees WHERE is_active = 1", ARRAY_A ) ?: [];
		?>
		<div class="nexus-admin-body p-8">
			<div class="mb-10 flex justify-between items-end">
				<div>
					<h2 class="text-sm font-semibold text-nexus-blue uppercase tracking-widest mb-2">Strategic Intelligence</h2>
					<h1 class="text-4xl font-bold text-white">Collaboration Hub</h1>
					<p class="text-gray-400 mt-2 max-w-2xl">Start a virtual meeting. Gather your AI executives to brainstorm, solve problems, and reach a consensus on complex business decisions.</p>
				</div>
				<button id="nexus-start-meeting-btn" class="bg-nexus-violet hover:bg-violet-600 text-white font-bold py-3 px-8 rounded-xl transition-all shadow-lg shadow-nexus-violet/20">
					Start New Meeting
				</button>
			</div>

			<div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
				<!-- Meeting Controls Sidebar -->
				<div class="lg:col-span-1 space-y-6">
					<div class="glass-panel p-6 rounded-2xl border border-nexus-border">
						<h3 class="text-sm font-bold text-gray-400 uppercase tracking-tighter mb-4">Invite Participants</h3>
						<div class="space-y-3">
							<?php foreach ( $agents as $agent ) : ?>
								<label class="flex items-center gap-3 p-3 rounded-xl bg-nexus-elevated border border-nexus-border hover:border-nexus-violet cursor-pointer transition-all">
									<input type="checkbox" class="nexus-meeting-invitee w-4 h-4 rounded border-gray-600 bg-gray-700 text-nexus-violet focus:ring-nexus-violet" value="<?php echo (int) $agent['id']; ?>">
									<span class="text-sm font-medium text-white"><?php echo esc_html( $agent['name'] ); ?> (<?php echo esc_html( $agent['position'] ); ?>)</span>
								</label>
							<?php endforeach; ?>
						</div>
					</div>

					<div class="glass-panel p-6 rounded-2xl border border-nexus-border">
						<h3 class="text-sm font-bold text-gray-400 uppercase tracking-tighter mb-4">Meeting Agenda</h3>
						<textarea id="nexus-meeting-agenda" class="w-full h-32 bg-nexus-elevated border border-nexus-border rounded-xl p-3 text-white text-sm" placeholder="Define the problem or goal for the team to discuss..."></textarea>
					</div>
				</div>

				<!-- Live Transcription Area -->
				<div class="lg:col-span-3">
					<div id="nexus-meeting-room" class="glass-panel rounded-3xl border border-nexus-border min-h-[600px] flex flex-col overflow-hidden">
						<div class="p-6 border-b border-nexus-border bg-nexus-elevated/30 flex justify-between items-center">
							<div class="flex items-center gap-4">
								<div class="w-3 h-3 rounded-full bg-red-500 animate-pulse"></div>
								<h2 class="font-bold text-white">Live Transcription</h2>
							</div>
							<div class="flex gap-2">
								<span class="text-xs text-gray-500 bg-nexus-border px-3 py-1 rounded-full">Real-time Reasoning Enabled</span>
							</div>
						</div>

						<div id="nexus-meeting-transcript" class="flex-1 p-8 space-y-8 overflow-y-auto max-h-[500px]">
							<div class="flex flex-col items-center justify-center h-full text-center text-gray-500">
								<svg class="w-16 h-16 mb-4 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9l-4 4v-4H3a2 2 0 01-2-2V10a2 2 0 012-2h2m3.382-7.034l.437.218a1 1 0 01.39 1.17l-.5 1.5a1 1 0 01-1.17.39l-1.5-.5a1 1 0 01-.39-1.17l.5-1.5a1 1 0 011.17-.39zM15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
								<p>Configure participants and agenda to start the meeting.</p>
							</div>
						</div>

						<div class="p-6 bg-nexus-elevated/30 border-t border-nexus-border flex gap-4">
							<input type="text" id="nexus-meeting-input" class="flex-1 bg-nexus-elevated border border-nexus-border rounded-xl p-4 text-white" placeholder="Type a message or instruction to the team...">
							<button id="nexus-send-meeting-msg" class="bg-nexus-blue hover:bg-blue-600 text-white font-bold px-8 rounded-xl transition-all">Send</button>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php
	}

	public function render_tutorials_page(): void {
		$level = $_GET['level'] ?? 'employee';
		echo $this->get_brand_styles();
		?>
		<div class="nexus-admin-body p-8">
			<div class="mb-10">
				<h2 class="text-sm font-semibold text-nexus-violet uppercase tracking-widest mb-2">Learning Center</h2>
				<h1 class="text-4xl font-bold text-white">Platform Tutorials (<?php echo ucfirst($level); ?> Level)</h1>
				<p class="text-gray-400 mt-2 max-w-2xl">Master the Nexus AI Workforce platform with specialized guides designed for your access level.</p>
			</div>

			<div class="grid grid-cols-1 md:grid-cols-3 gap-8">
				<div class="glass-panel p-8 rounded-3xl border border-nexus-border hover:border-nexus-violet transition-all">
					<h3 class="text-xl font-bold mb-2 text-white">The Core Blueprint</h3>
					<p class="text-sm text-gray-400 mb-6">Learn how AI agents interact with WordPress data. Focus on 'Identity' and 'Mission'.</p>
					<a href="#" class="text-nexus-violet font-bold hover:underline">Start Lesson -></a>
				</div>
				<?php if ($level === 'admin' || $level === 'agency') : ?>
					<div class="glass-panel p-8 rounded-3xl border border-nexus-border hover:border-nexus-blue transition-all">
						<h3 class="text-xl font-bold mb-2 text-white">Scaling ROI (Agency)</h3>
						<p class="text-sm text-gray-400 mb-6">Master the 'AI-as-a-Service' model. Learn to white-label the platform.</p>
						<a href="#" class="text-nexus-blue font-bold hover:underline">Start Lesson -></a>
					</div>
					<div class="glass-panel p-8 rounded-3xl border border-nexus-border hover:border-nexus-gold transition-all">
						<h3 class="text-xl font-bold mb-2 text-white">Security & RBAC</h3>
						<p class="text-sm text-gray-400 mb-6">Configure enterprise permissions and secure your API infrastructure.</p>
						<a href="#" class="text-nexus-gold font-bold hover:underline">Start Lesson -></a>
					</div>
				<?php endif; ?>
			</div>
		</div>
		<?php
	}
}
