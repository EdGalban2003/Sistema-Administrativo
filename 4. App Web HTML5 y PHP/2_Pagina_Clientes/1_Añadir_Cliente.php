<?php
// Incluye el archivo de configuración
require_once(__DIR__ . '/../_ConexionBDDSA/config.php');

// Configurar la ubicación personalizada para los archivos de sesión
session_save_path(__DIR__ . '/../_ConexionBDDSA/Sesiones/');
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


<h1>Crear Cliente</h1>
<form method="post">
    Cédula del cliente: <input type="text" name="cedula"><br>
    Nombre del cliente: <input type="text" name="nombre"><br>
    Apellido del cliente: <input type="text" name="apellido"><br>
    Teléfono del cliente: <input type="text" name="telefono"><br>
    Dirección del cliente: <input type="text" name="direccion"><br>
    <input type="submit" value="Crear Cliente">
</form>

    <!-- Agrega el botón de "Volver" -->
    <a href="/Sistema-Administrativo/4. App Web HTML5 y PHP/2_Pagina_Clientes/0_Index_Cliente.php"><button type="button">Volver</button></a>

</body>
</html>
