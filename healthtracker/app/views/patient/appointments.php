<?php
$pageTitle = 'Appointments';
$activePage = 'appointments';
require_once APP_PATH . '/views/shared/header.php';

$upcoming  = array_values(array_filter($appointments, fn($a) => $a['status'] === 'Scheduled'));
$completed = array_values(array_filter($appointments, fn($a) => $a['status'] === 'Completed'));
$cancelled = array_values(array_filter($appointments, fn($a) => $a['status'] === 'Cancelled'));
?>

<?php if (!empty($flash)): ?>
    <div class="alert alert-success" data-auto-dismiss>✅ <?= htmlspecialchars($flash) ?></div>
<?php endif; ?>

<!-- Summary row -->
<div class="stats-grid" style="grid-template-columns:repeat(3,1fr);">
    <div class="stat-card">
        <div class="stat-header"><span class="stat-label">Upcoming</span><div class="stat-icon">🗓️</div></div>
        <div class="stat-value text-blue"><?= count($upcoming) ?></div>
        <span class="stat-badge badge-stable"><span class="badge-dot"></span> Scheduled</span>
    </div>
    <div class="stat-card">
        <div class="stat-header"><span class="stat-label">Completed</span><div class="stat-icon">✅</div></div>
        <div class="stat-value text-green"><?= count($completed) ?></div>
        <span class="stat-badge badge-normal"><span class="badge-dot"></span> Done</span>
    </div>
    <div class="stat-card">
        <div class="stat-header"><span class="stat-label">Total</span><div class="stat-icon">📊</div></div>
        <div class="stat-value"><?= count($appointments) ?></div>
        <span class="stat-badge badge-stable"><span class="badge-dot"></span> All time</span>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <div class="card-title">
            <div class="card-icon blue">🗓️</div>
            Appointment Management
        </div>
        <a href="index.php?page=appointments-create" class="btn-primary">➕ Schedule Appointment</a>
    </div>

    <?php if (empty($appointments)): ?>
        <div class="empty-state">
            <div class="empty-icon">🗓️</div>
            <div class="empty-title">No appointments yet</div>
            <div class="empty-sub">Schedule your first appointment with your doctor.</div>
            <a href="index.php?page=appointments-create" class="btn-primary">Schedule Now</a>
        </div>
    <?php else: ?>

        <!-- Upcoming -->
        <?php if (!empty($upcoming)): ?>
            <div style="font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:0.8px;color:var(--blue);margin-bottom:12px;display:flex;align-items:center;gap:8px;">
                <span style="width:6px;height:6px;border-radius:50%;background:var(--blue);display:inline-block;"></span> Upcoming
            </div>
            <div style="display:flex;flex-direction:column;gap:10px;margin-bottom:24px;">
                <?php foreach ($upcoming as $appt): ?>
                    <?php $d = new DateTime($appt['date']); ?>
                    <div class="appt-card">
                        <div class="appt-date-badge">
                            <div class="month"><?= $d->format('M') ?></div>
                            <div class="day"><?= $d->format('d') ?></div>
                        </div>
                        <div class="appt-info">
                            <div class="appt-doctor"><?= htmlspecialchars($appt['doctor']) ?></div>
                            <div class="appt-specialty"><?= htmlspecialchars($appt['specialty']) ?></div>
                            <div class="appt-meta">
                                <span>🕐 <?= date('g:i A', strtotime($appt['time'])) ?></span>
                                <span>📍 <?= htmlspecialchars($appt['location'] ?: 'TBD') ?></span>
                                <span>🏷️ <?= htmlspecialchars($appt['type']) ?></span>
                            </div>
                            <?php if (!empty($appt['notes'])): ?>
                                <div style="font-size:12px;color:var(--text-muted);margin-top:5px;">📝 <?= htmlspecialchars($appt['notes']) ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="appt-actions">
                            <span class="status-badge status-scheduled">Scheduled</span>
                        </div>
                        <div class="appt-actions">
                            <a href="index.php?page=appointments-edit&id=<?= $appt['id'] ?>" class="btn-edit btn-sm">✏️</a>
                            <a href="index.php?page=appointments-delete&id=<?= $appt['id'] ?>" class="btn-danger btn-sm"
                               data-confirm="Cancel this appointment with <?= htmlspecialchars($appt['doctor']) ?>?">🗑</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <!-- All appointments table -->
        <div class="divider"></div>
        <div style="font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:0.8px;color:var(--text-muted);margin-bottom:14px;">All Appointments</div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Date & Time</th>
                        <th>Doctor</th>
                        <th>Specialty</th>
                        <th>Type</th>
                        <th>Location</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($appointments as $appt): ?>
                        <?php
                        $statusClass = match($appt['status']) {
                            'Scheduled' => 'status-scheduled',
                            'Completed' => 'status-completed',
                            'Cancelled' => 'status-cancelled',
                            default     => 'status-inactive',
                        };
                        ?>
                        <tr>
                            <td>
                                <div style="font-weight:600;color:var(--text-primary);"><?= date('M d, Y', strtotime($appt['date'])) ?></div>
                                <div style="font-size:12px;color:var(--text-muted);"><?= date('g:i A', strtotime($appt['time'])) ?></div>
                            </td>
                            <td style="font-weight:600;color:var(--text-primary);"><?= htmlspecialchars($appt['doctor']) ?></td>
                            <td class="td-muted"><?= htmlspecialchars($appt['specialty']) ?></td>
                            <td class="td-muted"><?= htmlspecialchars($appt['type']) ?></td>
                            <td class="td-muted"><?= htmlspecialchars($appt['location'] ?: '—') ?></td>
                            <td><span class="status-badge <?= $statusClass ?>"><?= htmlspecialchars($appt['status']) ?></span></td>
                            <td>
                                <div class="td-actions">
                                    <a href="index.php?page=appointments-edit&id=<?= $appt['id'] ?>" class="btn-edit btn-sm">✏️ Edit</a>
                                    <a href="index.php?page=appointments-delete&id=<?= $appt['id'] ?>" class="btn-danger btn-sm"
                                       data-confirm="Delete this appointment?">🗑 Delete</a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<?php require_once APP_PATH . '/views/shared/footer.php'; ?>
