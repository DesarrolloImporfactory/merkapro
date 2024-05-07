<?php

require_once "../db.php";
require_once "../php_conexion.php";
require_once "../funciones.php";

$get_id = $_POST['id'];

$delete = mysqli_query($conexion, "UPDATE solicitudes_pago set visto =1 WHERE id_solicitud = '$get_id'");
if ($delete) {
    echo "1";
} else {
    echo "0";
}
