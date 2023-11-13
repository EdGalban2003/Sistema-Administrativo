<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bloqueado</title>
    <style>
        @keyframes countdown {
            from { color: red; }
            to { color: black; }
        }
    </style>
</head>
<body>
    <?php
    // Recupera la cantidad de intentos fallidos de la URL
    $intentos_fallidos = isset($_GET['intentos']) ? intval($_GET['intentos']) : 0;
    ?>

    <h1>Usuario Bloqueado</h1>
    <p>Has excedido el límite de intentos. Tu cuenta está bloqueada temporalmente.</p>
    <p>Por favor, contacta con soporte o restablece tu contraseña.</p>

    <div id="countdown">El bloqueo se levantará en: 45 segundos.</div>
    
    <script>
        var seconds = 45;

        function countdown() {
            seconds--;
            document.getElementById("countdown").innerHTML = "El bloqueo se levantará en: " + seconds + " segundos.";

            if (seconds <= 0) {
                document.getElementById("countdown").innerHTML = "El bloqueo se ha levantado. ";
                var button = document.createElement("button");
                button.innerHTML = "Volver";
                button.onclick = function () {
                    // Cerrar la sesión antes de redirigir
                    window.location.href = "/Sistema-Administrativo/4. App Web HTML5 y PHP/0_Pagina_Usuarios-Login/7_CerrarSesion.php";
                };
                document.body.appendChild(button);

                // Deshabilita completamente el botón de retroceso
                history.pushState(null, null, document.URL);
                window.addEventListener('popstate', function () {
                    history.pushState(null, null, document.URL);
                });
            } else {
                // Guarda el tiempo de desbloqueo en una cookie
                document.cookie = "unlockTime=" + (new Date().getTime() + seconds * 1000) + "; path=/";
                setTimeout(countdown, 1000);
            }
        }

        // Iniciar el contador cuando se carga la página
        countdown();
    </script>
</body>
</html>
