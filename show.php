<?php
// Función para quitar tildes de una cadena
function quitar_tildes($cadena) {
    $no_permitidas = array("á", "é", "í", "ó", "ú", "Á", "É", "Í", "Ó", "Ú", "ñ", "Ñ", "ä", "ë", "ï", "ö", "ü", "Ä", "Ë", "Ï", "Ö", "Ü");
    $permitidas = array("a", "e", "i", "o", "u", "A", "E", "I", "O", "U", "n", "N", "a", "e", "i", "o", "u", "A", "E", "I", "O", "U");
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

    // Crear una tabla HTML para mostrar los datos
    $table = '<table>';
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
        $correo = quitar_tildes($correo); // Quitar tildes

        // Agregar fila a la tabla
        $table .= '<tr>';
        $table .= '<td>' . htmlspecialchars($dni) . '</td>';
        $table .= '<td>' . htmlspecialchars($nombre) . '</td>';
        $table .= '<td>' . htmlspecialchars($apellido) . '</td>';
        $table .= '<td>' . htmlspecialchars($carrera) . '</td>';
        $table .= '<td>' . htmlspecialchars($correo) . '</td>';
        $table .= '</tr>';
    }
    fclose($file);
    $table .= '</table>';
    echo $table;
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
}
?>
