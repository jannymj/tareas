<?php
session_start(); // Inicia la sesión
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
    <link rel="stylesheet" href="stylesregister.css"> <!-- Vincula el archivo CSS externo -->
</head>
<body>

<div class="login-container">
    <h2>Registro de Usuario</h2>
    <form action="" method="POST">
        <?php if (isset($error)): ?>
            <p style="color: red;"><?php echo $error; ?></p>
        <?php endif; ?>

        <label for="username">Nombre de Usuario:</label>
        <input type="text" id="username" name="username" required placeholder="Ingrese su nombre de usuario">

        <label for="email">Correo Electrónico:</label>
        <input type="email" id="email" name="email" required placeholder="ejemplo@correo.com">

        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" required placeholder="Crea una contraseña">

        <label for="confirm_password">Confirmar Contraseña:</label>
        <input type="password" id="confirm_password" name="confirm_password" required placeholder="Confirma tu contraseña">

        <button type="submit">Registrarse</button>
    </form>

    <div class="forgot-password">
        <p>¿Ya tienes una cuenta? <a href="login.php">Iniciar Sesión</a></p>
    </div>
</div>

</body>
</html>
