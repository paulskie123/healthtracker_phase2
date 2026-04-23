<?php
$pageTitle = 'Medications';
$activePage = 'medication';
require_once APP_PATH . '/views/shared/header.php';
?>

<?php if (!empty($flash)): ?>
    <div class="alert alert-success" data-auto-dismiss>✅ <?= htmlspecialchars($flash) ?></div>
<?php endif; ?>

<div class="card">
    <div class="card-header">
        <div class="card-title">
            <div class="card-icon orange">💊</div>
            Medication Management
            <span class="record-count">— <span><?= count($meds) ?></span> total</span>
        </div>
        <a href="index.php?page=medication-create" class="btn-primary">➕ Add Medication</a>
    </div>

    <?php if (empty($meds)): ?>
        <div class="empty-state">
            <div class="empty-icon">💊</div>
            <div class="empty-title">No medications tracked</div>
            <div class="empty-sub">Add your first medication to start tracking.</div>
            <a href="index.php?page=medication-create" class="btn-primary">Add Medication</a>
        </div>
    <?php else: ?>

        <!-- Card Grid View -->
        <div class="med-grid" style="margin-bottom:24px;">
            <?php foreach ($meds as $med): ?>
                <div class="med-card">
                    <div class="med-status">
                        <span class="status-badge <?= $med['status'] === 'Active' ? 'status-active' : 'status-inactive' ?>">
                            <?= htmlspecialchars($med['status']) ?>
                        </span>
                    </div>
                    <div class="med-icon-wrap"><?= $med['icon'] ?></div>
                    <div class="med-info">
                        <div class="med-name"><?= htmlspecialchars($med['name']) ?></div>
                        <div class="med-dosage"><?= htmlspecialchars($med['dosage']) ?></div>
                        <div class="med-schedule">🕐 <?= htmlspecialchars($med['schedule']) ?></div>
                        <?php if (!empty($med['prescriber'])): ?>
                            <div style="font-size:11.5px;color:var(--text-muted);margin-top:4px;">👨‍⚕️ <?= htmlspecialchars($med['prescriber']) ?></div>
                        <?php endif; ?>
                        <div class="med-actions">
                            <a href="index.php?page=medication-edit&id=<?= $med['id'] ?>" class="btn-edit btn-sm">✏️ Edit</a>
                            <a href="index.php?page=medication-delete&id=<?= $med['id'] ?>" class="btn-danger btn-sm"
                               data-confirm="Remove <?= htmlspecialchars($med['name']) ?> from your medications?">🗑</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Table View -->
        <div class="divider"></div>
        <div style="font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:0.8px;color:var(--text-muted);margin-bottom:14px;">Full Details Table</div>
        <div class="table-wrap">
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
                        <tr>
                            <td>
                                <div style="display:flex;align-items:center;gap:9px;">
                                    <span style="font-size:18px;"><?= $med['icon'] ?></span>
                                    <span style="font-weight:600;color:var(--text-primary);"><?= htmlspecialchars($med['name']) ?></span>
                                </div>
                            </td>
                            <td class="td-muted"><?= htmlspecialchars($med['type']) ?></td>
                            <td class="td-mono"><?= htmlspecialchars($med['dosage']) ?></td>
                            <td class="td-muted"><?= htmlspecialchars($med['schedule']) ?></td>
                            <td class="td-muted"><?= date('M d, Y', strtotime($med['start_date'])) ?></td>
                            <td class="td-muted"><?= htmlspecialchars($med['prescriber'] ?: '—') ?></td>
                            <td><span class="status-badge <?= $med['status'] === 'Active' ? 'status-active' : 'status-inactive' ?>"><?= htmlspecialchars($med['status']) ?></span></td>
                            <td>
                                <div class="td-actions">
                                    <a href="index.php?page=medication-edit&id=<?= $med['id'] ?>" class="btn-edit btn-sm">✏️ Edit</a>
                                    <a href="index.php?page=medication-delete&id=<?= $med['id'] ?>" class="btn-danger btn-sm"
                                       data-confirm="Remove <?= htmlspecialchars($med['name']) ?>?">🗑 Delete</a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="divider"></div>
        <div class="refill-bar">
            <div class="refill-info">✅ <span>Next refill: <strong>April 25, 2026</strong></span></div>
            <div class="refill-info">🕐 <span><strong>7 days</strong> remaining</span></div>
            <a href="index.php?page=medication-create" class="btn-secondary btn-sm">+ Add Refill</a>
        </div>

    <?php endif; ?>
</div>

<?php require_once APP_PATH . '/views/shared/footer.php'; ?>
