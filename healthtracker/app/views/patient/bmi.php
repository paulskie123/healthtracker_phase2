<?php
$pageTitle  = 'BMI Calculator';
$activePage = 'bmi';
require_once APP_PATH . '/views/shared/header.php';
?>

<style>
.bmi-wrap       { max-width: 860px; margin: 0 auto; padding: 32px 24px; }
.bmi-hero       { background: linear-gradient(135deg,#0f2027,#203a43,#2c5364); border-radius: 20px; padding: 36px; margin-bottom: 28px; text-align: center; }
.bmi-hero h1    { font-size: 28px; font-weight: 700; color: #e8f0fe; margin-bottom: 6px; }
.bmi-hero p     { color: #6b7a99; font-size: 14px; }
.calc-card      { background: #1a2235; border: 1px solid rgba(255,255,255,0.08); border-radius: 16px; padding: 28px; margin-bottom: 24px; }
.calc-card h2   { font-size: 16px; font-weight: 600; color: #e8f0fe; margin-bottom: 20px; }
.form-row       { display: flex; gap: 16px; margin-bottom: 16px; }
.form-group     { flex: 1; display: flex; flex-direction: column; gap: 6px; }
.form-group label { font-size: 12px; color: #6b7a99; text-transform: uppercase; letter-spacing: 0.5px; }
.form-group input { background: #0d1421; border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; padding: 10px 14px; color: #e8f0fe; font-size: 15px; outline: none; }
.form-group input:focus { border-color: #00d4aa; }
.btn-calc       { width: 100%; padding: 13px; background: #00d4aa; color: #000; border: none; border-radius: 10px; font-size: 15px; font-weight: 700; cursor: pointer; margin-top: 8px; }
.btn-calc:hover { background: #00b894; }
.result-box     { display: none; margin-top: 24px; border-radius: 14px; padding: 28px; text-align: center; border: 2px solid #00d4aa; }
.result-box .bmi-number { font-size: 64px; font-weight: 800; line-height: 1; }
.result-box .bmi-label  { font-size: 20px; font-weight: 600; margin: 8px 0 4px; }
.result-box .bmi-range  { font-size: 13px; color: #6b7a99; }
.gauge-wrap     { margin: 20px auto; width: 260px; }
.gauge-bar      { height: 12px; border-radius: 6px; background: linear-gradient(to right,#3b82f6,#22c55e,#f59e0b,#ef4444); margin-bottom: 6px; position: relative; }
.gauge-needle   { position: absolute; top: -4px; width: 4px; height: 20px; background: #fff; border-radius: 2px; transform: translateX(-50%); transition: left 0.6s ease; }
.gauge-labels   { display: flex; justify-content: space-between; font-size: 10px; color: #6b7a99; }
.history-table  { width: 100%; border-collapse: collapse; }
.history-table th { text-align: left; font-size: 11px; color: #6b7a99; text-transform: uppercase; letter-spacing: 0.5px; padding: 8px 12px; border-bottom: 1px solid rgba(255,255,255,0.06); }
.history-table td { padding: 12px; font-size: 13px; color: #e8f0fe; border-bottom: 1px solid rgba(255,255,255,0.04); }
.badge          { display: inline-block; padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 600; }
.badge-blue     { background: rgba(59,130,246,0.15); color: #60a5fa; }
.badge-green    { background: rgba(34,197,94,0.15);  color: #4ade80; }
.badge-yellow   { background: rgba(245,158,11,0.15); color: #fbbf24; }
.badge-red      { background: rgba(239,68,68,0.15);  color: #f87171; }
.tip-grid       { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-top: 4px; }
.tip-card       { background: rgba(0,212,170,0.06); border: 1px solid rgba(0,212,170,0.15); border-radius: 10px; padding: 14px; }
.tip-card .tip-icon { font-size: 22px; margin-bottom: 6px; }
.tip-card h4    { font-size: 13px; font-weight: 600; color: #e8f0fe; margin-bottom: 4px; }
.tip-card p     { font-size: 12px; color: #6b7a99; line-height: 1.5; }
</style>

<div class="bmi-wrap">

    <!-- Hero -->
    <div class="bmi-hero">
        <h1>⚖️ BMI Calculator</h1>
        <p>Body Mass Index — understand your weight relative to your height</p>
    </div>

    <!-- Calculator -->
    <div class="calc-card">
        <h2>Calculate Your BMI</h2>
        <div class="form-row">
            <div class="form-group">
                <label>Height (cm)</label>
                <input type="number" id="height" placeholder="e.g. 170" min="50" max="250">
            </div>
            <div class="form-group">
                <label>Weight (kg)</label>
                <input type="number" id="weight" placeholder="e.g. 65" min="10" max="300"
                       value="<?= !empty($records) ? htmlspecialchars($records[0]['weight']) : '' ?>">
            </div>
            <div class="form-group">
                <label>Age</label>
                <input type="number" id="age" placeholder="e.g. 25" min="1" max="120"
                       value="<?= htmlspecialchars($user['age'] ?? '') ?>">
            </div>
        </div>
        <button class="btn-calc" onclick="calculateBMI()">Calculate BMI →</button>

        <!-- Result -->
        <div class="result-box" id="resultBox">
            <div class="bmi-number" id="bmiNumber">--</div>
            <div class="bmi-label"  id="bmiLabel">--</div>
            <div class="bmi-range"  id="bmiRange">--</div>
            <div class="gauge-wrap">
                <div class="gauge-bar">
                    <div class="gauge-needle" id="needle" style="left:0%"></div>
                </div>
                <div class="gauge-labels">
                    <span>Underweight</span>
                    <span>Normal</span>
                    <span>Overweight</span>
                    <span>Obese</span>
                </div>
            </div>
            <p id="bmiAdvice" style="font-size:13px;color:#6b7a99;margin-top:8px;"></p>
        </div>
    </div>

    <!-- BMI History from health records -->
    <?php if (!empty($records)): ?>
    <div class="calc-card">
        <h2>📋 BMI History (from your health records)</h2>
        <table class="history-table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Weight (kg)</th>
                    <th>BMI*</th>
                    <th>Category</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach (array_slice($records, 0, 8) as $r):
                    $h  = $user['height'] ?? 170;
                    $bmi = $h > 0 ? round($r['weight'] / (($h/100) ** 2), 1) : null;
                    $cat = '';
                    $badgeClass = '';
                    if ($bmi) {
                        if      ($bmi < 18.5) { $cat = 'Underweight'; $badgeClass = 'badge-blue'; }
                        elseif  ($bmi < 25)   { $cat = 'Normal';      $badgeClass = 'badge-green'; }
                        elseif  ($bmi < 30)   { $cat = 'Overweight';  $badgeClass = 'badge-yellow'; }
                        else                  { $cat = 'Obese';       $badgeClass = 'badge-red'; }
                    }
                ?>
                <tr>
                    <td><?= date('M d, Y', strtotime($r['date'])) ?></td>
                    <td><?= number_format($r['weight'], 1) ?> kg</td>
                    <td><?= $bmi ?? '—' ?></td>
                    <td><?php if ($cat): ?><span class="badge <?= $badgeClass ?>"><?= $cat ?></span><?php endif; ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <p style="font-size:11px;color:#6b7a99;margin-top:12px;">* BMI calculated using your profile height (<?= $user['height'] ?? 170 ?> cm). Update your profile to change it.</p>
    </div>
    <?php endif; ?>

    <!-- Tips -->
    <div class="calc-card">
        <h2>💡 BMI Tips & Information</h2>
        <div class="tip-grid">
            <div class="tip-card">
                <div class="tip-icon">🔵</div>
                <h4>Underweight (< 18.5)</h4>
                <p>May indicate nutritional deficiency. Consult a doctor for a healthy weight gain plan.</p>
            </div>
            <div class="tip-card">
                <div class="tip-icon">🟢</div>
                <h4>Normal (18.5 – 24.9)</h4>
                <p>Healthy weight range. Maintain with balanced diet and regular physical activity.</p>
            </div>
            <div class="tip-card">
                <div class="tip-icon">🟡</div>
                <h4>Overweight (25 – 29.9)</h4>
                <p>Slightly above healthy range. Consider increasing exercise and reducing calorie intake.</p>
            </div>
            <div class="tip-card">
                <div class="tip-icon">🔴</div>
                <h4>Obese (≥ 30)</h4>
                <p>Higher risk of health issues. Speak with a healthcare provider about a weight management plan.</p>
            </div>
        </div>
    </div>

</div>

<script>
function calculateBMI() {
    const h = parseFloat(document.getElementById('height').value);
    const w = parseFloat(document.getElementById('weight').value);
    if (!h || !w || h < 50 || w < 10) {
        alert('Please enter a valid height and weight.');
        return;
    }
    const bmi   = w / ((h / 100) ** 2);
    const round = Math.round(bmi * 10) / 10;

    let label, color, range, advice, needle;
    if (bmi < 18.5) {
        label  = 'Underweight'; color = '#60a5fa';
        range  = 'BMI below 18.5';
        advice = 'You may be underweight. Consider speaking with a nutritionist.';
        needle = Math.max(2, (bmi / 18.5) * 20);
    } else if (bmi < 25) {
        label  = 'Normal Weight'; color = '#4ade80';
        range  = 'BMI 18.5 – 24.9';
        advice = 'Great! You are in the healthy weight range. Keep it up!';
        needle = 20 + ((bmi - 18.5) / 6.5) * 30;
    } else if (bmi < 30) {
        label  = 'Overweight'; color = '#fbbf24';
        range  = 'BMI 25 – 29.9';
        advice = 'Slightly above the healthy range. Regular exercise can help.';
        needle = 50 + ((bmi - 25) / 5) * 25;
    } else {
        label  = 'Obese'; color = '#f87171';
        range  = 'BMI 30 and above';
        advice = 'Please consult a healthcare provider for guidance.';
        needle = Math.min(98, 75 + ((bmi - 30) / 10) * 23);
    }

    const box = document.getElementById('resultBox');
    box.style.display      = 'block';
    box.style.borderColor  = color;
    document.getElementById('bmiNumber').textContent  = round;
    document.getElementById('bmiNumber').style.color  = color;
    document.getElementById('bmiLabel').textContent   = label;
    document.getElementById('bmiLabel').style.color   = color;
    document.getElementById('bmiRange').textContent   = range;
    document.getElementById('bmiAdvice').textContent  = advice;
    document.getElementById('needle').style.left      = needle + '%';
    box.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
}

document.getElementById('weight').addEventListener('keydown', e => { if (e.key === 'Enter') calculateBMI(); });
document.getElementById('height').addEventListener('keydown', e => { if (e.key === 'Enter') calculateBMI(); });
</script>

<?php require_once APP_PATH . '/views/shared/footer.php'; ?>