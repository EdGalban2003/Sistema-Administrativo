<!DOCTYPE html>
<html>
<head>
    <title>Añadir Producto</title>
</head>
<body>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $servername = "localhost";
        $username = "Admin";
        $password = "xztj-ARgQGavgh@K";
        $database = "sistema_administrativo";

        // Intentar conectar a la base de datos
        $conexion = new mysqli($servername, $username, $password, $database);

        // Verificar si la conexión fue exitosa
        if ($conexion->connect_error) {
            die("Error al conectar a la base de datos: " . $conexion->connect_error);
        }

        $nombre = $_POST['nombre'];
        $codigo = $_POST['codigo'];
        $detalle = $_POST['detalle'];
        $cantidad = $_POST['cantidad'];
        $precio_venta = $_POST['precio_venta'];
        $precio_costo = $_POST['precio_costo'];
        $fecha_ingreso = $_POST['fecha_ingreso'];
        $id_proveedor = $_POST['id_proveedor'];

        // Función para crear un producto
        function crearProducto($conexion, $nombre, $codigo, $detalle, $cantidad, $precio_venta, $precio_costo, $fecha_ingreso, $id_proveedor) {
            $query = "INSERT INTO Productos (Nombre_Producto, Codigo_Producto, Detalle_Producto, Cantidad_Producto, Precio_Venta, Precio_Costo, Fecha_Ingreso, Proveedor_ID_Proveedor) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conexion->prepare($query);
            $stmt->bind_param("ssssssss", $nombre, $codigo, $detalle, $cantidad, $precio_venta, $precio_costo, $fecha_ingreso, $id_proveedor);
            
            if ($stmt->execute()) {
                echo "Producto creado con éxito.";
            } else {
                echo "Error al crear el producto: " . $stmt->error;
            }
            
            $stmt->close();
        }

        // Llamar a la función para crear un producto
        crearProducto($conexion, $nombre, $codigo, $detalle, $cantidad, $precio_venta, $precio_costo, $fecha_ingreso, $id_proveedor);

        // Cerrar la conexión cuando hayas terminado
        $conexion->close();
    }
    ?>

    <h1>Añadir Producto</h1>
    <form method="post">
        Nombre del producto: <input type="text" name="nombre" required><br>
        Código del producto: <input type="text" name="codigo" required><br>
        Detalle del producto: <input type="text" name="detalle" required><br>
        Cantidad del producto: <input type="number" name="cantidad" required><br>
        Precio de venta del producto: <input type="number" name="precio_venta" step="0.01" required><br>
        Precio de costo del producto: <input type="number" name="precio_costo" step="0.01" required><br>
        Fecha de ingreso del producto: <input type="date" name="fecha_ingreso" required><br>
        ID del proveedor: <input type="text" name="id_proveedor" required><br>
        <input type="submit" value="Añadir Producto">
    </form>
</body>
</html>
