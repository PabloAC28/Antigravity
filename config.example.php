<?php
// config.example.php

/**
 * Este es un archivo de ejemplo con datos inventados.
 * Para configurar tu aplicación local:
 * 1. Renombra este archivo a config.php
 * 2. Personaliza los datos de conexión si fuera necesario (por defecto usa SQLite)
 */

// Configuración de la base de datos MySQL
$db_host = 'localhost';
$db_name = 'alumno7'; // Tu nombre de base de datos en el servidor
$db_user = 'alumno7'; // Tu usuario de MySQL
$db_pass = 'TU_CONTRASEÑA_AQUÍ'; // Cambia esto por tu contraseña real en el servidor

try {
    $dsn = "mysql:host=$db_host;dbname=$db_name;charset=utf8mb4";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    $pdo = new PDO($dsn, $db_user, $db_pass, $options);
} catch (PDOException $e) {
    die("Error de conexión a la base de datos: " . $e->getMessage());
}
?>
