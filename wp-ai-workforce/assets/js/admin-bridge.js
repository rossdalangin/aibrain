/**
 * Nexus AI Admin Bridge
 * Handles AJAX communications for PHP-rendered forms.
 */
document.addEventListener('DOMContentLoaded', function() {

    // 1. Hire Agent Form Submission
    const hireForm = document.getElementById('nexus-hire-agent-form');
    if (hireForm) {
        hireForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(hireForm);
            const data = Object.fromEntries(formData.entries());

            nexusFetch('employees', 'POST', data).then(res => {
                alert('Agent deployed successfully!');
                window.location.reload();
            });
        });
    }

    // 2. Settings Form Submission
    const settingsForm = document.getElementById('nexus-settings-form');
    if (settingsForm) {
        settingsForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(settingsForm);
            const data = Object.fromEntries(formData.entries());

            nexusFetch('settings', 'POST', data).then(res => {
                alert('Configuration saved.');
            });
        });
    }

    // 3. KB URL Ingestion
    const kbForm = document.querySelector('button[class*="bg-nexus-violet"]'); // Simple selector for MVP
    if (kbForm && kbForm.innerText === 'Index') {
        kbForm.addEventListener('click', function(e) {
            const urlInput = document.querySelector('input[type="url"]');
            if (urlInput && urlInput.value) {
                kbForm.innerText = 'Indexing...';
                nexusFetch('kb/ingest', 'POST', { url: urlInput.value }).then(res => {
                    kbForm.innerText = 'Index';
                    alert('URL content indexed into Company Brain!');
                    window.location.reload();
                });
            }
        });
    }

    /**
     * Helper to wrap WP REST API calls
     */
    async function nexusFetch(endpoint, method = 'GET', data = null) {
        const options = {
            method: method,
            headers: {
                'Content-Type': 'application/json',
                'X-WP-Nonce': nexus_ai_data.nonce
            }
        };
        if (data) options.body = JSON.stringify(data);

        const response = await fetch(`${nexus_ai_data.rest_url}nexus-ai/v1/${endpoint}`, options);
        return response.json();
    }
});
