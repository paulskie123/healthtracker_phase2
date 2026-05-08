<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HealthTracker — <?= htmlspecialchars($pageTitle ?? 'App') ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<div class="app-layout">

<!-- ── SIDEBAR ── -->
<aside class="sidebar">
    <div class="sidebar-logo">
        <span>❤️</span>
        <span class="sidebar-logo-text">Health<span>Tracker</span></span>
    </div>
    <nav class="sidebar-nav">
        <div class="sidebar-section-label">Overview</div>
        <a href="index.php?page=dashboard" class="nav-item <?= ($activePage??'')==='dashboard' ? 'active':'' ?>">
            <span class="nav-icon">🏠</span><span class="nav-label">Dashboard</span>
        </a>
        <a href="index.php?page=progress" class="nav-item <?= ($activePage??'')==='progress' ? 'active':'' ?>">
            <span class="nav-icon">📈</span><span class="nav-label">Progress & Reports</span>
        </a>
        <a href="index.php?page=bmi" class="nav-item <?= ($activePage??'')==='bmi' ? 'active':'' ?>">
            <span class="nav-icon">⚖️</span><span class="nav-label">BMI Calculator</span>
        </a>

        <div class="sidebar-section-label" style="margin-top:8px;">Management</div>
        <a href="index.php?page=health-records" class="nav-item <?= ($activePage??'')==='health-records' ? 'active':'' ?>">
            <span class="nav-icon">📋</span><span class="nav-label">Health Records</span>
        </a>
        <a href="index.php?page=medication" class="nav-item <?= ($activePage??'')==='medication' ? 'active':'' ?>">
            <span class="nav-icon">💊</span><span class="nav-label">Medications</span>
        </a>
        <a href="index.php?page=appointments" class="nav-item <?= ($activePage??'')==='appointments' ? 'active':'' ?>">
            <span class="nav-icon">🗓️</span><span class="nav-label">Appointments</span>
        </a>
        <a href="index.php?page=reminders" class="nav-item <?= ($activePage??'')==='reminders' ? 'active':'' ?>">
            <span class="nav-icon">🔔</span><span class="nav-label">Reminders</span>
        </a>

        <div class="sidebar-divider"></div>
        <a href="index.php?page=profile" class="nav-item <?= ($activePage??'')==='profile' ? 'active':'' ?>">
            <span class="nav-icon">👤</span><span class="nav-label">Profile</span>
        </a>
        <a href="index.php?page=settings" class="nav-item <?= ($activePage??'')==='settings' ? 'active':'' ?>">
            <span class="nav-icon">⚙️</span><span class="nav-label">Settings</span>
        </a>
        <a href="index.php?page=logout" class="nav-item danger">
            <span class="nav-icon">🚪</span><span class="nav-label">Logout</span>
        </a>
    </nav>
</aside>

<!-- ── MAIN CONTENT ── -->
<div class="main-content">
<header class="top-header">
    <div class="header-title">
        <h1><?= htmlspecialchars($pageTitle ?? '') ?></h1>
        <p><?= date('l, F j, Y') ?></p>
    </div>
    <div class="header-actions">
        <div class="btn-icon" title="Notifications">🔔</div>
        <div class="avatar"><?= strtoupper(substr($user['full_name'] ?? 'U', 0, 1)) . strtoupper(substr(strstr($user['full_name'] ?? 'U ', ' '), 1, 1)) ?></div>
    </div>
</header>
<div class="page-content">