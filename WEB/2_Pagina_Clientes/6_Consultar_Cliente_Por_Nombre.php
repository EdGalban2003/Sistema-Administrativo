<?php
// Conexión a la base de datos (debes establecer tu propia conexión)
$servername = "localhost";
$username = "Admin";
$password = "xztj-ARgQGavgh@K";
$database = "sistema_administrativo";

$conn = new mysqli($servername, $username, $password, $database);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Función para consultar clientes por nombre
function consultar_cliente_por_nombre($nombre, $conn) {
    $query = "SELECT * FROM Cliente WHERE Nombre_Cliente LIKE ?";
    $stmt = $conn->prepare($query);
    $nombreLike = "%" . $nombre . "%";
    $stmt->bind_param("s", $nombreLike);
    $stmt->execute();
    $result = $stmt->get_result();
    $clientes = array();
    
    while ($row = $result->fetch_assoc()) {
        $clientes[] = $row;
    }
    
    $stmt->close();
    
    return $clientes;
}

// Verificar si se ha enviado el nombre del cliente a consultar
if (isset($_POST['nombre'])) {
    $nombre = $_POST['nombre'];
    $clientes = consultar_cliente_por_nombre($nombre, $conn);

    if ($clientes) {
        echo "Clientes encontrados:";
        foreach ($clientes as $cliente) {
            echo "ID: " . $cliente['ID_Cliente'];
            echo "Cédula: " . $cliente['Cedula_Cliente'];
            echo "Nombre: " . $cliente['Nombre_Cliente'];
            echo "Apellido: " . $cliente['Apellido_Cliente'];
            echo "Teléfono: " . $cliente['Telefono_Cliente'];
            echo "Correo: " . $cliente['Correo_Cliente'];
            echo "Dirección: " . $cliente['Direccion_Cliente'];
        }
    } else {
        echo "No se encontraron clientes con ese nombre.";
    }
}

// Cerrar la conexión a la base de datos
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Consultar Cliente por Nombre</title>
</head>
<body>
    <h1>Consultar Cliente por Nombre</h1>
    <form method="post">
        <label for="nombre">Nombre del Cliente a Consultar:</label>
        <input type="text" name="nombre" id="nombre" required>
        <button type="submit">Consultar Cliente</button>
    </form>
</body>
</html>
