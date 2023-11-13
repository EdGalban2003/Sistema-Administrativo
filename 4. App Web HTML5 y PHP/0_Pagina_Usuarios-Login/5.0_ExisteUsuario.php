<?php
// Incluye el archivo de configuración para la conexión a la base de datos
require_once(__DIR__ . '/../_ConexionBDDSA/config.php');

// Inicia la sesión
session_save_path('G:\Repositorios Github\Sistema-Administrativo\4. App Web HTML5 y PHP\_ConexionBDDSA\Sesiones');
session_start();

// Conexión a la base de datos
$conn = new mysqli($db_config['host'], $db_config['username'], $db_config['password'], $db_config['database']);

// Mensaje de error por defecto
$error = '';

// Verifica si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtiene el nombre de usuario desde el formulario
    $nombre_usuario = isset($_POST['nombre_usuario']) ? htmlspecialchars($_POST['nombre_usuario']) : '';

    // Valida que el nombre de usuario solo contenga letras y números sin espacios
    if (preg_match('/^[a-zA-Z0-9]+$/', $nombre_usuario)) {
        // Consulta SQL para verificar si el nombre de usuario existe en la base de datos
        $consulta = "SELECT * FROM usuarios WHERE nombre_usuario = '$nombre_usuario'";
        $resultado = $conn->query($consulta);

        // Verifica si hay al menos una fila en el resultado
        if ($resultado->num_rows > 0) {
            // Si el nombre de usuario existe, establece la sesión y redirige
            $_SESSION['nombre_usuario'] = $nombre_usuario;
            header("Location: /Sistema-Administrativo/4. App Web HTML5 y PHP/0_Pagina_Usuarios-Login/5_VerificarPreguntasLogin.php");
            exit;
        } else {
            // Si el nombre de usuario no existe, muestra un mensaje de error
            $error = "El nombre de usuario no existe. Inténtalo de nuevo.";
        }
    } else {
        // Muestra un mensaje de error si el nombre de usuario no es válido
        $error = "El nombre de usuario solo debe contener letras y números, sin espacios.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Contraseña</title>
</head>
<body>
    <h1>Recuperar Contraseña</h1>
    
    <?php
    // Muestra el mensaje de error de manera segura
    if (!empty($error)) {
        echo '<div style="color: red;">' . htmlspecialchars($error) . '</div>';
    }
    ?>

    <form method="post">
        <label for="nombre_usuario">Nombre de usuario:</label>
        <input type="text" name="nombre_usuario" id="nombre_usuario" pattern="[a-zA-Z0-9]+" title="Solo letras y números, sin espacios" required>
        <br>
        <button type="submit">Aceptar</button>
        <br>
        <!-- Agrega el botón de "Volver" -->
        <a href="/Sistema-Administrativo/4. App Web HTML5 y PHP/0_Pagina_Usuarios-Login/1_Login.php"><button type="button">Volver</button></a>
        
    </form>
</body>
</html>