<?php
// Inicia la sesión (asegúrate de haber iniciado la sesión antes)
session_start();

// Verifica si hay un nombre de usuario en la sesión
if (isset($_SESSION['nombre_usuario'])) {
    // Muestra el nombre de usuario
    echo '<div class="usuario">' . $_SESSION['nombre_usuario'] . '</div>';
} else {
    // Si no hay un nombre de usuario, puedes redirigir o mostrar algo diferente
    echo '<div class="usuario">Invitado</div>';
}
?>
