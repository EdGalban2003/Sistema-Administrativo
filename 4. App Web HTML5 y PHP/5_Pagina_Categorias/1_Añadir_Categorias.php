<!DOCTYPE html>
<html>
<head>
    <title>Crear Categoría</title>
</head>
<body>

<?php
// Incluye el archivo de configuración
require_once(__DIR__ . '/../_ConexionBDDSA/config.php');

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

$errors = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = validarCampo("Nombre de la categoría", $_POST['nombre'], "alfabetico_espacios");
    $detalle = validarCampo("Detalle de la categoría", $_POST['detalle'], "texto");

    if (empty($errors)) {
        // Llamar a la función para crear una categoría
        crearCategoria($conn, $nombre, $detalle);
    } else {
        // Mostrar errores
        foreach ($errors as $error) {
            echo $error . "<br>";
        }
    }
}

// Función para validar un campo
function validarCampo($campo, $valor, $tipo) {
    global $errors;
    
    // Eliminar espacios en blanco al principio y al final
    $valor = trim($valor);

    if ($valor === "") {
        $errors[] = "El campo '$campo' no puede estar vacío.";
        return "";
    }

    switch ($tipo) {
        case "alfabetico_espacios":
            if (!preg_match('/^[a-zA-Z\s]+$/', $valor)) {
                $errors[] = "El campo '$campo' debe contener solo letras y espacios.";
                return "";
            }
            break;
        case "texto":
            // Permitir espacios en blanco para campos de texto
            break;
        default:
            $errors[] = "Tipo de validación no válido para el campo '$campo'.";
            return "";
    }

    return $valor;
}

// Función para crear una categoría
function crearCategoria($conn, $nombre, $detalle) {
    // Verificar si el nombre de la categoría ya está en uso
    $consultaExistencia = "SELECT Nombre_Categoria FROM Categorias WHERE Nombre_Categoria = ?";
    $stmtExistencia = $conn->prepare($consultaExistencia);
    $stmtExistencia->bind_param("s", $nombre);
    $stmtExistencia->execute();
    $stmtExistencia->store_result();

    if ($stmtExistencia->num_rows > 0) {
        echo "Error: El nombre de la categoría ya está en uso.";
        $stmtExistencia->close();
        return;
    }

    $stmtExistencia->close();

    // Insertar la nueva categoría
    $query = "INSERT INTO Categorias (Nombre_Categoria, Detalle_Categoria) VALUES (?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $nombre, $detalle);

    if ($stmt->execute()) {
        echo "Categoría creada con éxito.";
    } else {
        echo "Error al crear la categoría: " . $stmt->error;
    }

    $stmt->close();
}
?>

<h1>Crear Categoría</h1>
<form method="post">
    Nombre de la categoría: <input type="text" name="nombre"><br>
    Detalle de la categoría: <input type="text" name="detalle"><br>
    <input type="submit" value="Crear Categoría">
</form>

<!-- Agrega el botón de "Volver" -->
<a href="/Sistema-Administrativo/4. App Web HTML5 y PHP/5_Pagina_Categorias/0_Index_Categorias.php"><button type="button">Volver</button></a>

</body>
</html>
