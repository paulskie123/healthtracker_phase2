<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HealthTracker — Verify 2FA</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body style="display:flex; align-items:center; justify-content:center; min-height:100vh; background: var(--bg-primary);">

<div class="card" style="max-width: 400px; width: 100%; padding: 40px; text-align:center;">
    <div style="font-size: 48px; margin-bottom: 16px;">🔐</div>
    <h2 style="margin-bottom: 8px;">Two-Factor Authentication</h2>
    <p style="color: var(--text-muted); margin-bottom: 24px;">
        Enter the 6-digit code from your authenticator app.
    </p>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger">❌ <?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" action="index.php?page=verify-2fa">
        <input type="text" name="code" maxlength="6" placeholder="000000"
               class="form-select" style="font-size: 28px; letter-spacing: 8px; text-align:center; margin-bottom: 20px;"
               autofocus required>
        <button type="submit" class="btn-primary" style="width:100%;">✅ Verify</button>
    </form>

    <a href="index.php?page=login" style="display:block; margin-top: 16px; color: var(--text-muted); font-size: 13px;">
        ← Back to Login
    </a>
</div>

</body>
</html>