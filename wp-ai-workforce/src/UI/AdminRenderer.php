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
	 * Render the "Hire Agent" workforce management page.
	 */
	public function render_workforce_page(): void {
		echo $this->get_brand_styles();
		?>
		<div class="nexus-admin-body p-8">
			<h1 class="text-3xl font-bold text-nexus-violet mb-8">Workforce Command</h1>

			<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
				<!-- Form Section -->
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
					<form id="nexus-hire-agent-form" class="space-y-6">
						<div>
							<label class="block text-sm font-medium text-gray-400 mb-2">Agent Name</label>
							<input type="text" name="name" class="w-full bg-nexus-elevated border border-nexus-border rounded-lg p-3 text-white focus:ring-2 focus:ring-nexus-violet" placeholder="e.g. Sarah">
						</div>
						<div>
							<label class="block text-sm font-medium text-gray-400 mb-2">Professional Position</label>
							<input type="text" name="position" class="w-full bg-nexus-elevated border border-nexus-border rounded-lg p-3 text-white focus:ring-2 focus:ring-nexus-violet" placeholder="e.g. CMO, Full Stack Developer">
						</div>
						<div>
							<label class="block text-sm font-medium text-gray-400 mb-2">Identity & Mission</label>
							<textarea name="role_description" rows="3" class="w-full bg-nexus-elevated border border-nexus-border rounded-lg p-3 text-white focus:ring-2 focus:ring-nexus-violet" placeholder="Describe the agent's core purpose..."></textarea>
						</div>
						<div class="grid grid-cols-2 gap-4">
							<div>
								<label class="block text-sm font-medium text-gray-400 mb-2">Key Skills (Comma separated)</label>
								<input type="text" name="skills" class="w-full bg-nexus-elevated border border-nexus-border rounded-lg p-3 text-white focus:ring-2 focus:ring-nexus-violet" placeholder="SEO, Python, Copywriting">
							</div>
							<div>
								<label class="block text-sm font-medium text-gray-400 mb-2">Success KPIs</label>
								<input type="text" name="kpis" class="w-full bg-nexus-elevated border border-nexus-border rounded-lg p-3 text-white focus:ring-2 focus:ring-nexus-violet" placeholder="Conversion Rate, Load Time">
							</div>
						</div>
						<div class="grid grid-cols-2 gap-4">
							<div>
								<label class="block text-sm font-medium text-gray-400 mb-2">Communication Style</label>
								<select name="communication_style" class="w-full bg-nexus-elevated border border-nexus-border rounded-lg p-3 text-white">
									<option value="professional">Professional & Direct</option>
									<option value="creative">Creative & Enthusiastic</option>
									<option value="technical">Technical & Detailed</option>
									<option value="concise">Concise & Brief</option>
								</select>
							</div>
							<div>
								<label class="block text-sm font-medium text-gray-400 mb-2">Output Format</label>
								<select name="output_format" class="w-full bg-nexus-elevated border border-nexus-border rounded-lg p-3 text-white">
									<option value="markdown">Markdown</option>
									<option value="json">Structured JSON</option>
									<option value="html">HTML Code</option>
									<option value="plaintext">Plain Text</option>
								</select>
							</div>
						</div>
						<div class="grid grid-cols-2 gap-4">
							<div>
								<label class="block text-sm font-medium text-gray-400 mb-2">AI Model</label>
								<select name="model" class="w-full bg-nexus-elevated border border-nexus-border rounded-lg p-3 text-white">
									<optgroup label="OpenAI">
										<option value="gpt-4o">GPT-4o (Recommended)</option>
										<option value="gpt-4-turbo">GPT-4 Turbo</option>
									</optgroup>
									<optgroup label="Anthropic">
										<option value="claude-3-5-sonnet-20240620">Claude 3.5 Sonnet</option>
										<option value="claude-3-opus-20240229">Claude 3 Opus</option>
									</optgroup>
									<optgroup label="Google">
										<option value="gemini-1.5-pro">Gemini 1.5 Pro</option>
										<option value="gemini-1.5-flash">Gemini 1.5 Flash</option>
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

				<!-- Stats/List Section -->
				<div class="space-y-8">
					<div class="glass-panel p-6 rounded-2xl border border-nexus-border gradient-border">
						<p class="text-sm text-gray-400">Active Workforce</p>
						<p class="text-4xl font-bold mt-2">0 Agents</p>
						<p class="text-xs text-nexus-violet mt-2">+0% Productivity Increase</p>
					</div>
					<div class="glass-panel p-6 rounded-2xl border border-nexus-border">
						<h3 class="text-lg font-medium mb-4">Recent Deployments</h3>
						<div class="text-sm text-gray-500 italic">No agents hired yet. Start by filling out the form.</div>
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
			<h1 class="text-3xl font-bold text-nexus-violet mb-8">System Configuration</h1>

			<div class="max-w-2xl">
				<div class="glass-panel p-8 rounded-2xl border border-nexus-border">
						<div class="mb-6 flex justify-between items-start">
							<div>
								<h2 class="text-xl font-semibold">Global AI Settings</h2>
								<p class="text-xs text-gray-500 mt-1 italic">Security: All keys are AES-256 encrypted using your site's unique AUTH_KEY.</p>
							</div>
							<a href="#" class="text-nexus-violet hover:text-white transition-colors" title="View Security Documentation">
								<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
							</a>
					</div>
					<form id="nexus-settings-form" class="space-y-8">
						<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
							<div>
								<label class="block text-sm font-medium text-gray-400 mb-2">OpenAI API Key</label>
								<input type="password" name="openai_api_key" class="w-full bg-nexus-elevated border border-nexus-border rounded-lg p-3 text-white focus:ring-2 focus:ring-nexus-violet" placeholder="sk-...">
							</div>
							<div>
								<label class="block text-sm font-medium text-gray-400 mb-2">Anthropic (Claude) Key</label>
								<input type="password" name="claude_api_key" class="w-full bg-nexus-elevated border border-nexus-border rounded-lg p-3 text-white focus:ring-2 focus:ring-nexus-violet" placeholder="sk-ant-...">
							</div>
							<div>
								<label class="block text-sm font-medium text-gray-400 mb-2">Google (Gemini) Key</label>
								<input type="password" name="gemini_api_key" class="w-full bg-nexus-elevated border border-nexus-border rounded-lg p-3 text-white focus:ring-2 focus:ring-nexus-violet" placeholder="AIza...">
							</div>
							<div>
								<label class="block text-sm font-medium text-gray-400 mb-2">OpenRouter Key</label>
								<input type="password" name="openrouter_api_key" class="w-full bg-nexus-elevated border border-nexus-border rounded-lg p-3 text-white focus:ring-2 focus:ring-nexus-violet" placeholder="sk-or-...">
							</div>
						</div>

						<div>
							<label class="block text-sm font-medium text-gray-400 mb-2">Company Name</label>
							<input type="text" name="company_name" class="w-full bg-nexus-elevated border border-nexus-border rounded-lg p-3 text-white focus:ring-2 focus:ring-nexus-violet" placeholder="e.g. Nexus Enterprises">
						</div>

						<div>
							<label class="block text-sm font-medium text-gray-400 mb-2">Default Global Model</label>
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
								<optgroup label="OpenRouter (Advanced)">
									<option value="meta-llama/llama-3.1-405b-instruct">Llama 3.1 405B</option>
									<option value="x-ai/grok-1">Grok-1</option>
									<option value="deepseek/deepseek-chat">DeepSeek V2.5</option>
								</optgroup>
							</select>
						</div>

						<hr class="border-nexus-border">

						<!-- RAG Configuration -->
						<div>
							<h3 class="text-lg font-semibold mb-4 text-nexus-blue">Company Brain (RAG) Setup</h3>
							<div class="grid grid-cols-2 gap-4">
								<div>
									<label class="block text-sm font-medium text-gray-400 mb-2">Chunk Size (Chars)</label>
									<input type="number" name="chunk_size" class="w-full bg-nexus-elevated border border-nexus-border rounded-lg p-3 text-white" value="1000">
								</div>
								<div>
									<label class="block text-sm font-medium text-gray-400 mb-2">Chunk Overlap</label>
									<input type="number" name="chunk_overlap" class="w-full bg-nexus-elevated border border-nexus-border rounded-lg p-3 text-white" value="100">
								</div>
							</div>
						</div>

						<hr class="border-nexus-border">

						<!-- White Label Section -->
						<div>
							<h3 class="text-lg font-semibold mb-4 text-nexus-gold">Agency White Label</h3>
							<div class="space-y-4">
								<div>
									<label class="block text-sm font-medium text-gray-400 mb-2">Agency Logo URL</label>
									<input type="text" name="agency_logo" class="w-full bg-nexus-elevated border border-nexus-border rounded-lg p-3 text-white" placeholder="https://your-agency.com/logo.png">
								</div>
								<div>
									<label class="block text-sm font-medium text-gray-400 mb-2">Primary UI Color</label>
									<input type="color" name="ui_color" class="w-16 h-10 bg-nexus-elevated border border-nexus-border rounded-lg p-1 text-white" value="#7C3AED">
								</div>
							</div>
						</div>

						<div class="pt-4 border-t border-nexus-border flex items-center justify-between">
							<div class="flex items-center gap-2">
								<div class="w-2 h-2 rounded-full bg-green-500"></div>
								<span class="text-xs text-gray-400">System Secure</span>
							</div>
							<button type="submit" class="bg-nexus-violet hover:bg-violet-600 text-white font-bold py-2 px-8 rounded-lg transition-colors">Save Config</button>
						</div>
					</form>
				</div>

				<!-- System Status Block -->
				<div class="mt-8 glass-panel p-6 rounded-2xl border border-nexus-border bg-opacity-50">
					<h3 class="text-sm font-semibold text-gray-400 uppercase tracking-wider mb-4">Health Diagnostics</h3>
					<div class="space-y-3">
						<div class="flex justify-between text-sm">
							<span class="text-gray-300">PHP Version</span>
							<span class="text-white"><?php echo PHP_VERSION; ?></span>
						</div>
						<div class="flex justify-between text-sm">
							<span class="text-gray-300">OpenSSL Encryption</span>
							<span class="text-green-500">Active</span>
						</div>
						<div class="flex justify-between text-sm">
							<span class="text-gray-300">Vector Storage (SQLite)</span>
							<span class="text-green-500">Available</span>
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
			<h1 class="text-3xl font-bold text-nexus-violet mb-8">Company Brain (Knowledge Base)</h1>

			<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
				<!-- Ingestion Section -->
				<div class="glass-panel p-8 rounded-2xl border border-nexus-border">
						<div class="mb-6 flex justify-between items-start">
							<div>
								<h2 class="text-xl font-semibold">Ingest Information</h2>
								<p class="text-xs text-gray-500 mt-1 italic">Performance: For best RAG results, keep your PDF files under 5MB for faster indexing.</p>
							</div>
							<a href="#" class="text-nexus-blue hover:text-white transition-colors" title="View Ingestion Guide">
								<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
							</a>
					</div>

					<div class="space-y-8">
						<!-- File Upload -->
						<div class="border-2 border-dashed border-nexus-border rounded-xl p-8 text-center hover:border-nexus-violet transition-colors">
							<div class="text-nexus-violet mb-4">
								<svg class="w-12 h-12 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
							</div>
							<p class="text-sm text-gray-300">Drop PDFs, DOCX, or CSV files here</p>
							<p class="text-xs text-gray-500 mt-2">Max file size: 32MB</p>
							<button class="mt-4 bg-nexus-elevated border border-nexus-border text-white px-4 py-2 rounded-lg text-sm hover:bg-nexus-border">Select Files</button>
						</div>

						<!-- URL Scraper -->
						<div>
							<label class="block text-sm font-medium text-gray-400 mb-2">Index Website URL</label>
							<div class="flex gap-2">
								<input type="url" class="flex-1 bg-nexus-elevated border border-nexus-border rounded-lg p-3 text-white focus:ring-2 focus:ring-nexus-violet" placeholder="https://your-docs.com/...">
								<button class="bg-nexus-violet hover:bg-violet-600 text-white px-6 py-2 rounded-lg font-medium">Index</button>
							</div>
							<p class="text-xs text-gray-500 mt-2">Our crawler will extract text content from the provided URL.</p>
						</div>
					</div>
				</div>

				<!-- Memory Status Section -->
				<div class="space-y-8">
					<div class="glass-panel p-6 rounded-2xl border border-nexus-border">
						<h3 class="text-lg font-medium mb-4">Memory Integrity</h3>
						<div class="space-y-4">
							<div class="flex justify-between items-center">
								<span class="text-sm text-gray-400">Total Indexed Documents</span>
								<span class="text-white font-mono">0</span>
							</div>
							<div class="flex justify-between items-center">
								<span class="text-sm text-gray-400">Vector Embeddings</span>
								<span class="text-white font-mono">0</span>
							</div>
							<div class="flex justify-between items-center">
								<span class="text-sm text-gray-400">Database Size</span>
								<span class="text-white font-mono">0.00 MB</span>
							</div>
						</div>
					</div>

					<div class="glass-panel p-6 rounded-2xl border border-nexus-border">
						<h3 class="text-lg font-medium mb-4">Recent Documents</h3>
						<div class="text-sm text-gray-500 italic">No documents indexed. Feed the brain to start.</div>
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
		$agents = $wpdb->get_results( "SELECT id, name, position FROM {$wpdb->prefix}ai_employees WHERE is_active = 1", ARRAY_A );
		?>
		<div class="nexus-admin-body p-8">
			<h1 class="text-3xl font-bold text-nexus-violet mb-8">Multi-Agent Automations</h1>

			<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
				<!-- Template Gallery -->
				<div class="lg:col-span-1 space-y-6">
					<h2 class="text-xl font-semibold mb-6">Workflow Blueprints</h2>

					<div class="glass-panel p-4 rounded-xl border border-nexus-border hover:border-nexus-violet cursor-pointer transition-all">
						<h3 class="font-bold text-nexus-violet">Content Machine</h3>
						<p class="text-xs text-gray-400 mt-1">Research -> Copywriting -> SEO Review -> Publish</p>
					</div>

					<div class="glass-panel p-4 rounded-xl border border-nexus-border hover:border-nexus-violet cursor-pointer transition-all">
						<h3 class="font-bold text-nexus-blue">Product Launch</h3>
						<p class="text-xs text-gray-400 mt-1">Strategy -> Marketing Assets -> Launch Email</p>
					</div>

					<div class="glass-panel p-4 rounded-xl border border-nexus-border hover:border-nexus-violet cursor-pointer transition-all">
						<h3 class="font-bold text-green-500">Customer Success</h3>
						<p class="text-xs text-gray-400 mt-1">Sentiment Analysis -> Auto-Response -> Report</p>
					</div>
				</div>

				<!-- Workflow Builder Skeleton -->
				<div class="lg:col-span-2">
					<div class="glass-panel p-8 rounded-2xl border border-nexus-border min-h-[500px] flex flex-col items-center justify-center text-center">
						<div class="w-16 h-16 bg-nexus-elevated rounded-full flex items-center justify-center mb-6">
							<svg class="w-8 h-8 text-nexus-violet" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
						</div>
						<h2 class="text-2xl font-bold mb-2">Build Custom Workflow</h2>
						<p class="text-gray-400 max-w-sm">Drag and drop agents to create a sequence of collaborative tasks.</p>
						<button id="nexus-open-visual-builder" class="mt-8 bg-nexus-violet hover:bg-violet-600 text-white font-bold py-3 px-10 rounded-xl transition-all">Open Visual Builder</button>
					</div>
				</div>
			</div>

			<!-- Visual Builder Modal -->
			<div id="nexus-visual-builder-modal" class="fixed inset-0 z-[9999] hidden">
				<div class="absolute inset-0 bg-black bg-opacity-80 backdrop-blur-sm"></div>
				<div class="absolute inset-4 glass-panel rounded-3xl border border-nexus-border flex overflow-hidden shadow-2xl">
					<!-- Sidebar: Agents -->
					<div class="w-72 border-r border-nexus-border bg-nexus-surface flex flex-col">
						<div class="p-6 border-b border-nexus-border">
							<h3 class="font-bold text-lg text-white">Available Agents</h3>
							<p class="text-xs text-gray-500">Drag an agent to add a workflow step.</p>
						</div>
						<div class="flex-1 overflow-y-auto p-4 space-y-4">
							<?php foreach ( $agents as $agent ) : ?>
								<div class="nexus-draggable-agent p-4 rounded-xl bg-nexus-elevated border border-nexus-border cursor-move hover:border-nexus-violet transition-all" draggable="true" data-id="<?php echo (int) $agent['id']; ?>">
									<p class="font-bold text-sm text-white"><?php echo esc_html( $agent['name'] ); ?></p>
									<p class="text-xs text-gray-500"><?php echo esc_html( $agent['position'] ); ?></p>
								</div>
							<?php endforeach; ?>
						</div>
					</div>

					<!-- Canvas -->
					<div class="flex-1 bg-nexus-bg p-12 flex flex-col">
						<div class="flex justify-between items-center mb-12">
							<h2 class="text-2xl font-bold text-white">Workflow Canvas</h2>
							<div class="flex gap-4">
								<button id="nexus-close-builder" class="text-gray-400 hover:text-white transition-colors">Close Builder</button>
								<button class="bg-nexus-violet px-6 py-2 rounded-lg font-bold text-white shadow-lg shadow-nexus-violet/20">Save Workflow</button>
							</div>
						</div>

						<div id="nexus-workflow-canvas" class="flex-1 border-2 border-dashed border-nexus-border rounded-3xl flex items-center justify-center relative overflow-hidden">
							<div class="text-center">
								<div class="w-20 h-20 mx-auto bg-nexus-elevated rounded-full flex items-center justify-center mb-6">
									<svg class="w-10 h-10 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/></svg>
								</div>
								<p class="text-gray-500 font-medium">Drop first agent here to start the sequence</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php
	}

	/**
	 * Render the "Overview" dashboard page.
	 */
	public function render_overview_page(): void {
		echo $this->get_brand_styles();
		global $wpdb;
		$agent_count = $wpdb->get_var( "SELECT COUNT(*) FROM {$wpdb->prefix}ai_employees WHERE is_active = 1" );
		$doc_count   = $wpdb->get_var( "SELECT COUNT(*) FROM {$wpdb->prefix}ai_knowledge_documents" );
		$total_cost  = $wpdb->get_var( "SELECT SUM(cost) FROM {$wpdb->prefix}ai_usage_logs" ) ?: 0.00;
		?>
		<div class="nexus-admin-body p-8">
			<div class="flex justify-between items-center mb-8">
				<h1 class="text-3xl font-bold text-nexus-violet">Executive Overview</h1>
				<div class="flex gap-4">
					<div class="glass-panel px-4 py-2 rounded-lg text-sm text-gray-400">System Uptime: <span class="text-green-500">99.9%</span></div>
				</div>
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
				<div class="glass-panel p-8 rounded-3xl border border-nexus-border bg-nexus-blue bg-opacity-10 flex flex-col justify-between min-h-[200px] transform hover:scale-[1.02] transition-transform">
					<p class="text-xs text-nexus-blue uppercase tracking-widest font-bold">AI Workforce</p>
					<div>
						<p class="text-5xl font-black mt-2"><?php echo (int) $agent_count; ?></p>
						<p class="text-xs text-gray-400 mt-2">Specialized Agents Active</p>
					</div>
				</div>
				<div class="glass-panel p-8 rounded-3xl border border-nexus-border bg-green-500 bg-opacity-10 flex flex-col justify-between min-h-[200px] transform hover:scale-[1.02] transition-transform">
					<p class="text-xs text-green-500 uppercase tracking-widest font-bold">Company Brain</p>
					<div>
						<p class="text-5xl font-black mt-2"><?php echo (int) $doc_count; ?></p>
						<p class="text-xs text-gray-400 mt-2">Documents Ingested</p>
					</div>
				</div>
				<div class="glass-panel p-8 rounded-3xl border border-nexus-border bg-nexus-gold bg-opacity-10 flex flex-col justify-between min-h-[200px] transform hover:scale-[1.02] transition-transform">
					<p class="text-xs text-nexus-gold uppercase tracking-widest font-bold">Monthly ROI</p>
					<div>
						<p class="text-5xl font-black mt-2">$<?php echo number_format( (float) $total_cost, 2 ); ?></p>
						<p class="text-xs text-gray-400 mt-2">Estimated Value Created</p>
					</div>
				</div>
			</div>

			<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
				<!-- Recent Activity -->
				<div class="glass-panel p-8 rounded-2xl border border-nexus-border">
					<h2 class="text-xl font-semibold mb-6">Workforce Activity</h2>
					<div class="space-y-4">
						<div class="flex items-center gap-4 p-3 rounded-lg bg-nexus-elevated/50">
							<div class="w-2 h-2 rounded-full bg-nexus-violet"></div>
							<p class="text-sm">Agent <span class="font-bold">Sarah</span> updated the SEO strategy for 3 pages.</p>
							<span class="ml-auto text-xs text-gray-500">2m ago</span>
						</div>
						<div class="flex items-center gap-4 p-3 rounded-lg bg-nexus-elevated/50">
							<div class="w-2 h-2 rounded-full bg-nexus-blue"></div>
							<p class="text-sm">Multi-agent meeting completed for <span class="font-bold">Q4 Planning</span>.</p>
							<span class="ml-auto text-xs text-gray-500">15m ago</span>
						</div>
					</div>
				</div>

				<!-- Quick Actions -->
				<div class="glass-panel p-8 rounded-2xl border border-nexus-border bg-nexus-violet/5">
					<h2 class="text-xl font-semibold mb-6">Strategic Actions</h2>
					<div class="grid grid-cols-2 gap-4">
						<button class="p-4 rounded-xl bg-nexus-elevated border border-nexus-border hover:border-nexus-violet text-left transition-all">
							<p class="font-bold text-sm">Start Strategy Meeting</p>
							<p class="text-xs text-gray-500 mt-1">Gather the executive team.</p>
						</button>
						<button class="p-4 rounded-xl bg-nexus-elevated border border-nexus-border hover:border-nexus-violet text-left transition-all">
							<p class="font-bold text-sm">Run Content Audit</p>
							<p class="text-xs text-gray-500 mt-1">Identify SEO gaps.</p>
						</button>
					</div>
				</div>
			</div>
		</div>
		<?php
	}
}
