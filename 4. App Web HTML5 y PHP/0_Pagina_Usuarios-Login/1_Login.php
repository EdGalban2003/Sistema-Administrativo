<?php
require_once(__DIR__ . '/../_ConexionBDDSA/config.php');

// Configurar la ubicación personalizada para los archivos de sesión
session_save_path(__DIR__ . '/../_ConexionBDDSA/Sesiones/');
session_start();

// Inicializar la variable de intentos fallidos
$intentos_fallidos = isset($_SESSION['intentos_fallidos']) ? $_SESSION['intentos_fallidos'] : 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre_usuario = $_POST['nombre_usuario'];
    $contrasena = $_POST['contrasena'];

    // Actualiza dinámicamente el archivo config.php con el nombre de usuario proporcionado
    $config_path = __DIR__ . '/../_ConexionBDDSA/config.php';
    $config_content = file_get_contents($config_path);

    // Comprueba si el nombre de usuario está presente en el archivo config
    if (preg_match("/'username' => \"[^\"]+\"/", $config_content)) {
        // Reemplaza el nombre de usuario existente con el nuevo
        $config_content = preg_replace("/'username' => \"[^\"]+\"/", "'username' => \"$nombre_usuario\"", $config_content);
    } else {
        // Agrega el nombre de usuario si no existe en el archivo config
        $config_content = str_replace("'username' => \"\",", "'username' => \"$nombre_usuario\",", $config_content);
    }

    // Guarda los cambios en el archivo config.php
    if (file_put_contents($config_path, $config_content) === false) {
        die("Error al actualizar el archivo config.php");
    }

    try {
        // Intenta la conexión con la base de datos después de actualizar el archivo config.php
        $conn = new mysqli($db_config['host'], $nombre_usuario, '', $db_config['database']);
    } catch (mysqli_sql_exception $e) {
        // Muestra un mensaje personalizado en caso de un error de acceso
        echo "<h2>Acceso Denegado</h2>";
        echo "<p>Usuario no registrado.</p>";
        echo "<p>Ocurrió un error al intentar acceder. Por favor, verifica tus credenciales.</p>";
        echo "<a href='/Sistema-Administrativo/4. App Web HTML5 y PHP/0_Pagina_Usuarios-Login/1_Login.php'>Volver</a>";
        exit;
    }

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }
}

// Verificar si hay una sesión activa
if (isset($_SESSION['nombre_usuario'])) {
    echo "<h2>Error: Sesión activa</h2>";
    echo "<p>No puede iniciar sesión dos veces.</p>";
    echo "<div id='countdown'></div>";
    echo "<script>
            var seconds = 10;
            function updateCountdown() {
                document.getElementById('countdown').innerHTML = 'Serás redirigido al login en ' + seconds + ' segundos.';
                if (seconds == 0) {
                    window.location.href = '/Sistema-Administrativo/4. App Web HTML5 y PHP/0_Pagina_Usuarios-Login/1_Login.php';
                } else {
                    seconds--;
                    setTimeout(updateCountdown, 1000);
                }
            }
            updateCountdown();
          </script>";
    exit;
}

// Inicializar la variable de intentos fallidos
$intentos_fallidos = isset($_SESSION['intentos_fallidos']) ? $_SESSION['intentos_fallidos'] : 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre_usuario = $_POST['nombre_usuario'];
    $contrasena = $_POST['contrasena'];

    $errores = [];

    // Validación del nombre de usuario
    if (!preg_match("/^[A-Za-z0-9]+$/", $nombre_usuario)) {
        $errores['nombre_usuario'] = "Nombre de usuario solo debe contener letras y números.";
    }

    // Validación de la contraseña
    if (!preg_match("/^[A-Za-z0-9!@#$%^&*()_]{8,16}$/", $contrasena)) {
        $errores['contrasena'] = "Contraseña incorrecta. Debe contener entre 8 y 16 caracteres, incluyendo letras, números y algunos caracteres especiales.";
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

            // Verifica si la contraseña es correcta
            if ($contrasena_proveida_hashed == $contrasena_hashed) {
                // Asigna el nombre de usuario a la sesión
                $_SESSION['nombre_usuario'] = $nombre_usuario;
                header("Location: /Sistema-Administrativo/4. App Web HTML5 y PHP/1_Pagina_Menu_Principal/0_Index_MenuPrincipal.html");
                exit;
            } else {
                // Incrementar los intentos fallidos por IP
                $intentos_fallidos++;

                $errores['contrasena'] = "Contraseña incorrecta";

                // Verificar si el usuario está bloqueado después de tres intentos
                if ($intentos_fallidos >= 3) {
                    echo "<h2>Error: Usuario bloqueado</h2>";
                    echo "<p>Contacta con un Administrador o recupera la contraseña.</p>";
                    echo "<div id='countdown'></div>";
                    echo "<script>
                            var seconds = 45;
                            document.getElementById('nombre_usuario').disabled = true;
                            document.getElementById('contrasena').disabled = true;
                            document.querySelector('button').disabled = true;

                            function updateCountdown() {
                                document.getElementById('countdown').innerHTML = 'Serás redirigido al login en ' + seconds + ' segundos.';
                                if (seconds == 0) {
                                    window.location.href = '/Sistema-Administrativo/4. App Web HTML5 y PHP/0_Pagina_Usuarios-Login/1_Login.php';
                                } else {
                                    seconds--;
                                    setTimeout(updateCountdown, 1000);
                                }
                            }

                            updateCountdown();
                          </script>";
                    exit;
                }
            }
        } else {
            $errores['nombre_usuario'] = "Nombre de usuario no encontrado";
        }
    }

    // Almacenar el contador actualizado en la variable de intentos fallidos por IP
    $_SESSION['intentos_fallidos'] = $intentos_fallidos;
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
