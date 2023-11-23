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

    // Inicializar la variable de conexión fuera del bloque try-catch
    $conn = null;

    try {
        // Intenta la conexión con la base de datos después de actualizar el archivo config.php
        $conn = new mysqli($db_config['host'], $nombre_usuario, '', $db_config['database']);
    } catch (mysqli_sql_exception $e) {
        // Muestra un mensaje personalizado en caso de un error de acceso
        echo "<h2>Acceso Denegado</h2>";
        exit;
    }

    // Realizar la eliminación directamente en la misma página si se ha enviado el formulario
    if (isset($_POST['eliminar_impuesto'])) {
        $id_impuesto = $_POST['id_impuesto'];

        // Preparar la consulta de eliminación
        $query = "DELETE FROM Impuestos WHERE ID_Impuestos = ?";
        $stmt = $conn->prepare($query);

        if (!$stmt) {
            // Manejar el error de preparación
            echo "Error al preparar la consulta: " . $conn->error;
        } else {
            $stmt->bind_param("s", $id_impuesto);

            // Ejecutar la eliminación
            if ($stmt->execute()) {
                // Redirigir a otra página después de la eliminación
                header("/Sistema-Administrativo/4. App Web HTML5 y PHP/7_Pagina_Impuestos/0_Index_Impuestos.php");
                exit(); 
            } else {
                echo "Error al eliminar el impuesto: " . $stmt->error;
            }

            // Cerrar la declaración preparada
            $stmt->close();
        }
    }

    // Realizar la consulta a la base de datos con la opción de búsqueda para la tabla de Impuestos
    $search_query = isset($_GET['q']) ? $_GET['q'] : '';
    $query = "SELECT * FROM Impuestos WHERE 
              ID_Impuestos LIKE '%$search_query%' OR 
              Nombre_Impuesto LIKE '%$search_query%' OR 
              Tasa_Impuesto LIKE '%$search_query%' OR 
              Descripcion_Impuesto LIKE '%$search_query%'";

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
        <a href="/Sistema-Administrativo/4. App Web HTML5 y PHP/7_Pagina_Impuestos/1_Añadir_Impuestos.php">Añadir Impuesto</a>
        <button type="submit"><img src="assets/img/Añadir.gif" alt=""></button>
    </div>
  </div>

  <div class="container">
    <table>
        <thead>
            <tr>
                <th>ID Impuesto</th>
                <th>Nombre</th>
                <th>Tasa</th>
                <th>Descripción</th>
                <th>Modificar/Eliminar</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Mostrar datos en la tabla de Impuestos
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['ID_Impuestos'] . "</td>";
                echo "<td>" . $row['Nombre_Impuesto'] . "</td>";
                echo "<td>" . $row['Tasa_Impuesto'] . "</td>";
                echo "<td>" . $row['Descripcion_Impuesto'] . "</td>";
                echo "<td>";

               // Botón Modificar Impuesto (Ayuda.gif)
                echo "<a href='/Sistema-Administrativo/4. App Web HTML5 y PHP/7_Pagina_Impuestos/2_Modificar_Impuestos.php?nombre_impuesto=" . urlencode($row['Nombre_Impuesto']) . "'>";
                echo "<button><img src='assets/img/Editar.gif' alt=''></button>";
                echo "</a>";

                // Botón Eliminar Impuesto (Eliminar.gif)
                echo "<form method='post'>";
                echo "<input type='hidden' name='id_impuesto' value='" . $row['ID_Impuestos'] . "'>";
                echo "<button type='submit' name='eliminar_impuesto'><img src='assets/img/Eliminar.gif' alt=''></button>";
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