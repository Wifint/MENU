<?php
header('Content-Type: text/plain; charset=utf-8');
require_once 'db_config.php';

echo "--- DEBUG INFO ---\n";
echo "PHP Version: " . phpversion() . "\n";
echo "Database path: " . DB_FILE . "\n";
echo "Database folder: " . dirname(DB_FILE) . "\n";
echo "Database file exists: " . (file_exists(DB_FILE) ? "YES" : "NO") . "\n";
echo "Database size: " . (file_exists(DB_FILE) ? filesize(DB_FILE) : "N/A") . " bytes\n";

try {
    $pdo = getDBConnection();
    echo "Connection: SUCCESS\n";
    
    $stmt = $pdo->query("SELECT name FROM sqlite_master WHERE type='table'");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    echo "Tables found: " . implode(', ', $tables) . "\n";
    
    foreach ($tables as $table) {
        $count = $pdo->query("SELECT COUNT(*) FROM $table")->fetchColumn();
        echo "Table $table: $count records\n";
    }
    
} catch (Exception $e) {
    echo "Connection: FAILED\n";
    echo "Error: " . $e->getMessage() . "\n";
}
