<?php
$isEdit     = $record !== null;
$pageTitle  = $isEdit ? 'Edit Health Record' : 'Add Health Record';
$activePage = 'health-records';
require_once APP_PATH . '/views/shared/header.php';
$o = $old ?: $record ?: [];
?>

<a href="index.php?page=health-records" class="page-back">← Back to Health Records</a>

<div class="card">
    <div class="card-header">
        <div class="card-title">
            <div class="card-icon <?= $isEdit ? 'blue' : '' ?>"><?= $isEdit ? '✏️' : '➕' ?></div>
            <?= $isEdit ? 'Edit Health Record' : 'Add New Health Record' ?>
        </div>
    </div>

    <?php if (!empty($errors)): ?>
        <div class="errors-box">
            <ul><?php foreach ($errors as $e): ?><li><?= htmlspecialchars($e) ?></li><?php endforeach; ?></ul>
        </div>
    <?php endif; ?>

    <form method="POST" action="index.php?page=<?= $isEdit ? 'health-records-update' : 'health-records-store' ?>">
        <?php if ($isEdit): ?>
            <input type="hidden" name="id" value="<?= $id ?>">
        <?php endif; ?>

        <div class="form-grid">
            <div class="form-group full">
                <label class="form-label">Date <span class="req">*</span></label>
                <input type="date" name="date" class="form-input"
                       value="<?= htmlspecialchars($o['date'] ?? date('Y-m-d')) ?>" required>
            </div>

            <div class="form-group">
                <label class="form-label">Systolic BP (mmHg) <span class="req">*</span></label>
                <input type="number" name="systolic_bp" class="form-input" placeholder="e.g. 120"
                       min="60" max="250" value="<?= htmlspecialchars($o['systolic_bp'] ?? '') ?>" required>
                <span class="form-hint">Normal: below 120 mmHg</span>
            </div>

            <div class="form-group">
                <label class="form-label">Diastolic BP (mmHg) <span class="req">*</span></label>
                <input type="number" name="diastolic_bp" class="form-input" placeholder="e.g. 80"
                       min="40" max="150" value="<?= htmlspecialchars($o['diastolic_bp'] ?? '') ?>" required>
                <span class="form-hint">Normal: below 80 mmHg</span>
            </div>

            <div class="form-group">
                <label class="form-label">Heart Rate (BPM) <span class="req">*</span></label>
                <input type="number" name="heart_rate" class="form-input" placeholder="e.g. 72"
                       min="30" max="220" value="<?= htmlspecialchars($o['heart_rate'] ?? '') ?>" required>
                <span class="form-hint">Normal resting: 60–100 bpm</span>
            </div>

            <div class="form-group">
                <label class="form-label">Weight (kg) <span class="req">*</span></label>
                <input type="number" name="weight" class="form-input" placeholder="e.g. 74.5"
                       step="0.1" min="10" max="300" value="<?= htmlspecialchars($o['weight'] ?? '') ?>" required>
            </div>

            <div class="form-group full">
                <label class="form-label">Blood Sugar (mg/dL) <span class="req">*</span></label>
                <input type="number" name="blood_sugar" class="form-input" placeholder="e.g. 95"
                       step="0.1" min="40" max="600" value="<?= htmlspecialchars($o['blood_sugar'] ?? '') ?>" required>
                <span class="form-hint">Fasting normal: 70–99 mg/dL</span>
            </div>

            <div class="form-group full">
                <label class="form-label">Notes</label>
                <textarea name="notes" class="form-textarea" placeholder="Any additional notes, symptoms, or observations..."><?= htmlspecialchars($o['notes'] ?? '') ?></textarea>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-primary">
                    <?= $isEdit ? '💾 Update Record' : '✅ Save Record' ?>
                </button>
                <a href="index.php?page=health-records" class="btn-secondary">Cancel</a>
            </div>
        </div>
    </form>
</div>

<?php require_once APP_PATH . '/views/shared/footer.php'; ?>
