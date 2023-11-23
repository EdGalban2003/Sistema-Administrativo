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

// Obtener datos para las opciones desplegables
$proveedores = obtenerOpcionesDesplegables($conn, 'Proveedor', 'Nombre_Comercial_Proveedor', 'ID_Proveedor');
$categorias = obtenerOpcionesDesplegables($conn, 'Categorias', 'Nombre_Categoria', 'ID_Categoria');
$impuestos = obtenerOpcionesDesplegables($conn, 'Impuestos', 'Nombre_Impuesto', 'ID_Impuestos');

$errors = array();
$idImpuesto = '';  // Inicializar la variable $idImpuesto

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $codigoProducto = validarCampo("Código del producto", $_POST['codigoProducto'], "texto");
    $nombreProducto = validarCampo("Nombre del producto", $_POST['nombreProducto'], "texto");
    $detalleProducto = validarCampo("Detalle del producto", $_POST['detalleProducto'], "texto");
    $cantidadProducto = validarCampo("Cantidad del producto", $_POST['cantidadProducto'], "entero");
    $precioVenta = validarCampo("Precio de venta", $_POST['precioVenta'], "decimal");
    $precioCosto = validarCampo("Precio costo", $_POST['precioCosto'], "decimal");

    // Validar las opciones desplegables seleccionadas
    $idProveedor = validarCampoDesplegable("Proveedor", $_POST['proveedor'], $proveedores);
    $idCategoria = validarCampoDesplegable("Categoría", $_POST['categoria'], $categorias);
    $idImpuesto = validarCampoDesplegable("Impuesto", $_POST['impuesto'], $impuestos);

    if (empty($errors)) {
        // Llamar a la función para crear un producto
        crearProducto($conn, $codigoProducto, $nombreProducto, $detalleProducto, $cantidadProducto, $precioVenta, $precioCosto, $idProveedor, $idCategoria, $idImpuesto);
    } else {
        // Mostrar errores
        foreach ($errors as $error) {
            echo $error . "<br>";
        }
    }
}

// Función para obtener opciones para las opciones desplegables
function obtenerOpcionesDesplegables($conn, $tabla, $campoNombre, $campoID) {
    $opciones = array();
    $query = "SELECT $campoID, $campoNombre FROM $tabla";
    $result = $conn->query($query);

    while ($row = $result->fetch_assoc()) {
        $opciones[$row[$campoID]] = $row[$campoNombre];
    }

    return $opciones;
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
        case "entero":
            if (!ctype_digit($valor)) {
                $errors[] = "El campo '$campo' debe contener solo números enteros.";
                return "";
            }
            break;
        case "decimal":
            if (!is_numeric($valor)) {
                $errors[] = "El campo '$campo' debe contener un número decimal.";
                return "";
            }
            break;
        case "texto":
            // Permitir cualquier tipo de texto, incluidos espacios
            break;
        default:
            $errors[] = "Tipo de validación no válido para el campo '$campo'.";
            return "";
    }

    return $valor;
}

// Función para validar una opción desplegable seleccionada
function validarCampoDesplegable($campo, $valor, $opciones) {
    global $errors;

    if (!array_key_exists($valor, $opciones)) {
        $errors[] = "La opción seleccionada para '$campo' no es válida.";
        return "";
    }

    return $valor;
}

// Función para crear un producto
function crearProducto($conn, $codigoProducto, $nombreProducto, $detalleProducto, $cantidadProducto, $precioVenta, $precioCosto, $idProveedor, $idCategoria, $idImpuesto) {
    // Verificar si ya existe un producto con el mismo código
    $queryVerificarCodigo = "SELECT ID_Producto FROM Productos WHERE Codigo_Producto = ?";
    $stmtVerificarCodigo = $conn->prepare($queryVerificarCodigo);
    $stmtVerificarCodigo->bind_param("s", $codigoProducto);
    $stmtVerificarCodigo->execute();
    $stmtVerificarCodigo->store_result();

    if ($stmtVerificarCodigo->num_rows > 0) {
        echo "Error: Ya existe un producto con el código '$codigoProducto'.";
        $stmtVerificarCodigo->close();
        return;
    }

    $stmtVerificarCodigo->close();

    // Insertar el nuevo producto con los campos "Precio Costo" y "Precio Venta"
    $query = "INSERT INTO Productos (Codigo_Producto, Nombre_Producto, Detalle_Producto, Cantidad_Producto, Precio_Venta, Precio_Costo) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssid", $codigoProducto, $nombreProducto, $detalleProducto, $cantidadProducto, $precioVenta, $precioCosto);

    if ($stmt->execute()) {
        // Obtener el ID del producto recién insertado
        $idProducto = $stmt->insert_id;

        // Asociar producto con proveedor
        $queryProveedor = "INSERT INTO proveedor_has_productos (Proveedor_ID_Proveedor, Productos_ID_Producto) VALUES (?, ?)";
        $stmtProveedor = $conn->prepare($queryProveedor);
        $stmtProveedor->bind_param("ii", $idProveedor, $idProducto);
        $stmtProveedor->execute();

        // Asociar producto con categoría
        $queryCategoria = "INSERT INTO productos_has_categorias (Productos_ID_Producto, Categorias_ID_Categoria) VALUES (?, ?)";
        $stmtCategoria = $conn->prepare($queryCategoria);
        $stmtCategoria->bind_param("ii", $idProducto, $idCategoria);
        $stmtCategoria->execute();

        // Asociar producto con impuesto
        $queryImpuesto = "INSERT INTO productos_has_impuestos (Productos_ID_Producto, Impuestos_ID_Impuestos) VALUES (?, ?)";
        $stmtImpuesto = $conn->prepare($queryImpuesto);
        $stmtImpuesto->bind_param("ii", $idProducto, $idImpuesto);
        $stmtImpuesto->execute();

        echo "Producto creado con éxito.";
    } else {
        echo "Error al crear el producto: " . $stmt->error;
    }

    $stmt->close();
    $stmtProveedor->close();
    $stmtCategoria->close();
    $stmtImpuesto->close();
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

  
    <h1>Añadir Producto</h1>
    <form method="post">
        Código del producto: <input type="text" name="codigoProducto"><br>
        Nombre del producto: <input type="text" name="nombreProducto"><br>
        Detalle del producto: <input type="text" name="detalleProducto"><br>
        Cantidad del producto: <input type="text" name="cantidadProducto"><br>
        Precio de venta: <input type="text" name="precioVenta"><br>
        Precio costo: <input type="text" name="precioCosto"><br>

        <!-- Opciones desplegables para proveedores, categorías e impuestos -->
        Proveedor: <select name="proveedor"><?php foreach ($proveedores as $id => $nombre) { echo "<option value=\"$id\">$nombre</option>"; } ?></select><br>
        Categoría: <select name="categoria"><?php foreach ($categorias as $id => $nombre) { echo "<option value=\"$id\">$nombre</option>"; } ?></select><br>
        Impuesto: <select name="impuesto"><?php foreach ($impuestos as $id => $nombre) { echo "<option value=\"$id\">$nombre</option>"; } ?></select><br>

        <input type="submit" value="Añadir Producto">
    </form>

    <!-- Agrega el botón de "Volver" -->
    <a href="/Sistema-Administrativo/4. App Web HTML5 y PHP/4_Pagina_Productos/0_Index_Productos.php"><button type="button">Volver</button></a>
</body>
</html>
