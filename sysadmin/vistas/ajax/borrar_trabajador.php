<?php
require_once "../db.php"; //Contiene las variables de configuracion para conectar a la base de datos
require_once "../php_conexion.php"; //Contiene funcion que conecta a la base de datos
error_reporting(E_ALL);
ini_set('display_errors', '1');

$get_data = file_get_contents("php://input");

$id = $_POST['id'];

$sql = "DELETE FROM trabajadores_envio WHERE id = '$id'";
if (mysqli_query($conexion, $sql)) {
    echo "ok";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conexion);
}
