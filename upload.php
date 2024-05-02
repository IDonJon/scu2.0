<?php
$servername = "localhost"; // Nombre del servidor de la base de datos
$username = "root"; // Nombre de usuario de la base de datos
$password = ""; // Contraseña de la base de datos
$dbname = "myDB"; // Nombre de la base de datos

// Crear conexión con la base de datos
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar si la conexión fue exitosa
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Función para quitar tildes de una cadena
function quitar_tildes($cadena) {
    $no_permitidas = array("á", "é", "í", "ó", "ú", "Á", "É", "Í", "Ó", "Ú", "ñ", "Ñ", "ä", "ë", "ï", "ö", "ü", "Ä", "Ë", "Ï", "Ö", "Ü", " ");
    $permitidas = array("a", "e", "i", "o", "u", "A", "E", "I", "O", "U", "n", "N", "a", "e", "i", "o", "u", "A", "E", "I", "O", "U", " ");
    $texto = str_replace($no_permitidas, $permitidas, $cadena);
    return $texto;
}

try {
    if ($_FILES['file']['error'] > 0) {
        throw new Exception('Hubo un error al cargar el archivo: ' . $_FILES['file']['error']);
    }
    if (pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION) != 'csv') {
        throw new Exception('El archivo cargado no es un CSV');
    }
    if (($file = fopen($_FILES['file']['tmp_name'], 'r')) === FALSE) {
        throw new Exception('No se pudo abrir el archivo CSV');
    }
    while (($line = fgetcsv($file)) !== FALSE) {
        // Campos: dni, nombre, apellido y carrera
        $dni = $line[0];
        $nombre = $line[1];
        $apellido = $line[2];
        $carrera = $line[3];

        // Generar el correo electrónico
        $correo = $nombre . '.' . $apellido . '@unmsm.edu.pe';
        $correo = mb_strtolower($correo, 'UTF-8'); // Convertir a minúsculas
        $correo = quitar_tildes($correo);

        // Consulta SQL para insertar datos en la tabla "Estudiantes"
        $stmt = $conn->prepare("INSERT INTO Estudiantes (dni, nombre, apellido, carrera, correo) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $dni, $nombre, $apellido, $carrera, $correo);

        // Ejecutar la consulta
        $stmt->execute();
    }
    fclose($file);
    echo "Datos cargados exitosamente";
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
}
?>
