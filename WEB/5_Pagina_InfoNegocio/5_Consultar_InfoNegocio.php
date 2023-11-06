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

// Función para consultar un cliente por su cédula
function consultar_cliente_por_cedula($cedula, $conn) {
    $query = "SELECT * FROM Cliente WHERE Cedula_Cliente = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $cedula);
    $stmt->execute();
    $result = $stmt->get_result();
    $cliente = $result->fetch_assoc();
    $stmt->close();
    
    return $cliente;
}

// Verificar si se ha enviado la cédula del cliente a consultar
if (isset($_POST['cedula'])) {
    $cedula = $_POST['cedula'];
    $cliente = consultar_cliente_por_cedula($cedula, $conn);

    if ($cliente) {
        echo "Cliente encontrado:";
        echo "ID: " . $cliente['ID_Cliente'];
        echo "Cédula: " . $cliente['Cedula_Cliente'];
        echo "Nombre: " . $cliente['Nombre_Cliente'];
        echo "Apellido: " . $cliente['Apellido_Cliente'];
        echo "Teléfono: " . $cliente['Telefono_Cliente'];
        echo "Correo: " . $cliente['Correo_Cliente'];
        echo "Dirección: " . $cliente['Direccion_Cliente'];
    } else {
        echo "Cliente no encontrado.";
    }
}

// Cerrar la conexión a la base de datos
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Consultar Cliente</title>
</head>
<body>
    <h1>Consultar Cliente por Cédula</h1>
    <form method="post">
        <label for="cedula">Cédula del Cliente a Consultar:</label>
        <input type="text" name="cedula" id="cedula" required>
        <button type="submit">Consultar Cliente</button>
    </form>
</body>
</html>
