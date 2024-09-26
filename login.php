<?php
session_start(); // Inicia la sesión

// Verifica si el formulario fue enviado mediante el método POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Captura los valores del formulario
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Verifica si los campos son correctos
    if ($email === 'nombre@cesun.edu.mx' && $password === '12345') {
        // Almacena la variable de sesión para indicar que el usuario inició sesión correctamente
        $_SESSION['loggedin'] = true;

        // Redirige al archivo donde se encuentra el tablero de tareas
        header('Location: task.html');
        exit();
    } else {
        // Si los datos son incorrectos, muestra un mensaje de error
        $error = "Correo o contraseña inválidos";
    }
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
    <form action="" method="POST">
        <?php if (isset($error)): ?>
            <p style="color: red;"><?php echo $error; ?></p> <!-- Mensaje de error en rojo -->
        <?php endif; ?>

        <label for="email">Correo Electrónico:</label>
        <input type="email" id="email" name="email" required placeholder="ejemplo@correo.com">

        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" required placeholder="Ingresa tu contraseña">

        <button type="submit">Entrar</button>
    </form>

    <div class="forgot-password">
        <p>¿Olvidaste tu contraseña? <a href="#">Recupérala aquí</a></p>
    </div>
</div>

</body>
</html>
