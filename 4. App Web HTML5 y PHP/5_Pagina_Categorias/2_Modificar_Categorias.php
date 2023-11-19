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

// Obtener el ID de la categoría de la URL
$id_categoria = isset($_GET['id_categoria']) ? $_GET['id_categoria'] : null;

if ($id_categoria === null) {
    die('ID de categoría no proporcionado en la URL.');
}

// Obtener otros datos de la categoría para mostrar en el formulario
$query = "SELECT * FROM Categorias WHERE ID_Categoria = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id_categoria);
$stmt->execute();
$result = $stmt->get_result();

if ($result === false) {
    die('Error al ejecutar la consulta: ' . $stmt->error);
}

$categoria = $result->fetch_assoc();

if ($categoria === null) {
    die('No se encontró la categoría con ID ' . $id_categoria);
}

$stmt->close();

// Verificar si se ha enviado el formulario de modificación de datos
if (isset($_POST['id_categoria'], $_POST['nuevo_nombre'], $_POST['nuevo_detalle'])) {
    $id_categoria = $_POST['id_categoria'];
    $nuevo_nombre = $_POST['nuevo_nombre'];
    $nuevo_detalle = $_POST['nuevo_detalle'];

    try {
        $query = "UPDATE Categorias SET Nombre_Categoria = ?, Detalle_Categoria = ? WHERE ID_Categoria = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssi", $nuevo_nombre, $nuevo_detalle, $id_categoria);
        $stmt->execute();
        $stmt->close();
        echo "Datos de la categoría actualizados con éxito.";
    } catch (mysqli_sql_exception $e) {
        echo "Error al actualizar los datos de la categoría: " . $e->getMessage();
    }
}

// Cerrar la conexión a la base de datos
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Modificar Categoría</title>
</head>
<body>
    <h1>Modificar Datos de la Categoría</h1>

    <form method="post">
        <label for="id_categoria">ID de la Categoría:</label>
        <!-- Mostrar el ID de la categoría en un campo no editable -->
        <input type="text" name="id_categoria" id="id_categoria" value="<?php echo $categoria['ID_Categoria']; ?>" readonly required>
        <label for="nuevo_nombre">Nuevo Nombre:</label>
        <input type="text" name="nuevo_nombre" id="nuevo_nombre" value="<?php echo $categoria['Nombre_Categoria']; ?>" required>
        <label for="nuevo_detalle">Nuevo Detalle:</label>
        <input type="text" name="nuevo_detalle" id="nuevo_detalle" value="<?php echo $categoria['Detalle_Categoria']; ?>" required>
        <button type="submit">Modificar Datos</button>
    </form>
    
    <!-- Agrega el botón de "Volver" -->
    <a href="/Sistema-Administrativo/4. App Web HTML5 y PHP/5_Pagina_Categorias/0_Index_Categorias.php"><button type="button">Volver</button></a>

</body>
</html>
