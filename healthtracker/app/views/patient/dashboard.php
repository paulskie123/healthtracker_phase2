<?php
$pageTitle = 'Dashboard';
$activePage = 'dashboard';
require_once APP_PATH . '/views/shared/header.php';

$bp = $latest ? $latest['systolic_bp'].'/'.$latest['diastolic_bp'].' mmHg' : 'N/A';
$hr = $latest ? $latest['heart_rate'].' bpm' : 'N/A';
$wt = $latest ? $latest['weight'].' kg' : 'N/A';
$bs = $latest ? $latest['blood_sugar'].' mg/dL' : 'N/A';

// BP status helper
$bpStatus = 'normal';
if ($latest) {
    if ($latest['systolic_bp'] >= 140 || $latest['diastolic_bp'] >= 90) $bpStatus = 'danger';
    elseif ($latest['systolic_bp'] >= 130) $bpStatus = 'warning';
}
?>

<!-- STAT CARDS -->
<div class="stats-grid">
    <div class="stat-card bp">
        <div class="stat-header">
            <span class="stat-label">Blood Pressure</span>
            <div class="stat-icon">💓</div>
        </div>
        <div class="stat-value"><?= $bp ?></div>
        <?php if ($bpStatus === 'danger'): ?>
            <span class="stat-badge badge-danger"><span class="badge-dot"></span> High</span>
        <?php elseif ($bpStatus === 'warning'): ?>
            <span class="stat-badge badge-warning"><span class="badge-dot"></span> Elevated</span>
        <?php else: ?>
            <span class="stat-badge badge-normal"><span class="badge-dot"></span> Normal</span>
        <?php endif; ?>
    </div>
    <div class="stat-card hr">
        <div class="stat-header">
            <span class="stat-label">Heart Rate</span>
            <div class="stat-icon">❤️</div>
        </div>
        <div class="stat-value"><?= $hr ?></div>
        <span class="stat-badge badge-normal"><span class="badge-dot"></span> Normal</span>
    </div>
    <div class="stat-card wt">
        <div class="stat-header">
            <span class="stat-label">Weight</span>
            <div class="stat-icon">⚖️</div>
        </div>
        <div class="stat-value"><?= $wt ?></div>
        <span class="stat-badge badge-stable"><span class="badge-dot"></span> Stable</span>
    </div>
    <div class="stat-card bs">
        <div class="stat-header">
            <span class="stat-label">Blood Sugar</span>
            <div class="stat-icon">💧</div>
        </div>
        <div class="stat-value"><?= $bs ?></div>
        <span class="stat-badge badge-normal"><span class="badge-dot"></span> Normal</span>
    </div>
</div>

<div class="dashboard-grid">
    <!-- SELF DIAGNOSIS TOOL -->
    <div class="card">
        <div class="card-header">
            <div class="card-title">
                <div class="card-icon">❤️‍🩹</div>
                Self Diagnosis Tool
            </div>
        </div>
        <div class="diagnosis-grid">
            <div class="field-group">
                <label>Systolic BP (mmHg)</label>
                <input type="number" class="field-input" id="sys" value="<?= $latest['systolic_bp'] ?? 125 ?>">
            </div>
            <div class="field-group">
                <label>Diastolic BP (mmHg)</label>
                <input type="number" class="field-input" id="dia" value="<?= $latest['diastolic_bp'] ?? 80 ?>">
            </div>
            <div class="field-group">
                <label>Heart Rate (BPM)</label>
                <input type="number" class="field-input" id="hrt" value="<?= $latest['heart_rate'] ?? 72 ?>">
            </div>
            <div class="field-group">
                <label>Symptoms</label>
                <select class="field-select" id="sym">
                    <option>None</option>
                    <option>Headache</option>
                    <option>Dizziness</option>
                    <option>Chest Pain</option>
                    <option>Fatigue</option>
                    <option>Shortness of Breath</option>
                </select>
            </div>
        </div>
        <button class="btn-analyze" onclick="analyzeHealth()">Analyze Health →</button>
        <div id="diagResult" style="margin-top:12px;"></div>
    </div>

    <!-- UPCOMING APPOINTMENTS -->
    <div class="card">
        <div class="card-header">
            <div class="card-title">
                <div class="card-icon blue">🗓️</div>
                Upcoming Appointments
            </div>
            <a href="index.php?page=appointments" class="btn-secondary btn-sm">View All</a>
        </div>
        <?php if (empty($appointments)): ?>
            <div class="empty-state" style="padding:24px;">
                <div class="empty-icon">🗓️</div>
                <div class="empty-title">No upcoming appointments</div>
                <a href="index.php?page=appointments-create" class="btn-primary btn-sm">Schedule Now</a>
            </div>
        <?php else: ?>
            <div style="display:flex;flex-direction:column;gap:10px;">
                <?php foreach ($appointments as $appt): ?>
                    <?php
                    $d = new DateTime($appt['date']);
                    ?>
                    <div style="display:flex;align-items:center;gap:12px;padding:12px;background:var(--bg-elevated);border:1px solid var(--border);border-radius:8px;">
                        <div style="background:var(--blue-dim);border:1px solid rgba(79,168,255,0.2);border-radius:8px;padding:8px 10px;text-align:center;min-width:48px;">
                            <div style="font-size:9px;font-weight:700;text-transform:uppercase;color:var(--blue);"><?= $d->format('M') ?></div>
                            <div style="font-size:20px;font-weight:700;color:var(--text-primary);line-height:1.1;font-family:'JetBrains Mono',monospace;"><?= $d->format('d') ?></div>
                        </div>
                        <div style="flex:1;min-width:0;">
                            <div style="font-size:13.5px;font-weight:700;color:var(--text-primary);"><?= htmlspecialchars($appt['doctor']) ?></div>
                            <div style="font-size:12px;color:var(--teal);"><?= htmlspecialchars($appt['specialty']) ?></div>
                            <div style="font-size:11.5px;color:var(--text-muted);margin-top:2px;">🕐 <?= date('g:i A', strtotime($appt['time'])) ?></div>
                        </div>
                        <span class="status-badge status-scheduled">Scheduled</span>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- BP TREND CHART -->
<div class="card">
    <div class="card-header">
        <div class="card-title">
            <div class="card-icon">📈</div>
            Blood Pressure Trend (Last 5 Records)
        </div>
        <a href="index.php?page=health-records" class="btn-secondary btn-sm">All Records</a>
    </div>
    <div class="chart-legend">
        <div class="legend-item"><div class="legend-line" style="background:#ff5b5b"></div> Systolic (mmHg)</div>
        <div class="legend-item"><div class="legend-line" style="background:#4fa8ff"></div> Diastolic (mmHg)</div>
    </div>
    <div class="chart-wrapper">
        <canvas id="bpChart"></canvas>
    </div>
</div>

<!-- QUICK MEDICATIONS -->
<div class="card">
    <div class="card-header">
        <div class="card-title">
            <div class="card-icon orange">💊</div>
            Today's Medications
        </div>
        <a href="index.php?page=medication" class="btn-secondary btn-sm">Manage</a>
    </div>
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:12px;">
        <?php foreach ($meds as $med): ?>
            <div style="background:var(--bg-elevated);border:1px solid var(--border);border-radius:8px;padding:12px 14px;display:flex;align-items:center;gap:10px;">
                <span style="font-size:20px;"><?= $med['icon'] ?></span>
                <div>
                    <div style="font-size:13px;font-weight:700;color:var(--text-primary);"><?= htmlspecialchars($med['name']) ?></div>
                    <div style="font-size:11.5px;color:var(--text-muted);"><?= htmlspecialchars($med['dosage']) ?> · <?= htmlspecialchars($med['schedule']) ?></div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<script>
<?php
$slice  = array_reverse(array_slice($records, 0, 5));
$labels = array_map(fn($r) => date('M d', strtotime($r['date'])), $slice);
$sys    = array_column($slice, 'systolic_bp');
$dia    = array_column($slice, 'diastolic_bp');
?>
const bpCtx = document.getElementById('bpChart').getContext('2d');
new Chart(bpCtx, {
    type: 'line',
    data: {
        labels: <?= json_encode($labels) ?>,
        datasets: [
            { label:'Systolic', data:<?= json_encode($sys) ?>, borderColor:'#ff5b5b', backgroundColor:'rgba(255,91,91,0.06)', fill:true, pointBackgroundColor:'#ff5b5b', borderWidth:2, tension:0.4, pointRadius:5 },
            { label:'Diastolic', data:<?= json_encode($dia) ?>, borderColor:'#4fa8ff', backgroundColor:'rgba(79,168,255,0.06)', fill:true, pointBackgroundColor:'#4fa8ff', borderWidth:2, tension:0.4, pointRadius:5 }
        ]
    },
    options: {
        responsive:true, maintainAspectRatio:false,
        plugins:{ legend:{ labels:{ color:'#8ba3c7', font:{ size:11 } } } },
        scales:{
            x:{ ticks:{ color:'#4a6080', font:{size:11} }, grid:{ color:'rgba(255,255,255,0.04)' } },
            y:{ ticks:{ color:'#4a6080', font:{size:11} }, grid:{ color:'rgba(255,255,255,0.04)' } }
        }
    }
});
</script>

<?php require_once APP_PATH . '/views/shared/footer.php'; ?>
