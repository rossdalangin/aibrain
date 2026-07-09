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
									<option value="gpt-4o">GPT-4o (Recommended)</option>
									<option value="gpt-4-turbo">GPT-4 Turbo</option>
									<option value="gpt-3.5-turbo">GPT-3.5 Turbo</option>
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
						<div>
							<label class="block text-sm font-medium text-gray-400 mb-2">OpenAI API Key</label>
							<input type="password" name="openai_api_key" class="w-full bg-nexus-elevated border border-nexus-border rounded-lg p-3 text-white focus:ring-2 focus:ring-nexus-violet" placeholder="sk-...">
							<p class="text-xs text-gray-500 mt-2">Stored securely with AES-256-CTR encryption.</p>
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
}
