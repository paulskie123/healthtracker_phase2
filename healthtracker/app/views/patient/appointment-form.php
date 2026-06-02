<?php
$isEdit    = $appointment !== null;
$pageTitle = $isEdit ? 'Edit Appointment' : 'Schedule Appointment';
$activePage = 'appointments';
require_once APP_PATH . '/views/shared/header.php';
$o = $old ?: $appointment ?: [];

// Compute display values for the live preview
$previewDoctor    = htmlspecialchars($o['doctor']    ?? '');
$previewSpecialty = htmlspecialchars($o['specialty'] ?? '');
$previewDate      = !empty($o['date'])   ? date('F j, Y', strtotime($o['date']))     : '';
$previewTime      = !empty($o['time'])   ? date('g:i A',  strtotime($o['time']))      : '';
$previewType      = htmlspecialchars($o['type']      ?? 'Check-up');
$previewStatus    = htmlspecialchars($o['status']    ?? 'Scheduled');
$previewLocation  = htmlspecialchars($o['location']  ?? '');
?>

<style>
/* ─── Reset & tokens ─────────────────────────────────────────── */
:root{
  --af-bg:         #0d1117;
  --af-surface:    #161b22;
  --af-surface2:   #1c2230;
  --af-border:     rgba(255,255,255,.07);
  --af-border-h:   rgba(99,179,237,.35);
  --af-blue:       #3b9eff;
  --af-blue-glow:  rgba(59,158,255,.18);
  --af-teal:       #4ecdc4;
  --af-teal-glow:  rgba(78,205,196,.15);
  --af-purple:     #a78bfa;
  --af-green:      #34d399;
  --af-amber:      #fbbf24;
  --af-red:        #f87171;
  --af-text:       #e6edf3;
  --af-muted:      #8b949e;
  --af-faint:      rgba(230,237,243,.04);
  --af-radius:     16px;
  --af-radius-sm:  10px;
  --af-shadow:     0 4px 32px rgba(0,0,0,.45);
  --af-shadow-lg:  0 8px 52px rgba(0,0,0,.6);
  --font-head:     'Syne', sans-serif;
  --font-body:     'DM Sans', sans-serif;
  --font-mono:     'JetBrains Mono', monospace;
}

@import url('https://fonts.googleapis.com/css2?family=Syne:wght@600;700;800&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;1,9..40,400&family=JetBrains+Mono:wght@400;500;600&display=swap');

/* ─── Page wrapper ───────────────────────────────────────────── */
.af-page{
  max-width:1380px;
  margin:0 auto;
  padding:0 28px 100px;
  font-family:var(--font-body);
  color:var(--af-text);
  animation:afFadeUp .55s ease both;
}
@keyframes afFadeUp{from{opacity:0;transform:translateY(20px)}to{opacity:1;transform:none}}

/* ─── Back link ──────────────────────────────────────────────── */
.af-back{
  display:inline-flex;align-items:center;gap:8px;
  font-size:14px;font-weight:500;color:var(--af-muted);
  text-decoration:none;margin-bottom:32px;
  transition:color .2s,gap .2s;
}
.af-back:hover{color:var(--af-blue);gap:12px;}

/* ─── Command-center header ──────────────────────────────────── */
.af-header{
  display:grid;grid-template-columns:1fr auto;gap:32px;align-items:start;
  margin-bottom:36px; padding-top:8px;
}
@media(max-width:700px){.af-header{grid-template-columns:1fr;}}

.af-title-row{display:flex;align-items:center;gap:18px;margin-bottom:12px;}
.af-title-icon{
  width:56px;height:56px;border-radius:15px;
  background:linear-gradient(135deg,var(--af-blue) 0%,var(--af-teal) 100%);
  display:flex;align-items:center;justify-content:center;font-size:26px;
  box-shadow:0 0 24px var(--af-blue-glow);flex-shrink:0;
}
.af-title{font-family:var(--font-head);font-size:40px;font-weight:800;
  background:linear-gradient(135deg,#e6edf3 0%,var(--af-blue) 100%);
  -webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;
  line-height:1.05;
}
.af-subtitle{font-size:16px;color:var(--af-muted);max-width:540px;line-height:1.65;margin-top:6px;}
.af-ref-badge{
  display:inline-flex;align-items:center;gap:7px;margin-top:14px;
  background:var(--af-faint);border:1px solid var(--af-border);
  padding:6px 14px;border-radius:22px;font-family:var(--font-mono);font-size:12px;color:var(--af-muted);
}
.af-ref-badge span{color:var(--af-blue);}

.af-header-badges{display:flex;flex-wrap:wrap;gap:12px;padding-top:6px;}
.af-hbadge{
  background:rgba(22,27,34,.8);border:1px solid var(--af-border);
  border-radius:14px;padding:16px 20px;min-width:140px;
  backdrop-filter:blur(12px);transition:border-color .2s,transform .2s;
}
.af-hbadge:hover{border-color:var(--af-border-h);transform:translateY(-2px);}
.af-hbadge-label{font-size:11px;font-weight:700;color:var(--af-muted);text-transform:uppercase;letter-spacing:.8px;margin-bottom:6px;}
.af-hbadge-value{font-family:var(--font-head);font-size:28px;font-weight:800;color:var(--af-text);}
.af-hbadge-sub{font-size:12px;color:var(--af-muted);margin-top:3px;}

/* ─── Analytics row ──────────────────────────────────────────── */
.af-analytics{
  display:grid;grid-template-columns:repeat(4,1fr);gap:16px;
  margin-bottom:36px;
}
@media(max-width:900px){.af-analytics{grid-template-columns:repeat(2,1fr);}}
@media(max-width:500px){.af-analytics{grid-template-columns:1fr;}}

.af-acard{
  background:var(--af-surface);border:1px solid var(--af-border);
  border-radius:var(--af-radius);padding:24px 22px;
  position:relative;overflow:hidden;
  transition:border-color .25s,transform .25s;
  animation:afFadeUp .5s ease both;
}
.af-acard:nth-child(1){animation-delay:.05s}
.af-acard:nth-child(2){animation-delay:.10s}
.af-acard:nth-child(3){animation-delay:.15s}
.af-acard:nth-child(4){animation-delay:.20s}
.af-acard:hover{border-color:var(--af-border-h);transform:translateY(-3px);}
.af-acard::before{
  content:'';position:absolute;inset:0;
  background:radial-gradient(ellipse at top right,var(--ac-glow,rgba(59,158,255,.08)) 0%,transparent 65%);
  pointer-events:none;
}
.af-acard-top{display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:14px;}
.af-acard-label{font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.8px;color:var(--af-muted);}
.af-acard-icon{font-size:22px;opacity:.85;}
.af-acard-value{font-family:var(--font-head);font-size:38px;font-weight:800;color:var(--af-text);line-height:1;}
.af-acard-trend{font-size:13px;color:var(--af-muted);margin-top:8px;}
.af-acard-bar{height:4px;border-radius:4px;background:var(--af-border);margin-top:14px;overflow:hidden;}
.af-acard-bar-fill{height:100%;border-radius:4px;background:linear-gradient(90deg,var(--af-blue),var(--af-teal));width:0;
  transition:width 1.2s cubic-bezier(.16,1,.3,1);}

/* ─── Two-column layout ──────────────────────────────────────── */
.af-layout{
  display:grid;grid-template-columns:1fr 380px;gap:24px;align-items:start;
}
@media(max-width:1100px){.af-layout{grid-template-columns:1fr;}}

/* ─── Section cards ──────────────────────────────────────────── */
.af-form-col{display:flex;flex-direction:column;gap:20px;}

.af-card{
  background:var(--af-surface);border:1px solid var(--af-border);
  border-radius:var(--af-radius);overflow:hidden;
  box-shadow:var(--af-shadow);
  transition:border-color .25s;
  animation:afFadeUp .55s ease both;
}
.af-card:hover{border-color:rgba(255,255,255,.11);}

.af-card-head{
  display:flex;align-items:center;gap:14px;
  padding:22px 28px;border-bottom:1px solid var(--af-border);
  background:rgba(255,255,255,.02);
}
.af-card-head-icon{
  width:40px;height:40px;border-radius:11px;
  display:flex;align-items:center;justify-content:center;font-size:18px;
  background:var(--cci-bg, rgba(59,158,255,.15));
  box-shadow:0 0 14px var(--cci-glow, var(--af-blue-glow));
  flex-shrink:0;
}
.af-card-head-text{}
.af-card-head-title{font-family:var(--font-head);font-size:18px;font-weight:700;color:var(--af-text);}
.af-card-head-sub{font-size:13px;color:var(--af-muted);margin-top:3px;}

.af-card-body{padding:28px;}

/* ─── Form grid ──────────────────────────────────────────────── */
.af-grid{display:grid;grid-template-columns:1fr 1fr;gap:22px;}
.af-grid.af-grid-1{grid-template-columns:1fr;}
@media(max-width:600px){.af-grid{grid-template-columns:1fr;}}
.af-full{grid-column:1/-1;}

/* ─── Form group ─────────────────────────────────────────────── */
.af-group{display:flex;flex-direction:column;gap:10px;}
.af-label{
  font-size:13px;font-weight:700;text-transform:uppercase;letter-spacing:.7px;
  color:var(--af-muted);
}
.af-req{color:var(--af-blue);margin-left:3px;}

.af-input,.af-select,.af-textarea{
  width:100%;box-sizing:border-box;
  background:rgba(255,255,255,.04);
  border:1px solid var(--af-border);
  border-radius:var(--af-radius-sm);
  color:var(--af-text);
  font-family:var(--font-body);font-size:16px;
  padding:15px 18px;
  outline:none;
  transition:border-color .2s,box-shadow .2s,background .2s;
  -webkit-appearance:none;
}
.af-input::placeholder,.af-textarea::placeholder{color:rgba(139,148,158,.45);}
.af-input:focus,.af-select:focus,.af-textarea:focus{
  border-color:var(--af-blue);
  background:rgba(59,158,255,.06);
  box-shadow:0 0 0 3px rgba(59,158,255,.12),0 0 22px rgba(59,158,255,.08);
}
.af-select{
  background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath d='M1 1l5 5 5-5' stroke='%238b949e' stroke-width='1.5' fill='none' stroke-linecap='round'/%3E%3C/svg%3E");
  background-repeat:no-repeat;background-position:right 16px center;
  padding-right:44px;cursor:pointer;
}
.af-select option{background:#1c2230;color:var(--af-text);}
.af-textarea{min-height:130px;resize:vertical;line-height:1.65;}

/* ─── Input with icon ────────────────────────────────────────── */
.af-input-wrap{position:relative;}
.af-input-wrap .af-input{padding-left:48px;}
.af-input-wrap .af-input-icon{
  position:absolute;left:16px;top:50%;transform:translateY(-50%);
  font-size:17px;pointer-events:none;opacity:.55;
}

/* ─── Char counter ───────────────────────────────────────────── */
.af-char-counter{
  text-align:right;font-size:12px;color:var(--af-muted);
  font-family:var(--font-mono);
  transition:color .2s;
}

/* ─── Status pills inside select area ───────────────────────── */
.af-status-row{display:flex;gap:10px;flex-wrap:wrap;margin-top:2px;}
.af-status-pill{
  display:flex;align-items:center;gap:8px;
  padding:11px 18px;border-radius:10px;
  border:1.5px solid transparent;cursor:pointer;
  font-size:14px;font-weight:500;
  transition:all .2s;
  background:rgba(255,255,255,.04);
  color:var(--af-muted);user-select:none;
}
.af-status-pill input[type=radio]{display:none;}
.af-status-pill .sp-dot{width:7px;height:7px;border-radius:50%;background:currentColor;}
.af-status-pill.sp-scheduled{--spc:#3b9eff;}
.af-status-pill.sp-completed{--spc:#34d399;}
.af-status-pill.sp-cancelled{--spc:#f87171;}
.af-status-pill.sp-active{
  background:rgba(var(--spc-rgb,59,158,255),.12);
  border-color:var(--spc, var(--af-blue));
  color:var(--spc, var(--af-blue));
}
.af-status-pill.sp-scheduled.sp-active{background:rgba(59,158,255,.12);border-color:#3b9eff;color:#3b9eff;}
.af-status-pill.sp-completed.sp-active{background:rgba(52,211,153,.12);border-color:#34d399;color:#34d399;}
.af-status-pill.sp-cancelled.sp-active{background:rgba(248,113,113,.12);border-color:#f87171;color:#f87171;}

/* ─── Actions ────────────────────────────────────────────────── */
.af-actions{
  display:flex;align-items:center;gap:14px;padding-top:10px;flex-wrap:wrap;
}
.af-btn-primary{
  display:inline-flex;align-items:center;gap:9px;
  padding:15px 30px;border-radius:11px;border:none;cursor:pointer;
  background:linear-gradient(135deg,var(--af-blue) 0%,#2980ef 100%);
  color:#fff;font-family:var(--font-body);font-size:16px;font-weight:600;
  box-shadow:0 4px 20px rgba(59,158,255,.32);
  transition:transform .18s,box-shadow .18s,filter .18s;
  text-decoration:none;
}
.af-btn-primary:hover{transform:translateY(-2px);box-shadow:0 8px 32px rgba(59,158,255,.44);filter:brightness(1.08);}
.af-btn-primary:active{transform:translateY(0);}

.af-btn-ghost{
  display:inline-flex;align-items:center;gap:9px;
  padding:15px 24px;border-radius:11px;cursor:pointer;
  background:transparent;border:1px solid var(--af-border);
  color:var(--af-muted);font-family:var(--font-body);font-size:16px;font-weight:500;
  transition:border-color .18s,color .18s,background .18s;
  text-decoration:none;
}
.af-btn-ghost:hover{border-color:var(--af-border-h);color:var(--af-text);background:rgba(255,255,255,.04);}

/* ─── Sidebar ────────────────────────────────────────────────── */
.af-sidebar{display:flex;flex-direction:column;gap:20px;position:sticky;top:24px;}

/* ─── Live Preview card ──────────────────────────────────────── */
.af-preview{
  background:var(--af-surface);border:1px solid var(--af-border);
  border-radius:var(--af-radius);overflow:hidden;
  box-shadow:var(--af-shadow);
}
.af-preview-head{
  padding:22px 26px 18px;border-bottom:1px solid var(--af-border);
  background:linear-gradient(135deg,rgba(59,158,255,.08) 0%,rgba(78,205,196,.06) 100%);
}
.af-preview-head-title{font-family:var(--font-head);font-size:14px;font-weight:700;
  text-transform:uppercase;letter-spacing:.8px;color:var(--af-blue);margin-bottom:3px;}
.af-preview-head-sub{font-size:13px;color:var(--af-muted);}

.af-preview-body{padding:24px 26px;}
.af-preview-doctor{font-family:var(--font-head);font-size:22px;font-weight:700;color:var(--af-text);
  min-height:30px;transition:all .3s;}
.af-preview-specialty{font-size:15px;color:var(--af-teal);font-weight:500;margin-top:4px;margin-bottom:22px;min-height:22px;}
.af-preview-rows{display:flex;flex-direction:column;gap:14px;}
.af-preview-row{display:flex;align-items:center;gap:12px;}
.af-preview-row-icon{font-size:16px;width:22px;text-align:center;opacity:.7;}
.af-preview-row-label{font-size:12px;color:var(--af-muted);width:65px;flex-shrink:0;text-transform:uppercase;letter-spacing:.5px;font-weight:600;}
.af-preview-row-val{font-size:14px;color:var(--af-text);font-weight:500;min-height:20px;}

.af-prev-status{
  display:inline-flex;align-items:center;gap:7px;
  padding:5px 13px;border-radius:22px;font-size:13px;font-weight:600;
  background:rgba(59,158,255,.12);color:var(--af-blue);border:1px solid rgba(59,158,255,.25);
}
.af-prev-status-dot{width:6px;height:6px;border-radius:50%;background:currentColor;}

/* ─── Sidebar widget ─────────────────────────────────────────── */
.af-widget{
  background:var(--af-surface);border:1px solid var(--af-border);
  border-radius:var(--af-radius);overflow:hidden;
  box-shadow:var(--af-shadow);
}
.af-widget-head{
  padding:20px 24px;border-bottom:1px solid var(--af-border);
  font-family:var(--font-head);font-size:15px;font-weight:700;
  text-transform:uppercase;letter-spacing:.7px;
  display:flex;align-items:center;gap:9px;color:var(--af-muted);
}
.af-widget-body{padding:20px 24px;}

.af-tip{
  display:flex;gap:14px;padding:14px 0;
  border-bottom:1px solid var(--af-border);
}
.af-tip:last-child{border-bottom:none;padding-bottom:0;}
.af-tip-icon{font-size:17px;margin-top:1px;flex-shrink:0;}
.af-tip-text{font-size:14px;color:var(--af-muted);line-height:1.55;}

.af-stat-row{
  display:flex;justify-content:space-between;align-items:center;
  padding:13px 0;border-bottom:1px solid var(--af-border);
}
.af-stat-row:last-child{border-bottom:none;}
.af-stat-row-label{font-size:14px;color:var(--af-muted);}
.af-stat-row-val{font-family:var(--font-mono);font-size:16px;font-weight:600;color:var(--af-text);}

/* ─── Edit mode overview ─────────────────────────────────────── */
.af-edit-overview{
  background:linear-gradient(135deg,rgba(59,158,255,.07) 0%,rgba(78,205,196,.05) 100%);
  border:1px solid rgba(59,158,255,.2);border-radius:var(--af-radius);
  padding:24px 28px;margin-bottom:8px;
}
.af-edit-overview-title{
  font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.8px;
  color:var(--af-blue);margin-bottom:18px;
  display:flex;align-items:center;gap:9px;
}
.af-edit-ov-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:14px;}
@media(max-width:500px){.af-edit-ov-grid{grid-template-columns:1fr;}}
.af-edit-ov-item{background:rgba(255,255,255,.04);border-radius:10px;padding:14px 16px;}
.af-edit-ov-label{font-size:11px;color:var(--af-muted);text-transform:uppercase;letter-spacing:.5px;font-weight:700;margin-bottom:6px;}
.af-edit-ov-value{font-size:15px;font-weight:600;color:var(--af-text);}

/* ─── Errors ─────────────────────────────────────────────────── */
.af-errors{
  background:rgba(248,113,113,.08);border:1px solid rgba(248,113,113,.25);
  border-radius:var(--af-radius-sm);padding:18px 24px;margin-bottom:6px;
}
.af-errors ul{margin:0;padding-left:20px;}
.af-errors li{font-size:15px;color:#f87171;line-height:1.75;}

/* ─── Flash ──────────────────────────────────────────────────── */
.af-flash{
  display:flex;align-items:center;gap:12px;
  background:rgba(52,211,153,.08);border:1px solid rgba(52,211,153,.25);
  border-radius:var(--af-radius-sm);padding:16px 24px;margin-bottom:22px;
  font-size:15px;color:var(--af-green);
}

/* ─── Divider ────────────────────────────────────────────────── */
.af-divider{border:none;border-top:1px solid var(--af-border);margin:6px 0;}
</style>

<div class="af-page">

  <!-- Back -->
  <a href="index.php?page=appointments" class="af-back">← Back to Appointments</a>

  <?php if (!empty($flash)): ?>
    <div class="af-flash">✅ <?= htmlspecialchars($flash) ?></div>
  <?php endif; ?>

  <!-- ── Header ─────────────────────────────────────────────── -->
  <div class="af-header">
    <div class="af-header-left">
      <div class="af-title-row">
        <div class="af-title-icon"><?= $isEdit ? '✏️' : '🗓️' ?></div>
        <h1 class="af-title"><?= $isEdit ? 'Edit Appointment' : 'Schedule Appointment' ?></h1>
      </div>
      <p class="af-subtitle">
        <?= $isEdit
          ? 'Update appointment details, reschedule times, or change the status of this visit.'
          : 'Create and manage patient appointments, consultations, and follow-up visits.' ?>
      </p>
      <div class="af-ref-badge">
        <span>APT</span> — <?= $isEdit ? 'Editing Record #' . ($id ?? '—') : 'New Appointment' ?>
      </div>
    </div>

    <div class="af-header-badges">
      <div class="af-hbadge">
        <div class="af-hbadge-label">Upcoming</div>
        <div class="af-hbadge-value" style="color:var(--af-blue);"><?= count(array_filter($appointments ?? [], fn($a) => $a['status']==='Scheduled')) ?></div>
        <div class="af-hbadge-sub">Scheduled</div>
      </div>
      <div class="af-hbadge">
        <div class="af-hbadge-label">Total</div>
        <div class="af-hbadge-value"><?= count($appointments ?? []) ?></div>
        <div class="af-hbadge-sub">All time</div>
      </div>
      <div class="af-hbadge">
        <div class="af-hbadge-label">Completed</div>
        <div class="af-hbadge-value" style="color:var(--af-green);"><?= count(array_filter($appointments ?? [], fn($a) => $a['status']==='Completed')) ?></div>
        <div class="af-hbadge-sub">Done</div>
      </div>
    </div>
  </div>

  <!-- ── Analytics row ──────────────────────────────────────── -->
  <?php
    $totalAppts     = count($appointments ?? []);
    $scheduledCount = count(array_filter($appointments ?? [], fn($a) => $a['status']==='Scheduled'));
    $completedCount = count(array_filter($appointments ?? [], fn($a) => $a['status']==='Completed'));
    $completionRate = $totalAppts > 0 ? round($completedCount / $totalAppts * 100) : 0;
    $todayStr       = date('Y-m-d');
    $todayCount     = count(array_filter($appointments ?? [], fn($a) => $a['date']==$todayStr));
  ?>
  <div class="af-analytics">
    <div class="af-acard" style="--ac-glow:rgba(59,158,255,.1);">
      <div class="af-acard-top">
        <div class="af-acard-label">Scheduled Today</div>
        <div class="af-acard-icon">📅</div>
      </div>
      <div class="af-acard-value" style="color:var(--af-blue);"><?= $todayCount ?></div>
      <div class="af-acard-trend">Today · <?= date('M j') ?></div>
    </div>
    <div class="af-acard" style="--ac-glow:rgba(167,139,250,.1);">
      <div class="af-acard-top">
        <div class="af-acard-label">Upcoming</div>
        <div class="af-acard-icon">🗓️</div>
      </div>
      <div class="af-acard-value" style="color:var(--af-purple);"><?= $scheduledCount ?></div>
      <div class="af-acard-trend">Scheduled visits</div>
    </div>
    <div class="af-acard" style="--ac-glow:rgba(52,211,153,.1);">
      <div class="af-acard-top">
        <div class="af-acard-label">Completion Rate</div>
        <div class="af-acard-icon">✅</div>
      </div>
      <div class="af-acard-value" style="color:var(--af-green);"><?= $completionRate ?>%</div>
      <div class="af-acard-bar"><div class="af-acard-bar-fill" style="width:<?= $completionRate ?>%;"></div></div>
    </div>
    <div class="af-acard" style="--ac-glow:rgba(251,191,36,.1);">
      <div class="af-acard-top">
        <div class="af-acard-label">Status</div>
        <div class="af-acard-icon">🔔</div>
      </div>
      <div class="af-acard-value" style="color:var(--af-amber);font-size:18px;margin-top:6px;">
        <?= $isEdit ? htmlspecialchars($o['status'] ?? 'Scheduled') : 'New' ?>
      </div>
      <div class="af-acard-trend"><?= $isEdit ? 'Current state' : 'Ready to schedule' ?></div>
    </div>
  </div>

  <!-- ── Edit overview (only in edit mode) ─────────────────── -->
  <?php if ($isEdit): ?>
  <div class="af-edit-overview" style="margin-bottom:24px;">
    <div class="af-edit-overview-title">✏️ Current Appointment Details</div>
    <div class="af-edit-ov-grid">
      <div class="af-edit-ov-item">
        <div class="af-edit-ov-label">Doctor</div>
        <div class="af-edit-ov-value"><?= htmlspecialchars($appointment['doctor'] ?? '—') ?></div>
      </div>
      <div class="af-edit-ov-item">
        <div class="af-edit-ov-label">Specialty</div>
        <div class="af-edit-ov-value"><?= htmlspecialchars($appointment['specialty'] ?? '—') ?></div>
      </div>
      <div class="af-edit-ov-item">
        <div class="af-edit-ov-label">Date</div>
        <div class="af-edit-ov-value"><?= !empty($appointment['date']) ? date('M j, Y', strtotime($appointment['date'])) : '—' ?></div>
      </div>
      <div class="af-edit-ov-item">
        <div class="af-edit-ov-label">Time</div>
        <div class="af-edit-ov-value"><?= !empty($appointment['time']) ? date('g:i A', strtotime($appointment['time'])) : '—' ?></div>
      </div>
    </div>
  </div>
  <?php endif; ?>

  <!-- ── Two-column layout ──────────────────────────────────── -->
  <div class="af-layout">

    <!-- Form column -->
    <div class="af-form-col">

      <?php if (!empty($errors)): ?>
        <div class="af-errors"><ul><?php foreach ($errors as $e): ?><li><?= htmlspecialchars($e) ?></li><?php endforeach; ?></ul></div>
      <?php endif; ?>

      <form method="POST" action="index.php?page=<?= $isEdit ? 'appointments-update' : 'appointments-store' ?>" id="af-form">
        <?php if ($isEdit): ?>
          <input type="hidden" name="id" value="<?= $id ?>">
        <?php endif; ?>

        <!-- Section 1: Doctor Information -->
        <div class="af-card" style="animation-delay:.1s">
          <div class="af-card-head" style="--cci-bg:rgba(59,158,255,.12);--cci-glow:rgba(59,158,255,.2);">
            <div class="af-card-head-icon">👨‍⚕️</div>
            <div class="af-card-head-text">
              <div class="af-card-head-title">Doctor Information</div>
              <div class="af-card-head-sub">Attending physician and specialty details</div>
            </div>
          </div>
          <div class="af-card-body">
            <div class="af-grid">
              <div class="af-group">
                <label class="af-label">Doctor's Name <span class="af-req">*</span></label>
                <div class="af-input-wrap">
                  <span class="af-input-icon">🩺</span>
                  <input type="text" name="doctor" class="af-input" id="inp-doctor"
                         placeholder="e.g. Dr. Sarah Chen"
                         value="<?= htmlspecialchars($o['doctor'] ?? '') ?>" required
                         oninput="updatePreview()">
                </div>
              </div>
              <div class="af-group">
                <label class="af-label">Specialty <span class="af-req">*</span></label>
                <select name="specialty" class="af-select" id="inp-specialty" required onchange="updatePreview()">
                  <option value="">— Select specialty —</option>
                  <?php foreach (['Internal Medicine','Cardiology','Endocrinology','Ophthalmology','Dermatology','Neurology','Orthopedics','Pulmonology','Nephrology','Gastroenterology','General Practice','Other'] as $s): ?>
                    <option value="<?= $s ?>" <?= ($o['specialty'] ?? '') === $s ? 'selected' : '' ?>><?= $s ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
          </div>
        </div>

        <!-- Section 2: Schedule Details -->
        <div class="af-card" style="animation-delay:.15s">
          <div class="af-card-head" style="--cci-bg:rgba(167,139,250,.12);--cci-glow:rgba(167,139,250,.2);">
            <div class="af-card-head-icon">📅</div>
            <div class="af-card-head-text">
              <div class="af-card-head-title">Schedule Details</div>
              <div class="af-card-head-sub">Date, time, type, and appointment status</div>
            </div>
          </div>
          <div class="af-card-body">
            <div class="af-grid">
              <div class="af-group">
                <label class="af-label">Appointment Date <span class="af-req">*</span></label>
                <div class="af-input-wrap">
                  <span class="af-input-icon">📆</span>
                  <input type="date" name="date" class="af-input" id="inp-date"
                         value="<?= htmlspecialchars($o['date'] ?? date('Y-m-d', strtotime('+1 day'))) ?>"
                         required oninput="updatePreview()">
                </div>
              </div>
              <div class="af-group">
                <label class="af-label">Appointment Time <span class="af-req">*</span></label>
                <div class="af-input-wrap">
                  <span class="af-input-icon">🕐</span>
                  <input type="time" name="time" class="af-input" id="inp-time"
                         value="<?= htmlspecialchars($o['time'] ?? '09:00') ?>"
                         required oninput="updatePreview()">
                </div>
              </div>
              <div class="af-group">
                <label class="af-label">Appointment Type</label>
                <select name="type" class="af-select" id="inp-type" onchange="updatePreview()">
                  <?php foreach (['Check-up','Follow-up','Consultation','Annual','Emergency','Lab Test','Procedure','Other'] as $t): ?>
                    <option value="<?= $t ?>" <?= ($o['type'] ?? 'Check-up') === $t ? 'selected' : '' ?>><?= $t ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="af-group">
                <label class="af-label">Status</label>
                <!-- Hidden actual select for form submission -->
                <select name="status" id="inp-status" style="display:none;">
                  <option value="Scheduled" <?= ($o['status'] ?? 'Scheduled')==='Scheduled'?'selected':'' ?>>Scheduled</option>
                  <option value="Completed" <?= ($o['status'] ?? '')==='Completed'?'selected':'' ?>>Completed</option>
                  <option value="Cancelled" <?= ($o['status'] ?? '')==='Cancelled'?'selected':'' ?>>Cancelled</option>
                </select>
                <!-- Visual pills -->
                <div class="af-status-row" id="status-pills">
                  <?php
                    $currentStatus = $o['status'] ?? 'Scheduled';
                    $statusDefs = [
                      'Scheduled' => ['class'=>'sp-scheduled','icon'=>'🗓️'],
                      'Completed' => ['class'=>'sp-completed','icon'=>'✅'],
                      'Cancelled' => ['class'=>'sp-cancelled','icon'=>'🚫'],
                    ];
                    foreach($statusDefs as $sv => $sd):
                  ?>
                    <label class="af-status-pill <?= $sd['class'] ?> <?= $currentStatus===$sv ? 'sp-active' : '' ?>" data-val="<?= $sv ?>">
                      <input type="radio" name="_status_ui" value="<?= $sv ?>" <?= $currentStatus===$sv ? 'checked' : '' ?>>
                      <span class="sp-dot"></span> <?= $sv ?>
                    </label>
                  <?php endforeach; ?>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Section 3: Location -->
        <div class="af-card" style="animation-delay:.2s">
          <div class="af-card-head" style="--cci-bg:rgba(78,205,196,.12);--cci-glow:rgba(78,205,196,.2);">
            <div class="af-card-head-icon">📍</div>
            <div class="af-card-head-text">
              <div class="af-card-head-title">Location Information</div>
              <div class="af-card-head-sub">Clinic or hospital address details</div>
            </div>
          </div>
          <div class="af-card-body">
            <div class="af-grid af-grid-1">
              <div class="af-group">
                <label class="af-label">Clinic / Hospital Location</label>
                <div class="af-input-wrap">
                  <span class="af-input-icon">🏥</span>
                  <input type="text" name="location" class="af-input" id="inp-location"
                         placeholder="e.g. SF Medical Center, Room 301"
                         value="<?= htmlspecialchars($o['location'] ?? '') ?>"
                         oninput="updatePreview()">
                </div>
                <div style="font-size:13px;color:var(--af-muted);margin-top:2px;">Include building name, floor, or room number if applicable.</div>
              </div>
            </div>
          </div>
        </div>

        <!-- Section 4: Notes -->
        <div class="af-card" style="animation-delay:.25s">
          <div class="af-card-head" style="--cci-bg:rgba(251,191,36,.1);--cci-glow:rgba(251,191,36,.15);">
            <div class="af-card-head-icon">📝</div>
            <div class="af-card-head-text">
              <div class="af-card-head-title">Notes & Preparation</div>
              <div class="af-card-head-sub">Instructions, reminders, and preparation notes</div>
            </div>
          </div>
          <div class="af-card-body">
            <div class="af-group">
              <label class="af-label">Notes / Preparation Instructions</label>
              <textarea name="notes" class="af-textarea" id="inp-notes"
                        placeholder="e.g. Bring latest BP records, fasting required for 8 hours before visit, wear comfortable clothing..."
                        maxlength="600" oninput="updateCharCount(this)"><?= htmlspecialchars($o['notes'] ?? '') ?></textarea>
              <div class="af-char-counter" id="char-counter"><?= strlen($o['notes'] ?? '') ?> / 600</div>
            </div>
          </div>
        </div>

        <!-- Actions -->
        <div class="af-actions">
          <button type="submit" class="af-btn-primary">
            <?= $isEdit ? '💾 Update Appointment' : '✅ Schedule Appointment' ?>
          </button>
          <a href="index.php?page=appointments" class="af-btn-ghost">Cancel</a>
        </div>

      </form>
    </div><!-- /form col -->

    <!-- Sidebar -->
    <div class="af-sidebar">

      <!-- Live Preview -->
      <div class="af-preview">
        <div class="af-preview-head">
          <div class="af-preview-head-title">Live Preview</div>
          <div class="af-preview-head-sub">Updates as you fill the form</div>
        </div>
        <div class="af-preview-body">
          <div class="af-preview-doctor" id="prev-doctor"><?= $previewDoctor ?: '<span style="color:var(--af-muted);font-weight:400;font-size:15px;">Doctor name</span>' ?></div>
          <div class="af-preview-specialty" id="prev-specialty"><?= $previewSpecialty ?: '—' ?></div>
          <div class="af-preview-rows">
            <div class="af-preview-row">
              <span class="af-preview-row-icon">📅</span>
              <span class="af-preview-row-label">Date</span>
              <span class="af-preview-row-val" id="prev-date"><?= $previewDate ?: '—' ?></span>
            </div>
            <div class="af-preview-row">
              <span class="af-preview-row-icon">🕐</span>
              <span class="af-preview-row-label">Time</span>
              <span class="af-preview-row-val" id="prev-time"><?= $previewTime ?: '—' ?></span>
            </div>
            <div class="af-preview-row">
              <span class="af-preview-row-icon">🏷️</span>
              <span class="af-preview-row-label">Type</span>
              <span class="af-preview-row-val" id="prev-type"><?= $previewType ?></span>
            </div>
            <div class="af-preview-row">
              <span class="af-preview-row-icon">📍</span>
              <span class="af-preview-row-label">Location</span>
              <span class="af-preview-row-val" id="prev-location"><?= $previewLocation ?: 'TBD' ?></span>
            </div>
            <div class="af-preview-row">
              <span class="af-preview-row-icon">🔖</span>
              <span class="af-preview-row-label">Status</span>
              <span class="af-prev-status" id="prev-status-badge">
                <span class="af-prev-status-dot"></span>
                <span id="prev-status-text"><?= $previewStatus ?></span>
              </span>
            </div>
          </div>
        </div>
      </div>

      <!-- Tips widget -->
      <div class="af-widget">
        <div class="af-widget-head">💡 Scheduling Tips</div>
        <div class="af-widget-body">
          <div class="af-tip">
            <span class="af-tip-icon">📋</span>
            <div class="af-tip-text">Bring any recent lab results or health records to your appointment.</div>
          </div>
          <div class="af-tip">
            <span class="af-tip-icon">⏰</span>
            <div class="af-tip-text">Arrive 10–15 minutes early for new consultations to complete paperwork.</div>
          </div>
          <div class="af-tip">
            <span class="af-tip-icon">💊</span>
            <div class="af-tip-text">List all current medications and supplements before a check-up.</div>
          </div>
          <div class="af-tip">
            <span class="af-tip-icon">📞</span>
            <div class="af-tip-text">Confirm 24 hours in advance if you need to reschedule.</div>
          </div>
        </div>
      </div>

      <!-- Statistics widget -->
      <div class="af-widget">
        <div class="af-widget-head">📊 Your Appointments</div>
        <div class="af-widget-body">
          <div class="af-stat-row">
            <span class="af-stat-row-label">Total appointments</span>
            <span class="af-stat-row-val" style="color:var(--af-text);"><?= $totalAppts ?></span>
          </div>
          <div class="af-stat-row">
            <span class="af-stat-row-label">Upcoming</span>
            <span class="af-stat-row-val" style="color:var(--af-blue);"><?= $scheduledCount ?></span>
          </div>
          <div class="af-stat-row">
            <span class="af-stat-row-label">Completed</span>
            <span class="af-stat-row-val" style="color:var(--af-green);"><?= $completedCount ?></span>
          </div>
          <div class="af-stat-row">
            <span class="af-stat-row-label">Completion rate</span>
            <span class="af-stat-row-val" style="color:var(--af-teal);"><?= $completionRate ?>%</span>
          </div>
        </div>
      </div>

    </div><!-- /sidebar -->
  </div><!-- /layout -->
</div><!-- /af-page -->

<script>
/* ── Live preview updater ───────────────────────────────── */
function updatePreview(){
  var doctor   = document.getElementById('inp-doctor')?.value   || '';
  var specialty= document.getElementById('inp-specialty')?.value|| '';
  var dateVal  = document.getElementById('inp-date')?.value     || '';
  var timeVal  = document.getElementById('inp-time')?.value     || '';
  var type     = document.getElementById('inp-type')?.value     || '';
  var location = document.getElementById('inp-location')?.value || '';
  var status   = document.getElementById('inp-status')?.value   || 'Scheduled';

  var dEl = document.getElementById('prev-doctor');
  if(dEl) dEl.innerHTML = doctor
    ? '<span style="font-family:var(--font-head);font-size:22px;font-weight:700;color:var(--af-text)">'+escHtml(doctor)+'</span>'
    : '<span style="color:var(--af-muted);font-weight:400;font-size:15px;">Doctor name</span>';

  var spEl = document.getElementById('prev-specialty');
  if(spEl) spEl.textContent = specialty || '—';

  var dtEl = document.getElementById('prev-date');
  if(dtEl && dateVal){
    var d = new Date(dateVal + 'T00:00:00');
    dtEl.textContent = d.toLocaleDateString('en-US',{month:'short',day:'numeric',year:'numeric'});
  } else if(dtEl){ dtEl.textContent='—'; }

  var tmEl = document.getElementById('prev-time');
  if(tmEl && timeVal){
    var parts = timeVal.split(':');
    var h = parseInt(parts[0]); var m = parts[1];
    var ampm = h>=12?'PM':'AM'; h = h%12||12;
    tmEl.textContent = h+':'+m+' '+ampm;
  } else if(tmEl){ tmEl.textContent='—'; }

  var tpEl = document.getElementById('prev-type');
  if(tpEl) tpEl.textContent = type || '—';

  var lcEl = document.getElementById('prev-location');
  if(lcEl) lcEl.textContent = location || 'TBD';

  // Status badge
  var sbEl = document.getElementById('prev-status-badge');
  var stTx = document.getElementById('prev-status-text');
  if(sbEl && stTx){
    stTx.textContent = status;
    sbEl.style.background = status==='Completed'?'rgba(52,211,153,.12)'
      : status==='Cancelled'?'rgba(248,113,113,.12)'
      : 'rgba(59,158,255,.12)';
    sbEl.style.color = status==='Completed'?'var(--af-green)'
      : status==='Cancelled'?'var(--af-red)'
      : 'var(--af-blue)';
    sbEl.style.borderColor = status==='Completed'?'rgba(52,211,153,.3)'
      : status==='Cancelled'?'rgba(248,113,113,.3)'
      : 'rgba(59,158,255,.25)';
  }
}

function escHtml(s){ var d=document.createElement('div');d.textContent=s;return d.innerHTML; }

/* ── Status pills sync ─────────────────────────────────── */
document.querySelectorAll('#status-pills .af-status-pill').forEach(function(pill){
  pill.addEventListener('click', function(){
    var val = this.dataset.val;
    document.getElementById('inp-status').value = val;
    document.querySelectorAll('#status-pills .af-status-pill').forEach(function(p){ p.classList.remove('sp-active'); });
    this.classList.add('sp-active');
    updatePreview();
  });
});

/* ── Char counter ──────────────────────────────────────── */
function updateCharCount(el){
  var c = document.getElementById('char-counter');
  if(c){
    var len = el.value.length;
    c.textContent = len + ' / 600';
    c.style.color = len > 550 ? 'var(--af-amber)' : 'var(--af-muted)';
  }
}

/* ── Animate bar fills on load ─────────────────────────── */
window.addEventListener('load', function(){
  document.querySelectorAll('.af-acard-bar-fill').forEach(function(el){
    var target = el.style.width;
    el.style.width = '0';
    setTimeout(function(){ el.style.width = target; }, 200);
  });
  updatePreview();
});
</script>

<?php require_once APP_PATH . '/views/shared/footer.php'; ?>