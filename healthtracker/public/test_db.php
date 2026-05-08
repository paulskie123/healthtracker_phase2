<?php
// TEMP TEST FILE - delete after use
// Place this in: healthtracker/public/test_db.php
// Visit: localhost/healthtracker/public/test_db.php

session_start();

$configPath = __DIR__ . '/../../config/config.php';
if (!file_exists($configPath)) {
    die('❌ config.php not found at: ' . $configPath);
}
require_once $configPath;

if (!defined('APP_PATH')) {
    define('APP_PATH', __DIR__ . '/../app');
}

echo '<style>body{font-family:monospace;background:#0d1421;color:#e8f0fe;padding:30px;} .ok{color:#00d4aa;} .err{color:#ff5b5b;} .box{background:#111827;border:1px solid #1e3a5f;border-radius:8px;padding:16px;margin:10px 0;}</style>';
echo '<h2 style="color:#00d4aa;">🔍 HealthTracker DB Test</h2>';

// 1. Check constants
echo '<div class="box">';
echo '<b>Config:</b><br>';
echo defined('DB_HOST') ? '<span class="ok">✅ DB_HOST = ' . DB_HOST . '</span><br>' : '<span class="err">❌ DB_HOST not defined</span><br>';
echo defined('DB_NAME') ? '<span class="ok">✅ DB_NAME = ' . DB_NAME . '</span><br>' : '<span class="err">❌ DB_NAME not defined</span><br>';
echo defined('DB_USER') ? '<span class="ok">✅ DB_USER = ' . DB_USER . '</span><br>' : '<span class="err">❌ DB_USER not defined</span><br>';
echo '</div>';

// 2. Test PDO connection
echo '<div class="box"><b>PDO Connection:</b><br>';
try {
    $pdo = new PDO(
        'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4',
        DB_USER, DB_PASS,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
    echo '<span class="ok">✅ Connected to MySQL successfully!</span><br>';

    // 3. Check tables
    $tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
    echo '<br><b>Tables found:</b><br>';
    foreach (['users','health_records','medications','appointments'] as $t) {
        if (in_array($t, $tables)) {
            $count = $pdo->query("SELECT COUNT(*) FROM `$t`")->fetchColumn();
            echo "<span class='ok'>✅ $t ($count rows)</span><br>";
        } else {
            echo "<span class='err'>❌ $t — NOT FOUND</span><br>";
        }
    }

} catch (PDOException $e) {
    echo '<span class="err">❌ Connection failed: ' . $e->getMessage() . '</span>';
}
echo '</div>';

// 4. Check Model.php version
echo '<div class="box"><b>Model.php version:</b><br>';
$modelFile = APP_PATH . '/models/Model.php';
$content = file_get_contents($modelFile);
if (strpos($content, 'PDO') !== false) {
    echo '<span class="ok">✅ New PDO version is active</span>';
} else {
    echo '<span class="err">❌ Still using OLD session-based Model.php — replace it!</span>';
}
echo '</div>';

// 5. Test register insert
echo '<div class="box"><b>Test INSERT to users table:</b><br>';
try {
    $pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4', DB_USER, DB_PASS);
    $testEmail = 'test_' . time() . '@test.com';
    $stmt = $pdo->prepare("INSERT INTO users (full_name, email, password, role, allergies, plan) VALUES (?,?,?,?,?,?)");
    $stmt->execute(['Test User', $testEmail, md5('test123'), 'patient', 'None', 'Basic Member']);
    $newId = $pdo->lastInsertId();
    echo '<span class="ok">✅ INSERT works! New user ID: ' . $newId . '</span><br>';

    // Clean up test row
    $pdo->prepare("DELETE FROM users WHERE id = ?")->execute([$newId]);
    echo '<span class="ok">✅ Cleanup done (test row removed)</span>';
} catch (PDOException $e) {
    echo '<span class="err">❌ INSERT failed: ' . $e->getMessage() . '</span>';
}
echo '</div>';

echo '<br><p style="color:#4a6080;">Delete this file after testing: <code>public/test_db.php</code></p>';
