<?php
require_once "../db.php"; //Contiene las variables de configuracion para conectar a la base de datos
require_once "../php_conexion.php"; //Contiene funcion que conecta a la base de datos
require_once "../funciones.php"; //Contiene funcion que conecta a la base de datos

$data = file_get_contents("php://input");
parse_str($data, $data);

$id_cabecera = $data['id_cabecera'];

$consulta = "DELETE FROM cabecera_cuenta_pagar WHERE id_cabecera = '$id_cabecera';";
$resultado = mysqli_query($conexion, $consulta);

if ($resultado) {
    echo "Eliminado";
} else {
    echo "cascada";
}
