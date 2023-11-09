<?php
// Incluye el archivo de configuración
require('G:\Repositorios Github\Sistema-Administrativo\4. App Web HTML5 y PHP\_ConexionBDDSA\config.php');

// Iniciar sesión o reanudar la sesión existente
session_start();

// Verificar si el usuario ya ha iniciado sesión
if (!empty($_SESSION['nombre_usuario'])) {
    $nombre_usuario = $_SESSION['nombre_usuario'];
} else {
    // Si el usuario no ha iniciado sesión, redirige a la página de inicio de sesión
    header("Location: login.php");
    exit();
}

// Conexión a la base de datos
$conn = new mysqli($db_config['host'], $db_config['username'], $db_config['password'], $db_config['database']);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$preguntas = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Resto del código para manejar la configuración de preguntas...
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Configurar Preguntas de Seguridad</title>
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
        };

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
        <label for="nombre_usuario">Nombre de usuario:</label>
        <input type="text" name="nombre_usuario" value="<?php echo $nombre_usuario; ?>" readonly>
        <br>
        <!-- Resto del formulario para configurar preguntas... -->
    </form>
    <script>
        enableAllOptions(); // Llamar a la función para cargar las opciones iniciales
    </script>
</body>
</html>
