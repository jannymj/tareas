<?php
session_start(); // Iniciar la sesión

// Destruir todas las variables de sesión
$_SESSION = array();

// Si se desea, se puede destruir la sesión en el servidor
session_destroy();

// Redirigir al formulario de registro
header("Location: register.php");
exit();
?>
