<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
/* Connect To Database*/
require_once "../db.php";
require_once "../php_conexion.php";

$query = mysqli_query($conexion, "TRUNCATE TABLE dropi");
$row = mysqli_fetch_assoc($query);

