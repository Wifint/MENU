<?php
/**
 * Herramienta para añadir nuevas circulares a la base de datos.
 */
require_once 'db_config.php';

$message = '';
$status = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'] ?? '';
    $descripcion = $_POST['descripcion'] ?? '';
    $url = $_POST['url'] ?? '';

    if (!empty($titulo) && !empty($url)) {
        try {
            $pdo = getDBConnection();
            $stmt = $pdo->prepare("INSERT INTO circulares (titulo, descripcion, url) VALUES (?, ?, ?)");
            $stmt->execute([$titulo, $descripcion, $url]);
            
            $message = "✅ Circular añadida con éxito: " . htmlspecialchars($titulo);
            $status = 'success';
        } catch (Exception $e) {
            $message = "❌ Error al añadir la circular: " . $e->getMessage();
            $status = 'error';
        }
    } else {
        $message = "⚠️ El título y la URL son obligatorios.";
        $status = 'warning';
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Añadir Nueva Circular</title>
    <style>
        body { font-family: sans-serif; max-width: 600px; margin: 40px auto; padding: 20px; line-height: 1.6; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input[type="text"], textarea { width: 100%; padding: 8px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px; }
        button { background: #0056b3; color: white; padding: 10px 15px; border: none; border-radius: 4px; cursor: pointer; }
        button:hover { background: #004494; }
        .alert { padding: 10px; margin-bottom: 20px; border-radius: 4px; }
        .success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .warning { background: #fff3cd; color: #856404; border: 1px solid #ffeeba; }
        .back-link { display: block; margin-top: 20px; color: #0056b3; text-decoration: none; }
    </style>
</head>
<body>
    <h1>Añadir Nueva Circular</h1>
    
    <?php if ($message): ?>
        <div class="alert <?php echo $status; ?>">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>

    <form method="POST">
        <div class="form-group">
            <label for="titulo">Título de la Circular:</label>
            <input type="text" id="titulo" name="titulo" required placeholder="Ej: Circular 056-A ...">
        </div>
        <div class="form-group">
            <label for="descripcion">Descripción (opcional):</label>
            <textarea id="descripcion" name="descripcion" rows="3" placeholder="Breve resumen del contenido..."></textarea>
        </div>
        <div class="form-group">
            <label for="url">URL del Documento:</label>
            <input type="text" id="url" name="url" required placeholder="https://docs.google.com/document/d/.../pub">
        </div>
        <button type="submit">Añadir Circular</button>
    </form>

    <a href="../pages/circulares.html" class="back-link">← Volver al listado</a>
</body>
</html>
