<?php
require_once "../db.php";
require_once "../php_conexion.php";

if(isset($_POST['id'])) {
    $id = $_POST['id'];
    $sql = "DELETE FROM bodega WHERE id = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $id);
    if($stmt->execute()) {
        echo "Registro eliminado";
    } else {
        echo "Error al eliminar: " . $conexion->error;
    }
    $stmt->close();
    $conexion->close();
}
?>
