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

// Verificar si se ha enviado el formulario de modificación de datos
if (isset($_POST['cedula'], $_POST['nuevo_nombre'], $_POST['nuevo_apellido'], $_POST['nuevo_telefono'], $_POST['nueva_direccion'])) {
    $cedula = $_POST['cedula'];
    $nuevo_nombre = $_POST['nuevo_nombre'];
    $nuevo_apellido = $_POST['nuevo_apellido'];
    $nuevo_telefono = $_POST['nuevo_telefono'];
    $nueva_direccion = $_POST['nueva_direccion'];

    try {
        $query = "UPDATE Cliente SET Nombre_Cliente = ?, Apellido_Cliente = ?, Telefono_Cliente = ?, Direccion_Cliente = ? WHERE Cedula_Cliente = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssss", $nuevo_nombre, $nuevo_apellido, $nuevo_telefono, $nueva_direccion, $cedula);
        $stmt->execute();
        $stmt->close();
        echo "Datos del cliente actualizados con éxito.";
    } catch (mysqli_sql_exception $e) {
        echo "Error al actualizar los datos del cliente: " . $e->getMessage();
    }
}

// Obtener la cédula de la URL
$cedula = $_GET['cedula'];

// Obtener otros datos del cliente para mostrar en el formulario
$query = "SELECT * FROM Cliente WHERE Cedula_Cliente = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $cedula);
$stmt->execute();
$result = $stmt->get_result();
$cliente = $result->fetch_assoc();
$stmt->close();

// Cerrar la conexión a la base de datos
$conn->close();
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

    <h1>Modificar Datos del Cliente</h1>

    <form method="post">
        <label for="cedula">Cédula del Cliente:</label>
        <!-- Mostrar la cédula del cliente en un campo no editable -->
        <input type="text" name="cedula" id="cedula" value="<?php echo $cliente['Cedula_Cliente']; ?>" readonly required>
        <label for="nuevo_nombre">Nuevo Nombre:</label>
        <input type="text" name="nuevo_nombre" id="nuevo_nombre" value="<?php echo $cliente['Nombre_Cliente']; ?>" required>
        <label for="nuevo_apellido">Nuevo Apellido:</label>
        <input type="text" name="nuevo_apellido" id="nuevo_apellido" value="<?php echo $cliente['Apellido_Cliente']; ?>" required>
        <label for="nuevo_telefono">Nuevo Teléfono:</label>
        <input type="text" name="nuevo_telefono" id="nuevo_telefono" value="<?php echo $cliente['Telefono_Cliente']; ?>" required>
        <label for="nueva_direccion">Nueva Dirección:</label>
        <input type="text" name="nueva_direccion" id="nueva_direccion" value="<?php echo $cliente['Direccion_Cliente']; ?>" required>
        <button type="submit">Modificar Datos</button>
    </form>
    
    <!-- Agrega el botón de "Volver" -->
    <a href="/Sistema-Administrativo/4. App Web HTML5 y PHP/2_Pagina_Clientes/0_Index_Cliente.php"><button type="button">Volver</button></a>

</body>
</html>
