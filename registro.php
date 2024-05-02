<!DOCTYPE html>
<html>
<head>
    <title>Registro</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="login-container">

    <form method="post" action="registrar.php">
        <label for="username">Nombre de usuario:</label><br>
        <input type="text" id="username" name="username"><br>
        <label for="password">Contraseña:</label><br>
        <input type="password" id="password" name="password"><br>
        <label for="role">Rol:</label><br>
        <select id="role" name="role">
            <option value="0">Usuario</option>
            <option value="1">Administrador</option>
        </select><br>
        <input type="submit" value="Registrarse">
    </form>
</div>
</body>
</html>
