<?php
// Incluye el archivo de configuración
require('G:\Repositorios Github\Sistema-Administrativo\4. App Web HTML5 y PHP\_ConexionBDDSA\config.php');

// Conexión a la base de datos
$conn = new mysqli($db_config['host'], $db_config['username'], $db_config['password'], $db_config['database']);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar si se ha enviado el formulario de modificación de datos
if (isset($_POST['cedula'], $_POST['nuevo_nombre'], $_POST['nuevo_apellido'], $_POST['nuevo_telefono'], $_POST['nuevo_correo'], $_POST['nueva_direccion'])) {
    $cedula = $_POST['cedula'];
    $nuevo_nombre = $_POST['nuevo_nombre'];
    $nuevo_apellido = $_POST['nuevo_apellido'];
    $nuevo_telefono = $_POST['nuevo_telefono'];
    $nuevo_correo = $_POST['nuevo_correo'];
    $nueva_direccion = $_POST['nueva_direccion'];

    try {
        $query = "UPDATE Cliente SET Nombre_Cliente = ?, Apellido_Cliente = ?, Telefono_Cliente = ?, Correo_Cliente = ?, Direccion_Cliente = ? WHERE Cedula_Cliente = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssssss", $nuevo_nombre, $nuevo_apellido, $nuevo_telefono, $nuevo_correo, $nueva_direccion, $cedula);
        $stmt->execute();
        $stmt->close();
        echo "Datos del cliente actualizados con éxito.";
    } catch (mysqli_sql_exception $e) {
        echo "Error al actualizar los datos del cliente: " . $e->getMessage();
    }
}

// Cerrar la conexión a la base de datos
$conn->close();
?>



<!DOCTYPE html>
<html>
<head>
    <title>Modificar Cliente</title>
</head>
<body>
    <h1>Modificar Datos del Cliente</h1>

    <form method="post">
        <label for="cedula">Cédula del Cliente:</label>
        <input type="text" name="cedula" id="cedula" required>
        <label for="nuevo_nombre">Nuevo Nombre:</label>
        <input type="text" name="nuevo_nombre" id="nuevo_nombre" required>
        <label for="nuevo_apellido">Nuevo Apellido:</label>
        <input type="text" name="nuevo_apellido" id="nuevo_apellido" required>
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
