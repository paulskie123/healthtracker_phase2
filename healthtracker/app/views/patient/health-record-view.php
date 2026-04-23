<?php
$pageTitle = 'Record Detail';
$activePage = 'health-records';
require_once APP_PATH . '/views/shared/header.php';

$sys = $record['systolic_bp'];
$dia = $record['diastolic_bp'];
if ($sys >= 140 || $dia >= 90)     { $bpLabel = 'High Blood Pressure';  $bpClass = 'badge-danger'; }
elseif ($sys >= 130 || $dia >= 80) { $bpLabel = 'Elevated';             $bpClass = 'badge-warning'; }
else                               { $bpLabel = 'Normal';               $bpClass = 'badge-normal'; }
?>

<a href="index.php?page=health-records" class="page-back">← Back to Health Records</a>

<div class="card">
    <div class="card-header">
        <div>
            <div class="card-title">
                <div class="card-icon">📋</div>
                Record for <?= date('F j, Y', strtotime($record['date'])) ?>
            </div>
            <div style="margin-top:6px;">
                <span class="stat-badge <?= $bpClass ?>"><span class="badge-dot"></span> <?= $bpLabel ?></span>
            </div>
        </div>
        <div style="display:flex;gap:10px;">
            <a href="index.php?page=health-records-edit&id=<?= $id ?>" class="btn-edit">✏️ Edit</a>
            <a href="index.php?page=health-records-delete&id=<?= $id ?>" class="btn-danger"
               data-confirm="Delete this record? This cannot be undone.">🗑 Delete</a>
        </div>
    </div>

    <div class="vitals-grid">
        <div class="vital-box">
            <div class="vital-label">Systolic BP</div>
            <div class="vital-value text-red"><?= $record['systolic_bp'] ?></div>
            <div class="vital-unit">mmHg</div>
        </div>
        <div class="vital-box">
            <div class="vital-label">Diastolic BP</div>
            <div class="vital-value text-blue"><?= $record['diastolic_bp'] ?></div>
            <div class="vital-unit">mmHg</div>
        </div>
        <div class="vital-box">
            <div class="vital-label">Heart Rate</div>
            <div class="vital-value text-orange"><?= $record['heart_rate'] ?></div>
            <div class="vital-unit">bpm</div>
        </div>
        <div class="vital-box">
            <div class="vital-label">Weight</div>
            <div class="vital-value text-teal"><?= $record['weight'] ?></div>
            <div class="vital-unit">kg</div>
        </div>
        <div class="vital-box">
            <div class="vital-label">Blood Sugar</div>
            <div class="vital-value text-purple"><?= $record['blood_sugar'] ?></div>
            <div class="vital-unit">mg/dL</div>
        </div>
        <div class="vital-box">
            <div class="vital-label">BP Combined</div>
            <div class="vital-value" style="font-size:18px;color:var(--text-primary);"><?= $record['systolic_bp'] ?>/<?= $record['diastolic_bp'] ?></div>
            <div class="vital-unit">mmHg</div>
        </div>
    </div>

    <?php if (!empty($record['notes'])): ?>
        <div class="divider"></div>
        <div>
            <div style="font-size:11.5px;font-weight:700;text-transform:uppercase;letter-spacing:0.6px;color:var(--text-muted);margin-bottom:8px;">Notes</div>
            <p style="font-size:13.5px;color:var(--text-secondary);line-height:1.6;"><?= nl2br(htmlspecialchars($record['notes'])) ?></p>
        </div>
    <?php endif; ?>
</div>

<?php require_once APP_PATH . '/views/shared/footer.php'; ?>
