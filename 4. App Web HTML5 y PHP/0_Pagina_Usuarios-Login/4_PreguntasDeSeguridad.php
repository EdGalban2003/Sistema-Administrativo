<?php
// Incluye el archivo de configuración
require_once(__DIR__ . '/../_ConexionBDDSA/config.php');

// Configurar la ubicación personalizada para los archivos de sesión
session_save_path(__DIR__ . '/../_ConexionBDDSA/Sesiones/');
session_start();

// Verificar si el usuario ya ha iniciado sesión
if (!empty($_SESSION['nombre_usuario'])) {
    $nombre_usuario = $_SESSION['nombre_usuario'];
} 

try {
    // Intenta la conexión con la base de datos después de actualizar el archivo config.php
    $conn = new mysqli($db_config['host'], $nombre_usuario, '', $db_config['database']);
} catch (mysqli_sql_exception $e) {
    // Muestra un mensaje personalizado en caso de un error de acceso
    echo "<h2>Acceso Denegado</h2>";
    exit;
}

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$preguntas = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pregunta_seleccionada_1 = $_POST['pregunta_seleccionada_1'];
    $respuesta_1 = $_POST['respuesta_1'];
    $pregunta_seleccionada_2 = $_POST['pregunta_seleccionada_2'];
    $respuesta_2 = $_POST['respuesta_2'];
    $pregunta_seleccionada_3 = $_POST['pregunta_seleccionada_3'];
    $respuesta_3 = $_POST['respuesta_3'];

    // Genera un salt para cada respuesta
    $salt_1 = random_bytes(32);
    $salt_2 = random_bytes(32);
    $salt_3 = random_bytes(32);

    // Calcula el hash de cada respuesta utilizando el salt correspondiente
    $respuesta_hashed_1 = hash_pbkdf2("sha256", $respuesta_1, $salt_1, 100000, 32);
    $respuesta_hashed_2 = hash_pbkdf2("sha256", $respuesta_2, $salt_2, 100000, 32);
    $respuesta_hashed_3 = hash_pbkdf2("sha256", $respuesta_3, $salt_3, 100000, 32);

    // Actualiza las preguntas y respuestas en la base de datos
    $stmt = $conn->prepare("UPDATE usuarios SET Pregunta1 = ?, Respuesta1 = ?, Salt2 = ?, Pregunta2 = ?, Respuesta2 = ?, Salt3 = ?, Pregunta3 = ?, Respuesta3 = ?, Salt4 = ? WHERE Nombre_Usuario = ?");
    $stmt->bind_param("ssssssssss", $pregunta_seleccionada_1, $respuesta_hashed_1, $salt_1, $pregunta_seleccionada_2, $respuesta_hashed_2, $salt_2, $pregunta_seleccionada_3, $respuesta_hashed_3, $salt_3, $nombre_usuario);

    if ($stmt->execute()) {
        echo "Preguntas y respuestas guardadas con éxito.";
    } else {
        echo "Error al guardar las preguntas y respuestas: " . $stmt->error;
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Preguntas de Seguridad</title>
    <script>
        var selectedQuestions = [];

        // Array con las 10 opciones de pregunta
        var preguntas = [
            "¿Cuál es el nombre de tu primera mascota?",
            "¿En qué ciudad naciste?",
            "¿Cuál es tu película favorita?",
            "¿Cuál es el nombre de tu mejor amigo de la infancia?",
            "¿En qué año te graduaste de la escuela secundaria?",
            "¿Cuál es tu canción favorita?",
            "¿Cuál es el nombre de tu abuela materna?",
            "¿En qué país te gustaría vivir si pudieras elegir cualquiera?",
            "¿Cuál es tu plato de comida favorito?",
            "¿Cuál es tu libro favorito?"
        ];

        function toggleOptions(preguntaField) {
            var select = document.getElementById(preguntaField);
            select.innerHTML = '<option value="">Selecciona una pregunta</option>';
            for (var i = 0; i < preguntas.length; i++) {
                var pregunta = preguntas[i];
                if (!selectedQuestions.includes(pregunta)) {
                    var option = document.createElement('option');
                    option.value = pregunta;
                    option.text = pregunta;
                    select.appendChild(option);
                }
            }
        }

        function selectPregunta(preguntaField, pregunta) {
            if (selectedQuestions.includes(pregunta)) {
                alert("Esta pregunta ya ha sido seleccionada.");
                preguntaField.value = ""; // Limpiar el valor
            } else {
                selectedQuestions.push(pregunta);
            }
        }

        function enableAllOptions() {
            selectedQuestions = [];
            toggleOptions('pregunta_seleccionada_1');
            toggleOptions('pregunta_seleccionada_2');
            toggleOptions('pregunta_seleccionada_3');
        }
    </script>
</head>
<body>
    <h1>Configurar Preguntas de Seguridad</h1>
    <form method="post">
        <label for="pregunta_seleccionada_1">Pregunta 1 seleccionada:</label>
        <select id="pregunta_seleccionada_1" name="pregunta_seleccionada_1" onchange="selectPregunta(this, this.value)" required>
            <option value="">Selecciona una pregunta</option>
        </select>
        <label for="respuesta_1">Respuesta 1:</label>
        <input type="text" name="respuesta_1" required>
        <br>
        <label for="pregunta_seleccionada_2">Pregunta 2 seleccionada:</label>
        <select id="pregunta_seleccionada_2" name="pregunta_seleccionada_2" onchange="selectPregunta(this, this.value)" required>
            <option value="">Selecciona una pregunta</option>
        </select>
        <label for="respuesta_2">Respuesta 2:</label>
        <input type="text" name="respuesta_2" required>
        <br>
        <label for="pregunta_seleccionada_3">Pregunta 3 seleccionada:</label>
        <select id="pregunta_seleccionada_3" name="pregunta_seleccionada_3" onchange="selectPregunta(this, this.value)" required>
            <option value="">Selecciona una pregunta</option>
        </select>
        <label for="respuesta_3">Respuesta 3:</label>
        <input type="text" name="respuesta_3" required>
        <br>
        <button type="submit">Registrar</button>
    </form>

    <br>
        <!-- Agrega el botón de "Volver" -->
        <a href="/Sistema-Administrativo/4. App Web HTML5 y PHP/0_Pagina_Usuarios-Login/0_Menu_Usuarios_Opciones.html"><button type="button">Volver</button></a>
    <script>
        enableAllOptions(); // Llamar a la función para cargar las opciones iniciales
    </script>
</body>
</html>
