<?php
/**
 * API Endpoint para Circulares
 * 
 * Parámetros GET:
 * - page: Número de página (default: 1)
 * - limit: Registros por página (default: 10)
 * 
 * Respuesta JSON:
 * {
 *   "success": true,
 *   "data": [...],
 *   "pagination": {
 *     "current_page": 1,
 *     "per_page": 10,
 *     "total_records": 100,
 *     "total_pages": 10,
 *     "from": 1,
 *     "to": 10
 *   }
 * }
 */

require_once 'db_config.php';

// Obtener parámetros
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$limit = isset($_GET['limit']) ? max(1, min(100, intval($_GET['limit']))) : 10;

// Calcular offset
$offset = ($page - 1) * $limit;

try {
    $pdo = getDBConnection();
    
    // Obtener el total de registros
    $countStmt = $pdo->query("SELECT COUNT(*) as total FROM circulares");
    $totalRecords = $countStmt->fetch()['total'];
    
    // Calcular total de páginas
    $totalPages = ceil($totalRecords / $limit);
    
    // Validar que la página solicitada existe
    if ($page > $totalPages && $totalPages > 0) {
        sendJSONResponse([
            'success' => false,
            'error' => 'Página fuera de rango'
        ], 400);
    }
    
    // Obtener los registros paginados
    $stmt = $pdo->prepare("
        SELECT 
            id,
            titulo,
            descripcion,
            url,
            fecha_creacion
        FROM circulares
        ORDER BY fecha_creacion DESC
        LIMIT :limit OFFSET :offset
    ");
    
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    
    $data = $stmt->fetchAll();
    
    // Calcular registros "from" y "to"
    $from = $totalRecords > 0 ? $offset + 1 : 0;
    $to = min($offset + $limit, $totalRecords);
    
    // Enviar respuesta
    sendJSONResponse([
        'success' => true,
        'data' => $data,
        'pagination' => [
            'current_page' => $page,
            'per_page' => $limit,
            'total_records' => $totalRecords,
            'total_pages' => $totalPages,
            'from' => $from,
            'to' => $to
        ]
    ]);
    
} catch (Exception $e) {
    sendJSONResponse([
        'success' => false,
        'error' => 'Error al obtener los datos'
    ], 500);
}
