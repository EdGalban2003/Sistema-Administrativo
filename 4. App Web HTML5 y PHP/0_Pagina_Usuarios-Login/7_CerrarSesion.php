<?php
// Cerrar la sesión
session_destroy();

// Asegurarse de que la cookie de sesión se elimine en el lado del cliente
setcookie(session_name(), '', time() - 3600, '/');

// Asegurarse de que la cookie de bloqueo también se elimine en el lado del cliente
setcookie('usuario_bloqueado', '', time() - 3600, '/');

// Redirigir a la página de inicio de sesión u otra página
header("Location: /Sistema-Administrativo/4. App Web HTML5 y PHP/0_Pagina_Usuarios-Login/1_Login.php");
exit;
?>
