<?php
session_start(); // Iniciar la sesión

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['username'])) {
    // Redirige al login si no hay un usuario en sesión
    header("Location: login.php");
    exit();
}

// Conexión a la base de datos
$mysqli = new mysqli('localhost', 'root', '', 'tasks_manager');

// Verifica la conexión
if ($mysqli->connect_error) {
    die("Conexión fallida: " . $mysqli->connect_error);
}

// Manejo de tareas
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        if ($_POST['action'] === 'add') {
            // Agregar tarea
            $task_name = $mysqli->real_escape_string($_POST['task_name']);
            $description = $mysqli->real_escape_string($_POST['description']);
            $user_id = (int)$_SESSION['user_id']; // Tomamos el ID del usuario desde la sesión

            $stmt = $mysqli->prepare("INSERT INTO tasks (task_name, description, status, user_id, created_at, updated_at) VALUES (?, ?, 'pending', ?, NOW(), NOW())");
            if ($stmt) {
                $stmt->bind_param("ssi", $task_name, $description, $user_id);
                if ($stmt->execute()) {
                    // Redirigir para evitar el reenvío del formulario
                    header("Location: " . $_SERVER['PHP_SELF']);
                    exit();
                } else {
                    echo "Error al añadir tarea: " . $stmt->error;
                }
                $stmt->close();
            } else {
                echo "Error en la preparación de la declaración: " . $mysqli->error;
            }
        } elseif ($_POST['action'] === 'delete') {
            // Eliminar tarea
            $task_id = (int)$_POST['task_id'];

            $stmt = $mysqli->prepare("DELETE FROM tasks WHERE id = ?");
            if ($stmt) {
                $stmt->bind_param("i", $task_id);
                if ($stmt->execute()) {
                    // Redirigir para evitar el reenvío del formulario
                    header("Location: " . $_SERVER['PHP_SELF']);
                    exit();
                } else {
                    echo "Error al eliminar tarea: " . $stmt->error;
                }
                $stmt->close();
            } else {
                echo "Error en la preparación de la declaración: " . $mysqli->error;
            }
        } elseif ($_POST['action'] === 'complete') {
            // Marcar tarea como completa
            $task_id = (int)$_POST['task_id'];

            $stmt = $mysqli->prepare("UPDATE tasks SET status = 'completed', updated_at = NOW() WHERE id = ?");
            if ($stmt) {
                $stmt->bind_param("i", $task_id);
                if ($stmt->execute()) {
                    // Redirigir para evitar el reenvío del formulario
                    header("Location: " . $_SERVER['PHP_SELF']);
                    exit();
                } else {
                    echo "Error al marcar tarea como completa: " . $stmt->error;
                }
                $stmt->close();
            } else {
                echo "Error en la preparación de la declaración: " . $mysqli->error;
            }
        }
    }
}

// Mostrar tareas asociadas al usuario que ya inicio sesion
$user_id = (int)$_SESSION['user_id']; 
$result = $mysqli->query("SELECT id, task_name, description, status, user_id, created_at FROM tasks WHERE user_id = $user_id");

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styletask.css"> <!-- Asegúrate de que la ruta sea correcta -->
    <title>Task Manager</title>
</head>
<body>
    <div class="task-manager">
        <h1>Hola, <?php echo htmlspecialchars($_SESSION['username']); ?></h1>
        
      
<div class="logout">
    <form action="logout.php" method="POST">
        <button type="submit" class="logout-btn">Cerrar Sesión</button>
    </form>
</div>
        
        <h2>Añadir Tarea</h2>
        <div class="add-task">
            <form action="" method="POST">
                <input type="text" name="task_name" placeholder="Nombre de la tarea" required>
                <input type="text" name="description" placeholder="Descripción" required>
                <input type="hidden" name="action" value="add">
                <button type="submit">Añadir</button>
            </form>
        </div>

        <h2>Tareas</h2>
        <ul class="task-list">
            <?php while ($row = $result->fetch_assoc()): ?>
                <li class="task-item <?php echo ($row['status'] === 'completed') ? 'completed' : ''; ?>">
                    <div class="task-content">
                        <strong><?php echo htmlspecialchars($row['task_name']); ?></strong><br>
                        <?php echo htmlspecialchars($row['description']); ?><br>
                        <em><?php echo htmlspecialchars($row['status']); ?></em>
                    </div>
                    <div class="task-actions">
                        <form action="" method="POST" style="display:inline;">
                            <input type="hidden" name="task_id" value="<?php echo $row['id']; ?>">
                            <input type="hidden" name="action" value="complete">
                            <button class="complete-btn" type="submit">Completar</button>
                        </form>
                        <form action="" method="POST" style="display:inline;">
                            <input type="hidden" name="task_id" value="<?php echo $row['id']; ?>">
                            <input type="hidden" name="action" value="delete">
                            <button class="delete-btn" type="submit">Eliminar</button>
                        </form>
                    </div>
                </li>
            <?php endwhile; ?>
        </ul>
    </div>
</body>
</html>

<?php
// Cierra la conexión
$mysqli->close();
?>
