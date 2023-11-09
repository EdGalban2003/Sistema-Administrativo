<?php
// Incluye el archivo de configuración
require('G:\Repositorios Github\Sistema-Administrativo\4. App Web HTML5 y PHP\_ConexionBDDSA\config.php');

// Conexión a la base de datos
$conn = new mysqli($db_config['host'], $db_config['username'], $db_config['password'], $db_config['database']);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Función para consultar un proveedor por número de documento
function consultar_proveedor_por_numero_documento($numero_documento, $conn) {
    $query = "SELECT * FROM Proveedor WHERE Numero_Documento = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $numero_documento);
    $stmt->execute();
    $result = $stmt->get_result();
    $proveedor = $result->fetch_assoc();
    $stmt->close();
    
    return $proveedor;
}

// Verificar si se ha enviado el número de documento del proveedor a consultar
if (isset($_POST['numero_documento'])) {
    $numero_documento = $_POST['numero_documento'];
    $proveedor = consultar_proveedor_por_numero_documento($numero_documento, $conn);

    if ($proveedor) {
        echo "Proveedor encontrado:";
        echo "ID: " . $proveedor['ID_Proveedor'];
        echo "Nombre Comercial: " . $proveedor['Nombre_Comercial_Proveedor'];
        echo "Nombre: " . $proveedor['Nombre_Proveedor'];
        echo "Apellido: " . $proveedor['Apellido_Proveedor'];
        echo "Tipo de Documento: " . $proveedor['Tipo_Documento'];
        echo "Número de Documento: " . $proveedor['Numero_Documento'];
        echo "Teléfono: " . $proveedor['Telefono_Proveedor'];
        echo "Correo: " . $proveedor['Correo_Proveedor'];
        echo "Dirección: " . $proveedor['Direccion_Proveedor'];
    } else {
        echo "Proveedor no encontrado.";
    }
}

// Cerrar la conexión a la base de datos
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Consultar Proveedor</title>
</head>
<body>
    <h1>Consultar Proveedor por Número de Documento</h1>
    <form method="post">
        <label for="numero_documento">Número de Documento del Proveedor a Consultar:</label>
        <input type="text" name="numero_documento" id="numero_documento" required>
        <button type="submit">Consultar Proveedor</button>
    </form>
</body>
</html>
