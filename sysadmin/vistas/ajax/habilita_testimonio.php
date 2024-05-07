<?php
// cambiar_estado.php
//include 'db_config.php';  // Asegúrate de incluir tu script de conexión a la base de datos aquí
require_once "../db.php";
    require_once "../php_conexion.php";
        
if (isset($_POST['id']) && isset($_POST['estado'])) {
    $id = $_POST['id'];
    $estado = $_POST['estado'];
echo "UPDATE testimonios SET status = $estado WHERE id_testimonio = $id";
    // Preparar la consulta SQL para actualizar el estado
    $sql = "UPDATE testimonios SET status = ? WHERE id_testimonio = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param('ii', $estado, $id);

    if ($stmt->execute()) {
        echo $estado;  // Retorna el nuevo estado para el callback de AJAX
    } else {
        echo "Error";  // Manejo de errores
    }
    $stmt->close();
}
?>