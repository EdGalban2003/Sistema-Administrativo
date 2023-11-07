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

// Función para eliminar un cliente por su cédula
function eliminar_cliente_por_cedula($cedula, $conn) {
    if (cliente_existe_por_cedula($cedula, $conn)) {
        $query = "DELETE FROM Cliente WHERE Cedula_Cliente = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $cedula);
        
        if ($stmt->execute()) {
            echo "Cliente con cédula $cedula eliminado con éxito.";
        } else {
            echo "Error al eliminar el cliente.";
        }
        $stmt->close();
    } else {
        echo "No existe un cliente con la cédula $cedula en la base de datos.";
    }
}

// Verificar si se ha enviado la cédula del cliente a eliminar
if (isset($_POST['cedula'])) {
    $cedula = $_POST['cedula'];
    eliminar_cliente_por_cedula($cedula, $conn);
}

// Cerrar la conexión a la base de datos
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Eliminar Cliente</title>
</head>
<body>
    <h1>Eliminar Cliente por Cédula</h1>
    <form method="post">
        <label for="cedula">Cédula del Cliente a Eliminar:</label>
        <input type="text" name="cedula" id="cedula" required>
        <button type="submit">Eliminar Cliente</button>
    </form>
</body>
</html>
