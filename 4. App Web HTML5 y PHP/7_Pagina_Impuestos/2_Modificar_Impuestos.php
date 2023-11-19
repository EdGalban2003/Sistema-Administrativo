<?php
// Incluye el archivo de configuración
require('G:\Repositorios Github\Sistema-Administrativo\4. App Web HTML5 y PHP\_ConexionBDDSA\config.php');

// Iniciar sesión o reanudar la sesión existente
session_save_path('G:\Repositorios Github\Sistema-Administrativo\4. App Web HTML5 y PHP\_ConexionBDDSA\Sesiones');
session_start();

// Verificar si el usuario ya ha iniciado sesión
if (!empty($_SESSION['nombre_usuario'])) {
    $nombre_usuario = $_SESSION['nombre_usuario'];
} 

try {
    // Intenta la conexión con la base de datos después de actualizar el archivo config.php
    $conn = new mysqli($db_config['host'], $nombre_usuario, '', $db_config['database']);
} catch (mysqli_sql_exception $e) {
    // Muestra un mensaje personalizado en caso de un error de acceso
    echo "<h2>Acceso Denegado</h2>";
    exit;
}

// Verificar si se ha enviado el formulario de modificación de datos
if (isset($_POST['cedula'], $_POST['nuevo_nombre'], $_POST['nuevo_apellido'], $_POST['nuevo_telefono'], $_POST['nueva_direccion'])) {
    $cedula = $_POST['cedula'];
    $nuevo_nombre = $_POST['nuevo_nombre'];
    $nuevo_apellido = $_POST['nuevo_apellido'];
    $nuevo_telefono = $_POST['nuevo_telefono'];
    $nueva_direccion = $_POST['nueva_direccion'];

    try {
        $query = "UPDATE Cliente SET Nombre_Cliente = ?, Apellido_Cliente = ?, Telefono_Cliente = ?, Direccion_Cliente = ? WHERE Cedula_Cliente = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssss", $nuevo_nombre, $nuevo_apellido, $nuevo_telefono, $nueva_direccion, $cedula);
        $stmt->execute();
        $stmt->close();
        echo "Datos del cliente actualizados con éxito.";
    } catch (mysqli_sql_exception $e) {
        echo "Error al actualizar los datos del cliente: " . $e->getMessage();
    }
}

// Obtener la cédula de la URL
$cedula = $_GET['cedula'];

// Obtener otros datos del cliente para mostrar en el formulario
$query = "SELECT * FROM Cliente WHERE Cedula_Cliente = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $cedula);
$stmt->execute();
$result = $stmt->get_result();
$cliente = $result->fetch_assoc();
$stmt->close();

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
        <!-- Mostrar la cédula del cliente en un campo no editable -->
        <input type="text" name="cedula" id="cedula" value="<?php echo $cliente['Cedula_Cliente']; ?>" readonly required>
        <label for="nuevo_nombre">Nuevo Nombre:</label>
        <input type="text" name="nuevo_nombre" id="nuevo_nombre" value="<?php echo $cliente['Nombre_Cliente']; ?>" required>
        <label for="nuevo_apellido">Nuevo Apellido:</label>
        <input type="text" name="nuevo_apellido" id="nuevo_apellido" value="<?php echo $cliente['Apellido_Cliente']; ?>" required>
        <label for="nuevo_telefono">Nuevo Teléfono:</label>
        <input type="text" name="nuevo_telefono" id="nuevo_telefono" value="<?php echo $cliente['Telefono_Cliente']; ?>" required>
        <label for="nueva_direccion">Nueva Dirección:</label>
        <input type="text" name="nueva_direccion" id="nueva_direccion" value="<?php echo $cliente['Direccion_Cliente']; ?>" required>
        <button type="submit">Modificar Datos</button>
    </form>
    
    <!-- Agrega el botón de "Volver" -->
    <a href="/Sistema-Administrativo/4. App Web HTML5 y PHP/2_Pagina_Clientes/0_Index_Cliente.php"><button type="button">Volver</button></a>

</body>
</html>
