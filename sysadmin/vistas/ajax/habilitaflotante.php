<?php
include 'is_logged.php'; //Archivo verifica que el usario que intenta acceder a la URL esta logueado
/* Connect To Database*/
require_once "../db.php";
require_once "../php_conexion.php";
$id = intval($_GET['id']);
 $sql          = "UPDATE perfil SET flotante=$id";
            $query_update = mysqli_query($conexion, $sql);
            
            ?>

