<?php
$pageTitle = 'Setup 2FA';
$activePage = 'settings';
require_once APP_PATH . '/views/shared/header.php';
?>

<div class="card" style="max-width: 500px; margin: 40px auto;">
    <h2 style="margin-bottom: 8px;">🔐 Set Up Two-Factor Authentication</h2>
    <p style="color: var(--text-muted); margin-bottom: 24px;">
        Scan the QR code below with your authenticator app (Google Authenticator, Authy, etc.), then enter the 6-digit code to confirm.
    </p>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger">❌ <?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <?php if (!empty($success)): ?>
        <div class="alert alert-success">✅ <?= htmlspecialchars($success) ?>
            <br><a href="index.php?page=settings">← Back to Settings</a>
        </div>
    <?php else: ?>

    <div style="text-align:center; margin-bottom: 24px;">
        <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=<?= urlencode($qrUrl) ?>"
             alt="QR Code" style="border-radius: 8px; border: 4px solid #fff;">
    </div>

    <p style="text-align:center; font-size: 13px; color: var(--text-muted); margin-bottom: 20px;">
        Can't scan? Enter this key manually:<br>
        <strong style="letter-spacing: 2px; font-size: 16px;"><?= htmlspecialchars($secret) ?></strong>
    </p>

    <form method="POST" action="index.php?page=setup-2fa">
        <input type="hidden" name="secret" value="<?= htmlspecialchars($secret) ?>">
        <div style="margin-bottom: 16px;">
            <label style="display:block; margin-bottom: 6px; font-weight: 600;">Enter 6-digit code from your app:</label>
            <input type="text" name="code" maxlength="6" placeholder="000000"
                   class="form-select" style="max-width: 200px; font-size: 24px; letter-spacing: 6px; text-align:center;"
                   autofocus required>
        </div>
        <button type="submit" class="btn-primary">✅ Verify & Enable 2FA</button>
        <a href="index.php?page=settings" style="margin-left: 12px; color: var(--text-muted);">Cancel</a>
    </form>

    <?php endif; ?>
</div>

<?php require_once APP_PATH . '/views/shared/footer.php'; ?>