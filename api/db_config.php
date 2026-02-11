<?php
/**
 * Database Configuration (SQLite version for Vercel)
 */

// Ruta al archivo de base de datos SQLite (ahora un nivel arriba)
define('DB_FILE', __DIR__ . '/../tecnet.sqlite');

/**
 * Obtiene una conexión PDO a la base de datos SQLite
 * 
 * @return PDO
 * @throws PDOException
 */
function getDBConnection() {
    try {
        $dsn = "sqlite:" . DB_FILE;
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        
        $pdo = new PDO($dsn, null, null, $options);
        return $pdo;
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'error' => 'Error de conexión a la base de datos SQLite'
        ]);
        exit;
    }
}

/**
 * Envía una respuesta JSON
 */
function sendJSONResponse($data, $statusCode = 200) {
    http_response_code($statusCode);
    header('Content-Type: application/json; charset=utf-8');
    header('Access-Control-Allow-Origin: *');
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit;
}
