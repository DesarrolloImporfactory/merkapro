<?php
// Conectar a la base de datos (reemplaza los datos de conexión con los tuyos)


require_once "../db.php";
require_once "../php_conexion.php";

// Obtener el nuevo RNC enviado por AJAX
$nuevoRNC = $_POST['rnc'];
$id_cliente = $_POST['id_cliente'];

// Realizar la actualización en la base de datos
$sql_actualizar_rnc = "UPDATE clientes SET telefono_cliente = '$nuevoRNC' WHERE id_cliente = $id_cliente"; // Cambia 'id = 1' por la condición que necesites
$resultado = mysqli_query($conexion, $sql_actualizar_rnc);

if ($resultado) {
    echo "RNC actualizado correctamente";
} else {
    echo "Error al actualizar el RNC: " . mysqli_error($conexion);
}

// Cerrar la conexión
mysqli_close($conexion);
?>