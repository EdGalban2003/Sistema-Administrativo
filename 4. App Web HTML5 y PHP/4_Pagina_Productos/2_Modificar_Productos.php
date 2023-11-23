<?php
// Incluye el archivo de configuración
require('G:\Repositorios Github\Sistema-Administrativo\4. App Web HTML5 y PHP\_ConexionBDDSA\config.php');

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

// Obtener opciones para proveedores, categorías e impuestos
$proveedores = obtenerOpcionesDesplegables($conn, 'Proveedor', 'Nombre_Comercial_Proveedor', 'ID_Proveedor');
$categorias = obtenerOpcionesDesplegables($conn, 'Categorias', 'Nombre_Categoria', 'ID_Categoria');
$impuestos = obtenerOpcionesDesplegables($conn, 'Impuestos', 'Nombre_Impuesto', 'ID_Impuestos');

// Verificar si se ha enviado el formulario de modificación de datos
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_producto = isset($_POST['id_producto']) ? $_POST['id_producto'] : '';
    $codigoProducto = $_POST['codigoProducto'];
    $nombreProducto = $_POST['nombreProducto'];
    $detalleProducto = $_POST['detalleProducto'];
    $cantidadProducto = $_POST['cantidadProducto'];
    $precioVenta = $_POST['precioVenta'];
    $precioCosto = $_POST['precioCosto'];
    $idProveedor = $_POST['proveedor'];
    $idCategoria = $_POST['categoria'];
    $idImpuesto = $_POST['impuesto'];

    // Validar los datos del formulario (puedes reutilizar la función validarCampo de tu código anterior)

    // Llamar a la función para modificar un producto
    $modificacionExitosa = modificarProducto($conn, $id_producto, $codigoProducto, $nombreProducto, $detalleProducto, $cantidadProducto, $precioVenta, $precioCosto, $idProveedor, $idCategoria, $idImpuesto);
    
    // Establecer el mensaje de éxito si la modificación fue exitosa
    if ($modificacionExitosa) {
        $mensajeExito = "Producto modificado con éxito.";
    }
}

// Obtener el ID del producto de la URL
$id_producto = isset($_GET['id']) ? $_GET['id'] : '';

if (!empty($id_producto)) {
    // Obtener otros datos del producto para mostrar en el formulario
    $query = "SELECT * FROM Productos WHERE ID_Producto = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id_producto);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $producto = $result->fetch_assoc();
    } else {
        echo "Error: No se encontró el producto con ID $id_producto.";
    }
    
    $stmt->close();
} else {
    echo "Error: ID de producto no válido.";
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

// Función para modificar un producto
function modificarProducto($conn, $id_producto, $codigoProducto, $nombreProducto, $detalleProducto, $cantidadProducto, $precioVenta, $precioCosto, $idProveedor, $idCategoria, $idImpuesto) {
    // Actualizar el producto con el campo "Precio Costo"
    $query = "UPDATE Productos SET Codigo_Producto=?, Nombre_Producto=?, Detalle_Producto=?, Cantidad_Producto=?, Precio_Venta=?, Precio_Costo=? WHERE ID_Producto=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssddi", $codigoProducto, $nombreProducto, $detalleProducto, $cantidadProducto, $precioVenta, $precioCosto, $id_producto);

    if ($stmt->execute()) {
        // Actualizar la asociación con proveedor
        $queryProveedor = "UPDATE proveedor_has_productos SET Proveedor_ID_Proveedor=? WHERE Productos_ID_Producto=?";
        $stmtProveedor = $conn->prepare($queryProveedor);
        $stmtProveedor->bind_param("ii", $idProveedor, $id_producto);
        $stmtProveedor->execute();

        // Actualizar la asociación con categoría
        $queryCategoria = "UPDATE productos_has_categorias SET Categorias_ID_Categoria=? WHERE Productos_ID_Producto=?";
        $stmtCategoria = $conn->prepare($queryCategoria);
        $stmtCategoria->bind_param("ii", $idCategoria, $id_producto);
        $stmtCategoria->execute();

        // Actualizar la asociación con impuesto
        $queryImpuesto = "UPDATE productos_has_impuestos SET Impuestos_ID_Impuestos=? WHERE Productos_ID_Producto=?";
        $stmtImpuesto = $conn->prepare($queryImpuesto);
        $stmtImpuesto->bind_param("ii", $idImpuesto, $id_producto);
        $stmtImpuesto->execute();

        
        // Devolver true si la modificación fue exitosa
        return true;
        } else {
            echo "Error al modificar el producto: " . $stmt->error;
            // Devolver false si hubo un error en la modificación
            return false;
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

    <h1>Modificar Producto</h1>
    <form method="post">
        <input type="hidden" name="id_producto" value="<?php echo $producto['ID_Producto']; ?>">
        <label for="codigoProducto">Código del producto:</label>
        <input type="text" name="codigoProducto" id="codigoProducto" value="<?php echo $producto['Codigo_Producto']; ?>" required>
        <label for="nombreProducto">Nombre del producto:</label>
        <input type="text" name="nombreProducto" id="nombreProducto" value="<?php echo $producto['Nombre_Producto']; ?>" required>
        <label for="detalleProducto">Detalle del producto:</label>
        <input type="text" name="detalleProducto" id="detalleProducto" value="<?php echo $producto['Detalle_Producto']; ?>" required>
        <label for="cantidadProducto">Cantidad del producto:</label>
        <input type="text" name="cantidadProducto" id="cantidadProducto" value="<?php echo $producto['Cantidad_Producto']; ?>" required>
        <label for="precioVenta">Precio de venta:</label>
        <input type="text" name="precioVenta" id="precioVenta" value="<?php echo $producto['Precio_Venta']; ?>" required>
        <label for="precioCosto">Precio costo:</label>
        <input type="text" name="precioCosto" id="precioCosto" value="<?php echo $producto['Precio_Costo']; ?>" required>

        <!-- Opciones desplegables para proveedores, categorías e impuestos -->
        <label for="proveedor">Proveedor:</label>
        <select name="proveedor" id="proveedor">
            <?php foreach ($proveedores as $id => $nombre) { 
                $selected = ($id == $producto['Proveedor_ID_Proveedor']) ? 'selected' : '';
                echo "<option value=\"$id\" $selected>$nombre</option>"; 
            } ?>
        </select><br>

        <label for="categoria">Categoría:</label>
        <select name="categoria" id="categoria">
            <?php foreach ($categorias as $id => $nombre) { 
                $selected = ($id == $producto['Categorias_ID_Categoria']) ? 'selected' : '';
                echo "<option value=\"$id\" $selected>$nombre</option>"; 
            } ?>
        </select><br>

        <label for="impuesto">Impuesto:</label>
        <select name="impuesto" id="impuesto">
            <?php foreach ($impuestos as $id => $nombre) { 
                $selected = ($id == $producto['Impuestos_ID_Impuestos']) ? 'selected' : '';
                echo "<option value=\"$id\" $selected>$nombre</option>"; 
            } ?>
        </select><br>

        <button type="submit">Modificar Datos</button>
    </form>
    
    <!-- Agrega el botón de "Volver" -->
    <a href="/Sistema-Administrativo/4. App Web HTML5 y PHP/4_Pagina_Productos/0_Index_Productos.php"><button type="button">Volver</button></a>

    <script>
        function mostrarTasaImpuesto(idImpuesto) {
            // Realizar una solicitud AJAX para obtener la tasa de impuestos del servidor
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    // Mostrar la tasa de impuestos en el span correspondiente
                    document.getElementById("tasaImpuesto").textContent = xhr.responseText;
                }
            };
            xhr.open("GET", "obtener_tasa_impuesto.php?id=" + idImpuesto, true);
            xhr.send();
        }
    </script>

        <!-- Mostrar mensaje de éxito si existe -->
    <?php if (!empty($mensajeExito)): ?>
        <div style="color: green; font-weight: bold;"><?php echo $mensajeExito; ?></div>
    <?php endif; ?>

</body>
</html>
