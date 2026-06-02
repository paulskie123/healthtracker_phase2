<?php
$pageTitle = 'Dashboard';
$activePage = 'dashboard';
require_once APP_PATH . '/views/shared/header.php';

$bp = $latest ? $latest['systolic_bp'].'/'.$latest['diastolic_bp'].' mmHg' : 'N/A';
$hr = $latest ? $latest['heart_rate'].' bpm' : 'N/A';
$wt = $latest ? $latest['weight'].' kg' : 'N/A';
$bs = $latest ? $latest['blood_sugar'].' mg/dL' : 'N/A';

$bpStatus = 'normal';
if ($latest) {
    if ($latest['systolic_bp'] >= 140 || $latest['diastolic_bp'] >= 90) $bpStatus = 'danger';
    elseif ($latest['systolic_bp'] >= 130) $bpStatus = 'warning';
}
?>

<style>
@import url('https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;0,9..40,800;1,9..40,400&family=DM+Mono:wght@300;400;500&display=swap');

:root {
  --font-sans: 'DM Sans', sans-serif;
  --font-mono: 'DM Mono', monospace;
  --bg-root:    #04080f;
  --bg-surface: #070d1a;
  --bg-card:    rgba(9,16,32,0.85);
  --bg-raised:  rgba(12,22,42,0.72);
  --bg-input:   rgba(6,12,24,0.92);
  --bg-pill:    rgba(255,255,255,0.04);
  --bd-subtle:  rgba(255,255,255,0.05);
  --bd-default: rgba(255,255,255,0.09);
  --bd-strong:  rgba(255,255,255,0.16);
  --teal:       #00e5b8; --teal-dim:   rgba(0,229,184,0.09); --teal-glow: rgba(0,229,184,0.22);
  --cyan:       #18d4f0; --cyan-dim:   rgba(24,212,240,0.09);
  --blue:       #3b82f6; --blue-dim:   rgba(59,130,246,0.11); --blue-soft:  #60a5fa;
  --violet-mid: #8b5cf6; --violet-dim: rgba(139,92,246,0.11); --violet-soft:#a78bfa;
  --pink:       #ec4899; --pink-dim:   rgba(236,72,153,0.11); --pink-soft:  #f9a8d4;
  --amber:      #f59e0b; --amber-dim:  rgba(245,158,11,0.11); --amber-soft: #fcd34d;
  --red:        #ef4444; --red-dim:    rgba(239,68,68,0.11);  --red-soft:   #fca5a5;
  --green:      #10b981; --green-dim:  rgba(16,185,129,0.11); --green-soft: #6ee7b7;
  --tx-primary:   #f0f4ff; --tx-secondary:#7a9cc4; --tx-muted:#3d5470; --tx-faint:#253347;
  --r-sm:10px; --r-md:14px; --r-lg:18px; --r-xl:22px; --r-2xl:28px;
  --sh-card:  0 1px 3px rgba(0,0,0,0.45), 0 8px 36px rgba(0,0,0,0.38);
  --sh-hover: 0 4px 12px rgba(0,0,0,0.55), 0 20px 56px rgba(0,0,0,0.55);
  --sh-inset: inset 0 1px 0 rgba(255,255,255,0.05);
  --ease: cubic-bezier(0.4,0,0.2,1);
  --ease-spring: cubic-bezier(0.34,1.56,0.64,1);
}
*,*::before,*::after { box-sizing:border-box; margin:0; padding:0; }

/* ── Page load animation ── */
@keyframes fadeUp {
  from { opacity:0; transform:translateY(24px); }
  to   { opacity:1; transform:translateY(0); }
}
@keyframes fadeIn {
  from { opacity:0; }
  to   { opacity:1; }
}
@keyframes scaleIn {
  from { opacity:0; transform:scale(0.94); }
  to   { opacity:1; transform:scale(1); }
}
@keyframes slideRight {
  from { opacity:0; transform:translateX(-16px); }
  to   { opacity:1; transform:translateX(0); }
}
@keyframes floatY {
  0%,100% { transform:translateY(0px); }
  50%     { transform:translateY(-5px); }
}
@keyframes pulseGlow {
  0%,100% { opacity:0.6; }
  50%     { opacity:1; }
}
@keyframes shimmer {
  0%   { transform:translateX(-100%); }
  100% { transform:translateX(200%); }
}
@keyframes ripple {
  0%   { transform:scale(0); opacity:1; }
  100% { transform:scale(2.5); opacity:0; }
}
@keyframes borderGlow {
  0%,100% { box-shadow: 0 0 0 0 rgba(0,229,184,0); }
  50%     { box-shadow: 0 0 0 4px rgba(0,229,184,0.1); }
}

/* ── Ambient background ── */
.bg-mesh { position:fixed; inset:0; z-index:0; pointer-events:none; overflow:hidden; }
.bg-mesh::before {
  content:''; position:absolute; border-radius:50%; filter:blur(130px);
  width:1000px; height:800px; top:-220px; right:-200px;
  background:radial-gradient(ellipse,rgba(0,229,184,0.055) 0%,rgba(59,130,246,0.05) 50%,transparent 75%);
  animation:meshDrift1 20s ease-in-out infinite;
}
.bg-mesh::after {
  content:''; position:absolute; border-radius:50%; filter:blur(120px);
  width:850px; height:650px; bottom:-160px; left:-160px;
  background:radial-gradient(ellipse,rgba(139,92,246,0.055) 0%,rgba(24,212,240,0.035) 60%,transparent 80%);
  animation:meshDrift2 26s ease-in-out infinite;
}
.bg-accent {
  position:fixed; width:550px; height:450px;
  top:45%; left:40%; transform:translate(-50%,-50%);
  border-radius:50%; pointer-events:none; z-index:0;
  background:radial-gradient(ellipse,rgba(59,130,246,0.03) 0%,transparent 70%);
  filter:blur(90px); animation:meshDrift3 32s ease-in-out infinite;
}
.bg-grid {
  position:fixed; inset:0; z-index:0; pointer-events:none;
  background-image:
    linear-gradient(rgba(255,255,255,0.015) 1px, transparent 1px),
    linear-gradient(90deg, rgba(255,255,255,0.015) 1px, transparent 1px);
  background-size: 60px 60px;
  mask-image: radial-gradient(ellipse 80% 80% at 50% 50%, black 20%, transparent 100%);
}
@keyframes meshDrift1 { 0%,100%{transform:translate(0,0)scale(1)} 40%{transform:translate(-55px,45px)scale(1.07)} 70%{transform:translate(32px,-28px)scale(0.96)} }
@keyframes meshDrift2 { 0%,100%{transform:translate(0,0)scale(1)} 35%{transform:translate(44px,-34px)scale(1.06)} 65%{transform:translate(-22px,22px)scale(0.97)} }
@keyframes meshDrift3 { 0%,100%{transform:translate(-50%,-50%)scale(1)} 50%{transform:translate(-50%,-56%)scale(1.12)} }
@keyframes meshDrift1 { 0%,100%{transform:translate(0,0)scale(1)} 40%{transform:translate(-50px,40px)scale(1.06)} 70%{transform:translate(30px,-25px)scale(0.96)} }
@keyframes meshDrift2 { 0%,100%{transform:translate(0,0)scale(1)} 35%{transform:translate(40px,-30px)scale(1.05)} 65%{transform:translate(-20px,20px)scale(0.98)} }

/* ── Root ── */
.dash {
  position:relative; z-index:1;
  font-family:var(--font-sans); color:var(--tx-primary);
  max-width:1380px; padding:4px 0 56px;
}

/* ── Staggered load animations ── */
.anim-load { opacity:0; animation:fadeUp 0.6s var(--ease) forwards; }
.anim-load:nth-child(1)  { animation-delay:0.05s; }
.anim-load:nth-child(2)  { animation-delay:0.12s; }
.anim-load:nth-child(3)  { animation-delay:0.19s; }
.anim-load:nth-child(4)  { animation-delay:0.26s; }
.anim-load:nth-child(5)  { animation-delay:0.33s; }
.anim-load:nth-child(6)  { animation-delay:0.40s; }

.anim-fade { opacity:0; animation:fadeIn 0.7s var(--ease) forwards; }

/* ── Welcome Banner ── */
.wb {
  position:relative; overflow:hidden;
  border-radius:var(--r-2xl); padding:40px 44px;
  margin-bottom:36px;
  background:linear-gradient(140deg,rgba(0,229,184,0.07) 0%,rgba(9,16,32,0.88) 40%,rgba(59,130,246,0.07) 100%);
  border:1px solid var(--bd-default);
  backdrop-filter:blur(36px);
  box-shadow:var(--sh-card),var(--sh-inset);
  animation:fadeUp 0.7s var(--ease) both;
}
.wb::after {
  content:''; position:absolute; top:0; left:0; right:0; height:1px;
  background:linear-gradient(90deg,transparent 5%,rgba(0,229,184,0.5) 35%,rgba(59,130,246,0.45) 65%,transparent 95%);
}
.wb-shimmer {
  position:absolute; top:0; left:-60%; width:40%; height:100%;
  background:linear-gradient(105deg,transparent,rgba(255,255,255,0.025),transparent);
  animation:shimmer 5s 1.5s ease-in-out infinite;
  pointer-events:none;
}
.wb-body { display:flex; align-items:center; justify-content:space-between; gap:36px; flex-wrap:wrap; position:relative; z-index:1; }
.wb-eyebrow {
  font-family:var(--font-mono); font-size:11px; font-weight:500;
  letter-spacing:2.5px; text-transform:uppercase; color:var(--teal);
  margin-bottom:10px; display:flex; align-items:center; gap:10px;
}
.wb-eyebrow::before { content:''; width:22px; height:1px; background:var(--teal); opacity:0.5; }
.wb-name { font-size:40px; font-weight:800; line-height:1.12; letter-spacing:-1px; margin-bottom:8px; }
.wb-name em {
  font-style:normal;
  background:linear-gradient(120deg,var(--teal),var(--cyan),var(--blue-soft));
  -webkit-background-clip:text; -webkit-text-fill-color:transparent;
}
.wb-date { font-size:15px; font-weight:400; color:var(--tx-secondary); line-height:1.5; }
.wb-right { display:flex; align-items:center; gap:32px; flex-shrink:0; }
.wb-vitals { display:flex; flex-direction:column; gap:12px; }
.wb-vital { display:flex; align-items:center; gap:12px; font-size:14px; color:var(--tx-secondary); }
.wb-vital-dot { width:7px; height:7px; border-radius:50%; flex-shrink:0; }
.wb-vital-val { font-family:var(--font-mono); font-size:13px; font-weight:500; color:var(--tx-primary); margin-left:auto; padding-left:20px; }

/* Health Score ring */
.score-ring { position:relative; width:96px; height:96px; flex-shrink:0; animation:floatY 5s ease-in-out infinite; }
.score-ring svg { transform:rotate(-90deg); display:block; }
.sr-track { fill:none; stroke:rgba(255,255,255,0.06); stroke-width:6; }
.sr-fill {
  fill:none; stroke-width:6; stroke-linecap:round;
  stroke:url(#srGrad);
  stroke-dasharray:238;
  stroke-dashoffset:47;
  filter:drop-shadow(0 0 8px rgba(0,229,184,0.6));
  transition:stroke-dashoffset 1.8s cubic-bezier(.23,1,.32,1);
}
.score-center { position:absolute; inset:0; display:flex; flex-direction:column; align-items:center; justify-content:center; }
.score-num { font-size:26px; font-weight:800; letter-spacing:-0.5px; line-height:1; }
.score-lbl { font-family:var(--font-mono); font-size:9px; font-weight:500; letter-spacing:2px; text-transform:uppercase; color:var(--teal); margin-top:3px; }

/* Live pill */
.live-pill {
  display:inline-flex; align-items:center; gap:8px;
  background:rgba(0,229,184,0.06); border:1px solid rgba(0,229,184,0.22);
  color:var(--teal); font-family:var(--font-mono); font-size:10px; font-weight:500;
  letter-spacing:1.8px; text-transform:uppercase; padding:8px 16px; border-radius:100px;
  animation:borderGlow 3s ease-in-out infinite;
}
.live-dot { width:6px; height:6px; border-radius:50%; background:var(--teal); box-shadow:0 0 8px var(--teal); animation:pulseGlow 2.2s ease-in-out infinite; }
@keyframes liveBlink { 0%,100%{opacity:1}50%{opacity:0.4} }

/* ── Section heading ── */
.sec-head { display:flex; align-items:center; gap:14px; margin-bottom:18px; }
.sec-title { font-size:12px; font-weight:600; text-transform:uppercase; letter-spacing:1.6px; color:var(--tx-muted); font-family:var(--font-mono); white-space:nowrap; }
.sec-line  { flex:1; height:1px; background:linear-gradient(90deg,var(--bd-default),transparent); }

/* ── Stat Cards ── */
.stats-row {
  display:grid; grid-template-columns:repeat(4,1fr); gap:18px; margin-bottom:32px;
}
@media(max-width:1100px) { .stats-row { grid-template-columns:repeat(2,1fr); } }
@media(max-width:580px)  { .stats-row { grid-template-columns:1fr; } }

.sc {
  background:var(--bg-card);
  border:1px solid var(--bd-default);
  border-radius:var(--r-xl);
  padding:26px;
  position:relative; overflow:hidden;
  backdrop-filter:blur(32px);
  box-shadow:var(--sh-card),var(--sh-inset);
  transition:transform 0.32s var(--ease-spring), box-shadow 0.32s var(--ease), border-color 0.28s var(--ease);
  cursor:default;
  opacity:0;
  animation:fadeUp 0.6s var(--ease) forwards;
}
.stats-row .sc:nth-child(1) { animation-delay:0.15s; }
.stats-row .sc:nth-child(2) { animation-delay:0.22s; }
.stats-row .sc:nth-child(3) { animation-delay:0.29s; }
.stats-row .sc:nth-child(4) { animation-delay:0.36s; }
.sc:hover {
  transform:translateY(-6px);
  box-shadow:var(--sh-hover),var(--sh-inset);
  border-color:var(--bd-strong);
}
.sc::before {
  content:''; position:absolute; top:0; left:0; right:0; height:2px;
  border-radius:var(--r-xl) var(--r-xl) 0 0;
  opacity:0.75; transition:opacity 0.3s var(--ease);
}
.sc:hover::before { opacity:1; }
.sc-bp::before  { background:linear-gradient(90deg,transparent 5%,#ef4444 50%,transparent 95%); }
.sc-hr::before  { background:linear-gradient(90deg,transparent 5%,#ec4899 50%,transparent 95%); }
.sc-wt::before  { background:linear-gradient(90deg,transparent 5%,#f59e0b 50%,transparent 95%); }
.sc-bs::before  { background:linear-gradient(90deg,transparent 5%,#00e5b8 50%,transparent 95%); }
.sc::after {
  content:''; position:absolute; bottom:0; left:0; right:0; height:1px;
  opacity:0; transition:opacity 0.3s;
}
.sc:hover::after { opacity:1; }
.sc-bp:hover::after  { background:linear-gradient(90deg,transparent,rgba(239,68,68,0.2),transparent); }
.sc-hr:hover::after  { background:linear-gradient(90deg,transparent,rgba(236,72,153,0.2),transparent); }
.sc-wt:hover::after  { background:linear-gradient(90deg,transparent,rgba(245,158,11,0.2),transparent); }
.sc-bs:hover::after  { background:linear-gradient(90deg,transparent,rgba(0,229,184,0.2),transparent); }

.sc-glow {
  position:absolute; width:160px; height:160px;
  top:-55px; right:-55px; border-radius:50%;
  filter:blur(60px); pointer-events:none;
  opacity:0.16; transition:opacity 0.4s var(--ease);
}
.sc:hover .sc-glow { opacity:0.38; }
.sc-bp .sc-glow { background:#ef4444; }
.sc-hr .sc-glow { background:#ec4899; }
.sc-wt .sc-glow { background:#f59e0b; }
.sc-bs .sc-glow { background:#00e5b8; }

.sc-shimmer {
  position:absolute; top:0; left:-80%; width:45%; height:100%;
  background:linear-gradient(105deg,transparent,rgba(255,255,255,0.028),transparent);
  pointer-events:none; opacity:0;
  transition:opacity 0.2s;
}
.sc:hover .sc-shimmer { opacity:1; animation:shimmer 0.8s ease-in-out; }

.sc-top { display:flex; align-items:center; justify-content:space-between; margin-bottom:22px; }
.sc-lbl { font-family:var(--font-mono); font-size:11px; font-weight:500; letter-spacing:1.2px; text-transform:uppercase; color:var(--tx-muted); }
.sc-icon {
  width:42px; height:42px; border-radius:12px;
  display:flex; align-items:center; justify-content:center;
  font-size:19px; flex-shrink:0;
  border:1px solid var(--bd-default);
  transition:transform 0.3s var(--ease-spring);
}
.sc:hover .sc-icon { transform:scale(1.12) rotate(-3deg); }
.sc-bp .sc-icon { background:var(--red-dim);    border-color:rgba(239,68,68,0.2); }
.sc-hr .sc-icon { background:var(--pink-dim);   border-color:rgba(236,72,153,0.2); }
.sc-wt .sc-icon { background:var(--amber-dim);  border-color:rgba(245,158,11,0.2); }
.sc-bs .sc-icon { background:var(--teal-dim);   border-color:rgba(0,229,184,0.2); }
.sc-val {
  font-size:28px; font-weight:800; line-height:1; letter-spacing:-0.7px; margin-bottom:12px;
  font-family:var(--font-sans);
  transition:filter 0.3s;
}
.sc:hover .sc-val { filter:brightness(1.1); }
.sc-trend {
  display:flex; align-items:center; gap:6px;
  font-family:var(--font-mono); font-size:12px; font-weight:400;
  margin-bottom:14px; color:var(--tx-muted);
}
.t-up   { color:var(--green-soft); }
.t-down { color:var(--red-soft); }

.badge {
  display:inline-flex; align-items:center; gap:6px;
  font-size:12px; font-weight:500;
  padding:5px 12px; border-radius:100px;
  font-family:var(--font-sans); letter-spacing:0.1px;
}
.bdot { width:6px; height:6px; border-radius:50%; flex-shrink:0; }
.badge-ok     { background:var(--green-dim); color:var(--green-soft); border:1px solid rgba(16,185,129,0.24); }
.badge-ok .bdot { background:var(--green-soft); box-shadow:0 0 6px rgba(110,231,183,0.7); }
.badge-warn   { background:var(--amber-dim); color:var(--amber-soft); border:1px solid rgba(245,158,11,0.24); }
.badge-warn .bdot { background:var(--amber-soft); box-shadow:0 0 6px rgba(252,211,77,0.7); }
.badge-bad    { background:var(--red-dim);   color:var(--red-soft);   border:1px solid rgba(239,68,68,0.24); }
.badge-bad .bdot  { background:var(--red-soft);   box-shadow:0 0 6px rgba(252,165,165,0.7); }
.badge-stable { background:var(--amber-dim); color:var(--amber-soft); border:1px solid rgba(245,158,11,0.24); }
.badge-stable .bdot { background:var(--amber-soft); box-shadow:0 0 6px rgba(252,211,77,0.7); }

/* ── Mid grid ── */
.mid-grid { display:grid; grid-template-columns:1fr 1fr; gap:20px; margin-bottom:22px; }
@media(max-width:900px) { .mid-grid { grid-template-columns:1fr; } }

/* ── Base card ── */
.card {
  background:var(--bg-card);
  border:1px solid var(--bd-default);
  border-radius:var(--r-xl);
  padding:32px;
  backdrop-filter:blur(32px);
  box-shadow:var(--sh-card),var(--sh-inset);
  transition:border-color 0.28s var(--ease), box-shadow 0.28s var(--ease);
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
  display:flex; align-items:center; justify-content:center;
  font-size:17px; flex-shrink:0;
  transition:transform 0.3s var(--ease-spring);
}
.card:hover .card-ico { transform:scale(1.1) rotate(-4deg); }
.ico-teal   { background:var(--teal-dim);   border:1px solid rgba(0,229,184,0.18); }
.ico-red    { background:var(--red-dim);    border:1px solid rgba(239,68,68,0.18); }
.ico-blue   { background:var(--blue-dim);   border:1px solid rgba(59,130,246,0.18); }
.ico-violet { background:var(--violet-dim); border:1px solid rgba(139,92,246,0.18); }

/* Buttons */
.btn-ghost {
  background:var(--bg-pill); border:1px solid var(--bd-default);
  color:var(--tx-secondary); font-size:13px; font-weight:500;
  padding:8px 16px; border-radius:var(--r-sm); cursor:pointer;
  text-decoration:none; transition:all 0.22s var(--ease); font-family:var(--font-sans);
}
.btn-ghost:hover { border-color:var(--teal); color:var(--teal); background:var(--teal-dim); text-decoration:none; }
.btn-primary {
  background:linear-gradient(135deg,var(--teal),var(--cyan));
  color:#021a13; font-weight:700; font-size:14px;
  padding:11px 22px; border-radius:var(--r-sm);
  border:none; cursor:pointer; text-decoration:none;
  transition:all 0.25s var(--ease);
  box-shadow:0 4px 20px rgba(0,229,184,0.28);
  display:inline-block; font-family:var(--font-sans); letter-spacing:-0.15px;
  position:relative; overflow:hidden;
}
.btn-primary:hover { transform:translateY(-2px); box-shadow:0 8px 30px rgba(0,229,184,0.42); text-decoration:none; color:#021a13; }
.btn-primary:active { transform:translateY(0); }

/* ── Health Insights ── */
.insights-body { display:flex; flex-direction:column; gap:12px; }
.insight-item {
  display:flex; align-items:flex-start; gap:16px;
  padding:16px 20px;
  background:var(--bg-raised); border:1px solid var(--bd-subtle);
  border-radius:var(--r-md);
  transition:all 0.25s var(--ease);
  position:relative; overflow:hidden;
}
.insight-item::before {
  content:''; position:absolute; left:0; top:0; bottom:0; width:2px;
  opacity:0; transition:opacity 0.25s;
}
.insight-item:hover { border-color:var(--bd-default); transform:translateX(4px); }
.insight-item:hover::before { opacity:1; }
.insight-item.ii-green::before { background:var(--green-soft); }
.insight-item.ii-blue::before  { background:var(--blue-soft); }
.insight-item.ii-amber::before { background:var(--amber-soft); }
.insight-item.ii-violet::before{ background:var(--violet-soft); }
.insight-dot { width:32px; height:32px; border-radius:9px; display:flex; align-items:center; justify-content:center; font-size:14px; flex-shrink:0; }
.id-green  { background:var(--green-dim); border:1px solid rgba(16,185,129,0.2); }
.id-blue   { background:var(--blue-dim);  border:1px solid rgba(59,130,246,0.2); }
.id-amber  { background:var(--amber-dim); border:1px solid rgba(245,158,11,0.2); }
.id-violet { background:var(--violet-dim);border:1px solid rgba(139,92,246,0.2); }
.insight-heading { font-size:14px; font-weight:600; color:var(--tx-primary); margin-bottom:4px; letter-spacing:-0.1px; }
.insight-desc    { font-size:13px; font-weight:400; color:var(--tx-secondary); line-height:1.6; }

/* Weekly pills */
.week-pills { display:flex; gap:10px; margin-bottom:22px; flex-wrap:wrap; }
.week-pill {
  padding:9px 18px; border-radius:100px;
  font-size:13px; font-weight:500;
  border:1px solid var(--bd-default); background:var(--bg-pill);
  display:flex; align-items:center; gap:8px; color:var(--tx-secondary); white-space:nowrap;
  transition:all 0.22s var(--ease);
}
.week-pill:hover { border-color:var(--bd-strong); transform:translateY(-1px); }
.week-pill .wp-val { font-family:var(--font-mono); font-weight:500; font-size:12px; color:var(--tx-primary); }
.wp-teal   { border-color:rgba(0,229,184,0.24); background:var(--teal-dim); color:var(--teal); }
.wp-teal .wp-val { color:var(--teal); }
.wp-blue   { border-color:rgba(59,130,246,0.24); background:var(--blue-dim); color:var(--blue-soft); }
.wp-blue .wp-val { color:var(--blue-soft); }
.wp-pink   { border-color:rgba(236,72,153,0.24); background:var(--pink-dim); color:var(--pink-soft); }
.wp-pink .wp-val { color:var(--pink-soft); }

/* Score bars */
.score-bar-wrap { margin-bottom:6px; }
.score-bar-meta { display:flex; justify-content:space-between; align-items:center; margin-bottom:9px; }
.score-bar-label { font-size:13px; font-weight:500; color:var(--tx-secondary); }
.score-bar-val   { font-family:var(--font-mono); font-size:13px; font-weight:500; color:var(--tx-primary); }
.score-track { height:6px; background:rgba(255,255,255,0.05); border-radius:100px; overflow:hidden; }
.score-fill  { height:100%; border-radius:100px; width:0; transition:width 1.4s cubic-bezier(.23,1,.32,1); }

/* ── Appointments ── */
.appt-stack { display:flex; flex-direction:column; gap:12px; }
.appt-row {
  display:flex; align-items:center; gap:16px;
  padding:18px 20px;
  background:var(--bg-raised); border:1px solid var(--bd-subtle);
  border-radius:var(--r-md);
  transition:all 0.25s var(--ease); position:relative; overflow:hidden;
}
.appt-row::before {
  content:''; position:absolute; top:0; left:0; width:2px; height:100%;
  background:linear-gradient(180deg,var(--blue),var(--violet-mid));
  opacity:0; transition:opacity 0.25s;
}
.appt-row:hover { border-color:var(--bd-default); transform:translateX(5px); }
.appt-row:hover::before { opacity:1; }
.appt-avatar {
  width:48px; height:48px; border-radius:13px;
  background:linear-gradient(140deg,rgba(59,130,246,0.22),rgba(139,92,246,0.17));
  border:1px solid rgba(59,130,246,0.22);
  display:flex; align-items:center; justify-content:center;
  font-size:17px; font-weight:700; color:var(--blue-soft);
  flex-shrink:0; box-shadow:0 0 20px rgba(59,130,246,0.14);
}
.appt-datebox {
  text-align:center; flex-shrink:0; min-width:52px;
  padding:9px 11px;
  background:var(--blue-dim); border:1px solid rgba(59,130,246,0.2);
  border-radius:var(--r-sm);
}
.appt-mon { font-family:var(--font-mono); font-size:9px; font-weight:500; text-transform:uppercase; color:var(--blue-soft); letter-spacing:1.8px; }
.appt-day { font-size:22px; font-weight:800; color:var(--tx-primary); line-height:1.1; letter-spacing:-0.5px; }
.appt-info { flex:1; min-width:0; }
.appt-doc  { font-size:15px; font-weight:600; color:var(--tx-primary); letter-spacing:-0.2px; }
.appt-spec {
  display:inline-flex; align-items:center;
  font-size:12px; font-weight:500; margin-top:5px;
  padding:3px 10px; border-radius:100px;
  background:var(--violet-dim); color:var(--violet-soft);
  border:1px solid rgba(139,92,246,0.22);
}
.appt-time { font-family:var(--font-mono); font-size:12px; color:var(--tx-muted); margin-top:5px; }
.appt-end  { display:flex; flex-direction:column; align-items:flex-end; gap:7px; flex-shrink:0; }
.chip {
  font-family:var(--font-mono); font-size:9px; font-weight:500;
  padding:4px 10px; border-radius:100px; text-transform:uppercase; letter-spacing:1px;
}
.chip-sched { background:var(--blue-dim);  color:var(--blue-soft);  border:1px solid rgba(59,130,246,0.24); }
.chip-soon  { background:var(--teal-dim);  color:var(--teal);       border:1px solid rgba(0,229,184,0.24); }
.chip-later { background:var(--bg-pill);   color:var(--tx-muted);   border:1px solid var(--bd-subtle); }

/* ── Chart ── */
.chart-legend { display:flex; gap:22px; margin-bottom:20px; flex-wrap:wrap; }
.legend-item  { display:flex; align-items:center; gap:9px; font-size:13px; color:var(--tx-secondary); }
.legend-dot   { width:8px; height:8px; border-radius:50%; flex-shrink:0; }
.chart-box    { position:relative; height:260px; }

/* ── Medications ── */
.meds-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(210px,1fr)); gap:14px; }
.med-item {
  background:var(--bg-raised); border:1px solid var(--bd-subtle);
  border-radius:var(--r-md); padding:18px 20px;
  display:flex; align-items:center; gap:16px;
  transition:all 0.25s var(--ease); position:relative; overflow:hidden;
}
.med-item::after {
  content:''; position:absolute; top:0; left:0; right:0; height:1px;
  background:linear-gradient(90deg,transparent,rgba(0,229,184,0.45),transparent);
  opacity:0; transition:opacity 0.25s;
}
.med-item:hover { border-color:rgba(0,229,184,0.2); transform:translateY(-3px); box-shadow:0 10px 32px rgba(0,0,0,0.45); }
.med-item:hover::after { opacity:1; }
.med-em   { font-size:28px; flex-shrink:0; animation:floatY 4s ease-in-out infinite; }
.med-name { font-size:14px; font-weight:600; color:var(--tx-primary); letter-spacing:-0.15px; }
.med-sub  { font-family:var(--font-mono); font-size:12px; color:var(--tx-muted); margin-top:4px; }

/* Empty states */
.empty { display:flex; flex-direction:column; align-items:center; justify-content:center; padding:50px 20px; gap:12px; text-align:center; }
.empty-ico { font-size:40px; opacity:0.16; animation:floatY 5s ease-in-out infinite; }
.empty-txt { font-size:14px; color:var(--tx-muted); font-weight:400; }

.divider { height:1px; background:var(--bd-subtle); margin:22px 0; }
</style>

<!-- Background -->
<div class="bg-mesh"></div>
<div class="bg-accent"></div>
<div class="bg-grid"></div>

<div class="dash">

<!-- ─── WELCOME BANNER ─── -->
<div class="wb" style="animation-delay:0.05s;">
  <div class="wb-shimmer"></div>
  <div class="wb-body">
    <div class="wb-text">
      <div class="wb-eyebrow">Good day</div>
      <div class="wb-name">Welcome back, <em><?= htmlspecialchars($user['name'] ?? 'there') ?></em></div>
      <div class="wb-date"><?= date('l, F j, Y') ?> &middot; Your health metrics look great today.</div>
    </div>
    <div class="wb-right">
      <div class="wb-vitals">
        <div class="wb-vital">
          <span class="wb-vital-dot" style="background:var(--teal);box-shadow:0 0 7px var(--teal);"></span>
          Blood Pressure
          <span class="wb-vital-val"><?= $bp ?></span>
        </div>
        <div class="wb-vital">
          <span class="wb-vital-dot" style="background:var(--pink);box-shadow:0 0 7px var(--pink);"></span>
          Heart Rate
          <span class="wb-vital-val"><?= $hr ?></span>
        </div>
        <div class="wb-vital">
          <span class="wb-vital-dot" style="background:var(--amber);box-shadow:0 0 7px var(--amber);"></span>
          Weight
          <span class="wb-vital-val"><?= $wt ?></span>
        </div>
      </div>
      <div class="score-ring" title="Health Score">
        <svg width="96" height="96" viewBox="0 0 96 96">
          <defs>
            <linearGradient id="srGrad" x1="0%" y1="0%" x2="100%" y2="0%">
              <stop offset="0%"   stop-color="#00e5b8"/>
              <stop offset="55%"  stop-color="#18d4f0"/>
              <stop offset="100%" stop-color="#60a5fa"/>
            </linearGradient>
          </defs>
          <circle class="sr-track" cx="48" cy="48" r="38"/>
          <circle class="sr-fill"  cx="48" cy="48" r="38" id="hs-arc"/>
        </svg>
        <div class="score-center">
          <span class="score-num" id="hs-num" style="background:linear-gradient(135deg,var(--teal),var(--blue-soft));-webkit-background-clip:text;-webkit-text-fill-color:transparent;">0</span>
          <span class="score-lbl">Score</span>
        </div>
      </div>
      <div class="live-pill"><span class="live-dot"></span> Live</div>
    </div>
  </div>
</div>

<!-- ─── STAT CARDS ─── -->
<div class="sec-head" style="opacity:0;animation:fadeIn 0.5s 0.3s var(--ease) forwards;">
  <span class="sec-title">Vitals</span>
  <span class="sec-line"></span>
</div>

<div class="stats-row">
  <div class="sc sc-bp">
    <div class="sc-glow"></div><div class="sc-shimmer"></div>
    <div class="sc-top">
      <span class="sc-lbl">Blood Pressure</span>
      <div class="sc-icon">💓</div>
    </div>
    <div class="sc-val" data-countup="0"><?= $bp ?></div>
    <div class="sc-trend">→ <span style="color:var(--tx-muted);">No change</span></div>
    <?php if ($bpStatus === 'danger'): ?>
      <span class="badge badge-bad"><span class="bdot"></span> High</span>
    <?php elseif ($bpStatus === 'warning'): ?>
      <span class="badge badge-warn"><span class="bdot"></span> Elevated</span>
    <?php else: ?>
      <span class="badge badge-ok"><span class="bdot"></span> Normal</span>
    <?php endif; ?>
  </div>
  <div class="sc sc-hr">
    <div class="sc-glow"></div><div class="sc-shimmer"></div>
    <div class="sc-top"><span class="sc-lbl">Heart Rate</span><div class="sc-icon">❤️</div></div>
    <div class="sc-val"><?= $hr ?></div>
    <div class="sc-trend"><span class="t-up">↑</span> <span style="color:var(--tx-muted);">+2 bpm</span></div>
    <span class="badge badge-ok"><span class="bdot"></span> Normal</span>
  </div>
  <div class="sc sc-wt">
    <div class="sc-glow"></div><div class="sc-shimmer"></div>
    <div class="sc-top"><span class="sc-lbl">Weight</span><div class="sc-icon">⚖️</div></div>
    <div class="sc-val"><?= $wt ?></div>
    <div class="sc-trend">→ <span style="color:var(--tx-muted);">Steady</span></div>
    <span class="badge badge-stable"><span class="bdot"></span> Stable</span>
  </div>
  <div class="sc sc-bs">
    <div class="sc-glow"></div><div class="sc-shimmer"></div>
    <div class="sc-top"><span class="sc-lbl">Blood Sugar</span><div class="sc-icon">💧</div></div>
    <div class="sc-val"><?= $bs ?></div>
    <div class="sc-trend"><span class="t-down">↓</span> <span style="color:var(--tx-muted);">-3 mg/dL</span></div>
    <span class="badge badge-ok"><span class="bdot"></span> Normal</span>
  </div>
</div>

<!-- ─── MID GRID ─── -->
<div class="mid-grid">

  <!-- Health Insights -->
  <div class="card" style="animation-delay:0.42s;">
    <div class="card-head">
      <div class="card-title">
        <div class="card-ico ico-teal">🩺</div>
        Health Insights
      </div>
      <span class="live-pill" style="font-size:9px;padding:6px 12px;">
        <span class="live-dot"></span> This week
      </span>
    </div>
    <div class="week-pills">
      <div class="week-pill wp-teal">BP avg <span class="wp-val"><?= $latest ? $latest['systolic_bp'].'/'. $latest['diastolic_bp'] : 'N/A' ?></span></div>
      <div class="week-pill wp-pink">HR avg <span class="wp-val"><?= $latest ? $latest['heart_rate'].' bpm' : 'N/A' ?></span></div>
      <div class="week-pill wp-blue">Sugar <span class="wp-val"><?= $latest ? $latest['blood_sugar'].' mg/dL' : 'N/A' ?></span></div>
    </div>
    <div class="score-bar-wrap">
      <div class="score-bar-meta">
        <span class="score-bar-label">Cardiovascular Health</span>
        <span class="score-bar-val">82%</span>
      </div>
      <div class="score-track">
        <div class="score-fill" data-width="82" style="background:linear-gradient(90deg,#00e5b8,#18d4f0);box-shadow:0 0 8px rgba(0,229,184,0.45);"></div>
      </div>
    </div>
    <div class="score-bar-wrap" style="margin-top:14px;">
      <div class="score-bar-meta">
        <span class="score-bar-label">Metabolic Score</span>
        <span class="score-bar-val">78%</span>
      </div>
      <div class="score-track">
        <div class="score-fill" data-width="78" style="background:linear-gradient(90deg,#3b82f6,#8b5cf6);box-shadow:0 0 8px rgba(59,130,246,0.4);"></div>
      </div>
    </div>
    <div class="score-bar-wrap" style="margin-top:14px;">
      <div class="score-bar-meta">
        <span class="score-bar-label">Activity Level</span>
        <span class="score-bar-val">65%</span>
      </div>
      <div class="score-track">
        <div class="score-fill" data-width="65" style="background:linear-gradient(90deg,#f59e0b,#fcd34d);box-shadow:0 0 8px rgba(245,158,11,0.4);"></div>
      </div>
    </div>
    <div class="divider"></div>
    <div class="insights-body">
      <div class="insight-item ii-green">
        <div class="insight-dot id-green">✅</div>
        <div>
          <div class="insight-heading">Blood pressure within target range</div>
          <div class="insight-desc">Your readings have been consistently normal this week. Keep up your current routine.</div>
        </div>
      </div>
      <div class="insight-item ii-blue">
        <div class="insight-dot id-blue">💧</div>
        <div>
          <div class="insight-heading">Increase daily water intake</div>
          <div class="insight-desc">Staying hydrated supports stable blood sugar and helps maintain a healthy heart rate.</div>
        </div>
      </div>
      <div class="insight-item ii-amber">
        <div class="insight-dot id-amber">⚡</div>
        <div>
          <div class="insight-heading">30-min walk recommended today</div>
          <div class="insight-desc">Light aerobic activity can improve your activity score and support metabolic health.</div>
        </div>
      </div>
      <div class="insight-item ii-violet">
        <div class="insight-dot id-violet">📅</div>
        <div>
          <div class="insight-heading">Upcoming check-up reminder</div>
          <div class="insight-desc">You have an endocrinology appointment scheduled. Prepare any symptom notes in advance.</div>
        </div>
      </div>
    </div>
  </div>

  <!-- Appointments -->
  <div class="card" style="animation-delay:0.50s;">
    <div class="card-head">
      <div class="card-title">
        <div class="card-ico ico-blue">🗓️</div>
        Upcoming Appointments
      </div>
      <a href="index.php?page=appointments" class="btn-ghost">View All</a>
    </div>
    <?php if (empty($appointments)): ?>
      <div class="empty">
        <div class="empty-ico">🗓️</div>
        <div class="empty-txt">No upcoming appointments</div>
        <a href="index.php?page=appointments-create" class="btn-primary" style="margin-top:12px;">Schedule Now</a>
      </div>
    <?php else: ?>
      <div class="appt-stack">
        <?php foreach ($appointments as $i => $appt):
          $d = new DateTime($appt['date']);
          $now = new DateTime();
          $diff = $now->diff($d);
          $daysUntil = (int)$diff->days;
          $initials = strtoupper(substr($appt['doctor'] ?? 'D', 0, 1));
          if ($daysUntil === 0)      { $cdText = 'Today';          $cdClass = 'chip-soon'; }
          elseif ($daysUntil === 1)  { $cdText = 'Tomorrow';       $cdClass = 'chip-soon'; }
          elseif ($daysUntil <= 7)   { $cdText = "In {$daysUntil}d"; $cdClass = 'chip-soon'; }
          else                       { $cdText = "In {$daysUntil}d"; $cdClass = 'chip-later'; }
        ?>
          <div class="appt-row">
            <div class="appt-avatar"><?= $initials ?></div>
            <div class="appt-datebox">
              <div class="appt-mon"><?= $d->format('M') ?></div>
              <div class="appt-day"><?= $d->format('d') ?></div>
            </div>
            <div class="appt-info">
              <div class="appt-doc"><?= htmlspecialchars($appt['doctor']) ?></div>
              <div class="appt-spec"><?= htmlspecialchars($appt['specialty']) ?></div>
              <div class="appt-time">🕐 <?= date('g:i A', strtotime($appt['time'])) ?></div>
            </div>
            <div class="appt-end">
              <span class="chip chip-sched">Scheduled</span>
              <span class="chip <?= $cdClass ?>"><?= $cdText ?></span>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>

</div>

<!-- ─── BP CHART ─── -->
<div class="card" style="animation-delay:0.56s;">
  <div class="card-head">
    <div class="card-title">
      <div class="card-ico ico-teal">📈</div>
      Blood Pressure Trend
      <span style="font-size:13px;font-weight:400;color:var(--tx-muted);margin-left:4px;">— Last 5 records</span>
    </div>
    <a href="index.php?page=health-records" class="btn-ghost">All Records</a>
  </div>
  <div class="chart-legend">
    <div class="legend-item"><div class="legend-dot" style="background:#ef4444;box-shadow:0 0 6px rgba(239,68,68,0.75);"></div>Systolic (mmHg)</div>
    <div class="legend-item"><div class="legend-dot" style="background:#00e5b8;box-shadow:0 0 6px rgba(0,229,184,0.75);"></div>Diastolic (mmHg)</div>
  </div>
  <div class="chart-box"><canvas id="bpChart"></canvas></div>
</div>

<!-- ─── MEDICATIONS ─── -->
<div class="card" style="animation-delay:0.63s;">
  <div class="card-head">
    <div class="card-title">
      <div class="card-ico ico-violet">💊</div>
      Today's Medications
    </div>
    <a href="index.php?page=medication" class="btn-ghost">Manage</a>
  </div>
  <?php if (empty($meds)): ?>
    <div class="empty">
      <div class="empty-ico">💊</div>
      <div class="empty-txt">No medications logged today</div>
      <a href="index.php?page=medication" class="btn-primary" style="margin-top:12px;">Add Medication</a>
    </div>
  <?php else: ?>
    <div class="meds-grid">
      <?php foreach ($meds as $med): ?>
        <div class="med-item">
          <span class="med-em"><?= $med['icon'] ?></span>
          <div>
            <div class="med-name"><?= htmlspecialchars($med['name']) ?></div>
            <div class="med-sub"><?= htmlspecialchars($med['dosage']) ?> · <?= htmlspecialchars($med['schedule']) ?></div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</div>

</div><!-- /.dash -->

<script>
/* ── Health score ring ── */
(function() {
  const score  = 80;
  const circ   = 2 * Math.PI * 38;  /* r=38 */
  const target = circ - (circ * score / 100);
  const arc    = document.getElementById('hs-arc');
  const num    = document.getElementById('hs-num');
  if (!arc) return;
  arc.style.strokeDasharray  = circ;
  arc.style.strokeDashoffset = circ;
  let start = null;
  function animate(ts) {
    if (!start) start = ts;
    const p    = Math.min((ts - start) / 1600, 1);
    const ease = 1 - Math.pow(1 - p, 3);
    arc.style.strokeDashoffset = circ - (circ - target) * ease;
    num.textContent = Math.round(score * ease);
    if (p < 1) requestAnimationFrame(animate); else num.textContent = score;
  }
  setTimeout(() => requestAnimationFrame(animate), 400);
})();

/* ── Animated score bars ── */
(function() {
  const bars = document.querySelectorAll('.score-fill[data-width]');
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        const bar = entry.target;
        setTimeout(() => { bar.style.width = bar.dataset.width + '%'; }, 200);
        observer.unobserve(bar);
      }
    });
  }, { threshold: 0.3 });
  bars.forEach(b => observer.observe(b));
})();

/* ── BP Chart ── */
<?php
$slice  = array_reverse(array_slice($records, 0, 5));
$labels = array_map(fn($r) => date('M d', strtotime($r['date'])), $slice);
$sys    = array_column($slice, 'systolic_bp');
$dia    = array_column($slice, 'diastolic_bp');
?>
const bpCtx = document.getElementById('bpChart').getContext('2d');
new Chart(bpCtx, {
  type: 'line',
  data: {
    labels: <?= json_encode($labels) ?>,
    datasets: [
      {
        label: 'Systolic',
        data: <?= json_encode($sys) ?>,
        borderColor: '#ef4444',
        backgroundColor: (ctx) => {
          const g = ctx.chart.ctx.createLinearGradient(0,0,0,260);
          g.addColorStop(0,'rgba(239,68,68,0.18)');g.addColorStop(1,'rgba(239,68,68,0)');return g;
        },
        fill:true, pointBackgroundColor:'#ef4444',
        pointBorderColor:'#04080f', pointBorderWidth:2,
        borderWidth:2.5, tension:0.44, pointRadius:5, pointHoverRadius:8,
      },
      {
        label: 'Diastolic',
        data: <?= json_encode($dia) ?>,
        borderColor: '#00e5b8',
        backgroundColor: (ctx) => {
          const g = ctx.chart.ctx.createLinearGradient(0,0,0,260);
          g.addColorStop(0,'rgba(0,229,184,0.14)');g.addColorStop(1,'rgba(0,229,184,0)');return g;
        },
        fill:true, pointBackgroundColor:'#00e5b8',
        pointBorderColor:'#04080f', pointBorderWidth:2,
        borderWidth:2.5, tension:0.44, pointRadius:5, pointHoverRadius:8,
      }
    ]
  },
  options: {
    responsive:true, maintainAspectRatio:false,
    interaction:{ mode:'index', intersect:false },
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
  }
});
</script>

<?php require_once APP_PATH . '/views/shared/footer.php'; ?>