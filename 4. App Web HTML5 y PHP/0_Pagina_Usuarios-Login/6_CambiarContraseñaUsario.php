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
            } else {
                $mensaje = "Error al cambiar la contraseña: " . $stmt->error;
            }
            $stmt->close();
        } else {
            $mensaje = "Las contraseñas no coinciden. Intenta de nuevo.";
        }
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Cambiar Contraseña Usuario</title>
</head>
<body>
    <h1>Cambiar Contraseña Usuario</h1>
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
        <!-- Agrega el botón de "Volver" -->
        <a href="/Sistema-Administrativo/4. App Web HTML5 y PHP/0_Pagina_Usuarios-Login/0_Menu_Usuarios_Opciones.html"><button type="button">Volver</button></a>

</body>
</html>
