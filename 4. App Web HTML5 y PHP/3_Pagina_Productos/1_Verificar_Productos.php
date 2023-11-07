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

// Función para verificar si un producto existe por su código
function producto_existe_por_codigo($codigo, $conn) {
    $query = "SELECT COUNT(*) FROM Productos WHERE Codigo_Producto = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $codigo);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();
    
    return $count > 0;
}

// Verificar si se ha enviado un código de producto desde el formulario
if (isset($_POST['codigo_producto'])) {
    $codigo_producto = $_POST['codigo_producto'];

    if (producto_existe_por_codigo($codigo_producto, $conn)) {
        $mensaje = "El producto con el código $codigo_producto existe.";
    } else {
        $mensaje = "El producto con el código $codigo_producto no existe.";
    }
}

// Cerrar la conexión a la base de datos
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Verificar Producto</title>
</head>
<body>
    <h1>Verificar Producto por Código</h1>
    <form method="post">
        <label for="codigo_producto">Código del Producto:</label>
        <input type="text" name="codigo_producto" id="codigo_producto" required>
        <button type="submit">Verificar</button>
    </form>

    <?php
    if (isset($mensaje)) {
        echo "<p>$mensaje</p>";
    }
    ?>
</body>
</html>
