<?php
session_start();

// Inicializar variable de error
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Captura los valores del formulario
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Conexión a la base de datos
    $conn = new mysqli("localhost", "root", "", "tasks_manager");

    // Verificar la conexión
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Buscar al usuario en la base de datos
    $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        // Verificar la contraseña
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            // Redirigir al Task Manager
            header("Location: task_manager.php");
            exit();
        } else {
            $error = "Contraseña incorrecta.";
        }
    } else {
        $error = "Usuario no encontrado."; 
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PANTALLA DE LOGIN</title>
    <link rel="stylesheet" href="styleslogin.css"> 
</head>
<body>

<div class="login-container">
    <h2>Iniciar Sesión</h2>
    <form action="login.php" method="POST">
        
        <?php if (!empty($error)): ?>
            <p class="error-message"><?php echo $error; ?></p>
        <?php endif; ?>

        <label for="username">Nombre de Usuario:</label>
        <input type="text" id="username" name="username" required placeholder="Ingrese su usuario">

        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" required placeholder="Ingrese su contraseña">

        <button type="submit">Entrar</button>
    </form>
</div>

</body>
</html>
