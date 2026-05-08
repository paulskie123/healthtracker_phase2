<?php
$isEdit    = $med !== null;
$pageTitle = $isEdit ? 'Edit Medication' : 'Add Medication';
$activePage = 'medication';
require_once APP_PATH . '/views/shared/header.php';
$o = $old ?: $med ?: [];
?>

<a href="index.php?page=medication" class="page-back">← Back to Medications</a>

<div class="card">
    <div class="card-header">
        <div class="card-title">
            <div class="card-icon orange"><?= $isEdit ? '✏️' : '💊' ?></div>
            <?= $isEdit ? 'Edit Medication' : 'Add New Medication' ?>
        </div>
    </div>

    <?php if (!empty($errors)): ?>
        <div class="errors-box">
            <ul><?php foreach ($errors as $e): ?><li><?= htmlspecialchars($e) ?></li><?php endforeach; ?></ul>
        </div>
    <?php endif; ?>

    <form method="POST" action="index.php?page=<?= $isEdit ? 'medication-update' : 'medication-store' ?>">
        <?php if ($isEdit): ?>
            <input type="hidden" name="id" value="<?= $id ?>">
        <?php endif; ?>

        <div class="form-grid">
            <div class="form-group">
                <label class="form-label">Medication Name <span class="req">*</span></label>
                <input type="text" name="name" class="form-input" placeholder="e.g. Lisinopril"
                       value="<?= htmlspecialchars($o['name'] ?? '') ?>" required>
            </div>

            <div class="form-group">
                <label class="form-label">Type <span class="req">*</span></label>
                <select name="type" class="form-select" required>
                    <?php foreach (['Tablet','Capsule','Injection','Liquid','Inhaler','Patch','Other'] as $t): ?>
                        <option value="<?= $t ?>" <?= ($o['type'] ?? '') === $t ? 'selected' : '' ?>><?= $t ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">Dosage <span class="req">*</span></label>
                <input type="text" name="dosage" class="form-input" placeholder="e.g. 10mg"
                       value="<?= htmlspecialchars($o['dosage'] ?? '') ?>" required>
            </div>

            <div class="form-group">
                <label class="form-label">Schedule <span class="req">*</span></label>
                <select name="schedule" class="form-select" required>
                    <?php foreach (['Morning','Evening','Night','Daily','Before meals','After meals','As needed','Twice daily','Three times daily'] as $s): ?>
                        <option value="<?= $s ?>" <?= ($o['schedule'] ?? '') === $s ? 'selected' : '' ?>><?= $s ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">Start Date</label>
                <input type="date" name="start_date" class="form-input"
                       value="<?= htmlspecialchars($o['start_date'] ?? date('Y-m-d')) ?>">
            </div>

            <div class="form-group">
                <label class="form-label">End Date <span class="form-hint">(leave blank if ongoing)</span></label>
                <input type="date" name="end_date" class="form-input"
                       value="<?= htmlspecialchars($o['end_date'] ?? '') ?>">
            </div>

            <div class="form-group">
                <label class="form-label">Prescribing Doctor</label>
                <input type="text" name="prescriber" class="form-input" placeholder="e.g. Dr. Sarah Chen"
                       value="<?= htmlspecialchars($o['prescriber'] ?? '') ?>">
            </div>

            <div class="form-group">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="Active"   <?= ($o['status'] ?? 'Active') === 'Active'   ? 'selected' : '' ?>>Active</option>
                    <option value="Inactive" <?= ($o['status'] ?? '') === 'Inactive' ? 'selected' : '' ?>>Inactive</option>
                    <option value="Paused"   <?= ($o['status'] ?? '') === 'Paused'   ? 'selected' : '' ?>>Paused</option>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">Icon</label>
                <select name="icon" class="form-select">
                    <option value="💊" <?= ($o['icon'] ?? '💊') === '💊' ? 'selected' : '' ?>>💊 Pill/Tablet</option>
                    <option value="💉" <?= ($o['icon'] ?? '') === '💉' ? 'selected' : '' ?>>💉 Injection</option>
                    <option value="🩺" <?= ($o['icon'] ?? '') === '🩺' ? 'selected' : '' ?>>🩺 Medical</option>
                    <option value="🧴" <?= ($o['icon'] ?? '') === '🧴' ? 'selected' : '' ?>>🧴 Liquid</option>
                </select>
            </div>

            <div class="form-group full">
                <label class="form-label">Notes / Instructions</label>
                <textarea name="notes" class="form-textarea" placeholder="e.g. Take with food, monitor blood sugar..."><?= htmlspecialchars($o['notes'] ?? '') ?></textarea>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-primary">
                    <?= $isEdit ? '💾 Update Medication' : '✅ Save Medication' ?>
                </button>
                <a href="index.php?page=medication" class="btn-secondary">Cancel</a>
            </div>
        </div>
    </form>
</div>

<?php require_once APP_PATH . '/views/shared/footer.php'; ?>
