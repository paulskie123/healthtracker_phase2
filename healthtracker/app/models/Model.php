<?php
class Model {
    protected $db;

    public function __construct() {
        if (!isset($GLOBALS['_pdo'])) {
            try {
                $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4';
                $GLOBALS['_pdo'] = new PDO($dsn, DB_USER, DB_PASS, [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES   => false,
                ]);
            } catch (PDOException $e) {
                die('<div style="font-family:sans-serif;padding:30px;background:#1a0a0a;color:#ff6b6b;">
                    <h2>❌ Database Connection Failed</h2>
                    <p>' . $e->getMessage() . '</p>
                    <p>Check <code>config/config.php</code> — make sure DB_NAME=healthtracker, DB_USER=root, DB_PASS=</p>
                </div>');
            }
        }
        $this->db = $GLOBALS['_pdo'];
    }
}
