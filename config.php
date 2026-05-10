<?php

// Leer el archivo .env
$env = parse_ini_file(__DIR__ . '/.env');

$connection = $env['DB_CONNECTION'] ?? 'sqlite';

if ($connection === 'sqlite') {
    $dbPath = __DIR__ . '/' . $env['DB_DATABASE'];
    
    try {
        $pdo = new PDO('sqlite:' . $dbPath);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Crear tabla si no existe
        $pdo->exec("CREATE TABLE IF NOT EXISTS tareas (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            nombre TEXT NOT NULL,
            creado_en DATETIME DEFAULT CURRENT_TIMESTAMP
        )");

    } catch (PDOException $e) {
        die('Error de conexión SQLite: ' . $e->getMessage());
    }

} else {
    $host     = $env['DB_HOST'];
    $port     = $env['DB_PORT'] ?? 3306;
    $database = $env['DB_DATABASE'];
    $username = $env['DB_USERNAME'];
    $password = $env['DB_PASSWORD'];

    try {
        $pdo = new PDO("mysql:host=$host;port=$port;dbname=$database;charset=utf8", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Crear tabla si no existe
        $pdo->exec("CREATE TABLE IF NOT EXISTS tareas (
            id INT AUTO_INCREMENT PRIMARY KEY,
            nombre VARCHAR(255) NOT NULL,
            creado_en DATETIME DEFAULT CURRENT_TIMESTAMP
        )");

    } catch (PDOException $e) {
        die('Error de conexión MySQL: ' . $e->getMessage());
    }
}