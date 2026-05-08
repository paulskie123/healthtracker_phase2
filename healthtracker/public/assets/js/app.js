// HealthTracker v2.0 — app.js

// Confirm delete
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[data-confirm]').forEach(el => {
        el.addEventListener('click', e => {
            if (!confirm(el.dataset.confirm || 'Are you sure?')) {
                e.preventDefault();
            }
        });
    });

    // Auto-dismiss alerts
    document.querySelectorAll('.alert[data-auto-dismiss]').forEach(el => {
        setTimeout(() => {
            el.style.transition = 'opacity 0.5s';
            el.style.opacity = '0';
            setTimeout(() => el.remove(), 500);
        }, 3500);
    });

    // Sidebar active highlight based on URL
    const page = new URLSearchParams(window.location.search).get('page') || 'dashboard';
    document.querySelectorAll('.nav-item').forEach(el => {
        const href = el.getAttribute('href') || '';
        if (href.includes('page=' + page)) {
            el.classList.add('active');
        }
    });
});

// Self-diagnosis analyzer (used on dashboard)
function analyzeHealth() {
    const sys = parseInt(document.getElementById('sys')?.value || 0);
    const dia = parseInt(document.getElementById('dia')?.value || 0);
    const hr  = parseInt(document.getElementById('hrt')?.value || 0);
    const sym = document.getElementById('sym')?.value || 'None';

    let msg = '', color = 'var(--green)', icon = '✅';

    if (sys >= 180 || dia >= 120) {
        msg = 'Hypertensive crisis detected. Seek immediate medical attention!';
        color = 'var(--red)'; icon = '🚨';
    } else if (sys >= 140 || dia >= 90) {
        msg = 'High blood pressure (Stage 2). Please consult your physician soon.';
        color = '#ff7070'; icon = '⚠️';
    } else if (sys >= 130 || dia >= 80) {
        msg = 'Elevated blood pressure (Stage 1). Monitor closely and reduce sodium.';
        color = 'var(--orange)'; icon = '🟡';
    } else if (hr > 100) {
        msg = 'Elevated heart rate (tachycardia). Rest and stay well-hydrated.';
        color = 'var(--orange)'; icon = '⚡';
    } else if (hr < 50) {
        msg = 'Low heart rate (bradycardia). Consider consulting your doctor.';
        color = 'var(--blue)'; icon = '💙';
    } else {
        msg = 'Your vitals look great! Keep up the healthy lifestyle.';
    }

    if (sym !== 'None') msg += ` Noted symptom: ${sym}.`;

    const el = document.getElementById('diagResult');
    if (el) {
        el.innerHTML = `<div style="background:rgba(255,255,255,0.04);border:1px solid ${color}44;border-radius:8px;padding:13px 16px;color:${color};font-size:13.5px;font-weight:600;display:flex;align-items:center;gap:10px;">${icon} ${msg}</div>`;
    }
}

// Reminder add
function showAddReminder() {
    const form = document.getElementById('addReminderForm');
    if (form) form.style.display = form.style.display === 'none' ? 'block' : 'none';
}

function saveReminder() {
    const title = document.getElementById('remTitle')?.value.trim();
    const time  = document.getElementById('remTime')?.value;
    if (!title || !time) { alert('Please fill in both fields.'); return; }

    const [h, m] = time.split(':');
    const ampm = h >= 12 ? 'PM' : 'AM';
    const hour = h % 12 || 12;
    const formatted = `${hour}:${m} ${ampm}`;

    const list = document.querySelector('.reminder-list');
    if (list) {
        const item = document.createElement('div');
        item.className = 'reminder-item';
        item.innerHTML = `
            <div class="reminder-icon-wrap">🔔</div>
            <span class="reminder-text">${title}</span>
            <span class="reminder-time">${formatted}</span>`;
        list.appendChild(item);
    }

    document.getElementById('remTitle').value = '';
    document.getElementById('remTime').value  = '';
    document.getElementById('addReminderForm').style.display = 'none';
}
