<?php
// Incluye el archivo de configuración
require('G:\Repositorios Github\Sistema-Administrativo\4. App Web HTML5 y PHP\_ConexionBDDSA\config2.php');

// Iniciar sesión o reanudar la sesión existente
session_save_path('G:\Repositorios Github\Sistema-Administrativo\4. App Web HTML5 y PHP\_ConexionBDDSA\Sesiones');
session_start();

// Conexión a la base de datos
$conn = new mysqli($db_config2['host'], $db_config2['username'], $db_config2['password'], $db_config2['database']);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre_usuario = $_POST['nombre_usuario'];
    $contrasena = $_POST['contrasena'];

    // Obtiene el usuario de la base de datos
    $stmt = $conn->prepare("SELECT Contraseña, Salt FROM usuarios WHERE Nombre_Usuario = ?");
    $stmt->bind_param("s", $nombre_usuario);
    $stmt->execute();
    $stmt->bind_result($contrasena_hashed, $salt);
    $stmt->fetch();
    $stmt->close();

    if ($contrasena_hashed && $salt) {
        // Calcula el hash de la contraseña proporcionada
        $iteraciones = 100000;  // Número de iteraciones
        $longitud_hash = 32;    // Longitud del hash
        $contrasena_bytes = $contrasena;
        $contrasena_proveida_hashed = hash_pbkdf2("sha256", $contrasena_bytes, $salt, $iteraciones, $longitud_hash);

        if ($contrasena_proveida_hashed == $contrasena_hashed) {
            // Inicio de sesión exitoso, almacena el nombre de usuario en una variable de sesión
            $_SESSION['nombre_usuario'] = $nombre_usuario;
            echo "Inicio de sesión exitoso";
            // Puedes redirigir al usuario a la página de inicio o realizar otras acciones necesarias
        } else {
            echo "Nombre de usuario o contraseña incorrectos";
        }
    } else {
        echo "Nombre de usuario no encontrado";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Iniciar Sesión</title>
</head>
<body>
    <h1>Iniciar Sesión</h1>
    <form method="post">
        <label for="nombre_usuario">Nombre de usuario:</label>
        <input type="text" name="nombre_usuario" required>
        <br>
        <label for="contrasena">Contraseña:</label>
        <input type="password" name="contrasena" required>
        <br>
        <button type="submit">Iniciar Sesión</button>
    </form>
</body>
</html>
