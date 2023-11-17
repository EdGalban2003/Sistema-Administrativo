<?php
require_once(__DIR__ . '/../_ConexionBDDSA/config2.php');

try {
    // Intenta la conexión con la base de datos después de actualizar el archivo config.php
    $conn = new mysqli($db_config2['host'], $db_config2['username'], $db_config2['password'], $db_config2['database']);
} catch (mysqli_sql_exception $e) {
    // Muestra un mensaje personalizado en caso de un error de acceso
    echo "<h2>Acceso Denegado</h2>";
    exit;
}

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$mensajeError = ''; // Variable para almacenar mensajes de error

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
        $errores['nombre'] = "No se permiten espacios, solo letras.";
    }

    if (!empty($apellido) && !preg_match("/^[A-Za-z]+$/", $apellido)) {
        $errores['apellido'] = "No se permiten espacios, solo letras.";
    }

    if (empty($nombre_usuario) || !preg_match("/^[A-Za-z0-9]+$/", $nombre_usuario)) {
        $errores['nombre_usuario'] = "No se permiten espacios, solo letras y números.";
    } else {
        // Verifica si el nombre de usuario ya está en uso
        $stmt = $conn->prepare("SELECT Nombre_Usuario FROM usuarios WHERE Nombre_Usuario = ?");
        $stmt->bind_param("s", $nombre_usuario);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $errores['nombre_usuario'] = "El nombre de usuario ya está en uso. Por favor, elige otro.";
        }
        $stmt->close();
    }

    if (empty($correo) || !filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $errores['correo'] = "Solo se permiten correos que no estén en uso, solo correos, y sin espacios en el correo.";
    } else {
        // Verifica si el correo ya está en uso
        $stmt = $conn->prepare("SELECT Correo_Usuario FROM usuarios WHERE Correo_Usuario = ?");
        $stmt->bind_param("s", $correo);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $errores['correo'] = "El correo ya está en uso. Por favor, utiliza otro correo.";
        }
        $stmt->close();
    }

    if (empty($contrasena)) {
        $errores['contrasena'] = "Solo se permiten números, letras y signos.";
    } elseif (strlen($contrasena) < 8 || strlen($contrasena) > 16) {
        $errores['contrasena'] = "La contraseña debe tener entre 8 y 16 caracteres.";
    } elseif (!preg_match("/^[A-Za-z0-9!@#$%^&*()_+{}:;<>,.?~\-]+$/", $contrasena)) {
        $errores['contrasena'] = "Solo se permiten números, letras y los siguientes caracteres especiales: !@#$%^&*()_+{}:;<>,.?~\-";
    }

    if ($contrasena !== $contrasena_confirm) {
        $errores['contrasena_confirm'] = "Las contraseñas no coinciden. Intenta de nuevo.";
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


            // Crear un usuario con permisos de USAGE en la base de datos de PHPMyAdmin
            $crear_usuario_bd = $nombre_usuario;
            $contrasena_bd = $contrasena;

            // Obtener el nombre de usuario y la contraseña después de registrar el usuario
            $nombre_usuario_registrado = $nombre_usuario;
            
            $conn->query("USE sistema_administrativo;");
            $crear_usuario_query = "CREATE USER '$crear_usuario_bd'@'localhost';";
            $otorgar_permisos_query = "GRANT SELECT, INSERT, UPDATE, DELETE ON sistema_administrativo.* TO '$crear_usuario_bd'@'localhost';";
            
            // Ejecutar FLUSH PRIVILEGES para aplicar los cambios de privilegios inmediatamente
            $conn->query("FLUSH PRIVILEGES");
            
            // Ejecutar las consultas para crear el usuario y otorgar permisos
            $conn->query($crear_usuario_query);
            $conn->query($otorgar_permisos_query);

            if ($conn->error) {
                echo "Error Usuario no Confirmado: " . $conn->error;
            } else {
                echo "Usuario Confirmado.";
        
            }
        } else {
            echo "Error al registrar el usuario: " . $stmt->error;
        }
        $stmt->close();
    } else {
        // Muestra los errores al usuario
        $mensajeError = implode("\n", $errores);
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
        <div class="campo">
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" id="nombre" required>
            <?php if (isset($errores['nombre'])) : ?>
                <div style="color: red;"><?php echo $errores['nombre']; ?></div>
            <?php endif; ?>
        </div>

        <div class="campo">
            <label for="apellido">Apellido:</label>
            <input type="text" name="apellido" id="apellido">
            <?php if (isset($errores['apellido'])) : ?>
                <div style="color: red;"><?php echo $errores['apellido']; ?></div>
            <?php endif; ?>
        </div>

        <div class="campo">
            <label for="nombre_usuario">Nombre de usuario:</label>
            <input type="text" name="nombre_usuario" id="nombre_usuario" required onblur="verificarUsuario()">
            <span id="mensaje_usuario"></span>
            <?php if (isset($errores['nombre_usuario'])) : ?>
                <div style="color: red;"><?php echo $errores['nombre_usuario']; ?></div>
            <?php endif; ?>
        </div>

        <div class="campo">
            <label for="correo">Correo:</label>
            <input type="email" name="correo" id="correo" required>
            <?php if (isset($errores['correo'])) : ?>
                <div style="color: red;"><?php echo $errores['correo']; ?></div>
            <?php endif; ?>
        </div>

        <div class="campo">
            <label for="contrasena">Contraseña:</label>
            <input type="password" name="contrasena" id="contrasena" pattern="^[A-Za-z0-9!@#$%^&*()_+{}:;<>,.?~\-]+$" title="Solo se permiten números, letras y los siguientes caracteres especiales: !@#$%^&*()_+{}:;<>,.?~\-"
                minlength="8" maxlength="16" required>
            <?php if (isset($errores['contrasena'])) : ?>
                <div style="color: red;"><?php echo $errores['contrasena']; ?></div>
            <?php endif; ?>
        </div>

        <div class="campo">
            <label for="contrasena_confirm">Confirma la contraseña:</label>
            <input type="password" name="contrasena_confirm" id="contrasena_confirm" required>
            <?php if (isset($errores['contrasena_confirm'])) : ?>
                <div style="color: red;"><?php echo $errores['contrasena_confirm']; ?></div>
            <?php endif; ?>
        </div>

        <button type="submit">Registrarse</button>

    </form>
    
    <!-- Botón de inicio de sesion -->
    <a href="1_Login.php">Iniciar Sesion</a>

</body>
</html>

