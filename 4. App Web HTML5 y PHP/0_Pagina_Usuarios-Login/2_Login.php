<?php
require('G:\Repositorios Github\Sistema-Administrativo\4. App Web HTML5 y PHP\_ConexionBDDSA\config2.php');

// Iniciar sesión o reanudar la sesión existente
session_save_path('G:\Repositorios Github\Sistema-Administrativo\4. App Web HTML5 y PHP\_ConexionBDDSA\Sesiones');
session_start();

$conn = new mysqli($db_config2['host'], $db_config2['username'], $db_config2['password'], $db_config2['database']);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Definir el tiempo de bloqueo (en segundos)
$tiempo_de_bloqueo = 900; // 15 minutos

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre_usuario = $_POST['nombre_usuario'];
    $contrasena = $_POST['contrasena'];

    // Validación de usuario (solo letras y números)
    if (!preg_match("/^[A-Za-z0-9]+$/", $nombre_usuario)) {
        echo "Nombre de usuario solo debe contener letras y números.";
        exit;
    }

    // Validación de contraseña (no vacía)
    if (empty($contrasena)) {
        echo "La contraseña es obligatoria.";
        exit;
    }

    // Obtener la marca de tiempo del último intento fallido
    $ultima_marca_de_tiempo = isset($_SESSION['ultimo_intento']) ? $_SESSION['ultimo_intento'] : 0;
    $tiempo_actual = time();

    // Comprobar si el usuario está bloqueado
    if ($tiempo_actual - $ultima_marca_de_tiempo < $tiempo_de_bloqueo) {
        echo "Has excedido el límite de intentos. Debes esperar " . ($tiempo_de_bloqueo - ($tiempo_actual - $ultima_marca_de_tiempo)) . " segundos antes de intentar nuevamente.";
        exit;
    }

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
            // Restablecer el contador de intentos y la marca de tiempo
            $_SESSION['intentos'] = 0;
            $_SESSION['ultimo_intento'] = 0;

            $_SESSION['nombre_usuario'] = $nombre_usuario;
            echo "Inicio de sesión exitoso";
        } else {
            // Incrementar el contador de intentos fallidos
            $_SESSION['intentos']++;
            $_SESSION['ultimo_intento'] = $tiempo_actual;

            echo "Nombre de usuario o contraseña incorrectos. Intento " . $_SESSION['intentos'];
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
    <script>
        function validarUsuario() {
            var nombre_usuario = document.getElementById('nombre_usuario').value;
            var mensaje = document.getElementById('mensaje_usuario');

            if (nombre_usuario && !/^[A-Za-z0-9]+$/.test(nombre_usuario)) {
                mensaje.innerHTML = 'Nombre de usuario solo debe contener letras y números.';
                return false;
            } else {
                mensaje.innerHTML = '';
                return true;
            }
        }
    </script>
</head>
<body>
    <h1>Iniciar Sesión</h1>
    <form method="post">
        <label for="nombre_usuario">Nombre de usuario:</label>
        <input type="text" name="nombre_usuario" id="nombre_usuario" required onblur="validarUsuario()">
        <span id="mensaje_usuario"></span>
        <br>
        <label for="contrasena">Contraseña:</label>
        <input type="password" name="contrasena" required>
        <br>
        <button type="submit">Iniciar Sesión</button>
    </form>
</body>
</html>

