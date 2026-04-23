<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HealthTracker — Create Account</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="auth-body">

<div class="auth-card">
    <div class="auth-logo">
        <span class="auth-logo-icon">❤️</span>
        <span class="auth-logo-text">Health<span>Tracker</span></span>
    </div>

    <h2 class="auth-title" style="color:var(--teal);">Create Account</h2>
    <p class="auth-subtitle">Start your health journey today</p>

    <?php if (!empty($error)): ?>
        <div class="auth-error">⚠️ <?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <?php if (!empty($success)): ?>
        <div class="auth-success">✅ <?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <form class="auth-form" method="POST" action="index.php?page=register">
        <div class="input-wrapper">
            <span class="input-icon">👤</span>
            <input type="text" name="full_name" class="auth-input" placeholder="Full name" required>
        </div>
        <div class="input-wrapper">
            <span class="input-icon">✉️</span>
            <input type="email" name="email" class="auth-input" placeholder="Email address" required>
        </div>
        <div class="input-wrapper">
            <span class="input-icon">🔒</span>
            <input type="password" name="password" class="auth-input" placeholder="Password (min. 6 chars)" required>
        </div>
        <div class="input-wrapper">
            <span class="input-icon">✅</span>
            <input type="password" name="confirm_password" class="auth-input" placeholder="Confirm password" required>
        </div>
        <button type="submit" class="btn-primary" style="width:100%;justify-content:center;">Create Account →</button>
    </form>

    <div class="auth-footer">
        Already have an account? <a href="index.php?page=login">Sign in</a>
    </div>
</div>

</body>
</html>
