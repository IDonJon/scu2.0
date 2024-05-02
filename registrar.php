<?php
$dbHost = "localhost"; // Nombre del servidor de la base de datos
$dbUser = "root"; // Nombre de usuario de la base de datos
$dbPass = ""; // Contraseña de la base de datos
$dbName = "myDB"; // Nombre de la base de datos

$conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);
if ($conn->connect_error) {
    die('Error de conexión: ' . $conn->connect_error);
}

// Registrar al usuario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Encriptar la contraseña
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (username, password_hash, role) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssi', $username, $password_hash, $role);
    $stmt->execute();

    if ($stmt->affected_rows === 1) {
        // Registro exitoso
        header('Location: index.php?registro=1');
        exit;
    } else {
        // Error en el registro
        header('Location: registro.php?error=1');
        exit;
    }
} else {
    // Maneja otros métodos HTTP según sea necesario
    http_response_code(405); // Método no permitido
    echo 'Método no permitido';
}
?>
