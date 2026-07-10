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
		<div class="nexus-admin-body p-10">
			<div class="mb-10">
				<h2 class="text-sm font-semibold text-nexus-violet uppercase tracking-widest mb-2">Platform Command</h2>
				<h1 class="text-4xl font-bold text-white">Executive Overview</h1>
				<p class="text-gray-400 mt-2 max-w-2xl">Monitor your AI workforce productivity, token consumption, and strategic activity in real-time. This dashboard provides a high-level view of how AI is impacting your business operations.</p>
			</div>

			<!-- Key Stats: Bento Grid Layout -->
			<div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-12">
				<div class="glass-panel p-8 rounded-3xl collab-wave bg-opacity-20 flex flex-col justify-between min-h-[220px] transform hover:scale-[1.02] transition-transform">
					<p class="text-xs text-white uppercase tracking-widest font-bold">Efficiency Score</p>
					<div>
						<p class="text-6xl font-black mt-2">94.2%</p>
						<p class="text-xs text-white/70 mt-3 font-medium">Automatic Prompt Optimization Active</p>
					</div>
				</div>
				<div class="glass-panel p-8 rounded-3xl bg-nexus-blue bg-opacity-5 flex flex-col justify-between min-h-[220px] transform hover:scale-[1.02] transition-transform text-nexus-blue border-l-4 border-l-nexus-blue">
					<p class="text-xs uppercase tracking-widest font-bold">AI Workforce</p>
					<div>
						<p class="text-6xl font-black mt-2"><?php echo (int) $agent_count; ?></p>
						<p class="text-xs text-gray-400 mt-3">High-Impact Roles Deployed</p>
					</div>
				</div>
				<div class="glass-panel p-8 rounded-3xl bg-green-500 bg-opacity-5 flex flex-col justify-between min-h-[220px] transform hover:scale-[1.02] transition-transform text-green-500 border-l-4 border-l-green-500">
					<p class="text-xs uppercase tracking-widest font-bold">Company Brain</p>
					<div>
						<p class="text-6xl font-black mt-2"><?php echo (int) $doc_count; ?></p>
						<p class="text-xs text-gray-400 mt-3">Global Context Entries Ingested</p>
					</div>
				</div>
				<div class="glass-panel p-8 rounded-3xl bg-nexus-gold bg-opacity-5 flex flex-col justify-between min-h-[220px] transform hover:scale-[1.02] transition-transform text-nexus-gold border-l-4 border-l-nexus-gold">
					<p class="text-xs uppercase tracking-widest font-bold">Strategic ROI</p>
					<div>
						<p class="text-6xl font-black mt-2">$<?php echo number_format( (float) $total_cost * 12, 2 ); ?></p>
						<p class="text-xs text-gray-400 mt-3">Estimated Annual Labor Savings</p>
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
						<button class="p-4 rounded-xl bg-nexus-elevated border border-nexus-border hover:border-nexus-violet text-left transition-all group">
							<p class="font-bold text-sm group-hover:text-nexus-violet">Initialize Meeting</p>
							<p class="text-[10px] text-gray-500 mt-1 uppercase">Expect: Collaborative debate session between agents.</p>
						</button>
						<button class="p-4 rounded-xl bg-nexus-elevated border border-nexus-border hover:border-nexus-blue text-left transition-all group">
							<p class="font-bold text-sm group-hover:text-nexus-blue">Sync Global Memory</p>
							<p class="text-[10px] text-gray-500 mt-1 uppercase">Expect: Re-indexing of all RAG documents.</p>
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
				<div class="glass-panel p-8 rounded-2xl border border-nexus-border dept-exec">
					<div class="mb-6 flex justify-between items-start">
						<div>
							<h2 class="text-xl font-semibold">Hire New AI Agent</h2>
							<p class="text-xs text-gray-500 mt-1 italic">Pro-Tip: Agents with 'Logical' personality work best with Temperature set to 0.2.</p>
						</div>
					</div>

					<!-- Pre-configured Agents Dropdown -->
					<div class="mb-8 p-6 bg-nexus-violet/10 rounded-2xl border border-nexus-violet/20">
						<label class="block text-sm font-bold text-nexus-violet mb-3 uppercase tracking-tighter">Fast-Hire: Select Expert Template</label>
						<select id="nexus-agent-template-selector" class="w-full bg-nexus-elevated border border-nexus-border rounded-xl p-4 text-white font-medium focus:ring-2 focus:ring-nexus-violet transition-all">
							<option value="">-- Choose an Expert --</option>
							<optgroup label="Executive Suite">
								<option value="ceo">CEO - Strategic Visionary</option>
								<option value="cto">CTO - Systems Architect</option>
								<option value="cmo">CMO - Growth Architect</option>
								<option value="cfo">CFO - Financial Strategist</option>
							</optgroup>
							<optgroup label="Marketing & Sales">
								<option value="seo">SEO Specialist - Traffic Growth</option>
								<option value="copywriter">Copywriter - Conversion Expert</option>
								<option value="ads">Paid Ads Specialist - ROAS Expert</option>
								<option value="sales">Sales Director - Revenue Architect</option>
							</optgroup>
							<optgroup label="Operations & Support">
								<option value="hr">HR Manager - Culture Builder</option>
								<option value="legal">Legal Advisor - Risk Mitigator</option>
								<option value="qa">QA Engineer - Product Stability</option>
								<option value="data">Data Analyst - Business Intelligence</option>
								<option value="support">Customer Support Manager - Success Expert</option>
							</optgroup>
						</select>
						<p class="text-[10px] text-gray-500 mt-3">Expect: Selecting a template will automatically populate the persona, mission, and model settings below.</p>
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
								<textarea name="identity" class="w-full bg-nexus-elevated border border-nexus-border rounded-lg p-3 text-white h-24" placeholder="Who is this AI?"></textarea>
								<p class="text-[10px] text-gray-500 mt-1 uppercase">Mechanism: Injected as the core 'System Message' for this agent.</p>
							</div>
							<div>
								<label class="block text-sm font-medium text-gray-400 mb-2">Mission (Primary Objective)</label>
								<textarea name="mission" class="w-full bg-nexus-elevated border border-nexus-border rounded-lg p-3 text-white h-24" placeholder="What is its main goal?"></textarea>
								<p class="text-[10px] text-gray-500 mt-1 uppercase">Mechanism: Serves as the priority 'Goal' in the prompting logic.</p>
							</div>
						</div>
						<div class="grid grid-cols-2 gap-4">
							<div>
								<label class="block text-sm font-medium text-gray-400 mb-2">AI Model</label>
								<select name="model" class="w-full bg-nexus-elevated border border-nexus-border rounded-lg p-3 text-white">
									<option value="gpt-4o">GPT-4o (Recommended)</option>
									<option value="claude-3-5-sonnet-20240620">Claude 3.5 Sonnet</option>
									<option value="gemini-1.5-pro">Gemini 1.5 Pro</option>
								</select>
							</div>
							<div>
								<label class="block text-sm font-medium text-gray-400 mb-2">Creativity (Temp)</label>
								<input type="range" name="temperature" min="0" max="1" step="0.1" value="0.7" class="w-full h-2 bg-nexus-border rounded-lg appearance-none cursor-pointer accent-nexus-violet">
							</div>
						</div>
						<button type="submit" class="w-full bg-nexus-violet hover:bg-violet-600 text-white font-bold py-4 rounded-xl transition-all shadow-lg shadow-nexus-violet/20">Deploy Agent</button>
						<span class="nexus-button-note text-center">Expect: The agent will be initialized with a permanent profile and added to your Workforce roster.</span>
					</form>
				</div>

				<div class="space-y-8">
					<div class="glass-panel p-8 rounded-3xl border border-nexus-border bg-nexus-violet/5 flex flex-col justify-center min-h-[150px]">
						<p class="text-sm text-gray-400 uppercase tracking-widest font-bold">Workforce Strength</p>
						<p class="text-6xl font-black mt-2 text-white">READY</p>
					</div>
					<div class="glass-panel p-8 rounded-2xl border border-nexus-border">
						<h3 class="text-lg font-medium mb-4">Current Workforce</h3>
						<div class="text-sm text-gray-500 italic">No agents hired yet. Start by selecting a template or creating a custom agent.</div>
					</div>
				</div>
			</div>

			<div id="nexus-marketplace-tab" class="nexus-tab-content hidden">
				<div class="grid grid-cols-1 md:grid-cols-3 gap-8">
					<!-- Marketplace Item -->
					<div class="glass-panel p-8 rounded-3xl border border-nexus-border hover:border-nexus-gold transition-all group glass-card-hover">
						<div class="w-16 h-16 rounded-2xl bg-nexus-gold/10 flex items-center justify-center text-nexus-gold mb-6 group-hover:scale-110 transition-transform">
							<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
						</div>
						<h3 class="text-xl font-bold text-white">Grant Writer Pro</h3>
						<p class="text-sm text-gray-500 mt-2">Specialized in winning high-value federal and private grants. Trained on 5,000+ winning proposals.</p>
						<button class="nexus-marketplace-install w-full mt-8 bg-nexus-gold/20 hover:bg-nexus-gold text-nexus-gold hover:text-black font-bold py-3 rounded-xl transition-all" data-agent="grant_writer">Install for $49/mo</button>
						<span class="nexus-button-note">Expect: One-click installation and configuration of this expert role.</span>
					</div>

					<div class="glass-panel p-8 rounded-3xl border border-nexus-border hover:border-nexus-blue transition-all group glass-card-hover">
						<div class="w-16 h-16 rounded-2xl bg-nexus-blue/10 flex items-center justify-center text-nexus-blue mb-6 group-hover:scale-110 transition-transform">
							<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"/></svg>
						</div>
						<h3 class="text-xl font-bold text-white">Legal Advisor (LLM)</h3>
						<p class="text-sm text-gray-500 mt-2">Drafts contracts, reviews TOS, and provides compliance audits based on latest EU/US regulations.</p>
						<button class="nexus-marketplace-install w-full mt-8 bg-nexus-blue/20 hover:bg-nexus-blue text-nexus-blue hover:text-white font-bold py-3 rounded-xl transition-all" data-agent="legal_advisor">Install for $99/mo</button>
						<span class="nexus-button-note">Expect: Secure integration of high-compliance legal reasoning modules.</span>
					</div>

					<div class="glass-panel p-8 rounded-3xl border border-nexus-border hover:border-nexus-violet transition-all group glass-card-hover">
						<div class="w-16 h-16 rounded-2xl bg-nexus-violet/10 flex items-center justify-center text-nexus-violet mb-6 group-hover:scale-110 transition-transform">
							<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
						</div>
						<h3 class="text-xl font-bold text-white">WP Plugin Architect</h3>
						<p class="text-sm text-gray-500 mt-2">Writes production-ready, secure WordPress code following PSR-12 and VIP standards.</p>
						<button class="nexus-marketplace-install w-full mt-8 bg-nexus-violet/20 hover:bg-nexus-violet text-nexus-violet hover:text-white font-bold py-3 rounded-xl transition-all" data-agent="wp_architect">Install for $79/mo</button>
						<span class="nexus-button-note">Expect: Advanced WordPress-specific code generation and bug-fixing capabilities.</span>
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

			<div class="max-w-6xl grid grid-cols-1 md:grid-cols-2 gap-10">
				<div class="glass-panel p-8 rounded-2xl border border-nexus-border">
					<h2 class="text-xl font-semibold mb-6 text-nexus-violet">Global AI Engine</h2>
					<form id="nexus-settings-form" class="space-y-6">
						<div>
							<label class="block text-sm font-medium text-gray-400 mb-2">OpenAI API Key</label>
							<input type="password" name="openai_api_key" class="w-full bg-nexus-elevated border border-nexus-border rounded-lg p-3 text-white focus:border-nexus-violet outline-none" placeholder="sk-...">
						</div>
						<div>
							<label class="block text-sm font-medium text-gray-400 mb-2">Anthropic API Key</label>
							<input type="password" name="claude_api_key" class="w-full bg-nexus-elevated border border-nexus-border rounded-lg p-3 text-white focus:border-nexus-violet outline-none" placeholder="sk-ant-...">
						</div>
						<div class="nexus-pro-tip">
							<p class="font-bold text-nexus-gold mb-1">PRO TIP:</p>
							<p>Use GPT-4o for high-reasoning tasks like CEO or Legal. Use GPT-4o Mini or Claude Sonnet for high-volume tasks like Customer Support.</p>
						</div>
						<button type="submit" class="w-full bg-nexus-violet text-white font-bold py-4 rounded-xl transition-all shadow-lg shadow-nexus-violet/20">Save Configuration</button>
						<span class="nexus-button-note text-center">Expect: Encrypted storage of keys and immediate connectivity test for all active adapters.</span>
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
							<div class="flex items-center gap-4">
								<input type="color" name="ui_color" class="w-20 h-12 bg-nexus-elevated border border-nexus-border rounded-lg p-1 text-white cursor-pointer" value="#7C3AED">
								<p class="text-xs text-gray-500">This color will be applied to buttons, accents, and the "Overview" theme.</p>
							</div>
						</div>
						<div class="p-6 rounded-2xl bg-nexus-elevated border border-nexus-border">
							<p class="text-sm font-bold text-white mb-2">Agency Mode</p>
							<p class="text-xs text-gray-500">Hide "Harborne AI" references and use your own branding for client dashboards.</p>
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

			<div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
				<div class="glass-panel p-8 rounded-2xl border border-nexus-border dept-tech">
					<h2 class="text-xl font-semibold mb-6">Ingest Information</h2>
					<div class="space-y-8">
						<div class="border-2 border-dashed border-nexus-border rounded-2xl p-10 text-center hover:border-nexus-blue transition-all bg-nexus-blue/5 group">
							<div class="w-16 h-16 rounded-full bg-nexus-blue/10 flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
								<svg class="w-8 h-8 text-nexus-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
							</div>
							<p class="text-sm text-gray-300 font-medium">Drop PDF, DOCX, or CSV files here</p>
							<button class="mt-6 bg-nexus-elevated border border-nexus-border text-white px-8 py-3 rounded-xl text-sm font-bold hover:border-nexus-blue transition-all">Select Local Files</button>
							<span class="nexus-button-note">Expect: Documents will be chunked, embedded, and added to the vector index.</span>
						</div>
						<div>
							<label class="block text-sm font-medium text-gray-400 mb-2">Index Website URL</label>
							<div class="flex gap-2">
								<input type="url" class="flex-1 bg-nexus-elevated border border-nexus-border rounded-xl p-4 text-white outline-none focus:border-nexus-blue" placeholder="https://your-competitor.com/pricing">
								<button class="bg-nexus-blue text-white px-8 py-2 rounded-xl font-bold hover:bg-blue-600 transition-all shadow-lg shadow-nexus-blue/20">Index URL</button>
							</div>
							<span class="nexus-button-note">Expect: Scraper will crawl the page and extract semantic content for agent context.</span>
						</div>
					</div>
				</div>

				<div class="space-y-6">
					<div class="nexus-pro-tip">
						<p class="font-bold text-nexus-gold mb-2 uppercase">Semantic Indexing Notice:</p>
						<p>Documents uploaded here are accessible by ALL agents in your workforce. Use "Agent Specific Memory" in the Workforce tab for private training data.</p>
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
				<p class="text-gray-400 mt-2 max-w-2xl">Create complex workflows where multiple AI agents collaborate to finish a task. Automate entire departments with specialized agent chains.</p>
			</div>

			<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
				<div class="lg:col-span-1 space-y-6">
					<h2 class="text-xl font-semibold mb-6">Workflow Blueprints</h2>
					<div class="glass-panel p-6 rounded-2xl border border-nexus-border hover:border-nexus-green cursor-pointer transition-all glass-card-hover group border-l-4 border-l-nexus-green">
						<h3 class="font-bold text-white group-hover:text-nexus-green">Content Machine</h3>
						<p class="text-xs text-gray-500 mt-1">Research -> Copywriting -> SEO -> Publish</p>
					</div>
					<div class="glass-panel p-6 rounded-2xl border border-nexus-border hover:border-nexus-blue cursor-pointer transition-all glass-card-hover group border-l-4 border-l-nexus-blue">
						<h3 class="font-bold text-white group-hover:text-nexus-blue">Technical Audit</h3>
						<p class="text-xs text-gray-500 mt-1">Scan Logs -> Analyze Security -> Suggest Fixes -> Notify CTO</p>
					</div>
				</div>

				<div class="lg:col-span-2">
					<div class="glass-panel p-8 rounded-3xl border border-nexus-border min-h-[500px] flex flex-col items-center justify-center text-center bg-nexus-green/5">
						<h2 class="text-3xl font-bold mb-4 text-white">Build Custom Workflow</h2>
						<p class="text-gray-400 max-w-md mb-8">Orchestrate your workforce by dragging and dropping agents into a logical execution chain.</p>
						<button id="nexus-open-visual-builder" class="bg-nexus-green hover:bg-green-600 text-white font-bold py-4 px-12 rounded-xl transition-all shadow-lg shadow-green-500/20">Open Visual Builder</button>
						<span class="nexus-button-note mt-4">Expect: Full canvas editor with logic gates and agent assignment controls.</span>
					</div>
				</div>
			</div>

			<!-- Visual Builder Modal -->
			<div id="nexus-visual-builder-modal" class="fixed inset-0 z-[9999] hidden">
				<div class="absolute inset-0 bg-black/90 backdrop-blur-xl"></div>
				<div class="absolute inset-8 glass-panel rounded-3xl border border-nexus-border flex overflow-hidden shadow-2xl">
					<div class="w-80 border-r border-nexus-border bg-nexus-surface flex flex-col p-8">
						<h3 class="font-bold text-xl text-white mb-6">Agent Pool</h3>
						<div class="flex-1 overflow-y-auto space-y-4">
							<?php foreach ( $agents as $agent ) : ?>
								<div class="nexus-draggable-agent p-4 rounded-xl bg-nexus-elevated border border-nexus-border cursor-grab active:cursor-grabbing hover:border-nexus-violet transition-all group" draggable="true" data-id="<?php echo (int) $agent['id']; ?>">
									<p class="font-bold text-sm text-white group-hover:text-nexus-violet"><?php echo esc_html( $agent['name'] ); ?></p>
									<p class="text-[10px] text-gray-500 uppercase mt-1"><?php echo esc_html( $agent['position'] ); ?></p>
								</div>
							<?php endforeach; ?>
						</div>
					</div>
					<div class="flex-1 bg-nexus-bg p-12 flex flex-col bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')]">
						<div class="flex justify-between items-center mb-12">
							<div>
								<h2 class="text-3xl font-bold text-white">Workflow Canvas</h2>
								<p class="text-xs text-gray-500 mt-1">Drag agents from the left pool to establish an execution sequence.</p>
							</div>
							<div class="flex gap-4">
								<button class="bg-nexus-violet text-white px-6 py-2 rounded-xl font-bold">Save Workflow</button>
								<button id="nexus-close-builder" class="text-gray-400 hover:text-white bg-nexus-elevated px-4 rounded-xl">✕</button>
							</div>
						</div>
						<div id="nexus-workflow-canvas" class="flex-1 border-4 border-dashed border-nexus-border rounded-3xl flex items-center justify-center relative bg-black/20">
							<div class="text-center">
								<div class="w-20 h-20 bg-nexus-border/50 rounded-full flex items-center justify-center mx-auto mb-4">
									<svg class="w-10 h-10 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
								</div>
								<p class="text-gray-500 font-bold uppercase tracking-widest text-sm">Drop Agents Here to Begin</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php
	}

	/**
	 * Render the "Collaboration Hub" (AI Meetings) page.
	 */
	public function render_meetings_page(): void {
		echo $this->get_brand_styles();
		global $wpdb;
		$agents = $wpdb->get_results( "SELECT id, name, position, avatar FROM {$wpdb->prefix}ai_employees WHERE is_active = 1", ARRAY_A ) ?: [];
		?>
		<div class="nexus-admin-body p-10">
			<div class="mb-10 flex justify-between items-end">
				<div>
					<h2 class="text-sm font-semibold text-nexus-blue uppercase tracking-widest mb-2">Strategic Intelligence</h2>
					<h1 class="text-4xl font-bold text-white">Collaboration Hub</h1>
					<p class="text-gray-400 mt-2 max-w-2xl">Start a virtual meeting. Gather your AI executives to brainstorm, solve problems, and reach a consensus on complex business decisions.</p>
				</div>
				<div class="text-right">
					<button id="nexus-start-meeting-btn" class="bg-nexus-violet hover:bg-violet-600 text-white font-bold py-4 px-10 rounded-xl transition-all shadow-lg shadow-nexus-violet/20">
						Start Strategic Meeting
					</button>
					<span class="nexus-button-note mt-2">Expect: A multi-agent consensus loop where each agent provides role-specific insights.</span>
				</div>
			</div>

			<div class="grid grid-cols-1 lg:grid-cols-4 gap-10">
				<!-- Meeting Controls Sidebar -->
				<div class="lg:col-span-1 space-y-8">
					<div class="glass-panel p-6 rounded-2xl border border-nexus-border dept-exec">
						<h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-6">1. Invite Participants</h3>
						<div class="space-y-3">
							<?php foreach ( $agents as $agent ) : ?>
								<label class="flex items-center gap-3 p-4 rounded-xl bg-nexus-elevated border border-nexus-border hover:border-nexus-violet cursor-pointer transition-all group">
									<input type="checkbox" class="nexus-meeting-invitee w-5 h-5 rounded border-gray-600 bg-gray-700 text-nexus-violet focus:ring-nexus-violet" value="<?php echo (int) $agent['id']; ?>">
									<div>
										<p class="text-sm font-bold text-white group-hover:text-nexus-violet transition-colors"><?php echo esc_html( $agent['name'] ); ?></p>
										<p class="text-[10px] text-gray-500 uppercase"><?php echo esc_html( $agent['position'] ); ?></p>
									</div>
								</label>
							<?php endforeach; ?>
						</div>
					</div>

					<div class="glass-panel p-6 rounded-2xl border border-nexus-border">
						<h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">2. Define Agenda</h3>
						<textarea id="nexus-meeting-agenda" class="w-full h-40 bg-nexus-elevated border border-nexus-border rounded-xl p-4 text-white text-sm outline-none focus:border-nexus-violet" placeholder="Enter the strategic objective, problem, or goal for this session..."></textarea>
						<p class="text-[10px] text-gray-500 mt-3">PRO TIP: Be specific. "How should we pivot our Q4 marketing strategy given a 20% budget cut?"</p>
					</div>
				</div>

				<!-- Live Transcription Area -->
				<div class="lg:col-span-3">
					<div id="nexus-meeting-room" class="glass-panel rounded-3xl border border-nexus-border min-h-[650px] flex flex-col overflow-hidden bg-black/40">
						<div class="p-6 border-b border-nexus-border bg-nexus-elevated/50 flex justify-between items-center">
							<div class="flex items-center gap-4">
								<div class="w-3 h-3 rounded-full bg-red-500 animate-pulse shadow-[0_0_10px_rgba(239,68,68,0.5)]"></div>
								<h2 class="font-bold text-white uppercase tracking-widest text-sm">Live Strategic Transcription</h2>
							</div>
							<div class="flex gap-2">
								<span class="text-[10px] text-nexus-violet font-bold bg-nexus-violet/10 border border-nexus-violet/20 px-3 py-1 rounded-full uppercase">Real-time Reasoning</span>
								<span class="text-[10px] text-nexus-blue font-bold bg-nexus-blue/10 border border-nexus-blue/20 px-3 py-1 rounded-full uppercase">Consensus Mode</span>
							</div>
						</div>

						<div id="nexus-meeting-transcript" class="flex-1 p-10 space-y-8 overflow-y-auto max-h-[500px] bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')]">
							<div class="flex flex-col items-center justify-center h-full text-center">
								<div class="w-24 h-24 bg-nexus-violet/5 rounded-full flex items-center justify-center mb-6 border border-nexus-violet/10">
									<svg class="w-12 h-12 text-nexus-violet/20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9l-4 4v-4H3a2 2 0 01-2-2V10a2 2 0 012-2h2m3.382-7.034l.437.218a1 1 0 01.39 1.17l-.5 1.5a1 1 0 01-1.17.39l-1.5-.5a1 1 0 01-.39-1.17l.5-1.5a1 1 0 011.17-.39zM15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
								</div>
								<h3 class="text-white font-bold text-xl mb-2">Awaiting Session Initialization</h3>
								<p class="text-gray-500 max-w-xs mx-auto text-sm leading-relaxed">Select your strategic participants and define the agenda to begin the multi-agent collaboration loop.</p>
							</div>
						</div>

						<div class="p-8 bg-nexus-elevated/50 border-t border-nexus-border flex gap-4">
							<input type="text" id="nexus-meeting-input" class="flex-1 bg-nexus-elevated border border-nexus-border rounded-xl p-5 text-white outline-none focus:border-nexus-blue" placeholder="Insert chairman instruction or followup question...">
							<button id="nexus-send-meeting-msg" class="bg-nexus-blue hover:bg-blue-600 text-white font-bold px-10 rounded-xl transition-all shadow-lg shadow-nexus-blue/20">Send</button>
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
		<div class="nexus-admin-body p-10">
			<div class="mb-10">
				<h2 class="text-sm font-semibold text-nexus-violet uppercase tracking-widest mb-2">Learning Center</h2>
				<h1 class="text-4xl font-bold text-white">Platform Tutorials (<?php echo ucfirst($level); ?> Level)</h1>
				<p class="text-gray-400 mt-2 max-w-2xl">Master the Nexus AI Workforce platform with specialized guides designed for your access level. Learn to train, deploy, and scale your AI departments.</p>
			</div>

			<div class="grid grid-cols-1 md:grid-cols-3 gap-10">
				<div class="glass-panel p-8 rounded-3xl border border-nexus-border hover:border-nexus-violet transition-all glass-card-hover group">
					<div class="w-14 h-14 bg-nexus-violet/10 rounded-2xl flex items-center justify-center mb-6 text-nexus-violet group-hover:scale-110 transition-transform">
						<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
					</div>
					<h3 class="text-xl font-bold mb-2 text-white">The Core Blueprint</h3>
					<p class="text-sm text-gray-500 mb-8 leading-relaxed">Learn how AI agents interact with WordPress data. Master the art of 'Identity' crafting and 'Mission' definition for peak ROI.</p>
					<a href="#" class="inline-block bg-nexus-violet/20 text-nexus-violet px-6 py-2 rounded-xl font-bold hover:bg-nexus-violet hover:text-white transition-all">Start Lesson</a>
				</div>
				<?php if ($level === 'admin' || $level === 'agency') : ?>
					<div class="glass-panel p-8 rounded-3xl border border-nexus-border hover:border-nexus-blue transition-all glass-card-hover group">
						<div class="w-14 h-14 bg-nexus-blue/10 rounded-2xl flex items-center justify-center mb-6 text-nexus-blue group-hover:scale-110 transition-transform">
							<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
						</div>
						<h3 class="text-xl font-bold mb-2 text-white">Scaling ROI (Agency)</h3>
						<p class="text-sm text-gray-500 mb-8 leading-relaxed">Master the 'AI-as-a-Service' model. Learn to white-label the platform and build custom AI workforces for your clients.</p>
						<a href="#" class="inline-block bg-nexus-blue/20 text-nexus-blue px-6 py-2 rounded-xl font-bold hover:bg-nexus-blue hover:text-white transition-all">Start Lesson</a>
					</div>
					<div class="glass-panel p-8 rounded-3xl border border-nexus-border hover:border-nexus-gold transition-all glass-card-hover group">
						<div class="w-14 h-14 bg-nexus-gold/10 rounded-2xl flex items-center justify-center mb-6 text-nexus-gold group-hover:scale-110 transition-transform">
							<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
						</div>
						<h3 class="text-xl font-bold mb-2 text-white">Security & RBAC</h3>
						<p class="text-sm text-gray-500 mb-8 leading-relaxed">Configure enterprise permissions and secure your API infrastructure. Learn to manage multiple AI models safely.</p>
						<a href="#" class="inline-block bg-nexus-gold/20 text-nexus-gold px-6 py-2 rounded-xl font-bold hover:bg-nexus-gold hover:text-white transition-all">Start Lesson</a>
					</div>
				<?php endif; ?>
			</div>
		</div>
		<?php
	}
}
