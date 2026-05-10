<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int) ($_POST['id'] ?? 0);

    if ($id > 0) {
        $stmt = $pdo->prepare("DELETE FROM tareas WHERE id = :id");
        $stmt->execute([':id' => $id]);
    }
}

header('Location: index.php');
exit;