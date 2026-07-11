/**
 * Nexus AI Admin Bridge
 * Handles AJAX communications for PHP-rendered forms.
 */
document.addEventListener('DOMContentLoaded', function() {

    // --- 0. Core Helper ---
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

    // --- 1. Agent Template Selection ---
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

    // --- 2. Hire Agent Form ---
    const hireForm = document.getElementById('nexus-hire-agent-form');
    if (hireForm) {
        hireForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const btn = hireForm.querySelector('button[type="submit"]');
            btn.innerText = 'Initializing Persona...';
            btn.classList.add('opacity-50', 'pointer-events-none');

            const rawData = Object.fromEntries(new FormData(hireForm).entries());
            const payload = {
                name: rawData.name,
                position: rawData.position,
                role_description: rawData.identity,
                prompt_template: rawData.mission,
                model_settings: {
                    model: rawData.model,
                    temperature: parseFloat(rawData.temperature),
                    provider: 'openai',
                    personality: rawData.personality,
                    voice: rawData.voice
                }
            };
            nexusFetch('employees', 'POST', payload).then(() => {
                btn.innerText = 'Deployed ✓';
                alert('Agent deployed successfully!');
                window.location.reload();
            });
        });
    }

    // --- 3. Settings Form ---
    const settingsForm = document.getElementById('nexus-settings-form');
    if (settingsForm) {
        settingsForm.addEventListener('submit', function(e) {
            e.preventDefault();
            nexusFetch('settings', 'POST', Object.fromEntries(new FormData(settingsForm).entries())).then(() => {
                alert('Configuration saved.');
            });
        });
    }

    // --- 4. Knowledge Base ---
    const kbIndexBtn = document.getElementById('nexus-kb-index-btn');
    if (kbIndexBtn) {
        kbIndexBtn.addEventListener('click', function() {
            const urlInput = document.getElementById('nexus-kb-url-input');
            const target = document.getElementById('nexus-kb-target').value;
            if (urlInput && urlInput.value) {
                kbIndexBtn.innerText = 'Indexing...';
                nexusFetch('kb/ingest', 'POST', { url: urlInput.value, target: target }).then(() => {
                    kbIndexBtn.innerText = 'Index';
                    alert('Indexed for: ' + target.toUpperCase());
                    window.location.reload();
                });
            }
        });
    }

    const kbFileInput = document.getElementById('nexus-kb-file-input');
    if (kbFileInput) {
        kbFileInput.addEventListener('change', function() {
            if (!kbFileInput.files[0]) return;
            const formData = new FormData();
            formData.append('file', kbFileInput.files[0]);
            fetch(`${nexus_ai_data.rest_url}nexus-ai/v1/kb/upload`, {
                method: 'POST',
                headers: { 'X-WP-Nonce': nexus_ai_data.nonce },
                body: formData
            }).then(res => res.json()).then(data => {
                if (data.success) {
                    alert('Ingested successfully! Chunks: ' + data.chunks);
                    window.location.reload();
                }
            });
        });
    }

    const wipeBtn = document.getElementById('nexus-wipe-memory');
    if (wipeBtn) {
        wipeBtn.addEventListener('click', function() {
            if (confirm('Wipe all memory?')) {
                nexusFetch('kb/wipe', 'POST').then(() => window.location.reload());
            }
        });
    }

    // --- 5. Visual Workflow Builder ---
    const canvas = document.getElementById('nexus-workflow-canvas');
    const draggables = document.querySelectorAll('.nexus-draggable-agent');

    draggables.forEach(d => {
        d.addEventListener('dragstart', (e) => {
            e.dataTransfer.setData('agent_id', d.dataset.id);
            e.dataTransfer.setData('agent_name', d.querySelector('p').innerText);
        });
    });

    if (canvas) {
        canvas.addEventListener('dragover', (e) => e.preventDefault());
        canvas.addEventListener('drop', (e) => {
            e.preventDefault();
            const id = e.dataTransfer.getData('agent_id');
            const name = e.dataTransfer.getData('agent_name');
            const stepCount = canvas.querySelectorAll('.nexus-workflow-step').length + 1;

            const step = document.createElement('div');
            step.className = 'nexus-workflow-step p-6 rounded-2xl bg-nexus-surface border border-nexus-violet animate-fade-in-up mb-4 w-72 shadow-xl relative z-10';
            step.dataset.agentId = id;
            step.innerHTML = `
                <div class="flex justify-between items-center mb-3">
                    <p class="text-nexus-violet font-bold text-xs uppercase tracking-widest">Step ${stepCount}</p>
                    <button class="text-gray-600 hover:text-red-500 transition-colors nexus-step-delete">✕</button>
                </div>
                <p class="text-white font-bold">${name}</p>
                <textarea placeholder="Define task..." class="nexus-step-task w-full bg-nexus-bg border border-nexus-border rounded-xl mt-3 p-3 text-xs text-white outline-none focus:border-nexus-violet h-20"></textarea>
            `;
            if (canvas.querySelector('.text-center')) canvas.innerHTML = '';
            canvas.appendChild(step);
        });
    }

    const saveWorkflowBtn = document.getElementById('nexus-save-workflow-btn');
    if (saveWorkflowBtn) {
        saveWorkflowBtn.addEventListener('click', function() {
            const steps = [];
            document.querySelectorAll('.nexus-workflow-step').forEach((step, index) => {
                steps.push({
                    name: `Step_${index + 1}`,
                    agent_id: step.dataset.agentId,
                    task_description: step.querySelector('.nexus-step-task').value
                });
            });
            if (steps.length === 0) return;
            nexusFetch('workflows', 'POST', { steps: steps, name: 'Custom Workflow ' + Date.now() }).then(() => {
                alert('Workflow Saved');
                window.location.reload();
            });
        });
    }

    // --- 6. Global Click Handlers (Delegation) ---
    document.addEventListener('click', function(e) {
        // Modal Toggles
        if (e.target.closest('#nexus-open-visual-builder')) {
            document.getElementById('nexus-visual-builder-modal')?.classList.remove('hidden');
        }
        if (e.target.closest('#nexus-close-builder')) {
            document.getElementById('nexus-visual-builder-modal')?.classList.add('hidden');
        }
        if (e.target.closest('#nexus-close-results')) {
            document.getElementById('nexus-workflow-results-modal')?.classList.add('hidden');
        }

        // Canvas Maintenance
        if (e.target.closest('#nexus-clear-canvas')) {
            if (canvas) canvas.innerHTML = '<div class="text-center"><p class="text-gray-500 font-bold uppercase tracking-widest text-sm">Drop Agents Here</p></div>';
        }

        // --- Strategic Archive ---
        const viewTranscriptBtn = e.target.closest('.nexus-view-transcript');
        if (viewTranscriptBtn) {
            const id = viewTranscriptBtn.dataset.id;
            const title = viewTranscriptBtn.dataset.title;
            const modal = document.getElementById('nexus-archive-modal');
            const container = document.getElementById('nexus-archive-content');

            modal.classList.remove('hidden');
            document.getElementById('nexus-archive-title').innerText = title;
            container.innerHTML = '<p class="text-accent animate-pulse text-center py-10">Retrieving intelligence records...</p>';

            nexusFetch(`conversations/${id}`, 'GET').then(messages => {
                container.innerHTML = '';
                messages.forEach(msg => {
                    const isUser = msg.sender_type === 'user';
                    container.innerHTML += `
                        <div class="flex gap-4 items-start ${isUser ? 'justify-end' : ''}">
                            <div class="max-w-[80%] p-6 rounded-3xl ${isUser ? 'bg-accent/10 border border-accent/20' : 'bg-white/5 border border-white/5 shadow-xl'}">
                                <p class="text-[10px] text-gray-500 font-bold uppercase mb-2">${msg.sender_type}</p>
                                <p class="text-sm text-gray-200 leading-relaxed">${msg.content}</p>
                                <p class="text-[9px] text-gray-600 mt-4">${msg.created_at}</p>
                            </div>
                        </div>
                    `;
                });
            });
        }

        if (e.target.closest('#nexus-close-archive')) {
            document.getElementById('nexus-archive-modal')?.classList.add('hidden');
        }

        const exportMDBtn = e.target.closest('.nexus-export-md');
        if (exportMDBtn) {
            const id = exportMDBtn.dataset.id;
            const title = exportMDBtn.dataset.title;

            nexusFetch(`conversations/${id}`, 'GET').then(messages => {
                let md = `# ${title}\n\n`;
                messages.forEach(msg => {
                    md += `### ${msg.sender_type.toUpperCase()} (${msg.created_at})\n${msg.content}\n\n---\n\n`;
                });
                const blob = new Blob([md], { type: 'text/markdown' });
                const url = window.URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = `${title.replace(/\s+/g, '_')}_transcript.md`;
                a.click();
            });
        }

        // Agent Deletion
        const delAgentBtn = e.target.closest('.nexus-delete-agent');
        if (delAgentBtn) {
            if (confirm('Are you sure you want to terminate this agent contract?')) {
                const id = delAgentBtn.dataset.id;
                nexusFetch(`employees/${id}`, 'DELETE').then(() => window.location.reload());
            }
        }

        // Dept Deletion
        const delDeptBtn = e.target.closest('.nexus-delete-dept');
        if (delDeptBtn) {
            if (confirm('Delete this department? Active agents will be unassigned.')) {
                const id = delDeptBtn.dataset.id;
                nexusFetch(`departments/${id}`, 'DELETE').then(() => window.location.reload());
            }
        }

        // Step Deletion
        if (e.target.closest('.nexus-step-delete')) {
            e.target.closest('.nexus-workflow-step').remove();
            document.querySelectorAll('.nexus-workflow-step').forEach((s, i) => {
                const label = s.querySelector('p.text-nexus-violet');
                if (label) label.innerText = 'Step ' + (i + 1);
            });
        }

        // Workflow Deletion
        const delWfBtn = e.target.closest('.nexus-delete-workflow');
        if (delWfBtn) {
            if (confirm('Delete this automation?')) {
                const id = delWfBtn.dataset.id;
                nexusFetch(`workflows/${id}`, 'DELETE').then(() => window.location.reload());
            }
        }

        // Run Workflow
        const runWfBtn = e.target.closest('.nexus-run-workflow');
        if (runWfBtn) {
            const id = runWfBtn.dataset.id;
            const input = prompt('Enter trigger:');
            if (!input) return;
            document.getElementById('nexus-workflow-results-modal')?.classList.remove('hidden');
            const log = document.getElementById('nexus-workflow-log');
            log.innerHTML = '<p class="text-accent animate-pulse">Initializing...</p>';
            nexusFetch(`workflows/run/${id}`, 'POST', { input: input }).then(res => {
                log.innerHTML = '';
                res.results.forEach((step, idx) => {
                    log.innerHTML += `<div class="p-6 bg-white/5 rounded-2xl mb-4 border border-white/5">
                        <p class="text-[10px] text-accent uppercase font-bold mb-2">${step.step} - ${step.agent}</p>
                        <p class="text-sm text-gray-300">${step.output}</p>
                    </div>`;
                });
            });
        }
    });

    // --- 7. Billing ---
    document.querySelectorAll('.nexus-select-plan').forEach(btn => {
        btn.addEventListener('click', function() {
            const plan = btn.dataset.plan;
            btn.innerText = 'Activating...';
            nexusFetch('billing/upgrade', 'POST', { plan: plan }).then(() => window.location.reload());
        });
    });

    const cancelSubBtn = document.getElementById('nexus-cancel-sub');
    if (cancelSubBtn) {
        cancelSubBtn.addEventListener('click', function() {
            if (confirm('Proceed with cancellation?')) {
                cancelSubBtn.innerText = 'Cancelling...';
                nexusFetch('billing/cancel', 'POST').then(() => window.location.reload());
            }
        });
    }

    // --- 8. Meetings ---
    const startMeetingBtn = document.getElementById('nexus-start-meeting-btn');
    if (startMeetingBtn) {
        startMeetingBtn.addEventListener('click', function() {
            const invitees = Array.from(document.querySelectorAll('.nexus-meeting-invitee:checked')).map(cb => cb.value);
            const agenda = document.getElementById('nexus-meeting-agenda').value;
            if (invitees.length === 0 || !agenda) return;
            document.getElementById('nexus-meeting-transcript').innerHTML = '<p class="text-accent italic">Meeting Started...</p>';
            runMeetingRound(invitees, agenda);
        });
    }

    function runMeetingRound(invitees, agenda, round = 1) {
        if (round > 5) {
            document.getElementById('nexus-meeting-transcript').innerHTML += '<p class="text-green-500 font-bold text-center mt-4">Consensus Reached.</p>';
            document.getElementById('nexus-meeting-summarize')?.classList.remove('hidden');
            return;
        }
        const nextId = invitees[(round - 1) % invitees.length];
        nexusFetch('chat/meeting', 'POST', { agent_id: nextId, agenda: agenda, round: round }).then(res => {
            const colors = ['#7C3AED', '#0ea5e9', '#f59e0b', '#10b981'];
            const bubble = `<div class="flex gap-4 items-start animate-fade-in-up">
                <div class="w-10 h-10 rounded-full shrink-0 flex items-center justify-center font-bold text-white" style="background-color: ${colors[round%4]}">${res.agent_name[0]}</div>
                <div class="flex-1 p-4 bg-white/5 rounded-2xl border-l-4" style="border-color: ${colors[round%4]}">
                    <p class="text-[10px] text-gray-500 font-bold uppercase mb-1">${res.agent_name} (${res.position})</p>
                    <p class="text-sm text-gray-200">${res.content}</p>
                </div>
            </div>`;
            const transcript = document.getElementById('nexus-meeting-transcript');
            if (round === 1) transcript.innerHTML = '';
            transcript.innerHTML += bubble;
            transcript.scrollTop = transcript.scrollHeight;
            setTimeout(() => runMeetingRound(invitees, agenda, round + 1), 2000);
        });
    }

    // --- 9. Department Creation ---
    const createDeptForm = document.getElementById('nexus-create-dept-form');
    if (createDeptForm) {
        createDeptForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const btn = createDeptForm.querySelector('button[type="submit"]');
            btn.innerText = 'Structuring Organization...';
            btn.classList.add('opacity-50', 'pointer-events-none');

            const data = Object.fromEntries(new FormData(createDeptForm).entries());
            nexusFetch('departments', 'POST', data).then(() => {
                alert('Department initialized successfully.');
                window.location.reload();
            });
        });
    }

    // --- 10. Analytics (Chart.js) ---
    const consumptionCtx = document.getElementById('nexus-consumption-chart');
    if (consumptionCtx && typeof Chart !== 'undefined') {
        new Chart(consumptionCtx, {
            type: 'line',
            data: {
                labels: ['W1', 'W2', 'Week 3', 'Week 4'],
                datasets: [{ label: 'Usage', data: [12, 19, 3, 5], borderColor: '#7C3AED', tension: 0.4 }]
            },
            options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } } }
        });
    }
});

// 20. Purge Logs Action
document.addEventListener('click', function(e) {
    const purgeBtn = e.target.closest('#nexus-purge-logs');
    if (purgeBtn) {
        if (confirm('Are you sure you want to purge all usage and audit logs? This action is irreversible.')) {
            purgeBtn.innerText = 'Purging Data...';
            nexusFetch('status/purge', 'POST').then(() => {
                alert('System logs purged successfully.');
                window.location.reload();
            });
        }
    }
});
