<?php
$pageTitle = 'Progress & Reports';
$activePage = 'progress';
require_once APP_PATH . '/views/shared/header.php';

$recentFour  = array_reverse(array_slice($records, 0, 4));
$weightLabels = [];
$weightData   = [];
$hrData       = [];
foreach ($recentFour as $i => $r) {
    $weightLabels[] = date('M d', strtotime($r['date']));
    $weightData[]   = $r['weight'];
    $hrData[]       = $r['heart_rate'];
}

$avgBP = $records ? round(array_sum(array_column($records, 'systolic_bp')) / count($records)) : 0;
$avgHR = $records ? round(array_sum(array_column($records, 'heart_rate'))  / count($records)) : 0;
$avgBS = $records ? round(array_sum(array_column($records, 'blood_sugar'))  / count($records)) : 0;
$avgWT = $records ? round(array_sum(array_column($records, 'weight'))       / count($records), 1) : 0;
?>

<style>
@import url('https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;0,9..40,800;1,9..40,400&family=DM+Mono:wght@300;400;500&display=swap');

:root {
  --font-sans:'DM Sans',sans-serif; --font-mono:'DM Mono',monospace;
  --bg-root:#04080f; --bg-surface:#070d1a;
  --bg-card:rgba(9,16,32,0.85); --bg-raised:rgba(12,22,42,0.72);
  --bg-pill:rgba(255,255,255,0.04);
  --bd-subtle:rgba(255,255,255,0.05); --bd-default:rgba(255,255,255,0.09); --bd-strong:rgba(255,255,255,0.16);
  --teal:#00e5b8; --teal-dim:rgba(0,229,184,0.09); --cyan:#18d4f0; --cyan-dim:rgba(24,212,240,0.09);
  --blue:#3b82f6; --blue-dim:rgba(59,130,246,0.11); --blue-soft:#60a5fa;
  --violet-mid:#8b5cf6; --violet-dim:rgba(139,92,246,0.11); --violet-soft:#a78bfa;
  --pink-soft:#f9a8d4; --pink-dim:rgba(236,72,153,0.11);
  --amber:#f59e0b; --amber-dim:rgba(245,158,11,0.11); --amber-soft:#fcd34d;
  --orange:#f97316; --orange-dim:rgba(249,115,22,0.11); --orange-soft:#fdba74;
  --red:#ef4444; --red-dim:rgba(239,68,68,0.11); --red-soft:#fca5a5;
  --green:#10b981; --green-dim:rgba(16,185,129,0.11); --green-soft:#6ee7b7;
  --tx-primary:#f0f4ff; --tx-secondary:#7a9cc4; --tx-muted:#3d5470; --tx-faint:#253347;
  --r-sm:10px; --r-md:14px; --r-lg:18px; --r-xl:22px; --r-2xl:28px;
  --sh-card:0 1px 3px rgba(0,0,0,0.45),0 8px 36px rgba(0,0,0,0.38);
  --sh-hover:0 4px 12px rgba(0,0,0,0.55),0 20px 56px rgba(0,0,0,0.55);
  --sh-inset:inset 0 1px 0 rgba(255,255,255,0.05);
  --ease:cubic-bezier(0.4,0,0.2,1); --ease-spring:cubic-bezier(0.34,1.56,0.64,1);
}
*,*::before,*::after { box-sizing:border-box; margin:0; padding:0; }

@keyframes fadeUp    { from{opacity:0;transform:translateY(24px)} to{opacity:1;transform:translateY(0)} }
@keyframes fadeIn    { from{opacity:0} to{opacity:1} }
@keyframes floatY    { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-5px)} }
@keyframes countUp   { from{opacity:0;transform:translateY(10px)} to{opacity:1;transform:translateY(0)} }
@keyframes shimmer   { 0%{transform:translateX(-100%)} 100%{transform:translateX(200%)} }
@keyframes barGrow   { from{width:0} }
@keyframes glowPulse { 0%,100%{opacity:0.55} 50%{opacity:1} }

/* ── Ambient background ── */
.bg-mesh { position:fixed; inset:0; z-index:0; pointer-events:none; overflow:hidden; }
.bg-mesh::before {
  content:''; position:absolute; border-radius:50%; filter:blur(130px);
  width:1000px; height:800px; top:-200px; right:-210px;
  background:radial-gradient(ellipse,rgba(59,130,246,0.05) 0%,rgba(139,92,246,0.045) 50%,transparent 75%);
  animation:meshA 22s ease-in-out infinite;
}
.bg-mesh::after {
  content:''; position:absolute; border-radius:50%; filter:blur(120px);
  width:800px; height:650px; bottom:-130px; left:-140px;
  background:radial-gradient(ellipse,rgba(0,229,184,0.045) 0%,rgba(24,212,240,0.035) 60%,transparent 80%);
  animation:meshB 28s ease-in-out infinite;
}
.bg-orb3 {
  position:fixed; width:500px; height:400px;
  top:50%; left:45%; transform:translate(-50%,-50%);
  border-radius:50%; pointer-events:none; z-index:0;
  background:radial-gradient(ellipse,rgba(249,115,22,0.025) 0%,transparent 70%);
  filter:blur(100px); animation:meshC 35s ease-in-out infinite;
}
.bg-grid {
  position:fixed; inset:0; z-index:0; pointer-events:none;
  background-image:linear-gradient(rgba(255,255,255,0.015) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,0.015) 1px,transparent 1px);
  background-size:60px 60px;
  mask-image:radial-gradient(ellipse 80% 80% at 50% 50%,black 20%,transparent 100%);
}
@keyframes meshA { 0%,100%{transform:translate(0,0)scale(1)} 40%{transform:translate(-45px,38px)scale(1.06)} 70%{transform:translate(30px,-24px)scale(0.97)} }
@keyframes meshB { 0%,100%{transform:translate(0,0)scale(1)} 35%{transform:translate(40px,-30px)scale(1.05)} 65%{transform:translate(-20px,22px)scale(0.98)} }
@keyframes meshC { 0%,100%{transform:translate(-50%,-50%)scale(1)} 50%{transform:translate(-50%,-57%)scale(1.09)} }

.prog {
  position:relative; z-index:1; font-family:var(--font-sans); color:var(--tx-primary);
  max-width:1380px; padding:4px 0 56px;
}

/* ── Page header ── */
.pg-header {
  display:flex; align-items:flex-end; justify-content:space-between;
  margin-bottom:36px; gap:20px; flex-wrap:wrap;
  opacity:0; animation:fadeUp 0.65s 0.05s var(--ease) forwards;
}
.pg-eyebrow {
  font-family:var(--font-mono); font-size:11px; font-weight:500; letter-spacing:2.5px;
  text-transform:uppercase; color:var(--blue-soft); margin-bottom:8px;
  display:flex; align-items:center; gap:10px;
}
.pg-eyebrow::before { content:''; width:22px; height:1px; background:var(--blue-soft); opacity:0.45; }
.pg-title { font-size:44px; font-weight:800; letter-spacing:-1.2px; line-height:1.1; }
.pg-sub   { font-size:15px; color:var(--tx-secondary); margin-top:7px; font-weight:400; }
.rec-chip {
  display:inline-flex; align-items:center; gap:10px;
  background:var(--bg-pill); border:1px solid var(--bd-default);
  color:var(--tx-secondary); font-family:var(--font-mono); font-size:12px; font-weight:400;
  padding:10px 20px; border-radius:100px; white-space:nowrap;
}
.rec-num { font-weight:600; color:var(--tx-primary); }

/* ── Section heading ── */
.sec-head { display:flex; align-items:center; gap:14px; margin-bottom:18px; }
.sec-title { font-size:12px; font-weight:600; text-transform:uppercase; letter-spacing:1.6px; color:var(--tx-muted); font-family:var(--font-mono); white-space:nowrap; }
.sec-line  { flex:1; height:1px; background:linear-gradient(90deg,var(--bd-default),transparent); }

/* ── Summary stat cards ── */
.summary-row {
  display:grid; grid-template-columns:repeat(3,1fr); gap:18px; margin-bottom:36px;
}
@media(max-width:900px) { .summary-row { grid-template-columns:repeat(2,1fr); } }
@media(max-width:560px) { .summary-row { grid-template-columns:1fr; } }

.sm-card {
  background:var(--bg-card); border:1px solid var(--bd-default);
  border-radius:var(--r-xl); padding:32px 28px 26px;
  position:relative; overflow:hidden;
  backdrop-filter:blur(32px);
  box-shadow:var(--sh-card),var(--sh-inset);
  transition:transform 0.32s var(--ease-spring),box-shadow 0.32s var(--ease),border-color 0.28s var(--ease);
  cursor:default;
  opacity:0; animation:fadeUp 0.65s var(--ease) forwards;
}
.summary-row .sm-card:nth-child(1) { animation-delay:0.18s; }
.summary-row .sm-card:nth-child(2) { animation-delay:0.26s; }
.summary-row .sm-card:nth-child(3) { animation-delay:0.34s; }
.sm-card:hover { transform:translateY(-6px); box-shadow:var(--sh-hover),var(--sh-inset); border-color:var(--bd-strong); }
.sm-card::before {
  content:''; position:absolute; top:0; left:0; right:0; height:2px;
  border-radius:var(--r-xl) var(--r-xl) 0 0; opacity:0.75; transition:opacity 0.3s;
}
.sm-card:hover::before { opacity:1; }
.sm-bp::before   { background:linear-gradient(90deg,transparent 5%,#3b82f6 50%,transparent 95%); }
.sm-hr::before   { background:linear-gradient(90deg,transparent 5%,#ef4444 50%,transparent 95%); }
.sm-bs::before   { background:linear-gradient(90deg,transparent 5%,#8b5cf6 50%,transparent 95%); }
.sm-glow {
  position:absolute; width:160px; height:160px;
  top:-60px; right:-60px; border-radius:50%;
  filter:blur(60px); opacity:0.16; pointer-events:none;
  transition:opacity 0.4s;
}
.sm-card:hover .sm-glow { opacity:0.34; }
.sm-bp .sm-glow { background:#3b82f6; } .sm-hr .sm-glow { background:#ef4444; } .sm-bs .sm-glow { background:#8b5cf6; }
.sm-shimmer {
  position:absolute; top:0; left:-80%; width:45%; height:100%;
  background:linear-gradient(105deg,transparent,rgba(255,255,255,0.025),transparent);
  pointer-events:none; opacity:0; transition:opacity 0.2s;
}
.sm-card:hover .sm-shimmer { opacity:1; animation:shimmer 0.85s ease-in-out; }
.sm-top { display:flex; align-items:center; justify-content:space-between; margin-bottom:20px; }
.sm-label { font-family:var(--font-mono); font-size:11px; font-weight:500; letter-spacing:1.2px; text-transform:uppercase; color:var(--tx-muted); }
.sm-icon {
  width:42px; height:42px; border-radius:12px;
  display:flex; align-items:center; justify-content:center; font-size:18px;
  border:1px solid var(--bd-default);
  transition:transform 0.3s var(--ease-spring);
}
.sm-card:hover .sm-icon { transform:scale(1.12) rotate(-4deg); }
.sm-bp .sm-icon { background:var(--blue-dim);   border-color:rgba(59,130,246,0.2); }
.sm-hr .sm-icon { background:var(--red-dim);    border-color:rgba(239,68,68,0.2); }
.sm-bs .sm-icon { background:var(--violet-dim); border-color:rgba(139,92,246,0.2); }
.sm-val {
  font-size:60px; font-weight:800; line-height:1; letter-spacing:-2.5px; margin-bottom:8px;
  opacity:0; animation:countUp 0.7s var(--ease) forwards;
}
.sm-bp .sm-val { color:var(--blue-soft); animation-delay:0.4s; }
.sm-hr .sm-val { color:var(--red-soft);  animation-delay:0.5s; }
.sm-bs .sm-val { color:var(--violet-soft); animation-delay:0.6s; }
.sm-sub { font-size:13px; color:var(--tx-muted); font-weight:400; display:flex; align-items:center; gap:10px; }
.sm-badge {
  display:inline-flex; align-items:center; gap:6px;
  font-size:12px; font-weight:500; padding:4px 11px; border-radius:100px; font-family:var(--font-sans);
}
.bdot { width:6px; height:6px; border-radius:50%; flex-shrink:0; }
.badge-ok   { background:var(--green-dim); color:var(--green-soft); border:1px solid rgba(16,185,129,0.24); }
.badge-ok .bdot   { background:var(--green-soft); box-shadow:0 0 6px rgba(110,231,183,0.7); }
.badge-warn { background:var(--amber-dim); color:var(--amber-soft); border:1px solid rgba(245,158,11,0.24); }
.badge-warn .bdot { background:var(--amber-soft); box-shadow:0 0 6px rgba(252,211,77,0.7); }

/* ── Chart grid ── */
.chart-grid { display:grid; grid-template-columns:1fr 1fr; gap:20px; margin-bottom:20px; }
@media(max-width:900px) { .chart-grid { grid-template-columns:1fr; } }

/* ── Base card ── */
.card {
  background:var(--bg-card); border:1px solid var(--bd-default);
  border-radius:var(--r-xl); padding:32px;
  backdrop-filter:blur(32px);
  box-shadow:var(--sh-card),var(--sh-inset);
  transition:border-color 0.28s var(--ease),box-shadow 0.28s var(--ease);
  margin-bottom:20px;
  opacity:0; animation:fadeUp 0.65s var(--ease) forwards;
}
.card:hover { border-color:var(--bd-strong); box-shadow:var(--sh-hover),var(--sh-inset); }
.card:last-child { margin-bottom:0; }
.card-head { display:flex; align-items:center; justify-content:space-between; margin-bottom:28px; }
.card-title {
  display:flex; align-items:center; gap:14px;
  font-size:18px; font-weight:700; color:var(--tx-primary); letter-spacing:-0.3px;
}
.card-ico {
  width:40px; height:40px; border-radius:12px;
  display:flex; align-items:center; justify-content:center; font-size:17px; flex-shrink:0;
  transition:transform 0.3s var(--ease-spring);
}
.card:hover .card-ico { transform:scale(1.1) rotate(-4deg); }
.ico-teal   { background:var(--teal-dim);   border:1px solid rgba(0,229,184,0.18); }
.ico-orange { background:var(--orange-dim); border:1px solid rgba(249,115,22,0.18); }
.ico-red    { background:var(--red-dim);    border:1px solid rgba(239,68,68,0.18); }
.ico-violet { background:var(--violet-dim); border:1px solid rgba(139,92,246,0.18); }
.ico-blue   { background:var(--blue-dim);   border:1px solid rgba(59,130,246,0.18); }

/* ── Metric highlight ── */
.metric-highlight {
  display:flex; align-items:baseline; gap:12px; margin-bottom:24px;
  padding:18px 22px;
  background:var(--bg-raised); border:1px solid var(--bd-subtle); border-radius:var(--r-md);
}
.mh-val { font-size:44px; font-weight:800; line-height:1; letter-spacing:-1.5px; }
.mh-unit { font-size:15px; color:var(--tx-secondary); font-weight:400; }
.mh-sep  { width:1px; height:32px; background:var(--bd-default); margin:0 4px; align-self:center; }
.mh-sub  { font-size:13px; color:var(--tx-muted); line-height:1.55; }
.mh-sub strong { color:var(--tx-secondary); font-weight:500; display:block; font-size:11px; font-family:var(--font-mono); text-transform:uppercase; letter-spacing:0.9px; margin-bottom:3px; }

.chart-box { position:relative; height:230px; }
.chart-box-tall { position:relative; height:280px; }

/* ── Chart legend ── */
.chart-legend { display:flex; gap:22px; margin-bottom:18px; flex-wrap:wrap; }
.legend-item  { display:flex; align-items:center; gap:9px; font-size:13px; color:var(--tx-secondary); }
.legend-dot   { width:8px; height:8px; border-radius:50%; flex-shrink:0; }

/* ── Insights ── */
.insights-grid { display:grid; grid-template-columns:repeat(2,1fr); gap:14px; margin-bottom:20px; }
@media(max-width:700px) { .insights-grid { grid-template-columns:1fr; } }
.ins-card {
  background:var(--bg-raised); border:1px solid var(--bd-subtle);
  border-radius:var(--r-md); padding:20px 22px;
  display:flex; align-items:flex-start; gap:16px;
  transition:all 0.25s var(--ease);
  position:relative; overflow:hidden;
}
.ins-card::before {
  content:''; position:absolute; top:0; left:0; right:0; height:1px;
  opacity:0; transition:opacity 0.25s;
}
.ins-card:hover { border-color:var(--bd-default); transform:translateY(-3px); box-shadow:0 10px 32px rgba(0,0,0,0.45); }
.ins-card:hover::before { opacity:1; }
.ins-card.ic-teal::before  { background:linear-gradient(90deg,transparent,rgba(0,229,184,0.5),transparent); }
.ins-card.ic-violet::before{ background:linear-gradient(90deg,transparent,rgba(139,92,246,0.5),transparent); }
.ins-card.ic-blue::before  { background:linear-gradient(90deg,transparent,rgba(59,130,246,0.5),transparent); }
.ins-card.ic-orange::before{ background:linear-gradient(90deg,transparent,rgba(249,115,22,0.5),transparent); }
.ins-ico { width:40px; height:40px; border-radius:11px; flex-shrink:0; display:flex; align-items:center; justify-content:center; font-size:17px; transition:transform 0.3s var(--ease-spring); }
.ins-card:hover .ins-ico { transform:scale(1.12) rotate(-5deg); }
.ins-title { font-size:14px; font-weight:600; color:var(--tx-primary); letter-spacing:-0.15px; margin-bottom:5px; }
.ins-desc  { font-size:13px; color:var(--tx-secondary); line-height:1.6; font-weight:400; }

/* ── Trend cells ── */
.trend-row { display:grid; grid-template-columns:repeat(3,1fr); gap:14px; }
@media(max-width:700px) { .trend-row { grid-template-columns:1fr; } }
.trend-cell {
  background:var(--bg-raised); border:1px solid var(--bd-subtle);
  border-radius:var(--r-md); padding:20px 20px;
  transition:all 0.25s var(--ease);
}
.trend-cell:hover { border-color:var(--bd-default); transform:translateY(-2px); }
.tc-label { font-family:var(--font-mono); font-size:10px; font-weight:500; letter-spacing:1.2px; text-transform:uppercase; color:var(--tx-muted); margin-bottom:12px; }
.tc-val   { font-size:26px; font-weight:800; letter-spacing:-0.7px; margin-bottom:8px; }
.tc-bar-track { height:4px; background:rgba(255,255,255,0.05); border-radius:4px; overflow:hidden; margin-bottom:10px; }
.tc-bar-fill  { height:100%; border-radius:4px; width:0; transition:width 1.3s cubic-bezier(.23,1,.32,1); }
.tc-status { font-size:12px; color:var(--tx-muted); font-weight:400; }

.divider { height:1px; background:var(--bd-subtle); margin:24px 0; }

/* Btn */
.btn-ghost {
  background:var(--bg-pill); border:1px solid var(--bd-default);
  color:var(--tx-secondary); font-size:13px; font-weight:500;
  padding:8px 16px; border-radius:var(--r-sm); cursor:pointer;
  text-decoration:none; transition:all 0.22s var(--ease); font-family:var(--font-sans);
}
.btn-ghost:hover { border-color:var(--teal); color:var(--teal); background:var(--teal-dim); text-decoration:none; }
</style>

<div class="bg-mesh"></div>
<div class="bg-orb3"></div>
<div class="bg-grid"></div>

<div class="prog">

<!-- ─── PAGE HEADER ─── -->
<div class="pg-header">
  <div>
    <div class="pg-eyebrow">Analytics</div>
    <div class="pg-title">Progress &amp; Reports</div>
    <div class="pg-sub">Health metrics overview and trend analysis.</div>
  </div>
  <div class="rec-chip">Based on <span class="rec-num">&nbsp;<?= count($records) ?>&nbsp;</span> records</div>
</div>

<!-- ─── MONTHLY SUMMARY ─── -->
<div class="sec-head" style="opacity:0;animation:fadeIn 0.5s 0.14s var(--ease) forwards;">
  <span class="sec-title">Monthly Summary</span><span class="sec-line"></span>
</div>

<div class="summary-row">
  <div class="sm-card sm-bp">
    <div class="sm-glow"></div><div class="sm-shimmer"></div>
    <div class="sm-top"><span class="sm-label">Avg Blood Pressure</span><div class="sm-icon">💓</div></div>
    <div class="sm-val" id="avgBpVal"><?= $avgBP ?></div>
    <div class="sm-sub">Systolic average (mmHg) &nbsp;<span class="sm-badge badge-ok"><span class="bdot"></span> Normal</span></div>
  </div>
  <div class="sm-card sm-hr">
    <div class="sm-glow"></div><div class="sm-shimmer"></div>
    <div class="sm-top"><span class="sm-label">Avg Heart Rate</span><div class="sm-icon">❤️</div></div>
    <div class="sm-val" id="avgHrVal"><?= $avgHR ?></div>
    <div class="sm-sub">Resting rate (bpm) &nbsp;<span class="sm-badge badge-ok"><span class="bdot"></span> Normal</span></div>
  </div>
  <div class="sm-card sm-bs">
    <div class="sm-glow"></div><div class="sm-shimmer"></div>
    <div class="sm-top"><span class="sm-label">Avg Blood Sugar</span><div class="sm-icon">💧</div></div>
    <div class="sm-val" id="avgBsVal"><?= $avgBS ?></div>
    <div class="sm-sub">Fasting average (mg/dL) &nbsp;<span class="sm-badge badge-warn"><span class="bdot"></span> Monitor</span></div>
  </div>
</div>

<!-- ─── TREND CHARTS ─── -->
<div class="sec-head" style="opacity:0;animation:fadeIn 0.5s 0.38s var(--ease) forwards;">
  <span class="sec-title">Trends</span><span class="sec-line"></span>
</div>

<div class="chart-grid">
  <div class="card" style="animation-delay:0.42s;">
    <div class="card-head">
      <div class="card-title"><div class="card-ico ico-orange">⚖️</div>Weight Trend</div>
    </div>
    <div class="metric-highlight">
      <div><div class="mh-val" style="color:var(--orange-soft);"><?= $avgWT ?></div></div>
      <div class="mh-unit">kg avg</div>
      <div class="mh-sep"></div>
      <div class="mh-sub"><strong>4-record average</strong>Tracking body weight changes over time</div>
    </div>
    <div class="chart-box"><canvas id="weightChart"></canvas></div>
  </div>
  <div class="card" style="animation-delay:0.50s;">
    <div class="card-head">
      <div class="card-title"><div class="card-ico ico-red">❤️</div>Heart Rate Trend</div>
    </div>
    <div class="metric-highlight">
      <div><div class="mh-val" style="color:var(--red-soft);"><?= $avgHR ?></div></div>
      <div class="mh-unit">bpm avg</div>
      <div class="mh-sep"></div>
      <div class="mh-sub"><strong>Resting heart rate</strong>Weekly average across all records</div>
    </div>
    <div class="chart-box"><canvas id="hrChart"></canvas></div>
  </div>
</div>

<!-- ─── BP HISTORY ─── -->
<div class="card" style="animation-delay:0.56s;">
  <div class="card-head">
    <div class="card-title">
      <div class="card-ico ico-teal">📈</div>
      Blood Pressure History
      <span style="font-size:13px;font-weight:400;color:var(--tx-muted);margin-left:4px;">— All records</span>
    </div>
  </div>
  <div class="chart-legend">
    <div class="legend-item"><div class="legend-dot" style="background:#ef4444;box-shadow:0 0 6px rgba(239,68,68,0.75);"></div>Systolic (mmHg)</div>
    <div class="legend-item"><div class="legend-dot" style="background:#60a5fa;box-shadow:0 0 6px rgba(96,165,250,0.75);"></div>Diastolic (mmHg)</div>
  </div>
  <div class="chart-box-tall"><canvas id="bpChart"></canvas></div>
</div>

<!-- ─── INSIGHTS ─── -->
<div class="sec-head" style="margin-top:36px;opacity:0;animation:fadeIn 0.5s 0.6s var(--ease) forwards;">
  <span class="sec-title">Health Insights</span><span class="sec-line"></span>
</div>

<div class="insights-grid" style="opacity:0;animation:fadeUp 0.65s 0.65s var(--ease) forwards;">
  <div class="ins-card ic-teal">
    <div class="ins-ico ico-teal">🎯</div>
    <div>
      <div class="ins-title">Weekly Progress</div>
      <div class="ins-desc">Your average systolic pressure of <?= $avgBP ?> mmHg sits within the normal range. Continue monitoring daily and maintain your current lifestyle habits.</div>
    </div>
  </div>
  <div class="ins-card ic-violet">
    <div class="ins-ico ico-violet">⭐</div>
    <div>
      <div class="ins-title">Overall Health Score</div>
      <div class="ins-desc">Based on <?= count($records) ?> data points, your composite health score is <strong style="color:var(--teal);">80 / 100</strong>. Blood pressure and heart rate metrics are both stable.</div>
    </div>
  </div>
  <div class="ins-card ic-blue">
    <div class="ins-ico ico-blue">📊</div>
    <div>
      <div class="ins-title">Trend Analysis</div>
      <div class="ins-desc">Heart rate average of <?= $avgHR ?> bpm indicates good cardiovascular fitness. Weight average of <?= $avgWT ?> kg has remained steady — a positive indicator.</div>
    </div>
  </div>
  <div class="ins-card ic-orange">
    <div class="ins-ico ico-orange">💡</div>
    <div>
      <div class="ins-title">Recommendations</div>
      <div class="ins-desc">Blood sugar averaging <?= $avgBS ?> mg/dL — consider a low-carb dietary review. Logging more frequent records will improve trend accuracy over time.</div>
    </div>
  </div>
</div>

<!-- ─── TREND ANALYSIS CELLS ─── -->
<div class="card" style="animation-delay:0.70s;">
  <div class="card-head">
    <div class="card-title"><div class="card-ico ico-teal">🔬</div>Metric Snapshot</div>
  </div>
  <div class="trend-row">
    <div class="trend-cell">
      <div class="tc-label">Avg Blood Pressure</div>
      <div class="tc-val" style="color:var(--blue-soft);"><?= $avgBP ?> <span style="font-size:16px;font-weight:400;color:var(--tx-muted);">mmHg</span></div>
      <div class="tc-bar-track">
        <div class="tc-bar-fill" data-width="<?= min(100,round($avgBP/180*100)) ?>" style="background:linear-gradient(90deg,#3b82f6,#60a5fa);box-shadow:0 0 6px rgba(59,130,246,0.5);"></div>
      </div>
      <div class="tc-status">Target: &lt;120 mmHg systolic</div>
    </div>
    <div class="trend-cell">
      <div class="tc-label">Avg Heart Rate</div>
      <div class="tc-val" style="color:var(--red-soft);"><?= $avgHR ?> <span style="font-size:16px;font-weight:400;color:var(--tx-muted);">bpm</span></div>
      <div class="tc-bar-track">
        <div class="tc-bar-fill" data-width="<?= min(100,round($avgHR/120*100)) ?>" style="background:linear-gradient(90deg,#ef4444,#fca5a5);box-shadow:0 0 6px rgba(239,68,68,0.5);"></div>
      </div>
      <div class="tc-status">Target: 60–100 bpm resting</div>
    </div>
    <div class="trend-cell">
      <div class="tc-label">Avg Blood Sugar</div>
      <div class="tc-val" style="color:var(--violet-soft);"><?= $avgBS ?> <span style="font-size:16px;font-weight:400;color:var(--tx-muted);">mg/dL</span></div>
      <div class="tc-bar-track">
        <div class="tc-bar-fill" data-width="<?= min(100,round($avgBS/200*100)) ?>" style="background:linear-gradient(90deg,#8b5cf6,#a78bfa);box-shadow:0 0 6px rgba(139,92,246,0.5);"></div>
      </div>
      <div class="tc-status">Target: 70–99 mg/dL fasting</div>
    </div>
  </div>
</div>

</div><!-- /.prog -->

<script>
/* ── Animate trend bars on scroll ── */
(function() {
  const bars = document.querySelectorAll('.tc-bar-fill[data-width]');
  const obs  = new IntersectionObserver((entries) => {
    entries.forEach(e => {
      if (e.isIntersecting) {
        setTimeout(() => { e.target.style.width = e.target.dataset.width + '%'; }, 150);
        obs.unobserve(e.target);
      }
    });
  }, { threshold:0.3 });
  bars.forEach(b => obs.observe(b));
})();

/* ── Count-up for summary values ── */
function animateCount(el, target, duration, suffix) {
  let start = null;
  const step = (ts) => {
    if (!start) start = ts;
    const p    = Math.min((ts - start) / duration, 1);
    const ease = 1 - Math.pow(1 - p, 3);
    el.textContent = Math.round(target * ease) + (suffix || '');
    if (p < 1) requestAnimationFrame(step);
    else el.textContent = target + (suffix || '');
  };
  requestAnimationFrame(step);
}
setTimeout(() => {
  animateCount(document.getElementById('avgBpVal'), <?= $avgBP ?>, 1200);
  animateCount(document.getElementById('avgHrVal'), <?= $avgHR ?>, 1200);
  animateCount(document.getElementById('avgBsVal'), <?= $avgBS ?>, 1200);
}, 500);

/* ── Chart defaults ── */
const allRecords = <?= json_encode(array_reverse($records)) ?>;
const bpLabels   = allRecords.map(r => { const d=new Date(r.date); return d.toLocaleDateString('en-US',{month:'short',day:'numeric'}); });
const sysList    = allRecords.map(r => r.systolic_bp);
const diaList    = allRecords.map(r => r.diastolic_bp);

const chartDefaults = {
  responsive:true, maintainAspectRatio:false,
  animation:{ duration:1100, easing:'easeInOutQuart' },
  plugins:{
    legend:{ display:false },
    tooltip:{
      backgroundColor:'#070d1a', borderColor:'rgba(255,255,255,0.11)', borderWidth:1,
      titleColor:'#f0f4ff', bodyColor:'#7a9cc4',
      padding:16, cornerRadius:12, boxPadding:7,
      titleFont:{ family:"'DM Sans',sans-serif", weight:'600', size:14 },
      bodyFont:{ family:"'DM Mono',monospace", size:13 },
    }
  },
  scales:{
    x:{ ticks:{ color:'#3d5470', font:{size:12,family:"'DM Mono',monospace"} }, grid:{ color:'rgba(255,255,255,0.03)',drawBorder:false } },
    y:{ ticks:{ color:'#3d5470', font:{size:12,family:"'DM Mono',monospace"} }, grid:{ color:'rgba(255,255,255,0.03)',drawBorder:false } }
  }
};

new Chart(document.getElementById('weightChart').getContext('2d'), {
  type:'line',
  data:{
    labels:<?= json_encode($weightLabels) ?>,
    datasets:[{
      label:'Weight (kg)', data:<?= json_encode($weightData) ?>,
      borderColor:'#f97316',
      backgroundColor:(ctx)=>{ const g=ctx.chart.ctx.createLinearGradient(0,0,0,230); g.addColorStop(0,'rgba(249,115,22,0.2)'); g.addColorStop(1,'rgba(249,115,22,0)'); return g; },
      fill:true, pointBackgroundColor:'#f97316',
      pointBorderColor:'#04080f', pointBorderWidth:2,
      borderWidth:2.5, tension:0.44, pointRadius:5, pointHoverRadius:9,
    }]
  },
  options:{...chartDefaults}
});

new Chart(document.getElementById('hrChart').getContext('2d'), {
  type:'bar',
  data:{
    labels:<?= json_encode($weightLabels) ?>,
    datasets:[{
      label:'Heart Rate (bpm)', data:<?= json_encode($hrData) ?>,
      backgroundColor:'rgba(239,68,68,0.2)', borderColor:'#ef4444',
      borderWidth:2, borderRadius:8, borderSkipped:false,
      hoverBackgroundColor:'rgba(239,68,68,0.34)',
    }]
  },
  options:{...chartDefaults}
});

new Chart(document.getElementById('bpChart').getContext('2d'), {
  type:'line',
  data:{
    labels:bpLabels,
    datasets:[
      {
        label:'Systolic', data:sysList, borderColor:'#ef4444',
        backgroundColor:(ctx)=>{ const g=ctx.chart.ctx.createLinearGradient(0,0,0,280); g.addColorStop(0,'rgba(239,68,68,0.16)'); g.addColorStop(1,'rgba(239,68,68,0)'); return g; },
        fill:true, pointBackgroundColor:'#ef4444',
        pointBorderColor:'#04080f', pointBorderWidth:2,
        borderWidth:2.5, tension:0.44, pointRadius:4, pointHoverRadius:8,
      },
      {
        label:'Diastolic', data:diaList, borderColor:'#60a5fa',
        backgroundColor:(ctx)=>{ const g=ctx.chart.ctx.createLinearGradient(0,0,0,280); g.addColorStop(0,'rgba(96,165,250,0.14)'); g.addColorStop(1,'rgba(96,165,250,0)'); return g; },
        fill:true, pointBackgroundColor:'#60a5fa',
        pointBorderColor:'#04080f', pointBorderWidth:2,
        borderWidth:2.5, tension:0.44, pointRadius:4, pointHoverRadius:8,
      }
    ]
  },
  options:{...chartDefaults, interaction:{mode:'index',intersect:false}}
});
</script>

<?php require_once APP_PATH . '/views/shared/footer.php'; ?>