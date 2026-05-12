<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre'] ?? '');

    if (empty($nombre)) {
        header('Location: index.php?error=vacio');
        exit;
    }

    if (strlen($nombre) > 255) {
        header('Location: index.php?error=largo');
        exit;
    }

    try {
        $stmt = $pdo->prepare("INSERT INTO tareas (nombre) VALUES (:nombre)");
        $stmt->execute([':nombre' => $nombre]);

        if ($stmt->rowCount() === 0) {
            header('Location: index.php?error=noguardado');
            exit;
        }
    } catch (Exception $e) {
        header('Location: index.php?error=db');
        exit;
    }
}

header('Location: index.php');
exit;
