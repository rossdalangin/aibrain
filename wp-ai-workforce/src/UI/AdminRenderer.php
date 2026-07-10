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
			<div class="mb-10">
				<h2 class="text-sm font-semibold text-nexus-violet uppercase tracking-widest mb-2">Talent Management</h2>
				<h1 class="text-4xl font-bold text-white">Hire & Manage AI Agents</h1>
				<p class="text-gray-400 mt-2 max-w-2xl">Build your virtual executive team. Each agent you hire has a unique personality, specific professional goals, and access to your company knowledge. Deploy specialized agents for Marketing, Sales, Development, and more.</p>
			</div>

			<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
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
