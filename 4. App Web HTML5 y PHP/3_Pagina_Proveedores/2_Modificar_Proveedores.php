<?php
// Incluye el archivo de configuración
require('G:\Repositorios Github\Sistema-Administrativo\4. App Web HTML5 y PHP\_ConexionBDDSA\config.php');

// Iniciar sesión o reanudar la sesión existente
session_save_path('G:\Repositorios Github\Sistema-Administrativo\4. App Web HTML5 y PHP\_ConexionBDDSA\Sesiones');
session_start();

// Verificar si el usuario ya ha iniciado sesión
if (!empty($_SESSION['nombre_usuario'])) {
    $nombre_usuario = $_SESSION['nombre_usuario'];
} else {
    // Si no hay un usuario en la sesión, redirige o realiza alguna acción adecuada
    echo "<h2>Acceso Denegado</h2>";
    exit;
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
if (isset($_POST['id_proveedor'], $_POST['nuevo_nombre'], $_POST['nuevo_apellido'], $_POST['nuevo_telefono'], $_POST['nueva_direccion'])) {
    $id_proveedor = $_POST['id_proveedor'];
    $nuevo_nombre = $_POST['nuevo_nombre'];
    $nuevo_apellido = $_POST['nuevo_apellido'];
    $nuevo_telefono = $_POST['nuevo_telefono'];
    $nueva_direccion = $_POST['nueva_direccion'];

    try {
        $query = "UPDATE Proveedor SET Nombre_Proveedor = ?, Apellido_Proveedor = ?, Telefono_Proveedor = ?, Direccion_Proveedor = ? WHERE ID_Proveedor = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssss", $nuevo_nombre, $nuevo_apellido, $nuevo_telefono, $nueva_direccion, $id_proveedor);
        $stmt->execute();
        $stmt->close();
        echo "Datos del proveedor actualizados con éxito.";
    } catch (mysqli_sql_exception $e) {
        echo "Error al actualizar los datos del proveedor: " . $e->getMessage();
    }
}

// Obtener el ID del proveedor de la URL
$id_proveedor = $_GET['id_proveedor'];

// Obtener otros datos del proveedor para mostrar en el formulario
$query = "SELECT * FROM Proveedor WHERE ID_Proveedor = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $id_proveedor);
$stmt->execute();
$result = $stmt->get_result();
$proveedor = $result->fetch_assoc();
$stmt->close();

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
        <label for="id_proveedor">ID del Proveedor:</label>
        <!-- Mostrar el ID del proveedor en un campo no editable -->
        <input type="text" name="id_proveedor" id="id_proveedor" value="<?php echo $proveedor['ID_Proveedor']; ?>" readonly required>
        <label for="nuevo_nombre">Nuevo Nombre:</label>
        <input type="text" name="nuevo_nombre" id="nuevo_nombre" value="<?php echo $proveedor['Nombre_Proveedor']; ?>" required>
        <label for="nuevo_apellido">Nuevo Apellido:</label>
        <input type="text" name="nuevo_apellido" id="nuevo_apellido" value="<?php echo $proveedor['Apellido_Proveedor']; ?>" required>
        <label for="nuevo_telefono">Nuevo Teléfono:</label>
        <input type="text" name="nuevo_telefono" id="nuevo_telefono" value="<?php echo $proveedor['Telefono_Proveedor']; ?>" required>
        <label for="nueva_direccion">Nueva Dirección:</label>
        <input type="text" name="nueva_direccion" id="nueva_direccion" value="<?php echo $proveedor['Direccion_Proveedor']; ?>" required>
        <button type="submit">Modificar Datos</button>
    </form>
    
    <!-- Agrega el botón de "Volver" -->
    <a href="/Sistema-Administrativo/4. App Web HTML5 y PHP/3_Pagina_Proveedores/0_Index_Proveedores.php"><button type="button">Volver</button></a>

</body>
</html>
