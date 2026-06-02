<?php
$isEdit    = $med !== null;
$pageTitle = $isEdit ? 'Edit Medication' : 'Add Medication';
$activePage = 'medication';
require_once APP_PATH . '/views/shared/header.php';
$o = $old ?: $med ?: [];
?>

<style>
/* ============================================================
   MEDICATION FORM — Add & Edit  |  Premium HealthSaaS
   Enhanced: Spacing · Typography · Visual Hierarchy · UX
   ============================================================ */

@import url('https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;1,9..40,300&family=Space+Mono:wght@400;700&display=swap');

:root {
    --mf-orange:      #f97316;
    --mf-orange-dim:  rgba(249,115,22,0.12);
    --mf-orange-glow: rgba(249,115,22,0.28);
    --mf-teal:        #00d4aa;
    --mf-teal-dim:    rgba(0,212,170,0.12);
    --mf-blue:        #3b82f6;
    --mf-blue-dim:    rgba(59,130,246,0.12);
    --mf-red:         #ef4444;
    --mf-red-dim:     rgba(239,68,68,0.12);
    --mf-glass:       rgba(255,255,255,0.04);
    --mf-glass2:      rgba(255,255,255,0.07);
    --mf-border:      rgba(255,255,255,0.08);
    --mf-border2:     rgba(255,255,255,0.14);
    --mf-text1:       #e8f4f0;
    --mf-text2:       #8fa8b8;
    --mf-text3:       #3d5060;
    --mf-font:        'DM Sans', sans-serif;
    --mf-mono:        'Space Mono', monospace;
}

.mf-module {
    font-family: var(--mf-font);
    color: var(--mf-text1);
    max-width: 900px;
}
@keyframes mfFadeUp { from{opacity:0;transform:translateY(14px)} to{opacity:1;transform:translateY(0)} }
.mf-module { animation: mfFadeUp .35s ease; }

/* ---------- Back Link ---------- */
.mf-back {
    display: inline-flex; align-items: center; gap: 8px;
    font-size: 13px; color: var(--mf-text2);
    text-decoration: none; margin-bottom: 28px;
    transition: color .2s; font-weight: 500;
}
.mf-back:hover { color: var(--mf-orange); }

/* ---------- Page Header ---------- */
.mf-header {
    display: flex; align-items: center; gap: 20px;
    margin-bottom: 36px;
}
.mf-page-icon {
    width: 62px; height: 62px; border-radius: 18px;
    display: flex; align-items: center; justify-content: center;
    font-size: 30px; flex-shrink: 0;
}
.mf-icon-add  { background: var(--mf-orange-dim); border: 1px solid rgba(249,115,22,.28); }
.mf-icon-edit { background: var(--mf-blue-dim);   border: 1px solid rgba(59,130,246,.28); }
.mf-breadcrumb {
    display: flex; align-items: center; gap: 7px;
    font-size: 12px; color: var(--mf-text3); margin-bottom: 6px;
}
.mf-crumb-link { color: var(--mf-text2); text-decoration: none; font-weight: 500; }
.mf-crumb-link:hover { color: var(--mf-orange); }
.mf-page-title {
    font-size: 26px; font-weight: 700;
    color: var(--mf-text1); letter-spacing: -0.3px;
}
.mf-page-sub { font-size: 14px; color: var(--mf-text2); margin-top: 5px; }

/* ---------- Error Box ---------- */
.mf-errors {
    background: var(--mf-red-dim);
    border: 1px solid rgba(239,68,68,.3);
    border-radius: 14px; padding: 18px 22px; margin-bottom: 28px;
}
.mf-errors ul { list-style: none; margin: 0; padding: 0; }
.mf-errors li { font-size: 14px; color: var(--mf-red); padding: 5px 0; }
.mf-errors li::before { content: '⚠ '; }

/* ---------- Form Sections ---------- */
.mf-section {
    background: var(--mf-glass);
    border: 1px solid var(--mf-border);
    border-radius: 18px; padding: 30px;
    margin-bottom: 20px;
    transition: border-color .2s;
}
.mf-section:focus-within { border-color: rgba(249,115,22,.22); }
.mf-section-title {
    display: flex; align-items: center; gap: 12px;
    font-size: 12px; font-weight: 700; color: var(--mf-text2);
    text-transform: uppercase; letter-spacing: .8px; margin-bottom: 26px;
}
.mf-section-title::after {
    content: ''; flex: 1; height: 1px; background: var(--mf-border);
}
.mf-section-icon {
    width: 30px; height: 30px; border-radius: 8px;
    display: flex; align-items: center; justify-content: center; font-size: 15px;
}
.mf-si-orange { background: var(--mf-orange-dim); }
.mf-si-blue   { background: var(--mf-blue-dim); }
.mf-si-teal   { background: var(--mf-teal-dim); }
.mf-si-glass  { background: var(--mf-glass2); }

/* ---------- Form Grid ---------- */
.mf-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 22px; }
.mf-group { display: flex; flex-direction: column; gap: 9px; }
.mf-group.full { grid-column: 1 / -1; }

/* ---------- Labels ---------- */
.mf-label {
    font-size: 12px; font-weight: 700; color: var(--mf-text2);
    text-transform: uppercase; letter-spacing: .6px;
    display: flex; align-items: center; gap: 6px;
}
.mf-req  { color: var(--mf-orange); font-size: 14px; }
.mf-hint { font-size: 12px; color: var(--mf-text3); font-weight: 400;
           text-transform: none; letter-spacing: 0; }

/* ---------- Inputs & Selects ---------- */
.mf-input, .mf-select, .mf-textarea {
    width: 100%;
    background: rgba(0,0,0,.3);
    border: 1px solid var(--mf-border2);
    border-radius: 11px; padding: 14px 16px;
    font-family: var(--mf-font); font-size: 15px; color: var(--mf-text1);
    outline: none; transition: border-color .2s, box-shadow .2s;
    box-sizing: border-box;
}
.mf-input::placeholder { color: var(--mf-text3); }
.mf-input:focus, .mf-select:focus, .mf-textarea:focus {
    border-color: var(--mf-orange);
    box-shadow: 0 0 0 3px var(--mf-orange-dim);
}
.mf-select {
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath d='M1 1l5 5 5-5' stroke='%238fa8b8' stroke-width='1.5' fill='none' stroke-linecap='round'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 16px center;
    padding-right: 42px;
    cursor: pointer;
}
/* Style native select options for dark theme */
.mf-select option {
    background: #0f1c2e;
    color: var(--mf-text1);
    font-size: 15px;
    padding: 8px;
}
.mf-textarea {
    resize: vertical; min-height: 130px;
    line-height: 1.75; padding: 16px;
}
.mf-field-hint { font-size: 12px; color: var(--mf-text3); }

/* ---------- Buttons ---------- */
.mf-actions {
    display: flex; align-items: center;
    gap: 12px; margin-top: 10px;
}
.mf-btn {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 13px 28px; border-radius: 11px;
    font-family: var(--mf-font); font-size: 15px; font-weight: 600;
    cursor: pointer; border: none; transition: all .2s; text-decoration: none;
}
.mf-btn-primary {
    background: linear-gradient(135deg, #f97316, #ea6a0a);
    color: #fff;
}
.mf-btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 0 28px var(--mf-orange-glow);
}
.mf-btn-ghost {
    background: var(--mf-glass); color: var(--mf-text2);
    border: 1px solid var(--mf-border); text-decoration: none;
}
.mf-btn-ghost:hover { background: var(--mf-glass2); color: var(--mf-text1); }

/* ---------- Responsive ---------- */
@media (max-width: 640px) {
    .mf-grid { grid-template-columns: 1fr; }
    .mf-group.full { grid-column: 1; }
    .mf-section { padding: 22px; }
    .mf-page-title { font-size: 22px; }
}
</style>

<div class="mf-module">

    <!-- Back Link -->
    <a href="index.php?page=medication" class="mf-back">← Back to Medications</a>

    <!-- Page Header -->
    <div class="mf-header">
        <div class="mf-page-icon <?= $isEdit ? 'mf-icon-edit' : 'mf-icon-add' ?>">
            <?= $isEdit ? '✏️' : '💊' ?>
        </div>
        <div>
            <div class="mf-breadcrumb">
                <a href="index.php?page=medication" class="mf-crumb-link">Medications</a>
                <span>›</span>
                <span><?= $isEdit ? 'Edit Medication' : 'Add New Medication' ?></span>
            </div>
            <div class="mf-page-title"><?= $isEdit ? 'Edit Medication' : 'Add New Medication' ?></div>
            <div class="mf-page-sub">
                <?= $isEdit
                    ? 'Update the details for this medication'
                    : 'Enter details for your new prescription or supplement' ?>
            </div>
        </div>
    </div>

    <!-- Error Box -->
    <?php if (!empty($errors)): ?>
        <div class="mf-errors">
            <ul><?php foreach ($errors as $e): ?>
                <li><?= htmlspecialchars($e) ?></li>
            <?php endforeach; ?></ul>
        </div>
    <?php endif; ?>

    <!-- FORM (action/method/hidden id preserved exactly) -->
    <form method="POST" action="index.php?page=<?= $isEdit ? 'medication-update' : 'medication-store' ?>">
        <?php if ($isEdit): ?>
            <input type="hidden" name="id" value="<?= $id ?>">
        <?php endif; ?>

        <!-- Section 1: Basic Information -->
        <div class="mf-section">
            <div class="mf-section-title">
                <div class="mf-section-icon mf-si-orange">💊</div>
                Basic Information
            </div>
            <div class="mf-grid">
                <div class="mf-group">
                    <label class="mf-label">Medication Name <span class="mf-req">*</span></label>
                    <input type="text" name="name" class="mf-input" placeholder="e.g. Lisinopril"
                           value="<?= htmlspecialchars($o['name'] ?? '') ?>" required>
                </div>
                <div class="mf-group">
                    <label class="mf-label">Type <span class="mf-req">*</span></label>
                    <select name="type" class="mf-select" required>
                        <?php foreach (['Tablet','Capsule','Injection','Liquid','Inhaler','Patch','Other'] as $t): ?>
                            <option value="<?= $t ?>" <?= ($o['type'] ?? '') === $t ? 'selected' : '' ?>><?= $t ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mf-group">
                    <label class="mf-label">Dosage <span class="mf-req">*</span></label>
                    <input type="text" name="dosage" class="mf-input" placeholder="e.g. 10mg"
                           value="<?= htmlspecialchars($o['dosage'] ?? '') ?>" required>
                </div>
                <div class="mf-group">
                    <label class="mf-label">Schedule <span class="mf-req">*</span></label>
                    <select name="schedule" class="mf-select" required>
                        <?php foreach (['Morning','Evening','Night','Daily','Before meals','After meals','As needed','Twice daily','Three times daily'] as $s): ?>
                            <option value="<?= $s ?>" <?= ($o['schedule'] ?? '') === $s ? 'selected' : '' ?>><?= $s ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>

        <!-- Section 2: Dates & Prescriber -->
        <div class="mf-section">
            <div class="mf-section-title">
                <div class="mf-section-icon mf-si-blue">📅</div>
                Dates &amp; Prescriber
            </div>
            <div class="mf-grid">
                <div class="mf-group">
                    <label class="mf-label">Start Date</label>
                    <input type="date" name="start_date" class="mf-input"
                           value="<?= htmlspecialchars($o['start_date'] ?? date('Y-m-d')) ?>">
                </div>
                <div class="mf-group">
                    <label class="mf-label">End Date <span class="mf-hint">(leave blank if ongoing)</span></label>
                    <input type="date" name="end_date" class="mf-input"
                           value="<?= htmlspecialchars($o['end_date'] ?? '') ?>">
                </div>
                <div class="mf-group full">
                    <label class="mf-label">Prescribing Doctor</label>
                    <input type="text" name="prescriber" class="mf-input" placeholder="e.g. Dr. Sarah Chen"
                           value="<?= htmlspecialchars($o['prescriber'] ?? '') ?>">
                </div>
            </div>
        </div>

        <!-- Section 3: Status & Icon -->
        <div class="mf-section">
            <div class="mf-section-title">
                <div class="mf-section-icon mf-si-teal">⚙️</div>
                Status &amp; Appearance
            </div>
            <div class="mf-grid">
                <div class="mf-group">
                    <label class="mf-label">Status</label>
                    <select name="status" class="mf-select">
                        <option value="Active"   <?= ($o['status'] ?? 'Active') === 'Active'   ? 'selected' : '' ?>>Active</option>
                        <option value="Inactive" <?= ($o['status'] ?? '') === 'Inactive' ? 'selected' : '' ?>>Inactive</option>
                        <option value="Paused"   <?= ($o['status'] ?? '') === 'Paused'   ? 'selected' : '' ?>>Paused</option>
                    </select>
                </div>
                <div class="mf-group">
                    <label class="mf-label">Icon</label>
                    <select name="icon" class="mf-select">
                        <option value="💊" <?= ($o['icon'] ?? '💊') === '💊' ? 'selected' : '' ?>>💊 Pill / Tablet</option>
                        <option value="💉" <?= ($o['icon'] ?? '') === '💉' ? 'selected' : '' ?>>💉 Injection</option>
                        <option value="🩺" <?= ($o['icon'] ?? '') === '🩺' ? 'selected' : '' ?>>🩺 Medical</option>
                        <option value="🧴" <?= ($o['icon'] ?? '') === '🧴' ? 'selected' : '' ?>>🧴 Liquid</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Section 4: Notes -->
        <div class="mf-section">
            <div class="mf-section-title">
                <div class="mf-section-icon mf-si-glass">📝</div>
                Notes &amp; Instructions
            </div>
            <div class="mf-group">
                <label class="mf-label">Additional Notes</label>
                <textarea name="notes" class="mf-textarea"
                          placeholder="e.g. Take with food, monitor blood sugar, avoid grapefruit..."
                ><?= htmlspecialchars($o['notes'] ?? '') ?></textarea>
                <span class="mf-field-hint">Include any special instructions, side effects to watch for, or dietary considerations.</span>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="mf-actions">
            <button type="submit" class="mf-btn mf-btn-primary">
                <?= $isEdit ? '💾 Update Medication' : '✅ Save Medication' ?>
            </button>
            <a href="index.php?page=medication" class="mf-btn mf-btn-ghost">Cancel</a>
        </div>

    </form>

</div><!-- /.mf-module -->

<?php require_once APP_PATH . '/views/shared/footer.php'; ?>