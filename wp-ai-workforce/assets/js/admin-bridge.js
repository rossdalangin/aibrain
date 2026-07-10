/**
 * Nexus AI Admin Bridge
 * Handles AJAX communications for PHP-rendered forms.
 */
document.addEventListener('DOMContentLoaded', function() {

    // 0. Agent Template Selection
    const templateSelector = document.getElementById('nexus-agent-template-selector');
    if (templateSelector) {
        templateSelector.addEventListener('change', function() {
            const role = templateSelector.value;
            const hireForm = document.getElementById('nexus-hire-agent-form');
            if (!role || !hireForm) return;

            const templates = {
                ceo: { position: 'Chief Executive Officer', identity: 'I am a visionary enterprise leader focused on high-level strategy and ROI.', mission: 'Synthesize data into clear action plans.', temp: 0.4 },
                cmo: { position: 'Chief Marketing Officer', identity: 'I am a data-driven growth architect specializing in high-conversion funnels.', mission: 'Maximize CPA and brand narrative consistency.', temp: 0.8 },
                cto: { position: 'Chief Technology Officer', identity: 'I am a systems architect and security expert ensuring technical scalability.', mission: 'Optimize performance and minimize technical debt.', temp: 0.2 },
                cfo: { position: 'Chief Financial Officer', identity: 'I am a financial strategist focused on capital allocation and risk management.', mission: 'Maximize long-term growth through rigorous audit.', temp: 0.1 },
                seo: { position: 'SEO Specialist', identity: 'I am a technical search architect living in the data of search trends.', mission: 'Dominate page one for primary business keywords.', temp: 0.3 },
                copywriter: { position: 'Copywriter', identity: 'I am a master of words and consumer psychology.', mission: 'Craft high-conversion direct response copy.', temp: 0.9 },
                hr: { position: 'HR Manager', identity: 'I am a culture-focused HR professional specializing in talent acquisition and employee retention.', mission: 'Build a high-performance team culture.', temp: 0.6 },
                legal: { position: 'Legal Advisor', identity: 'I am a meticulous legal expert specializing in corporate law and compliance.', mission: 'Mitigate risk and ensure regulatory adherence.', temp: 0.1 },
                qa: { position: 'QA Engineer', identity: 'I am a detail-oriented quality assurance specialist focused on bug-free deployments.', mission: 'Ensure 100% product stability and performance.', temp: 0.1 },
                ads: { position: 'Paid Ads Specialist', identity: 'I am an expert media buyer for Meta, Google, and LinkedIn.', mission: 'Optimize ad spend for maximum ROAS.', temp: 0.7 },
                data: { position: 'Data Analyst', identity: 'I am a statistical expert turning raw data into actionable business intelligence.', mission: 'Identify trends and growth opportunities through data.', temp: 0.2 },
                support: { position: 'Customer Support Manager', identity: 'I am a customer success expert dedicated to 100% satisfaction.', mission: 'Reduce churn and increase NPS.', temp: 0.5 },
                sales: { position: 'Sales Director', identity: 'I am a high-ticket sales closer and pipeline architect.', mission: 'Maximize revenue and shorten sales cycles.', temp: 0.8 }
            };

            const data = templates[role];
            hireForm.querySelector('[name="position"]').value = data.position;
            hireForm.querySelector('[name="identity"]').value = data.identity;
            hireForm.querySelector('[name="mission"]').value = data.mission;
            hireForm.querySelector('[name="temperature"]').value = data.temp;
        });
    }

    // 1. Hire Agent Form Submission
    const hireForm = document.getElementById('nexus-hire-agent-form');
    if (hireForm) {
        hireForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(hireForm);
            const rawData = Object.fromEntries(formData.entries());

            // Correct field mapping for backend
            const payload = {
                name: rawData.name,
                position: rawData.position,
                role_description: rawData.identity,
                prompt_template: rawData.mission,
                model_settings: {
                    model: rawData.model,
                    temperature: parseFloat(rawData.temperature),
                    provider: 'openai'
                }
            };

            nexusFetch('employees', 'POST', payload).then(res => {
                alert('Agent deployed successfully! This agent is now part of your virtual workforce.');
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

    // 4. Visual Workflow Builder
    const openBuilderBtn = document.getElementById('nexus-open-visual-builder');
    const closeBuilderBtn = document.getElementById('nexus-close-builder');
    const builderModal = document.getElementById('nexus-visual-builder-modal');
    const canvas = document.getElementById('nexus-workflow-canvas');

    if (openBuilderBtn) {
        openBuilderBtn.addEventListener('click', () => builderModal.classList.remove('hidden'));
    }
    if (closeBuilderBtn) {
        closeBuilderBtn.addEventListener('click', () => builderModal.classList.add('hidden'));
    }

    // Drag & Drop Logic
    const draggables = document.querySelectorAll('.nexus-draggable-agent');
    draggables.forEach(draggable => {
        draggable.addEventListener('dragstart', (e) => {
            e.dataTransfer.setData('agent_id', draggable.dataset.id);
            e.dataTransfer.setData('agent_name', draggable.querySelector('p').innerText);
        });
    });

    if (canvas) {
        canvas.addEventListener('dragover', (e) => e.preventDefault());
        canvas.addEventListener('drop', (e) => {
            e.preventDefault();
            const id = e.dataTransfer.getData('agent_id');
            const name = e.dataTransfer.getData('agent_name');

            // Create a step element on the canvas
            const step = document.createElement('div');
            step.className = 'p-6 rounded-2xl bg-nexus-surface border border-nexus-violet animate-fade-in-up mb-4 w-64 shadow-xl relative z-10';
            step.innerHTML = `<p class="text-nexus-violet font-bold">STEP ${canvas.children.length}</p>
                              <p class="text-white font-bold mt-1">${name}</p>
                              <input type="text" placeholder="Task description..." class="w-full bg-nexus-bg border border-nexus-border rounded mt-3 p-2 text-xs text-white">`;

            if (canvas.querySelector('.text-center')) {
                canvas.innerHTML = ''; // Clear placeholder
            }
            canvas.appendChild(step);
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
