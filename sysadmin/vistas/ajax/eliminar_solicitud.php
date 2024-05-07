<?php

require_once "../db.php";
require_once "../php_conexion.php";
require_once "../funciones.php";

$get_id = $_POST['id'];

$delete = mysqli_query($conexion, "DELETE FROM solicitudes_pago WHERE id_solicitud = '$get_id'");
if ($delete) {
    echo "1";
} else {
    echo "0";
}
