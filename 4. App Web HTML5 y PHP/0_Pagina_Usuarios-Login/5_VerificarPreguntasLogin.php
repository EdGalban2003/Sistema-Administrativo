<?php
// Incluye el archivo de configuración
require_once(__DIR__ . '/../_ConexionBDDSA/config.php');

// Iniciar sesión o reanudar la sesión existente
session_save_path('G:\Repositorios Github\Sistema-Administrativo\4. App Web HTML5 y PHP\_ConexionBDDSA\Sesiones');
session_start();

// Conexión a la base de datos
$conn = new mysqli($db_config['host'], $db_config['username'], $db_config['password'], $db_config['database']);

// Resto del código de verificación de respuestas
$mensaje = "";
$cambiar_contrasena = false; // Variable para habilitar el cambio de contraseña

// Obtén el nombre de usuario desde la sesión
$nombre_usuario = $_SESSION['nombre_usuario'];

// Recupera las preguntas almacenadas en la base de datos
$stmt = $conn->prepare("SELECT Pregunta1, Pregunta2, Pregunta3, Respuesta1, Salt2, Respuesta2, Salt3, Respuesta3, Salt4 FROM usuarios WHERE Nombre_Usuario = ?");
$stmt->bind_param("s", $nombre_usuario);
$stmt->execute();
$stmt->bind_result($pregunta1_db, $pregunta2_db, $pregunta3_db, $respuesta_hashed_1_db, $salt2_db, $respuesta_hashed_2_db, $salt3_db, $respuesta_hashed_3_db, $salt4_db);
$stmt->fetch();
$stmt->close();

$iteraciones = 100000;  // Número de iteraciones
$longitud_hash = 32;    // Longitud del hash

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $respuesta_1 = isset($_POST['respuesta_1']) ? $_POST['respuesta_1'] : "";
    $respuesta_2 = isset($_POST['respuesta_2']) ? $_POST['respuesta_2'] : "";
    $respuesta_3 = isset($_POST['respuesta_3']) ? $_POST['respuesta_3'] : "";

    // Verifica las respuestas
    $respuesta_hashed_1 = hash_pbkdf2("sha256", $respuesta_1, $salt2_db, $iteraciones, $longitud_hash);
    $respuesta_hashed_2 = hash_pbkdf2("sha256", $respuesta_2, $salt3_db, $iteraciones, $longitud_hash);
    $respuesta_hashed_3 = hash_pbkdf2("sha256", $respuesta_3, $salt4_db, $iteraciones, $longitud_hash);

    if (
        hash_equals($respuesta_hashed_1_db, $respuesta_hashed_1) &&
        hash_equals($respuesta_hashed_2_db, $respuesta_hashed_2) &&
        hash_equals($respuesta_hashed_3_db, $respuesta_hashed_3)
    ) {
        $cambiar_contrasena = true;
        $mensaje = "Respuestas correctas. Puedes cambiar tu contraseña a continuación.";
    } else {
        $mensaje = "Respuestas incorrectas. No puedes cambiar la contraseña.";
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Verificar Respuestas</title>
</head>
<body>
    <h1>Verificar Respuestas Login</h1>
    <?php if (!empty($mensaje)) { echo "<p>$mensaje</p>"; } ?>
    <?php if ($cambiar_contrasena) { ?>
        <!-- Agregar redirección a CambiarContrasena.php -->
        <form method="post" action="6_CambiarContraseñaLogin.php">
            <button type="submit">Cambiar Contraseña</button>
        </form>
    <?php } else { ?>
        <form method="post">
            <label for="pregunta_seleccionada_1"><?php echo $pregunta1_db; ?></label>
            <input type="text" name="respuesta_1" required>
            <br>
            <label for="pregunta_seleccionada_2"><?php echo $pregunta2_db; ?></label>
            <input type="text" name="respuesta_2" required>
            <br>
            <label for="pregunta_seleccionada_3"><?php echo $pregunta3_db; ?></label>
            <input type="text" name="respuesta_3" required>
            <br>
            <button type="submit">Verificar Preguntas y Respuestas</button>
        </form>

        <br>
        <!-- Agrega el botón de "Volver" -->
        <a href="/Sistema-Administrativo/4. App Web HTML5 y PHP/0_Pagina_Usuarios-Login/1_Login.php"><button type="button">Volver</button></a>

    <?php 
    } 
    ?>
</body>
</html>
