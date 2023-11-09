<?php
// Incluye el archivo de configuración
require('G:\Repositorios Github\Sistema-Administrativo\4. App Web HTML5 y PHP\_ConexionBDDSA\config.php');

// Conexión a la base de datos
$conn = new mysqli($db_config['host'], $db_config['username'], $db_config['password'], $db_config['database']);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $apellido = isset($_POST['apellido']) ? $_POST['apellido'] : ''; // Verifica si se envió el campo "apellido"
    $nombre_usuario = $_POST['nombre_usuario'];
    $correo = $_POST['correo'];

    $contrasena = $_POST['contrasena'];
    $contrasena_confirm = $_POST['contrasena_confirm'];

    if ($contrasena != $contrasena_confirm) {
        echo "Las contraseñas no coinciden. Intenta de nuevo.";
    } else {
        // Genera un "salt" aleatorio para la contraseña
        $salt = random_bytes(32);  // Genera un "salt" como bytes

        // Calcula el hash de la contraseña utilizando el "salt"
        $iteraciones = 100000;  // Número de iteraciones
        $longitud_hash = 32;    // Longitud del hash
        $contrasena_hashed = hash_pbkdf2("sha256", $contrasena, $salt, $iteraciones, $longitud_hash);

        // Obtener la fecha y hora actuales
        $fecha_registro = date("Y-m-d");
        $hora_registro = date("H:i:s");

        // Inserta el usuario en la base de datos
        $stmt = $conn->prepare("INSERT INTO usuarios (Nombre_Personal, Apellido_Personal, Nombre_Usuario, Contraseña, Correo_Usuario, Salt, Fecha_Registro, Hora_Registro) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssss", $nombre, $apellido, $nombre_usuario, $contrasena_hashed, $correo, $salt, $fecha_registro, $hora_registro);

        if ($stmt->execute()) {
            echo "Usuario registrado con éxito.";
        } else {
            echo "Error al registrar el usuario: " . $stmt->error;
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Registrarse</title>
</head>
<body>
    <h1>Registrarse</h1>
    <form method="post">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" required>
        <br>
        <label for="apellido">Apellido:</label>
        <input type="text" name="apellido">
        <br>
        <label for="nombre_usuario">Nombre de usuario:</label>
        <input type="text" name="nombre_usuario" required>
        <br>
        <label for="correo">Correo:</label>
        <input type="email" name="correo" required>
        <br>
        <label for="contrasena">Contraseña:</label>
        <input type="password" name="contrasena" required>
        <br>
        <label for="contrasena_confirm">Confirma la contraseña:</label>
        <input type="password" name="contrasena_confirm" required>
        <br>
        <button type="submit">Registrarse</button>
    </form>
</body>
</html>
