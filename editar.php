<?php
require_once 'config.php';

$id = (int) ($_GET['id'] ?? 0);

if ($id <= 0) {
    header('Location: index.php');
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM tareas WHERE id = :id");
$stmt->execute([':id' => $id]);
$tarea = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$tarea) {
    header('Location: index.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre'] ?? '');

    if (empty($nombre)) {
        $error = 'El nombre no puede estar vacío.';
    } elseif (strlen($nombre) > 255) {
        $error = 'El nombre no puede superar los 255 caracteres.';
    } else {
        $stmt = $pdo->prepare("UPDATE tareas SET nombre = :nombre WHERE id = :id");
        $stmt->execute([':nombre' => $nombre, ':id' => $id]);
        header('Location: index.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Tarea</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 600px;
            margin: 40px auto;
            padding: 0 20px;
            background: #f5f5f5;
        }
        h1 { color: #333; }
        form {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        input[type="text"] {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }
        .botones {
            display: flex;
            gap: 10px;
        }
        button {
            padding: 10px 20px;
            background: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover { background: #45a049; }
        a.cancelar {
            padding: 10px 20px;
            background: #999;
            color: white;
            border-radius: 4px;
            text-decoration: none;
            font-size: 16px;
        }
        a.cancelar:hover { background: #777; }
        .error {
            color: #e74c3c;
            font-size: 14px;
        }
    </style>
</head>
<body>

    <h1>Editar Tarea</h1>

    <?php if ($error): ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form action="editar.php?id=<?= $id ?>" method="POST">
        <input type="text" name="nombre" value="<?= htmlspecialchars($tarea['nombre']) ?>" maxlength="255" required>
        <div class="botones">
            <button type="submit">Guardar</button>
            <a class="cancelar" href="index.php">Cancelar</a>
        </div>
    </form>

</body>
</html>
