<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HealthTracker — Sign In</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="auth-body">

<div class="auth-card">
    <div class="auth-logo">
        <span class="auth-logo-icon">❤️</span>
        <span class="auth-logo-text">Health<span>Tracker</span></span>
    </div>

    <h2 class="auth-title">Welcome Back</h2>
    <p class="auth-subtitle">Sign in to your health dashboard</p>

    <?php if (!empty($error)): ?>
        <div class="auth-error">⚠️ <?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form class="auth-form" method="POST" action="index.php?page=login">
        <div class="input-wrapper">
            <span class="input-icon">✉️</span>
            <input type="email" name="email" class="auth-input" placeholder="Email address" required>
        </div>
        <div class="input-wrapper">
            <span class="input-icon">🔒</span>
            <input type="password" name="password" class="auth-input" placeholder="Password" required>
        </div>
        <button type="submit" class="btn-primary" style="width:100%;justify-content:center;">Sign In →</button>
    </form>

    <div style="margin-top:16px;padding:12px 14px;background:rgba(0,212,170,0.06);border:1px solid rgba(0,212,170,0.15);border-radius:8px;">
        <p style="font-size:11.5px;color:var(--text-muted);margin-bottom:4px;font-weight:600;text-transform:uppercase;letter-spacing:0.5px;">Demo Credentials</p>
        <p style="font-size:12.5px;color:var(--teal);font-family:'JetBrains Mono',monospace;">alex.morgan@healthtracker.com</p>
        <p style="font-size:12.5px;color:var(--text-secondary);font-family:'JetBrains Mono',monospace;">password123</p>
    </div>

    <div class="auth-footer">
        Don't have an account? <a href="index.php?page=register">Create one</a>
    </div>
</div>

</body>
</html>