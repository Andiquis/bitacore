<?php
try {
    $db = new PDO('sqlite:bitacora.db');

    // Crear la tabla si no existe
    $db->exec("CREATE TABLE IF NOT EXISTS bitacora (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        fecha TEXT NOT NULL,
        titulo TEXT NOT NULL,
        subtemas TEXT,
        contenido TEXT NOT NULL
    )");

    echo "Base de datos creada y tabla 'bitacora' lista para su uso.";
} catch (PDOException $e) {
    echo "Error al crear la base de datos: " . $e->getMessage();
}
?>
