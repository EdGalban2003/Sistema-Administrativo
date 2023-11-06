<!DOCTYPE html>
<html>
<head>
    <title>Añadir Proveedor</title>
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

        $nombre_comercial = $_POST['nombre_comercial'];
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $tipo_documento = $_POST['tipo_documento'];
        $numero_documento = $_POST['numero_documento'];
        $telefono = $_POST['telefono'];
        $correo = $_POST['correo'];
        $direccion = $_POST['direccion'];

        // Función para crear un proveedor
        function crearProveedor($conexion, $nombre_comercial, $nombre, $apellido, $tipo_documento, $numero_documento, $telefono, $correo, $direccion) {
            $query = "INSERT INTO Proveedor (Nombre_Comercial_Proveedor, Nombre_Proveedor, Apellido_Proveedor, Tipo_Documento, Numero_Documento, Telefono_Proveedor, Correo_Proveedor, Direccion_Proveedor) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conexion->prepare($query);
            $stmt->bind_param("ssssssss", $nombre_comercial, $nombre, $apellido, $tipo_documento, $numero_documento, $telefono, $correo, $direccion);
            
            if ($stmt->execute()) {
                echo "Proveedor creado con éxito.";
            } else {
                echo "Error al crear el proveedor: " . $stmt->error;
            }
            
            $stmt->close();
        }

        // Llamar a la función para crear un proveedor
        crearProveedor($conexion, $nombre_comercial, $nombre, $apellido, $tipo_documento, $numero_documento, $telefono, $correo, $direccion);

        // Cerrar la conexión cuando hayas terminado
        $conexion->close();
    }
    ?>

    <h1>Añadir Proveedor</h1>
    <form method="post">
        Nombre Comercial del proveedor: <input type="text" name="nombre_comercial"><br>
        Nombre del proveedor: <input type="text" name="nombre"><br>
        Apellido del proveedor: <input type="text" name="apellido"><br>
        Tipo de documento: <input type="text" name="tipo_documento"><br>
        Número de documento del proveedor: <input type="text" name="numero_documento"><br>
        Teléfono del proveedor: <input type="text" name="telefono"><br>
        Correo del proveedor: <input type="text" name="correo"><br>
        Dirección del proveedor: <input type="text" name="direccion"><br>
        <input type="submit" value="Añadir Proveedor">
    </form>
</body>
</html>