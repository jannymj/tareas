<?php
/**
 * Función: sanitizeInput
 * 
 * Propósito:
 * Esta función limpia y sanitiza una cadena de entrada eliminando espacios innecesarios y convirtiendo caracteres especiales en entidades HTML.
 * 
 * Lógica:
 * - La función recibe un dato ($data).
 * - Usa la función `trim()` para eliminar espacios en blanco al principio y al final de la cadena.
 * - Usa `htmlspecialchars()` para convertir caracteres especiales (como '<' y '>') en entidades HTML seguras, evitando ataques de inyección de código como XSS (Cross-Site Scripting).
 * 
 * @param string $data - El dato que se desea limpiar.
 * @return string - La cadena limpia y segura.
 */
function sanitizeInput($data) {
    return htmlspecialchars(trim($data));
}

/**
 * Función: checkLogin
 * 
 * Propósito:
 * Verifica si un usuario ha iniciado sesión revisando si existe la variable de sesión `user_id`. Si no existe, redirige al archivo `login.php`.
 * 
 * Lógica:
 * - Inicia o reanuda una sesión usando `session_start()`.
 * - Verifica si la variable de sesión `user_id` está establecida. Si no lo está, se redirige al usuario a la página de inicio de sesión con la función `header()`.
 * - La función `exit()` garantiza que se detenga la ejecución después de la redirección.
 */
function checkLogin() {
    session_start();
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit();
    }
}

/**
 * Función: redirectWithMessage
 * 
 * Propósito:
 * Redirige a una página específica mientras guarda un mensaje en la variable de sesión `flash_message` para mostrarlo posteriormente.
 * 
 * Lógica:
 * - Inicia o reanuda una sesión con `session_start()`.
 * - Almacena el mensaje proporcionado en la variable de sesión `flash_message`.
 * - Redirige a la ubicación especificada en el parámetro `$location` utilizando `header()`.
 * - Finaliza la ejecución del script con `exit()` para asegurar que no se ejecute más código.
 * 
 * @param string $location - La página a la que se redirige.
 * @param string $message - El mensaje que se almacenará y se mostrará después de la redirección.
 */
function redirectWithMessage($location, $message) {
    session_start();
    $_SESSION['flash_message'] = $message;
    header("Location: $location");
    exit();
}

/**
 * Función: displayFlashMessage
 * 
 * Propósito:
 * Muestra un mensaje almacenado en la variable de sesión `flash_message` y lo elimina después de haber sido mostrado.
 * 
 * Lógica:
 * - Verifica si existe una variable de sesión `flash_message`.
 * - Si existe, muestra el mensaje dentro de un `div` con clase `message`.
 * - Después de mostrar el mensaje, se elimina la variable de sesión usando `unset()` para evitar que se vuelva a mostrar en futuras páginas.
 */
function displayFlashMessage() {
    if (isset($_SESSION['flash_message'])) {
        echo "<div class='message'>" . $_SESSION['flash_message'] . "</div>";
        unset($_SESSION['flash_message']);
    }
}

/**
 * Función: isFieldEmpty
 * 
 * Propósito:
 * Verifica si un campo está vacío, ignorando espacios en blanco.
 * 
 * Lógica:
 * - La función recibe el valor de un campo.
 * - Usa `trim()` para eliminar espacios al principio y al final del campo.
 * - Luego utiliza `empty()` para verificar si el campo está vacío después de eliminar los espacios.
 * 
 * @param string $field - El campo que se desea verificar.
 * @return bool - Devuelve `true` si el campo está vacío, `false` si contiene datos.
 */
function isFieldEmpty($field) {
    return empty(trim($field));
}

/**
 * Función: isValidEmail
 * 
 * Propósito:
 * Verifica si una cadena de texto es un correo electrónico válido usando la función integrada de PHP `filter_var()`.
 * 
 * Lógica:
 * - Usa `filter_var()` con el filtro `FILTER_VALIDATE_EMAIL`, que comprueba si la cadena cumple con el formato estándar de correo electrónico.
 * - Si el correo es válido, la función devuelve `true`. Si no, devuelve `false`.
 * 
 * @param string $email - El correo electrónico que se desea validar.
 * @return bool - Devuelve `true` si el correo es válido, `false` si no lo es.
 */
function isValidEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

/**
 * Función: fetchSingleRow
 * 
 * Propósito:
 * Ejecuta una consulta SQL y devuelve una única fila de resultados en forma de un array asociativo.
 * 
 * Lógica:
 * - Ejecuta una consulta SQL usando `$conn->query($query)` que devuelve un objeto de resultado.
 * - Verifica si la consulta devolvió al menos una fila (`$result->num_rows > 0`).
 * - Si hay resultados, devuelve la primera fila de resultados como un array asociativo usando `fetch_assoc()`.
 * - Si no hay resultados, devuelve `null`.
 * 
 * @param object $conn - La conexión a la base de datos (objeto mysqli).
 * @param string $query - La consulta SQL a ejecutar.
 * @return array|null - Devuelve un array asociativo con la fila de resultados o `null` si no hay resultados.
 */
function fetchSingleRow($conn, $query) {
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    } else {
        return null;
    }
}
?>
