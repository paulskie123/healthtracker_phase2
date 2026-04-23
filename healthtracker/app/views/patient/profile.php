<?php
$pageTitle = 'Profile';
$activePage = 'profile';
require_once APP_PATH . '/views/shared/header.php';

$initials = strtoupper(substr($user['full_name'], 0, 1))
          . strtoupper(substr(strstr($user['full_name'], ' '), 1, 1));
?>

<div class="card">
    <div class="profile-header">
        <div class="profile-avatar"><?= $initials ?></div>
        <div>
            <div class="profile-name"><?= htmlspecialchars($user['full_name']) ?></div>
            <div class="profile-meta">
                <span>👑 <?= htmlspecialchars($user['plan']) ?> — Member since <?= htmlspecialchars($user['member_since']) ?></span>
                <span>📅 Age: <?= htmlspecialchars($user['age']) ?> &nbsp;|&nbsp; Gender: <?= htmlspecialchars($user['gender']) ?></span>
            </div>
        </div>
    </div>

    <div class="profile-divider"></div>

    <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:0.8px;color:var(--text-muted);margin-bottom:10px;">Contact Information</div>
    <div class="profile-info-row">
        <span class="profile-info-icon">✉️</span>
        <span class="profile-info-text"><?= htmlspecialchars($user['email']) ?></span>
    </div>
    <div class="profile-info-row">
        <span class="profile-info-icon">📞</span>
        <span class="profile-info-text"><?= htmlspecialchars($user['phone'] ?: 'Not provided') ?></span>
    </div>
    <div class="profile-info-row">
        <span class="profile-info-icon">📍</span>
        <span class="profile-info-text"><?= htmlspecialchars($user['location'] ?: 'Not provided') ?></span>
    </div>

    <div class="profile-divider"></div>

    <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:0.8px;color:var(--text-muted);margin-bottom:10px;">Medical Information</div>
    <div class="profile-info-row">
        <span class="profile-info-icon">🩸</span>
        <span class="profile-info-text">Blood Type: <strong><?= htmlspecialchars($user['blood_type'] ?: 'Unknown') ?></strong></span>
    </div>
    <div class="profile-info-row">
        <span class="profile-info-icon">🤚</span>
        <span class="profile-info-text">Allergies: <?= htmlspecialchars($user['allergies'] ?: 'None') ?></span>
    </div>
    <div class="profile-info-row">
        <span class="profile-info-icon">🚑</span>
        <span class="profile-info-text">Emergency Contact: <?= htmlspecialchars($user['emergency_contact'] ?: 'Not set') ?></span>
    </div>
    <div class="profile-info-row">
        <span class="profile-info-icon">👨‍⚕️</span>
        <span class="profile-info-text">Primary Physician: <?= htmlspecialchars($user['physician'] ?: 'Not set') ?></span>
    </div>
</div>

<?php require_once APP_PATH . '/views/shared/footer.php'; ?>
