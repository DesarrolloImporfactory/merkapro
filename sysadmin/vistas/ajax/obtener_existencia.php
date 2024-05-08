<?php
// Este archivo recibe 'id_producto' y devuelve la existencia actual.
require_once "../db.php";
require_once "../php_conexion.php";

$id_producto = $_POST['id_producto'] ?? 0; // Usar el operador de fusión de null de PHP 7+

$sql = "SELECT stock_producto FROM productos WHERE id_producto='$id_producto'";
$query = mysqli_query($conexion, $sql);
$row = mysqli_fetch_array($query);

echo $row['stock_producto'] ?? '0'; // Si no encuentra nada, devuelve '0'
