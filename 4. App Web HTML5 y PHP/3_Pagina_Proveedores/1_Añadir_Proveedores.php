<?php
// Incluye el archivo de configuración
require_once(__DIR__ . '/../_ConexionBDDSA/config.php');

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

$errors = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombreComercial = validarCampo("Nombre Comercial del proveedor", $_POST['nombreComercial'], "nombreComercial");
    $nombreProveedor = validarCampo("Nombre del proveedor", $_POST['nombreProveedor'], "alfabetico");
    $apellidoProveedor = validarCampo("Apellido del proveedor", $_POST['apellidoProveedor'], "alfabetico");
    $tipoDocumento = validarCampo("Tipo de documento", $_POST['tipoDocumento'], "tipoDocumento");
    $numeroDocumento = validarCampo("Número de documento", $_POST['numeroDocumento'], "alfanumerico");
    $telefonoProveedor = validarCampo("Teléfono del proveedor", $_POST['telefonoProveedor'], "entero");
    $direccionProveedor = validarCampo("Dirección del proveedor", $_POST['direccionProveedor'], "texto");

    if (empty($errors)) {
        // Llamar a la función para crear un proveedor
        crearProveedor($conn, $nombreComercial, $nombreProveedor, $apellidoProveedor, $tipoDocumento, $numeroDocumento, $telefonoProveedor, $direccionProveedor);
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
        case "nombreComercial":
            // Permitir letras, números, signos y espacios
            if (!preg_match('/^[A-Za-z0-9 .,-]+$/', $valor)) {
                $errors[] = "El campo '$campo' puede contener letras, números, signos y espacios.";
                return "";
            }
            // Verificar que el Nombre Comercial no esté en uso
            $consultaExistencia = "SELECT Nombre_Comercial_Proveedor FROM Proveedor WHERE Nombre_Comercial_Proveedor = ?";
            $stmtExistencia = $GLOBALS['conn']->prepare($consultaExistencia);
            $stmtExistencia->bind_param("s", $valor);
            $stmtExistencia->execute();
            $stmtExistencia->store_result();

            if ($stmtExistencia->num_rows > 0) {
                $errors[] = "Error: El Nombre Comercial ya está en uso.";
                $stmtExistencia->close();
                return "";
            }

            $stmtExistencia->close();
            break;
        case "alfabetico":
            if (!ctype_alpha(str_replace(' ', '', $valor))) {
                $errors[] = "El campo '$campo' debe contener solo letras y no puede tener espacios.";
                return "";
            }
            break;
        case "tipoDocumento":
            $tiposValidos = array("V", "J", "A", "B", "C");
            if (!in_array($valor, $tiposValidos)) {
                $errors[] = "El campo '$campo' tiene un valor no válido.";
                return "";
            }
            break;
        case "alfanumerico":
            // Permitir letras y números en el número de documento
            if (!ctype_alnum($valor)) {
                $errors[] = "El campo '$campo' debe contener solo letras y números.";
                return "";
            }
            break;
        case "entero":
            if (!ctype_digit($valor)) {
                $errors[] = "El campo '$campo' debe contener solo números enteros.";
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

// Función para crear un proveedor
function crearProveedor($conn, $nombreComercial, $nombreProveedor, $apellidoProveedor, $tipoDocumento, $numeroDocumento, $telefonoProveedor, $direccionProveedor) {
    // Verificar si el Número de documento ya está en uso
    $consultaExistencia = "SELECT Numero_Documento FROM Proveedor WHERE Numero_Documento = ?";
    $stmtExistencia = $conn->prepare($consultaExistencia);
    $stmtExistencia->bind_param("s", $numeroDocumento);
    $stmtExistencia->execute();
    $stmtExistencia->store_result();

    if ($stmtExistencia->num_rows > 0) {
        echo "Error: El Número de documento ya está en uso.";
        $stmtExistencia->close();
        return;
    }

    $stmtExistencia->close();

    // Insertar el nuevo proveedor
    $query = "INSERT INTO Proveedor (Nombre_Comercial_Proveedor, Nombre_Proveedor, Apellido_Proveedor, Tipo_Documento, Numero_Documento, Telefono_Proveedor, Direccion_Proveedor) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssssss", $nombreComercial, $nombreProveedor, $apellidoProveedor, $tipoDocumento, $numeroDocumento, $telefonoProveedor, $direccionProveedor);

    if ($stmt->execute()) {
        echo "Proveedor creado con éxito.";
    } else {
        echo "Error al crear el proveedor: " . $stmt->error;
    }

    $stmt->close();
}
?>

<h1>Crear Proveedor</h1>
<form method="post">
    Nombre Comercial del proveedor: <input type="text" name="nombreComercial"><br>
    Nombre del proveedor: <input type="text" name="nombreProveedor"><br>
    Apellido del proveedor: <input type="text" name="apellidoProveedor"><br>
    Tipo de documento: 
    <select name="tipoDocumento">
        <option value="V">V</option>
        <option value="J">J</option>
        <option value="A">A</option>
        <option value="B">B</option>
        <option value="C">C</option>
    </select><br>
    Número de documento: <input type="text" name="numeroDocumento"><br>
    Teléfono del proveedor: <input type="text" name="telefonoProveedor"><br>
    Dirección del proveedor: <input type="text" name="direccionProveedor"><br>
    <input type="submit" value="Crear Proveedor">
</form>

<!-- Agrega el botón de "Volver" -->
<a href="/Sistema-Administrativo/4. App Web HTML5 y PHP/3_Pagina_Proveedores/0_Index_Proveedores.php"><button type="button">Volver</button></a>

</body>
</html>
