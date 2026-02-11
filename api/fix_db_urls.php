<?php
/**
 * Script para corregir las URLs en la base de datos tras la reorganización de carpetas.
 * Las páginas del dashboard ahora están en /pages/, por lo que las URLs de los protocolos
 * deben apuntar a ../manuales/archivo.html para que funcionen correctamente.
 */

require_once 'db_config.php';

try {
    $pdo = getDBConnection();
    echo "Conexión a la base de datos exitosa.\n";

    // Actualizar URLs de protocolos
    // manualfinal.html -> ../manuales/manualfinal.html
    // manual2.html -> ../manuales/manual2.html
    // manual3.html -> ../manuales/manual3.html

    $updates = [
        'manualfinal.html' => '../manuales/manualfinal.html',
        'manual2.html' => '../manuales/manual2.html',
        'manual3.html' => '../manuales/manual3.html'
    ];

    $stmt = $pdo->prepare("UPDATE protocolos SET url = ? WHERE url = ?");

    foreach ($updates as $old => $new) {
        $stmt->execute([$new, $old]);
        echo "Actualizado: $old -> $new (" . $stmt->rowCount() . " filas)\n";
    }

    echo "Corrección completada.\n";

} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}
