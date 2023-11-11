<?php
session_start();  // Iniciar la sesión si no se ha iniciado aún

// Guardar el ID de sesión antes de destruir la sesión
$sesion_anterior = $_SESSION;

// Realizar cualquier otra lógica de tu aplicación

// Cerrar la sesión
session_destroy();

// Redirigir a la página de inicio de sesión u otra página
header("Location: /Sistema-Administrativo/4. App Web HTML5 y PHP/1_Pagina_Menu_Principal/0_Index_MenuPrincipal.html");
exit;

// Verificar si la sesión se ha cerrado
if (empty($sesion_anterior)) {
    echo "La sesión se ha cerrado correctamente.";
} else {
    echo "La sesión no se ha cerrado correctamente.";
}
?>
