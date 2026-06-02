<?php
$isEdit    = $record !== null;
$pageTitle = $isEdit ? 'Edit Health Record' : 'Add Health Record';
$activePage = 'health-records';
require_once APP_PATH . '/views/shared/header.php';
$o = $old ?: $record ?: [];
?>

<style>
/* ============================================================
   HEALTH RECORD FORM — Add & Edit  |  Premium HealthSaaS
   Enhanced: Spacing · Typography · Visual Hierarchy · UX
   ============================================================ */

@import url('https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;1,9..40,300&family=Space+Mono:wght@400;700&display=swap');

:root {
    --hf-bg:        #080e1a;
    --hf-glass:     rgba(255,255,255,0.04);
    --hf-glass2:    rgba(255,255,255,0.07);
    --hf-border:    rgba(255,255,255,0.08);
    --hf-border2:   rgba(255,255,255,0.14);
    --hf-teal:      #00d4aa;
    --hf-teal-dim:  rgba(0,212,170,0.12);
    --hf-teal-glow: rgba(0,212,170,0.25);
    --hf-blue:      #3b82f6;
    --hf-blue-dim:  rgba(59,130,246,0.12);
    --hf-red:       #ef4444;
    --hf-red-dim:   rgba(239,68,68,0.12);
    --hf-amber:     #f59e0b;
    --hf-purple:    #a78bfa;
    --hf-text1:     #e8f4f0;
    --hf-text2:     #8fa8b8;
    --hf-text3:     #3d5060;
    --hf-font:      'DM Sans', sans-serif;
    --hf-mono:      'Space Mono', monospace;
}

.hf-module {
    font-family: var(--hf-font);
    color: var(--hf-text1);
    max-width: 900px;
}
@keyframes hfFadeUp { from{opacity:0;transform:translateY(14px)} to{opacity:1;transform:translateY(0)} }
.hf-module { animation: hfFadeUp .35s ease; }

/* ---------- Back Link ---------- */
.hf-back {
    display: inline-flex; align-items: center; gap: 8px;
    font-size: 13px; color: var(--hf-text2);
    text-decoration: none; margin-bottom: 28px;
    transition: color .2s; font-weight: 500;
}
.hf-back:hover { color: var(--hf-teal); }

/* ---------- Page Header ---------- */
.hf-page-header {
    display: flex; align-items: flex-start;
    justify-content: space-between; gap: 20px;
    flex-wrap: wrap; margin-bottom: 36px;
}
.hf-header-left { display: flex; align-items: center; gap: 20px; }
.hf-page-icon {
    width: 62px; height: 62px; border-radius: 18px;
    display: flex; align-items: center; justify-content: center;
    font-size: 30px; flex-shrink: 0;
}
.hf-icon-add  { background: var(--hf-teal-dim); border: 1px solid rgba(0,212,170,.25); }
.hf-icon-edit { background: var(--hf-blue-dim); border: 1px solid rgba(59,130,246,.25); }
.hf-breadcrumb {
    display: flex; align-items: center; gap: 7px;
    font-size: 12px; color: var(--hf-text3); margin-bottom: 6px;
}
.hf-crumb-link { color: var(--hf-text2); text-decoration: none; font-weight: 500; }
.hf-crumb-link:hover { color: var(--hf-teal); }
.hf-page-title {
    font-size: 26px; font-weight: 700;
    color: var(--hf-text1); letter-spacing: -0.3px;
}
.hf-page-sub {
    font-size: 14px; color: var(--hf-text2);
    margin-top: 5px; font-weight: 400;
}

/* ---------- Error Box ---------- */
.hf-errors {
    background: var(--hf-red-dim);
    border: 1px solid rgba(239,68,68,.3);
    border-radius: 14px; padding: 18px 22px;
    margin-bottom: 28px;
}
.hf-errors ul { list-style: none; margin: 0; padding: 0; }
.hf-errors li { font-size: 14px; color: var(--hf-red); padding: 5px 0; }
.hf-errors li::before { content: '⚠ '; }

/* ---------- Form Sections ---------- */
.hf-section {
    background: var(--hf-glass);
    border: 1px solid var(--hf-border);
    border-radius: 18px; padding: 30px;
    margin-bottom: 20px;
    transition: border-color .2s;
}
.hf-section:focus-within { border-color: rgba(0,212,170,.22); }
.hf-section-title {
    display: flex; align-items: center; gap: 12px;
    font-size: 12px; font-weight: 700; color: var(--hf-text2);
    text-transform: uppercase; letter-spacing: .8px; margin-bottom: 26px;
}
.hf-section-title::after {
    content: ''; flex: 1; height: 1px; background: var(--hf-border);
}
.hf-section-icon {
    width: 30px; height: 30px; border-radius: 8px;
    display: flex; align-items: center; justify-content: center; font-size: 15px;
}
.hf-si-teal   { background: var(--hf-teal-dim); }
.hf-si-red    { background: var(--hf-red-dim); }
.hf-si-blue   { background: var(--hf-blue-dim); }
.hf-si-purple { background: rgba(167,139,250,.12); }
.hf-si-amber  { background: rgba(245,158,11,.12); }

/* ---------- Form Grid ---------- */
.hf-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 22px; }
.hf-group { display: flex; flex-direction: column; gap: 9px; }
.hf-group.full { grid-column: 1 / -1; }

/* ---------- Labels ---------- */
.hf-label {
    font-size: 12px; font-weight: 700; color: var(--hf-text2);
    text-transform: uppercase; letter-spacing: .6px;
    display: flex; align-items: center; gap: 6px;
}
.hf-req { color: var(--hf-teal); font-size: 14px; }

/* ---------- Inputs ---------- */
.hf-input-wrap { position: relative; }
.hf-input-icon {
    position: absolute; left: 15px; top: 50%;
    transform: translateY(-50%);
    font-size: 17px; color: var(--hf-text3); pointer-events: none;
}
.hf-input, .hf-textarea {
    width: 100%;
    background: rgba(0,0,0,.3);
    border: 1px solid var(--hf-border2);
    border-radius: 11px; padding: 14px 16px;
    font-family: var(--hf-font); font-size: 15px; color: var(--hf-text1);
    outline: none; transition: border-color .2s, box-shadow .2s;
    box-sizing: border-box;
}
.hf-input-wrap .hf-input { padding-left: 44px; }
.hf-input:focus, .hf-textarea:focus {
    border-color: var(--hf-teal);
    box-shadow: 0 0 0 3px var(--hf-teal-dim);
}
.hf-input.changed {
    border-color: rgba(59,130,246,.6);
    box-shadow: 0 0 0 3px var(--hf-blue-dim);
}
.hf-textarea {
    resize: vertical; min-height: 130px;
    line-height: 1.75; padding: 16px;
}
.hf-hint    { font-size: 12px; color: var(--hf-text3); }
.hf-char-count { font-size: 12px; color: var(--hf-text3); text-align: right; }

/* ---------- Original Values Panel (Edit only) ---------- */
.hf-orig-panel {
    background: rgba(59,130,246,.06);
    border: 1px solid rgba(59,130,246,.18);
    border-radius: 16px; padding: 22px; margin-bottom: 24px;
}
.hf-orig-label {
    font-size: 12px; font-weight: 700; color: var(--hf-blue);
    text-transform: uppercase; letter-spacing: .7px; margin-bottom: 18px;
}
.hf-orig-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
    gap: 12px;
}
.hf-orig-card {
    background: rgba(0,0,0,.25);
    border: 1px solid var(--hf-border);
    border-radius: 10px; padding: 14px; text-align: center;
}
.hf-orig-metric {
    font-size: 10px; color: var(--hf-text3);
    text-transform: uppercase; letter-spacing: .6px;
}
.hf-orig-val {
    font-family: var(--hf-mono); font-size: 17px;
    color: var(--hf-text2); margin-top: 6px;
}
.hf-orig-unit { font-size: 10px; color: var(--hf-text3); }

/* ---------- Buttons ---------- */
.hf-actions {
    display: flex; align-items: center;
    gap: 12px; margin-top: 10px;
}
.hf-btn {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 13px 28px; border-radius: 11px;
    font-family: var(--hf-font); font-size: 15px; font-weight: 600;
    cursor: pointer; border: none; transition: all .2s; text-decoration: none;
}
.hf-btn-teal {
    background: linear-gradient(135deg, #00c49a, #009f7f);
    color: #001a12;
}
.hf-btn-teal:hover {
    transform: translateY(-2px);
    box-shadow: 0 0 28px var(--hf-teal-glow);
}
.hf-btn-ghost {
    background: var(--hf-glass); color: var(--hf-text2);
    border: 1px solid var(--hf-border); text-decoration: none;
}
.hf-btn-ghost:hover { background: var(--hf-glass2); color: var(--hf-text1); }

/* ---------- Responsive ---------- */
@media (max-width: 640px) {
    .hf-grid { grid-template-columns: 1fr; }
    .hf-group.full { grid-column: 1; }
    .hf-section { padding: 22px; }
    .hf-page-title { font-size: 22px; }
}
</style>

<div class="hf-module">

    <!-- Back Link -->
    <a href="index.php?page=health-records" class="hf-back">← Back to Health Records</a>

    <!-- Page Header -->
    <div class="hf-page-header">
        <div class="hf-header-left">
            <div class="hf-page-icon <?= $isEdit ? 'hf-icon-edit' : 'hf-icon-add' ?>">
                <?= $isEdit ? '✏️' : '➕' ?>
            </div>
            <div>
                <div class="hf-breadcrumb">
                    <a href="index.php?page=health-records" class="hf-crumb-link">Health Records</a>
                    <span>›</span>
                    <span><?= $isEdit ? 'Edit Record' : 'Add New Record' ?></span>
                </div>
                <div class="hf-page-title"><?= $isEdit ? 'Edit Health Record' : 'Add New Health Record' ?></div>
                <div class="hf-page-sub">
                    <?= $isEdit
                        ? 'Update your vitals — changed fields are highlighted'
                        : 'Enter your current vitals and health measurements' ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Error Box (preserves existing validation) -->
    <?php if (!empty($errors)): ?>
        <div class="hf-errors">
            <ul><?php foreach ($errors as $e): ?>
                <li><?= htmlspecialchars($e) ?></li>
            <?php endforeach; ?></ul>
        </div>
    <?php endif; ?>

    <!-- Original Values Panel (Edit mode only) -->
    <?php if ($isEdit && $record): ?>
    <div class="hf-orig-panel">
        <div class="hf-orig-label">📊 Current values — before your edits</div>
        <div class="hf-orig-grid">
            <div class="hf-orig-card">
                <div class="hf-orig-metric">Systolic</div>
                <div class="hf-orig-val"><?= htmlspecialchars($record['systolic_bp']) ?></div>
                <div class="hf-orig-unit">mmHg</div>
            </div>
            <div class="hf-orig-card">
                <div class="hf-orig-metric">Diastolic</div>
                <div class="hf-orig-val"><?= htmlspecialchars($record['diastolic_bp']) ?></div>
                <div class="hf-orig-unit">mmHg</div>
            </div>
            <div class="hf-orig-card">
                <div class="hf-orig-metric">Heart Rate</div>
                <div class="hf-orig-val"><?= htmlspecialchars($record['heart_rate']) ?></div>
                <div class="hf-orig-unit">bpm</div>
            </div>
            <div class="hf-orig-card">
                <div class="hf-orig-metric">Weight</div>
                <div class="hf-orig-val"><?= htmlspecialchars($record['weight']) ?></div>
                <div class="hf-orig-unit">kg</div>
            </div>
            <div class="hf-orig-card">
                <div class="hf-orig-metric">Blood Sugar</div>
                <div class="hf-orig-val"><?= htmlspecialchars($record['blood_sugar']) ?></div>
                <div class="hf-orig-unit">mg/dL</div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- FORM (action/method/hidden id preserved exactly) -->
    <form method="POST" action="index.php?page=<?= $isEdit ? 'health-records-update' : 'health-records-store' ?>">
        <?php if ($isEdit): ?>
            <input type="hidden" name="id" value="<?= $id ?>">
        <?php endif; ?>

        <!-- Section 1: Record Information -->
        <div class="hf-section">
            <div class="hf-section-title">
                <div class="hf-section-icon hf-si-teal">📅</div>
                Record Information
            </div>
            <div class="hf-grid">
                <div class="hf-group full">
                    <label class="hf-label">Date <span class="hf-req">*</span></label>
                    <div class="hf-input-wrap">
                        <span class="hf-input-icon">📅</span>
                        <input type="date" name="date" class="hf-input"
                               value="<?= htmlspecialchars($o['date'] ?? date('Y-m-d')) ?>" required>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section 2: Vital Signs -->
        <div class="hf-section">
            <div class="hf-section-title">
                <div class="hf-section-icon hf-si-red">🫀</div>
                Vital Signs
            </div>
            <div class="hf-grid">
                <div class="hf-group">
                    <label class="hf-label">Systolic BP <span class="hf-req">*</span></label>
                    <div class="hf-input-wrap">
                        <span class="hf-input-icon">🫀</span>
                        <input type="number" name="systolic_bp" class="hf-input"
                               id="f_sys" placeholder="e.g. 120"
                               min="60" max="250"
                               value="<?= htmlspecialchars($o['systolic_bp'] ?? '') ?>"
                               data-orig="<?= htmlspecialchars($record['systolic_bp'] ?? '') ?>"
                               required>
                    </div>
                    <span class="hf-hint">Normal: below 120 mmHg</span>
                </div>
                <div class="hf-group">
                    <label class="hf-label">Diastolic BP <span class="hf-req">*</span></label>
                    <div class="hf-input-wrap">
                        <span class="hf-input-icon">💧</span>
                        <input type="number" name="diastolic_bp" class="hf-input"
                               id="f_dia" placeholder="e.g. 80"
                               min="40" max="150"
                               value="<?= htmlspecialchars($o['diastolic_bp'] ?? '') ?>"
                               data-orig="<?= htmlspecialchars($record['diastolic_bp'] ?? '') ?>"
                               required>
                    </div>
                    <span class="hf-hint">Normal: below 80 mmHg</span>
                </div>
                <div class="hf-group full">
                    <label class="hf-label">Heart Rate (BPM) <span class="hf-req">*</span></label>
                    <div class="hf-input-wrap">
                        <span class="hf-input-icon">💓</span>
                        <input type="number" name="heart_rate" class="hf-input"
                               id="f_hr" placeholder="e.g. 72"
                               min="30" max="220"
                               value="<?= htmlspecialchars($o['heart_rate'] ?? '') ?>"
                               data-orig="<?= htmlspecialchars($record['heart_rate'] ?? '') ?>"
                               required>
                    </div>
                    <span class="hf-hint">Normal resting: 60–100 bpm</span>
                </div>
            </div>
        </div>

        <!-- Section 3: Health Metrics -->
        <div class="hf-section">
            <div class="hf-section-title">
                <div class="hf-section-icon hf-si-purple">📊</div>
                Health Metrics
            </div>
            <div class="hf-grid">
                <div class="hf-group">
                    <label class="hf-label">Weight (kg) <span class="hf-req">*</span></label>
                    <div class="hf-input-wrap">
                        <span class="hf-input-icon">⚖</span>
                        <input type="number" name="weight" class="hf-input"
                               id="f_wt" placeholder="e.g. 74.5"
                               step="0.1" min="10" max="300"
                               value="<?= htmlspecialchars($o['weight'] ?? '') ?>"
                               data-orig="<?= htmlspecialchars($record['weight'] ?? '') ?>"
                               required>
                    </div>
                </div>
                <div class="hf-group">
                    <label class="hf-label">Blood Sugar (mg/dL) <span class="hf-req">*</span></label>
                    <div class="hf-input-wrap">
                        <span class="hf-input-icon">🩸</span>
                        <input type="number" name="blood_sugar" class="hf-input"
                               id="f_bs" placeholder="e.g. 95"
                               step="0.1" min="40" max="600"
                               value="<?= htmlspecialchars($o['blood_sugar'] ?? '') ?>"
                               data-orig="<?= htmlspecialchars($record['blood_sugar'] ?? '') ?>"
                               required>
                    </div>
                    <span class="hf-hint">Fasting normal: 70–99 mg/dL</span>
                </div>
            </div>
        </div>

        <!-- Section 4: Notes -->
        <div class="hf-section">
            <div class="hf-section-title">
                <div class="hf-section-icon hf-si-amber">📝</div>
                Notes
            </div>
            <div class="hf-group">
                <label class="hf-label">Additional Notes</label>
                <textarea name="notes" id="hf_notes" class="hf-textarea"
                          placeholder="Any symptoms, observations, or context for this reading..."
                          maxlength="500"
                          oninput="document.getElementById('hf_char').textContent=this.value.length"
                ><?= htmlspecialchars($o['notes'] ?? '') ?></textarea>
                <div class="hf-char-count">
                    <span id="hf_char"><?= mb_strlen($o['notes'] ?? '') ?></span> / 500
                </div>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="hf-actions">
            <button type="submit" class="hf-btn hf-btn-teal">
                <?= $isEdit ? '💾 Update Record' : '✅ Save Record' ?>
            </button>
            <a href="index.php?page=health-records" class="hf-btn hf-btn-ghost">Cancel</a>
        </div>
    </form>

</div><!-- /.hf-module -->

<script>
/* Highlight changed fields in Edit mode */
document.querySelectorAll('.hf-input[data-orig]').forEach(input => {
    const orig = input.dataset.orig;
    if (!orig) return; /* Add mode — no original */
    input.addEventListener('input', function () {
        if (this.value !== orig) {
            this.classList.add('changed');
        } else {
            this.classList.remove('changed');
        }
    });
});
</script>

<?php require_once APP_PATH . '/views/shared/footer.php'; ?>