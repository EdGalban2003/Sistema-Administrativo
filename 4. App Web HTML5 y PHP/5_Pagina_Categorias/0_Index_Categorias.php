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
          <li class="link"><a href="/Sistema-Administrativo/4. App Web HTML5 y PHP/2_Pagina_Clientes/0_Index_Cliente.php">Clientes</a></li>
            <li class="link"><a href="/Sistema-Administrativo/4. App Web HTML5 y PHP/3_Pagina_Proveedores/0_Index_Proveedores.php">Proveedores</a></li>
            <li class="link"><a href="/Sistema-Administrativo/4. App Web HTML5 y PHP/4_Pagina_Productos/0_Index_Productos.php">Productos</a></li>
            <li class="link"><a href="/Sistema-Administrativo/4. App Web HTML5 y PHP/5_Pagina_Categorias/0_Index_Categorias.php">Categorias</a></li>
          </ul>
        </li>    
        <li class="submenu">
          <a href="">Movimientos</a>
          <ul class="hijos">
            <li><a href="">Recibo</a></li>
            <li><a href="">Cierre de Caja</a></li>
            <li><a href="">Inventario</a></li>
          </ul>
        </li>
        <li class="submenu">
          <a href="">Reportes</a>
          <ul class="hijos">
            <li><a href="">Clientes</a></li>
            <li><a href="">Proveedores</a></li>
            <li><a href="">Productos</a></li>
            <li><a href="">Auditoria</a></li>
            <li><a href="">Cierre de Caja</a></li>
            <li><a href="">Reimprimir Recibo</a></li>
          </ul>
        </li>
        <li class="submenu">
          <a href="">Mantenimiento</a>
          <ul class="hijos">
            <li><a href="">Auditoria</a></li>
            <li><a href="">Respaldar</a></li>
            <li><a href="">Restaurar</a></li>
          </ul>
        </li>
        <li class="submenu">
          <a href="">Ayuda</a>
          <ul class="hijos">
            <li><a href="">Acerca de</a></li>
            <li><a href="">Manual de Usuario</a></li>
            <li><a href="">Información de Sistema</a></li>
          </ul>
        </li>
        <li class="submenu">
          <a href="">Configuración</a>
          <ul class="hijos">
            <li><a href="">Notificaciones</a></li>
            <li><a href="">Configuración General</a></li>
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

// Realizar la eliminación directamente en la misma página
if (isset($_POST['eliminar_categoria'])) {
    // Obtener el ID de la categoría a eliminar desde el formulario
    $id_categoria = $_POST['id_categoria'];

    // Preparar la consulta de eliminación
    $query = "DELETE FROM Categorias WHERE ID_Categoria = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id_categoria);

    // Ejecutar la eliminación
    if ($stmt->execute()) {
        // Redirigir a otra página después de la eliminación
        header("Location: /Sistema-Administrativo/4. App Web HTML5 y PHP/5_Pagina_Categorias/0_Index_Categorias.php");
        exit(); // Asegurarse de que el script se detenga después de la redirección
    } else {
        echo "Error al eliminar la categoría: " . $stmt->error;
    }

    // Cerrar la declaración preparada
    $stmt->close();
}

// Realizar la consulta a la base de datos con la opción de búsqueda para categorías
$search_query = isset($_GET['q']) ? $_GET['q'] : '';
$query = "SELECT * FROM Categorias WHERE 
          Nombre_Categoria LIKE '%$search_query%' OR 
          Detalle_Categoria LIKE '%$search_query%'";

$result = $conn->query($query);
?>

<div class="funciones">
    <button type="submit"><img src="assets/img/Añadir 2.gif" alt=""></button>
    <a href="/Sistema-Administrativo/4. App Web HTML5 y PHP/5_Pagina_Categorias/1_Añadir_Categorias.php">Añadir Categoría</a>
    <button type="submit"><img src="assets/img/Añadir.gif" alt=""></button>
</div>
</div>

<div class="container">
    <table>
        <thead>
            <tr>
                <th>ID Categoría</th>
                <th>Nombre</th>
                <th>Detalle</th>
                <th>Modificar/Eliminar</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Mostrar datos en la tabla
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['ID_Categoria'] . "</td>";
                echo "<td>" . $row['Nombre_Categoria'] . "</td>";
                echo "<td>" . $row['Detalle_Categoria'] . "</td>";
                echo "<td>";

                // Botón Modificar Categoría (Ayuda.gif)
                echo "<a href='/Sistema-Administrativo/4. App Web HTML5 y PHP/5_Pagina_Categorias/2_Modificar_Categorias.php?id_categoria=" . $row['ID_Categoria'] . "'>";
                echo "<button><img src='assets/img/Editar.gif' alt=''></button>";
                echo "</a>";

                // Botón Eliminar Categoría (Eliminar.gif)
                echo "<form method='post'>";
                echo "<input type='hidden' name='id_categoria' value='" . $row['ID_Categoria'] . "'>";
                echo "<button type='submit' name='eliminar_categoria'><img src='assets/img/Eliminar.gif' alt=''></button>";
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
