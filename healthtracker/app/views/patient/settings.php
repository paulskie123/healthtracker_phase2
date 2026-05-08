<?php
$pageTitle = 'Settings';
$activePage = 'settings';
require_once APP_PATH . '/views/shared/header.php';
?>

<?php if (!empty($success)): ?>
    <div class="alert alert-success" data-auto-dismiss>✅ <?= htmlspecialchars($success) ?></div>
<?php endif; ?>
<?php if (!empty($error)): ?>
    <div class="alert alert-danger" data-auto-dismiss>❌ <?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<div class="card">
    <form method="POST" action="index.php?page=settings">

        <div class="settings-section">
            <div class="settings-section-title">🎨 Theme Preference</div>
            <select name="theme" class="form-select" style="max-width:280px;">
                <option selected>Dark Mode (Recommended)</option>
                <option>Light Mode</option>
                <option>System Default</option>
            </select>
        </div>

        <div class="settings-section">
            <div class="settings-section-title">🔔 Notifications</div>
            <div class="checkbox-group">
                <label class="checkbox-item"><input type="checkbox" name="notif_email" checked> Email health reminders</label>
                <label class="checkbox-item"><input type="checkbox" name="notif_push" checked> Push notifications for medication</label>
                <label class="checkbox-item"><input type="checkbox" name="notif_weekly"> Weekly health report via email</label>
            </div>
        </div>

        <div class="settings-section">
            <div class="settings-section-title">📏 Units & Measurements</div>
            <select name="units" class="form-select" style="max-width:280px;">
                <option selected>Metric (kg, mmHg, mg/dL)</option>
                <option>Imperial (lbs, mmHg, mg/dL)</option>
            </select>
        </div>

        <div class="settings-section">
            <div class="settings-section-title">🔒 Privacy & Security</div>
            <div class="checkbox-group">
                <label class="checkbox-item"><input type="checkbox" name="anon_data"> Share anonymized data for research</label>
            </div>

            <div style="margin-top: 12px;">
                <?php if (!empty($user['two_fa_enabled'])): ?>
                    <p style="color: #4ade80; margin-bottom: 8px;">✅ Two-factor authentication is <strong>enabled</strong></p>
                    <button type="submit" name="disable_2fa" class="btn-danger"
                        onclick="return confirm('Disable 2FA? This will make your account less secure.')">
                        🔓 Disable 2FA
                    </button>
                <?php else: ?>
                    <p style="color: #f87171; margin-bottom: 8px;">⚠️ Two-factor authentication is <strong>disabled</strong></p>
                    <a href="index.php?page=setup-2fa" class="btn-primary">🔐 Enable 2FA</a>
                <?php endif; ?>
            </div>
        </div>

        <div class="settings-section">
            <div class="settings-section-title">🌐 Language</div>
            <select name="language" class="form-select" style="max-width:280px;">
                <option selected>English (US)</option>
                <option>Filipino</option>
                <option>Spanish</option>
                <option>French</option>
            </select>
        </div>

        <button type="submit" class="btn-primary">💾 Save All Preferences</button>
    </form>
</div>

<?php require_once APP_PATH . '/views/shared/footer.php'; ?>