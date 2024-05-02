<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['user_id'])) {
    // Si el usuario no ha iniciado sesión, redirigir a la página de inicio de sesión
    header('Location: index.php');
    exit;
}

// A partir de aquí, puedes agregar el resto de tu código HTML
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de Estudiantes</title>
    <link rel="stylesheet" href="styles.css"> <!-- Enlace a la hoja de estilos externa -->
</head>
<body>
<div class="container">
    <!-- Sección para la "Consulta de Estudiantes" -->
    <h1>Consulta de Estudiantes</h1>
    <form id="consultaForm">
        <label for="dniInput">Ingrese DNI o código de estudiante:</label>
        <input type="text" id="dniInput" name="dniInput" required>
        <button type="submit">Consultar</button>
    </form>
    <div id="resultContainer" style="display:none;">
        <!-- Contenedor oculto para mostrar los resultados de la consulta -->
        <h2>Resultado:</h2>
        <table id="resultTable"></table>
        <button id="resetButton" type="button">Nueva consulta</button>
    </div>
</div>

<div class="container">
    <!-- Sección para la "Carga masiva" -->
    <h1>Carga masiva</h1>
    <form id="uploadForm" enctype="multipart/form-data">
        <label for="file">Selecciona un archivo CSV:</label>
        <input type="file" id="file" name="file" accept=".csv" required>
        <button type="submit">Mostrar</button>
        <button id="confirmButton" type="button" style="display:none;">Confirmar carga</button>
    </form>
    <div id="tableContainer"></div> <!-- Contenedor para mostrar una tabla -->
</div>

<!-- Botón de logout -->
<form action="index.php" method="post">
    <button type="submit">Logout</button>
</form>

<script src="script.js"></script> <!-- Enlace al archivo JavaScript -->
</body>
</html>
