
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

    function obtenerTasaImpuesto($conn, $id_impuesto) {
      // Consulta para obtener la tasa de impuesto por ID
      $query = "SELECT Tasa_Impuesto FROM Impuestos WHERE ID_Impuestos = ?";
      $stmt = $conn->prepare($query);
  
      if (!$stmt) {
          // Manejar el error de preparación
          echo "Error al preparar la consulta: " . $conn->error;
          return false;
      } else {
          $stmt->bind_param("i", $id_impuesto);
  
          // Ejecutar la consulta
          if ($stmt->execute()) {
              // Vincular el resultado
              $stmt->bind_result($tasa_impuesto);
  
              // Obtener el valor de la tasa de impuesto
              if ($stmt->fetch()) {
                  // Devolver la tasa de impuesto
                  return $tasa_impuesto;
              } else {
                  // Devolver un valor predeterminado o manejar el caso en que no se encuentra la tasa de impuesto
                  return 0;
              }
          } else {
              // Manejar el error de ejecución
              echo "Error al obtener la tasa de impuesto: " . $stmt->error;
              return false;
          }
  
          // Cerrar la declaración preparada
          $stmt->close();
      }
      
  }

      // Realizar la eliminación directamente en la misma página si se ha enviado el formulario
    if (isset($_POST['eliminar_producto'])) {
      $id_producto = $_POST['id_producto'];

      // Eliminar registros en proveedor_has_productos
      $query_eliminar_proveedor = "DELETE FROM proveedor_has_productos WHERE Productos_ID_Producto = ?";
      $stmt_eliminar_proveedor = $conn->prepare($query_eliminar_proveedor);

      if ($stmt_eliminar_proveedor) {
          $stmt_eliminar_proveedor->bind_param("i", $id_producto);

          // Ejecutar la eliminación de proveedores
          if (!$stmt_eliminar_proveedor->execute()) {
              echo "Error al eliminar proveedores asociados al producto: " . $stmt_eliminar_proveedor->error;
              exit();
          }

          // Cerrar la declaración preparada
          $stmt_eliminar_proveedor->close();
      } else {
          echo "Error al preparar la consulta para eliminar proveedores: " . $conn->error;
          exit();
      }

      // Eliminar registros en productos_has_categorias
      $query_eliminar_categorias = "DELETE FROM productos_has_categorias WHERE Productos_ID_Producto = ?";
      $stmt_eliminar_categorias = $conn->prepare($query_eliminar_categorias);

      if ($stmt_eliminar_categorias) {
          $stmt_eliminar_categorias->bind_param("i", $id_producto);

          // Ejecutar la eliminación de categorías
          if (!$stmt_eliminar_categorias->execute()) {
              echo "Error al eliminar categorías asociadas al producto: " . $stmt_eliminar_categorias->error;
              exit();
          }

          // Cerrar la declaración preparada
          $stmt_eliminar_categorias->close();
      } else {
          echo "Error al preparar la consulta para eliminar categorías: " . $conn->error;
          exit();
      }

      // Eliminar registros en productos_has_impuestos
      $query_eliminar_impuestos = "DELETE FROM productos_has_impuestos WHERE Productos_ID_Producto = ?";
      $stmt_eliminar_impuestos = $conn->prepare($query_eliminar_impuestos);

      if ($stmt_eliminar_impuestos) {
          $stmt_eliminar_impuestos->bind_param("i", $id_producto);

          // Ejecutar la eliminación de impuestos
          if (!$stmt_eliminar_impuestos->execute()) {
              echo "Error al eliminar impuestos asociados al producto: " . $stmt_eliminar_impuestos->error;
              exit();
          }

          // Cerrar la declaración preparada
          $stmt_eliminar_impuestos->close();
      } else {
          echo "Error al preparar la consulta para eliminar impuestos: " . $conn->error;
          exit();
      }

      // Preparar la consulta de eliminación
      $query_eliminar_producto = "DELETE FROM Productos WHERE ID_Producto = ?";
      $stmt_eliminar_producto = $conn->prepare($query_eliminar_producto);

      if (!$stmt_eliminar_producto) {
          // Manejar el error de preparación
          echo "Error al preparar la consulta: " . $conn->error;
      } else {
          $stmt_eliminar_producto->bind_param("i", $id_producto);

          // Ejecutar la eliminación
          if ($stmt_eliminar_producto->execute()) {
              // Redirigir a otra página después de la eliminación
              header("Location: /Sistema-Administrativo/4. App Web HTML5 y PHP/4_Pagina_Productos/0_Index_Productos.php");
              exit();
          } else {
              echo "Error al eliminar el producto: " . $stmt_eliminar_producto->error;
          }

          // Cerrar la declaración preparada
          $stmt_eliminar_producto->close();
      }
    }

   // Realizar la consulta a la base de datos con la opción de búsqueda
$search_query = isset($_GET['q']) ? $_GET['q'] : '';
$query = "SELECT p.ID_Producto, p.Nombre_Producto, p.Codigo_Producto, p.Detalle_Producto, 
                  p.Cantidad_Producto, p.Precio_Venta, p.Precio_Costo, 
                  pr.Nombre_Comercial_Proveedor, c.Nombre_Categoria, i.Nombre_Impuesto, i.ID_Impuestos
          FROM Productos p
          LEFT JOIN proveedor_has_productos php ON p.ID_Producto = php.Productos_ID_Producto
          LEFT JOIN Proveedor pr ON php.Proveedor_ID_Proveedor = pr.ID_Proveedor
          LEFT JOIN productos_has_categorias phc ON p.ID_Producto = phc.Productos_ID_Producto
          LEFT JOIN Categorias c ON phc.Categorias_ID_Categoria = c.ID_Categoria
          LEFT JOIN productos_has_impuestos phi ON p.ID_Producto = phi.Productos_ID_Producto
          LEFT JOIN Impuestos i ON phi.Impuestos_ID_Impuestos = i.ID_Impuestos
          WHERE 
              p.Nombre_Producto LIKE '%$search_query%' OR 
              p.Codigo_Producto LIKE '%$search_query%' OR 
              p.Detalle_Producto LIKE '%$search_query%' OR 
              p.Cantidad_Producto LIKE '%$search_query%' OR 
              p.Precio_Venta LIKE '%$search_query%' OR 
              p.Precio_Costo LIKE '%$search_query%' OR 
              pr.Nombre_Comercial_Proveedor LIKE '%$search_query%' OR  
              c.Nombre_Categoria LIKE '%$search_query%' OR           
              i.Nombre_Impuesto LIKE '%$search_query%'";             

    $result = $conn->query($query);
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

  <div class="search">
    <form action="" method="get" class="search-bar">
      <input type="text" placeholder="Busca aquí" name="q" value="<?php echo isset($_GET['q']) ? htmlspecialchars($_GET['q']) : ''; ?>">
      <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
    </form>

    <div class="funciones">
      <button type="submit"><img src="assets/img/Añadir 2.gif" alt=""></button>
      <a href="/Sistema-Administrativo/4. App Web HTML5 y PHP/4_Pagina_Productos/1_Añadir_Productos.php">Añadir Producto</a>
      <button type="submit"><img src="assets/img/Añadir.gif" alt=""></button>
    </div>
  </div>

  <div class="container">
    <table>
      <thead>
        <tr>
          <th>ID Producto</th>
          <th>Nombre</th>
          <th>Código</th>
          <th>Detalle</th>
          <th>Cantidad</th>
          <th>Precio Venta</th>
          <th>Precio Costo</th>
          <th>Proveedor</th>
          <th>Categoría</th>
          <th>Impuesto</th>
          <th>Modificar/Eliminar</th>
        </tr>
      </thead>
      <tbody>
        <?php
        // Mostrar datos en la tabla
        while ($row = $result->fetch_assoc()) {
          echo "<tr>";
          echo "<td>" . $row['ID_Producto'] . "</td>";
          echo "<td>" . $row['Nombre_Producto'] . "</td>";
          echo "<td>" . $row['Codigo_Producto'] . "</td>";
          echo "<td>" . $row['Detalle_Producto'] . "</td>";
          echo "<td>" . $row['Cantidad_Producto'] . "</td>";
          echo "<td>" . $row['Precio_Venta'] . "</td>";
          echo "<td>" . $row['Precio_Costo'] . "</td>";
          echo "<td>" . $row['Nombre_Comercial_Proveedor'] . "</td>";
          echo "<td>" . $row['Nombre_Categoria'] . "</td>";
          echo "<td>" . $row['Nombre_Impuesto'] . " (" . obtenerTasaImpuesto($conn, $row['ID_Impuestos']) . ")</td>";
          echo "<td>";

          // Botón Modificar Producto (Ayuda.gif)
          echo "<a href='/Sistema-Administrativo/4. App Web HTML5 y PHP/4_Pagina_Productos/2_Modificar_Productos.php?id=" . $row['ID_Producto'] . "'>";
          echo "<button><img src='assets/img/Editar.gif' alt=''></button>";
          echo "</a>";

          // Botón Eliminar Producto (Eliminar.gif)
          echo "<form method='post'>";
          echo "<input type='hidden' name='id_producto' value='" . $row['ID_Producto'] . "'>";
          echo "<button type='submit' name='eliminar_producto'><img src='assets/img/Eliminar.gif' alt=''></button>";
          echo "</form>";

          echo "</td>";
          echo "</tr>";
        }
        ?>
      </tbody>
    </table>
  </div>
  
</body>
</html>