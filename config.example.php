<?php
// config.example.php

/**
 * Este es un archivo de ejemplo con datos inventados.
 * Para configurar tu aplicación local:
 * 1. Renombra este archivo a config.php
 * 2. Personaliza los datos de conexión si fuera necesario (por defecto usa SQLite)
 */

$db_file = __DIR__ . '/database.sqlite';
$is_new_db = !file_exists($db_file);

try {
    $pdo = new PDO("sqlite:" . $db_file);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Lógica de inicialización de la base de datos...
    if ($is_new_db) {
        // ... (el código real se encargará de crear las tablas)
    }
} catch (PDOException $e) {
    die("Error de conexión a la base de datos: " . $e->getMessage());
}

// Ejemplo de otras variables que podrían ser necesarias en el futuro
// define('APP_URL', 'http://localhost/tu-proyecto');
// define('ADMIN_USER', 'admin');
// define('ADMIN_PASS', 'password123');
?>
