<?php
$pageTitle  = 'Appointments';
$activePage = 'appointments';
require_once APP_PATH . '/views/shared/header.php';

$upcoming  = array_values(array_filter($appointments, fn($a) => $a['status'] === 'Scheduled'));
$completed = array_values(array_filter($appointments, fn($a) => $a['status'] === 'Completed'));
$cancelled = array_values(array_filter($appointments, fn($a) => $a['status'] === 'Cancelled'));

$totalAppts     = count($appointments);
$scheduledCount = count($upcoming);
$completedCount = count($completed);
$cancelledCount = count($cancelled);
$completionRate = $totalAppts > 0 ? round($completedCount / $totalAppts * 100) : 0;
$todayStr       = date('Y-m-d');
$todayAppts     = array_values(array_filter($appointments, fn($a) => $a['date'] === $todayStr));
$todayCount     = count($todayAppts);

$specialtyCounts = [];
foreach ($appointments as $a) {
    $s = $a['specialty'] ?? 'General';
    $specialtyCounts[$s] = ($specialtyCounts[$s] ?? 0) + 1;
}
arsort($specialtyCounts);
$topSpecialty      = array_key_first($specialtyCounts) ?? '—';
$topSpecialtyCount = $specialtyCounts[$topSpecialty] ?? 0;

$weekStart  = date('Y-m-d', strtotime('monday this week'));
$weekEnd    = date('Y-m-d', strtotime('sunday this week'));
$weekAppts  = array_filter($appointments, fn($a) => $a['date'] >= $weekStart && $a['date'] <= $weekEnd);
$weekCount  = count($weekAppts);

$timelineAppts = array_slice($upcoming, 0, 5);
?>

<style>
@import url('https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;1,9..40,300&family=Space+Mono:wght@400;700&display=swap');

/* ============================================================
   APPOINTMENTS PAGE  |  Matched to Medications Page Scale
   Premium Animations · Consistent Hierarchy
   ============================================================ */

:root {
    --ap-blue:        #3b9eff;
    --ap-blue-dim:    rgba(59,158,255,0.12);
    --ap-blue-glow:   rgba(59,158,255,0.28);
    --ap-teal:        #00d4aa;
    --ap-teal-dim:    rgba(0,212,170,0.12);
    --ap-teal-glow:   rgba(0,212,170,0.28);
    --ap-purple:      #a78bfa;
    --ap-purple-dim:  rgba(167,139,250,0.12);
    --ap-green:       #34d399;
    --ap-green-dim:   rgba(52,211,153,0.12);
    --ap-amber:       #fbbf24;
    --ap-amber-dim:   rgba(251,191,36,0.12);
    --ap-amber-glow:  rgba(251,191,36,0.28);
    --ap-red:         #f87171;
    --ap-red-dim:     rgba(248,113,113,0.12);
    --ap-orange:      #fb923c;
    --ap-glass:       rgba(255,255,255,0.04);
    --ap-glass2:      rgba(255,255,255,0.07);
    --ap-border:      rgba(255,255,255,0.08);
    --ap-border2:     rgba(255,255,255,0.14);
    --ap-text1:       #e8f4f0;
    --ap-text2:       #8fa8b8;
    --ap-text3:       #3d5060;
    --ap-font:        'DM Sans', sans-serif;
    --ap-mono:        'Space Mono', monospace;
}

/* ── Keyframes ──────────────────────────────────── */
@keyframes apFadeUp   { from{opacity:0;transform:translateY(18px)} to{opacity:1;transform:translateY(0)} }
@keyframes apSlideIn  { from{opacity:0;transform:translateX(-12px)} to{opacity:1;transform:translateX(0)} }
@keyframes apScaleIn  { from{opacity:0;transform:scale(.94)} to{opacity:1;transform:scale(1)} }
@keyframes apDotPulse { 0%,100%{opacity:1;transform:scale(1)} 50%{opacity:.4;transform:scale(.85)} }
@keyframes apGlow     { 0%,100%{box-shadow:0 0 12px var(--ap-blue-glow)} 50%{box-shadow:0 0 28px var(--ap-blue-glow),0 0 48px rgba(59,158,255,.1)} }
@keyframes apFloat    { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-5px)} }
@keyframes apRipple   { 0%{transform:scale(0);opacity:.5} 100%{transform:scale(3);opacity:0} }
@keyframes apBarFill  { from{width:0} }
@keyframes apLineGrow { from{height:0;opacity:0} to{height:100%;opacity:1} }

/* ── Page Shell ─────────────────────────────────── */
.ap-module {
    font-family: var(--ap-font);
    color: var(--ap-text1);
    max-width: 1400px;
    animation: apFadeUp .45s ease both;
}

/* ── Flash ──────────────────────────────────────── */
.ap-flash {
    display: flex; align-items: center; gap: 12px;
    background: rgba(52,211,153,.08); border: 1px solid rgba(52,211,153,.28);
    border-radius: 14px; padding: 18px 24px;
    font-size: 15px; color: var(--ap-green); margin-bottom: 32px;
    animation: apFadeUp .35s ease both;
}

/* ── Page Header ────────────────────────────────── */
.ap-header {
    display: flex; align-items: center; justify-content: space-between;
    gap: 24px; flex-wrap: wrap; margin-bottom: 44px;
    animation: apFadeUp .4s ease both;
}
.ap-header-left { display: flex; align-items: center; gap: 22px; }

.ap-page-icon {
    width: 68px; height: 68px; border-radius: 20px;
    background: linear-gradient(135deg, rgba(59,158,255,.18), rgba(0,212,170,.12));
    border: 1px solid rgba(59,158,255,.32);
    display: flex; align-items: center; justify-content: center;
    font-size: 34px; flex-shrink: 0;
    animation: apFloat 4s ease-in-out infinite;
    box-shadow: 0 0 24px rgba(59,158,255,.15);
}
.ap-page-title {
    font-size: 52px; font-weight: 700; color: var(--ap-text1);
    letter-spacing: -1px; line-height: 1.1;
}
.ap-page-sub {
    font-size: 20px; color: var(--ap-text2);
    margin-top: 6px; line-height: 1.5; max-width: 560px;
}
.ap-count-pill {
    display: inline-flex; align-items: center; gap: 8px;
    background: var(--ap-blue-dim); border: 1px solid rgba(59,158,255,.28);
    border-radius: 22px; padding: 7px 16px;
    font-size: 14px; font-weight: 600; color: var(--ap-blue); margin-top: 10px;
}

/* ── Toolbar ────────────────────────────────────── */
.ap-toolbar { display: flex; flex-wrap: wrap; gap: 12px; align-items: center; }
.ap-search {
    display: flex; align-items: center; gap: 10px;
    background: var(--ap-glass); border: 1px solid var(--ap-border);
    border-radius: 11px; padding: 12px 18px; transition: all .22s;
}
.ap-search:focus-within {
    border-color: rgba(59,158,255,.5);
    box-shadow: 0 0 0 3px rgba(59,158,255,.1), 0 0 20px rgba(59,158,255,.08);
    background: rgba(59,158,255,.03);
}
.ap-search input {
    background: none; border: none; outline: none;
    color: var(--ap-text1); font-family: var(--ap-font);
    font-size: 15px; width: 210px;
}
.ap-search input::placeholder { color: var(--ap-text2); }
.ap-filter-select {
    background: var(--ap-glass); border: 1px solid var(--ap-border);
    border-radius: 11px; padding: 12px 18px;
    color: var(--ap-text2); font-family: var(--ap-font); font-size: 15px;
    outline: none; cursor: pointer; -webkit-appearance: none;
    transition: border-color .2s;
}
.ap-filter-select:focus { border-color: rgba(59,158,255,.5); }

/* ── Buttons ────────────────────────────────────── */
.ap-btn {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 14px 26px; border-radius: 11px;
    font-family: var(--ap-font); font-size: 15px; font-weight: 600;
    cursor: pointer; border: none; transition: all .22s;
    text-decoration: none; white-space: nowrap;
    position: relative; overflow: hidden;
}
.ap-btn-primary {
    background: linear-gradient(135deg, var(--ap-blue), #2272d9);
    color: #fff;
    box-shadow: 0 4px 20px rgba(59,158,255,.28);
}
.ap-btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 0 36px var(--ap-blue-glow), 0 8px 24px rgba(0,0,0,.3);
    filter: brightness(1.08);
}
.ap-btn-primary::after {
    content:''; position:absolute; inset:0; border-radius:11px;
    background:radial-gradient(circle at var(--rx,50%) var(--ry,50%), rgba(255,255,255,.28) 0%, transparent 60%);
    opacity:0; transition:opacity .3s;
}
.ap-btn-primary:hover::after { opacity:1; }
.ap-btn-edit {
    background: var(--ap-blue-dim); color: var(--ap-blue);
    border: 1px solid rgba(59,158,255,.28);
    padding: 10px 16px; font-size: 14px; border-radius: 9px;
}
.ap-btn-edit:hover { background: rgba(59,158,255,.22); transform: translateY(-1px); }
.ap-btn-del {
    background: var(--ap-red-dim); color: var(--ap-red);
    border: 1px solid rgba(248,113,113,.28);
    padding: 10px 16px; font-size: 14px; border-radius: 9px;
}
.ap-btn-del:hover { background: rgba(248,113,113,.22); transform: translateY(-1px); }

/* Action icon buttons */
.ap-action-btn {
    width: 44px; height: 44px; border-radius: 11px;
    display: flex; align-items: center; justify-content: center;
    font-size: 17px; cursor: pointer;
    border: 1px solid var(--ap-border); background: transparent;
    transition: all .2s; position: relative; overflow: hidden;
    text-decoration: none;
}
.ap-action-btn:hover { transform: translateY(-2px); }
.ap-action-edit:hover { background: rgba(59,158,255,.18);  border-color: rgba(59,158,255,.4);  box-shadow: 0 0 14px rgba(59,158,255,.2); }
.ap-action-del:hover  { background: rgba(248,113,113,.18); border-color: rgba(248,113,113,.4); box-shadow: 0 0 14px rgba(248,113,113,.2); }
.ap-action-btn .ap-tooltip {
    position: absolute; bottom: calc(100% + 8px); left: 50%; transform: translateX(-50%);
    background: #1c2a38; border: 1px solid var(--ap-border2); border-radius: 7px;
    padding: 5px 11px; font-size: 12px; color: var(--ap-text2); white-space: nowrap;
    pointer-events: none; opacity: 0; transition: opacity .15s;
}
.ap-action-btn:hover .ap-tooltip { opacity: 1; }

/* ── Status Badges ──────────────────────────────── */
.ap-status {
    display: inline-flex; align-items: center; gap: 7px;
    padding: 7px 15px; border-radius: 22px;
    font-size: 13px; font-weight: 600; white-space: nowrap; flex-shrink: 0;
}
.ap-status-dot { width: 8px; height: 8px; border-radius: 50%; background: currentColor; }
.ap-s-scheduled { background: var(--ap-blue-dim);   color: var(--ap-blue);   border: 1px solid rgba(59,158,255,.3);   box-shadow: 0 0 12px rgba(59,158,255,.1); }
.ap-s-completed  { background: var(--ap-green-dim);  color: var(--ap-green);  border: 1px solid rgba(52,211,153,.3);   box-shadow: 0 0 12px rgba(52,211,153,.1); }
.ap-s-cancelled  { background: var(--ap-red-dim);    color: var(--ap-red);    border: 1px solid rgba(248,113,113,.3);  box-shadow: 0 0 12px rgba(248,113,113,.1); }
.ap-s-scheduled .ap-status-dot { animation: apDotPulse 2s ease-in-out infinite; }

/* ── Stat Cards Grid ────────────────────────────── */
.ap-stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 20px; margin-bottom: 44px;
}
.ap-stat-card {
    background: var(--ap-glass);
    border: 1px solid var(--ap-border);
    border-radius: 18px; padding: 28px 26px;
    position: relative; overflow: hidden;
    transition: transform .22s, box-shadow .22s, border-color .22s;
    animation: apScaleIn .4s ease both;
}
.ap-stat-card::before {
    content:''; position:absolute; inset:0;
    background: radial-gradient(ellipse at top right, var(--sc-glow, rgba(59,158,255,.07)) 0%, transparent 65%);
    pointer-events:none;
}
.ap-stat-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 18px 52px rgba(0,0,0,.4);
    border-color: var(--ap-border2);
}
.ap-stat-card-top {
    display: flex; justify-content: space-between; align-items: flex-start;
    margin-bottom: 16px;
}
.ap-stat-label {
    font-size: 13px; font-weight: 700; color: var(--ap-text2);
    text-transform: uppercase; letter-spacing: .8px;
}
.ap-stat-icon { font-size: 26px; animation: apFloat 3.5s ease-in-out infinite; }
.ap-stat-number {
    font-size: 52px; font-weight: 700; line-height: 1;
    margin-bottom: 8px;
}
.ap-stat-sub { font-size: 15px; color: var(--ap-text2); }
.ap-stat-bar {
    height: 4px; border-radius: 4px;
    background: var(--ap-border); margin-top: 16px; overflow: hidden;
}
.ap-stat-bar-fill {
    height: 100%; border-radius: 4px;
    background: linear-gradient(90deg, var(--ap-blue), var(--ap-teal));
    width: 0; transition: width 1.3s cubic-bezier(.16,1,.3,1) .5s;
}

/* Ring */
.ap-ring-wrap { display: flex; align-items: center; gap: 16px; }
.ap-ring { position: relative; width: 66px; height: 66px; flex-shrink: 0; }
.ap-ring svg { transform: rotate(-90deg); }
.ap-ring-pct {
    position: absolute; inset: 0;
    display: flex; align-items: center; justify-content: center;
    font-family: var(--ap-mono); font-size: 12px; font-weight: 700;
    color: var(--ap-teal);
}
.ap-ring circle { transition: stroke-dashoffset 1.5s cubic-bezier(.16,1,.3,1) .6s; }

/* ── Main Layout ────────────────────────────────── */
.ap-layout {
    display: grid;
    grid-template-columns: 1fr 360px;
    gap: 28px; align-items: start;
}
@media(max-width:1200px) { .ap-layout { grid-template-columns: 1fr; } }

/* ── Card Shell ─────────────────────────────────── */
.ap-card {
    background: var(--ap-glass);
    border: 1px solid var(--ap-border);
    border-radius: 20px; overflow: hidden;
    box-shadow: 0 4px 32px rgba(0,0,0,.3);
    animation: apFadeUp .4s ease both;
}
.ap-card-head {
    display: flex; align-items: center; justify-content: space-between;
    padding: 26px 30px; border-bottom: 1px solid var(--ap-border);
    background: rgba(0,0,0,.15);
}
.ap-card-head-left { display: flex; align-items: center; gap: 16px; }
.ap-card-head-icon {
    width: 48px; height: 48px; border-radius: 13px; flex-shrink: 0;
    display: flex; align-items: center; justify-content: center; font-size: 22px;
    background: var(--chi-bg, rgba(59,158,255,.14));
    box-shadow: 0 0 16px var(--chi-glow, rgba(59,158,255,.2));
}
.ap-card-head-title {
    font-size: 22px; font-weight: 700; color: var(--ap-text1); letter-spacing: -.2px;
}
.ap-card-head-sub { font-size: 15px; color: var(--ap-text2); margin-top: 3px; }

/* ── Appointment Items ──────────────────────────── */
.ap-appt-list { display: flex; flex-direction: column; }
.ap-appt-item {
    display: grid;
    grid-template-columns: 84px 1fr auto auto;
    gap: 0 22px; align-items: center;
    padding: 28px 30px; min-height: 120px;
    border-bottom: 1px solid var(--ap-border);
    transition: background .2s;
}
.ap-appt-item:last-child { border-bottom: none; }
.ap-appt-item:hover { background: rgba(255,255,255,.03); }
.ap-appt-item:hover .ap-date-badge { transform: scale(1.04); border-color: var(--ap-border2); }

/* Date badge */
.ap-date-badge {
    width: 76px; height: 76px; border-radius: 16px; flex-shrink: 0;
    background: rgba(0,0,0,.2); border: 1px solid var(--ap-border);
    display: flex; flex-direction: column; align-items: center; justify-content: center;
    gap: 2px; transition: all .22s;
}
.ap-date-badge .adb-month {
    font-size: 12px; font-weight: 700; text-transform: uppercase;
    letter-spacing: .7px; color: var(--ap-blue);
}
.ap-date-badge .adb-day {
    font-size: 30px; font-weight: 700; color: var(--ap-text1); line-height: 1;
}

/* Info */
.ap-appt-info { padding: 2px 0; }
.ap-appt-doctor {
    font-size: 20px; font-weight: 700; color: var(--ap-text1);
    margin-bottom: 5px; letter-spacing: -.1px;
}
.ap-appt-specialty {
    font-size: 15px; color: var(--ap-teal); margin-bottom: 12px; font-weight: 500;
}
.ap-appt-meta { display: flex; flex-wrap: wrap; gap: 8px; }
.ap-meta-chip {
    display: inline-flex; align-items: center; gap: 6px;
    background: rgba(255,255,255,.05); border: 1px solid var(--ap-border);
    padding: 5px 12px; border-radius: 8px; font-size: 14px; color: var(--ap-text2);
}

.ap-appt-actions { display: flex; gap: 8px; align-items: center; flex-shrink: 0; }

/* ── Table ──────────────────────────────────────── */
.ap-table-wrap { overflow-x: auto; }
.ap-table { width: 100%; border-collapse: collapse; }
.ap-table th {
    text-align: left; padding: 18px 26px;
    font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: .8px;
    color: var(--ap-text2); border-bottom: 1px solid var(--ap-border);
    background: rgba(0,0,0,.2); white-space: nowrap;
}
.ap-table td {
    padding: 20px 26px; border-bottom: 1px solid var(--ap-border);
    font-size: 15px; color: var(--ap-text1); vertical-align: middle;
}
.ap-table tr:last-child td { border-bottom: none; }
.ap-table tbody tr { transition: background .15s; }
.ap-table tbody tr:hover td { background: rgba(255,255,255,.03); }
.ap-td-primary { font-weight: 700; font-size: 16px; }
.ap-td-muted { color: var(--ap-text2); font-size: 14px; }
.ap-td-actions { display: flex; gap: 8px; align-items: center; }

/* ── Empty State ────────────────────────────────── */
.ap-empty {
    display: flex; flex-direction: column; align-items: center; justify-content: center;
    padding: 90px 40px; gap: 20px; text-align: center;
}
.ap-empty-icon { font-size: 64px; opacity: .4; animation: apFloat 3s ease-in-out infinite; }
.ap-empty-title { font-size: 26px; font-weight: 700; color: var(--ap-text1); }
.ap-empty-sub { font-size: 16px; color: var(--ap-text2); max-width: 380px; line-height: 1.65; }

/* ── Section Title ──────────────────────────────── */
.ap-section-title {
    font-size: 28px; font-weight: 700; color: var(--ap-text1);
    letter-spacing: -.3px;
    display: flex; align-items: center; gap: 12px;
    margin: 48px 0 22px;
}
.ap-section-title::after {
    content: ''; flex: 1; height: 1px;
    background: linear-gradient(90deg, var(--ap-border2), transparent);
    margin-left: 8px;
}

/* ── Sidebar ────────────────────────────────────── */
.ap-sidebar { display: flex; flex-direction: column; gap: 22px; position: sticky; top: 24px; }

/* Timeline */
.ap-timeline { display: flex; flex-direction: column; }
.ap-tl-item {
    display: flex; gap: 16px; padding: 20px 26px;
    border-bottom: 1px solid var(--ap-border);
    transition: background .2s; position: relative;
    animation: apSlideIn .4s ease both;
}
.ap-tl-item:last-child { border-bottom: none; }
.ap-tl-item:hover { background: rgba(255,255,255,.03); }
.ap-tl-item::before {
    content: ''; position: absolute; left: 54px; top: 0; bottom: 0; width: 1px;
    background: linear-gradient(to bottom, transparent, var(--ap-border), transparent);
    pointer-events: none;
}
.ap-tl-time {
    width: 32px; flex-shrink: 0; text-align: right;
    font-family: var(--ap-mono); font-size: 12px;
    color: var(--ap-blue); line-height: 1.35; padding-top: 2px;
}
.ap-tl-dot {
    width: 12px; height: 12px; border-radius: 50%;
    background: var(--ap-blue); flex-shrink: 0; margin-top: 3px;
    box-shadow: 0 0 10px var(--ap-blue-glow);
    position: relative; z-index: 1;
    animation: apGlow 2.5s ease-in-out infinite;
}
.ap-tl-doctor   { font-size: 15px; font-weight: 600; color: var(--ap-text1); }
.ap-tl-specialty{ font-size: 13px; color: var(--ap-text2); margin-top: 3px; }

/* Mini Calendar */
.ap-cal { padding: 24px 26px; }
.ap-cal-header {
    display: flex; align-items: center; justify-content: space-between; margin-bottom: 18px;
}
.ap-cal-month { font-size: 18px; font-weight: 700; color: var(--ap-text1); }
.ap-cal-grid { display: grid; grid-template-columns: repeat(7,1fr); gap: 3px; }
.ap-cal-dow {
    text-align: center; font-size: 11px; font-weight: 700;
    text-transform: uppercase; color: var(--ap-text2); padding: 6px 0;
}
.ap-cal-day {
    text-align: center; font-size: 14px; padding: 7px 2px; border-radius: 8px;
    color: var(--ap-text2); cursor: default; transition: background .15s;
}
.ap-cal-day.today {
    background: rgba(59,158,255,.2); color: var(--ap-blue);
    font-weight: 700; box-shadow: 0 0 12px rgba(59,158,255,.15);
}
.ap-cal-day.has-appt { color: var(--ap-text1); font-weight: 600; position: relative; }
.ap-cal-day.has-appt::after {
    content: ''; position: absolute; bottom: 2px; left: 50%; transform: translateX(-50%);
    width: 4px; height: 4px; border-radius: 50%; background: var(--ap-teal);
}

/* Sidebar stat rows */
.ap-stat-row {
    display: flex; justify-content: space-between; align-items: center;
    padding: 16px 26px; border-bottom: 1px solid var(--ap-border); font-size: 15px;
}
.ap-stat-row:last-child { border-bottom: none; }
.ap-stat-row-label { color: var(--ap-text2); }
.ap-stat-row-val {
    font-family: var(--ap-mono); font-size: 19px;
    font-weight: 700; color: var(--ap-text1);
}

/* ── Responsive ─────────────────────────────────── */
@media(max-width:768px) {
    .ap-header { flex-direction: column; align-items: flex-start; }
    .ap-page-title { font-size: 36px; }
    .ap-stats-grid { grid-template-columns: repeat(2,1fr); }
    .ap-appt-item { grid-template-columns: 72px 1fr; }
    .ap-appt-item .ap-status,
    .ap-appt-item .ap-appt-actions { grid-column: 2; }
}
@media(max-width:480px) {
    .ap-stats-grid { grid-template-columns: 1fr; }
    .ap-page-title { font-size: 30px; }
}
</style>

<div class="ap-module">

<?php if (!empty($flash)): ?>
    <div class="ap-flash">✅ <?= htmlspecialchars($flash) ?></div>
<?php endif; ?>

<!-- ══ Page Header ══════════════════════════════════ -->
<div class="ap-header">
    <div class="ap-header-left">
        <div class="ap-page-icon">🗓️</div>
        <div>
            <div class="ap-page-title">Appointments</div>
            <div class="ap-page-sub">Track, manage, and organize your healthcare appointments efficiently.</div>
            <div class="ap-count-pill">🗓️ <?= $totalAppts ?> appointment<?= $totalAppts !== 1 ? 's' : '' ?> total</div>
        </div>
    </div>
    <div class="ap-toolbar">
        <div class="ap-search">
            <span style="font-size:18px;opacity:.45">🔍</span>
            <input type="text" placeholder="Search appointments…" id="ap-search-input">
        </div>
        <select class="ap-filter-select" id="ap-status-filter">
            <option value="">All Status</option>
            <option value="Scheduled">Scheduled</option>
            <option value="Completed">Completed</option>
            <option value="Cancelled">Cancelled</option>
        </select>
        <a href="index.php?page=appointments-create" class="ap-btn ap-btn-primary">➕ Schedule Appointment</a>
    </div>
</div>

<!-- ══ Stat Cards ═══════════════════════════════════ -->
<div class="ap-stats-grid">

    <div class="ap-stat-card" style="--sc-glow:rgba(59,158,255,.08);animation-delay:.05s">
        <div class="ap-stat-card-top">
            <div class="ap-stat-label">Upcoming</div>
            <div class="ap-stat-icon">🗓️</div>
        </div>
        <div class="ap-stat-number" style="color:var(--ap-blue)"
             data-count="<?= $scheduledCount ?>"><?= $scheduledCount ?></div>
        <div class="ap-stat-sub">Scheduled visits</div>
    </div>

    <div class="ap-stat-card" style="--sc-glow:rgba(52,211,153,.08);animation-delay:.10s">
        <div class="ap-stat-card-top">
            <div class="ap-stat-label">Completed</div>
            <div class="ap-stat-icon">✅</div>
        </div>
        <div class="ap-stat-number" style="color:var(--ap-green)"
             data-count="<?= $completedCount ?>"><?= $completedCount ?></div>
        <div class="ap-stat-sub"><?= $completionRate ?>% completion rate</div>
        <div class="ap-stat-bar">
            <div class="ap-stat-bar-fill" data-w="<?= $completionRate ?>"></div>
        </div>
    </div>

    <div class="ap-stat-card" style="--sc-glow:rgba(251,191,36,.08);animation-delay:.15s">
        <div class="ap-stat-card-top">
            <div class="ap-stat-label">Today</div>
            <div class="ap-stat-icon">📅</div>
        </div>
        <div class="ap-stat-number" style="color:var(--ap-amber)"
             data-count="<?= $todayCount ?>"><?= $todayCount ?></div>
        <div class="ap-stat-sub"><?= date('M j, Y') ?></div>
    </div>

    <div class="ap-stat-card" style="--sc-glow:rgba(167,139,250,.08);animation-delay:.20s">
        <div class="ap-stat-card-top">
            <div class="ap-stat-label">This Week</div>
            <div class="ap-stat-icon">📆</div>
        </div>
        <div class="ap-stat-number" style="color:var(--ap-purple)"
             data-count="<?= $weekCount ?>"><?= $weekCount ?></div>
        <div class="ap-stat-sub">Mon – Sun</div>
    </div>

    <div class="ap-stat-card" style="--sc-glow:rgba(0,212,170,.08);animation-delay:.25s">
        <div class="ap-stat-card-top">
            <div class="ap-stat-label">Completion</div>
            <div class="ap-stat-icon">📊</div>
        </div>
        <div class="ap-ring-wrap">
            <?php $circ = round(2*M_PI*28,1); $off = round($circ*(1-$completionRate/100),1); ?>
            <div class="ap-ring">
                <svg width="66" height="66" viewBox="0 0 66 66">
                    <circle cx="33" cy="33" r="28" fill="none"
                            stroke="rgba(255,255,255,.07)" stroke-width="5"/>
                    <circle cx="33" cy="33" r="28" fill="none"
                            stroke="var(--ap-teal)" stroke-width="5"
                            stroke-dasharray="<?= $circ ?>"
                            stroke-dashoffset="<?= $circ ?>"
                            data-dashoffset="<?= $off ?>"
                            stroke-linecap="round"
                            class="ap-ring-circle"/>
                </svg>
                <div class="ap-ring-pct"><?= $completionRate ?>%</div>
            </div>
            <div>
                <div style="font-size:42px;font-weight:700;color:var(--ap-teal);line-height:1"
                     data-count="<?= $completionRate ?>"><?= $completionRate ?></div>
                <div style="font-size:15px;color:var(--ap-text2);margin-top:4px">% Rate</div>
            </div>
        </div>
    </div>

    <div class="ap-stat-card" style="--sc-glow:rgba(251,191,36,.08);animation-delay:.30s">
        <div class="ap-stat-card-top">
            <div class="ap-stat-label">Top Specialty</div>
            <div class="ap-stat-icon">👨‍⚕️</div>
        </div>
        <div style="font-size:20px;font-weight:700;color:var(--ap-text1);line-height:1.3;margin-bottom:8px">
            <?= htmlspecialchars($topSpecialty) ?>
        </div>
        <div class="ap-stat-sub"><?= $topSpecialtyCount ?> visit<?= $topSpecialtyCount !== 1 ? 's' : '' ?></div>
    </div>

</div>

<!-- ══ Main Two-Col Layout ══════════════════════════ -->
<div class="ap-layout">
<div style="display:flex;flex-direction:column;gap:24px;">

    <?php if (empty($appointments)): ?>
    <div class="ap-card">
        <div class="ap-empty">
            <div class="ap-empty-icon">🗓️</div>
            <div class="ap-empty-title">No appointments yet</div>
            <div class="ap-empty-sub">Schedule your first appointment to start tracking your healthcare visits.</div>
            <a href="index.php?page=appointments-create" class="ap-btn ap-btn-primary" style="margin-top:12px">➕ Schedule Now</a>
        </div>
    </div>

    <?php else: ?>

    <!-- Upcoming Appointments -->
    <?php if (!empty($upcoming)): ?>
    <div class="ap-card" style="animation-delay:.1s">
        <div class="ap-card-head">
            <div class="ap-card-head-left">
                <div class="ap-card-head-icon" style="--chi-bg:rgba(59,158,255,.14);--chi-glow:rgba(59,158,255,.2)">🗓️</div>
                <div>
                    <div class="ap-card-head-title">Upcoming Appointments</div>
                    <div class="ap-card-head-sub"><?= $scheduledCount ?> scheduled visit<?= $scheduledCount !== 1 ? 's' : '' ?></div>
                </div>
            </div>
        </div>
        <div class="ap-appt-list" id="ap-upcoming-list">
        <?php foreach ($upcoming as $i => $appt):
            $d = new DateTime($appt['date']); ?>
        <div class="ap-appt-item"
             data-doctor="<?= strtolower(htmlspecialchars($appt['doctor'])) ?>"
             data-status="<?= $appt['status'] ?>"
             style="animation: apFadeUp .35s ease <?= .05*$i ?>s both;">
            <div class="ap-date-badge">
                <div class="adb-month"><?= $d->format('M') ?></div>
                <div class="adb-day"><?= $d->format('d') ?></div>
            </div>
            <div class="ap-appt-info">
                <div class="ap-appt-doctor"><?= htmlspecialchars($appt['doctor']) ?></div>
                <div class="ap-appt-specialty"><?= htmlspecialchars($appt['specialty']) ?></div>
                <div class="ap-appt-meta">
                    <span class="ap-meta-chip">🕐 <?= date('g:i A', strtotime($appt['time'])) ?></span>
                    <?php if (!empty($appt['location'])): ?>
                        <span class="ap-meta-chip">📍 <?= htmlspecialchars($appt['location']) ?></span>
                    <?php endif; ?>
                    <span class="ap-meta-chip">🏷️ <?= htmlspecialchars($appt['type']) ?></span>
                </div>
            </div>
            <div class="ap-status ap-s-scheduled">
                <span class="ap-status-dot"></span> Scheduled
            </div>
            <div class="ap-appt-actions">
                <a href="index.php?page=appointments-edit&id=<?= $appt['id'] ?>" class="ap-action-btn ap-action-edit">
                    ✏️<span class="ap-tooltip">Edit</span>
                </a>
                <a href="index.php?page=appointments-delete&id=<?= $appt['id'] ?>" class="ap-action-btn ap-action-del"
                   data-confirm="Cancel appointment with <?= htmlspecialchars($appt['doctor']) ?>?">
                    🗑️<span class="ap-tooltip">Delete</span>
                </a>
            </div>
        </div>
        <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>

    <!-- All Appointments Table -->
    <div class="ap-card" style="animation-delay:.15s">
        <div class="ap-card-head">
            <div class="ap-card-head-left">
                <div class="ap-card-head-icon" style="--chi-bg:rgba(167,139,250,.14);--chi-glow:rgba(167,139,250,.2)">📋</div>
                <div>
                    <div class="ap-card-head-title">All Appointments</div>
                    <div class="ap-card-head-sub"><?= $totalAppts ?> total record<?= $totalAppts !== 1 ? 's' : '' ?></div>
                </div>
            </div>
        </div>
        <div class="ap-table-wrap">
            <table class="ap-table" id="ap-all-table">
                <thead>
                    <tr>
                        <th>Date & Time</th>
                        <th>Doctor</th>
                        <th>Specialty</th>
                        <th>Type</th>
                        <th>Location</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($appointments as $appt):
                    $sc = match($appt['status']) {
                        'Scheduled' => 'ap-s-scheduled',
                        'Completed' => 'ap-s-completed',
                        'Cancelled' => 'ap-s-cancelled',
                        default     => 'ap-s-scheduled',
                    };
                ?>
                <tr data-doctor="<?= strtolower(htmlspecialchars($appt['doctor'])) ?>"
                    data-status="<?= $appt['status'] ?>">
                    <td>
                        <div class="ap-td-primary"><?= date('M d, Y', strtotime($appt['date'])) ?></div>
                        <div class="ap-td-muted"><?= date('g:i A', strtotime($appt['time'])) ?></div>
                    </td>
                    <td class="ap-td-primary"><?= htmlspecialchars($appt['doctor']) ?></td>
                    <td class="ap-td-muted"><?= htmlspecialchars($appt['specialty']) ?></td>
                    <td class="ap-td-muted"><?= htmlspecialchars($appt['type']) ?></td>
                    <td class="ap-td-muted"><?= htmlspecialchars($appt['location'] ?: '—') ?></td>
                    <td>
                        <span class="ap-status <?= $sc ?>">
                            <span class="ap-status-dot"></span>
                            <?= htmlspecialchars($appt['status']) ?>
                        </span>
                    </td>
                    <td>
                        <div class="ap-td-actions">
                            <a href="index.php?page=appointments-edit&id=<?= $appt['id'] ?>" class="ap-action-btn ap-action-edit">
                                ✏️<span class="ap-tooltip">Edit</span>
                            </a>
                            <a href="index.php?page=appointments-delete&id=<?= $appt['id'] ?>" class="ap-action-btn ap-action-del"
                               data-confirm="Delete this appointment?">
                                🗑️<span class="ap-tooltip">Delete</span>
                            </a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php endif; ?>

</div><!-- /left col -->

<!-- ── Sidebar ──────────────────────────────────── -->
<div class="ap-sidebar">

    <!-- Upcoming Schedule Timeline -->
    <div class="ap-card" style="animation-delay:.20s">
        <div class="ap-card-head">
            <div class="ap-card-head-left">
                <div class="ap-card-head-icon" style="--chi-bg:rgba(0,212,170,.14);--chi-glow:rgba(0,212,170,.2)">⏱️</div>
                <div>
                    <div class="ap-card-head-title">Upcoming Schedule</div>
                    <div class="ap-card-head-sub">Next visits</div>
                </div>
            </div>
        </div>
        <?php if (empty($timelineAppts)): ?>
            <div style="padding:32px 26px;text-align:center;font-size:16px;color:var(--ap-text2)">
                No upcoming appointments
            </div>
        <?php else: ?>
        <div class="ap-timeline">
            <?php foreach ($timelineAppts as $i => $appt): ?>
            <div class="ap-tl-item" style="animation-delay:<?= .22+$i*.05 ?>s">
                <div class="ap-tl-time">
                    <?= date('g:i', strtotime($appt['time'])) ?><br>
                    <?= date('A', strtotime($appt['time'])) ?>
                </div>
                <div class="ap-tl-dot"></div>
                <div>
                    <div class="ap-tl-doctor"><?= htmlspecialchars($appt['doctor']) ?></div>
                    <div class="ap-tl-specialty">
                        <?= htmlspecialchars($appt['specialty']) ?> · <?= date('M j', strtotime($appt['date'])) ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>

    <!-- Mini Calendar -->
    <div class="ap-card" style="animation-delay:.28s">
        <div class="ap-card-head">
            <div class="ap-card-head-left">
                <div class="ap-card-head-icon" style="--chi-bg:rgba(251,191,36,.12);--chi-glow:rgba(251,191,36,.18)">📅</div>
                <div><div class="ap-card-head-title">Calendar</div></div>
            </div>
        </div>
        <div class="ap-cal">
        <?php
            $now         = new DateTime();
            $calYear     = (int)$now->format('Y');
            $calMonth    = (int)$now->format('m');
            $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $calMonth, $calYear);
            $firstDow    = (int)(new DateTime("$calYear-$calMonth-01"))->format('w');
            $apptDays    = [];
            foreach ($appointments as $a) {
                $ad = new DateTime($a['date']);
                if ((int)$ad->format('Y') === $calYear && (int)$ad->format('m') === $calMonth) {
                    $apptDays[(int)$ad->format('j')] = true;
                }
            }
            $todayDay = (int)$now->format('j');
        ?>
            <div class="ap-cal-header">
                <div class="ap-cal-month"><?= $now->format('F Y') ?></div>
                <div style="font-size:13px;color:var(--ap-blue);font-family:var(--ap-mono)">
                    <?= count($apptDays) ?> appts
                </div>
            </div>
            <div class="ap-cal-grid">
                <?php foreach(['S','M','T','W','T','F','S'] as $dow): ?>
                    <div class="ap-cal-dow"><?= $dow ?></div>
                <?php endforeach; ?>
                <?php for($b=0;$b<$firstDow;$b++): ?><div></div><?php endfor; ?>
                <?php for($d=1;$d<=$daysInMonth;$d++):
                    $cls = '';
                    if ($d === $todayDay) $cls .= ' today';
                    if (isset($apptDays[$d])) $cls .= ' has-appt';
                ?>
                    <div class="ap-cal-day<?= $cls ?>"><?= $d ?></div>
                <?php endfor; ?>
            </div>
        </div>
    </div>

    <!-- Statistics -->
    <div class="ap-card" style="animation-delay:.34s">
        <div class="ap-card-head">
            <div class="ap-card-head-left">
                <div class="ap-card-head-icon" style="--chi-bg:rgba(167,139,250,.14);--chi-glow:rgba(167,139,250,.2)">📊</div>
                <div><div class="ap-card-head-title">Statistics</div></div>
            </div>
        </div>
        <div class="ap-stat-row"><span class="ap-stat-row-label">Total appointments</span><span class="ap-stat-row-val"><?= $totalAppts ?></span></div>
        <div class="ap-stat-row"><span class="ap-stat-row-label">Upcoming</span><span class="ap-stat-row-val" style="color:var(--ap-blue)"><?= $scheduledCount ?></span></div>
        <div class="ap-stat-row"><span class="ap-stat-row-label">Completed</span><span class="ap-stat-row-val" style="color:var(--ap-green)"><?= $completedCount ?></span></div>
        <div class="ap-stat-row"><span class="ap-stat-row-label">Cancelled</span><span class="ap-stat-row-val" style="color:var(--ap-red)"><?= $cancelledCount ?></span></div>
        <div class="ap-stat-row"><span class="ap-stat-row-label">Completion rate</span><span class="ap-stat-row-val" style="color:var(--ap-teal)"><?= $completionRate ?>%</span></div>
        <div class="ap-stat-row"><span class="ap-stat-row-label">Top specialty</span><span class="ap-stat-row-val" style="color:var(--ap-amber);font-size:15px"><?= htmlspecialchars($topSpecialty) ?></span></div>
    </div>

</div><!-- /sidebar -->
</div><!-- /layout -->
</div><!-- /.ap-module -->

<script>
/* ── Bar fills ───────────────────────── */
window.addEventListener('load', function() {

    document.querySelectorAll('.ap-stat-bar-fill').forEach(function(el) {
        var w = el.dataset.w || '0';
        el.style.width = '0';
        setTimeout(function() { el.style.width = w + '%'; }, 350);
    });

    /* SVG ring draw */
    document.querySelectorAll('.ap-ring-circle').forEach(function(el) {
        var target = el.dataset.dashoffset || '0';
        var full   = parseFloat(el.getAttribute('stroke-dasharray')) || 175;
        el.setAttribute('stroke-dashoffset', full);
        setTimeout(function() {
            el.style.transition = 'stroke-dashoffset 1.5s cubic-bezier(.16,1,.3,1)';
            el.setAttribute('stroke-dashoffset', target);
        }, 400);
    });

    /* Count-up numbers */
    document.querySelectorAll('[data-count]').forEach(function(el) {
        var target = parseInt(el.dataset.count, 10) || 0;
        if (target === 0) return;
        var start = 0, dur = 900, step = 16;
        var inc = target / (dur / step);
        var t = setInterval(function() {
            start += inc;
            if (start >= target) { start = target; clearInterval(t); }
            el.textContent = Math.round(start);
        }, step);
    });

    /* Button ripple */
    document.querySelectorAll('.ap-btn-primary').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            var r = document.createElement('span');
            r.style.cssText = [
                'position:absolute','border-radius:50%',
                'width:20px','height:20px',
                'background:rgba(255,255,255,.3)',
                'transform:scale(0)','pointer-events:none',
                'animation:apRipple .5s linear',
                'left:'+(e.offsetX-10)+'px',
                'top:'+(e.offsetY-10)+'px'
            ].join(';');
            this.appendChild(r);
            setTimeout(function() { r.remove(); }, 550);
        });

        /* Mouse-position shimmer */
        btn.addEventListener('mousemove', function(e) {
            var rect = btn.getBoundingClientRect();
            btn.style.setProperty('--rx', ((e.clientX-rect.left)/rect.width*100)+'%');
            btn.style.setProperty('--ry', ((e.clientY-rect.top)/rect.height*100)+'%');
        });
    });
});

/* ── Search + filter ─────────────────── */
function apFilter() {
    var q  = (document.getElementById('ap-search-input')?.value || '').toLowerCase();
    var st = document.getElementById('ap-status-filter')?.value || '';
    ['#ap-upcoming-list .ap-appt-item', '#ap-all-table tbody tr'].forEach(function(sel) {
        document.querySelectorAll(sel).forEach(function(row) {
            var doc    = row.dataset.doctor || '';
            var status = row.dataset.status || '';
            var show   = (!q || doc.includes(q)) && (!st || status === st);
            row.style.display = show ? '' : 'none';
        });
    });
}
document.getElementById('ap-search-input')?.addEventListener('input', apFilter);
document.getElementById('ap-status-filter')?.addEventListener('change', apFilter);
</script>

<?php require_once APP_PATH . '/views/shared/footer.php'; ?>