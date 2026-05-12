<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre'] ?? '');

    if (!empty($nombre) && strlen($nombre) <= 255) {
        $stmt = $pdo->prepare("INSERT INTO tareas (nombre) VALUES (:nombre)");
        $stmt->execute([':nombre' => $nombre]);
    }
}

header('Location: index.php');
exit;