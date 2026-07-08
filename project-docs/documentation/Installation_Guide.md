# Nexus AI Workforce: Installation & Technical Setup

## 1. System Requirements
- WordPress 6.2+
- PHP 8.1+
- SQLite (recommended for local vector search) or MySQL 8.0+
- OpenSSL enabled (for secure encryption)

## 2. Installation
1. Upload the `wp-ai-workforce` folder to your `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Run `composer install` in the plugin directory to fetch enterprise parsers.
4. Run `npm install && npm run build` for the premium UI.

## 3. API Configuration
1. Go to **Nexus AI > Settings**.
2. Enter your **OpenAI API Key** (or preferred provider).
3. Click **Encrypt & Save**. Your keys are now securely stored using AES-256-CTR.

## 4. Troubleshooting
- **Memory Issues:** Increase your PHP memory limit to 512MB for document indexing.
- **API Timeouts:** Ensure your server allows outbound requests to `api.openai.com`.
- **UI Not Loading:** Check that `assets/js/admin.js` exists after running the build script.
