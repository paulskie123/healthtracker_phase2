<?php
$pageTitle = 'Reminders';
$activePage = 'reminders';
require_once APP_PATH . '/views/shared/header.php';

$reminders = [
    ['icon' => '💓', 'text' => 'Take blood pressure reading',              'time' => '8:00 AM',  'category' => 'Health Monitoring', 'freq' => 'Daily',   'priority' => 'High',   'status' => 'upcoming'],
    ['icon' => '💊', 'text' => 'Morning medication (Lisinopril, Vitamin D)', 'time' => '9:00 AM', 'category' => 'Medications',       'freq' => 'Daily',   'priority' => 'High',   'status' => 'completed'],
    ['icon' => '🍽️', 'text' => 'Log breakfast & blood sugar',               'time' => '9:30 AM', 'category' => 'Nutrition',         'freq' => 'Daily',   'priority' => 'Medium', 'status' => 'completed'],
    ['icon' => '🔔', 'text' => 'Weekly check-up reminder',                  'time' => 'Sat 10:00 AM', 'category' => 'Appointments', 'freq' => 'Weekly',  'priority' => 'Medium', 'status' => 'upcoming'],
    ['icon' => '🍏', 'text' => 'Log dinner & blood sugar',                  'time' => '7:00 PM',  'category' => 'Nutrition',         'freq' => 'Daily',   'priority' => 'Medium', 'status' => 'pending'],
    ['icon' => '💊', 'text' => 'Evening medication (Metformin)',             'time' => '8:00 PM',  'category' => 'Medications',       'freq' => 'Daily',   'priority' => 'High',   'status' => 'pending'],
    ['icon' => '🌙', 'text' => 'Bedtime medication (Atorvastatin)',          'time' => '10:30 PM', 'category' => 'Medications',       'freq' => 'Daily',   'priority' => 'High',   'status' => 'pending'],
];

$totalCount     = count($reminders);
$completedCount = count(array_filter($reminders, fn($r) => $r['status'] === 'completed'));
$pendingCount   = count(array_filter($reminders, fn($r) => $r['status'] === 'pending'));
$upcomingCount  = count(array_filter($reminders, fn($r) => $r['status'] === 'upcoming'));
$medCount       = count(array_filter($reminders, fn($r) => $r['category'] === 'Medications'));
$healthCount    = count(array_filter($reminders, fn($r) => $r['category'] === 'Health Monitoring'));
$completePct    = $totalCount > 0 ? round($completedCount / $totalCount * 100) : 0;

$grouped = [];
foreach ($reminders as $r) {
    $grouped[$r['category']][] = $r;
}

$categoryMeta = [
    'Medications'       => ['icon' => '💊', 'color' => '#3b9eff', 'glow' => 'rgba(59,158,255,.2)'],
    'Health Monitoring' => ['icon' => '❤️', 'color' => '#f87171', 'glow' => 'rgba(248,113,113,.2)'],
    'Nutrition'         => ['icon' => '🍎', 'color' => '#34d399', 'glow' => 'rgba(52,211,153,.2)'],
    'Appointments'      => ['icon' => '🏥', 'color' => '#a78bfa', 'glow' => 'rgba(167,139,250,.2)'],
    'Exercise'          => ['icon' => '🏃', 'color' => '#fb923c', 'glow' => 'rgba(251,146,60,.2)'],
    'Wellness'          => ['icon' => '😴', 'color' => '#4ecdc4', 'glow' => 'rgba(78,205,196,.2)'],
];
?>

<style>
@import url('https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;1,9..40,300&family=Space+Mono:wght@400;700&display=swap');

/* ============================================================
   REMINDERS PAGE  |  Matched to Medications Page Scale
   Premium Animations · Consistent Hierarchy
   ============================================================ */

:root {
    --rm-teal:        #00d4aa;
    --rm-teal-dim:    rgba(0,212,170,0.12);
    --rm-teal-glow:   rgba(0,212,170,0.28);
    --rm-blue:        #3b9eff;
    --rm-blue-dim:    rgba(59,158,255,0.12);
    --rm-blue-glow:   rgba(59,158,255,0.28);
    --rm-orange:      #f97316;
    --rm-orange-dim:  rgba(249,115,22,0.12);
    --rm-orange-glow: rgba(249,115,22,0.28);
    --rm-red:         #f87171;
    --rm-red-dim:     rgba(248,113,113,0.12);
    --rm-green:       #34d399;
    --rm-green-dim:   rgba(52,211,153,0.12);
    --rm-amber:       #fbbf24;
    --rm-amber-dim:   rgba(251,191,36,0.12);
    --rm-amber-glow:  rgba(251,191,36,0.28);
    --rm-purple:      #a78bfa;
    --rm-purple-dim:  rgba(167,139,250,0.12);
    --rm-glass:       rgba(255,255,255,0.04);
    --rm-glass2:      rgba(255,255,255,0.07);
    --rm-border:      rgba(255,255,255,0.08);
    --rm-border2:     rgba(255,255,255,0.14);
    --rm-text1:       #e8f4f0;
    --rm-text2:       #8fa8b8;
    --rm-text3:       #3d5060;
    --rm-font:        'DM Sans', sans-serif;
    --rm-mono:        'Space Mono', monospace;
}

/* ── Keyframes ─────────────────────────────────── */
@keyframes rmFadeUp    { from{opacity:0;transform:translateY(18px)} to{opacity:1;transform:translateY(0)} }
@keyframes rmSlideIn   { from{opacity:0;transform:translateX(-12px)} to{opacity:1;transform:translateX(0)} }
@keyframes rmScaleIn   { from{opacity:0;transform:scale(.94)} to{opacity:1;transform:scale(1)} }
@keyframes rmDotPulse  { 0%,100%{opacity:1;transform:scale(1)} 50%{opacity:.4;transform:scale(.85)} }
@keyframes rmGlow      { 0%,100%{box-shadow:0 0 12px var(--rm-teal-glow)} 50%{box-shadow:0 0 28px var(--rm-teal-glow),0 0 48px rgba(0,212,170,.12)} }
@keyframes rmFloat     { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-5px)} }
@keyframes rmShimmer   { 0%{background-position:-200% 0} 100%{background-position:200% 0} }
@keyframes rmBarFill   { from{width:0} to{width:var(--bar-w)} }
@keyframes rmRingDraw  { from{stroke-dashoffset:var(--ring-full)} to{stroke-dashoffset:var(--ring-off)} }
@keyframes rmLineGrow  { from{height:0;opacity:0} to{height:100%;opacity:1} }
@keyframes rmBorderSpin{ 0%{background-position:0% 50%} 100%{background-position:200% 50%} }
@keyframes rmCountUp   { from{opacity:0;transform:translateY(10px)} to{opacity:1;transform:translateY(0)} }
@keyframes rmRipple    { 0%{transform:scale(0);opacity:.5} 100%{transform:scale(3);opacity:0} }

/* ── Page Shell ────────────────────────────────── */
.rm-module {
    font-family: var(--rm-font);
    color: var(--rm-text1);
    max-width: 1400px;
    animation: rmFadeUp .45s ease both;
}

/* ── Flash ─────────────────────────────────────── */
.rm-flash {
    display: flex; align-items: center; gap: 12px;
    background: rgba(0,212,170,0.1); border: 1px solid rgba(0,212,170,0.3);
    border-radius: 14px; padding: 18px 24px;
    font-size: 15px; color: var(--rm-teal); margin-bottom: 32px;
    animation: rmFadeUp .35s ease both;
}

/* ── Page Header ───────────────────────────────── */
.rm-header {
    display: flex; align-items: center; justify-content: space-between;
    gap: 24px; flex-wrap: wrap; margin-bottom: 44px;
    animation: rmFadeUp .4s ease both;
}
.rm-header-left { display: flex; align-items: center; gap: 22px; }

.rm-page-icon {
    width: 68px; height: 68px; border-radius: 20px;
    background: linear-gradient(135deg, rgba(0,212,170,.18), rgba(59,158,255,.12));
    border: 1px solid rgba(0,212,170,.32);
    display: flex; align-items: center; justify-content: center;
    font-size: 34px; flex-shrink: 0;
    animation: rmFloat 4s ease-in-out infinite;
    box-shadow: 0 0 24px rgba(0,212,170,.15);
}

.rm-page-title {
    font-size: 52px; font-weight: 700; color: var(--rm-text1);
    letter-spacing: -1px; line-height: 1.1;
}
.rm-page-sub {
    font-size: 20px; color: var(--rm-text2);
    margin-top: 6px; line-height: 1.5; max-width: 560px;
}
.rm-count-pill {
    display: inline-flex; align-items: center; gap: 8px;
    background: var(--rm-teal-dim); border: 1px solid rgba(0,212,170,.28);
    border-radius: 22px; padding: 7px 16px;
    font-size: 14px; font-weight: 600; color: var(--rm-teal); margin-top: 10px;
}

/* ── Buttons ───────────────────────────────────── */
.rm-btn {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 14px 26px; border-radius: 11px;
    font-family: var(--rm-font); font-size: 15px; font-weight: 600;
    cursor: pointer; border: none; transition: all .22s;
    text-decoration: none; white-space: nowrap; position: relative; overflow: hidden;
}
.rm-btn-primary {
    background: linear-gradient(135deg, var(--rm-teal), #00b894);
    color: #0d1f1b;
    box-shadow: 0 4px 20px rgba(0,212,170,.25);
}
.rm-btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 0 36px var(--rm-teal-glow), 0 8px 24px rgba(0,0,0,.3);
}
.rm-btn-primary::after {
    content:''; position:absolute; inset:0; border-radius:11px;
    background:radial-gradient(circle at var(--rx,50%) var(--ry,50%), rgba(255,255,255,.3) 0%, transparent 60%);
    opacity:0; transition:opacity .3s;
}
.rm-btn-primary:hover::after { opacity:1; }
.rm-btn-ghost {
    background: var(--rm-glass); color: var(--rm-text2);
    border: 1px solid var(--rm-border);
}
.rm-btn-ghost:hover { background: var(--rm-glass2); color: var(--rm-text1); border-color: var(--rm-border2); }
.rm-btn-edit {
    background: var(--rm-blue-dim); color: var(--rm-blue);
    border: 1px solid rgba(59,158,255,.28);
    padding: 10px 16px; font-size: 14px; border-radius: 9px;
}
.rm-btn-edit:hover { background: rgba(59,158,255,.22); transform: translateY(-1px); }
.rm-btn-del {
    background: var(--rm-red-dim); color: var(--rm-red);
    border: 1px solid rgba(248,113,113,.28);
    padding: 10px 16px; font-size: 14px; border-radius: 9px;
}
.rm-btn-del:hover { background: rgba(248,113,113,.22); transform: translateY(-1px); }

/* Action icon buttons */
.rm-action-btn {
    width: 44px; height: 44px; border-radius: 11px;
    display: flex; align-items: center; justify-content: center;
    font-size: 17px; cursor: pointer;
    border: 1px solid var(--rm-border); background: transparent;
    transition: all .2s; position: relative; overflow: hidden;
}
.rm-action-btn:hover { transform: translateY(-2px); }
.rm-action-check:hover { background: rgba(52,211,153,.18); border-color: rgba(52,211,153,.4); box-shadow: 0 0 14px rgba(52,211,153,.2); }
.rm-action-edit:hover  { background: rgba(59,158,255,.18);  border-color: rgba(59,158,255,.4);  box-shadow: 0 0 14px rgba(59,158,255,.2); }
.rm-action-del:hover   { background: rgba(248,113,113,.18); border-color: rgba(248,113,113,.4); box-shadow: 0 0 14px rgba(248,113,113,.2); }
.rm-action-btn .rm-tip {
    position: absolute; bottom: calc(100% + 8px); left: 50%; transform: translateX(-50%);
    background: #1c2a38; border: 1px solid var(--rm-border2); border-radius: 7px;
    padding: 5px 11px; font-size: 12px; color: var(--rm-text2); white-space: nowrap;
    pointer-events: none; opacity: 0; transition: opacity .15s;
}
.rm-action-btn:hover .rm-tip { opacity: 1; }

/* ── Search / Toolbar ──────────────────────────── */
.rm-toolbar { display: flex; flex-wrap: wrap; gap: 12px; align-items: center; }
.rm-search {
    display: flex; align-items: center; gap: 10px;
    background: var(--rm-glass); border: 1px solid var(--rm-border);
    border-radius: 11px; padding: 12px 18px; transition: all .22s;
}
.rm-search:focus-within {
    border-color: rgba(0,212,170,.5);
    box-shadow: 0 0 0 3px rgba(0,212,170,.1), 0 0 20px rgba(0,212,170,.08);
    background: rgba(0,212,170,.04);
}
.rm-search input {
    background: none; border: none; outline: none;
    color: var(--rm-text1); font-family: var(--rm-font);
    font-size: 15px; width: 210px;
}
.rm-search input::placeholder { color: var(--rm-text2); }
.rm-select {
    background: var(--rm-glass); border: 1px solid var(--rm-border);
    border-radius: 11px; padding: 12px 18px;
    color: var(--rm-text2); font-family: var(--rm-font); font-size: 15px;
    outline: none; cursor: pointer; -webkit-appearance: none;
    transition: border-color .2s;
}
.rm-select:focus { border-color: rgba(0,212,170,.5); }

/* ── Status Badges ─────────────────────────────── */
.rm-badge {
    display: inline-flex; align-items: center; gap: 7px;
    padding: 7px 15px; border-radius: 22px;
    font-size: 13px; font-weight: 600; letter-spacing: .2px;
    white-space: nowrap;
}
.rm-badge-dot { width: 8px; height: 8px; border-radius: 50%; background: currentColor; }
.rm-badge-completed { background: rgba(52,211,153,.14); color: var(--rm-green); border: 1px solid rgba(52,211,153,.3); }
.rm-badge-pending   { background: var(--rm-amber-dim);  color: var(--rm-amber);  border: 1px solid rgba(251,191,36,.3); }
.rm-badge-upcoming  { background: var(--rm-blue-dim);   color: var(--rm-blue);   border: 1px solid rgba(59,158,255,.3); box-shadow: 0 0 12px rgba(59,158,255,.1); }
.rm-badge-completed .rm-badge-dot { animation: none; }
.rm-badge-upcoming .rm-badge-dot  { animation: rmDotPulse 2s ease-in-out infinite; }
.rm-badge-pending .rm-badge-dot   { animation: rmDotPulse 2.5s ease-in-out infinite; }

/* ── Stat Cards Grid ───────────────────────────── */
.rm-stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 20px; margin-bottom: 44px;
}
.rm-stat-card {
    background: var(--rm-glass);
    border: 1px solid var(--rm-border);
    border-radius: 18px; padding: 28px 26px;
    position: relative; overflow: hidden;
    transition: transform .22s, box-shadow .22s, border-color .22s;
    animation: rmScaleIn .4s ease both;
}
.rm-stat-card::before {
    content:''; position:absolute; inset:0;
    background: radial-gradient(ellipse at top right, var(--sc-glow, rgba(0,212,170,.07)) 0%, transparent 65%);
    pointer-events:none;
}
.rm-stat-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 18px 52px rgba(0,0,0,.4);
    border-color: var(--rm-border2);
}
.rm-stat-card-top {
    display: flex; justify-content: space-between; align-items: flex-start;
    margin-bottom: 16px;
}
.rm-stat-label {
    font-size: 13px; font-weight: 700; color: var(--rm-text2);
    text-transform: uppercase; letter-spacing: .8px;
}
.rm-stat-icon { font-size: 26px; animation: rmFloat 3.5s ease-in-out infinite; }
.rm-stat-number {
    font-size: 52px; font-weight: 700; line-height: 1;
    margin-bottom: 8px; font-family: var(--rm-font);
}
.rm-stat-sub { font-size: 15px; color: var(--rm-text2); }
.rm-stat-bar {
    height: 4px; border-radius: 4px;
    background: var(--rm-border); margin-top: 16px; overflow: hidden;
}
.rm-stat-bar-fill {
    height: 100%; border-radius: 4px;
    background: linear-gradient(90deg, var(--rm-teal), var(--rm-blue));
    width: 0; transition: width 1.3s cubic-bezier(.16,1,.3,1) .5s;
}

/* Ring in stat card */
.rm-ring-wrap { display: flex; align-items: center; gap: 16px; }
.rm-ring { position: relative; width: 66px; height: 66px; flex-shrink: 0; }
.rm-ring svg { transform: rotate(-90deg); }
.rm-ring-pct {
    position: absolute; inset: 0;
    display: flex; align-items: center; justify-content: center;
    font-family: var(--rm-mono); font-size: 12px; font-weight: 700;
    color: var(--rm-teal);
}
.rm-ring circle { transition: stroke-dashoffset 1.5s cubic-bezier(.16,1,.3,1) .6s; }

/* ── Main Layout ───────────────────────────────── */
.rm-layout {
    display: grid;
    grid-template-columns: 1fr 360px;
    gap: 28px; align-items: start;
}
@media(max-width:1200px) { .rm-layout { grid-template-columns: 1fr; } }

/* ── Card Shell ────────────────────────────────── */
.rm-card {
    background: var(--rm-glass);
    border: 1px solid var(--rm-border);
    border-radius: 20px; overflow: hidden;
    box-shadow: 0 4px 32px rgba(0,0,0,.3);
    animation: rmFadeUp .4s ease both;
}
.rm-card-head {
    display: flex; align-items: center; justify-content: space-between;
    padding: 26px 30px; border-bottom: 1px solid var(--rm-border);
    background: rgba(0,0,0,.15);
}
.rm-card-head-left { display: flex; align-items: center; gap: 16px; }
.rm-card-head-icon {
    width: 48px; height: 48px; border-radius: 13px; flex-shrink: 0;
    display: flex; align-items: center; justify-content: center; font-size: 22px;
    background: var(--chi-bg, rgba(0,212,170,.14));
    box-shadow: 0 0 16px var(--chi-glow, rgba(0,212,170,.2));
}
.rm-card-head-title {
    font-size: 22px; font-weight: 700; color: var(--rm-text1);
    letter-spacing: -.2px;
}
.rm-card-head-sub { font-size: 15px; color: var(--rm-text2); margin-top: 3px; }

/* ── Section Title ─────────────────────────────── */
.rm-section-title {
    font-size: 28px; font-weight: 700; color: var(--rm-text1);
    letter-spacing: -.3px;
    display: flex; align-items: center; gap: 12px;
    margin: 48px 0 22px;
    animation: rmFadeUp .4s ease both;
}
.rm-section-title::after {
    content: ''; flex: 1; height: 1px;
    background: linear-gradient(90deg, var(--rm-border2), transparent);
    margin-left: 8px;
}

/* ── Category sections ─────────────────────────── */
.rm-category { border-bottom: 1px solid var(--rm-border); }
.rm-category:last-child { border-bottom: none; }
.rm-cat-header {
    display: flex; align-items: center; gap: 16px;
    padding: 24px 30px; cursor: pointer;
    transition: background .2s; user-select: none;
}
.rm-cat-header:hover { background: rgba(255,255,255,.03); }
.rm-cat-icon {
    width: 50px; height: 50px; border-radius: 13px; flex-shrink: 0;
    display: flex; align-items: center; justify-content: center; font-size: 22px;
    background: var(--cat-bg, rgba(0,212,170,.12));
    box-shadow: 0 0 16px var(--cat-glow, rgba(0,212,170,.15));
    transition: transform .2s, box-shadow .2s;
}
.rm-cat-header:hover .rm-cat-icon { transform: scale(1.06); box-shadow: 0 0 22px var(--cat-glow, rgba(0,212,170,.25)); }
.rm-cat-name {
    font-size: 20px; font-weight: 700; color: var(--rm-text1);
    flex: 1; letter-spacing: -.1px;
}
.rm-cat-count {
    display: inline-flex; align-items: center;
    background: var(--rm-glass2); border: 1px solid var(--rm-border2);
    padding: 5px 15px; border-radius: 22px;
    font-family: var(--rm-mono); font-size: 13px; color: var(--rm-text2);
}
.rm-cat-chevron { font-size: 14px; color: var(--rm-text2); transition: transform .3s; margin-left: 10px; }
.rm-cat-header.open .rm-cat-chevron { transform: rotate(180deg); }
.rm-cat-body { display: none; }
.rm-cat-body.open { display: block; }

/* ── Reminder Rows ─────────────────────────────── */
.rm-row {
    display: grid;
    grid-template-columns: 70px 1fr auto auto;
    gap: 0 22px; align-items: center;
    padding: 26px 30px; min-height: 128px;
    border-top: 1px solid var(--rm-border);
    transition: background .2s, transform .2s;
    position: relative;
}
.rm-row:hover { background: rgba(255,255,255,.03); }
.rm-row:hover .rm-row-icon { transform: scale(1.08); }

.rm-row-icon {
    width: 66px; height: 66px; border-radius: 16px; flex-shrink: 0;
    background: var(--ri-bg, rgba(0,212,170,.1));
    border: 1px solid var(--ri-border, rgba(0,212,170,.2));
    display: flex; align-items: center; justify-content: center; font-size: 30px;
    transition: transform .22s, box-shadow .22s;
}
.rm-row:hover .rm-row-icon {
    box-shadow: 0 0 20px var(--ri-border, rgba(0,212,170,.25));
}

.rm-row-info {}
.rm-row-title {
    font-size: 20px; font-weight: 700; color: var(--rm-text1);
    margin-bottom: 8px; line-height: 1.3; letter-spacing: -.1px;
}
.rm-row-meta { display: flex; flex-wrap: wrap; gap: 8px; align-items: center; }
.rm-meta-chip {
    display: inline-flex; align-items: center; gap: 6px;
    background: rgba(255,255,255,.05); border: 1px solid var(--rm-border);
    padding: 5px 12px; border-radius: 8px; font-size: 14px; color: var(--rm-text2);
}

.rm-row-right {
    display: flex; flex-direction: column;
    align-items: flex-end; gap: 10px; flex-shrink: 0;
}
.rm-time-badge {
    font-family: var(--rm-mono); font-size: 20px; font-weight: 700;
    color: var(--rm-teal);
    background: rgba(0,212,170,.07); border: 1px solid rgba(0,212,170,.18);
    padding: 10px 18px; border-radius: 11px;
    text-align: center; white-space: nowrap; min-width: 120px;
}

.rm-row-actions { display: flex; gap: 8px; align-items: center; flex-shrink: 0; }

/* ── Add Reminder Form ─────────────────────────── */
.rm-add-wrap {
    padding: 30px; border-top: 1px solid var(--rm-border);
    background: rgba(0,212,170,.025);
    animation: rmFadeUp .3s ease both;
}
.rm-form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 22px; }
@media(max-width:600px) { .rm-form-grid { grid-template-columns: 1fr; } }
.rm-form-group { display: flex; flex-direction: column; gap: 10px; }
.rm-form-label {
    font-size: 13px; font-weight: 700; text-transform: uppercase;
    letter-spacing: .8px; color: var(--rm-text2);
}
.rm-form-input, .rm-form-select {
    background: rgba(255,255,255,.05); border: 1px solid var(--rm-border);
    border-radius: 11px; color: var(--rm-text1);
    font-family: var(--rm-font); font-size: 16px; padding: 14px 18px;
    outline: none; transition: border-color .2s, box-shadow .2s;
    -webkit-appearance: none; width: 100%; box-sizing: border-box;
}
.rm-form-input::placeholder { color: rgba(143,168,184,.45); }
.rm-form-input:focus, .rm-form-select:focus {
    border-color: rgba(0,212,170,.5);
    box-shadow: 0 0 0 3px rgba(0,212,170,.1);
}
.rm-form-actions { display: flex; gap: 12px; align-items: center; margin-top: 8px; grid-column: 1/-1; }
.rm-btn-save {
    display: inline-flex; align-items: center; gap: 9px;
    padding: 15px 30px; border-radius: 11px; border: none; cursor: pointer;
    background: linear-gradient(135deg, var(--rm-teal), #00b894);
    color: #0d1f1b; font-family: var(--rm-font); font-size: 16px; font-weight: 700;
    box-shadow: 0 4px 20px rgba(0,212,170,.25);
    transition: transform .18s, box-shadow .18s;
}
.rm-btn-save:hover { transform: translateY(-2px); box-shadow: 0 8px 32px rgba(0,212,170,.4); }
.rm-btn-cancel {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 15px 24px; border-radius: 11px; cursor: pointer;
    background: transparent; border: 1px solid var(--rm-border);
    color: var(--rm-text2); font-family: var(--rm-font); font-size: 16px;
    transition: border-color .18s, color .18s;
}
.rm-btn-cancel:hover { border-color: var(--rm-border2); color: var(--rm-text1); }

/* ── Insights Grid ─────────────────────────────── */
.rm-insights-grid { display: grid; grid-template-columns: repeat(3,1fr); gap: 20px; }
@media(max-width:900px) { .rm-insights-grid { grid-template-columns: 1fr; } }
.rm-insight {
    background: var(--rm-glass); border: 1px solid var(--rm-border);
    border-radius: 18px; padding: 28px 26px;
    transition: transform .22s, border-color .22s, box-shadow .22s;
    animation: rmScaleIn .4s ease both;
}
.rm-insight:hover { transform: translateY(-5px); border-color: var(--rm-border2); box-shadow: 0 16px 44px rgba(0,0,0,.35); }
.rm-insight-icon { font-size: 32px; margin-bottom: 14px; animation: rmFloat 4s ease-in-out infinite; }
.rm-insight-value { font-size: 44px; font-weight: 700; margin-bottom: 6px; line-height: 1; }
.rm-insight-label { font-size: 16px; color: var(--rm-text2); margin-bottom: 16px; }
.rm-insight-bar { height: 5px; border-radius: 5px; background: var(--rm-border); overflow: hidden; }
.rm-insight-fill { height: 100%; border-radius: 5px; width: 0; transition: width 1.4s cubic-bezier(.16,1,.3,1) .7s; }

/* ── Quick Actions ─────────────────────────────── */
.rm-quick-grid { display: grid; grid-template-columns: repeat(5,1fr); gap: 16px; }
@media(max-width:1100px) { .rm-quick-grid { grid-template-columns: repeat(3,1fr); } }
@media(max-width:600px)  { .rm-quick-grid { grid-template-columns: repeat(2,1fr); } }
.rm-quick-card {
    background: var(--rm-glass); border: 1px solid var(--rm-border);
    border-radius: 18px; padding: 26px 20px;
    display: flex; flex-direction: column; align-items: center; gap: 14px;
    cursor: pointer; transition: all .22s; text-align: center; text-decoration: none;
}
.rm-quick-card:hover {
    border-color: var(--rm-border2); transform: translateY(-5px);
    box-shadow: 0 14px 40px rgba(0,0,0,.35);
    background: var(--rm-glass2);
}
.rm-quick-icon { font-size: 34px; transition: transform .3s; }
.rm-quick-card:hover .rm-quick-icon { transform: scale(1.12) rotate(-3deg); }
.rm-quick-label { font-size: 15px; font-weight: 600; color: var(--rm-text2); line-height: 1.4; }

/* ── Sidebar ───────────────────────────────────── */
.rm-sidebar { display: flex; flex-direction: column; gap: 22px; position: sticky; top: 24px; }

/* Timeline */
.rm-timeline { display: flex; flex-direction: column; }
.rm-tl-item {
    display: flex; gap: 16px; padding: 20px 26px;
    border-bottom: 1px solid var(--rm-border);
    transition: background .2s; position: relative;
    animation: rmSlideIn .4s ease both;
}
.rm-tl-item:last-child { border-bottom: none; }
.rm-tl-item:hover { background: rgba(255,255,255,.03); }
.rm-tl-item::before {
    content: ''; position: absolute; left: 54px; top: 0; bottom: 0; width: 1px;
    background: linear-gradient(to bottom, transparent, var(--rm-border), transparent);
    pointer-events: none;
    animation: rmLineGrow .6s ease both;
}
.rm-tl-time {
    width: 32px; flex-shrink: 0; text-align: right;
    font-family: var(--rm-mono); font-size: 12px;
    color: var(--rm-teal); line-height: 1.35; padding-top: 2px;
}
.rm-tl-dot {
    width: 12px; height: 12px; border-radius: 50%;
    background: var(--rm-teal); flex-shrink: 0; margin-top: 3px;
    box-shadow: 0 0 10px rgba(0,212,170,.4);
    position: relative; z-index: 1;
    animation: rmGlow 2.5s ease-in-out infinite;
}
.rm-tl-dot.completed { background: var(--rm-green); box-shadow: 0 0 10px rgba(52,211,153,.35); animation: none; }
.rm-tl-dot.pending   { background: var(--rm-amber); box-shadow: 0 0 10px rgba(251,191,36,.35); animation: rmDotPulse 2s ease-in-out infinite; }
.rm-tl-title  { font-size: 15px; font-weight: 600; color: var(--rm-text1); }
.rm-tl-cat    { font-size: 13px; color: var(--rm-text2); margin-top: 3px; }

/* Progress card */
.rm-progress-body {
    padding: 28px; display: flex; flex-direction: column;
    align-items: center; gap: 18px;
}
.rm-big-ring { position: relative; width: 130px; height: 130px; flex-shrink: 0; }
.rm-big-ring svg { transform: rotate(-90deg); }
.rm-big-ring circle { transition: stroke-dashoffset 1.6s cubic-bezier(.16,1,.3,1) .5s; }
.rm-big-ring-pct {
    position: absolute; inset: 0; display: flex; flex-direction: column;
    align-items: center; justify-content: center; gap: 3px;
}
.rm-big-ring-num   { font-size: 32px; font-weight: 700; color: var(--rm-teal); line-height: 1; }
.rm-big-ring-label { font-size: 12px; color: var(--rm-text2); text-transform: uppercase; letter-spacing: .6px; }
.rm-progress-label { font-size: 17px; color: var(--rm-text2); text-align: center; }

/* Stat rows in sidebar */
.rm-stat-row-item {
    display: flex; justify-content: space-between; align-items: center;
    padding: 16px 26px; border-bottom: 1px solid var(--rm-border); font-size: 15px;
}
.rm-stat-row-item:last-child { border-bottom: none; }
.rm-stat-row-label { color: var(--rm-text2); }
.rm-stat-row-val {
    font-family: var(--rm-mono); font-size: 19px;
    font-weight: 700; color: var(--rm-text1);
}

/* Streak card */
.rm-streak-body { padding: 24px 26px; }
.rm-streak-row {
    display: flex; justify-content: space-between; align-items: center;
    padding: 13px 0; border-bottom: 1px solid var(--rm-border);
}
.rm-streak-row:last-child { border-bottom: none; }
.rm-streak-label { font-size: 15px; color: var(--rm-text2); }
.rm-streak-val {
    font-size: 30px; font-weight: 700; color: var(--rm-amber);
    text-shadow: 0 0 20px rgba(251,191,36,.25);
}

/* ── Empty state ───────────────────────────────── */
.rm-empty {
    text-align: center; padding: 90px 30px;
    display: flex; flex-direction: column; align-items: center; gap: 18px;
}
.rm-empty-icon  { font-size: 60px; opacity: .4; animation: rmFloat 3s ease-in-out infinite; }
.rm-empty-title { font-size: 24px; font-weight: 700; color: var(--rm-text1); }
.rm-empty-sub   { font-size: 16px; color: var(--rm-text2); max-width: 380px; line-height: 1.65; }

/* ── Responsive ────────────────────────────────── */
@media(max-width:768px) {
    .rm-header { flex-direction: column; align-items: flex-start; }
    .rm-page-title { font-size: 36px; }
    .rm-stats-grid { grid-template-columns: repeat(2,1fr); }
    .rm-row { grid-template-columns: 60px 1fr; gap: 14px; }
    .rm-row-right, .rm-row-actions { grid-column: 2; }
}
@media(max-width:480px) {
    .rm-stats-grid { grid-template-columns: 1fr; }
    .rm-page-title { font-size: 30px; }
}
</style>

<div class="rm-module">

<?php if (!empty($flash)): ?>
    <div class="rm-flash">✅ <?= htmlspecialchars($flash) ?></div>
<?php endif; ?>

<!-- ══ Page Header ══════════════════════════════════ -->
<div class="rm-header">
    <div class="rm-header-left">
        <div class="rm-page-icon">🔔</div>
        <div>
            <div class="rm-page-title">Health Reminders</div>
            <div class="rm-page-sub">Manage medications, health tasks, appointments, and daily wellness reminders.</div>
            <div class="rm-count-pill">🔔 <?= $totalCount ?> reminder<?= $totalCount !== 1 ? 's' : '' ?> today</div>
        </div>
    </div>
    <div class="rm-toolbar">
        <div class="rm-search">
            <span style="font-size:18px;opacity:.45">🔍</span>
            <input type="text" placeholder="Search reminders…" id="rm-search-input">
        </div>
        <select class="rm-select" id="rm-status-filter">
            <option value="">All Status</option>
            <option value="completed">Completed</option>
            <option value="pending">Pending</option>
            <option value="upcoming">Upcoming</option>
        </select>
        <select class="rm-select" id="rm-cat-filter">
            <option value="">All Categories</option>
            <?php foreach (array_keys($grouped) as $cat): ?>
                <option value="<?= htmlspecialchars($cat) ?>"><?= htmlspecialchars($cat) ?></option>
            <?php endforeach; ?>
        </select>
        <button class="rm-btn rm-btn-primary" onclick="toggleAddForm()">➕ Add Reminder</button>
    </div>
</div>

<!-- ══ Stat Cards ═══════════════════════════════════ -->
<div class="rm-stats-grid">

    <div class="rm-stat-card" style="--sc-glow:rgba(0,212,170,.08);animation-delay:.05s">
        <div class="rm-stat-card-top">
            <div class="rm-stat-label">Today's Total</div>
            <div class="rm-stat-icon">🔔</div>
        </div>
        <div class="rm-stat-number" style="color:var(--rm-teal)"
             data-count="<?= $totalCount ?>"><?= $totalCount ?></div>
        <div class="rm-stat-sub">Active reminders</div>
    </div>

    <div class="rm-stat-card" style="--sc-glow:rgba(52,211,153,.08);animation-delay:.10s">
        <div class="rm-stat-card-top">
            <div class="rm-stat-label">Completed</div>
            <div class="rm-stat-icon">✅</div>
        </div>
        <div class="rm-stat-number" style="color:var(--rm-green)"
             data-count="<?= $completedCount ?>"><?= $completedCount ?></div>
        <div class="rm-stat-sub"><?= $completePct ?>% done today</div>
        <div class="rm-stat-bar">
            <div class="rm-stat-bar-fill" data-w="<?= $completePct ?>"></div>
        </div>
    </div>

    <div class="rm-stat-card" style="--sc-glow:rgba(251,191,36,.08);animation-delay:.15s">
        <div class="rm-stat-card-top">
            <div class="rm-stat-label">Pending</div>
            <div class="rm-stat-icon">⏳</div>
        </div>
        <div class="rm-stat-number" style="color:var(--rm-amber)"
             data-count="<?= $pendingCount ?>"><?= $pendingCount ?></div>
        <div class="rm-stat-sub">Awaiting action</div>
    </div>

    <div class="rm-stat-card" style="--sc-glow:rgba(59,158,255,.08);animation-delay:.20s">
        <div class="rm-stat-card-top">
            <div class="rm-stat-label">Medications</div>
            <div class="rm-stat-icon">💊</div>
        </div>
        <div class="rm-stat-number" style="color:var(--rm-blue)"
             data-count="<?= $medCount ?>"><?= $medCount ?></div>
        <div class="rm-stat-sub">Med reminders</div>
    </div>

    <div class="rm-stat-card" style="--sc-glow:rgba(248,113,113,.08);animation-delay:.25s">
        <div class="rm-stat-card-top">
            <div class="rm-stat-label">Health Tasks</div>
            <div class="rm-stat-icon">❤️</div>
        </div>
        <div class="rm-stat-number" style="color:var(--rm-red)"
             data-count="<?= $healthCount ?>"><?= $healthCount ?></div>
        <div class="rm-stat-sub">Monitoring tasks</div>
    </div>

    <div class="rm-stat-card" style="--sc-glow:rgba(167,139,250,.08);animation-delay:.30s">
        <div class="rm-stat-card-top">
            <div class="rm-stat-label">Completion</div>
            <div class="rm-stat-icon">📊</div>
        </div>
        <div class="rm-ring-wrap">
            <div class="rm-ring">
                <?php $circ = round(2*M_PI*28,1); $off = round($circ*(1-$completePct/100),1); ?>
                <svg width="66" height="66" viewBox="0 0 66 66">
                    <circle cx="33" cy="33" r="28" fill="none"
                            stroke="rgba(255,255,255,.07)" stroke-width="5"/>
                    <circle cx="33" cy="33" r="28" fill="none"
                            stroke="var(--rm-teal)" stroke-width="5"
                            stroke-dasharray="<?= $circ ?>"
                            stroke-dashoffset="<?= $circ ?>"
                            data-dashoffset="<?= $off ?>"
                            stroke-linecap="round"
                            class="rm-ring-circle"/>
                </svg>
                <div class="rm-ring-pct"><?= $completePct ?>%</div>
            </div>
            <div>
                <div style="font-size:42px;font-weight:700;color:var(--rm-teal);line-height:1"
                     data-count="<?= $completePct ?>"><?= $completePct ?></div>
                <div style="font-size:15px;color:var(--rm-text2);margin-top:4px">% Rate</div>
            </div>
        </div>
    </div>

</div>

<!-- ══ Main Two-Col Layout ══════════════════════════ -->
<div class="rm-layout">
<div style="display:flex;flex-direction:column;gap:24px;">

    <!-- All Reminders card -->
    <div class="rm-card" style="animation-delay:.12s">
        <div class="rm-card-head">
            <div class="rm-card-head-left">
                <div class="rm-card-head-icon" style="--chi-bg:rgba(0,212,170,.14);--chi-glow:rgba(0,212,170,.2)">🗂️</div>
                <div>
                    <div class="rm-card-head-title">All Reminders</div>
                    <div class="rm-card-head-sub"><?= $totalCount ?> reminder<?= $totalCount !== 1 ? 's' : '' ?> grouped by category</div>
                </div>
            </div>
        </div>

        <?php if (empty($reminders)): ?>
            <div class="rm-empty">
                <div class="rm-empty-icon">🔔</div>
                <div class="rm-empty-title">No reminders yet</div>
                <div class="rm-empty-sub">Add your first reminder to start tracking your health tasks and medications.</div>
                <button class="rm-btn rm-btn-primary" onclick="toggleAddForm()">Add Reminder</button>
            </div>
        <?php else: ?>

        <?php foreach ($grouped as $catName => $catReminders):
            $meta  = $categoryMeta[$catName] ?? ['icon'=>'📌','color'=>'#3b9eff','glow'=>'rgba(59,158,255,.2)'];
            $catId = preg_replace('/\W+/','-',strtolower($catName));
            $catDone = count(array_filter($catReminders, fn($r) => $r['status']==='completed'));
            $rgb = implode(',', array_map('hexdec', str_split(ltrim($meta['color'],'#'),2)));
        ?>
        <div class="rm-category" data-category="<?= htmlspecialchars($catName) ?>">
            <div class="rm-cat-header open" onclick="toggleCategory('<?= $catId ?>')" id="cat-hdr-<?= $catId ?>">
                <div class="rm-cat-icon"
                     style="--cat-bg:rgba(<?= $rgb ?>,.12);--cat-glow:<?= $meta['glow'] ?>">
                    <?= $meta['icon'] ?>
                </div>
                <div class="rm-cat-name"><?= htmlspecialchars($catName) ?></div>
                <span class="rm-cat-count"><?= $catDone ?> / <?= count($catReminders) ?></span>
                <span class="rm-cat-chevron">▼</span>
            </div>
            <div class="rm-cat-body open" id="cat-body-<?= $catId ?>">
            <?php foreach ($catReminders as $i => $r):
                $badgeCls = match($r['status']) {
                    'completed' => 'rm-badge-completed',
                    'pending'   => 'rm-badge-pending',
                    'upcoming'  => 'rm-badge-upcoming',
                    default     => 'rm-badge-pending',
                };
                $statusLabel = match($r['status']) {
                    'completed' => '✅ Completed',
                    'pending'   => '⏳ Pending',
                    'upcoming'  => '🔵 Upcoming',
                    default     => $r['status'],
                };
                $priorityColor = match($r['priority'] ?? 'Medium') {
                    'High'   => 'var(--rm-red)',
                    'Medium' => 'var(--rm-amber)',
                    'Low'    => 'var(--rm-green)',
                    default  => 'var(--rm-text2)',
                };
            ?>
            <div class="rm-row"
                 data-status="<?= $r['status'] ?>"
                 data-text="<?= strtolower(htmlspecialchars($r['text'])) ?>"
                 style="animation: rmFadeUp .35s ease <?= .05*$i ?>s both;">
                <div class="rm-row-icon"
                     style="--ri-bg:rgba(<?= $rgb ?>,.1);--ri-border:<?= $meta['glow'] ?>">
                    <?= $r['icon'] ?>
                </div>
                <div class="rm-row-info">
                    <div class="rm-row-title"><?= htmlspecialchars($r['text']) ?></div>
                    <div class="rm-row-meta">
                        <span class="rm-meta-chip">🔄 <?= htmlspecialchars($r['freq']) ?></span>
                        <span class="rm-meta-chip" style="color:<?= $priorityColor ?>">
                            ⚡ <?= htmlspecialchars($r['priority']) ?> Priority
                        </span>
                        <span class="rm-meta-chip">📁 <?= htmlspecialchars($catName) ?></span>
                    </div>
                </div>
                <div class="rm-row-right">
                    <div class="rm-time-badge"><?= htmlspecialchars($r['time']) ?></div>
                    <span class="rm-badge <?= $badgeCls ?>">
                        <span class="rm-badge-dot"></span><?= $statusLabel ?>
                    </span>
                </div>
                <div class="rm-row-actions">
                    <button class="rm-action-btn rm-action-check" title="Mark complete">✅<span class="rm-tip">Complete</span></button>
                    <button class="rm-action-btn rm-action-edit"  title="Edit">✏️<span class="rm-tip">Edit</span></button>
                    <button class="rm-action-btn rm-action-del"   title="Delete">🗑️<span class="rm-tip">Delete</span></button>
                </div>
            </div>
            <?php endforeach; ?>
            </div>
        </div>
        <?php endforeach; ?>

        <?php endif; ?>

        <!-- Add Reminder Form -->
        <div id="addReminderForm" style="display:none;">
            <div class="rm-add-wrap">
                <div style="font-size:20px;font-weight:700;color:var(--rm-text1);margin-bottom:22px;">➕ New Reminder</div>
                <div class="rm-form-grid">
                    <div class="rm-form-group">
                        <label class="rm-form-label">Reminder Title</label>
                        <input type="text" class="rm-form-input" id="remTitle" placeholder="e.g. Take morning medication">
                    </div>
                    <div class="rm-form-group">
                        <label class="rm-form-label">Time</label>
                        <input type="time" class="rm-form-input" id="remTime">
                    </div>
                    <div class="rm-form-group">
                        <label class="rm-form-label">Category</label>
                        <select class="rm-form-select" id="remCategory">
                            <option value="Medications">💊 Medications</option>
                            <option value="Health Monitoring">❤️ Health Monitoring</option>
                            <option value="Nutrition">🍎 Nutrition</option>
                            <option value="Appointments">🏥 Appointments</option>
                            <option value="Exercise">🏃 Exercise</option>
                            <option value="Wellness">😴 Wellness</option>
                        </select>
                    </div>
                    <div class="rm-form-group">
                        <label class="rm-form-label">Frequency</label>
                        <select class="rm-form-select" id="remFreq">
                            <option value="Daily">Daily</option>
                            <option value="Weekly">Weekly</option>
                            <option value="Monthly">Monthly</option>
                            <option value="As Needed">As Needed</option>
                        </select>
                    </div>
                    <div class="rm-form-actions">
                        <button class="rm-btn-save" onclick="saveReminder()">✅ Save Reminder</button>
                        <button class="rm-btn-cancel" onclick="toggleAddForm()">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Health Insights -->
    <div style="animation-delay:.2s">
        <div class="rm-section-title">📈 Health Insights</div>
        <div class="rm-insights-grid">
            <div class="rm-insight" style="animation-delay:.22s">
                <div class="rm-insight-icon">💊</div>
                <div class="rm-insight-value" style="color:var(--rm-blue)">95%</div>
                <div class="rm-insight-label">Medication Adherence</div>
                <div class="rm-insight-bar">
                    <div class="rm-insight-fill" data-w="95"
                         style="background:linear-gradient(90deg,var(--rm-blue),var(--rm-teal))"></div>
                </div>
            </div>
            <div class="rm-insight" style="animation-delay:.26s">
                <div class="rm-insight-icon">❤️</div>
                <div class="rm-insight-value" style="color:var(--rm-red)">92%</div>
                <div class="rm-insight-label">BP Logging Consistency</div>
                <div class="rm-insight-bar">
                    <div class="rm-insight-fill" data-w="92"
                         style="background:linear-gradient(90deg,var(--rm-red),var(--rm-orange))"></div>
                </div>
            </div>
            <div class="rm-insight" style="animation-delay:.30s">
                <div class="rm-insight-icon">🎯</div>
                <div class="rm-insight-value" style="color:var(--rm-green)"><?= $completePct ?>%</div>
                <div class="rm-insight-label">Today's Completion Rate</div>
                <div class="rm-insight-bar">
                    <div class="rm-insight-fill" data-w="<?= $completePct ?>"
                         style="background:linear-gradient(90deg,var(--rm-green),var(--rm-teal))"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div style="animation-delay:.25s">
        <div class="rm-section-title">⚡ Quick Add</div>
        <div class="rm-quick-grid">
            <?php
            $quickActions = [
                ['icon'=>'➕','label'=>'Add Reminder'],
                ['icon'=>'💊','label'=>'Add Medication'],
                ['icon'=>'❤️','label'=>'Add BP Reminder'],
                ['icon'=>'🩸','label'=>'Add Blood Sugar'],
                ['icon'=>'🏥','label'=>'Add Appointment'],
            ];
            foreach ($quickActions as $qa): ?>
            <div class="rm-quick-card" onclick="toggleAddForm()">
                <div class="rm-quick-icon"><?= $qa['icon'] ?></div>
                <div class="rm-quick-label"><?= $qa['label'] ?></div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

</div><!-- /left col -->

<!-- ── Sidebar ──────────────────────────────────── -->
<div class="rm-sidebar">

    <!-- Today's Schedule -->
    <div class="rm-card" style="animation-delay:.16s">
        <div class="rm-card-head">
            <div class="rm-card-head-left">
                <div class="rm-card-head-icon" style="--chi-bg:rgba(0,212,170,.14);--chi-glow:rgba(0,212,170,.2)">⏱️</div>
                <div>
                    <div class="rm-card-head-title">Today's Schedule</div>
                    <div class="rm-card-head-sub">Full timeline view</div>
                </div>
            </div>
        </div>
        <div class="rm-timeline">
            <?php foreach ($reminders as $i => $r): ?>
            <div class="rm-tl-item" style="animation-delay:<?= .18 + $i*.05 ?>s">
                <div class="rm-tl-time">
                    <?= explode(' ',$r['time'])[0] ?><br><?= explode(' ',$r['time'])[1] ?? '' ?>
                </div>
                <div class="rm-tl-dot <?= $r['status'] ?>"></div>
                <div>
                    <div class="rm-tl-title"><?= htmlspecialchars(mb_strimwidth($r['text'],0,38,'…')) ?></div>
                    <div class="rm-tl-cat"><?= htmlspecialchars($r['category']) ?></div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Today's Progress -->
    <div class="rm-card" style="animation-delay:.24s">
        <div class="rm-card-head">
            <div class="rm-card-head-left">
                <div class="rm-card-head-icon" style="--chi-bg:rgba(52,211,153,.14);--chi-glow:rgba(52,211,153,.2)">🎯</div>
                <div><div class="rm-card-head-title">Today's Progress</div></div>
            </div>
        </div>
        <div class="rm-progress-body">
            <?php $c2 = round(2*M_PI*55,1); $o2 = round($c2*(1-$completePct/100),1); ?>
            <div class="rm-big-ring">
                <svg width="130" height="130" viewBox="0 0 130 130">
                    <circle cx="65" cy="65" r="55" fill="none"
                            stroke="rgba(255,255,255,.07)" stroke-width="9"/>
                    <circle cx="65" cy="65" r="55" fill="none"
                            stroke="var(--rm-teal)" stroke-width="9"
                            stroke-dasharray="<?= $c2 ?>"
                            stroke-dashoffset="<?= $c2 ?>"
                            data-dashoffset="<?= $o2 ?>"
                            stroke-linecap="round"
                            class="rm-ring-circle"/>
                </svg>
                <div class="rm-big-ring-pct">
                    <span class="rm-big-ring-num"><?= $completePct ?>%</span>
                    <span class="rm-big-ring-label">Complete</span>
                </div>
            </div>
            <div class="rm-progress-label"><?= $completedCount ?> of <?= $totalCount ?> reminders done today</div>
        </div>
    </div>

    <!-- Statistics -->
    <div class="rm-card" style="animation-delay:.30s">
        <div class="rm-card-head">
            <div class="rm-card-head-left">
                <div class="rm-card-head-icon" style="--chi-bg:rgba(167,139,250,.14);--chi-glow:rgba(167,139,250,.2)">📊</div>
                <div><div class="rm-card-head-title">Statistics</div></div>
            </div>
        </div>
        <div class="rm-stat-row-item"><span class="rm-stat-row-label">Total reminders</span><span class="rm-stat-row-val"><?= $totalCount ?></span></div>
        <div class="rm-stat-row-item"><span class="rm-stat-row-label">Completed today</span><span class="rm-stat-row-val" style="color:var(--rm-green)"><?= $completedCount ?></span></div>
        <div class="rm-stat-row-item"><span class="rm-stat-row-label">Pending</span><span class="rm-stat-row-val" style="color:var(--rm-amber)"><?= $pendingCount ?></span></div>
        <div class="rm-stat-row-item"><span class="rm-stat-row-label">Upcoming</span><span class="rm-stat-row-val" style="color:var(--rm-blue)"><?= $upcomingCount ?></span></div>
        <div class="rm-stat-row-item"><span class="rm-stat-row-label">Medications</span><span class="rm-stat-row-val" style="color:var(--rm-blue)"><?= $medCount ?></span></div>
        <div class="rm-stat-row-item"><span class="rm-stat-row-label">Completion rate</span><span class="rm-stat-row-val" style="color:var(--rm-teal)"><?= $completePct ?>%</span></div>
    </div>

    <!-- Streak -->
    <div class="rm-card" style="animation-delay:.36s">
        <div class="rm-card-head">
            <div class="rm-card-head-left">
                <div class="rm-card-head-icon" style="--chi-bg:rgba(251,191,36,.12);--chi-glow:rgba(251,191,36,.2)">🔥</div>
                <div><div class="rm-card-head-title">Your Streak</div></div>
            </div>
        </div>
        <div class="rm-streak-body">
            <div class="rm-streak-row"><span class="rm-streak-label">Daily streak</span><span class="rm-streak-val">7</span></div>
            <div class="rm-streak-row"><span class="rm-streak-label">Weekly streak</span><span class="rm-streak-val">3</span></div>
            <div class="rm-streak-row"><span class="rm-streak-label">Best streak</span><span class="rm-streak-val">14</span></div>
        </div>
    </div>

</div><!-- /sidebar -->
</div><!-- /layout -->
</div><!-- /.rm-module -->

<script>
/* ── Category toggle ─────────────────── */
function toggleCategory(id) {
    var body = document.getElementById('cat-body-' + id);
    var hdr  = document.getElementById('cat-hdr-'  + id);
    if (!body) return;
    var isOpen = body.classList.contains('open');
    body.classList.toggle('open', !isOpen);
    body.style.display = isOpen ? 'none' : 'block';
    hdr.classList.toggle('open', !isOpen);
}

/* ── Add Reminder toggle ─────────────── */
function toggleAddForm() {
    var form = document.getElementById('addReminderForm');
    if (!form) return;
    var isHidden = form.style.display === 'none';
    form.style.display = isHidden ? 'block' : 'none';
    if (isHidden) form.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
}

/* ── Save Reminder ───────────────────── */
function saveReminder() {
    var title = document.getElementById('remTitle')?.value?.trim();
    var time  = document.getElementById('remTime')?.value;
    if (!title) { alert('Please enter a reminder title.'); return; }
    alert('Reminder saved: ' + title + (time ? ' at ' + time : ''));
    document.getElementById('addReminderForm').style.display = 'none';
    if (document.getElementById('remTitle')) document.getElementById('remTitle').value = '';
    if (document.getElementById('remTime'))  document.getElementById('remTime').value  = '';
}
function showAddReminder() { toggleAddForm(); }

/* ── Search + filter ─────────────────── */
function rmFilter() {
    var q   = (document.getElementById('rm-search-input')?.value || '').toLowerCase();
    var st  = document.getElementById('rm-status-filter')?.value || '';
    var cat = document.getElementById('rm-cat-filter')?.value    || '';
    document.querySelectorAll('.rm-row').forEach(function(row) {
        var text   = row.dataset.text    || '';
        var status = row.dataset.status  || '';
        var catEl  = row.closest('.rm-category');
        var rowCat = catEl ? catEl.dataset.category : '';
        var show = (!q || text.includes(q)) && (!st || status === st) && (!cat || rowCat === cat);
        row.style.display = show ? '' : 'none';
    });
}
document.getElementById('rm-search-input')?.addEventListener('input', rmFilter);
document.getElementById('rm-status-filter')?.addEventListener('change', rmFilter);
document.getElementById('rm-cat-filter')?.addEventListener('change', rmFilter);

/* ── Premium animations on load ─────── */
window.addEventListener('load', function() {

    /* Bar fills */
    document.querySelectorAll('.rm-stat-bar-fill, .rm-insight-fill').forEach(function(el) {
        var w = el.dataset.w || '0';
        el.style.width = '0';
        setTimeout(function() { el.style.width = w + '%'; }, 350);
    });

    /* SVG ring draw */
    document.querySelectorAll('.rm-ring-circle').forEach(function(el) {
        var target = el.dataset.dashoffset || '0';
        var full   = parseFloat(el.getAttribute('stroke-dasharray')) || 314;
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
        var start = 0;
        var dur   = 900;
        var step  = 16;
        var inc   = target / (dur / step);
        var t = setInterval(function() {
            start += inc;
            if (start >= target) { start = target; clearInterval(t); }
            el.textContent = Math.round(start);
        }, step);
    });

    /* Button ripple */
    document.querySelectorAll('.rm-btn-primary').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            var r = document.createElement('span');
            r.style.cssText = [
                'position:absolute', 'border-radius:50%',
                'width:20px', 'height:20px',
                'background:rgba(255,255,255,.35)',
                'transform:scale(0)', 'pointer-events:none',
                'animation:rmRipple .5s linear',
                'left:' + (e.offsetX - 10) + 'px',
                'top:'  + (e.offsetY - 10) + 'px'
            ].join(';');
            this.appendChild(r);
            setTimeout(function() { r.remove(); }, 550);
        });
    });

    /* Shimmer button hover glow coords */
    document.querySelectorAll('.rm-btn-primary').forEach(function(btn) {
        btn.addEventListener('mousemove', function(e) {
            var rect = btn.getBoundingClientRect();
            btn.style.setProperty('--rx', ((e.clientX - rect.left) / rect.width * 100) + '%');
            btn.style.setProperty('--ry', ((e.clientY - rect.top)  / rect.height * 100) + '%');
        });
    });

});
</script>

<?php require_once APP_PATH . '/views/shared/footer.php'; ?>