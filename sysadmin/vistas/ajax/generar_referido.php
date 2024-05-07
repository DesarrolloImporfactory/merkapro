<?php

$get_data = file_get_contents("php://input");
$get_data = file_get_contents("php://input");
$request = json_decode($get_data, true); // Convertir JSON a array
$dominio = $request['dominio'];


$token = bin2hex(openssl_random_pseudo_bytes(20));

$sql_update = "UPDATE `plataformas` SET `referido` = '1', `token_referido`='$token'  WHERE `url_imporsuit` = '$dominio';";
$conexion_marketplace = mysqli_connect("localhost", "imporsuit_marketplace", "imporsuit_marketplace", "imporsuit_marketplace");
$query_update = mysqli_query($conexion_marketplace, $sql_update);
if ($query_update) {
    echo 'ok';
} else {
    echo 'error';
}
