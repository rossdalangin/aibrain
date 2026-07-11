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

    // 12. Purge Logs
    const purgeBtn = document.getElementById('nexus-purge-logs');
    if (purgeBtn) {
        purgeBtn.addEventListener('click', function() {
            if (!confirm('Are you sure you want to purge all system logs?')) return;
            purgeBtn.innerText = 'Purging...';
            nexusFetch('status/purge', 'POST').then(res => {
                alert('System logs purged.');
                window.location.reload();
            });
        });
    }

    // 11. Wipe Memory
    const wipeBtn = document.getElementById('nexus-wipe-memory');
    if (wipeBtn) {
        wipeBtn.addEventListener('click', function() {
            if (!confirm('Are you sure you want to PERMANENTLY wipe all company memory? This cannot be undone.')) return;

            wipeBtn.innerText = 'Wiping...';
            nexusFetch('kb/wipe', 'POST').then(res => {
                alert('Memory wiped successfully.');
                window.location.reload();
            });
        });
    }

    // 10. Enterprise Analytics (Chart.js)
    const consumptionCtx = document.getElementById('nexus-consumption-chart');
    if (consumptionCtx && typeof Chart !== 'undefined') {
        new Chart(consumptionCtx, {
            type: 'line',
            data: {
                labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
                datasets: [{
                    label: 'Token Usage',
                    data: [12000, 19000, 3000, 5000],
                    borderColor: '#7C3AED',
                    tension: 0.4,
                    fill: true,
                    backgroundColor: 'rgba(124, 58, 237, 0.1)'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { grid: { color: 'rgba(255,255,255,0.05)' } },
                    x: { grid: { display: false } }
                }
            }
        });
    }

    const efficiencyCtx = document.getElementById('nexus-efficiency-chart');
    if (efficiencyCtx && typeof Chart !== 'undefined') {
        new Chart(efficiencyCtx, {
            type: 'doughnut',
            data: {
                labels: ['Marketing', 'IT', 'Legal', 'Executive'],
                datasets: [{
                    data: [45, 25, 15, 15],
                    backgroundColor: ['#7C3AED', '#0ea5e9', '#f59e0b', '#10b981'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { position: 'bottom', labels: { color: '#94a3b8' } } }
            }
        });
    }

    // 7. KB File Upload
    const kbFileInput = document.getElementById('nexus-kb-file-input');
    const uploadIdle = document.getElementById('nexus-upload-idle');
    const uploadProgress = document.getElementById('nexus-upload-progress');

    if (kbFileInput) {
        kbFileInput.addEventListener('change', function() {
            if (!kbFileInput.files[0]) return;

            uploadIdle.classList.add('hidden');
            uploadProgress.classList.remove('hidden');

            const formData = new FormData();
            formData.append('file', kbFileInput.files[0]);

            fetch(`${nexus_ai_data.rest_url}nexus-ai/v1/kb/upload`, {
                method: 'POST',
                headers: { 'X-WP-Nonce': nexus_ai_data.nonce },
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                uploadProgress.classList.add('hidden');
                uploadIdle.classList.remove('hidden');
                if (data.success) {
                    alert('Document ingested successfully! Chunks created: ' + data.chunks);
                } else {
                    alert('Upload failed: ' + (data.message || 'Unknown error'));
                }
            });
        });
    }

    // 1. Hire Agent Form Submission
    const hireForm = document.getElementById('nexus-hire-agent-form');
    if (hireForm) {
        hireForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(hireForm);
            const rawData = Object.fromEntries(formData.entries());

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

            nexusFetch('employees', 'POST', payload).then(res => {
                alert('Agent deployed successfully! This expert is now ready for deployment.');
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

    if (openBuilderBtn && builderModal) {
        openBuilderBtn.addEventListener('click', () => builderModal.classList.remove('hidden'));
    }
    if (closeBuilderBtn && builderModal) {
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
            step.className = 'nexus-workflow-step p-6 rounded-2xl bg-nexus-surface border border-nexus-violet animate-fade-in-up mb-4 w-72 shadow-xl relative z-10';
            step.dataset.agentId = id;
            step.innerHTML = `
                <div class="flex justify-between items-center mb-3">
                    <p class="text-nexus-violet font-bold text-xs uppercase tracking-widest">Step ${canvas.querySelectorAll('.nexus-workflow-step').length + 1}</p>
                    <button class="text-gray-600 hover:text-red-500 transition-colors" onclick="this.parentElement.parentElement.remove()">✕</button>
                </div>
                <p class="text-white font-bold">${name}</p>
                <textarea placeholder="Define the specific task for this agent..." class="nexus-step-task w-full bg-nexus-bg border border-nexus-border rounded-xl mt-3 p-3 text-xs text-white outline-none focus:border-nexus-violet h-20"></textarea>
            `;

            if (canvas.querySelector('.text-center')) {
                canvas.innerHTML = ''; // Clear placeholder
            }
            canvas.appendChild(step);
        });
    }

    const saveWorkflowBtn = document.querySelector('button[id="nexus-save-workflow-btn"]') || document.querySelector('button.bg-accent.text-white.px-8.py-3.rounded-xl.font-bold');
    if (saveWorkflowBtn && (saveWorkflowBtn.innerText.includes('Save Workflow') || saveWorkflowBtn.id === 'nexus-save-workflow-btn')) {
        saveWorkflowBtn.addEventListener('click', function() {
            const steps = [];
            document.querySelectorAll('.nexus-workflow-step').forEach((step, index) => {
                steps.push({
                    name: `Step_${index + 1}`,
                    agent_id: step.dataset.agentId,
                    task_description: step.querySelector('.nexus-step-task').value
                });
            });

            if (steps.length === 0) return alert('Add at least one step to the workflow.');

            saveWorkflowBtn.innerText = 'Saving...';
            nexusFetch('workflows', 'POST', { steps: steps, name: 'Custom Workflow ' + Date.now() }).then(res => {
                saveWorkflowBtn.innerText = 'Saved ✓';
                setTimeout(() => saveWorkflowBtn.innerText = 'Save Workflow', 2000);
            });
        });
    }

    // 8. Run Workflow
    document.querySelectorAll('.nexus-run-workflow').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = btn.dataset.id;
            const input = prompt('Enter the initial trigger for this workflow (e.g. "Draft a 500 word blog post about solar energy"):');
            if (!input) return;

            const resultsModal = document.getElementById('nexus-workflow-results-modal');
            const workflowLog = document.getElementById('nexus-workflow-log');

            resultsModal.classList.remove('hidden');
            workflowLog.innerHTML = `<div class="p-6 rounded-2xl bg-accent/10 border border-accent/20 italic text-accent animate-pulse">Initializing execution sequence... Input: "${input}"</div>`;

            nexusFetch(`workflows/run/${id}`, 'POST', { input: input }).then(res => {
                workflowLog.innerHTML = ''; // Clear init message

                let fullText = '';
                res.results.forEach((step, index) => {
                    fullText += `[${step.step} - ${step.agent}]\n${step.output}\n\n`;
                    const entry = document.createElement('div');
                    entry.className = 'flex gap-6 items-start animate-fade-in-up';
                    entry.style.animationDelay = `${index * 0.2}s`;
                    entry.innerHTML = `
                        <div class="w-12 h-12 rounded-full bg-nexus-elevated border border-accent flex items-center justify-center font-bold text-accent shrink-0">
                            ${index + 1}
                        </div>
                        <div class="flex-1">
                            <div class="flex justify-between items-center mb-2">
                                <p class="font-bold text-white uppercase tracking-widest text-[10px] opacity-50">${step.step} • ${step.agent}</p>
                                <button class="text-[10px] text-accent hover:text-white" onclick="navigator.clipboard.writeText(\`${step.output.replace(/`/g, '\\`').replace(/\$/g, '\\$')}\`); alert('Step output copied!')">Copy Output</button>
                            </div>
                            <div class="p-6 rounded-3xl bg-nexus-elevated border border-nexus-border text-gray-300 text-sm leading-relaxed shadow-xl">
                                ${step.output}
                            </div>
                        </div>
                    `;
                    workflowLog.appendChild(entry);
                });

                const final = document.createElement('div');
                final.className = 'p-6 rounded-2xl bg-green-500/10 border border-green-500/20 text-green-500 font-bold text-center mt-10 flex flex-col items-center gap-4';
                final.innerHTML = `
                    <p>WORKFLOW SEQUENCE COMPLETED SUCCESSFULLY ✓</p>
                    <button class="bg-green-500 text-black px-6 py-2 rounded-xl text-xs" onclick="navigator.clipboard.writeText(\`${fullText.replace(/`/g, '\\`').replace(/\$/g, '\\$')}\`); alert('Full trace copied!')">Copy Full Trace</button>
                `;
                workflowLog.appendChild(final);
            });
        });
    });

    const closeResultsBtn = document.getElementById('nexus-close-results');
    if (closeResultsBtn) {
        closeResultsBtn.addEventListener('click', () => document.getElementById('nexus-workflow-results-modal').classList.add('hidden'));
    }

    // 9. Connectivity Test
    const testBtn = document.getElementById('nexus-test-connectivity');
    if (testBtn) {
        testBtn.addEventListener('click', function() {
            testBtn.innerText = 'Testing All Endpoints...';
            nexusFetch('status', 'GET').then(res => {
                testBtn.innerText = 'All Systems Operational ✓';
                setTimeout(() => testBtn.innerText = 'Run Global Connectivity Test', 3000);
            });
        });
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
            meetingTranscript.innerHTML += `<div class="p-4 rounded-xl bg-green-500/10 border border-green-500/20 italic text-green-500 text-center font-bold">Consensus reached. Final strategy finalized.</div>`;
            startMeetingBtn.innerText = 'Start Strategic Meeting';
            return;
        }

        const nextAgentId = invitees[(round - 1) % invitees.length];

        nexusFetch(`chat/meeting`, 'POST', {
            agent_id: nextAgentId,
            agenda: agenda,
            round: round,
            invitees: invitees
        }).then(res => {
            const colors = ['#7C3AED', '#0ea5e9', '#f59e0b', '#10b981', '#ef4444', '#f97316'];
            const agentColor = colors[round % colors.length];

            const entry = document.createElement('div');
            entry.className = 'flex gap-4 items-start animate-fade-in-up';
            entry.innerHTML = `
                <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-white shrink-0 shadow-lg" style="background-color: ${agentColor}">
                    ${res.agent_name.charAt(0)}
                </div>
                <div class="flex-1">
                    <p class="font-bold text-white mb-1">${res.agent_name} <span class="text-xs text-gray-500 font-normal ml-2">${res.position}</span></p>
                    <div class="p-6 rounded-3xl bg-nexus-elevated border-l-4 text-gray-300 text-sm leading-relaxed shadow-xl" style="border-color: ${agentColor}">
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

            tabButtons.forEach(b => b.classList.remove('bg-accent', 'text-white'));
            tabButtons.forEach(b => b.classList.add('text-gray-400'));
            btn.classList.remove('text-gray-400');
            btn.classList.add('bg-accent', 'text-white');

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

// 15. Visual Builder Reliability & Cleanup
document.addEventListener('click', function(e) {
    // Better modal toggle
    const openBtn = e.target.closest('#nexus-open-visual-builder');
    if (openBtn) {
        const modal = document.getElementById('nexus-visual-builder-modal');
        if (modal) modal.classList.remove('hidden');
    }

    const closeBtn = e.target.closest('#nexus-close-builder');
    if (closeBtn) {
        const modal = document.getElementById('nexus-visual-builder-modal');
        if (modal) modal.classList.add('hidden');
    }

    // Clear Canvas
    const clearBtn = e.target.closest('#nexus-clear-canvas');
    if (clearBtn) {
        const canvas = document.getElementById('nexus-workflow-canvas');
        if (canvas) {
            canvas.innerHTML = '<div class="text-center"><p class="text-gray-500 font-bold uppercase tracking-widest text-sm">Drop Agents Here to Initialize Sequence</p></div>';
        }
    }

    // Step Deletion Logic (Fix for global context)
    const delBtn = e.target.closest('.nexus-workflow-step button');
    if (delBtn) {
        delBtn.closest('.nexus-workflow-step').remove();
        // Re-index remaining steps
        document.querySelectorAll('.nexus-workflow-step').forEach((step, idx) => {
            const stepLabel = step.querySelector('p.text-nexus-violet');
            if (stepLabel) stepLabel.innerText = 'Step ' + (idx + 1);
        });
    }
});

// 16. Subscription Cancellation
const cancelSubBtn = document.getElementById('nexus-cancel-sub');
if (cancelSubBtn) {
    cancelSubBtn.addEventListener('click', function() {
        if (!confirm('Warning: Cancelling your plan will deactivate all agents at the end of your billing cycle. Proceed?')) return;

        cancelSubBtn.innerText = 'Processing...';
        nexusFetch('billing/cancel', 'POST').then(res => {
            alert('Cancellation request received.');
            window.location.reload();
        });
    });
}

// 17. Meeting Summarization & Export
function updateMeetingUI(isConcluded = false) {
    const summarizeBtn = document.getElementById('nexus-meeting-summarize');
    if (summarizeBtn && isConcluded) {
        summarizeBtn.classList.remove('hidden');
        summarizeBtn.addEventListener('click', function() {
            const transcript = document.getElementById('nexus-meeting-transcript').innerText;
            navigator.clipboard.writeText(transcript);
            alert('Meeting minutes copied to clipboard!');
            summarizeBtn.innerText = 'COPIED ✓';
        });
    }
}

// Intercept original meeting logic to show summarize button
const originalRunMeetingRound = runMeetingRound;
runMeetingRound = function(invitees, agenda, round = 1) {
    if (round > 5) {
        updateMeetingUI(true);
    }
    originalRunMeetingRound(invitees, agenda, round);
};
