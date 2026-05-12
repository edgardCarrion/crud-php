<?php
require_once 'config.php';

// Debug temporal
$env = parse_ini_file(__DIR__ . '/.env');
echo "Conexión: " . $env['DB_CONNECTION'] . "<br>";
echo "Base de datos: " . $env['DB_DATABASE'] . "<br>";
// Debug temporal
var_dump(file_exists(__DIR__ . '/.env'));
var_dump(parse_ini_file(__DIR__ . '/.env'));
// Obtener todas las tareas
$tareas = $pdo->query("SELECT * FROM tareas ORDER BY creado_en DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Tareas</title>
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
            gap: 10px;
            margin-bottom: 20px;
        }
        input[type="text"] {
            flex: 1;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
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
        ul {
            list-style: none;
            padding: 0;
        }
        li {
            background: white;
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 4px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        .eliminar {
            background: #e74c3c;
            padding: 6px 12px;
            font-size: 14px;
        }
        .eliminar:hover { background: #c0392b; }
        .vacio {
            text-align: center;
            color: #999;
            padding: 20px;
        }
    </style>
</head>
<body>

    <h1>📝 Lista de Tareas</h1>

    <form action="crear.php" method="POST">
        <input type="text" name="nombre" placeholder="Nueva tarea..." required>
        <button type="submit">Agregar</button>
    </form>

    <ul>
        <?php if (empty($tareas)): ?>
            <p class="vacio">No hay tareas aún. ¡Agrega una!</p>
        <?php else: ?>
            <?php foreach ($tareas as $tarea): ?>
                <li>
                    <span><?= htmlspecialchars($tarea['nombre']) ?></span>
                    <form action="eliminar.php" method="POST">
                        <input type="hidden" name="id" value="<?= $tarea['id'] ?>">
                        <button class="eliminar" type="submit">Eliminar</button>
                    </form>
                </li>
            <?php endforeach; ?>
        <?php endif; ?>
    </ul>

</body>
</html>