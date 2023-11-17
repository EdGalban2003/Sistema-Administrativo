<!DOCTYPE html>
<html>
<head>
    <title>Crear Cliente</title>
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
    $cedula = validarCampo("Cédula del cliente", $_POST['cedula'], "entero");
    $nombre = validarCampo("Nombre del cliente", $_POST['nombre'], "alfabetico");
    $apellido = validarCampo("Apellido del cliente", $_POST['apellido'], "alfabetico");
    $telefono = validarCampo("Teléfono del cliente", $_POST['telefono'], "entero");
    $direccion = validarCampo("Dirección del cliente", $_POST['direccion'], "texto");

    if (empty($errors)) {
        // Llamar a la función para crear un cliente
        crearCliente($conn, $cedula, $nombre, $apellido, $telefono, $direccion);
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

    // Validar que no haya espacios (excepto para la dirección)
    if ($tipo !== "texto" && strpos($valor, ' ') !== false) {
        $errors[] = "El campo '$campo' no puede contener espacios.";
        return "";
    }

    switch ($tipo) {
        case "entero":
            if (!ctype_digit($valor)) {
                $errors[] = "El campo '$campo' debe contener solo números enteros.";
                return "";
            }
            break;
        case "alfabetico":
            if (!ctype_alpha(str_replace(' ', '', $valor))) {
                $errors[] = "El campo '$campo' debe contener solo letras y no puede tener espacios.";
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

// Función para crear un cliente
function crearCliente($conn, $cedula, $nombre, $apellido, $telefono, $direccion) {
    // Verificar si la Cédula ya está en uso
    $consultaExistencia = "SELECT Cedula_Cliente FROM Cliente WHERE Cedula_Cliente = ?";
    $stmtExistencia = $conn->prepare($consultaExistencia);
    $stmtExistencia->bind_param("s", $cedula);
    $stmtExistencia->execute();
    $stmtExistencia->store_result();

    if ($stmtExistencia->num_rows > 0) {
        echo "Error: La Cédula ya está en uso.";
        $stmtExistencia->close();
        return;
    }

    $stmtExistencia->close();

    // Insertar el nuevo cliente
    $query = "INSERT INTO Cliente (Cedula_Cliente, Nombre_Cliente, Apellido_Cliente, Telefono_Cliente, Direccion_Cliente) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssss", $cedula, $nombre, $apellido, $telefono, $direccion);

    if ($stmt->execute()) {
        echo "Cliente creado con éxito.";
    } else {
        echo "Error al crear el cliente: " . $stmt->error;
    }

    $stmt->close();
}
?>

<h1>Crear Cliente</h1>
<form method="post">
    Cédula del cliente: <input type="text" name="cedula"><br>
    Nombre del cliente: <input type="text" name="nombre"><br>
    Apellido del cliente: <input type="text" name="apellido"><br>
    Teléfono del cliente: <input type="text" name="telefono"><br>
    Dirección del cliente: <input type="text" name="direccion"><br>
    <input type="submit" value="Crear Cliente">
</form>

<!-- Botón "Volver" -->
<button onclick="window.history.back()">Volver</button>

</body>
</html>
