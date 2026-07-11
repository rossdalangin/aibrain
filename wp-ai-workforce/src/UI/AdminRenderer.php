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
		<div class="nexus-admin-body p-10 theme-overview">
			<div class="mb-10">
				<h2 class="text-sm font-semibold text-accent uppercase tracking-widest mb-2">Platform Command</h2>
				<h1 class="text-4xl font-bold text-white">Executive Overview</h1>
				<p class="text-gray-400 mt-2 max-w-2xl">Monitor your AI workforce productivity, token consumption, and strategic activity in real-time.</p>
			</div>

			<div class="nexus-step-guide">
				<h3 class="text-white font-bold mb-3 uppercase tracking-tighter text-sm flex items-center gap-2">
					<span class="w-5 h-5 bg-accent rounded-full flex items-center justify-center text-[10px]">1</span>
					Quick Start Guide
				</h3>
				<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
					<div class="text-xs text-gray-400">
						<p class="font-bold text-white mb-1">Step 1: Infrastructure</p>
						<p>Go to <span class="text-accent">Settings</span> and add your OpenAI or Anthropic API keys to power the engine.</p>
					</div>
					<div class="text-xs text-gray-400">
						<p class="font-bold text-white mb-1">Step 2: Hire Workforce</p>
						<p>Visit <span class="text-accent">Hire AI Agents</span> to deploy specialized roles like a CEO, CMO, or Developer.</p>
					</div>
					<div class="text-xs text-gray-400">
						<p class="font-bold text-white mb-1">Step 3: Train Brain</p>
						<p>Upload your SOPs and PDFs in <span class="text-accent">Company Brain</span> to give agents context.</p>
					</div>
				</div>
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

			<!-- System Health Monitor -->
			<div class="glass-panel p-8 rounded-2xl border border-nexus-border mb-12 bg-white/5">
				<div class="flex justify-between items-center mb-6">
					<h2 class="text-xl font-bold flex items-center gap-3">
						<span class="w-3 h-3 bg-green-500 rounded-full animate-pulse"></span>
						System Core Integrity
					</h2>
					<span class="text-xs text-gray-500 uppercase font-bold tracking-widest">v1.0.0 Stable</span>
				</div>
				<div class="grid grid-cols-2 md:grid-cols-5 gap-6">
					<div class="p-4 rounded-xl bg-nexus-elevated border border-white/5">
						<p class="text-[10px] text-gray-500 uppercase mb-1">Database</p>
						<p class="text-sm font-bold text-green-500">OPTIMIZED</p>
					</div>
					<div class="p-4 rounded-xl bg-nexus-elevated border border-white/5">
						<p class="text-[10px] text-gray-500 uppercase mb-1">RAG Engine</p>
						<p class="text-sm font-bold text-green-500">READY</p>
					</div>
					<div class="p-4 rounded-xl bg-nexus-elevated border border-white/5">
						<p class="text-[10px] text-gray-500 uppercase mb-1">Encryption</p>
						<p class="text-sm font-bold text-nexus-violet uppercase">AES-256-CTR</p>
					</div>
					<div class="p-4 rounded-xl bg-nexus-elevated border border-white/5">
						<p class="text-[10px] text-gray-500 uppercase mb-1">Memory</p>
						<p class="text-sm font-bold text-white">PERSISTENT</p>
					</div>
					<div class="p-4 rounded-xl bg-nexus-elevated border border-white/5">
						<p class="text-[10px] text-gray-500 uppercase mb-1">Adapters</p>
						<p class="text-sm font-bold text-nexus-blue">7 ACTIVE</p>
					</div>
				</div>
			</div>

			<div class="grid grid-cols-1 lg:grid-cols-2 gap-10 mb-12">
				<div class="glass-panel p-8 rounded-3xl border border-nexus-border">
					<h2 class="text-xl font-bold mb-6 flex justify-between items-center">
						Consumption Trends
						<span class="text-[10px] text-gray-500 uppercase tracking-widest font-bold">Last 30 Days</span>
					</h2>
					<div class="h-64">
						<canvas id="nexus-consumption-chart"></canvas>
					</div>
				</div>
				<div class="glass-panel p-8 rounded-3xl border border-nexus-border">
					<h2 class="text-xl font-bold mb-6 flex justify-between items-center">
						Workforce Efficiency
						<span class="text-[10px] text-gray-500 uppercase tracking-widest font-bold">Output Metrics</span>
					</h2>
					<div class="h-64">
						<canvas id="nexus-efficiency-chart"></canvas>
					</div>
				</div>
			</div>

			<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
				<div class="glass-panel p-8 rounded-2xl border border-nexus-border">
					<h2 class="text-xl font-semibold mb-6">Workforce Activity</h2>
					<div class="space-y-4">
						<div class="flex items-center gap-4 p-3 rounded-lg bg-nexus-elevated/50">
							<div class="w-2 h-2 rounded-full bg-accent"></div>
							<p class="text-sm">Agent <span class="font-bold">Sarah</span> updated SEO for 3 pages.</p>
							<span class="ml-auto text-xs text-gray-500">2m ago</span>
						</div>
					</div>
				</div>
				<div class="glass-panel p-8 rounded-2xl border border-nexus-border bg-accent/5">
					<h2 class="text-xl font-semibold mb-6">Enterprise Quick-Tools</h2>
					<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
						<button class="p-5 rounded-2xl bg-nexus-elevated border border-nexus-border hover:border-nexus-violet text-left transition-all group nexus-btn-vibrant theme-overview">
							<p class="font-bold text-sm text-white group-hover:text-accent">Prompt Rewriter</p>
							<p class="text-[10px] text-gray-500 mt-1 uppercase">Refine agent instructions for GPT-4o.</p>
						</button>
						<button class="p-5 rounded-2xl bg-nexus-elevated border border-nexus-border hover:border-nexus-blue text-left transition-all group nexus-btn-vibrant theme-kb">
							<p class="font-bold text-sm text-white group-hover:text-accent">Context Optimizer</p>
							<p class="text-[10px] text-gray-500 mt-1 uppercase">Prune redundant Company Brain chunks.</p>
						</button>
						<button id="nexus-purge-logs" class="p-5 rounded-2xl bg-nexus-elevated border border-nexus-border hover:border-red-500 text-left transition-all group">
							<p class="font-bold text-sm text-white group-hover:text-red-500">System Purge</p>
							<p class="text-[10px] text-gray-500 mt-1 uppercase">Clear all usage logs and transcripts.</p>
						</button>
						<button class="p-5 rounded-2xl bg-nexus-elevated border border-nexus-border hover:border-accent text-left transition-all group nexus-btn-vibrant theme-learning">
							<p class="font-bold text-sm text-white group-hover:text-accent">ROAS Audit</p>
							<p class="text-[10px] text-gray-500 mt-1 uppercase">Generate instant marketing report.</p>
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
		<div class="nexus-admin-body p-10 theme-workforce">
			<div class="mb-10 flex justify-between items-end">
				<div>
					<h2 class="text-sm font-semibold text-accent uppercase tracking-widest mb-2 text-green-500">Talent Management</h2>
					<h1 class="text-4xl font-bold text-white">Hire & Manage AI Agents</h1>
					<p class="text-gray-400 mt-2 max-w-2xl">Build your virtual executive team. Each agent you hire has a unique personality and specific professional goals.</p>
				</div>
				<div class="flex gap-2 bg-nexus-elevated p-1 rounded-xl border border-nexus-border">
					<button class="nexus-tab-btn px-6 py-2 rounded-lg text-sm font-bold bg-accent text-white" data-tab="hiring">In-House</button>
					<button class="nexus-tab-btn px-6 py-2 rounded-lg text-sm font-bold text-gray-400 hover:text-white transition-all" data-tab="marketplace">Global Marketplace</button>
				</div>
			</div>

			<div class="nexus-step-guide">
				<div class="grid grid-cols-1 md:grid-cols-4 gap-8">
					<div class="text-xs text-gray-400">
						<p class="font-bold text-white mb-1">Step 1: Select Template</p>
						<p>Use the <span class="text-accent font-bold">Fast-Hire</span> dropdown to pick a pre-configured role.</p>
					</div>
					<div class="text-xs text-gray-400">
						<p class="font-bold text-white mb-1">Step 2: Define Persona</p>
						<p>Customize the <span class="text-accent font-bold">Identity</span> and <span class="text-accent font-bold">Mission</span> for your specific business.</p>
					</div>
					<div class="text-xs text-gray-400">
						<p class="font-bold text-white mb-1">Step 3: Select Model</p>
						<p>Pick a brain for the agent. <span class="text-accent font-bold">GPT-4o</span> is best for complex strategy.</p>
					</div>
					<div class="text-xs text-gray-400">
						<p class="font-bold text-white mb-1">Step 4: Deploy</p>
						<p>Click <span class="text-accent font-bold">Deploy Agent</span> to start using them immediately.</p>
					</div>
				</div>
			</div>

			<div id="nexus-hiring-tab" class="nexus-tab-content grid grid-cols-1 lg:grid-cols-2 gap-10">
				<div class="glass-panel p-8 rounded-2xl border border-nexus-border dept-tech">
					<div class="mb-6">
						<h2 class="text-xl font-semibold">Hire New AI Agent</h2>
					</div>

					<!-- Pre-configured Agents Dropdown -->
					<div class="mb-8 p-6 bg-accent/5 rounded-2xl border border-accent/20">
						<label class="block text-sm font-bold text-accent mb-3 uppercase tracking-tighter">Fast-Hire: Select Expert Template</label>
						<select id="nexus-agent-template-selector" class="w-full bg-nexus-elevated border border-nexus-border rounded-xl p-4 text-white font-medium focus:ring-2 focus:ring-accent transition-all">
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
						<p class="text-[10px] text-gray-500 mt-3">Expect: Instant population of professional identity and mission constraints.</p>
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
							</div>
							<div>
								<label class="block text-sm font-medium text-gray-400 mb-2">Mission (Primary Objective)</label>
								<textarea name="mission" class="w-full bg-nexus-elevated border border-nexus-border rounded-lg p-3 text-white h-24" placeholder="What is its main goal?"></textarea>
							</div>
						</div>
						<div class="grid grid-cols-2 gap-6">
							<div>
								<label class="block text-sm font-medium text-gray-400 mb-2">Communication Tone</label>
								<select name="personality" class="w-full bg-nexus-elevated border border-nexus-border rounded-lg p-3 text-white">
									<option value="professional">Professional & Direct</option>
									<option value="creative">Creative & Enthusiastic</option>
									<option value="analytical">Analytical & Fact-based</option>
									<option value="motivational">Visionary & Motivational</option>
									<option value="technical">Technical & Precise</option>
								</select>
							</div>
							<div>
								<label class="block text-sm font-medium text-gray-400 mb-2">Voice Identity</label>
								<select name="voice" class="w-full bg-nexus-elevated border border-nexus-border rounded-lg p-3 text-white">
									<option value="onyx">OpenAI - Onyx (Deep)</option>
									<option value="nova">OpenAI - Nova (Energetic)</option>
									<option value="shimmer">OpenAI - Shimmer (Soft)</option>
									<option value="eleven_multilingual">ElevenLabs - Professional</option>
								</select>
							</div>
						</div>
						<div class="grid grid-cols-2 gap-4">
							<div>
								<label class="block text-sm font-medium text-gray-400 mb-2">AI Model</label>
								<select name="model" class="w-full bg-nexus-elevated border border-nexus-border rounded-lg p-3 text-white">
									<option value="gpt-4o">GPT-4o (Recommended)</option>
									<option value="claude-3-5-sonnet-20240620">Claude 3.5 Sonnet</option>
									<option value="gemini-1.5-pro">Gemini 1.5 Pro</option>
									<option value="openrouter/meta-llama/llama-3.1-405b-instruct">Llama 3.1 405B (OpenRouter)</option>
								</select>
							</div>
							<div>
								<label class="block text-sm font-medium text-gray-400 mb-2">Creativity (Temp)</label>
								<input type="range" name="temperature" min="0" max="1" step="0.1" value="0.7" class="w-full h-2 bg-nexus-border rounded-lg appearance-none cursor-pointer accent-accent">
							</div>
						</div>
						<button type="submit" class="w-full bg-accent hover:bg-green-600 text-white font-bold py-4 rounded-xl transition-all shadow-lg shadow-green-500/10 nexus-btn-vibrant">Deploy Agent</button>
						<span class="nexus-button-note text-center">Expect: Permanent agent profile creation and workforce integration.</span>
					</form>
				</div>

				<div class="space-y-8">
					<div class="glass-panel p-8 rounded-3xl border border-nexus-border bg-accent/5 flex flex-col justify-center min-h-[150px]">
						<p class="text-sm text-gray-400 uppercase tracking-widest font-bold">Workforce Capability</p>
						<p class="text-6xl font-black mt-2 text-white">ACTIVE</p>
					</div>
					<div class="glass-panel p-8 rounded-2xl border border-nexus-border">
						<h3 class="text-lg font-medium mb-4">Current Workforce</h3>
						<div class="text-sm text-gray-500 italic">Start by selecting a template or creating a custom agent.</div>
					</div>
				</div>
			</div>

			<div id="nexus-marketplace-tab" class="nexus-tab-content hidden">
				<div class="grid grid-cols-1 md:grid-cols-3 gap-8">
					<div class="glass-panel p-8 rounded-3xl border border-nexus-border hover:border-nexus-gold transition-all group glass-card-hover border-l-4 border-l-nexus-gold">
						<div class="w-16 h-16 rounded-2xl bg-nexus-gold/10 flex items-center justify-center text-nexus-gold mb-6 group-hover:scale-110 transition-transform">
							<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
						</div>
						<h3 class="text-xl font-bold text-white">Grant Writer Pro</h3>
						<p class="text-sm text-gray-500 mt-2">Specialized in winning high-value federal and private grants.</p>
						<button class="nexus-marketplace-install w-full mt-8 bg-nexus-gold/20 hover:bg-nexus-gold text-nexus-gold hover:text-black font-bold py-3 rounded-xl transition-all" data-agent="grant_writer">Install Role</button>
						<span class="nexus-button-note">Expect: Expert persona added to your workforce.</span>
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
		<div class="nexus-admin-body p-10 theme-settings">
			<div class="mb-10">
				<h2 class="text-sm font-semibold text-accent uppercase tracking-widest mb-2">Infrastructure</h2>
				<h1 class="text-4xl font-bold text-white">System Configuration</h1>
				<p class="text-gray-400 mt-2 max-w-2xl">Manage the core engines and branding of your AI platform.</p>
			</div>

			<div class="nexus-step-guide">
				<div class="grid grid-cols-1 md:grid-cols-2 gap-10">
					<div class="text-xs text-gray-400">
						<p class="font-bold text-white mb-1">Configuration Note:</p>
						<p>API keys are <span class="text-accent font-bold">AES-256 Encrypted</span> and stored securely. We never store keys in plain text.</p>
					</div>
					<div class="text-xs text-gray-400">
						<p class="font-bold text-white mb-1">White Labeling:</p>
						<p>Changing the color and logo will update the entire platform UI for all users.</p>
					</div>
				</div>
			</div>

			<div class="max-w-6xl grid grid-cols-1 md:grid-cols-2 gap-10">
				<div class="glass-panel p-8 rounded-2xl border border-nexus-border">
					<h2 class="text-xl font-semibold mb-6 text-accent">Global AI Engines</h2>
					<form id="nexus-settings-form" class="space-y-6">
						<div>
							<label class="block text-sm font-medium text-gray-400 mb-2">OpenAI API Key</label>
							<input type="password" name="openai_api_key" class="w-full bg-nexus-elevated border border-nexus-border rounded-lg p-3 text-white focus:border-accent outline-none" placeholder="sk-...">
						</div>
						<div>
							<label class="block text-sm font-medium text-gray-400 mb-2">Anthropic API Key</label>
							<input type="password" name="claude_api_key" class="w-full bg-nexus-elevated border border-nexus-border rounded-lg p-3 text-white focus:border-accent outline-none" placeholder="sk-ant-...">
						</div>
						<div>
							<label class="block text-sm font-medium text-gray-400 mb-2">Google Gemini API Key</label>
							<input type="password" name="gemini_api_key" class="w-full bg-nexus-elevated border border-nexus-border rounded-lg p-3 text-white focus:border-accent outline-none" placeholder="AIza...">
						</div>
						<div>
							<label class="block text-sm font-medium text-gray-400 mb-2">OpenRouter API Key</label>
							<input type="password" name="openrouter_api_key" class="w-full bg-nexus-elevated border border-nexus-border rounded-lg p-3 text-white focus:border-accent outline-none" placeholder="sk-or-...">
						</div>
						<div class="grid grid-cols-2 gap-4">
							<div>
								<label class="block text-sm font-medium text-gray-400 mb-2">DeepSeek Key</label>
								<input type="password" name="deepseek_api_key" class="w-full bg-nexus-elevated border border-nexus-border rounded-lg p-3 text-white focus:border-accent outline-none" placeholder="sk-...">
							</div>
							<div>
								<label class="block text-sm font-medium text-gray-400 mb-2">Mistral Key</label>
								<input type="password" name="mistral_api_key" class="w-full bg-nexus-elevated border border-nexus-border rounded-lg p-3 text-white focus:border-accent outline-none" placeholder="sk-...">
							</div>
						</div>
						<div>
							<label class="block text-sm font-medium text-gray-400 mb-2">Global Default Model</label>
							<select name="default_model" class="w-full bg-nexus-elevated border border-nexus-border rounded-lg p-3 text-white outline-none focus:border-accent">
								<optgroup label="High Reasoning">
									<option value="gpt-4o">OpenAI GPT-4o (Standard)</option>
									<option value="claude-3-5-sonnet-20240620">Anthropic Claude 3.5 Sonnet</option>
									<option value="gemini-1.5-pro">Google Gemini 1.5 Pro</option>
								</optgroup>
								<optgroup label="High Volume / Fast">
									<option value="gpt-4o-mini">OpenAI GPT-4o Mini</option>
									<option value="gemini-1.5-flash">Google Gemini 1.5 Flash</option>
								</optgroup>
								<optgroup label="OpenRouter / Open Source">
									<option value="meta-llama/llama-3.1-405b-instruct">Llama 3.1 405B (via OpenRouter)</option>
									<option value="mistralai/mistral-large">Mistral Large</option>
									<option value="x-ai/grok-1">xAI Grok-1</option>
								</optgroup>
							</select>
						</div>
						<button type="submit" class="w-full bg-accent text-white font-bold py-4 rounded-xl transition-all shadow-lg shadow-accent/10 nexus-btn-vibrant">Save Infrastructure</button>
						<button type="button" id="nexus-test-connectivity" class="w-full mt-2 bg-white/5 border border-white/10 text-white py-2 rounded-lg text-xs hover:bg-white/10 transition-all">Run Global Connectivity Test</button>
						<span class="nexus-button-note text-center">Expect: Secure AES-256 encryption of all keys before storage.</span>
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
							<input type="color" name="ui_color" class="w-20 h-12 bg-nexus-elevated border border-nexus-border rounded-lg p-1 text-white cursor-pointer" value="#7C3AED">
						</div>
						<div>
							<label class="block text-sm font-medium text-gray-400 mb-2">Platform Display Title</label>
							<input type="text" name="platform_title" class="w-full bg-nexus-elevated border border-nexus-border rounded-lg p-3 text-white" placeholder="Nexus AI Workforce">
						</div>
						<div class="p-6 rounded-2xl bg-nexus-elevated border border-nexus-border">
							<p class="text-sm font-bold text-white mb-2 uppercase">Agency Mode</p>
							<div class="flex items-center gap-4">
								<input type="checkbox" name="agency_mode" class="w-5 h-5 rounded border-gray-600 bg-gray-700 text-accent">
								<p class="text-xs text-gray-500">Hide "Nexus AI" branding and use "Platform Display Title" throughout the UI.</p>
							</div>
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
		<div class="nexus-admin-body p-10 theme-kb">
			<div class="mb-10 flex justify-between items-end">
				<div>
					<h2 class="text-sm font-semibold text-accent uppercase tracking-widest mb-2">Intelligence</h2>
					<h1 class="text-4xl font-bold text-white">Company Brain (RAG)</h1>
					<p class="text-gray-400 mt-2 max-w-2xl">Give your AI workforce "Company Memory." Upload your unique business data to ground agent responses.</p>
				</div>
				<button id="nexus-wipe-memory" class="bg-red-500/10 hover:bg-red-500 text-red-500 hover:text-white px-6 py-2 rounded-xl text-xs font-bold transition-all border border-red-500/20">Wipe All Memory</button>
			</div>

			<div class="nexus-step-guide">
				<div class="grid grid-cols-1 md:grid-cols-3 gap-10">
					<div class="text-xs text-gray-400">
						<p class="font-bold text-white mb-1">Upload SOPs</p>
						<p>Add PDFs or Word docs of your standard operating procedures for agents to follow.</p>
					</div>
					<div class="text-xs text-gray-400">
						<p class="font-bold text-white mb-1">Scrape Competition</p>
						<p>Add competitor URLs to the index so agents can perform market analysis.</p>
					</div>
					<div class="text-xs text-gray-400">
						<p class="font-bold text-white mb-1">Global Access</p>
						<p>Every agent in your workforce can instantly recall data stored in the Company Brain.</p>
					</div>
				</div>
			</div>

			<div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
				<div class="glass-panel p-8 rounded-2xl border border-nexus-border dept-tech">
					<h2 class="text-xl font-semibold mb-6">Ingest Data</h2>
					<div class="space-y-8">
						<div id="nexus-kb-upload-zone" class="border-2 border-dashed border-accent/20 rounded-2xl p-10 text-center hover:border-accent transition-all bg-accent/5 group cursor-pointer relative">
							<input type="file" id="nexus-kb-file-input" class="absolute inset-0 opacity-0 cursor-pointer" accept=".pdf,.docx,.txt,.md">
							<div id="nexus-upload-idle">
								<p class="text-sm text-gray-300 font-medium">Click or Drag PDF, DOCX, or TXT here</p>
								<button class="mt-6 bg-nexus-elevated border border-nexus-border text-white px-8 py-3 rounded-xl text-sm font-bold hover:border-accent transition-all">Select Files</button>
							</div>
							<div id="nexus-upload-progress" class="hidden">
								<div class="w-12 h-12 border-4 border-accent border-t-transparent rounded-full animate-spin mx-auto mb-4"></div>
								<p class="text-accent font-bold">Ingesting Knowledge...</p>
							</div>
							<span class="nexus-button-note">Expect: Automatic chunking and semantic indexing into Company Memory.</span>
						</div>
						<div>
							<label class="block text-sm font-medium text-gray-400 mb-2">Web Scraper</label>
							<div class="flex gap-2">
								<input type="url" class="flex-1 bg-nexus-elevated border border-nexus-border rounded-xl p-4 text-white outline-none focus:border-accent" placeholder="https://...">
								<button class="bg-accent text-white px-8 py-2 rounded-xl font-bold hover:bg-blue-600 transition-all">Index</button>
							</div>
							<span class="nexus-button-note">Expect: Recursive crawling of the provided URL.</span>
						</div>
					</div>
				</div>

				<div class="glass-panel p-8 rounded-2xl border border-nexus-border">
					<h2 class="text-xl font-semibold mb-6">Document Library</h2>
					<?php
					global $wpdb;
					$docs = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}ai_knowledge_documents ORDER BY created_at DESC", ARRAY_A ) ?: [];
					?>
					<div class="overflow-x-auto">
						<table class="w-full text-left text-sm text-gray-400">
							<thead class="text-xs uppercase text-gray-500 border-b border-nexus-border">
								<tr>
									<th class="pb-3 px-2">Type</th>
									<th class="pb-3 px-2">Source</th>
									<th class="pb-3 px-2">Status</th>
									<th class="pb-3 px-2">Created</th>
								</tr>
							</thead>
							<tbody class="divide-y divide-nexus-border/50">
								<?php foreach ( $docs as $doc ) : ?>
									<tr>
										<td class="py-4 px-2 uppercase text-[10px] font-bold"><?php echo esc_html( $doc['type'] ); ?></td>
										<td class="py-4 px-2 truncate max-w-[150px]"><?php echo esc_html( basename($doc['source_path']) ); ?></td>
										<td class="py-4 px-2">
											<span class="px-2 py-1 rounded-full bg-green-500/10 text-green-500 text-[10px] font-bold uppercase">
												<?php echo esc_html( $doc['status'] ); ?>
											</span>
										</td>
										<td class="py-4 px-2 text-[10px]"><?php echo esc_html( $doc['created_at'] ); ?></td>
									</tr>
								<?php endforeach; ?>
								<?php if ( empty( $docs ) ) : ?>
									<tr><td colspan="4" class="py-8 text-center italic opacity-50">No documents indexed yet.</td></tr>
								<?php endif; ?>
							</tbody>
						</table>
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
		$workflows = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}ai_workflows WHERE is_active = 1", ARRAY_A ) ?: [];
		?>
		<div class="nexus-admin-body p-10 theme-automations">
			<div class="mb-10">
				<h2 class="text-sm font-semibold text-accent uppercase tracking-widest mb-2">Workflow Engineering</h2>
				<h1 class="text-4xl font-bold text-white">Multi-Agent Automations</h1>
				<p class="text-gray-400 mt-2 max-w-2xl">Create logical chains where agents collaborate to achieve complex business objectives.</p>
			</div>

			<div class="nexus-step-guide">
				<div class="grid grid-cols-1 md:grid-cols-2 gap-10">
					<div class="text-xs text-gray-400 flex gap-3">
						<div class="w-8 h-8 rounded-full bg-accent/20 flex items-center justify-center text-accent shrink-0">1</div>
						<p>Open the <span class="text-accent font-bold">Visual Builder</span> and drag agents from the pool into the sequence canvas.</p>
					</div>
					<div class="text-xs text-gray-400 flex gap-3">
						<div class="w-8 h-8 rounded-full bg-accent/20 flex items-center justify-center text-accent shrink-0">2</div>
						<p>Define the <span class="text-accent font-bold">Task</span> for each agent. Previous outputs are automatically shared with the next agent.</p>
					</div>
				</div>
			</div>

			<div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
				<div class="lg:col-span-1 space-y-6">
					<h2 class="text-xl font-semibold mb-6">Active Workflows</h2>
					<div id="nexus-active-workflows" class="space-y-4">
						<?php foreach ( $workflows as $wf ) : ?>
							<div class="glass-panel p-6 rounded-2xl border border-nexus-border hover:border-accent cursor-pointer transition-all glass-card-hover border-l-4 border-l-accent group nexus-run-workflow" data-id="<?php echo (int) $wf['id']; ?>">
								<div class="flex justify-between items-start">
									<h3 class="font-bold text-white group-hover:text-accent"><?php echo esc_html( $wf['name'] ); ?></h3>
									<button class="bg-accent/20 text-accent text-[10px] font-bold px-2 py-1 rounded">RUN</button>
								</div>
								<p class="text-xs text-gray-500 mt-2 uppercase tracking-tighter">Chain: <?php
									$steps = json_decode($wf['definition'], true);
									echo count($steps);
								?> Specialized Agents</p>
							</div>
						<?php endforeach; ?>
						<?php if ( empty( $workflows ) ) : ?>
							<p class="text-xs text-gray-500 italic">No custom workflows saved yet.</p>
						<?php endif; ?>
					</div>

					<h2 class="text-xl font-semibold mb-6 mt-12">Workflow Templates</h2>
					<div class="glass-panel p-6 rounded-2xl border border-nexus-border hover:border-accent cursor-pointer transition-all glass-card-hover border-l-4 border-l-accent group">
						<h3 class="font-bold text-white group-hover:text-accent">Content Machine</h3>
						<p class="text-xs text-gray-500 mt-1">SEO Research -> Copy -> Publish</p>
					</div>
				</div>

				<div class="lg:col-span-2">
					<div class="glass-panel p-8 rounded-3xl border border-nexus-border min-h-[500px] flex flex-col items-center justify-center text-center bg-accent/5">
						<h2 class="text-3xl font-bold mb-4 text-white uppercase tracking-tighter">Workflow Canvas</h2>
						<button id="nexus-open-visual-builder" class="bg-accent hover:opacity-90 text-white font-bold py-4 px-12 rounded-xl transition-all shadow-lg shadow-accent/20">Open Visual Builder</button>
						<span class="nexus-button-note mt-4">Expect: Fullscreen drag-and-drop orchestration environment.</span>
					</div>
				</div>
			</div>

			<!-- Workflow Results Modal -->
			<div id="nexus-workflow-results-modal" class="fixed inset-0 z-[10000] hidden">
				<div class="absolute inset-0 bg-black/90 backdrop-blur-md"></div>
				<div class="absolute inset-x-10 top-20 bottom-20 glass-panel rounded-3xl border border-nexus-border flex flex-col overflow-hidden shadow-2xl">
					<div class="p-8 border-b border-nexus-border flex justify-between items-center bg-nexus-elevated/50">
						<div>
							<h2 class="text-2xl font-bold text-white uppercase tracking-tighter">Workflow Execution Trace</h2>
							<p class="text-xs text-gray-500 mt-1">Real-time status of multi-agent collaboration</p>
						</div>
						<button id="nexus-close-results" class="text-gray-400 hover:text-white bg-white/5 px-4 py-2 rounded-xl">Close Trace</button>
					</div>
					<div id="nexus-workflow-log" class="flex-1 p-10 overflow-y-auto space-y-6 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')]">
						<!-- Log entries will appear here -->
					</div>
				</div>
			</div>

			<!-- Visual Builder Modal -->
			<div id="nexus-visual-builder-modal" class="fixed inset-0 z-[9999] hidden">
				<div class="absolute inset-0 bg-black/95 backdrop-blur-xl"></div>
				<div class="absolute inset-8 glass-panel rounded-3xl border border-nexus-border flex overflow-hidden shadow-2xl">
					<div class="w-80 border-r border-nexus-border bg-nexus-surface flex flex-col p-8">
						<h3 class="font-bold text-xl text-white mb-6 uppercase tracking-widest text-xs opacity-50">Agent Pool</h3>
						<div class="flex-1 overflow-y-auto space-y-4">
							<?php foreach ( $agents as $agent ) : ?>
								<div class="nexus-draggable-agent p-4 rounded-xl bg-nexus-elevated border border-nexus-border cursor-grab active:cursor-grabbing hover:border-accent transition-all group" draggable="true" data-id="<?php echo (int) $agent['id']; ?>">
									<p class="font-bold text-sm text-white group-hover:text-accent"><?php echo esc_html( $agent['name'] ); ?></p>
									<p class="text-[10px] text-gray-500 uppercase mt-1"><?php echo esc_html( $agent['position'] ); ?></p>
								</div>
							<?php endforeach; ?>
						</div>
					</div>
					<div class="flex-1 bg-nexus-bg p-12 flex flex-col bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')]">
						<div class="flex justify-between items-center mb-12">
							<div>
								<h2 class="text-3xl font-bold text-white uppercase tracking-tighter">Strategic Canvas</h2>
								<p class="text-xs text-gray-500 mt-1">Establish the execution sequence for your AI workforce.</p>
							</div>
							<div class="flex gap-4">
								<button id="nexus-save-workflow-btn" class="bg-accent text-white px-8 py-3 rounded-xl font-bold hover:opacity-90 transition-all nexus-btn-vibrant">Save Workflow</button>
								<button id="nexus-close-builder" class="text-gray-400 hover:text-white bg-nexus-elevated px-4 rounded-xl">✕</button>
							</div>
						</div>
						<div id="nexus-workflow-canvas" class="flex-1 border-4 border-dashed border-nexus-border rounded-3xl flex items-center justify-center relative bg-black/20">
							<div class="text-center">
								<p class="text-gray-500 font-bold uppercase tracking-widest text-sm">Drop Agents Here to Initialize Sequence</p>
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
		<div class="nexus-admin-body p-10 theme-meetings">
			<div class="mb-10 flex justify-between items-end">
				<div>
					<h2 class="text-sm font-semibold text-accent uppercase tracking-widest mb-2">Intelligence</h2>
					<h1 class="text-4xl font-bold text-white">Collaboration Hub</h1>
					<p class="text-gray-400 mt-2 max-w-2xl">Start virtual meetings. Gather your AI executives to brainstorm and reach a consensus.</p>
				</div>
				<div class="text-right">
					<button id="nexus-start-meeting-btn" class="bg-accent hover:opacity-90 text-white font-bold py-4 px-10 rounded-xl transition-all shadow-lg shadow-accent/20 nexus-btn-vibrant">
						Start Strategic Meeting
					</button>
					<span class="nexus-button-note mt-2">Expect: Iterative consensus loop between invited agents.</span>
				</div>
			</div>

			<div class="grid grid-cols-1 lg:grid-cols-4 gap-10">
				<!-- Meeting Controls Sidebar -->
				<div class="lg:col-span-1 space-y-8">
					<div class="glass-panel p-6 rounded-2xl border border-nexus-border dept-exec">
						<h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-6">Invite Participants</h3>
						<div class="space-y-3">
							<?php foreach ( $agents as $agent ) : ?>
								<label class="flex items-center gap-3 p-4 rounded-xl bg-nexus-elevated border border-nexus-border hover:border-accent cursor-pointer transition-all group">
									<input type="checkbox" class="nexus-meeting-invitee w-5 h-5 rounded border-gray-600 bg-gray-700 text-accent focus:ring-accent" value="<?php echo (int) $agent['id']; ?>">
									<div>
										<p class="text-sm font-bold text-white group-hover:text-accent transition-colors"><?php echo esc_html( $agent['name'] ); ?></p>
										<p class="text-[10px] text-gray-500 uppercase"><?php echo esc_html( $agent['position'] ); ?></p>
									</div>
								</label>
							<?php endforeach; ?>
						</div>
					</div>

					<div class="glass-panel p-6 rounded-2xl border border-nexus-border">
						<h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Strategic Agenda</h3>
						<textarea id="nexus-meeting-agenda" class="w-full h-40 bg-nexus-elevated border border-nexus-border rounded-xl p-4 text-white text-sm outline-none focus:border-accent" placeholder="Enter objective..."></textarea>
					</div>
				</div>

				<!-- Live Transcription Area -->
				<div class="lg:col-span-3">
					<div id="nexus-meeting-room" class="glass-panel rounded-3xl border border-nexus-border min-h-[650px] flex flex-col overflow-hidden bg-black/40">
						<div class="p-6 border-b border-nexus-border bg-nexus-elevated/50 flex justify-between items-center">
							<div class="flex items-center gap-4">
								<div class="w-3 h-3 rounded-full bg-red-500 animate-pulse"></div>
								<h2 class="font-bold text-white uppercase tracking-widest text-xs">Live Transcription</h2>
							</div>
						</div>

						<div id="nexus-meeting-transcript" class="flex-1 p-10 space-y-8 overflow-y-auto max-h-[500px] bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')]">
							<div class="flex flex-col items-center justify-center h-full text-center text-gray-500">
								<p>Awaiting Session Initialization.</p>
							</div>
						</div>

						<div class="p-8 bg-nexus-elevated/50 border-t border-nexus-border flex gap-4">
							<input type="text" id="nexus-meeting-input" class="flex-1 bg-nexus-elevated border border-nexus-border rounded-xl p-5 text-white outline-none focus:border-accent" placeholder="Chairman Instruction...">
							<button id="nexus-send-meeting-msg" class="bg-accent hover:opacity-90 text-white font-bold px-10 rounded-xl transition-all shadow-lg shadow-accent/20">Send</button>
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
	 * Render the Billing & Plans page.
	 */
	public function render_billing_page(): void {
		echo $this->get_brand_styles();
		?>
		<div class="nexus-admin-body p-10 theme-settings">
			<div class="mb-10">
				<h2 class="text-sm font-semibold text-accent uppercase tracking-widest mb-2">Commerce</h2>
				<h1 class="text-4xl font-bold text-white">Plans & Subscriptions</h1>
				<p class="text-gray-400 mt-2 max-w-2xl">Scale your AI workforce with premium enterprise plans. Manage your subscription, usage limits, and billing history.</p>
			</div>

			<div class="grid grid-cols-1 md:grid-cols-4 gap-8">
				<!-- Starter -->
				<div class="glass-panel p-8 rounded-3xl border border-nexus-border flex flex-col h-full">
					<h3 class="text-xl font-bold text-white mb-2">Starter</h3>
					<p class="text-3xl font-black text-white mb-6">$197<span class="text-sm text-gray-500 font-normal">/mo</span></p>
					<ul class="space-y-4 text-sm text-gray-400 mb-10 flex-1">
						<li class="flex items-center gap-2"><svg class="w-4 h-4 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> 3 AI Agents</li>
						<li class="flex items-center gap-2"><svg class="w-4 h-4 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> Basic Company Brain</li>
						<li class="flex items-center gap-2"><svg class="w-4 h-4 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> Standard Support</li>
					</ul>
					<button class="w-full bg-white/5 border border-white/10 text-white font-bold py-3 rounded-xl hover:bg-white/10 transition-all">Current Plan</button>
				</div>

				<!-- Pro -->
				<div class="glass-panel p-8 rounded-3xl border-2 border-accent flex flex-col h-full relative overflow-hidden">
					<div class="absolute top-0 right-0 bg-accent text-white text-[10px] font-bold px-4 py-1 rounded-bl-xl uppercase">Most Popular</div>
					<h3 class="text-xl font-bold text-white mb-2">Professional</h3>
					<p class="text-3xl font-black text-white mb-6">$497<span class="text-sm text-gray-500 font-normal">/mo</span></p>
					<ul class="space-y-4 text-sm text-gray-400 mb-10 flex-1">
						<li class="flex items-center gap-2"><svg class="w-4 h-4 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> 15 AI Agents</li>
						<li class="flex items-center gap-2"><svg class="w-4 h-4 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> Advanced RAG Engine</li>
						<li class="flex items-center gap-2"><svg class="w-4 h-4 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> Multi-Agent Workflows</li>
						<li class="flex items-center gap-2"><svg class="w-4 h-4 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> Priority API Access</li>
					</ul>
					<button class="w-full bg-accent text-white font-bold py-3 rounded-xl hover:opacity-90 transition-all nexus-btn-vibrant">Upgrade to Pro</button>
				</div>

				<!-- Agency -->
				<div class="glass-panel p-8 rounded-3xl border border-nexus-border flex flex-col h-full">
					<h3 class="text-xl font-bold text-white mb-2">Agency</h3>
					<p class="text-3xl font-black text-white mb-6">$997<span class="text-sm text-gray-500 font-normal">/mo</span></p>
					<ul class="space-y-4 text-sm text-gray-400 mb-10 flex-1">
						<li class="flex items-center gap-2"><svg class="w-4 h-4 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> Unlimited Agents</li>
						<li class="flex items-center gap-2"><svg class="w-4 h-4 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> White Labeling</li>
						<li class="flex items-center gap-2"><svg class="w-4 h-4 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> Client Portals</li>
						<li class="flex items-center gap-2"><svg class="w-4 h-4 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> 24/7 Dedicated Support</li>
					</ul>
					<button class="w-full bg-white/5 border border-white/10 text-white font-bold py-3 rounded-xl hover:bg-white/10 transition-all">Select Plan</button>
				</div>

				<!-- Enterprise -->
				<div class="glass-panel p-8 rounded-3xl border border-nexus-border flex flex-col h-full bg-nexus-violet/5">
					<h3 class="text-xl font-bold text-white mb-2">Enterprise</h3>
					<p class="text-3xl font-black text-white mb-6 italic">Custom</p>
					<ul class="space-y-4 text-sm text-gray-400 mb-10 flex-1">
						<li class="flex items-center gap-2"><svg class="w-4 h-4 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> Local Ollama Hosting</li>
						<li class="flex items-center gap-2"><svg class="w-4 h-4 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> Custom SLA</li>
						<li class="flex items-center gap-2"><svg class="w-4 h-4 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> On-Premise Training</li>
					</ul>
					<button class="w-full bg-nexus-blue text-white font-bold py-3 rounded-xl hover:opacity-90 transition-all">Contact Sales</button>
				</div>
			</div>
		</div>
		<?php
	}

	public function render_tutorials_page(): void {
		$level = $_GET['level'] ?? 'employee';
		echo $this->get_brand_styles();
		?>
		<div class="nexus-admin-body p-10 theme-learning">
			<div class="mb-10">
				<h2 class="text-sm font-semibold text-accent uppercase tracking-widest mb-2">Education</h2>
				<h1 class="text-4xl font-bold text-white">Platform Learning Center</h1>
				<p class="text-gray-400 mt-2 max-w-2xl">Master the AI Workforce platform with specialized lessons.</p>
			</div>

			<div class="grid grid-cols-1 md:grid-cols-3 gap-10">
				<!-- Lesson 1 -->
				<div class="glass-panel p-8 rounded-3xl border border-nexus-border hover:border-accent transition-all glass-card-hover group">
					<h3 class="text-xl font-bold mb-4 text-white group-hover:text-accent transition-colors">The Core Blueprint</h3>
					<div class="space-y-4 text-sm text-gray-400 leading-relaxed mb-8">
						<p><span class="text-accent font-bold">Objective:</span> Master AI Persona crafting.</p>
						<p>AI performance is 90% determined by the <span class="text-white font-bold">Identity</span> field. Learn how to define boundaries and KPIs for your agents.</p>
						<ul class="list-disc list-inside space-y-2 text-xs">
							<li>Avoid vague instructions.</li>
							<li>Always provide a specific output format.</li>
							<li>Use Negative Constraints (e.g. "Never mention competitors").</li>
						</ul>
					</div>
					<button class="w-full bg-accent/20 text-accent font-bold py-3 rounded-xl hover:bg-accent hover:text-white transition-all">Complete Lesson ✓</button>
				</div>

				<!-- Lesson 2 -->
				<div class="glass-panel p-8 rounded-3xl border border-nexus-border hover:border-accent transition-all glass-card-hover group">
					<h3 class="text-xl font-bold mb-4 text-white group-hover:text-accent transition-colors">Scaling ROI</h3>
					<div class="space-y-4 text-sm text-gray-400 leading-relaxed mb-8">
						<p><span class="text-accent font-bold">Objective:</span> Build AI departments.</p>
						<p>Scale your business by creating <span class="text-white font-bold">Multi-Agent Departments</span>. Learn to chain a researcher, copywriter, and publisher into a single workflow.</p>
						<ul class="list-disc list-inside space-y-2 text-xs">
							<li>Assign 1 goal per agent.</li>
							<li>Verify outputs between steps.</li>
							<li>Use "Agency Mode" for client resale.</li>
						</ul>
					</div>
					<button class="w-full bg-accent/20 text-accent font-bold py-3 rounded-xl hover:bg-accent hover:text-white transition-all">Complete Lesson ✓</button>
				</div>

				<!-- Lesson 3 -->
				<div class="glass-panel p-8 rounded-3xl border border-nexus-border hover:border-accent transition-all glass-card-hover group">
					<h3 class="text-xl font-bold mb-4 text-white group-hover:text-accent transition-colors">Security & RBAC</h3>
					<div class="space-y-4 text-sm text-gray-400 leading-relaxed mb-8">
						<p><span class="text-accent font-bold">Objective:</span> Secure your infrastructure.</p>
						<p>Learn how to manage <span class="text-white font-bold">Permissions</span> and protect your API tokens in an enterprise environment.</p>
						<ul class="list-disc list-inside space-y-2 text-xs">
							<li>Use Role-Based Access Controls.</li>
							<li>Monitor token usage per department.</li>
							<li>Set monthly cost ceilings.</li>
						</ul>
					</div>
					<button class="w-full bg-accent/20 text-accent font-bold py-3 rounded-xl hover:bg-accent hover:text-white transition-all">Complete Lesson ✓</button>
				</div>

				<!-- Lesson 4 -->
				<div class="glass-panel p-8 rounded-3xl border border-nexus-border hover:border-accent transition-all glass-card-hover group">
					<h3 class="text-xl font-bold mb-4 text-white group-hover:text-accent transition-colors">AI Collaboration</h3>
					<div class="space-y-4 text-sm text-gray-400 leading-relaxed mb-8">
						<p><span class="text-accent font-bold">Objective:</span> Master AI Meetings.</p>
						<p>Learn to run <span class="text-white font-bold">Consensus Meetings</span>. Gather multiple experts to debate a topic until a decision is reached.</p>
						<ul class="list-disc list-inside space-y-2 text-xs">
							<li>Invite relevant experts only.</li>
							<li>Define a clear agenda.</li>
							<li>Watch the real-time reasoning flow.</li>
						</ul>
					</div>
					<button class="w-full bg-accent/20 text-accent font-bold py-3 rounded-xl hover:bg-accent hover:text-white transition-all">Complete Lesson ✓</button>
				</div>

				<!-- Lesson 5 -->
				<div class="glass-panel p-8 rounded-3xl border border-nexus-border hover:border-accent transition-all glass-card-hover group">
					<h3 class="text-xl font-bold mb-4 text-white group-hover:text-accent transition-colors">Strategic Automations</h3>
					<div class="space-y-4 text-sm text-gray-400 leading-relaxed mb-8">
						<p><span class="text-accent font-bold">Objective:</span> Multi-Agent Workflows.</p>
						<p>Establish high-value <span class="text-white font-bold">Automated Chains</span>. Pass data seamlessly between agents to complete complex sequences.</p>
						<ul class="list-disc list-inside space-y-2 text-xs">
							<li>Design linear sequences.</li>
							<li>Use "Context Sharing" between steps.</li>
							<li>Trigger workflows via webhooks.</li>
						</ul>
					</div>
					<button class="w-full bg-accent/20 text-accent font-bold py-3 rounded-xl hover:bg-accent hover:text-white transition-all">Complete Lesson ✓</button>
				</div>
			</div>
		</div>
		<?php
	}
}
