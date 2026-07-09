# Nexus AI Workforce: Functional & Feature Guide

This guide provides detailed instructions for every form, field, and section within the Nexus AI platform to ensure a premium user experience and optimal agent performance.

---

## 1. Workforce Hall (Employee Management)

### 1.1 The "Hire Agent" Form
- **Name:** The human-readable name for the AI agent (e.g., "Sarah").
- **Position:** The specific professional role (e.g., "Senior SEO Strategist"). This heavily influences the agent's initial reasoning.
- **Department:** Categorize the agent for multi-agent meeting filtering.
- **Role Description (Identity):** *Instructions:* Write in the first person. "I am a growth-focused marketer with 10 years of experience in SaaS..."
- **Responsibilities:** List 3-5 specific duties. *Note:* Use bullet points for better AI parsing.
- **Goals & KPIs:** Define what success looks like (e.g., "Increase organic traffic by 20%"). Agents will reference these when weighing decisions.

### 1.2 The AI Brain Builder (Visual Config)
- **Temperature Slider (0.0 to 1.0):**
    - *0.2 - 0.4:* Professional, factual, low variance (CFO, Legal).
    - *0.7 - 0.9:* Creative, brainstorming, high variance (Copywriter, UX Designer).
- **Thinking Process Toggle:** Enables "Chain of Thought" reasoning. *Instructions:* Use this for complex analytical roles to see the "Logic Logs" before the final answer.
- **Memory Depth:** Controls how many past messages the agent remembers. *Warning:* Higher depth increases token costs.

---

## 2. The Command Center (Chat UI)

### 2.1 Chat Interface
- **Agent Selector:** Switch between agents mid-conversation.
- **Context Pinning:** Pin specific Knowledge Base documents to the chat so the agent prioritizes them.
- **Logic Logs (Thinking Mode):** Click the "Brain" icon to expand the agent's internal reasoning process.

### 2.2 Meeting Room
- **Participant Selection:** Choose up to 5 agents. *Instructions:* For best results, include a "Moderator" (e.g., CEO) to synthesize the debate.
- **Consensus Mode:** Forces agents to vote on a final decision.
- **Meeting Minutes Export:** Automatically generates a Markdown summary of the discussion.

---

## 3. Knowledge Base Manager

### 3.1 Document Upload
- **Source Selection:** Drag-and-drop or URL input.
- **Indexing Priority:** *Instructions:* Set "High" for core company policies and "Normal" for general reference documents.
- **Tagging:** Use tags like `#marketing` or `#legal` to limit which departments can access specific data.

---

## 4. Settings & Security

### 4.1 API Key Management
- **Encryption Status:** Shows a green shield if the key is stored with AES-256-CTR encryption.
- **Usage Limits:** Set monthly dollar caps to prevent overspending.

### 4.2 White Label (Agency Only)
- **Primary Brand Color:** Updates the entire UI accent color.
- **Support URL:** Replaces the Nexus AI support link with your agency's portal.
