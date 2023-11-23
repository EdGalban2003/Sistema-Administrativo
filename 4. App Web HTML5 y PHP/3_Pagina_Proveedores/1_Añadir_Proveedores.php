<?php
// Incluye el archivo de configuración
require_once(__DIR__ . '/../_ConexionBDDSA/config.php');

// Configurar la ubicación personalizada para los archivos de sesión
session_save_path(__DIR__ . '/../_ConexionBDDSA/Sesiones/');
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
            $tiposValidos = array("V", "E", "P", "J", "G");
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

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Infinity Technology</title>
  <link rel="stylesheet" href="assets/css/styles.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:400,400i,700,700i">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
  <header>
    <div class="interior">
      <a href="/Sistema-Administrativo/4. App Web HTML5 y PHP/1_Pagina_Menu_Principal/0_Index_MenuPrincipal.html" class="logo"><img src="./assets/img/infinity.png" alt=""></a>
      <nav class="navegacion">
      <ul>
        <li class="submenu">
          <a href="#">Catálogos</a>
          <ul class="hijos">
          <li ><a href="/Sistema-Administrativo/4. App Web HTML5 y PHP/2_Pagina_Clientes/0_Index_Cliente.php">Clientes</a></li>
            <li class="link"><a href="/Sistema-Administrativo/4. App Web HTML5 y PHP/3_Pagina_Proveedores/0_Index_Proveedores.php">Proveedores</a></li>
            <li ><a href="/Sistema-Administrativo/4. App Web HTML5 y PHP/4_Pagina_Productos/0_Index_Productos.php">Productos</a></li>
            <li ><a href="/Sistema-Administrativo/4. App Web HTML5 y PHP/5_Pagina_Categorias/0_Index_Categorias.php">Categorias</a></li>
            <li ><a href="/Sistema-Administrativo/4. App Web HTML5 y PHP/7_Pagina_Impuestos/0_Index_Impuestos.php">Impuestos</a></li>
          </ul>
        </li>    
        <li class="submenu">
          <a href="">Movimientos</a>
          <ul class="hijos">
            <li><a href="/Sistema-Administrativo/4. App Web HTML5 y PHP/6_Pagina_Recibos/0_Index_Recibos.php">Recibo</a></li>
            <li><a href="/Sistema-Administrativo/4. App Web HTML5 y PHP/8_Pagina_CierreDeCaja/0_Index_CierreCaja.php">Cierre de Caja</a></li>
            <li><a href="/Sistema-Administrativo/4. App Web HTML5 y PHP/8.1_Inventario
              /0_Index_CierreCaja.php">Inventario</a></li>
          </ul>
        </li>
        <li class="submenu">
          <a href="">Reportes</a>
          <ul class="hijos">
            <li><a href="/Sistema-Administrativo/4. App Web HTML5 y PHP/14_Pagina_Reportes/0_Index_Cliente.php">Clientes</a></li>
            <li><a href="/Sistema-Administrativo/4. App Web HTML5 y PHP/14_Pagina_Reportes/1_Index_Proveedores.php">Proveedores</a></li>
            <li><a href="/Sistema-Administrativo/4. App Web HTML5 y PHP/14_Pagina_Reportes/2_Index_Productos.php">Productos</a></li>
            <li><a href="/Sistema-Administrativo/4. App Web HTML5 y PHP/14_Pagina_Reportes/3_Index_Auditoria.php">Auditoria</a></li>
            <li><a href="/Sistema-Administrativo/4. App Web HTML5 y PHP/14_Pagina_Reportes/4_Index_CierreCaja.php">Cierre de Caja</a></li>
            <li><a href="/Sistema-Administrativo/4. App Web HTML5 y PHP/14_Pagina_Reportes/5_Index_Reimprimir.php">Reimprimir Recibo</a></li>
          </ul>
        </li>
        <li class="submenu">
          <a href="">Mantenimiento</a>
          <ul class="hijos">
            <li><a href="/Sistema-Administrativo/4. App Web HTML5 y PHP/9_Pagina_Auditoria/0_Index_Auditoria.php">Auditoria</a></li>
            <li><a href="/Sistema-Administrativo/4. App Web HTML5 y PHP/12_Pagina_Mantenimiento/0_Index_Respaldar.html">Respaldar</a></li>
          </ul>
        </li>
        <li class="submenu">
          <a href="">Ayuda</a>
          <ul class="hijos">
            <li><a href="/Sistema-Administrativo/4. App Web HTML5 y PHP/11_Pagina_AcercaDe/0_Index_AcercaDe.html">Acerca de</a></li>
            <li><a href="/Sistema-Administrativo/4. App Web HTML5 y PHP/10_Pagina_Manual/0_Index_Manual.php">Manual de Usuario</a></li>
            <li><a href="/Sistema-Administrativo/4. App Web HTML5 y PHP/15_Pagina_InfoSistema/0_Index_AcercaDe.html">Información de Sistema</a></li>
          </ul>
        </li>
        <li class="submenu">
          <a href="">Configuración</a>
          <ul class="hijos">
            <li><a href="/Sistema-Administrativo/4. App Web HTML5 y PHP/13_Pagina_Configuracion/0_Index_Configuracion.html">Información del Negocio</a></li>
          </ul>
        </li>
        <li class="submenu">
          <a href=""><i class="fa-solid fa-circle-user fa-2xl" style="font-size: 3em;" ></i></a>
          <ul class="hijos user">
            <li><a href="/Sistema-Administrativo/4. App Web HTML5 y PHP/0_Pagina_Usuarios-Login/0_Menu_Usuarios_Opciones.html">Opciones</a></li>
            <li><a href="/Sistema-Administrativo/4. App Web HTML5 y PHP/0_Pagina_Usuarios-Login/7_CerrarSesion.php">Cerrar Sesión</a></li>
          </ul>
        </li>
      </ul>
      </nav>
    </div>
  </header>


<h1>Crear Proveedor</h1>
<form method="post">
    Nombre Comercial del proveedor: <input type="text" name="nombreComercial"><br>
    Nombre del proveedor: <input type="text" name="nombreProveedor"><br>
    Apellido del proveedor: <input type="text" name="apellidoProveedor"><br>
    Tipo de documento: 
    <select name="tipoDocumento">
        <option value="V">V</option>
        <option value="E">E</option>
        <option value="P">P</option>
        <option value="J">J</option>
        <option value="G">G</option>
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
