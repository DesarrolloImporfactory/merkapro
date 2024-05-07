<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
include 'is_logged.php'; // Archivo verifica que el usuario que intenta acceder a la URL está logueado

/* Connect To Database */
require_once "../db.php";
require_once "../php_conexion.php";
$query_id = mysqli_query($conexion, "SELECT codigo_producto FROM productos ORDER BY codigo_producto DESC LIMIT 1")
  or die('error ' . mysqli_error($conexion));
$count = mysqli_num_rows($query_id);

if ($count != 0) {
  $data_id = mysqli_fetch_assoc($query_id);
  $codigo  = $data_id['codigo_producto']; // Obtener el código completo

  // Utiliza una expresión regular para separar las partes de letras con guiones y números
  if (preg_match('/^([A-Za-z-]*)(\d+)$/', $codigo, $matches)) {
    $prefix = $matches[1]; // Esto captura el prefijo que podría incluir letras y guiones
    $numero = $matches[2]; // Esto captura la parte numérica

    // Incrementar el número
    $numero++;

    // Reensamblar el código
    $codigo = $prefix . str_pad($numero, strlen($matches[2]), "0", STR_PAD_LEFT);
  } else {
    // Si el código no contiene letras o guiones, simplemente incrementar
    $codigo++;
  }
} else {
  $codigo = 1; // Inicializar a 1 si no hay productos
}

echo '<input type="text" class="form-control" autocomplete="off" id="codigo" value="' . $codigo . '" name="codigo">';
