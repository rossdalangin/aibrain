<?php
declare(strict_types=1);

namespace NexusAI\Workforce\UI;

/**
 * Renders the visible Admin UI forms and components.
 */
class AdminRenderer {

	/**
	 * Render the "Hire Agent" workforce management page.
	 */
	public function render_workforce_page(): void {
		?>
		<div class="nexus-admin-body p-8">
			<h1 class="text-3xl font-bold text-nexus-violet mb-8">Workforce Command</h1>

			<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
				<!-- Form Section -->
				<div class="glass-panel p-8 rounded-2xl border border-nexus-border">
					<h2 class="text-xl font-semibold mb-6">Hire New AI Agent</h2>
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
							<textarea name="role_description" rows="4" class="w-full bg-nexus-elevated border border-nexus-border rounded-lg p-3 text-white focus:ring-2 focus:ring-nexus-violet" placeholder="Describe the agent's core purpose..."></textarea>
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
		?>
		<div class="nexus-admin-body p-8">
			<h1 class="text-3xl font-bold text-nexus-violet mb-8">System Configuration</h1>

			<div class="max-w-2xl">
				<div class="glass-panel p-8 rounded-2xl border border-nexus-border">
					<h2 class="text-xl font-semibold mb-6">Global AI Settings</h2>
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
								<option value="gpt-4o">GPT-4o</option>
								<option value="gpt-4-turbo">GPT-4 Turbo</option>
							</select>
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
		?>
		<div class="nexus-admin-body p-8">
			<h1 class="text-3xl font-bold text-nexus-violet mb-8">Company Brain (Knowledge Base)</h1>

			<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
				<!-- Ingestion Section -->
				<div class="glass-panel p-8 rounded-2xl border border-nexus-border">
					<h2 class="text-xl font-semibold mb-6">Ingest Information</h2>

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
}
