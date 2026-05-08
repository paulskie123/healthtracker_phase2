<?php
$pageTitle = 'Progress & Reports';
$activePage = 'progress';
require_once APP_PATH . '/views/shared/header.php';

$recentFour  = array_reverse(array_slice($records, 0, 4));
$weightLabels = [];
$weightData   = [];
$hrData       = [];
foreach ($recentFour as $i => $r) {
    $weightLabels[] = date('M d', strtotime($r['date']));
    $weightData[]   = $r['weight'];
    $hrData[]       = $r['heart_rate'];
}

$avgBP = $records ? round(array_sum(array_column($records, 'systolic_bp')) / count($records)) : 0;
$avgHR = $records ? round(array_sum(array_column($records, 'heart_rate'))  / count($records)) : 0;
$avgBS = $records ? round(array_sum(array_column($records, 'blood_sugar'))  / count($records)) : 0;
$avgWT = $records ? round(array_sum(array_column($records, 'weight'))       / count($records), 1) : 0;
?>

<!-- Monthly Summary -->
<div class="card">
    <div class="card-header">
        <div class="card-title"><div class="card-icon">📊</div> Monthly Summary</div>
        <span class="text-muted text-sm">Based on <?= count($records) ?> records</span>
    </div>
    <div class="summary-grid">
        <div class="summary-card">
            <div class="summary-label">Avg Blood Pressure</div>
            <div class="summary-value text-blue"><?= $avgBP ?></div>
            <div class="summary-sub">Systolic average (mmHg)</div>
        </div>
        <div class="summary-card">
            <div class="summary-label">Avg Heart Rate</div>
            <div class="summary-value text-red"><?= $avgHR ?></div>
            <div class="summary-sub">Resting rate (bpm)</div>
        </div>
        <div class="summary-card">
            <div class="summary-label">Avg Blood Sugar</div>
            <div class="summary-value text-purple"><?= $avgBS ?></div>
            <div class="summary-sub">Fasting average (mg/dL)</div>
        </div>
    </div>
</div>

<div class="dashboard-grid">
    <!-- Weight Trend -->
    <div class="card">
        <div class="card-header">
            <div class="card-title"><div class="card-icon orange">⚖️</div> Weight Trend</div>
        </div>
        <div style="text-align:center;margin-bottom:12px;">
            <span style="font-size:32px;font-weight:700;color:var(--orange);font-family:'JetBrains Mono',monospace;"><?= $avgWT ?></span>
            <span style="font-size:14px;color:var(--text-muted);margin-left:4px;">kg avg</span>
        </div>
        <div class="chart-wrapper">
            <canvas id="weightChart"></canvas>
        </div>
    </div>

    <!-- Heart Rate Trend -->
    <div class="card">
        <div class="card-header">
            <div class="card-title"><div class="card-icon red">❤️</div> Heart Rate Trend</div>
        </div>
        <div style="text-align:center;margin-bottom:12px;">
            <span style="font-size:32px;font-weight:700;color:var(--red);font-family:'JetBrains Mono',monospace;"><?= $avgHR ?></span>
            <span style="font-size:14px;color:var(--text-muted);margin-left:4px;">bpm avg</span>
        </div>
        <div class="chart-wrapper">
            <canvas id="hrChart"></canvas>
        </div>
    </div>
</div>

<!-- BP Trend Full -->
<div class="card">
    <div class="card-header">
        <div class="card-title"><div class="card-icon">💓</div> Blood Pressure History</div>
    </div>
    <div class="chart-legend">
        <div class="legend-item"><div class="legend-line" style="background:#ff5b5b"></div> Systolic</div>
        <div class="legend-item"><div class="legend-line" style="background:#4fa8ff"></div> Diastolic</div>
    </div>
    <div class="chart-wrapper" style="height:260px;">
        <canvas id="bpChart"></canvas>
    </div>
</div>

<script>
const allRecords = <?= json_encode(array_reverse($records)) ?>;
const bpLabels   = allRecords.map(r => { const d = new Date(r.date); return d.toLocaleDateString('en-US',{month:'short',day:'numeric'}); });
const sysList    = allRecords.map(r => r.systolic_bp);
const diaList    = allRecords.map(r => r.diastolic_bp);

new Chart(document.getElementById('weightChart').getContext('2d'), {
    type:'line',
    data:{ labels:<?= json_encode($weightLabels) ?>, datasets:[{ label:'Weight (kg)', data:<?= json_encode($weightData) ?>, borderColor:'#ff9a3c', backgroundColor:'rgba(255,154,60,0.08)', fill:true, pointBackgroundColor:'#ff9a3c', borderWidth:2, tension:0.4, pointRadius:5 }] },
    options:{ responsive:true, maintainAspectRatio:false, plugins:{ legend:{ labels:{ color:'#8ba3c7', font:{size:11} } } }, scales:{ x:{ ticks:{ color:'#4a6080' }, grid:{ color:'rgba(255,255,255,0.04)' } }, y:{ ticks:{ color:'#4a6080' }, grid:{ color:'rgba(255,255,255,0.04)' } } } }
});

new Chart(document.getElementById('hrChart').getContext('2d'), {
    type:'bar',
    data:{ labels:<?= json_encode($weightLabels) ?>, datasets:[{ label:'Heart Rate (bpm)', data:<?= json_encode($hrData) ?>, backgroundColor:'rgba(255,91,91,0.2)', borderColor:'#ff5b5b', borderWidth:2, borderRadius:6 }] },
    options:{ responsive:true, maintainAspectRatio:false, plugins:{ legend:{ labels:{ color:'#8ba3c7', font:{size:11} } } }, scales:{ x:{ ticks:{ color:'#4a6080' }, grid:{ color:'rgba(255,255,255,0.04)' } }, y:{ ticks:{ color:'#4a6080' }, grid:{ color:'rgba(255,255,255,0.04)' } } } }
});

new Chart(document.getElementById('bpChart').getContext('2d'), {
    type:'line',
    data:{ labels:bpLabels, datasets:[
        { label:'Systolic', data:sysList, borderColor:'#ff5b5b', backgroundColor:'rgba(255,91,91,0.05)', fill:true, pointBackgroundColor:'#ff5b5b', borderWidth:2, tension:0.4, pointRadius:4 },
        { label:'Diastolic', data:diaList, borderColor:'#4fa8ff', backgroundColor:'rgba(79,168,255,0.05)', fill:true, pointBackgroundColor:'#4fa8ff', borderWidth:2, tension:0.4, pointRadius:4 }
    ] },
    options:{ responsive:true, maintainAspectRatio:false, plugins:{ legend:{ labels:{ color:'#8ba3c7', font:{size:11} } } }, scales:{ x:{ ticks:{ color:'#4a6080', font:{size:11} }, grid:{ color:'rgba(255,255,255,0.04)' } }, y:{ ticks:{ color:'#4a6080', font:{size:11} }, grid:{ color:'rgba(255,255,255,0.04)' } } } }
});
</script>

<?php require_once APP_PATH . '/views/shared/footer.php'; ?>
