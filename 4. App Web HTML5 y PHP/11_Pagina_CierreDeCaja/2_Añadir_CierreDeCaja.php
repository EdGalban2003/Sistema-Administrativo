<!DOCTYPE html>
<html>
<head>
    <title>Crear Cliente</title>
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

        $cedula = $_POST['cedula'];
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $telefono = $_POST['telefono'];
        $correo = $_POST['correo'];
        $direccion = $_POST['direccion'];

        // Función para crear un cliente
        function crearCliente($conexion, $cedula, $nombre, $apellido, $telefono, $correo, $direccion) {
            $query = "INSERT INTO Cliente (Cedula_Cliente, Nombre_Cliente, Apellido_Cliente, Telefono_Cliente, Correo_Cliente, Direccion_Cliente) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conexion->prepare($query);
            $stmt->bind_param("ssssss", $cedula, $nombre, $apellido, $telefono, $correo, $direccion);
            
            if ($stmt->execute()) {
                echo "Cliente creado con éxito.";
            } else {
                echo "Error al crear el cliente: " . $stmt->error;
            }
            
            $stmt->close();
        }

        // Llamar a la función para crear un cliente
        crearCliente($conexion, $cedula, $nombre, $apellido, $telefono, $correo, $direccion);

        // Cerrar la conexión cuando hayas terminado
        $conexion->close();
    }
    ?>



    <h1>Crear Cliente</h1>
    <form method="post">
        Cédula del cliente: <input type="text" name="cedula"><br>
        Nombre del cliente: <input type="text" name="nombre"><br>
        Apellido del cliente: <input type="text" name="apellido"><br>
        Teléfono del cliente: <input type="text" name="telefono"><br>
        Correo del cliente: <input type="text" name="correo"><br>
        Dirección del cliente: <input type="text" name="direccion"><br>
        <input type="submit" value="Crear Cliente">
    </form>


</body>
</html>
