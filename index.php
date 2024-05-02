<?php
session_start();

// Verificar si el usuario ha solicitado cerrar sesión
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Destruir todas las variables de sesión.
    $_SESSION = array();

    // Borrar también las cookies de sesión.
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }

    // Finalmente, destruir la sesión.
    session_destroy();

    // Redirigir al usuario a la página de inicio de sesión
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Iniciar sesión</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="login-container">

    <form method="post" action="validar.php">
        <label for="username">Nombre de usuario:</label><br>
        <input type="text" id="username" name="username"><br>
        <label for="password">Contraseña:</label><br>
        <input type="password" id="password" name="password"><br>
        <input type="submit" value="Iniciar sesión">
    </form>
    <p>¿No tienes una cuenta? <a href="registro.php">Regístrate aquí</a></p>
</div>
</body>
</html>
