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
                copywriter: { position: 'Copywriter', identity: 'I am a master of words and consumer psychology.', mission: 'Craft high-conversion direct response copy.', temp: 0.9 }
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

            // Align with backend controller expectations
            const payload = {
                name: rawData.name,
                position: rawData.position,
                role_description: rawData.identity,
                prompt_template: rawData.mission,
                model_settings: {
                    model: rawData.model,
                    temperature: parseFloat(rawData.temperature),
                    provider: 'openai' // Default or based on model
                }
            };

            nexusFetch('employees', 'POST', payload).then(res => {
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

    // 5. AI Meeting Collaboration Hub
    const startMeetingBtn = document.getElementById('nexus-start-meeting-btn');
    const meetingTranscript = document.getElementById('nexus-meeting-transcript');
    const meetingInput = document.getElementById('nexus-meeting-input');
    const sendMeetingBtn = document.getElementById('nexus-send-meeting-msg');

    if (startMeetingBtn) {
        startMeetingBtn.addEventListener('click', function() {
            const invitees = Array.from(document.querySelectorAll('.nexus-meeting-invitee:checked')).map(cb => cb.value);
            const agenda = document.getElementById('nexus-meeting-agenda').value;

            if (invitees.length === 0) return alert('Invite at least one AI participant.');
            if (!agenda) return alert('Please define an agenda for the meeting.');

            startMeetingBtn.innerText = 'Collaborating...';
            meetingTranscript.innerHTML = `<div class="p-4 rounded-xl bg-nexus-violet/10 border border-nexus-violet/20 italic text-nexus-violet">Meeting initialized. Agenda: ${agenda}</div>`;

            // Start the recursive multi-agent chain via REST
            runMeetingRound(invitees, agenda);
        });
    }

    function runMeetingRound(invitees, agenda, round = 1) {
        if (round > 5) { // Cap for MVP safety
            meetingTranscript.innerHTML += `<div class="p-4 rounded-xl bg-green-500/10 border border-green-500/20 italic text-green-500">Meeting concluded. Consensus reached.</div>`;
            startMeetingBtn.innerText = 'Start New Meeting';
            return;
        }

        const nextAgentId = invitees[(round - 1) % invitees.length];

        nexusFetch(`chat/meeting`, 'POST', {
            agent_id: nextAgentId,
            agenda: agenda,
            round: round,
            invitees: invitees
        }).then(res => {
            const entry = document.createElement('div');
            entry.className = 'flex gap-4 items-start animate-fade-in-up';
            entry.innerHTML = `
                <div class="w-10 h-10 rounded-full bg-nexus-violet flex items-center justify-center font-bold text-white shrink-0">
                    ${res.agent_name.charAt(0)}
                </div>
                <div class="flex-1">
                    <p class="font-bold text-white mb-1">${res.agent_name} <span class="text-xs text-gray-500 font-normal ml-2">${res.position}</span></p>
                    <div class="p-4 rounded-2xl bg-nexus-elevated border border-nexus-border text-gray-300 text-sm leading-relaxed">
                        ${res.content}
                    </div>
                </div>
            `;
            meetingTranscript.appendChild(entry);
            meetingTranscript.scrollTop = meetingTranscript.scrollHeight;

            // Chain to next agent after a short "thinking" delay
            setTimeout(() => runMeetingRound(invitees, agenda, round + 1), 2000);
        });
    }

    // 6. Marketplace Tabs & Install
    const tabButtons = document.querySelectorAll('.nexus-tab-btn');
    const tabContents = document.querySelectorAll('.nexus-tab-content');

    tabButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            const target = btn.dataset.tab;

            tabButtons.forEach(b => b.classList.remove('bg-nexus-violet', 'text-white'));
            tabButtons.forEach(b => b.classList.add('text-gray-400'));
            btn.classList.remove('text-gray-400');
            btn.classList.add('bg-nexus-violet', 'text-white');

            tabContents.forEach(content => {
                if (content.id === `nexus-${target}-tab`) {
                    content.classList.remove('hidden');
                } else {
                    content.classList.add('hidden');
                }
            });
        });
    });

    const installButtons = document.querySelectorAll('.nexus-marketplace-install');
    installButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            const agentKey = btn.dataset.agent;
            btn.innerText = 'Installing...';

            nexusFetch('marketplace/import', 'POST', { agent_key: agentKey }).then(res => {
                btn.innerText = 'Installed ✓';
                btn.classList.replace('bg-nexus-gold/20', 'bg-green-500/20');
                btn.classList.replace('text-nexus-gold', 'text-green-500');
            });
        });
    });
});
