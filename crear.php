<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre'] ?? '');

    if (!empty($nombre)) {
        $stmt = $pdo->prepare("INSERT INTO tareas (nombre) VALUES (:nombre)");
        $stmt->execute([':nombre' => $nombre]);
    }
}

header('Location: index.php');
exit;