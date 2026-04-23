<?php
$isEdit    = $appointment !== null;
$pageTitle = $isEdit ? 'Edit Appointment' : 'Schedule Appointment';
$activePage = 'appointments';
require_once APP_PATH . '/views/shared/header.php';
$o = $old ?: $appointment ?: [];
?>

<a href="index.php?page=appointments" class="page-back">← Back to Appointments</a>

<div class="card">
    <div class="card-header">
        <div class="card-title">
            <div class="card-icon blue"><?= $isEdit ? '✏️' : '🗓️' ?></div>
            <?= $isEdit ? 'Edit Appointment' : 'Schedule New Appointment' ?>
        </div>
    </div>

    <?php if (!empty($errors)): ?>
        <div class="errors-box">
            <ul><?php foreach ($errors as $e): ?><li><?= htmlspecialchars($e) ?></li><?php endforeach; ?></ul>
        </div>
    <?php endif; ?>

    <form method="POST" action="index.php?page=<?= $isEdit ? 'appointments-update' : 'appointments-store' ?>">
        <?php if ($isEdit): ?>
            <input type="hidden" name="id" value="<?= $id ?>">
        <?php endif; ?>

        <div class="form-grid">
            <div class="form-group">
                <label class="form-label">Doctor's Name <span class="req">*</span></label>
                <input type="text" name="doctor" class="form-input" placeholder="e.g. Dr. Sarah Chen"
                       value="<?= htmlspecialchars($o['doctor'] ?? '') ?>" required>
            </div>

            <div class="form-group">
                <label class="form-label">Specialty <span class="req">*</span></label>
                <select name="specialty" class="form-select" required>
                    <option value="">— Select specialty —</option>
                    <?php foreach (['Internal Medicine','Cardiology','Endocrinology','Ophthalmology','Dermatology','Neurology','Orthopedics','Pulmonology','Nephrology','Gastroenterology','General Practice','Other'] as $s): ?>
                        <option value="<?= $s ?>" <?= ($o['specialty'] ?? '') === $s ? 'selected' : '' ?>><?= $s ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">Date <span class="req">*</span></label>
                <input type="date" name="date" class="form-input"
                       value="<?= htmlspecialchars($o['date'] ?? date('Y-m-d', strtotime('+1 day'))) ?>" required>
            </div>

            <div class="form-group">
                <label class="form-label">Time <span class="req">*</span></label>
                <input type="time" name="time" class="form-input"
                       value="<?= htmlspecialchars($o['time'] ?? '09:00') ?>" required>
            </div>

            <div class="form-group">
                <label class="form-label">Appointment Type</label>
                <select name="type" class="form-select">
                    <?php foreach (['Check-up','Follow-up','Consultation','Annual','Emergency','Lab Test','Procedure','Other'] as $t): ?>
                        <option value="<?= $t ?>" <?= ($o['type'] ?? 'Check-up') === $t ? 'selected' : '' ?>><?= $t ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="Scheduled" <?= ($o['status'] ?? 'Scheduled') === 'Scheduled' ? 'selected' : '' ?>>Scheduled</option>
                    <option value="Completed" <?= ($o['status'] ?? '') === 'Completed' ? 'selected' : '' ?>>Completed</option>
                    <option value="Cancelled" <?= ($o['status'] ?? '') === 'Cancelled' ? 'selected' : '' ?>>Cancelled</option>
                </select>
            </div>

            <div class="form-group full">
                <label class="form-label">Clinic / Hospital Location</label>
                <input type="text" name="location" class="form-input" placeholder="e.g. SF Medical Center, Room 301"
                       value="<?= htmlspecialchars($o['location'] ?? '') ?>">
            </div>

            <div class="form-group full">
                <label class="form-label">Notes / Preparation Instructions</label>
                <textarea name="notes" class="form-textarea" placeholder="e.g. Bring latest BP records, fasting required..."><?= htmlspecialchars($o['notes'] ?? '') ?></textarea>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-primary">
                    <?= $isEdit ? '💾 Update Appointment' : '✅ Schedule Appointment' ?>
                </button>
                <a href="index.php?page=appointments" class="btn-secondary">Cancel</a>
            </div>
        </div>
    </form>
</div>

<?php require_once APP_PATH . '/views/shared/footer.php'; ?>
