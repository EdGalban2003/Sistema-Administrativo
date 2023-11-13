<?php
require_once(__DIR__ . '/../_ConexionBDDSA/config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['nombre_usuario'])) {
    $nombre_usuario = $_POST['nombre_usuario'];

    // Conecta a la base de datos
    $conn = new mysqli($db_config['host'], $db_config['username'], $db_config['password'], $db_config['database']);

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
