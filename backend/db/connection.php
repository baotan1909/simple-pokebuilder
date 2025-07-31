<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$dbPath = $_ENV['DB_PATH'];
$initStmtPath = $_ENV['DB_INIT_PATH'];

try {
    $isNewDb = !file_exists($dbPath);
    $isIniStmtExist = file_exists($initStmtPath);
    $pdo = new PDO("sqlite:" . $dbPath);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $pdo->exec("PRAGMA foreign_keys = ON;");

    if ($isNewDb && !$isIniStmtExist) {
        throw new Exception("SQL schema file not found at: $initStmtPath");
    }

    if ($isNewDb) {
        $schema = file_get_contents($initStmtPath);
        $pdo->exec($schema);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'error' => 'Database initialization failed.',
        'details' => $e->getMessage()
    ]);
    exit;
}