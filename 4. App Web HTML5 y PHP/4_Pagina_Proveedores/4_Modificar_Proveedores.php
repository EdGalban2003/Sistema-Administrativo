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

// Verificar si se ha enviado el formulario de modificación de datos
if (isset($_POST['numero_documento'], $_POST['nuevo_nombre'], $_POST['nuevo_apellido'], $_POST['nuevo_tipo_documento'], $_POST['nuevo_numero_documento'], $_POST['nuevo_telefono'], $_POST['nuevo_correo'], $_POST['nueva_direccion'])) {
    $numero_documento = $_POST['numero_documento'];
    $nuevo_nombre = $_POST['nuevo_nombre'];
    $nuevo_apellido = $_POST['nuevo_apellido'];
    $nuevo_tipo_documento = $_POST['nuevo_tipo_documento'];
    $nuevo_numero_documento = $_POST['nuevo_numero_documento'];
    $nuevo_telefono = $_POST['nuevo_telefono'];
    $nuevo_correo = $_POST['nuevo_correo'];
    $nueva_direccion = $_POST['nueva_direccion'];

    try {
        $query = "UPDATE Proveedor SET Nombre_Proveedor = ?, Apellido_Proveedor = ?, Tipo_Documento = ?, Numero_Documento = ?, Telefono_Proveedor = ?, Correo_Proveedor = ?, Direccion_Proveedor = ? WHERE Numero_Documento = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssssssss", $nuevo_nombre, $nuevo_apellido, $nuevo_tipo_documento, $nuevo_numero_documento, $nuevo_telefono, $nuevo_correo, $nueva_direccion, $numero_documento);
        $stmt->execute();
        $stmt->close();
        echo "Datos del proveedor actualizados con éxito.";
    } catch (mysqli_sql_exception $e) {
        echo "Error al actualizar los datos del proveedor: " . $e->getMessage();
    }
}

// Cerrar la conexión a la base de datos
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Modificar Proveedor</title>
</head>
<body>
    <h1>Modificar Datos del Proveedor</h1>

    <form method="post">
        <label for="numero_documento">Número de Documento del Proveedor:</label>
        <input type="text" name="numero_documento" id="numero_documento" required>
        <label for="nuevo_nombre">Nuevo Nombre:</label>
        <input type="text" name="nuevo_nombre" id="nuevo_nombre" required>
        <label for="nuevo_apellido">Nuevo Apellido:</label>
        <input type="text" name="nuevo_apellido" id="nuevo_apellido" required>
        <label for="nuevo_tipo_documento">Nuevo Tipo de Documento:</label>
        <input type="text" name="nuevo_tipo_documento" id="nuevo_tipo_documento" required>
        <label for="nuevo_numero_documento">Nuevo Número de Documento:</label>
        <input type="text" name="nuevo_numero_documento" id="nuevo_numero_documento" required>
        <label for="nuevo_telefono">Nuevo Teléfono:</label>
        <input type="text" name="nuevo_telefono" id="nuevo_telefono" required>
        <label for="nuevo_correo">Nuevo Correo:</label>
        <input type="text" name="nuevo_correo" id="nuevo_correo" required>
        <label for="nueva_direccion">Nueva Dirección:</label>
        <input type="text" name="nueva_direccion" id="nueva_direccion" required>
        <button type="submit">Modificar Datos</button>
    </form>
</body>
</html>
