<?php
$pageTitle  = 'Record Detail';
$activePage = 'health-records';
require_once APP_PATH . '/views/shared/header.php';

/* ---- Existing BP logic (unchanged) ---- */
$sys = $record['systolic_bp'];
$dia = $record['diastolic_bp'];
if ($sys >= 140 || $dia >= 90)     { $bpLabel = 'High Blood Pressure'; $bpCls = 'hv-badge-high'; }
elseif ($sys >= 130 || $dia >= 80) { $bpLabel = 'Elevated';            $bpCls = 'hv-badge-elevated'; }
else                               { $bpLabel = 'Normal';              $bpCls = 'hv-badge-normal'; }

/* ---- Health Score (visual only — based on existing data) ---- */
$score = 100;
if ($sys >= 140 || $dia >= 90)     $score -= 25;
elseif ($sys >= 130 || $dia >= 80) $score -= 12;
if ($record['heart_rate'] > 100 || $record['heart_rate'] < 50) $score -= 10;
if ($record['blood_sugar'] >= 100 && $record['blood_sugar'] < 126) $score -= 8;
elseif ($record['blood_sugar'] >= 126) $score -= 18;
$score = max(0, min(100, $score));

/* SVG ring: circumference of r=40 circle = 251.3; offset for score */
$ringOffset = round(251.3 * (1 - $score / 100));
$scoreColor = $score >= 80 ? '#00d4aa' : ($score >= 60 ? '#f59e0b' : '#ef4444');

/* Progress bar widths (clamped to 0–100) */
$sysPct  = min(100, round(($sys / 180) * 100));
$diaPct  = min(100, round(($dia / 120) * 100));
$hrPct   = min(100, round(($record['heart_rate']   / 180) * 100));
$bsPct   = min(100, round(($record['blood_sugar']  / 250) * 100));
$wtPct   = min(100, round(($record['weight']       / 150) * 100));
$sysClr  = ($sys >= 140) ? 'var(--hv-red)' : (($sys >= 130) ? 'var(--hv-amber)' : 'var(--hv-teal)');
$bsClr   = ($record['blood_sugar'] >= 100) ? 'var(--hv-amber)' : 'var(--hv-teal)';
?>

<style>
/* ============================================================
   HEALTH RECORD VIEW  |  Premium HealthSaaS Analytics
   Enhanced: Spacing · Typography · Visual Hierarchy
   ============================================================ */

@import url('https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;1,9..40,300&family=Space+Mono:wght@400;700&display=swap');

:root {
    --hv-teal:      #00d4aa;
    --hv-teal-dim:  rgba(0,212,170,0.12);
    --hv-teal-glow: rgba(0,212,170,0.25);
    --hv-blue:      #3b82f6;
    --hv-blue-dim:  rgba(59,130,246,0.12);
    --hv-red:       #ef4444;
    --hv-red-dim:   rgba(239,68,68,0.12);
    --hv-amber:     #f59e0b;
    --hv-amber-dim: rgba(245,158,11,0.12);
    --hv-purple:    #a78bfa;
    --hv-purple-dim:rgba(167,139,250,0.12);
    --hv-glass:     rgba(255,255,255,0.04);
    --hv-glass2:    rgba(255,255,255,0.07);
    --hv-border:    rgba(255,255,255,0.08);
    --hv-border2:   rgba(255,255,255,0.14);
    --hv-text1:     #e8f4f0;
    --hv-text2:     #8fa8b8;
    --hv-text3:     #3d5060;
    --hv-font:      'DM Sans', sans-serif;
    --hv-mono:      'Space Mono', monospace;
}

.hv-module {
    font-family: var(--hv-font);
    color: var(--hv-text1);
    max-width: 1400px;
}
@keyframes hvFadeUp { from{opacity:0;transform:translateY(14px)} to{opacity:1;transform:translateY(0)} }
.hv-module { animation: hvFadeUp .35s ease; }

/* ---------- Back ---------- */
.hv-back {
    display: inline-flex; align-items: center; gap: 8px;
    font-size: 13px; color: var(--hv-text2);
    text-decoration: none; margin-bottom: 28px;
    transition: color .2s; font-weight: 500;
}
.hv-back:hover { color: var(--hv-teal); }

/* ---------- Page Header ---------- */
.hv-page-header {
    display: flex; align-items: flex-start;
    justify-content: space-between; gap: 20px;
    flex-wrap: wrap; margin-bottom: 36px;
}
.hv-header-left { display: flex; align-items: center; gap: 20px; }
.hv-page-icon {
    width: 62px; height: 62px; border-radius: 18px;
    background: var(--hv-teal-dim);
    border: 1px solid rgba(0,212,170,.25);
    display: flex; align-items: center; justify-content: center;
    font-size: 30px; flex-shrink: 0;
}
.hv-breadcrumb {
    display: flex; align-items: center; gap: 7px;
    font-size: 12px; color: var(--hv-text3); margin-bottom: 6px;
}
.hv-crumb-link { color: var(--hv-text2); text-decoration: none; font-weight: 500; }
.hv-crumb-link:hover { color: var(--hv-teal); }
.hv-page-title {
    font-size: 26px; font-weight: 700;
    color: var(--hv-text1); letter-spacing: -0.3px;
}
.hv-header-meta {
    display: flex; align-items: center; gap: 10px;
    margin-top: 10px; flex-wrap: wrap;
}
.hv-header-actions {
    display: flex; align-items: center; gap: 10px;
}

/* ---------- Badges ---------- */
.hv-badge {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 6px 13px; border-radius: 20px;
    font-size: 12px; font-weight: 600; letter-spacing: .3px;
}
.hv-badge-dot { width: 7px; height: 7px; border-radius: 50%; background: currentColor; }
@keyframes hvPulse { 0%,100%{opacity:1} 50%{opacity:.3} }
.hv-badge-normal   { background: rgba(0,212,170,.15); color: var(--hv-teal); border: 1px solid rgba(0,212,170,.3); }
.hv-badge-normal .hv-badge-dot { animation: hvPulse 2s infinite; }
.hv-badge-elevated { background: var(--hv-amber-dim); color: var(--hv-amber); border: 1px solid rgba(245,158,11,.3); }
.hv-badge-high     { background: var(--hv-red-dim);   color: var(--hv-red);   border: 1px solid rgba(239,68,68,.3); }

/* ---------- Buttons ---------- */
.hv-btn {
    display: inline-flex; align-items: center; gap: 7px;
    padding: 11px 20px; border-radius: 10px;
    font-family: var(--hv-font); font-size: 14px; font-weight: 500;
    cursor: pointer; border: none; transition: all .2s; text-decoration: none;
}
.hv-btn-edit { background: var(--hv-blue-dim); color: var(--hv-blue); border: 1px solid rgba(59,130,246,.25); }
.hv-btn-edit:hover { background: rgba(59,130,246,.2); transform: translateY(-1px); }
.hv-btn-del  { background: var(--hv-red-dim);  color: var(--hv-red);  border: 1px solid rgba(239,68,68,.25); }
.hv-btn-del:hover  { background: rgba(239,68,68,.2); transform: translateY(-1px); }

/* ---------- Vitals Grid ---------- */
.hv-vitals {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    gap: 16px; margin-bottom: 28px;
}
.hv-vital-card {
    background: var(--hv-glass);
    border: 1px solid var(--hv-border);
    border-radius: 18px; padding: 30px 24px;
    text-align: center;
    transition: transform .2s, box-shadow .2s, border-color .2s;
}
.hv-vital-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 16px 40px rgba(0,0,0,.35);
    border-color: var(--hv-border2);
}
.hv-vital-label {
    font-size: 11px; color: var(--hv-text2);
    text-transform: uppercase; letter-spacing: .8px;
    margin-bottom: 14px; font-weight: 600;
}
.hv-vital-val   { font-family: var(--hv-mono); font-size: 38px; font-weight: 700; line-height: 1; }
.hv-vital-unit  { font-size: 12px; color: var(--hv-text2); margin-top: 8px; font-weight: 400; }
.c-red    { color: var(--hv-red); }
.c-blue   { color: var(--hv-blue); }
.c-amber  { color: var(--hv-amber); }
.c-teal   { color: var(--hv-teal); }
.c-purple { color: var(--hv-purple); }
.c-text   { color: var(--hv-text1); font-size: 28px; }

/* ---------- Two-Column Layout ---------- */
.hv-two-col { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
.hv-panel   {
    background: var(--hv-glass);
    border: 1px solid var(--hv-border);
    border-radius: 18px; padding: 28px;
}
.hv-panel-title {
    font-size: 11px; font-weight: 700; color: var(--hv-text2);
    text-transform: uppercase; letter-spacing: .9px; margin-bottom: 24px;
}

/* ---------- Health Score Ring ---------- */
.hv-score-wrap {
    display: flex; align-items: center;
    gap: 26px; margin-bottom: 26px;
}
.hv-ring-center {
    position: relative; width: 100px; height: 100px;
    flex-shrink: 0; display: flex;
    align-items: center; justify-content: center;
}
.hv-ring-center svg {
    position: absolute; top: 0; left: 0;
    transform: rotate(-90deg);
}
.hv-ring-val {
    font-family: var(--hv-mono); font-size: 26px; font-weight: 700;
}
.hv-ring-lbl {
    font-size: 9px; color: var(--hv-text3);
    text-align: center; letter-spacing: .6px; margin-top: 2px;
}
.hv-score-desc h3 {
    font-size: 16px; font-weight: 700;
    color: var(--hv-text1); margin-bottom: 8px;
}
.hv-score-desc p {
    font-size: 13px; color: var(--hv-text2); line-height: 1.7;
}
.hv-divider      { height: 1px; background: var(--hv-border); margin: 22px 0; }
.hv-mini-grid    { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
.hv-mini-card    {
    background: rgba(0,212,170,.06);
    border-radius: 10px; padding: 14px; text-align: center;
}
.hv-mini-label   { font-size: 10px; color: var(--hv-text3); text-transform: uppercase; letter-spacing: .5px; }
.hv-mini-val     { font-size: 14px; font-weight: 700; margin-top: 5px; }

/* ---------- Trend Rows ---------- */
.hv-trend-row {
    display: flex; align-items: center; justify-content: space-between;
    padding: 13px 0; border-bottom: 1px solid var(--hv-border);
    gap: 16px;
}
.hv-trend-row:last-child { border-bottom: none; }
.hv-trend-metric { font-size: 12px; color: var(--hv-text2); margin-bottom: 8px; font-weight: 500; }
.hv-progress     { height: 5px; background: rgba(255,255,255,.06); border-radius: 3px; width: 90px; }
.hv-progress-fill{ height: 100%; border-radius: 3px; }
.hv-trend-val    { font-family: var(--hv-mono); font-size: 14px; white-space: nowrap; }

/* ---------- Notes Card ---------- */
.hv-notes {
    background: rgba(0,0,0,.2);
    border: 1px solid var(--hv-border);
    border-left: 3px solid var(--hv-teal);
    border-radius: 14px; padding: 26px; margin-top: 22px;
}
.hv-notes-label {
    font-size: 11px; font-weight: 700; color: var(--hv-text2);
    text-transform: uppercase; letter-spacing: .7px; margin-bottom: 14px;
}
.hv-notes-text {
    font-size: 14px; color: var(--hv-text1); line-height: 1.8;
}

/* ---------- Responsive ---------- */
@media (max-width: 900px) {
    .hv-two-col { grid-template-columns: 1fr; }
}
@media (max-width: 768px) {
    .hv-page-header { flex-direction: column; }
    .hv-vitals { grid-template-columns: repeat(2, 1fr); }
    .hv-vital-val { font-size: 30px; }
    .hv-page-title { font-size: 22px; }
}
@media (max-width: 480px) {
    .hv-vitals { grid-template-columns: 1fr; }
}
</style>

<div class="hv-module">

    <!-- Back Link -->
    <a href="index.php?page=health-records" class="hv-back">← Back to Health Records</a>

    <!-- Page Header -->
    <div class="hv-page-header">
        <div class="hv-header-left">
            <div class="hv-page-icon">📋</div>
            <div>
                <div class="hv-breadcrumb">
                    <a href="index.php?page=health-records" class="hv-crumb-link">Health Records</a>
                    <span>›</span>
                    <span>Record Detail</span>
                </div>
                <div class="hv-page-title">Record — <?= date('F j, Y', strtotime($record['date'])) ?></div>
                <div class="hv-header-meta">
                    <span class="hv-badge <?= $bpCls ?>">
                        <span class="hv-badge-dot"></span><?= $bpLabel ?>
                    </span>
                    <span style="font-size:12px;color:var(--hv-text3)">
                        Last updated <?= date('M d, Y', strtotime($record['updated_at'] ?? $record['date'])) ?>
                    </span>
                </div>
            </div>
        </div>
        <div class="hv-header-actions">
            <a href="index.php?page=health-records-edit&id=<?= $id ?>" class="hv-btn hv-btn-edit">✏️ Edit</a>
            <a href="index.php?page=health-records-delete&id=<?= $id ?>"
               class="hv-btn hv-btn-del"
               data-confirm="Delete this record? This cannot be undone.">🗑 Delete</a>
        </div>
    </div>

    <!-- Vital Sign Cards -->
    <div class="hv-vitals">
        <div class="hv-vital-card">
            <div class="hv-vital-label">Systolic BP</div>
            <div class="hv-vital-val c-red"><?= $record['systolic_bp'] ?></div>
            <div class="hv-vital-unit">mmHg</div>
        </div>
        <div class="hv-vital-card">
            <div class="hv-vital-label">Diastolic BP</div>
            <div class="hv-vital-val c-blue"><?= $record['diastolic_bp'] ?></div>
            <div class="hv-vital-unit">mmHg</div>
        </div>
        <div class="hv-vital-card">
            <div class="hv-vital-label">Combined BP</div>
            <div class="hv-vital-val c-text"><?= $record['systolic_bp'] ?>/<?= $record['diastolic_bp'] ?></div>
            <div class="hv-vital-unit">mmHg</div>
        </div>
        <div class="hv-vital-card">
            <div class="hv-vital-label">Heart Rate</div>
            <div class="hv-vital-val c-amber"><?= $record['heart_rate'] ?></div>
            <div class="hv-vital-unit">bpm</div>
        </div>
        <div class="hv-vital-card">
            <div class="hv-vital-label">Weight</div>
            <div class="hv-vital-val c-teal"><?= $record['weight'] ?></div>
            <div class="hv-vital-unit">kg</div>
        </div>
        <div class="hv-vital-card">
            <div class="hv-vital-label">Blood Sugar</div>
            <div class="hv-vital-val c-purple"><?= $record['blood_sugar'] ?></div>
            <div class="hv-vital-unit">mg/dL</div>
        </div>
    </div>

    <!-- Summary + Overview Panels -->
    <div class="hv-two-col">

        <!-- Health Summary -->
        <div class="hv-panel">
            <div class="hv-panel-title">Health Summary</div>
            <div class="hv-score-wrap">
                <div class="hv-ring-center">
                    <svg width="100" height="100" viewBox="0 0 100 100" aria-hidden="true">
                        <circle cx="50" cy="50" r="40" fill="none"
                                stroke="rgba(255,255,255,0.06)" stroke-width="7"/>
                        <circle cx="50" cy="50" r="40" fill="none"
                                stroke="<?= $scoreColor ?>" stroke-width="7"
                                stroke-dasharray="251.3"
                                stroke-dashoffset="<?= $ringOffset ?>"
                                stroke-linecap="round"/>
                    </svg>
                    <div style="text-align:center">
                        <div class="hv-ring-val" style="color:<?= $scoreColor ?>"><?= $score ?></div>
                        <div class="hv-ring-lbl">HEALTH<br>SCORE</div>
                    </div>
                </div>
                <div class="hv-score-desc">
                    <h3>
                        <?php
                        if ($score >= 85)      echo 'Excellent Standing';
                        elseif ($score >= 70)  echo 'Good Standing';
                        elseif ($score >= 55)  echo 'Needs Attention';
                        else                   echo 'Consult a Doctor';
                        ?>
                    </h3>
                    <p>
                        <?php
                        if ($bpLabel === 'Normal')        echo 'Blood pressure is within optimal range. Keep up your current lifestyle.';
                        elseif ($bpLabel === 'Elevated')  echo 'BP is slightly elevated. Consider reducing sodium and monitoring more frequently.';
                        else                              echo 'High blood pressure detected. Consult a healthcare provider promptly.';
                        ?>
                    </p>
                </div>
            </div>
            <div class="hv-divider"></div>
            <div class="hv-mini-grid">
                <div class="hv-mini-card">
                    <div class="hv-mini-label">BP Status</div>
                    <div class="hv-mini-val" style="color:<?= ($bpLabel === 'Normal') ? 'var(--hv-teal)' : (($bpLabel === 'Elevated') ? 'var(--hv-amber)' : 'var(--hv-red)') ?>">
                        <?= $bpLabel ?>
                    </div>
                </div>
                <div class="hv-mini-card">
                    <div class="hv-mini-label">Blood Sugar</div>
                    <div class="hv-mini-val" style="color:<?= ($record['blood_sugar'] >= 100) ? 'var(--hv-amber)' : 'var(--hv-teal)' ?>">
                        <?= ($record['blood_sugar'] >= 126) ? 'High' : (($record['blood_sugar'] >= 100) ? 'Pre-diabetic range' : 'Normal') ?>
                    </div>
                </div>
                <div class="hv-mini-card">
                    <div class="hv-mini-label">Heart Rate</div>
                    <div class="hv-mini-val" style="color:<?= ($record['heart_rate'] >= 60 && $record['heart_rate'] <= 100) ? 'var(--hv-teal)' : 'var(--hv-amber)' ?>">
                        <?= ($record['heart_rate'] >= 60 && $record['heart_rate'] <= 100) ? 'Normal' : 'Outside range' ?>
                    </div>
                </div>
                <div class="hv-mini-card">
                    <div class="hv-mini-label">Record Date</div>
                    <div class="hv-mini-val" style="color:var(--hv-text2);font-size:12px">
                        <?= date('M d, Y', strtotime($record['date'])) ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Vital Signs Overview -->
        <div class="hv-panel">
            <div class="hv-panel-title">Vital Signs Overview</div>
            <div class="hv-trend-row">
                <div>
                    <div class="hv-trend-metric">Systolic BP</div>
                    <div class="hv-progress">
                        <div class="hv-progress-fill" style="width:<?= $sysPct ?>%;background:<?= $sysClr ?>"></div>
                    </div>
                </div>
                <div class="hv-trend-val" style="color:<?= $sysClr ?>"><?= $record['systolic_bp'] ?> <span style="font-size:11px;color:var(--hv-text3)">mmHg</span></div>
            </div>
            <div class="hv-trend-row">
                <div>
                    <div class="hv-trend-metric">Diastolic BP</div>
                    <div class="hv-progress">
                        <div class="hv-progress-fill" style="width:<?= $diaPct ?>%;background:var(--hv-blue)"></div>
                    </div>
                </div>
                <div class="hv-trend-val" style="color:var(--hv-blue)"><?= $record['diastolic_bp'] ?> <span style="font-size:11px;color:var(--hv-text3)">mmHg</span></div>
            </div>
            <div class="hv-trend-row">
                <div>
                    <div class="hv-trend-metric">Heart Rate</div>
                    <div class="hv-progress">
                        <div class="hv-progress-fill" style="width:<?= $hrPct ?>%;background:var(--hv-amber)"></div>
                    </div>
                </div>
                <div class="hv-trend-val" style="color:var(--hv-amber)"><?= $record['heart_rate'] ?> <span style="font-size:11px;color:var(--hv-text3)">bpm</span></div>
            </div>
            <div class="hv-trend-row">
                <div>
                    <div class="hv-trend-metric">Blood Sugar</div>
                    <div class="hv-progress">
                        <div class="hv-progress-fill" style="width:<?= $bsPct ?>%;background:<?= $bsClr ?>"></div>
                    </div>
                </div>
                <div class="hv-trend-val" style="color:<?= $bsClr ?>"><?= $record['blood_sugar'] ?> <span style="font-size:11px;color:var(--hv-text3)">mg/dL</span></div>
            </div>
            <div class="hv-trend-row">
                <div>
                    <div class="hv-trend-metric">Weight</div>
                    <div class="hv-progress">
                        <div class="hv-progress-fill" style="width:<?= $wtPct ?>%;background:var(--hv-purple)"></div>
                    </div>
                </div>
                <div class="hv-trend-val" style="color:var(--hv-purple)"><?= $record['weight'] ?> <span style="font-size:11px;color:var(--hv-text3)">kg</span></div>
            </div>
        </div>
    </div>

    <!-- Notes (preserves existing condition check) -->
    <?php if (!empty($record['notes'])): ?>
        <div class="hv-notes">
            <div class="hv-notes-label">📝 Clinical Notes</div>
            <div class="hv-notes-text"><?= nl2br(htmlspecialchars($record['notes'])) ?></div>
        </div>
    <?php endif; ?>

</div><!-- /.hv-module -->

<?php require_once APP_PATH . '/views/shared/footer.php'; ?>