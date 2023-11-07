<?php
// Conexión a la base de datos 
$servername = "localhost";
$username = "UserGuest";
$password = "U$3rG#3stP@ss";
$database = "sistema_administrativo";

$conn = new mysqli($servername, $username, $password, $database);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Función para consultar un proveedor por nombre comercial
function consultar_proveedor_por_nombre_comercial($nombre_comercial, $conn) {
    $query = "SELECT * FROM Proveedor WHERE Nombre_Comercial_Proveedor LIKE ?";
    $stmt = $conn->prepare($query);
    $nombre_comercial_param = "%" . $nombre_comercial . "%"; // Agregar comodines % para buscar coincidencias parciales
    $stmt->bind_param("s", $nombre_comercial_param);
    $stmt->execute();
    $result = $stmt->get_result();
    $proveedores = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    
    return $proveedores;
}

// Verificar si se ha enviado el nombre comercial del proveedor a consultar
if (isset($_POST['nombre_comercial'])) {
    $nombre_comercial = $_POST['nombre_comercial'];
    $proveedores = consultar_proveedor_por_nombre_comercial($nombre_comercial, $conn);

    if ($proveedores) {
        echo "Proveedores encontrados:";
        foreach ($proveedores as $proveedor) {
            echo "ID: " . $proveedor['ID_Proveedor'];
            echo "Nombre Comercial: " . $proveedor['Nombre_Comercial_Proveedor'];
            echo "Nombre: " . $proveedor['Nombre_Proveedor'];
            echo "Apellido: " . $proveedor['Apellido_Proveedor'];
            echo "Tipo de Documento: " . $proveedor['Tipo_Documento'];
            echo "Número de Documento: " . $proveedor['Numero_Documento'];
            echo "Teléfono: " . $proveedor['Telefono_Proveedor'];
            echo "Correo: " . $proveedor['Correo_Proveedor'];
            echo "Dirección: " . $proveedor['Direccion_Proveedor'];
        }
    } else {
        echo "No se encontraron proveedores con ese nombre comercial.";
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
    <h1>Consultar Proveedor por Nombre Comercial</h1>
    <form method="post">
        <label for="nombre_comercial">Nombre Comercial del Proveedor a Consultar:</label>
        <input type="text" name="nombre_comercial" id="nombre_comercial" required>
        <button type="submit">Consultar Proveedor</button>
    </form>
</body>
</html>
