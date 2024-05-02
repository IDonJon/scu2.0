// Variable para almacenar el archivo cargado
var fileToUpload;

// Manejar el envío de la carga del archivo para mostrarlo
document.getElementById('uploadForm').addEventListener('submit', function(event) {
    event.preventDefault();
    var formData = new FormData(event.target);
    fileToUpload = formData.get('file');
    fetch('show.php', {
        method: 'POST',
        body: formData
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Error de red al intentar cargar el archivo');
        }
        return response.text();
    })
    .then(data => {
        // Mostrar los datos en una tabla dentro del elemento con ID 'tableContainer'
        document.getElementById('tableContainer').innerHTML = data;
        // Mostrar el botón de confirmación
        document.getElementById('confirmButton').style.display = 'block';
    })
    .catch(error => {
        console.error('Error:', error);
    });
});

// Manejar el clic en el botón de confirmación para cargar el archivo a la base de datos
document.getElementById('confirmButton').addEventListener('click', function() {
    var formData = new FormData();
    formData.append('file', fileToUpload);
    fetch('upload.php', {
        method: 'POST',
        body: formData
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Error de red al intentar cargar el archivo');
        }
        return response.text();
    })
    .then(data => {
        // Mostrar una alerta con la respuesta del servidor
        alert(data);
        // Ocultar el botón de confirmación
        document.getElementById('confirmButton').style.display = 'none';
    })
    .catch(error => {
        console.error('Error:', error);
    });
});



// Refrescar consulta
document.getElementById('resetButton').addEventListener('click', function() {
    // Limpia el contenido de la tabla
    document.getElementById('resultTable').innerHTML = '';
    // Oculta el contenedor de resultados
    document.getElementById('resultContainer').style.display = 'none';
});

//Realizar consulta de alumno
document.getElementById('consultaForm').addEventListener('submit', function(event) {
    event.preventDefault();
    
    var dni = document.getElementById('dniInput').value;

    // Crear un objeto FormData para enviar los datos del formulario
    var formData = new FormData();
    formData.append('dni', dni);

    // Crear una solicitud AJAX
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'consulta.php', true);

    // Configurar la función de respuesta
    xhr.onload = function () {
        if (xhr.status === 200) {
            // Parsear la respuesta JSON
            var datos = JSON.parse(xhr.responseText);

            var resultadoHTML = '';

            for (var key in datos) {
                resultadoHTML += `<tr><td>${key}</td><td>${datos[key]}</td></tr>`;
            }

            document.getElementById('resultTable').innerHTML = resultadoHTML;
            document.getElementById('resultContainer').style.display = 'block';
        } else {
            console.error('Error en la solicitud: ' + xhr.status);
        }
    };

    // Enviar la solicitud
    xhr.send(formData);
});
