<?php
require_once(__DIR__ . '/../_ConexionBDDSA/config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['nombre_usuario'])) {
    $nombre_usuario = $_POST['nombre_usuario'];

    try {
        // Intenta la conexión con la base de datos después de actualizar el archivo config.php
        $conn = new mysqli($db_config['host'], $nombre_usuario, '', $db_config['database']);
    } catch (mysqli_sql_exception $e) {
        // Muestra un mensaje personalizado en caso de un error de acceso
        echo "<h2>Acceso Denegado</h2>";
        exit;
    }
    
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Verifica si el nombre de usuario ya está en uso
    $stmt = $conn->prepare("SELECT Nombre_Usuario FROM usuarios WHERE Nombre_Usuario = ?");
    $stmt->bind_param("s", $nombre_usuario);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "en_uso"; // El nombre de usuario está en uso
    } else {
        echo "disponible"; // El nombre de usuario está disponible
    }

    $stmt->close();
    $conn->close();
}
?>
