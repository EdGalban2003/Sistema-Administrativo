<?php
require('G:\Repositorios Github\Sistema-Administrativo\4. App Web HTML5 y PHP\_ConexionBDDSA\config.php');

$conn = new mysqli($db_config['host'], $db_config['username'], $db_config['password'], $db_config['database']);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $apellido = isset($_POST['apellido']) ? $_POST['apellido'] : '';
    $nombre_usuario = $_POST['nombre_usuario'];
    $correo = $_POST['correo'];
    $contrasena = $_POST['contrasena'];
    $contrasena_confirm = $_POST['contrasena_confirm'];

    // Realiza la validación de datos
    $errores = [];

    if (empty($nombre) || !preg_match("/^[A-Za-z]+$/", $nombre)) {
        $errores[] = "El campo 'Nombre' es obligatorio y solo debe contener letras y no pueden haber espacios.";
    }

    if (!empty($apellido) && !preg_match("/^[A-Za-z]+$/", $apellido)) {
        $errores[] = "El campo 'Apellido' solo debe contener letras y no pueden haber espacios.";
    }

    if (empty($nombre_usuario) || !preg_match("/^[A-Za-z0-9]+$/", $nombre_usuario)) {
        $errores[] = "El campo 'Nombre de usuario' es obligatorio y solo debe contener letras y números.";
    } else {
        // Verifica si el nombre de usuario ya está en uso
        $stmt = $conn->prepare("SELECT Nombre_Usuario FROM usuarios WHERE Nombre_Usuario = ?");
        $stmt->bind_param("s", $nombre_usuario);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $errores[] = "El nombre de usuario ya está en uso. Por favor, elige otro.";
        }
        $stmt->close();
    }

    if (empty($correo) || !filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $errores[] = "El campo 'Correo' es obligatorio y debe ser una dirección de correo válida.";
    } else {
        // Verifica si el correo ya está en uso
        $stmt = $conn->prepare("SELECT Correo_Usuario FROM usuarios WHERE Correo_Usuario = ?");
        $stmt->bind_param("s", $correo);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $errores[] = "El correo ya está en uso. Por favor, utiliza otro correo.";
        }
        $stmt->close();
    }

    if (empty($contrasena)) {
        $errores[] = "El campo 'Contraseña' es obligatorio.";
    }

    if ($contrasena !== $contrasena_confirm) {
        $errores[] = "Las contraseñas no coinciden. Intenta de nuevo.";
    }

    if (empty($errores)) {
        $salt = random_bytes(32);
        $iteraciones = 100000;
        $longitud_hash = 32;
        $contrasena_hashed = hash_pbkdf2("sha256", $contrasena, $salt, $iteraciones, $longitud_hash);

        $fecha_registro = date("Y-m-d");
        $hora_registro = date("H:i:s");

        $stmt = $conn->prepare("INSERT INTO usuarios (Nombre_Personal, Apellido_Personal, Nombre_Usuario, Contraseña, Correo_Usuario, Salt, Fecha_Registro, Hora_Registro) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssss", $nombre, $apellido, $nombre_usuario, $contrasena_hashed, $correo, $salt, $fecha_registro, $hora_registro);

        if ($stmt->execute()) {
            echo "Usuario registrado con éxito.";
        } else {
            echo "Error al registrar el usuario: " . $stmt->error;
        }
        $stmt->close();
    } else {
        // Muestra los errores al usuario
        foreach ($errores as $error) {
            echo $error . "<br>";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Registrarse</title>
    <script>
        function verificarUsuario() {
            var nombre_usuario = document.getElementById('nombre_usuario').value;
            if (nombre_usuario) {
                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'verificar_usuario.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        var response = xhr.responseText;
                        var mensaje = document.getElementById('mensaje_usuario');

                        if (response === 'disponible') {
                            mensaje.innerHTML = 'Nombre de usuario disponible.';
                        } else if (response === 'en_uso') {
                            mensaje.innerHTML = 'El nombre de usuario ya está en uso. Por favor, elige otro.';
                        }
                    }
                };
                xhr.send('nombre_usuario=' + nombre_usuario);
            }
        }
    </script>
</head>
<body>
    <h1>Registrarse</h1>
    <form method="post">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" id="nombre" required>
        <br>
        <label for="apellido">Apellido:</label>
        <input type="text" name="apellido" id="apellido">
        <br>
        <label for="nombre_usuario">Nombre de usuario:</label>
        <input type="text" name="nombre_usuario" id="nombre_usuario" required onblur="verificarUsuario()">
        <span id="mensaje_usuario"></span>
        <br>
        <label for="correo">Correo:</label>
        <input type="email" name="correo" id="correo" required>
        <br>
        <label for="contrasena">Contraseña:</label>
        <input type="password" name="contrasena" id="contrasena" required>
        <br>
        <label for="contrasena_confirm">Confirma la contraseña:</label>
        <input type="password" name="contrasena_confirm" id="contrasena_confirm" required>
        <br>
        <button type="submit">Registrarse</button>
    </form>
</body>
</html>

