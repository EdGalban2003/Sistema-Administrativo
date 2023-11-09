<?php
// Incluye el archivo de configuración
require('G:\Repositorios Github\Sistema-Administrativo\4. App Web HTML5 y PHP\_ConexionBDDSA\config.php');

// Conexión a la base de datos
$conn = new mysqli($db_config['host'], $db_config['username'], $db_config['password'], $db_config['database']);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Función para verificar si un proveedor existe por su número de documento
function proveedor_existe_por_numero_documento($numero_documento, $conn) {
    $query = "SELECT COUNT(*) FROM Proveedor WHERE Numero_Documento = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $numero_documento);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    return $count > 0;
}

// Función para eliminar un proveedor por su número de documento
function eliminar_proveedor_por_numero_documento($numero_documento, $conn) {
    if (proveedor_existe_por_numero_documento($numero_documento, $conn)) {
        $query = "DELETE FROM Proveedor WHERE Numero_Documento = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $numero_documento);

        if ($stmt->execute()) {
            echo "Proveedor con número de documento $numero_documento eliminado con éxito.";
        } else {
            echo "Error al eliminar el proveedor.";
        }
        $stmt->close();
    } else {
        echo "No existe un proveedor con el número de documento $numero_documento en la base de datos.";
    }
}

// Verificar si se ha enviado el número de documento del proveedor a eliminar
if (isset($_POST['numero_documento'])) {
    $numero_documento = $_POST['numero_documento'];
    eliminar_proveedor_por_numero_documento($numero_documento, $conn);
}

// Cerrar la conexión a la base de datos
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Eliminar Proveedor</title>
</head>
<body>
    <h1>Eliminar Proveedor por Número de Documento</h1>
    <form method="post">
        <label for="numero_documento">Número de Documento del Proveedor a Eliminar:</label>
        <input type="text" name="numero_documento" id="numero_documento" required>
        <button type="submit">Eliminar Proveedor</button>
    </form>
</body>
</html>
