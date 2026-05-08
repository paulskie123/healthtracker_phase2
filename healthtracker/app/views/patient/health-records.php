<?php
$pageTitle = 'Health Records';
$activePage = 'health-records';
require_once APP_PATH . '/views/shared/header.php';
?>

<?php if (!empty($flash)): ?>
    <div class="alert alert-success" data-auto-dismiss>✅ <?= htmlspecialchars($flash) ?></div>
<?php endif; ?>

<div class="card">
    <div class="card-header">
        <div class="card-title">
            <div class="card-icon">📋</div>
            Health Records Management
            <span class="record-count">— <span><?= count($records) ?></span> total</span>
        </div>
        <a href="index.php?page=health-records-create" class="btn-primary">
            ➕ Add New Record
        </a>
    </div>

    <?php if (empty($records)): ?>
        <div class="empty-state">
            <div class="empty-icon">📋</div>
            <div class="empty-title">No health records yet</div>
            <div class="empty-sub">Start tracking your vitals by adding your first record.</div>
            <a href="index.php?page=health-records-create" class="btn-primary">Add First Record</a>
        </div>
    <?php else: ?>
        <div class="table-wrap">
            <table>
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
                        if ($sys >= 140 || $dia >= 90)       { $bpLabel = 'High';     $bpClass = 'status-cancelled'; }
                        elseif ($sys >= 130 || $dia >= 80)   { $bpLabel = 'Elevated'; $bpClass = 'status-badge' ; }
                        else                                  { $bpLabel = 'Normal';   $bpClass = 'status-completed'; }
                        ?>
                        <tr>
                            <td class="td-muted"><?= $i + 1 ?></td>
                            <td>
                                <span style="font-weight:600;color:var(--text-primary);"><?= date('M d, Y', strtotime($r['date'])) ?></span>
                            </td>
                            <td class="td-mono"><?= $r['systolic_bp'] ?>/<?= $r['diastolic_bp'] ?> <span class="td-muted" style="font-family:inherit;font-size:11px;">mmHg</span></td>
                            <td class="td-mono"><?= $r['heart_rate'] ?> <span class="td-muted" style="font-family:inherit;font-size:11px;">bpm</span></td>
                            <td class="td-mono"><?= $r['weight'] ?> <span class="td-muted" style="font-family:inherit;font-size:11px;">kg</span></td>
                            <td class="td-mono"><?= $r['blood_sugar'] ?> <span class="td-muted" style="font-family:inherit;font-size:11px;">mg/dL</span></td>
                            <td><span class="status-badge <?= $bpClass ?>"><?= $bpLabel ?></span></td>
                            <td>
                                <div class="td-actions">
                                    <a href="index.php?page=health-records-view&id=<?= $r['id'] ?>" class="btn-view btn-sm">👁 View</a>
                                    <a href="index.php?page=health-records-edit&id=<?= $r['id'] ?>" class="btn-edit btn-sm">✏️ Edit</a>
                                    <a href="index.php?page=health-records-delete&id=<?= $r['id'] ?>" class="btn-danger btn-sm"
                                       data-confirm="Delete this health record? This cannot be undone.">🗑 Delete</a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<?php require_once APP_PATH . '/views/shared/footer.php'; ?>
