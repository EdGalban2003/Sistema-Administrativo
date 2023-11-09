<?php
// Incluye el archivo de configuración
require('G:\Repositorios Github\Sistema-Administrativo\4. App Web HTML5 y PHP\_ConexionBDDSA\config.php');

// Iniciar sesión o reanudar la sesión existente
session_save_path('G:\Repositorios Github\Sistema-Administrativo\4. App Web HTML5 y PHP\_ConexionBDDSA\Sesiones');
session_start();

// Conexión a la base de datos
$conn = new mysqli($db_config['host'], $db_config['username'], $db_config['password'], $db_config['database']);

// Obtén el nombre de usuario desde la sesión
$nombre_usuario = $_SESSION['nombre_usuario'];

$mensaje = "";
$iteraciones = 100000;  // Número de iteraciones
$longitud_hash = 32;    // Longitud del hash

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $contrasena_actual = $_POST['contrasena_actual'];
    $nueva_contrasena = $_POST['nueva_contrasena'];
    $confirmar_contrasena = $_POST['confirmar_contrasena'];

    // Obtén el hash y el salt de la contraseña actual del usuario
    $stmt = $conn->prepare("SELECT Contraseña, Salt FROM usuarios WHERE Nombre_Usuario = ?");
    $stmt->bind_param("s", $nombre_usuario);
    $stmt->execute();
    $stmt->bind_result($contrasena_actual_hashed, $salt_actual);
    $stmt->fetch();
    $stmt->close();

    // Verifica si la contraseña actual es correcta
    $contrasena_actual_hashed_input = hash_pbkdf2("sha256", $contrasena_actual, $salt_actual, $iteraciones, $longitud_hash);

    if (hash_equals($contrasena_actual_hashed, $contrasena_actual_hashed_input)) {
        // Verifica si la nueva contraseña y la confirmación coinciden
        if ($nueva_contrasena === $confirmar_contrasena) {
            // Genera un "salt" aleatorio para la nueva contraseña
            $nuevo_salt = random_bytes(32);
            $nueva_contrasena_hashed = hash_pbkdf2("sha256", $nueva_contrasena, $nuevo_salt, $iteraciones, $longitud_hash);

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
            $mensaje = "La nueva contraseña y la confirmación no coinciden.";
        }
    } else {
        $mensaje = "Contraseña actual incorrecta. No puedes cambiar la contraseña.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Cambiar Contraseña</title>
</head>
<body>
    <h1>Cambiar Contraseña</h1>
    <?php if (!empty($mensaje)) { echo "<p>$mensaje</p>"; } ?>
    <form method="post">
    <label for="contrasena_actual">Contraseña Actual:</label>
    <input type="password" name="contrasena_actual" required>
    <br>
    <label for="nueva_contrasena">Nueva Contraseña:</label>
    <input type="password" name="nueva_contrasena" required>
    <br>
    <label for="confirmar_contrasena">Confirmar Contraseña:</label>
    <input type="password" name="confirmar_contrasena" required>
    <br>
    <button type="submit">Cambiar Contraseña</button>
</form>
</body>
</html>
