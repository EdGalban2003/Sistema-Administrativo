<?php
// Incluye el archivo de configuración
require_once(__DIR__ . '/../_ConexionBDDSA/config2.php');

try {
    // Intenta la conexión con la base de datos después de actualizar el archivo config.php
    $conn = new mysqli($db_config2['host'], $db_config2['username'], $db_config2['password'], $db_config2['database']);
} catch (mysqli_sql_exception $e) {
    // Muestra un mensaje personalizado en caso de un error de acceso
    echo "<h2>Acceso Denegado</h2>";
    exit;
}

// Resto del código de verificación de respuestas
$mensaje = "";
$cambiar_contrasena = false; // Variable para habilitar el cambio de contraseña

// Obtén el nombre de usuario desde la tabla temporal
$sql_temporal = "SELECT Nombre_Usuario FROM Usuarios_Temporales";
$resultado_temporal = $conn->query($sql_temporal);

if ($resultado_temporal->num_rows > 0) {
    $fila_temporal = $resultado_temporal->fetch_assoc();
    $nombre_usuario = $fila_temporal['Nombre_Usuario'];

    // Verifica si se ha obtenido un nombre de usuario
    if (!empty($nombre_usuario)) {
        // Recupera las preguntas y respuestas almacenadas en la base de datos
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

            // Verifica si las preguntas y respuestas almacenadas no son nulas antes de comparar
            if (
                $pregunta1_db !== null &&
                $pregunta2_db !== null &&
                $pregunta3_db !== null &&
                $respuesta_hashed_1_db !== null &&
                $respuesta_hashed_2_db !== null &&
                $respuesta_hashed_3_db !== null
            ) {
                // Verifica las respuestas
                $respuesta_hashed_1 = hash_pbkdf2("sha256", $respuesta_1, $salt2_db, $iteraciones, $longitud_hash);
                $respuesta_hashed_2 = hash_pbkdf2("sha256", $respuesta_2, $salt3_db, $iteraciones, $longitud_hash);
                $respuesta_hashed_3 = hash_pbkdf2("sha256", $respuesta_3, $salt4_db, $iteraciones, $longitud_hash);

                // Verifica si las respuestas coinciden
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
            } else {
                $mensaje = "Las preguntas o respuestas almacenadas son nulas.";
            }
        }
    } else {
        $mensaje = "No se ha obtenido un nombre de usuario.";
    }
} else {
    $mensaje = "No hay registros en la tabla de usuarios temporales.";
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
        <a href="1_Login.php"><button type="button">Volver</button></a>
    <?php } ?>
</body>
</html>