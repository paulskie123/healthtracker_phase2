<?php
$pageTitle = 'Reminders';
$activePage = 'reminders';
require_once APP_PATH . '/views/shared/header.php';

$reminders = [
    ['icon' => '💓', 'text' => 'Take blood pressure reading',              'time' => '8:00 AM'],
    ['icon' => '💊', 'text' => 'Morning medication (Lisinopril, Vitamin D)', 'time' => '9:00 AM'],
    ['icon' => '🍽️', 'text' => 'Log breakfast & blood sugar',               'time' => '9:30 AM'],
    ['icon' => '🔔', 'text' => 'Weekly check-up reminder',                  'time' => 'Sat 10:00 AM'],
    ['icon' => '🍏', 'text' => 'Log dinner & blood sugar',                  'time' => '7:00 PM'],
    ['icon' => '💊', 'text' => 'Evening medication (Metformin)',             'time' => '8:00 PM'],
    ['icon' => '🌙', 'text' => 'Bedtime medication (Atorvastatin)',          'time' => '10:30 PM'],
];
?>

<div class="card">
    <div class="card-header">
        <div class="card-title"><div class="card-icon">🔔</div> Daily Reminders</div>
    </div>

    <div class="reminder-list">
        <?php foreach ($reminders as $r): ?>
            <div class="reminder-item">
                <div class="reminder-icon-wrap"><?= $r['icon'] ?></div>
                <span class="reminder-text"><?= htmlspecialchars($r['text']) ?></span>
                <span class="reminder-time"><?= htmlspecialchars($r['time']) ?></span>
            </div>
        <?php endforeach; ?>
    </div>

    <button class="btn-add-reminder" onclick="showAddReminder()">+ Add New Reminder</button>

    <div id="addReminderForm" style="display:none;margin-top:18px;">
        <div class="divider"></div>
        <div class="form-grid">
            <div class="form-group">
                <label class="form-label">Reminder Title</label>
                <input type="text" class="form-input" id="remTitle" placeholder="e.g. Take medication">
            </div>
            <div class="form-group">
                <label class="form-label">Time</label>
                <input type="time" class="form-input" id="remTime">
            </div>
            <div class="form-actions">
                <button class="btn-primary" onclick="saveReminder()">✅ Save Reminder</button>
                <button class="btn-secondary" onclick="showAddReminder()">Cancel</button>
            </div>
        </div>
    </div>
</div>

<?php require_once APP_PATH . '/views/shared/footer.php'; ?>
