<?php
$dbHost = "localhost"; // Nombre del servidor de la base de datos
$dbUser = "root"; // Nombre de usuario de la base de datos
$dbPass = ""; // Contraseña de la base de datos
$dbName = "myDB"; // Nombre de la base de datos

$conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);
if ($conn->connect_error) {
    die('Error de conexión: ' . $conn->connect_error);
}

// Verificar las credenciales del usuario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT id, username, password_hash, role FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password_hash'])) {
            // Inicio de sesión exitoso
            session_start();
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['role'] = $row['role'];
            header('Location: principal.php');
            exit;
        } else {
            // Contraseña incorrecta
            header('Location: index.php?error=1');
            exit;
        }
    } else {
        // Usuario no encontrado
        header('Location: index.php?error=2');
        exit;
    }
} else {
    // Maneja otros métodos HTTP según sea necesario
    http_response_code(405); // Método no permitido
    echo 'Método no permitido';
}
?>
