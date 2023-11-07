<?php
// Incluye el archivo de configuración
require('G:\Repositorios Github\Sistema-Administrativo\4. App Web HTML5 y PHP\_ConexionBDDSA\config.php');

// Conexión a la base de datos
$conn = new mysqli($db_config['host'], $db_config['username'], $db_config['password'], $db_config['database']);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
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

    <?php
    if (isset($mensaje)) {
        echo "<p>$mensaje</p>";
    }
    ?>
</body>
</html>

