<?php
$get_data = json_decode(file_get_contents('php://input'), true);

$contacto = $get_data['nombre'];
$whatsapp = $get_data['telefono'];
$email = $get_data['correo'];
$url_imporsuit = $get_data['enlace'];

$tienda = str_replace(' ', '', $url_imporsuit);
$tienda = str_replace('www.', '', $tienda);
$tienda = str_replace('.imporsuit.com', '', $tienda);
$tienda = str_replace('http://', '', $tienda);
$tienda = str_replace('https://', '', $tienda);
$tienda = str_replace('/', '', $tienda);




$marketplace_conexion = mysqli_connect('localhost', 'imporsuit_marketplace', 'imporsuit_marketplace', 'imporsuit_marketplace');

$sql_insert = "INSERT INTO plataformas (nombre_tienda,contacto, whatsapp, email, url_imporsuit) VALUES ('$tienda','$contacto', '$whatsapp', '$email', '$url_imporsuit')";

$query_insert = mysqli_query($marketplace_conexion, $sql_insert);


if ($query_insert) {
    $response = array(
        "status" => "actualizado",
        "message" => "Información actualizada"

    );
    echo json_encode($response);
} else {
    $response = array(
        "status" => "error",
        "message" => "Error al actualizar la información"

    );
    echo json_encode($response);
}
