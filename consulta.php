<?php
$servername = "localhost"; // Nombre del servidor de la base de datos
$username = "root"; // Nombre de usuario de la base de datos
$password = ""; // Contraseña de la base de datos
$dbname = "myDB"; // Nombre de la base de datos

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
  die("Conexión fallida: " . $conn->connect_error); // Mostrar mensaje de error si la conexión falla
}

$dni = $_POST['dni']; // Obtener el valor del DNI enviado mediante un formulario POST

$sql = "SELECT * FROM Estudiantes WHERE dni = '$dni'"; // Consulta SQL para seleccionar estudiantes con el DNI proporcionado
$result = $conn->query($sql); // Ejecutar la consulta y almacenar los resultados en la variable $result

if ($result->num_rows > 0) {
  // Mostrar datos de cada fila
  while($row = $result->fetch_assoc()) {
    echo json_encode($row); // Mostrar los datos en formato JSON
  }
} else {
  echo "0 resultados"; // Mostrar mensaje si no se encontraron resultados
}
$conn->close(); // Cerrar la conexión a la base de datos
?>
