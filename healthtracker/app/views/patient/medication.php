<?php
$pageTitle = 'Medications';
$activePage = 'medication';
require_once APP_PATH . '/views/shared/header.php';
?>

<style>
/* ============================================================
   MEDICATION LIST PAGE  |  Premium HealthSaaS Design
   Enhanced: Spacing · Typography · Visual Hierarchy
   ============================================================ */

@import url('https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;1,9..40,300&family=Space+Mono:wght@400;700&display=swap');

:root {
    --ml-teal:        #00d4aa;
    --ml-teal-dim:    rgba(0,212,170,0.12);
    --ml-teal-glow:   rgba(0,212,170,0.28);
    --ml-orange:      #f97316;
    --ml-orange-dim:  rgba(249,115,22,0.12);
    --ml-orange-glow: rgba(249,115,22,0.28);
    --ml-blue:        #3b82f6;
    --ml-blue-dim:    rgba(59,130,246,0.12);
    --ml-red:         #ef4444;
    --ml-red-dim:     rgba(239,68,68,0.12);
    --ml-amber:       #f59e0b;
    --ml-amber-dim:   rgba(245,158,11,0.12);
    --ml-purple:      #a78bfa;
    --ml-purple-dim:  rgba(167,139,250,0.12);
    --ml-glass:       rgba(255,255,255,0.04);
    --ml-glass2:      rgba(255,255,255,0.07);
    --ml-border:      rgba(255,255,255,0.08);
    --ml-border2:     rgba(255,255,255,0.14);
    --ml-text1:       #e8f4f0;
    --ml-text2:       #8fa8b8;
    --ml-text3:       #3d5060;
    --ml-font:        'DM Sans', sans-serif;
    --ml-mono:        'Space Mono', monospace;
}

.ml-module { font-family: var(--ml-font); color: var(--ml-text1); max-width: 1400px; }
@keyframes mlFadeUp { from{opacity:0;transform:translateY(14px)} to{opacity:1;transform:translateY(0)} }
.ml-module { animation: mlFadeUp .35s ease; }

/* ---------- Flash ---------- */
.ml-flash {
    display: flex; align-items: center; gap: 12px;
    background: rgba(0,212,170,0.1); border: 1px solid rgba(0,212,170,0.3);
    border-radius: 14px; padding: 16px 22px;
    font-size: 14px; color: var(--ml-teal); margin-bottom: 28px;
}

/* ---------- Page Header ---------- */
.ml-header {
    display: flex; align-items: center; justify-content: space-between;
    gap: 20px; flex-wrap: wrap; margin-bottom: 36px;
}
.ml-header-left { display: flex; align-items: center; gap: 20px; }
.ml-page-icon {
    width: 62px; height: 62px; border-radius: 18px;
    background: var(--ml-orange-dim); border: 1px solid rgba(249,115,22,.28);
    display: flex; align-items: center; justify-content: center;
    font-size: 30px; flex-shrink: 0;
}
.ml-page-title {
    font-size: 28px; font-weight: 700; color: var(--ml-text1);
    letter-spacing: -0.3px; line-height: 1.2;
}
.ml-page-sub { font-size: 14px; color: var(--ml-text2); margin-top: 5px; }
.ml-count-pill {
    display: inline-flex; align-items: center; gap: 6px;
    background: var(--ml-orange-dim); border: 1px solid rgba(249,115,22,.25);
    border-radius: 20px; padding: 5px 13px;
    font-size: 13px; font-weight: 600; color: var(--ml-orange); margin-top: 8px;
}

/* ---------- Buttons ---------- */
.ml-btn {
    display: inline-flex; align-items: center; gap: 7px;
    padding: 11px 22px; border-radius: 10px;
    font-family: var(--ml-font); font-size: 14px; font-weight: 600;
    cursor: pointer; border: none; transition: all .2s;
    text-decoration: none; white-space: nowrap;
}
.ml-btn-primary {
    background: linear-gradient(135deg, #f97316, #ea6a0a);
    color: #fff;
}
.ml-btn-primary:hover { transform: translateY(-2px); box-shadow: 0 0 28px var(--ml-orange-glow); }
.ml-btn-ghost {
    background: var(--ml-glass); color: var(--ml-text2);
    border: 1px solid var(--ml-border);
}
.ml-btn-ghost:hover { background: var(--ml-glass2); color: var(--ml-text1); }
.ml-btn-edit {
    background: var(--ml-blue-dim); color: var(--ml-blue);
    border: 1px solid rgba(59,130,246,.25);
    padding: 8px 14px; font-size: 13px; border-radius: 8px;
}
.ml-btn-edit:hover { background: rgba(59,130,246,.2); transform: translateY(-1px); }
.ml-btn-del {
    background: var(--ml-red-dim); color: var(--ml-red);
    border: 1px solid rgba(239,68,68,.25);
    padding: 8px 14px; font-size: 13px; border-radius: 8px;
}
.ml-btn-del:hover { background: rgba(239,68,68,.2); transform: translateY(-1px); }

/* ---------- Status Badges ---------- */
.ml-badge {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 6px 13px; border-radius: 20px;
    font-size: 12px; font-weight: 600; letter-spacing: .3px;
    white-space: nowrap;
}
.ml-badge-dot { width: 7px; height: 7px; border-radius: 50%; background: currentColor; }
@keyframes mlDotPulse { 0%,100%{opacity:1} 50%{opacity:.3} }
.ml-badge-active   { background: rgba(0,212,170,.15); color: var(--ml-teal);   border: 1px solid rgba(0,212,170,.3); }
.ml-badge-active .ml-badge-dot { animation: mlDotPulse 2s infinite; }
.ml-badge-inactive { background: var(--ml-glass2);   color: var(--ml-text2);  border: 1px solid var(--ml-border2); }
.ml-badge-paused   { background: var(--ml-amber-dim); color: var(--ml-amber);  border: 1px solid rgba(245,158,11,.3); }

/* ---------- Med Cards Grid ---------- */
.ml-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
    gap: 18px; margin-bottom: 36px;
}
.ml-card {
    background: var(--ml-glass);
    border: 1px solid var(--ml-border);
    border-radius: 18px; padding: 26px;
    transition: transform .2s, box-shadow .2s, border-color .2s;
    display: flex; flex-direction: column; gap: 0;
}
.ml-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 16px 48px rgba(0,0,0,.4);
    border-color: var(--ml-border2);
}
.ml-card-top {
    display: flex; align-items: flex-start;
    justify-content: space-between; margin-bottom: 18px;
}
.ml-card-icon {
    width: 52px; height: 52px; border-radius: 14px;
    background: var(--ml-orange-dim); border: 1px solid rgba(249,115,22,.2);
    display: flex; align-items: center; justify-content: center; font-size: 26px;
}
.ml-card-name {
    font-size: 17px; font-weight: 700; color: var(--ml-text1);
    margin-bottom: 5px; line-height: 1.3;
}
.ml-card-dosage {
    font-family: var(--ml-mono); font-size: 15px; font-weight: 700;
    color: var(--ml-orange); margin-bottom: 14px;
}
.ml-card-detail {
    font-size: 13px; color: var(--ml-text2);
    display: flex; align-items: center; gap: 7px;
    margin-bottom: 8px;
}
.ml-card-detail:last-of-type { margin-bottom: 0; }
.ml-card-divider { height: 1px; background: var(--ml-border); margin: 16px 0; }
.ml-card-actions { display: flex; gap: 8px; align-items: center; }

/* ---------- Section Label ---------- */
.ml-section-label {
    font-size: 11px; font-weight: 700; color: var(--ml-text3);
    text-transform: uppercase; letter-spacing: 1px; margin-bottom: 16px;
}

/* ---------- Table ---------- */
.ml-table-wrap {
    border-radius: 18px; overflow: hidden;
    border: 1px solid var(--ml-border);
    background: var(--ml-glass); margin-bottom: 28px;
}
.ml-table-wrap table { width: 100%; border-collapse: collapse; }
.ml-table-wrap thead { background: rgba(0,0,0,.35); }
.ml-table-wrap th {
    padding: 16px 20px; font-size: 11px; font-weight: 700;
    color: var(--ml-text2); text-transform: uppercase;
    letter-spacing: .9px; text-align: left; white-space: nowrap;
}
.ml-table-wrap td {
    padding: 18px 20px; font-size: 14px; color: var(--ml-text1);
    border-top: 1px solid var(--ml-border); vertical-align: middle;
}
.ml-table-wrap tbody tr { transition: background .15s; }
.ml-table-wrap tbody tr:hover { background: var(--ml-glass2); }
.ml-td-name {
    display: flex; align-items: center; gap: 12px;
}
.ml-td-name-icon { font-size: 20px; }
.ml-td-name-text { font-weight: 700; color: var(--ml-text1); font-size: 14px; }
.ml-td-muted  { color: var(--ml-text2); font-size: 13px; }
.ml-td-mono   { font-family: var(--ml-mono); font-size: 13px; font-weight: 700; }
.ml-td-actions { display: flex; gap: 8px; align-items: center; }

/* ---------- Refill Bar ---------- */
.ml-refill-bar {
    display: flex; align-items: center; gap: 20px; flex-wrap: wrap;
    background: rgba(0,0,0,.2); border: 1px solid var(--ml-border);
    border-radius: 14px; padding: 18px 22px;
}
.ml-refill-info { font-size: 13px; color: var(--ml-text2); }
.ml-refill-info strong { color: var(--ml-text1); font-weight: 600; }
.ml-refill-spacer { flex: 1; }

/* ---------- Divider ---------- */
.ml-divider { height: 1px; background: var(--ml-border); margin: 28px 0; }

/* ---------- Empty State ---------- */
.ml-empty {
    text-align: center; padding: 90px 30px;
    background: var(--ml-glass); border-radius: 18px;
    border: 1px solid var(--ml-border);
}
.ml-empty-icon  { font-size: 56px; margin-bottom: 20px; }
.ml-empty-title { font-size: 22px; font-weight: 700; color: var(--ml-text1); margin-bottom: 10px; }
.ml-empty-sub   { font-size: 15px; color: var(--ml-text2); margin-bottom: 30px; }

/* ---------- Responsive ---------- */
@media (max-width: 768px) {
    .ml-header { flex-direction: column; align-items: flex-start; }
    .ml-grid { grid-template-columns: 1fr; }
    .ml-page-title { font-size: 22px; }
}
@media (max-width: 480px) {
    .ml-table-wrap { overflow-x: auto; }
}
</style>

<div class="ml-module">

    <?php if (!empty($flash)): ?>
        <div class="ml-flash">✅ <?= htmlspecialchars($flash) ?></div>
    <?php endif; ?>

    <!-- Page Header -->
    <div class="ml-header">
        <div class="ml-header-left">
            <div class="ml-page-icon">💊</div>
            <div>
                <div class="ml-page-title">Medication Management</div>
                <div class="ml-page-sub">Track and manage your prescriptions and supplements</div>
                <?php if (!empty($meds)): ?>
                    <div class="ml-count-pill">💊 <?= count($meds) ?> medication<?= count($meds) !== 1 ? 's' : '' ?> tracked</div>
                <?php endif; ?>
            </div>
        </div>
        <a href="index.php?page=medication-create" class="ml-btn ml-btn-primary">➕ Add Medication</a>
    </div>

    <?php if (empty($meds)): ?>
        <div class="ml-empty">
            <div class="ml-empty-icon">💊</div>
            <div class="ml-empty-title">No medications tracked</div>
            <div class="ml-empty-sub">Add your first medication to start tracking.</div>
            <a href="index.php?page=medication-create" class="ml-btn ml-btn-primary">Add Medication</a>
        </div>

    <?php else: ?>

        <!-- Card Grid View -->
        <div class="ml-grid">
            <?php foreach ($meds as $med): ?>
                <?php
                $badgeCls = match($med['status']) {
                    'Active'   => 'ml-badge-active',
                    'Paused'   => 'ml-badge-paused',
                    default    => 'ml-badge-inactive',
                };
                ?>
                <div class="ml-card">
                    <div class="ml-card-top">
                        <div class="ml-card-icon"><?= $med['icon'] ?></div>
                        <span class="ml-badge <?= $badgeCls ?>">
                            <span class="ml-badge-dot"></span><?= htmlspecialchars($med['status']) ?>
                        </span>
                    </div>
                    <div class="ml-card-name"><?= htmlspecialchars($med['name']) ?></div>
                    <div class="ml-card-dosage"><?= htmlspecialchars($med['dosage']) ?></div>
                    <div class="ml-card-detail">🕐 <?= htmlspecialchars($med['schedule']) ?></div>
                    <?php if (!empty($med['prescriber'])): ?>
                        <div class="ml-card-detail">👨‍⚕️ <?= htmlspecialchars($med['prescriber']) ?></div>
                    <?php endif; ?>
                    <div class="ml-card-divider"></div>
                    <div class="ml-card-actions">
                        <a href="index.php?page=medication-edit&id=<?= $med['id'] ?>" class="ml-btn ml-btn-edit">✏️ Edit</a>
                        <a href="index.php?page=medication-delete&id=<?= $med['id'] ?>" class="ml-btn ml-btn-del"
                           data-confirm="Remove <?= htmlspecialchars($med['name']) ?> from your medications?">🗑 Delete</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Table View -->
        <div class="ml-section-label">Full Details Table</div>
        <div class="ml-table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Medication</th>
                        <th>Type</th>
                        <th>Dosage</th>
                        <th>Schedule</th>
                        <th>Start Date</th>
                        <th>Prescriber</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($meds as $med): ?>
                        <?php
                        $badgeCls = match($med['status']) {
                            'Active'   => 'ml-badge-active',
                            'Paused'   => 'ml-badge-paused',
                            default    => 'ml-badge-inactive',
                        };
                        ?>
                        <tr>
                            <td>
                                <div class="ml-td-name">
                                    <span class="ml-td-name-icon"><?= $med['icon'] ?></span>
                                    <span class="ml-td-name-text"><?= htmlspecialchars($med['name']) ?></span>
                                </div>
                            </td>
                            <td class="ml-td-muted"><?= htmlspecialchars($med['type']) ?></td>
                            <td class="ml-td-mono"><?= htmlspecialchars($med['dosage']) ?></td>
                            <td class="ml-td-muted"><?= htmlspecialchars($med['schedule']) ?></td>
                            <td class="ml-td-muted"><?= date('M d, Y', strtotime($med['start_date'])) ?></td>
                            <td class="ml-td-muted"><?= htmlspecialchars($med['prescriber'] ?: '—') ?></td>
                            <td>
                                <span class="ml-badge <?= $badgeCls ?>">
                                    <span class="ml-badge-dot"></span><?= htmlspecialchars($med['status']) ?>
                                </span>
                            </td>
                            <td>
                                <div class="ml-td-actions">
                                    <a href="index.php?page=medication-edit&id=<?= $med['id'] ?>" class="ml-btn ml-btn-edit">✏️ Edit</a>
                                    <a href="index.php?page=medication-delete&id=<?= $med['id'] ?>" class="ml-btn ml-btn-del"
                                       data-confirm="Remove <?= htmlspecialchars($med['name']) ?>?">🗑 Delete</a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Refill Bar -->
        <div class="ml-refill-bar">
            <div class="ml-refill-info">✅ Next refill: <strong>April 25, 2026</strong></div>
            <div class="ml-refill-info">🕐 <strong>7 days</strong> remaining</div>
            <div class="ml-refill-spacer"></div>
            <a href="index.php?page=medication-create" class="ml-btn ml-btn-ghost">+ Add Refill</a>
        </div>

    <?php endif; ?>

</div><!-- /.ml-module -->

<?php require_once APP_PATH . '/views/shared/footer.php'; ?>