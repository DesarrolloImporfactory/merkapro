<?php

$get_data = json_decode(file_get_contents('php://input'), true);

if (
    isset($_SERVER['HTTPS']) &&
    ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) ||
    isset($_SERVER['HTTP_X_FORWARDED_PROTO']) &&
    $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https'
) {
    $protocol = 'https://';
} else {
    $protocol = 'http://';
}
$host = $_SERVER['HTTP_HOST'];

$tienda = str_replace(' ', '', $host);
$tienda = str_replace('www.', '', $tienda);
$tienda = str_replace('.imporsuit.com', '', $tienda);

$conexion_marketplace = mysqli_connect('localhost', 'imporsuit_marketplace', 'imporsuit_marketplace', 'imporsuit_marketplace');
$sql = "SELECT * FROM plataformas WHERE url_imporsuit like '%$tienda%'";
$query = mysqli_query($conexion_marketplace, $sql);
$datos = mysqli_fetch_array($query);

if (!$datos) {
    echo json_encode("cambios");
    return;
}

$nombre = $datos['contacto'];
$telefono = $datos['whatsapp'];
$correo = $datos['email'];
$enlace = $datos['url_imporsuit'];

echo json_encode(array(
    'nombre' => $nombre,
    'telefono' => $telefono,
    'correo' => $correo,
    'enlace' => $enlace
));
