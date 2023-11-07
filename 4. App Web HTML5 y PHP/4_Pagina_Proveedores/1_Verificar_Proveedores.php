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

// Verificar si se ha enviado un número de documento desde el formulario
if (isset($_POST['numero_documento'])) {
    $numero_documento = $_POST['numero_documento'];

    if (proveedor_existe_por_numero_documento($numero_documento, $conn)) {
        $mensaje = "El proveedor con el número de documento $numero_documento existe.";
    } else {
        $mensaje = "El proveedor con el número de documento $numero_documento no existe.";
    }
}

// Cerrar la conexión a la base de datos
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Verificar Proveedor</title>
</head>
<body>
    <h1>Verificar Proveedor por Número de Documento</h1>
    <form method="post">
        <label for="numero_documento">Número de Documento del Proveedor:</label>
        <input type="text" name="numero_documento" id="numero_documento" required>
        <button type="submit">Verificar Proveedor</button>
    </form>

    <?php
    if (isset($mensaje)) {
        echo "<p>$mensaje</p>";
    }
    ?>
</body>
</html>

