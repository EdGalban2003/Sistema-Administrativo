<?php
require_once(__DIR__ . '/../_ConexionBDDSA/config.php');

// Configurar la ubicación personalizada para los archivos de sesión
session_save_path('G:\Repositorios Github\Sistema-Administrativo\4. App Web HTML5 y PHP\_ConexionBDDSA\Sesiones');

// Inicia la sesión solo si no está iniciada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Verifica si ya hay una sesión activa
if (isset($_SESSION['nombre_usuario'])) {
    header("Location: /Sistema-Administrativo/4. App Web HTML5 y PHP/1_Pagina_Menu_Principal/0_Index_MenuPrincipal.html");
    exit;
}

$conn = new mysqli($db_config['host'], $db_config['username'], $db_config['password'], $db_config['database']);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

function bloquearUsuario($usuario) {
    // Configura una cookie indicando que el usuario está bloqueado
    setcookie('usuario_bloqueado', true, time() + 30, '/');
    header("Location: 1.1_Bloquear_Usuario.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre_usuario = $_POST['nombre_usuario'];
    $contrasena = $_POST['contrasena'];

    $errores = [];

    if (!preg_match("/^[A-Za-z0-9]+$/", $nombre_usuario)) {
        $errores['nombre_usuario'] = "Nombre de usuario solo debe contener letras y números.";
    }

    if (empty($errores)) {
        $stmt = $conn->prepare("SELECT Contraseña, Salt FROM usuarios WHERE Nombre_Usuario = ?");
        $stmt->bind_param("s", $nombre_usuario);
        $stmt->execute();
        $stmt->bind_result($contrasena_hashed, $salt);
        $stmt->fetch();
        $stmt->close();

        if ($contrasena_hashed && $salt) {
            $iteraciones = 100000;
            $longitud_hash = 32;
            $contrasena_bytes = $contrasena;
            $contrasena_proveida_hashed = hash_pbkdf2("sha256", $contrasena_bytes, $salt, $iteraciones, $longitud_hash);

            if ($contrasena_proveida_hashed == $contrasena_hashed) {
                // Elimina la cookie de bloqueo si existe
                setcookie('usuario_bloqueado', '', time() - 3600, '/');

                // Inicia la sesión y guarda el nombre de usuario actual
                $_SESSION['nombre_usuario'] = $nombre_usuario;

                // Resto del código de inicio de sesión aquí...

                header("Location: /Sistema-Administrativo/4. App Web HTML5 y PHP/1_Pagina_Menu_Principal/0_Index_MenuPrincipal.html");
                exit;
            } else {
                bloquearUsuario($nombre_usuario);
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
        if (isset($errores['nombre_usuario'])) {
            echo '<div style="color: red;">' . $errores['nombre_usuario'] . '</div>';
        }
        ?>
        <br>
        <label for="contrasena">Contraseña:</label>
        <input type="password" name="contrasena" required>
        <?php
        if (isset($errores['contrasena'])) {
            echo '<div style="color: red;">' . $errores['contrasena'] . '</div>';
        }
        ?>
        <br>
        <button type="submit">Iniciar Sesión</button>
    </form>
    
    <a href="2_Registrarse.php">Registrarse</a>
    <br>
    <?php if (isset($errores['contrasena'])): ?>
        <a href="5.0_ExisteUsuario.php">¿Recuperar contraseña?</a>
    <?php endif; ?>
</body>
</html>
