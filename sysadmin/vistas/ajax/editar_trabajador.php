<?php
require_once "../db.php"; //Contiene las variables de configuracion para conectar a la base de datos
require_once "../php_conexion.php"; //Contiene funcion que conecta a la base de datos
error_reporting(E_ALL);
ini_set('display_errors', '1');
$get_data = file_get_contents("php://input");
$id = $_POST['id'];
$nombre = $_POST['nombre'];
$contacto = $_POST['contacto'];
$placa = $_POST['placa'];
$empresa = $_POST['empresa'];
$estado = $_POST['estado'];

$nombre = mysqli_real_escape_string($conexion, $nombre);
$contacto = mysqli_real_escape_string($conexion, $contacto);
$placa = mysqli_real_escape_string($conexion, $placa);
$empresa = mysqli_real_escape_string($conexion, $empresa);
$estado = mysqli_real_escape_string($conexion, $estado);

$sql = "UPDATE `trabajadores_envio` SET nombre = '$nombre', contacto = '$contacto', placa = '$placa', empresa = '$empresa', estado = '$estado' WHERE id = '$id'";
if (mysqli_query($conexion, $sql)) {
    echo "ok";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conexion);
}
