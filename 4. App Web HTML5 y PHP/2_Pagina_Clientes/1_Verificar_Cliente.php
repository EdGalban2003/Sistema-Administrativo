<?php
// Incluye el archivo de configuración
require_once(__DIR__ . '/../_ConexionBDDSA/config.php');

// Iniciar sesión o reanudar la sesión existente
session_save_path('G:\Repositorios Github\Sistema-Administrativo\4. App Web HTML5 y PHP\_ConexionBDDSA\Sesiones');
session_start();

// Verificar si el usuario ya ha iniciado sesión
if (!empty($_SESSION['nombre_usuario'])) {
    $nombre_usuario = $_SESSION['nombre_usuario'];
} 

try {
    // Intenta la conexión con la base de datos después de actualizar el archivo config.php
    $conn = new mysqli($db_config['host'], $nombre_usuario, '', $db_config['database']);
} catch (mysqli_sql_exception $e) {
    // Muestra un mensaje personalizado en caso de un error de acceso
    echo "<h2>Acceso Denegado</h2>";
    exit;
}


// Función para verificar si un cliente existe por su cédula
function cliente_existe_por_cedula($cedula, $conn) {
    $query = "SELECT COUNT(*) FROM Cliente WHERE Cedula_Cliente = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $cedula);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();
    
    return $count > 0;
}

// Verificar si se ha enviado una cédula desde el formulario
if (isset($_POST['cedula'])) {
    $cedula = $_POST['cedula'];

    if (cliente_existe_por_cedula($cedula, $conn)) {
        $mensaje = "El cliente con la cédula $cedula existe.";
    } else {
        $mensaje = "El cliente con la cédula $cedula no existe.";
    }
}

// Cerrar la conexión a la base de datos
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Verificar Cliente</title>
</head>
<body>
    <h1>Verificar Cliente por Cédula</h1>
    <form method="post">
        <label for="cedula">Cédula del Cliente:</label>
        <input type="text" name="cedula" id="cedula" required>
        <button type="submit">Verificar</button>
    </form>

    <!-- Botón "Volver" -->
    <button onclick="window.history.back()">Volver</button>

    <?php
    if (isset($mensaje)) {
        echo "<p>$mensaje</p>";
    }
    ?>
</body>
</html>

