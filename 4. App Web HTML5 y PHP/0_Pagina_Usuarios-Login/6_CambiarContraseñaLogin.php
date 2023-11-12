<?php
// Incluye el archivo de configuración
require_once(__DIR__ . '/../_ConexionBDDSA/config.php');

// Iniciar sesión o reanudar la sesión existente
session_save_path('G:\Repositorios Github\Sistema-Administrativo\4. App Web HTML5 y PHP\_ConexionBDDSA\Sesiones');
session_start();

// Conexión a la base de datos
$conn = new mysqli($db_config['host'], $db_config['username'], $db_config['password'], $db_config['database']);

// Resto del código de cambio de contraseña
$mensaje = "";
$iteraciones = 100000;  // Número de iteraciones
$longitud_hash = 32;    // Longitud del hash

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['nueva_contrasena']) && isset($_POST['nueva_contrasena_confirm'])) {
        $nueva_contrasena = $_POST['nueva_contrasena'];
        $nueva_contrasena_confirm = $_POST['nueva_contrasena_confirm'];

        if ($nueva_contrasena === $nueva_contrasena_confirm) {
            // Realiza el cambio de contraseña
            $nueva_contrasena_bytes = $nueva_contrasena;
            $nuevo_salt = random_bytes(32);
            $nueva_contrasena_hashed = hash_pbkdf2("sha256", $nueva_contrasena_bytes, $nuevo_salt, $iteraciones, $longitud_hash);

            // Actualiza la contraseña en la base de datos
            $stmt = $conn->prepare("UPDATE usuarios SET Contraseña = ?, Salt = ? WHERE Nombre_Usuario = ?");
            $stmt->bind_param("sss", $nueva_contrasena_hashed, $nuevo_salt, $nombre_usuario);

            if ($stmt->execute()) {
                $mensaje = "Contraseña cambiada con éxito.";

                // Cerrar la sesión al cambiar la contraseña con éxito
                session_unset();
                session_destroy();
            } else {
                $mensaje = "Error al cambiar la contraseña: " . $stmt->error;
            }
            $stmt->close();
        } else {
            $mensaje = "Las contraseñas no coinciden. Intenta de nuevo.";
        }
    }
}

// Agrega la lógica para cerrar la sesión al presionar "Volver"
if (isset($_GET['cerrar_sesion'])) {
    session_unset();
    session_destroy();
    header("Location: /Sistema-Administrativo/4. App Web HTML5 y PHP/0_Pagina_Usuarios-Login/1_Login.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Cambiar Contraseña</title>
</head>
<body>
    <h1>Cambiar Contraseña Login</h1>
    <?php if (!empty($mensaje)) { echo "<p>$mensaje</p>"; } ?>
    <form method="post">
        <label for="nueva_contrasena">Nueva Contraseña:</label>
        <input type="password" name="nueva_contrasena" required>
        <br>
        <label for="nueva_contrasena_confirm">Confirma la nueva contraseña:</label>
        <input type="password" name="nueva_contrasena_confirm" required>
        <br>
        <button type="submit">Cambiar Contraseña</button>
    </form>

    <br>
    <!-- Agrega el botón de "Volver" con un parámetro para cerrar la sesión -->
    <a href="?cerrar_sesion=1"><button type="button">Volver</button></a>
</body>
</html>
