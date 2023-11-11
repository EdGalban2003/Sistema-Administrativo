<?php
require_once(__DIR__ . '/../_ConexionBDDSA/config.php');

// Iniciar sesión o reanudar la sesión existente
session_save_path('G:\Repositorios Github\Sistema-Administrativo\4. App Web HTML5 y PHP\_ConexionBDDSA\Sesiones');
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Inicializar el contador de intentos si no existe
$_SESSION['intentos'] = $_SESSION['intentos'] ?? 0;

$conn = new mysqli($db_config['host'], $db_config['username'], $db_config['password'], $db_config['database']);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

function bloquearUsuario($usuario) {
    // Establecer el tiempo de bloqueo en 30 segundos
    $tiempo_bloqueo = 30;

    // Marcar la verificación fallida y aumentar el contador de intentos
    $_SESSION['verificacion_fallida'] = true;
    $_SESSION['intentos']++;

    // Almacenar la cantidad de intentos actuales en la variable de sesión
    $_SESSION['intentos_actuales'] = $_SESSION['intentos'];

    // Establecer la marca de tiempo del último intento
    $_SESSION['ultimo_intento'] = time();

    // Verificar si se alcanzó el límite de intentos
    if ($_SESSION['intentos'] >= 3) {
        // Bloquear al usuario
        $_SESSION['usuario_bloqueado'] = true;

        // Limpiar variables de sesión relacionadas con el bloqueo
        unset($_SESSION['verificacion_fallida']);
        unset($_SESSION['intentos']);
        unset($_SESSION['intentos_actuales']);
        unset($_SESSION['ultimo_intento']);

        // Redirigir a la página de bloqueo o mostrar un mensaje
        header("Location: pagina_de_bloqueo.php");
        exit;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Restablecer el contador de intentos y la marca de tiempo
    $_SESSION['intentos'] = 0;
    $_SESSION['intentos_actuales'] = 0;
    $_SESSION['ultimo_intento'] = 0;

    $nombre_usuario = $_POST['nombre_usuario'];
    $contrasena = $_POST['contrasena'];

    $errores = []; // Variable para almacenar mensajes de error

    // Validación de usuario (solo letras y números)
    if (!preg_match("/^[A-Za-z0-9]+$/", $nombre_usuario)) {
        $errores['nombre_usuario'] = "Nombre de usuario solo debe contener letras y números.";
    }

    // Verificar si hay errores
    if (empty($errores)) {
        // Obtener la contraseña almacenada y el salt de la base de datos
        $stmt = $conn->prepare("SELECT Contraseña, Salt FROM usuarios WHERE Nombre_Usuario = ?");
        $stmt->bind_param("s", $nombre_usuario);
        $stmt->execute();
        $stmt->bind_result($contrasena_hashed, $salt);
        $stmt->fetch();
        $stmt->close();

        if ($contrasena_hashed && $salt) {
            // Calcular el hash de la contraseña proporcionada
            $iteraciones = 100000;  // Número de iteraciones
            $longitud_hash = 32;    // Longitud del hash
            $contrasena_bytes = $contrasena;
            $contrasena_proveida_hashed = hash_pbkdf2("sha256", $contrasena_bytes, $salt, $iteraciones, $longitud_hash);

            if ($contrasena_proveida_hashed == $contrasena_hashed) {
                $_SESSION['nombre_usuario'] = $nombre_usuario;

                // Redirigir al usuario a la página de menú (ajusta la ruta según sea necesario)
                header("Location: Sistema-Administrativo/4. App Web HTML5 y PHP/1_Pagina_Menu_Principal/0_Index_MenuPrincipal.html");
                exit;  // Asegurar que el script se detenga después de la redirección
            } else {
                // Si la verificación de la contraseña falla, bloquear al usuario
                bloquearUsuario($nombre_usuario);

                // Marcar el error de contraseña
                $errores['contrasena'] = "Contraseña incorrecta";
            }
        } else {
            $errores['nombre_usuario'] = "Nombre de usuario no encontrado";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <style>
        @keyframes countdown {
            from { color: red; }
            to { color: black; }
        }
    </style>
</head>
<body>
    <h1>Iniciar Sesión</h1>
    <form method="post">
        <label for="nombre_usuario">Nombre de usuario:</label>
        <input type="text" name="nombre_usuario" id="nombre_usuario" required>
        <?php
        // Mostrar el mensaje de error específico para el nombre de usuario
        if (isset($errores['nombre_usuario'])) {
            echo '<div style="color: red;">' . $errores['nombre_usuario'] . '</div>';
        }
        ?>
        <br>
        <label for="contrasena">Contraseña:</label>
        <input type="password" name="contrasena" required>
        <?php
        // Mostrar el mensaje de error específico para la contraseña
        if (isset($errores['contrasena'])) {
            echo '<div style="color: red;">' . $errores['contrasena'] . '</div>';
        }
        ?>
        <br>
        <button type="submit">Iniciar Sesión</button>
    </form>
    
    <!-- Botón de registro -->
    <a href="2_Registrarse.php">Registrarse</a>
</body>
</html>
