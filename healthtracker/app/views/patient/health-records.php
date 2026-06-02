<?php
$pageTitle = 'Health Records';
$activePage = 'health-records';
require_once APP_PATH . '/views/shared/header.php';
?>

<style>
/* ============================================================
   HEALTH RECORDS — LIST PAGE  |  Premium HealthSaaS Design
   Enhanced: Spacing · Typography · Visual Hierarchy · Readability
   ============================================================ */

@import url('https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;1,9..40,300&family=Space+Mono:wght@400;700&display=swap');

:root {
    --hr-bg:          #080e1a;
    --hr-bg2:         #0d1526;
    --hr-glass:       rgba(255,255,255,0.04);
    --hr-glass2:      rgba(255,255,255,0.07);
    --hr-border:      rgba(255,255,255,0.08);
    --hr-border2:     rgba(255,255,255,0.14);
    --hr-teal:        #00d4aa;
    --hr-teal-dim:    rgba(0,212,170,0.12);
    --hr-teal-glow:   rgba(0,212,170,0.28);
    --hr-blue:        #3b82f6;
    --hr-blue-dim:    rgba(59,130,246,0.12);
    --hr-red:         #ef4444;
    --hr-red-dim:     rgba(239,68,68,0.12);
    --hr-amber:       #f59e0b;
    --hr-amber-dim:   rgba(245,158,11,0.12);
    --hr-purple:      #a78bfa;
    --hr-purple-dim:  rgba(167,139,250,0.12);
    --hr-text1:       #e8f4f0;
    --hr-text2:       #8fa8b8;
    --hr-text3:       #3d5060;
    --hr-font:        'DM Sans', sans-serif;
    --hr-mono:        'Space Mono', monospace;
}

.hr-module {
    font-family: var(--hr-font);
    color: var(--hr-text1);
    max-width: 1400px;
}

/* ---------- Flash Message ---------- */
.hr-flash {
    display: flex; align-items: center; gap: 12px;
    background: rgba(0,212,170,0.1);
    border: 1px solid rgba(0,212,170,0.3);
    border-radius: 14px; padding: 16px 22px;
    font-size: 14px; color: var(--hr-teal);
    margin-bottom: 28px;
    animation: hrFadeUp .4s ease;
}

/* ---------- Page Header ---------- */
.hr-page-header {
    display: flex; align-items: flex-start;
    justify-content: space-between; gap: 20px;
    flex-wrap: wrap; margin-bottom: 36px;
}
.hr-header-left { display: flex; align-items: center; gap: 20px; }
.hr-page-icon {
    width: 62px; height: 62px; border-radius: 18px;
    background: var(--hr-teal-dim);
    border: 1px solid rgba(0,212,170,0.25);
    display: flex; align-items: center; justify-content: center;
    font-size: 30px; flex-shrink: 0;
}
.hr-page-title {
    font-size: 28px; font-weight: 700;
    color: var(--hr-text1); line-height: 1.2;
    letter-spacing: -0.3px;
}
.hr-page-sub {
    font-size: 14px; color: var(--hr-text2);
    margin-top: 5px; font-weight: 400;
}
.hr-header-actions {
    display: flex; align-items: center;
    gap: 10px; flex-wrap: wrap;
}

/* ---------- Search Bar ---------- */
.hr-search {
    display: flex; align-items: center; gap: 10px;
    background: rgba(0,0,0,0.35);
    border: 1px solid var(--hr-border2);
    border-radius: 11px; padding: 10px 16px;
    min-width: 240px;
    transition: border-color .2s;
}
.hr-search:focus-within {
    border-color: rgba(0,212,170,.35);
}
.hr-search input {
    background: none; border: none; outline: none;
    font-family: var(--hr-font); font-size: 14px;
    color: var(--hr-text1); width: 100%;
}
.hr-search input::placeholder { color: var(--hr-text3); }
.hr-search-icon { color: var(--hr-text2); font-size: 16px; }

/* ---------- Custom Status Dropdown ---------- */
.hr-dropdown { position: relative; }
.hr-dropdown-btn {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 10px 16px; border-radius: 10px;
    font-family: var(--hr-font); font-size: 14px; font-weight: 500;
    cursor: pointer; border: 1px solid var(--hr-border);
    background: var(--hr-glass); color: var(--hr-text2);
    white-space: nowrap; transition: all .2s; user-select: none;
    min-width: 148px; justify-content: space-between;
}
.hr-dropdown-btn:hover { background: var(--hr-glass2); color: var(--hr-text1); }
.hr-dropdown-btn.open  { border-color: rgba(0,212,170,.35); color: var(--hr-text1); }
.hr-dropdown-arrow { font-size: 10px; color: var(--hr-text3); transition: transform .2s; }
.hr-dropdown-btn.open .hr-dropdown-arrow { transform: rotate(180deg); }
.hr-dropdown-menu {
    position: absolute; top: calc(100% + 6px); left: 0;
    min-width: 100%; background: #0f1c2e;
    border: 1px solid var(--hr-border2);
    border-radius: 12px; overflow: hidden;
    box-shadow: 0 16px 48px rgba(0,0,0,.6);
    z-index: 100;
    opacity: 0; transform: translateY(-6px);
    pointer-events: none;
    transition: opacity .18s ease, transform .18s ease;
}
.hr-dropdown-menu.open {
    opacity: 1; transform: translateY(0); pointer-events: all;
}
.hr-dropdown-item {
    display: flex; align-items: center; gap: 10px;
    padding: 11px 16px; font-size: 13px; font-weight: 500;
    color: var(--hr-text2); cursor: pointer;
    transition: background .15s, color .15s;
}
.hr-dropdown-item:hover { background: var(--hr-glass2); color: var(--hr-text1); }
.hr-dropdown-item.active { color: var(--hr-teal); background: var(--hr-teal-dim); }
.hr-dropdown-item .hr-di-dot {
    width: 7px; height: 7px; border-radius: 50%;
    flex-shrink: 0; opacity: .7;
}

/* ---------- Buttons ---------- */
.hr-btn {
    display: inline-flex; align-items: center; gap: 7px;
    padding: 10px 18px; border-radius: 10px;
    font-family: var(--hr-font); font-size: 14px; font-weight: 500;
    cursor: pointer; border: none; transition: all .2s;
    text-decoration: none; white-space: nowrap;
}
.hr-btn-teal {
    background: linear-gradient(135deg, #00c49a, #009f7f);
    color: #001a12;
    padding: 10px 20px;
}
.hr-btn-teal:hover {
    transform: translateY(-2px);
    box-shadow: 0 0 28px var(--hr-teal-glow);
}
.hr-btn-ghost {
    background: var(--hr-glass); color: var(--hr-text2);
    border: 1px solid var(--hr-border);
}
.hr-btn-ghost:hover { background: var(--hr-glass2); color: var(--hr-text1); }

/* ---------- Analytics Row ---------- */
.hr-analytics {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(190px, 1fr));
    gap: 16px; margin-bottom: 32px;
}
.hr-stat-card {
    background: var(--hr-glass);
    border: 1px solid var(--hr-border);
    border-radius: 18px; padding: 26px 24px;
    transition: transform .2s, box-shadow .2s, border-color .2s;
}
.hr-stat-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 16px 48px rgba(0,0,0,.4);
    border-color: var(--hr-border2);
}
.hr-stat-icon {
    width: 48px; height: 48px; border-radius: 13px;
    display: flex; align-items: center; justify-content: center;
    font-size: 22px; margin-bottom: 18px;
}
.hr-icon-teal   { background: var(--hr-teal-dim); }
.hr-icon-red    { background: var(--hr-red-dim); }
.hr-icon-amber  { background: var(--hr-amber-dim); }
.hr-icon-blue   { background: var(--hr-blue-dim); }
.hr-icon-purple { background: var(--hr-purple-dim); }
.hr-stat-val {
    font-family: var(--hr-mono); font-size: 28px;
    font-weight: 700; color: var(--hr-text1);
    line-height: 1;
}
.hr-stat-label {
    font-size: 12px; color: var(--hr-text2);
    margin-top: 8px; font-weight: 500;
    text-transform: uppercase; letter-spacing: 0.5px;
}
.hr-stat-trend {
    display: flex; align-items: center; gap: 5px;
    margin-top: 10px; font-size: 12px;
}
.hr-trend-up     { color: var(--hr-teal); }
.hr-trend-dn     { color: var(--hr-red); }
.hr-trend-neutral { color: var(--hr-text2); }

/* ---------- Section Label ---------- */
.hr-section-label {
    font-size: 11px; font-weight: 600; color: var(--hr-text3);
    text-transform: uppercase; letter-spacing: 1px;
    margin-bottom: 14px;
}

/* ---------- Table ---------- */
.hr-table-wrap {
    border-radius: 18px; overflow: hidden;
    border: 1px solid var(--hr-border);
    background: var(--hr-glass);
    margin-bottom: 32px;
}
.hr-table-wrap table { width: 100%; border-collapse: collapse; }
.hr-table-wrap thead { background: rgba(0,0,0,.35); }
.hr-table-wrap th {
    padding: 16px 20px; font-size: 11px; font-weight: 600;
    color: var(--hr-text2); text-transform: uppercase;
    letter-spacing: .9px; text-align: left; white-space: nowrap;
}
.hr-table-wrap td {
    padding: 18px 20px; font-size: 14px; color: var(--hr-text1);
    border-top: 1px solid var(--hr-border);
    vertical-align: middle;
}
.hr-table-wrap tbody tr { transition: background .15s; }
.hr-table-wrap tbody tr:hover { background: var(--hr-glass2); }
.hr-td-num   { color: var(--hr-text3); font-size: 13px; font-family: var(--hr-mono); }
.hr-td-date  { font-weight: 600; color: var(--hr-text1); font-size: 14px; }
.hr-td-mono  { font-family: var(--hr-mono); font-size: 14px; font-weight: 700; }
.hr-td-unit  { font-size: 11px; color: var(--hr-text2); font-weight: 400; }
.hr-actions  { display: flex; gap: 8px; align-items: center; }

/* ---------- Icon Buttons ---------- */
.hr-icon-btn {
    width: 36px; height: 36px; border-radius: 9px;
    display: inline-flex; align-items: center; justify-content: center;
    font-size: 15px; cursor: pointer; transition: all .2s;
    border: 1px solid var(--hr-border); background: var(--hr-glass);
    color: var(--hr-text2); text-decoration: none;
}
.hr-icon-btn:hover { transform: scale(1.12); }
.hr-icon-btn.view:hover { background: var(--hr-teal-dim); color: var(--hr-teal); border-color: rgba(0,212,170,.3); }
.hr-icon-btn.edit:hover { background: var(--hr-blue-dim); color: var(--hr-blue); border-color: rgba(59,130,246,.3); }
.hr-icon-btn.del:hover  { background: var(--hr-red-dim);  color: var(--hr-red);  border-color: rgba(239,68,68,.3); }

/* ---------- Status Badges ---------- */
.hr-badge {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 6px 13px; border-radius: 20px;
    font-size: 12px; font-weight: 600; letter-spacing: .3px;
    white-space: nowrap;
}
.hr-badge-dot {
    width: 7px; height: 7px; border-radius: 50%;
    background: currentColor; display: inline-block;
}
@keyframes hrDotPulse { 0%,100%{opacity:1} 50%{opacity:.35} }
.hr-badge-normal   { background: rgba(0,212,170,.15); color: var(--hr-teal); border: 1px solid rgba(0,212,170,.3); }
.hr-badge-normal .hr-badge-dot { animation: hrDotPulse 2s infinite; }
.hr-badge-elevated { background: var(--hr-amber-dim); color: var(--hr-amber); border: 1px solid rgba(245,158,11,.3); }
.hr-badge-high     { background: var(--hr-red-dim);   color: var(--hr-red);   border: 1px solid rgba(239,68,68,.3); }

/* ---------- Empty State ---------- */
.hr-empty {
    text-align: center; padding: 90px 30px;
    background: var(--hr-glass); border-radius: 18px;
    border: 1px solid var(--hr-border);
}
.hr-empty-icon  { font-size: 56px; margin-bottom: 20px; }
.hr-empty-title { font-size: 22px; font-weight: 700; color: var(--hr-text1); margin-bottom: 10px; }
.hr-empty-sub   { font-size: 15px; color: var(--hr-text2); margin-bottom: 30px; }

/* ---------- Lower Panels ---------- */
.hr-two-col {
    display: grid; grid-template-columns: 1fr 1fr;
    gap: 20px;
}
.hr-panel {
    background: var(--hr-glass);
    border: 1px solid var(--hr-border);
    border-radius: 18px; padding: 28px;
}
.hr-panel-title {
    font-size: 11px; font-weight: 700; color: var(--hr-text2);
    text-transform: uppercase; letter-spacing: .9px;
    margin-bottom: 22px;
}
.hr-activity-item {
    display: flex; align-items: flex-start; gap: 14px;
    padding: 14px 0; border-bottom: 1px solid var(--hr-border);
}
.hr-activity-item:last-child { border-bottom: none; }
.hr-activity-dot {
    width: 9px; height: 9px; border-radius: 50%;
    margin-top: 5px; flex-shrink: 0;
}
.hr-activity-text { font-size: 13px; color: var(--hr-text1); font-weight: 500; }
.hr-activity-time { font-size: 12px; color: var(--hr-text3); margin-top: 4px; }
.hr-trend-row {
    display: flex; align-items: center; justify-content: space-between;
    padding: 13px 0; border-bottom: 1px solid var(--hr-border);
    gap: 16px;
}
.hr-trend-row:last-child { border-bottom: none; }
.hr-trend-metric { font-size: 12px; color: var(--hr-text2); margin-bottom: 8px; font-weight: 500; }
.hr-trend-val    { font-family: var(--hr-mono); font-size: 14px; color: var(--hr-text1); white-space: nowrap; }
.hr-progress     { height: 5px; background: rgba(255,255,255,.06); border-radius: 3px; width: 90px; }
.hr-progress-fill { height: 100%; border-radius: 3px; background: var(--hr-teal); }

/* ---------- Animation ---------- */
@keyframes hrFadeUp {
    from { opacity: 0; transform: translateY(14px); }
    to   { opacity: 1; transform: translateY(0); }
}
.hr-module { animation: hrFadeUp .35s ease; }

/* ---------- Responsive ---------- */
@media (max-width: 900px) {
    .hr-two-col { grid-template-columns: 1fr; }
}
@media (max-width: 768px) {
    .hr-page-header { flex-direction: column; }
    .hr-analytics { grid-template-columns: repeat(2, 1fr); }
    .hr-page-title { font-size: 22px; }
    .hr-stat-val { font-size: 24px; }
}
@media (max-width: 480px) {
    .hr-analytics { grid-template-columns: 1fr; }
    .hr-search { min-width: unset; width: 100%; }
}
</style>

<div class="hr-module">

    <?php if (!empty($flash)): ?>
        <div class="hr-flash">✅ <?= htmlspecialchars($flash) ?></div>
    <?php endif; ?>

    <!-- Page Header -->
    <div class="hr-page-header">
        <div class="hr-header-left">
            <div class="hr-page-icon">📋</div>
            <div>
                <div class="hr-page-title">Health Records</div>
                <div class="hr-page-sub">Monitor and manage your health metrics efficiently</div>
            </div>
        </div>
        <div class="hr-header-actions">
            <div class="hr-search">
                <span class="hr-search-icon">🔍</span>
                <input type="text" id="hrSearch" placeholder="Search records..." onkeyup="hrFilterTable()">
            </div>
            <div class="hr-dropdown" id="statusDropdown">
                <div class="hr-dropdown-btn" id="statusDropdownBtn" onclick="hrToggleDropdown()">
                    <span id="statusDropdownLabel">All Statuses</span>
                    <span class="hr-dropdown-arrow">▼</span>
                </div>
                <div class="hr-dropdown-menu" id="statusDropdownMenu">
                    <div class="hr-dropdown-item active" data-value="" onclick="hrSelectStatus(this, '')">
                        <span class="hr-di-dot" style="background:var(--hr-text2)"></span> All Statuses
                    </div>
                    <div class="hr-dropdown-item" data-value="Normal" onclick="hrSelectStatus(this, 'Normal')">
                        <span class="hr-di-dot" style="background:var(--hr-teal)"></span> Normal
                    </div>
                    <div class="hr-dropdown-item" data-value="Elevated" onclick="hrSelectStatus(this, 'Elevated')">
                        <span class="hr-di-dot" style="background:var(--hr-amber)"></span> Elevated
                    </div>
                    <div class="hr-dropdown-item" data-value="High" onclick="hrSelectStatus(this, 'High')">
                        <span class="hr-di-dot" style="background:var(--hr-red)"></span> High
                    </div>
                </div>
            </div>
            <a href="index.php?page=health-records&export=csv" class="hr-btn hr-btn-ghost">⬇ Export</a>
            <a href="index.php?page=health-records-create" class="hr-btn hr-btn-teal">＋ Add Record</a>
        </div>
    </div>

    <?php
    /* ---- Compute Analytics from existing $records ---- */
    $totalRecords = count($records);
    $avgSys = $avgDia = $avgHr = $avgWt = $avgBs = 0;
    if ($totalRecords > 0) {
        foreach ($records as $r) {
            $avgSys += $r['systolic_bp'];
            $avgDia += $r['diastolic_bp'];
            $avgHr  += $r['heart_rate'];
            $avgWt  += $r['weight'];
            $avgBs  += $r['blood_sugar'];
        }
        $avgSys = round($avgSys / $totalRecords);
        $avgDia = round($avgDia / $totalRecords);
        $avgHr  = round($avgHr  / $totalRecords);
        $avgWt  = round($avgWt  / $totalRecords, 1);
        $avgBs  = round($avgBs  / $totalRecords);
    }
    /* Determine avg BP status label */
    if ($avgSys >= 140 || $avgDia >= 90)     { $avgBpTrend = '↑ avg elevated'; $avgBpClass = 'hr-trend-dn'; }
    elseif ($avgSys >= 130 || $avgDia >= 80) { $avgBpTrend = '↑ slightly above normal'; $avgBpClass = 'hr-trend-dn'; }
    else                                      { $avgBpTrend = '✓ within normal range';  $avgBpClass = 'hr-trend-up'; }
    ?>

    <?php if ($totalRecords > 0): ?>

    <!-- Analytics Cards -->
    <div class="hr-analytics">
        <div class="hr-stat-card">
            <div class="hr-stat-icon hr-icon-teal">📁</div>
            <div class="hr-stat-val"><?= $totalRecords ?></div>
            <div class="hr-stat-label">Total Records</div>
            <div class="hr-stat-trend hr-trend-up">↑ tracking your health</div>
        </div>
        <div class="hr-stat-card">
            <div class="hr-stat-icon hr-icon-red">🫀</div>
            <div class="hr-stat-val"><?= $avgSys ?>/<?= $avgDia ?></div>
            <div class="hr-stat-label">Avg Blood Pressure</div>
            <div class="hr-stat-trend <?= $avgBpClass ?>"><?= $avgBpTrend ?></div>
        </div>
        <div class="hr-stat-card">
            <div class="hr-stat-icon hr-icon-amber">💓</div>
            <div class="hr-stat-val"><?= $avgHr ?></div>
            <div class="hr-stat-label">Avg Heart Rate <span class="hr-td-unit">bpm</span></div>
            <div class="hr-stat-trend hr-trend-neutral">resting average</div>
        </div>
        <div class="hr-stat-card">
            <div class="hr-stat-icon hr-icon-blue">⚖</div>
            <div class="hr-stat-val"><?= $avgWt ?></div>
            <div class="hr-stat-label">Avg Weight <span class="hr-td-unit">kg</span></div>
            <div class="hr-stat-trend hr-trend-neutral">across all records</div>
        </div>
        <div class="hr-stat-card">
            <div class="hr-stat-icon hr-icon-purple">🩸</div>
            <div class="hr-stat-val"><?= $avgBs ?></div>
            <div class="hr-stat-label">Avg Blood Sugar <span class="hr-td-unit">mg/dL</span></div>
            <div class="hr-stat-trend <?= ($avgBs >= 100) ? 'hr-trend-dn' : 'hr-trend-up' ?>">
                <?= ($avgBs >= 100) ? '↑ above fasting normal' : '✓ fasting normal range' ?>
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="hr-section-label">All Records</div>
    <div class="hr-table-wrap">
        <table id="hrTable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Date</th>
                    <th>Blood Pressure</th>
                    <th>Heart Rate</th>
                    <th>Weight</th>
                    <th>Blood Sugar</th>
                    <th>BP Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($records as $i => $r): ?>
                    <?php
                    $sys = $r['systolic_bp'];
                    $dia = $r['diastolic_bp'];
                    if ($sys >= 140 || $dia >= 90)     { $bpLabel = 'High';     $bpCls = 'hr-badge-high'; }
                    elseif ($sys >= 130 || $dia >= 80) { $bpLabel = 'Elevated'; $bpCls = 'hr-badge-elevated'; }
                    else                               { $bpLabel = 'Normal';   $bpCls = 'hr-badge-normal'; }
                    ?>
                    <tr data-status="<?= $bpLabel ?>">
                        <td class="hr-td-num"><?= $i + 1 ?></td>
                        <td><span class="hr-td-date"><?= date('M d, Y', strtotime($r['date'])) ?></span></td>
                        <td class="hr-td-mono">
                            <?= $r['systolic_bp'] ?>/<?= $r['diastolic_bp'] ?>
                            <span class="hr-td-unit">mmHg</span>
                        </td>
                        <td class="hr-td-mono">
                            <?= $r['heart_rate'] ?> <span class="hr-td-unit">bpm</span>
                        </td>
                        <td class="hr-td-mono">
                            <?= $r['weight'] ?> <span class="hr-td-unit">kg</span>
                        </td>
                        <td class="hr-td-mono">
                            <?= $r['blood_sugar'] ?> <span class="hr-td-unit">mg/dL</span>
                        </td>
                        <td>
                            <span class="hr-badge <?= $bpCls ?>">
                                <span class="hr-badge-dot"></span><?= $bpLabel ?>
                            </span>
                        </td>
                        <td>
                            <div class="hr-actions">
                                <a href="index.php?page=health-records-view&id=<?= $r['id'] ?>"
                                   class="hr-icon-btn view" title="View Record">👁</a>
                                <a href="index.php?page=health-records-edit&id=<?= $r['id'] ?>"
                                   class="hr-icon-btn edit" title="Edit Record">✏️</a>
                                <a href="index.php?page=health-records-delete&id=<?= $r['id'] ?>"
                                   class="hr-icon-btn del" title="Delete Record"
                                   data-confirm="Delete this health record? This cannot be undone.">🗑</a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Lower Panels -->
    <div class="hr-two-col">
        <!-- Recent Activity -->
        <div class="hr-panel">
            <div class="hr-panel-title">Recent Activity</div>
            <?php $recent = array_slice($records, 0, 4); foreach ($recent as $idx => $r):
                $colors = ['var(--hr-teal)','var(--hr-amber)','var(--hr-blue)','var(--hr-purple)'];
                $dotColor = $colors[$idx % 4];
                $sys = $r['systolic_bp']; $dia = $r['diastolic_bp'];
                if ($sys >= 140 || $dia >= 90)     $action = 'High BP recorded';
                elseif ($sys >= 130 || $dia >= 80) $action = 'Elevated BP recorded';
                else                               $action = 'Record added';
            ?>
                <div class="hr-activity-item">
                    <div class="hr-activity-dot" style="background:<?= $dotColor ?>"></div>
                    <div>
                        <div class="hr-activity-text"><?= $action ?> — <?= date('M d, Y', strtotime($r['date'])) ?></div>
                        <div class="hr-activity-time">BP: <?= $r['systolic_bp'] ?>/<?= $r['diastolic_bp'] ?> · HR: <?= $r['heart_rate'] ?> bpm</div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Health Trends -->
        <div class="hr-panel">
            <div class="hr-panel-title">Health Trends — All Records</div>
            <?php
            /* Compute % of normal range for progress bars (using real averages) */
            $sysPct  = min(100, round(($avgSys  / 180) * 100));
            $diaPct  = min(100, round(($avgDia  / 120) * 100));
            $hrPct   = min(100, round(($avgHr   / 180) * 100));
            $bsPct   = min(100, round(($avgBs   / 250) * 100));
            $wtPct   = min(100, round(($avgWt   / 150) * 100));
            $sysColor = ($avgSys >= 140) ? 'var(--hr-red)' : (($avgSys >= 130) ? 'var(--hr-amber)' : 'var(--hr-teal)');
            $bsColor  = ($avgBs  >= 100) ? 'var(--hr-amber)' : 'var(--hr-teal)';
            ?>
            <div class="hr-trend-row">
                <div>
                    <div class="hr-trend-metric">Avg Systolic BP</div>
                    <div class="hr-progress"><div class="hr-progress-fill" style="width:<?= $sysPct ?>%;background:<?= $sysColor ?>"></div></div>
                </div>
                <div class="hr-trend-val" style="color:<?= $sysColor ?>"><?= $avgSys ?> <span class="hr-td-unit">mmHg</span></div>
            </div>
            <div class="hr-trend-row">
                <div>
                    <div class="hr-trend-metric">Avg Diastolic BP</div>
                    <div class="hr-progress"><div class="hr-progress-fill" style="width:<?= $diaPct ?>%;background:var(--hr-blue)"></div></div>
                </div>
                <div class="hr-trend-val" style="color:var(--hr-blue)"><?= $avgDia ?> <span class="hr-td-unit">mmHg</span></div>
            </div>
            <div class="hr-trend-row">
                <div>
                    <div class="hr-trend-metric">Avg Heart Rate</div>
                    <div class="hr-progress"><div class="hr-progress-fill" style="width:<?= $hrPct ?>%;background:var(--hr-amber)"></div></div>
                </div>
                <div class="hr-trend-val" style="color:var(--hr-amber)"><?= $avgHr ?> <span class="hr-td-unit">bpm</span></div>
            </div>
            <div class="hr-trend-row">
                <div>
                    <div class="hr-trend-metric">Avg Blood Sugar</div>
                    <div class="hr-progress"><div class="hr-progress-fill" style="width:<?= $bsPct ?>%;background:<?= $bsColor ?>"></div></div>
                </div>
                <div class="hr-trend-val" style="color:<?= $bsColor ?>"><?= $avgBs ?> <span class="hr-td-unit">mg/dL</span></div>
            </div>
            <div class="hr-trend-row">
                <div>
                    <div class="hr-trend-metric">Avg Weight</div>
                    <div class="hr-progress"><div class="hr-progress-fill" style="width:<?= $wtPct ?>%;background:var(--hr-purple)"></div></div>
                </div>
                <div class="hr-trend-val" style="color:var(--hr-purple)"><?= $avgWt ?> <span class="hr-td-unit">kg</span></div>
            </div>
        </div>
    </div>

    <?php else: ?>
    <!-- Empty State -->
    <div class="hr-empty">
        <div class="hr-empty-icon">📋</div>
        <div class="hr-empty-title">No health records yet</div>
        <div class="hr-empty-sub">Start tracking your vitals by adding your first record.</div>
        <a href="index.php?page=health-records-create" class="hr-btn hr-btn-teal">＋ Add First Record</a>
    </div>
    <?php endif; ?>

</div><!-- /.hr-module -->

<script>
/* Live search — no backend change */
function hrFilterTable() {
    const q = document.getElementById('hrSearch').value.toLowerCase();
    document.querySelectorAll('#hrTable tbody tr').forEach(row => {
        row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
    });
}
/* Status filter */
function hrFilterStatus(val) {
    document.querySelectorAll('#hrTable tbody tr').forEach(row => {
        if (!val || row.dataset.status === val) row.style.display = '';
        else row.style.display = 'none';
    });
}
/* Custom dropdown */
function hrToggleDropdown() {
    const btn  = document.getElementById('statusDropdownBtn');
    const menu = document.getElementById('statusDropdownMenu');
    const open = menu.classList.toggle('open');
    btn.classList.toggle('open', open);
}
function hrSelectStatus(el, val) {
    /* Update active state */
    document.querySelectorAll('#statusDropdownMenu .hr-dropdown-item')
        .forEach(i => i.classList.remove('active'));
    el.classList.add('active');
    /* Update label */
    document.getElementById('statusDropdownLabel').textContent = el.textContent.trim();
    /* Close */
    document.getElementById('statusDropdownMenu').classList.remove('open');
    document.getElementById('statusDropdownBtn').classList.remove('open');
    /* Filter */
    hrFilterStatus(val);
}
/* Close dropdown on outside click */
document.addEventListener('click', function(e) {
    if (!document.getElementById('statusDropdown').contains(e.target)) {
        document.getElementById('statusDropdownMenu').classList.remove('open');
        document.getElementById('statusDropdownBtn').classList.remove('open');
    }
});
/* Staggered row animation on load */
document.querySelectorAll('#hrTable tbody tr').forEach((row, i) => {
    row.style.opacity = 0;
    row.style.transform = 'translateY(8px)';
    row.style.transition = 'opacity .3s ease, transform .3s ease';
    setTimeout(() => { row.style.opacity = 1; row.style.transform = 'translateY(0)'; }, 60 + i * 40);
});
</script>

<?php require_once APP_PATH . '/views/shared/footer.php'; ?>