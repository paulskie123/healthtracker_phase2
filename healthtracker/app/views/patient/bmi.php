<?php
$pageTitle  = 'BMI Calculator';
$activePage = 'bmi';
require_once APP_PATH . '/views/shared/header.php';
?>

<style>
@import url('https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;0,9..40,800;1,9..40,400&family=DM+Mono:wght@300;400;500&display=swap');

:root {
  --font-sans:'DM Sans',sans-serif; --font-mono:'DM Mono',monospace;
  --bg-root:#04080f; --bg-surface:#070d1a;
  --bg-card:rgba(9,16,32,0.85); --bg-raised:rgba(12,22,42,0.72);
  --bg-input:rgba(6,12,24,0.92); --bg-pill:rgba(255,255,255,0.04);
  --bd-subtle:rgba(255,255,255,0.05); --bd-default:rgba(255,255,255,0.09); --bd-strong:rgba(255,255,255,0.16);
  --teal:#00e5b8; --teal-dim:rgba(0,229,184,0.09); --teal-glow:rgba(0,229,184,0.22);
  --cyan:#18d4f0; --cyan-dim:rgba(24,212,240,0.09);
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

@keyframes fadeUp   { from{opacity:0;transform:translateY(24px)} to{opacity:1;transform:translateY(0)} }
@keyframes fadeIn   { from{opacity:0} to{opacity:1} }
@keyframes floatY   { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-5px)} }
@keyframes shimmer  { 0%{transform:translateX(-100%)} 100%{transform:translateX(200%)} }
@keyframes resultIn { from{opacity:0;transform:translateY(16px)scale(0.97)} to{opacity:1;transform:translateY(0)scale(1)} }
@keyframes ringFill { from{stroke-dashoffset:282} }
@keyframes glowPulse{ 0%,100%{opacity:0.6} 50%{opacity:1} }
@keyframes borderGlow{ 0%,100%{box-shadow:0 0 0 0 rgba(0,229,184,0)} 50%{box-shadow:0 0 0 4px rgba(0,229,184,0.08)} }
@keyframes bounceIn { 0%{transform:scale(0.9);opacity:0} 60%{transform:scale(1.03)} 100%{transform:scale(1);opacity:1} }
@keyframes inputFocus{ from{box-shadow:0 0 0 0 rgba(0,229,184,0.08)} to{box-shadow:0 0 0 4px rgba(0,229,184,0.12)} }

/* ── Ambient background ── */
.bg-mesh { position:fixed; inset:0; z-index:0; pointer-events:none; overflow:hidden; }
.bg-mesh::before {
  content:''; position:absolute; border-radius:50%; filter:blur(130px);
  width:1000px; height:800px; top:-200px; right:-190px;
  background:radial-gradient(ellipse,rgba(0,229,184,0.05) 0%,rgba(59,130,246,0.045) 55%,transparent 75%);
  animation:mA 22s ease-in-out infinite;
}
.bg-mesh::after {
  content:''; position:absolute; border-radius:50%; filter:blur(120px);
  width:800px; height:650px; bottom:-140px; left:-140px;
  background:radial-gradient(ellipse,rgba(139,92,246,0.045) 0%,rgba(24,212,240,0.035) 60%,transparent 80%);
  animation:mB 28s ease-in-out infinite;
}
.bg-orb3 {
  position:fixed; width:500px; height:400px;
  top:50%; left:45%; transform:translate(-50%,-50%);
  border-radius:50%; pointer-events:none; z-index:0;
  background:radial-gradient(ellipse,rgba(245,158,11,0.028) 0%,transparent 70%);
  filter:blur(100px); animation:mC 34s ease-in-out infinite;
}
.bg-grid {
  position:fixed; inset:0; z-index:0; pointer-events:none;
  background-image:linear-gradient(rgba(255,255,255,0.014) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,0.014) 1px,transparent 1px);
  background-size:60px 60px;
  mask-image:radial-gradient(ellipse 80% 80% at 50% 50%,black 20%,transparent 100%);
}
@keyframes mA { 0%,100%{transform:translate(0,0)scale(1)} 40%{transform:translate(-48px,36px)scale(1.07)} 70%{transform:translate(30px,-24px)scale(0.97)} }
@keyframes mB { 0%,100%{transform:translate(0,0)scale(1)} 35%{transform:translate(40px,-30px)scale(1.05)} 65%{transform:translate(-20px,20px)scale(0.98)} }
@keyframes mC { 0%,100%{transform:translate(-50%,-50%)scale(1)} 50%{transform:translate(-50%,-57%)scale(1.1)} }

/* ── Root ── */
.bmi-root {
  position:relative; z-index:1; font-family:var(--font-sans); color:var(--tx-primary);
  max-width:920px; margin:0 auto; padding:4px 0 60px;
}

/* ── Page header ── */
.pg-header {
  display:flex; align-items:flex-end; justify-content:space-between;
  margin-bottom:36px; gap:18px; flex-wrap:wrap;
  opacity:0; animation:fadeUp 0.65s 0.05s var(--ease) forwards;
}
.pg-eyebrow {
  font-family:var(--font-mono); font-size:11px; font-weight:500; letter-spacing:2.5px;
  text-transform:uppercase; color:var(--teal); margin-bottom:8px;
  display:flex; align-items:center; gap:10px;
}
.pg-eyebrow::before { content:''; width:22px; height:1px; background:var(--teal); opacity:0.45; }
.pg-title { font-size:44px; font-weight:800; letter-spacing:-1.2px; line-height:1.1; }
.pg-sub   { font-size:15px; color:var(--tx-secondary); margin-top:7px; font-weight:400; }

.live-pill {
  display:inline-flex; align-items:center; gap:8px;
  background:rgba(0,229,184,0.06); border:1px solid rgba(0,229,184,0.22);
  color:var(--teal); font-family:var(--font-mono); font-size:10px; font-weight:500;
  letter-spacing:1.8px; text-transform:uppercase; padding:9px 18px; border-radius:100px;
  animation:borderGlow 3s ease-in-out infinite;
}
.live-dot { width:6px; height:6px; border-radius:50%; background:var(--teal); box-shadow:0 0 8px var(--teal); animation:glowPulse 2.2s ease-in-out infinite; }

/* ── Section heading ── */
.sec-head { display:flex; align-items:center; gap:14px; margin-bottom:18px; }
.sec-title { font-size:12px; font-weight:600; text-transform:uppercase; letter-spacing:1.6px; color:var(--tx-muted); font-family:var(--font-mono); }
.sec-line  { flex:1; height:1px; background:linear-gradient(90deg,var(--bd-default),transparent); }

/* ── Cards ── */
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
.ico-violet { background:var(--violet-dim); border:1px solid rgba(139,92,246,0.18); }
.ico-amber  { background:var(--amber-dim);  border:1px solid rgba(245,158,11,0.18); }
.ico-blue   { background:var(--blue-dim);   border:1px solid rgba(59,130,246,0.18); }
.ico-green  { background:var(--green-dim);  border:1px solid rgba(16,185,129,0.18); }
.ico-orange { background:var(--orange-dim); border:1px solid rgba(249,115,22,0.18); }

/* ── Form ── */
.form-grid { display:grid; grid-template-columns:1fr 1fr 1fr; gap:18px; margin-bottom:22px; }
@media(max-width:640px) { .form-grid { grid-template-columns:1fr 1fr; } }
@media(max-width:420px) { .form-grid { grid-template-columns:1fr; } }
.field-group { display:flex; flex-direction:column; gap:8px; }
.field-label { font-family:var(--font-mono); font-size:11px; font-weight:500; letter-spacing:1.2px; text-transform:uppercase; color:var(--tx-muted); }
.field-input {
  background:var(--bg-input); border:1px solid var(--bd-default);
  border-radius:var(--r-sm); color:var(--tx-primary);
  font-size:17px; font-family:var(--font-sans); font-weight:500;
  padding:14px 18px; outline:none;
  transition:border-color 0.22s var(--ease),box-shadow 0.22s var(--ease),transform 0.18s var(--ease);
}
.field-input:focus {
  border-color:var(--teal);
  box-shadow:0 0 0 4px rgba(0,229,184,0.1);
  transform:translateY(-1px);
}
.field-input:hover:not(:focus) { border-color:var(--bd-strong); }
.field-input::placeholder { color:var(--tx-faint); font-weight:400; }

/* ── CTA button ── */
.btn-calc {
  width:100%; padding:18px;
  background:linear-gradient(135deg,var(--teal),var(--cyan));
  color:#021a13; font-weight:800; font-size:17px; letter-spacing:-0.3px;
  border:none; border-radius:var(--r-md); cursor:pointer;
  font-family:var(--font-sans);
  box-shadow:0 6px 26px rgba(0,229,184,0.32);
  transition:all 0.25s var(--ease);
  position:relative; overflow:hidden;
}
.btn-calc::before {
  content:''; position:absolute; top:0; left:-60%; width:40%; height:100%;
  background:linear-gradient(105deg,transparent,rgba(255,255,255,0.18),transparent);
  transition:left 0.5s var(--ease);
}
.btn-calc:hover::before { left:120%; }
.btn-calc:hover { transform:translateY(-3px); box-shadow:0 12px 40px rgba(0,229,184,0.48); }
.btn-calc:active { transform:translateY(0); box-shadow:0 4px 16px rgba(0,229,184,0.3); }

/* ── Result panel ── */
#resultPanel { display:none; margin-top:28px; }
#resultPanel.show { animation:resultIn 0.45s var(--ease-spring) both; }

.result-main {
  display:flex; align-items:center; gap:32px; flex-wrap:wrap;
  padding:28px 32px;
  background:var(--bg-raised); border:1px solid var(--bd-default);
  border-radius:var(--r-xl); margin-bottom:18px;
  position:relative; overflow:hidden;
}
.result-main::before {
  content:''; position:absolute; top:0; left:0; right:0; height:1px;
  background:linear-gradient(90deg,transparent,rgba(0,229,184,0.35),rgba(59,130,246,0.3),transparent);
}

/* Animated ring */
.result-ring { position:relative; width:130px; height:130px; flex-shrink:0; animation:floatY 5s ease-in-out infinite; }
.result-ring svg { transform:rotate(-90deg); display:block; }
.rr-track { fill:none; stroke:rgba(255,255,255,0.06); stroke-width:9; }
.rr-fill  {
  fill:none; stroke-width:9; stroke-linecap:round;
  stroke-dasharray:339; stroke-dashoffset:339;
  transition:stroke-dashoffset 1.6s cubic-bezier(.23,1,.32,1),stroke 0.4s;
}
.rr-center { position:absolute; inset:0; display:flex; flex-direction:column; align-items:center; justify-content:center; }
.rr-num { font-size:34px; font-weight:800; line-height:1; letter-spacing:-1px; }
.rr-lbl { font-family:var(--font-mono); font-size:9px; font-weight:500; letter-spacing:2px; text-transform:uppercase; color:var(--tx-muted); margin-top:4px; }

.result-info { flex:1; min-width:200px; }
.result-category { font-size:28px; font-weight:800; letter-spacing:-0.6px; margin-bottom:7px; line-height:1.1; }
.result-range    { font-size:14px; color:var(--tx-secondary); margin-bottom:12px; font-family:var(--font-mono); }
.result-advice   { font-size:14px; color:var(--tx-secondary); line-height:1.65; font-weight:400; }

/* Category cards */
.cat-row {
  display:grid; grid-template-columns:repeat(4,1fr); gap:12px; margin-bottom:22px;
}
@media(max-width:700px) { .cat-row { grid-template-columns:repeat(2,1fr); } }
.cat-card {
  padding:16px 18px; border-radius:var(--r-md);
  border:1px solid var(--bd-subtle);
  background:var(--bg-raised);
  transition:all 0.25s var(--ease-spring);
  position:relative; overflow:hidden; cursor:default;
}
.cat-card::before {
  content:''; position:absolute; top:0; left:0; right:0; height:2px;
  opacity:0; transition:opacity 0.25s; background:currentColor;
}
.cat-card.active { border-color:currentColor; box-shadow:0 0 24px -8px currentColor; transform:translateY(-3px); }
.cat-card.active::before { opacity:0.75; }
.cat-card:not(.active):hover { border-color:var(--bd-default); transform:translateY(-2px); }
.cat-emoji { font-size:20px; margin-bottom:10px; transition:transform 0.3s var(--ease-spring); }
.cat-card:hover .cat-emoji { transform:scale(1.2); }
.cat-name  { font-size:13px; font-weight:600; margin-bottom:4px; }
.cat-range { font-family:var(--font-mono); font-size:11px; color:var(--tx-muted); font-weight:400; }
.cat-uw { color:var(--blue-soft); } .cat-nm { color:var(--green-soft); }
.cat-ow { color:var(--amber-soft); } .cat-ob { color:var(--red-soft); }

/* Gauge strip */
.gauge-strip {
  padding:18px 22px; background:var(--bg-raised); border:1px solid var(--bd-subtle);
  border-radius:var(--r-md); margin-bottom:22px;
}
.gauge-bar {
  height:10px; border-radius:8px;
  background:linear-gradient(to right,#60a5fa 0%,#6ee7b7 28%,#fcd34d 58%,#f97316 78%,#fca5a5 100%);
  margin-bottom:10px; position:relative;
  box-shadow:0 2px 12px rgba(0,0,0,0.3);
}
.gauge-needle {
  position:absolute; top:-6px; width:4px; height:22px;
  background:#fff; border-radius:3px; transform:translateX(-50%);
  transition:left 1s cubic-bezier(.23,1,.32,1);
  box-shadow:0 0 10px rgba(255,255,255,0.7),0 0 20px rgba(255,255,255,0.3);
}
.gauge-labels { display:flex; justify-content:space-between; font-family:var(--font-mono); font-size:10px; color:var(--tx-muted); letter-spacing:0.5px; text-transform:uppercase; }

/* Insights grid */
.insights-grid { display:grid; grid-template-columns:1fr 1fr; gap:14px; }
@media(max-width:640px) { .insights-grid { grid-template-columns:1fr; } }
.ins-item {
  display:flex; align-items:flex-start; gap:14px;
  padding:18px 20px; background:var(--bg-raised);
  border:1px solid var(--bd-subtle); border-radius:var(--r-md);
  transition:all 0.25s var(--ease); position:relative; overflow:hidden;
}
.ins-item::before {
  content:''; position:absolute; left:0; top:0; bottom:0; width:2px;
  opacity:0; transition:opacity 0.25s; background:var(--teal);
}
.ins-item:hover { border-color:var(--bd-default); transform:translateY(-3px); box-shadow:0 8px 28px rgba(0,0,0,0.4); }
.ins-item:hover::before { opacity:1; }
.ins-ico-wrap { width:36px; height:36px; border-radius:10px; display:flex; align-items:center; justify-content:center; font-size:15px; flex-shrink:0; transition:transform 0.3s var(--ease-spring); }
.ins-item:hover .ins-ico-wrap { transform:scale(1.12) rotate(-5deg); }
.ins-heading { font-size:14px; font-weight:600; color:var(--tx-primary); margin-bottom:5px; }
.ins-desc    { font-size:12px; color:var(--tx-secondary); line-height:1.6; }
.ico-teal   { background:var(--teal-dim);   border:1px solid rgba(0,229,184,0.18); }
.ico-blue   { background:var(--blue-dim);   border:1px solid rgba(59,130,246,0.18); }
.ico-amber  { background:var(--amber-dim);  border:1px solid rgba(245,158,11,0.18); }
.ico-violet { background:var(--violet-dim); border:1px solid rgba(139,92,246,0.18); }
.ico-red    { background:var(--red-dim);    border:1px solid rgba(239,68,68,0.18); }
.ico-orange { background:var(--orange-dim); border:1px solid rgba(249,115,22,0.18); }
.ico-green  { background:var(--green-dim);  border:1px solid rgba(16,185,129,0.18); }

/* ── Summary chips ── */
.summary-row {
  display:grid; grid-template-columns:repeat(4,1fr); gap:16px; margin-bottom:22px;
}
@media(max-width:800px) { .summary-row { grid-template-columns:repeat(2,1fr); } }
.sum-chip {
  background:var(--bg-raised); border:1px solid var(--bd-subtle);
  border-radius:var(--r-md); padding:18px 20px;
  transition:all 0.25s var(--ease-spring);
}
.sum-chip:hover { border-color:var(--bd-default); transform:translateY(-3px); box-shadow:0 8px 28px rgba(0,0,0,0.4); }
.sum-chip-lbl { font-family:var(--font-mono); font-size:10px; font-weight:500; letter-spacing:1.2px; text-transform:uppercase; color:var(--tx-muted); margin-bottom:10px; }
.sum-chip-val { font-size:24px; font-weight:800; letter-spacing:-0.6px; line-height:1; margin-bottom:5px; }
.sum-chip-sub { font-size:12px; color:var(--tx-muted); font-weight:400; }

/* ── History table ── */
.history-wrap { border-radius:var(--r-md); overflow:hidden; border:1px solid var(--bd-subtle); }
.history-table { width:100%; border-collapse:collapse; }
.history-table thead tr { background:rgba(255,255,255,0.025); }
.history-table th {
  text-align:left; font-family:var(--font-mono); font-size:11px; font-weight:500;
  letter-spacing:1.2px; text-transform:uppercase; color:var(--tx-muted);
  padding:14px 18px; border-bottom:1px solid var(--bd-subtle); white-space:nowrap;
}
.history-table td {
  padding:15px 18px; font-size:14px; color:var(--tx-primary);
  border-bottom:1px solid rgba(255,255,255,0.03);
  transition:background 0.18s var(--ease);
}
.history-table tbody tr:last-child td { border-bottom:none; }
.history-table tbody tr:hover td { background:rgba(255,255,255,0.025); }
.td-date   { color:var(--tx-secondary); font-size:13px; font-family:var(--font-mono); }
.td-weight { font-family:var(--font-mono); font-size:14px; font-weight:500; }
.td-bmi    { font-family:var(--font-mono); font-size:16px; font-weight:800; }
.hbadge {
  display:inline-flex; align-items:center; gap:6px;
  font-size:12px; font-weight:500; padding:4px 12px; border-radius:100px;
}
.hbadge-dot { width:6px; height:6px; border-radius:50%; flex-shrink:0; }
.hb-blue  { background:var(--blue-dim);  color:var(--blue-soft);  border:1px solid rgba(59,130,246,0.24); }
.hb-blue  .hbadge-dot { background:var(--blue-soft);  box-shadow:0 0 6px rgba(96,165,250,0.7); }
.hb-green { background:var(--green-dim); color:var(--green-soft); border:1px solid rgba(16,185,129,0.24); }
.hb-green .hbadge-dot { background:var(--green-soft); box-shadow:0 0 6px rgba(110,231,183,0.7); }
.hb-amber { background:var(--amber-dim); color:var(--amber-soft); border:1px solid rgba(245,158,11,0.24); }
.hb-amber .hbadge-dot { background:var(--amber-soft); box-shadow:0 0 6px rgba(252,211,77,0.7); }
.hb-red   { background:var(--red-dim);   color:var(--red-soft);   border:1px solid rgba(239,68,68,0.24); }
.hb-red   .hbadge-dot { background:var(--red-soft);   box-shadow:0 0 6px rgba(252,165,165,0.7); }
.trend-up   { color:var(--green-soft); font-size:12px; font-family:var(--font-mono); }
.trend-down { color:var(--red-soft);   font-size:12px; font-family:var(--font-mono); }
.trend-flat { color:var(--tx-muted);   font-size:12px; font-family:var(--font-mono); }

/* ── Tips ── */
.tip-grid { display:grid; grid-template-columns:1fr 1fr; gap:14px; }
@media(max-width:580px) { .tip-grid { grid-template-columns:1fr; } }
.tip-card {
  background:var(--bg-raised); border:1px solid var(--bd-subtle);
  border-radius:var(--r-md); padding:20px 22px;
  display:flex; align-items:flex-start; gap:16px;
  transition:all 0.25s var(--ease-spring);
  position:relative; overflow:hidden;
}
.tip-card::before {
  content:''; position:absolute; top:0; left:0; right:0; height:2px; opacity:0.65;
}
.tip-card.tip-blue::before   { background:linear-gradient(90deg,transparent 10%,#60a5fa,transparent 90%); }
.tip-card.tip-green::before  { background:linear-gradient(90deg,transparent 10%,#6ee7b7,transparent 90%); }
.tip-card.tip-amber::before  { background:linear-gradient(90deg,transparent 10%,#fcd34d,transparent 90%); }
.tip-card.tip-red::before    { background:linear-gradient(90deg,transparent 10%,#fca5a5,transparent 90%); }
.tip-card:hover { border-color:var(--bd-default); transform:translateY(-3px); box-shadow:0 10px 32px rgba(0,0,0,0.48); }
.tip-ico-wrap { width:42px; height:42px; border-radius:12px; flex-shrink:0; display:flex; align-items:center; justify-content:center; font-size:19px; transition:transform 0.3s var(--ease-spring); }
.tip-card:hover .tip-ico-wrap { transform:scale(1.12) rotate(-5deg); }
.tip-blue  .tip-ico-wrap { background:var(--blue-dim);  border:1px solid rgba(59,130,246,0.2); }
.tip-green .tip-ico-wrap { background:var(--green-dim); border:1px solid rgba(16,185,129,0.2); }
.tip-amber .tip-ico-wrap { background:var(--amber-dim); border:1px solid rgba(245,158,11,0.2); }
.tip-red   .tip-ico-wrap { background:var(--red-dim);   border:1px solid rgba(239,68,68,0.2); }
.tip-name { font-size:14px; font-weight:600; color:var(--tx-primary); margin-bottom:6px; letter-spacing:-0.15px; }
.tip-desc { font-size:13px; color:var(--tx-secondary); line-height:1.6; font-weight:400; }

.footnote { font-family:var(--font-mono); font-size:12px; color:var(--tx-muted); margin-top:16px; }
.divider  { height:1px; background:var(--bd-subtle); margin:6px 0 22px; }
</style>

<div class="bg-mesh"></div>
<div class="bg-orb3"></div>
<div class="bg-grid"></div>

<div class="bmi-root">

<!-- ─── PAGE HEADER ─── -->
<div class="pg-header">
  <div>
    <div class="pg-eyebrow">Health Tools</div>
    <div class="pg-title">BMI Calculator</div>
    <div class="pg-sub">Body Mass Index — understand your weight relative to your height.</div>
  </div>
  <div class="live-pill"><span class="live-dot"></span> Interactive</div>
</div>

<!-- ─── CALCULATOR FORM ─── -->
<div class="sec-head" style="opacity:0;animation:fadeIn 0.5s 0.18s var(--ease) forwards;">
  <span class="sec-title">Calculate</span><span class="sec-line"></span>
</div>

<div class="card" style="animation-delay:0.22s;">
  <div class="card-head">
    <div class="card-title">
      <div class="card-ico ico-teal">⚖️</div>
      Your Measurements
    </div>
  </div>

  <div class="form-grid">
    <div class="field-group">
      <label class="field-label">Height (cm)</label>
      <input type="number" class="field-input" id="height" placeholder="e.g. 170" min="50" max="250">
    </div>
    <div class="field-group">
      <label class="field-label">Weight (kg)</label>
      <input type="number" class="field-input" id="weight" placeholder="e.g. 65" min="10" max="300"
             value="<?= !empty($records) ? htmlspecialchars($records[0]['weight']) : '' ?>">
    </div>
    <div class="field-group">
      <label class="field-label">Age</label>
      <input type="number" class="field-input" id="age" placeholder="e.g. 25" min="1" max="120"
             value="<?= htmlspecialchars($user['age'] ?? '') ?>">
    </div>
  </div>

  <button class="btn-calc" onclick="calculateBMI()">Calculate BMI →</button>

  <!-- ─── RESULT PANEL ─── -->
  <div id="resultPanel">

    <div class="result-main">
      <div class="result-ring">
        <svg width="130" height="130" viewBox="0 0 130 130">
          <circle class="rr-track" cx="65" cy="65" r="54"/>
          <circle class="rr-fill"  cx="65" cy="65" r="54" id="rrArc"/>
        </svg>
        <div class="rr-center">
          <span class="rr-num" id="bmiNumber">--</span>
          <span class="rr-lbl">BMI</span>
        </div>
      </div>
      <div class="result-info">
        <div class="result-category" id="bmiLabel">--</div>
        <div class="result-range"   id="bmiRange">--</div>
        <div class="result-advice"  id="bmiAdvice"></div>
      </div>
    </div>

    <div class="gauge-strip">
      <div class="gauge-bar">
        <div class="gauge-needle" id="needle" style="left:0%"></div>
      </div>
      <div class="gauge-labels">
        <span>Underweight</span><span>Normal</span><span>Overweight</span><span>Obese</span>
      </div>
    </div>

    <div class="cat-row">
      <div class="cat-card cat-uw" id="cat-uw">
        <div class="cat-emoji">🔵</div>
        <div class="cat-name">Underweight</div>
        <div class="cat-range">&lt; 18.5</div>
      </div>
      <div class="cat-card cat-nm" id="cat-nm">
        <div class="cat-emoji">🟢</div>
        <div class="cat-name">Normal</div>
        <div class="cat-range">18.5 – 24.9</div>
      </div>
      <div class="cat-card cat-ow" id="cat-ow">
        <div class="cat-emoji">🟡</div>
        <div class="cat-name">Overweight</div>
        <div class="cat-range">25 – 29.9</div>
      </div>
      <div class="cat-card cat-ob" id="cat-ob">
        <div class="cat-emoji">🔴</div>
        <div class="cat-name">Obese</div>
        <div class="cat-range">≥ 30</div>
      </div>
    </div>

    <div class="sec-head" style="margin-top:10px;">
      <span class="sec-title">Health Insights</span><span class="sec-line"></span>
    </div>
    <div class="insights-grid" id="insightsGrid"></div>

  </div><!-- /#resultPanel -->
</div>

<!-- ─── BMI HISTORY ─── -->
<?php if (!empty($records)): ?>
<?php
  $h0  = $user['height'] ?? 170;
  $w0  = $records[0]['weight'];
  $latestBMI = $h0 > 0 ? round($w0 / (($h0/100)**2), 1) : null;
  $latestDate = date('M d, Y', strtotime($records[0]['date']));
  $latestCat = '';
  if ($latestBMI) {
    if      ($latestBMI < 18.5) $latestCat = 'Underweight';
    elseif  ($latestBMI < 25)   $latestCat = 'Normal';
    elseif  ($latestBMI < 30)   $latestCat = 'Overweight';
    else                        $latestCat = 'Obese';
  }
  $healthyLow  = round($h0 > 0 ? 18.5 * (($h0/100)**2) : 0, 1);
  $healthyHigh = round($h0 > 0 ? 24.9 * (($h0/100)**2) : 0, 1);
?>

<div class="sec-head" style="margin-top:32px;opacity:0;animation:fadeIn 0.5s 0.45s var(--ease) forwards;">
  <span class="sec-title">BMI History</span><span class="sec-line"></span>
</div>

<div class="summary-row" style="opacity:0;animation:fadeUp 0.65s 0.50s var(--ease) forwards;">
  <div class="sum-chip">
    <div class="sum-chip-lbl">Current BMI</div>
    <div class="sum-chip-val" style="color:var(--teal);"><?= $latestBMI ?? '—' ?></div>
    <div class="sum-chip-sub">Latest record</div>
  </div>
  <div class="sum-chip">
    <div class="sum-chip-lbl">Healthy Range</div>
    <div class="sum-chip-val" style="color:var(--green-soft);">18.5–24.9</div>
    <div class="sum-chip-sub">BMI scale</div>
  </div>
  <div class="sum-chip">
    <div class="sum-chip-lbl">Weight Status</div>
    <div class="sum-chip-val" style="color:var(--blue-soft);font-size:18px;"><?= $latestCat ?: '—' ?></div>
    <div class="sum-chip-sub">At <?= $latestDate ?></div>
  </div>
  <div class="sum-chip">
    <div class="sum-chip-lbl">Ideal Weight</div>
    <div class="sum-chip-val" style="color:var(--amber-soft);font-size:19px;"><?= $healthyLow ?>–<?= $healthyHigh ?></div>
    <div class="sum-chip-sub">kg for your height</div>
  </div>
</div>

<div class="card" style="animation-delay:0.55s;">
  <div class="card-head">
    <div class="card-title">
      <div class="card-ico ico-violet">📋</div>
      BMI History from Health Records
    </div>
  </div>
  <div class="history-wrap">
    <table class="history-table">
      <thead>
        <tr><th>Date</th><th>Weight</th><th>BMI</th><th>Category</th><th>Trend</th></tr>
      </thead>
      <tbody>
        <?php
        $slice = array_slice($records, 0, 8);
        $prevBMI = null;
        foreach ($slice as $idx => $r):
          $h    = $user['height'] ?? 170;
          $bmi  = $h > 0 ? round($r['weight'] / (($h/100) ** 2), 1) : null;
          $cat  = ''; $badgeClass = '';
          if ($bmi) {
            if      ($bmi < 18.5) { $cat = 'Underweight'; $badgeClass = 'hb-blue'; }
            elseif  ($bmi < 25)   { $cat = 'Normal';      $badgeClass = 'hb-green'; }
            elseif  ($bmi < 30)   { $cat = 'Overweight';  $badgeClass = 'hb-amber'; }
            else                  { $cat = 'Obese';       $badgeClass = 'hb-red'; }
          }
          $trendHtml = '<span class="trend-flat">—</span>';
          if ($prevBMI !== null && $bmi !== null) {
            $diff = $bmi - $prevBMI;
            if      ($diff > 0.1)  $trendHtml = '<span class="trend-up">↑ +'.round($diff,1).'</span>';
            elseif  ($diff < -0.1) $trendHtml = '<span class="trend-down">↓ '.round($diff,1).'</span>';
          }
          $prevBMI = $bmi;
        ?>
          <tr>
            <td class="td-date"><?= date('M d, Y', strtotime($r['date'])) ?></td>
            <td class="td-weight"><?= number_format($r['weight'],1) ?> kg</td>
            <td class="td-bmi"><?= $bmi ?? '—' ?></td>
            <td><?php if ($cat): ?><span class="hbadge <?= $badgeClass ?>"><span class="hbadge-dot"></span><?= $cat ?></span><?php endif; ?></td>
            <td><?= $trendHtml ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
  <p class="footnote">* BMI calculated using your profile height (<?= $user['height'] ?? 170 ?> cm). Update your profile to change it.</p>
</div>
<?php endif; ?>

<!-- ─── TIPS ─── -->
<div class="sec-head" style="opacity:0;animation:fadeIn 0.5s 0.62s var(--ease) forwards;">
  <span class="sec-title">BMI Reference Guide</span><span class="sec-line"></span>
</div>

<div class="card" style="animation-delay:0.66s;">
  <div class="card-head">
    <div class="card-title">
      <div class="card-ico ico-amber">💡</div>
      BMI Categories &amp; What They Mean
    </div>
  </div>
  <div class="tip-grid">
    <div class="tip-card tip-blue">
      <div class="tip-ico-wrap">🔵</div>
      <div>
        <div class="tip-name">Underweight &lt; 18.5</div>
        <div class="tip-desc">May indicate nutritional deficiency. Consult a doctor for a healthy weight gain plan.</div>
      </div>
    </div>
    <div class="tip-card tip-green">
      <div class="tip-ico-wrap">🟢</div>
      <div>
        <div class="tip-name">Normal 18.5 – 24.9</div>
        <div class="tip-desc">Healthy weight range. Maintain with balanced diet and regular physical activity.</div>
      </div>
    </div>
    <div class="tip-card tip-amber">
      <div class="tip-ico-wrap">🟡</div>
      <div>
        <div class="tip-name">Overweight 25 – 29.9</div>
        <div class="tip-desc">Slightly above healthy range. Consider increasing exercise and reducing calorie intake.</div>
      </div>
    </div>
    <div class="tip-card tip-red">
      <div class="tip-ico-wrap">🔴</div>
      <div>
        <div class="tip-name">Obese ≥ 30</div>
        <div class="tip-desc">Higher risk of health issues. Speak with a healthcare provider about a weight management plan.</div>
      </div>
    </div>
  </div>
</div>

</div><!-- /.bmi-root -->

<script>
function calculateBMI() {
    const h = parseFloat(document.getElementById('height').value);
    const w = parseFloat(document.getElementById('weight').value);
    if (!h || !w || h < 50 || w < 10) { alert('Please enter a valid height and weight.'); return; }
    const bmi   = w / ((h / 100) ** 2);
    const round = Math.round(bmi * 10) / 10;

    let label, color, strokeColor, range, advice, needle;
    let insightData = [];

    if (bmi < 18.5) {
        label='Underweight'; color='#60a5fa'; strokeColor='#3b82f6';
        range='BMI below 18.5';
        advice='You may be underweight. Consider speaking with a nutritionist for a healthy weight gain plan.';
        needle=Math.max(2,(bmi/18.5)*20);
        insightData=[
          {ico:'🍽️',cls:'ico-blue',   title:'Nutrition Focus',       desc:'Increase caloric intake with nutrient-dense foods — nuts, whole grains, lean proteins, and dairy.'},
          {ico:'💪',cls:'ico-green',  title:'Strength Training',      desc:'Resistance training helps build muscle mass and contributes to healthy weight gain.'},
          {ico:'⚖️',cls:'ico-amber',  title:'Healthy Weight Target',  desc:`Your target healthy weight is ${Math.round(18.5*(h/100)**2)}–${Math.round(24.9*(h/100)**2)} kg based on your height.`},
          {ico:'🩺',cls:'ico-violet', title:'Medical Consultation',   desc:'If underweight persists, consult a healthcare provider to rule out underlying conditions.'},
        ];
    } else if (bmi < 25) {
        label='Normal Weight'; color='#6ee7b7'; strokeColor='#10b981';
        range='BMI 18.5 – 24.9';
        advice="Great! You're in the healthy weight range. Maintain your current habits.";
        needle=20+((bmi-18.5)/6.5)*30;
        insightData=[
          {ico:'✅',cls:'ico-green',  title:'Healthy Range',          desc:'Your BMI is within the ideal range. Keep up your current diet and exercise routine.'},
          {ico:'🏃',cls:'ico-teal',   title:'Stay Active',            desc:'Aim for at least 150 minutes of moderate aerobic activity per week to maintain your score.'},
          {ico:'🥗',cls:'ico-amber',  title:'Balanced Diet',          desc:'Continue eating a variety of whole foods — fruits, vegetables, lean proteins, and healthy fats.'},
          {ico:'📅',cls:'ico-violet', title:'Regular Check-ups',      desc:'Schedule annual health screenings to keep an eye on blood pressure, sugar, and cholesterol.'},
        ];
    } else if (bmi < 30) {
        label='Overweight'; color='#fcd34d'; strokeColor='#f59e0b';
        range='BMI 25 – 29.9';
        advice='Slightly above the healthy range. Regular exercise and dietary changes can help significantly.';
        needle=50+((bmi-25)/5)*25;
        insightData=[
          {ico:'🏃',cls:'ico-amber',  title:'Increase Activity',      desc:'Add 30 minutes of moderate cardio 4–5 days a week. Walking, cycling, and swimming are great options.'},
          {ico:'🥦',cls:'ico-green',  title:'Dietary Adjustment',     desc:'Reduce processed foods and added sugars. Prioritize fiber-rich vegetables and lean proteins.'},
          {ico:'⚖️',cls:'ico-orange', title:'Weight Loss Target',     desc:`Losing ${Math.max(1,Math.round((bmi-24.9)*(h/100)**2))}–${Math.round((bmi-23)*(h/100)**2)} kg would bring you into the healthy BMI range.`},
          {ico:'💧',cls:'ico-blue',   title:'Hydration',              desc:'Drinking 2–3 liters of water daily can help manage hunger and support metabolism.'},
        ];
    } else {
        label='Obese'; color='#fca5a5'; strokeColor='#ef4444';
        range='BMI 30 and above';
        advice='Please consult a healthcare provider for personalized guidance on weight management.';
        needle=Math.min(98,75+((bmi-30)/10)*23);
        insightData=[
          {ico:'🩺',cls:'ico-red',    title:'Medical Consultation',   desc:'Speak with your doctor about a structured weight management program suited to your health profile.'},
          {ico:'🏃',cls:'ico-orange', title:'Low-Impact Exercise',    desc:'Start with gentle activities like walking or swimming to reduce joint strain while improving fitness.'},
          {ico:'🍎',cls:'ico-amber',  title:'Dietary Review',         desc:'Consider working with a registered dietitian to create a sustainable calorie-deficit eating plan.'},
          {ico:'📊',cls:'ico-violet', title:'Progress Tracking',      desc:'Monitor your weight weekly and track health records consistently to observe improvement trends.'},
        ];
    }

    /* Ring animation — r=54, circumference=339.3 */
    const arc  = document.getElementById('rrArc');
    const circ = 2 * Math.PI * 54;
    const pct  = Math.min(bmi / 40, 1);
    arc.style.stroke     = strokeColor;
    arc.style.filter     = `drop-shadow(0 0 10px ${strokeColor}99)`;
    const target = circ - circ * pct;
    arc.style.strokeDasharray  = circ;
    arc.style.strokeDashoffset = circ;
    requestAnimationFrame(() => { setTimeout(() => { arc.style.strokeDashoffset = target; }, 20); });

    /* Animate number */
    const numEl = document.getElementById('bmiNumber');
    numEl.style.color = color;
    let startNum = null;
    function animNum(ts) {
      if (!startNum) startNum = ts;
      const p = Math.min((ts - startNum) / 1000, 1);
      const e = 1 - Math.pow(1 - p, 3);
      numEl.textContent = (round * e).toFixed(1);
      if (p < 1) requestAnimationFrame(animNum); else numEl.textContent = round.toFixed(1);
    }
    requestAnimationFrame(animNum);

    document.getElementById('bmiLabel').textContent  = label;
    document.getElementById('bmiLabel').style.color  = color;
    document.getElementById('bmiRange').textContent  = range;
    document.getElementById('bmiAdvice').textContent = advice;
    document.getElementById('needle').style.left     = needle + '%';

    ['uw','nm','ow','ob'].forEach(c => document.getElementById('cat-'+c).classList.remove('active'));
    const catMap = { 'Underweight':'cat-uw', 'Normal Weight':'cat-nm', 'Overweight':'cat-ow', 'Obese':'cat-ob' };
    const activeId = catMap[label];
    if (activeId) document.getElementById(activeId).classList.add('active');

    const grid = document.getElementById('insightsGrid');
    grid.innerHTML = insightData.map((d,i) => `
      <div class="ins-item" style="opacity:0;animation:fadeUp 0.4s ${0.05*i}s var(--ease) forwards;">
        <div class="ins-ico-wrap ${d.cls}">${d.ico}</div>
        <div>
          <div class="ins-heading">${d.title}</div>
          <div class="ins-desc">${d.desc}</div>
        </div>
      </div>`).join('');

    const panel = document.getElementById('resultPanel');
    panel.style.display = 'block';
    panel.classList.remove('show');
    void panel.offsetWidth;
    panel.classList.add('show');
    panel.scrollIntoView({ behavior:'smooth', block:'nearest' });
}

document.getElementById('weight').addEventListener('keydown', e => { if (e.key==='Enter') calculateBMI(); });
document.getElementById('height').addEventListener('keydown', e => { if (e.key==='Enter') calculateBMI(); });
</script>

<?php require_once APP_PATH . '/views/shared/footer.php'; ?>