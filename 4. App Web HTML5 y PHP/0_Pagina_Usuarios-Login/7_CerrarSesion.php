<?php
// Configurar la ubicación personalizada para los archivos de sesión
session_save_path(__DIR__ . '/../_ConexionBDDSA/Sesiones/');
session_start();

// Obtener el ID de sesión actual
$current_session_id = session_id();

// Liberar todas las variables de sesión
session_unset();

// Destruir la sesión
if (session_destroy()) {
    // Cierre adecuado de la sesión en el lado del servidor
    session_write_close();

    // Asegurarse de que la cookie de sesión se elimine en el lado del cliente
    setcookie(session_name(), '', time() - 3600, '/');

    // Asegurarse de que la cookie de bloqueo también se elimine en el lado del cliente
    setcookie('usuario_bloqueado', '', time() - 3600, '/');

    // Actualizar el archivo config.php con el 'username' vacío
    $config_path = __DIR__ . '/../_ConexionBDDSA/config.php';
    $config_content = file_get_contents($config_path);
    $config_content = preg_replace("/'username' => \"[^\"]+\"/", "'username' => \"\"", $config_content);
    file_put_contents($config_path, $config_content);


    // Redirigir a la página de inicio de sesión u otra página
    header("Location: /Sistema-Administrativo/4. App Web HTML5 y PHP/0_Pagina_Usuarios-Login/1_Login.php");
    exit;
} else {
    // Manejar errores si la destrucción de la sesión falla
    echo "Error al cerrar la sesión.";
}
?>