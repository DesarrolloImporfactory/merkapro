<?php

$ciudad_origen = $_POST['codigo_origen'];
$ciudad_destino = $_POST['codigo'];

$razon_zocial_destinatario = "Entrega a Domicilio";
$nombre_destinatario = $_POST['nombre_destino'];

if (isset($_POST['apellido_destinatario'])) {
    $apellido_destinatario = $_POST['apellido_destinatario'];
} else {
    $apellido_destinatario = " ";
}

$direccion_destinatario = $_POST['direccion'];
$telefono_destinatario = $_POST['celular'];

$razon_social_remitente = "Servientrega Ecuador S.A.";
$nombre_remitente = $_POST['nombre_remitente'];
$apellido_remitente = $_POST['apellido_remitente'];
$direccion_remitente = $_POST['direccion_remitente'];
$telefono_remitente = $_POST['telefono_remitente'];

$contenido = $_POST['productos_guia'];
$valor_mercancia = $_POST['valor_total'];
$valor_asegurado = $_POST['valorasegurado'];
$referencia = $_POST['referencia'];


$url = 'https://swservicli.servientrega.com.ec:5052/api/guiawebs';

// Los datos que vas a enviar en formato JSON
$data = array(
    "id_tipo_logistica" => 1,
    "detalle_envio_1" => "",
    "detalle_envio_2" => "",
    "detalle_envio_3" => "",
    "id_ciudad_origen" => $ciudad_origen,
    "id_ciudad_destino" => $ciudad_destino,
    "id_destinatario_ne_cl" => "001dest",
    "razon_social_desti_ne" =>  $razon_zocial_destinatario,
    "nombre_destinatario_ne" => $nombre_destinatario,
    "apellido_destinatar_ne" =>     $apellido_destinatario,
    "direccion1_destinat_ne" => $direccion_destinatario . " - Referencia: " . $referencia,
    "sector_destinat_ne" => "",
    "telefono1_destinat_ne" => $telefono_destinatario,
    "telefono2_destinat_ne" => "",
    "codigo_postal_dest_ne" => "",
    "id_remitente_cl" => "001remi",
    "razon_social_remite" => $razon_social_remitente,
    "nombre_remitente" => $nombre_remitente,
    "apellido_remite" =>    $apellido_remitente,
    "direccion1_remite" => $direccion_remitente,
    "sector_remite" => "",
    "telefono1_remite" => $telefono_remitente,
    "telefono2_remite" => "",
    "codigo_postal_remi" => "",
    "id_producto" => 2,
    "contenido" => $contenido,
    "numero_piezas" => 1,
    "valor_mercancia" => $valor_mercancia,
    "valor_asegurado" => $valor_asegurado,
    "largo" => 2,
    "ancho" => 50,
    "alto" => 50,
    "peso_fisico" => 2,
    "login_creacion" => "integracion.api.1",
    "password" => "54321"
);

// Convertir los datos al formato JSON
$jsonData = json_encode($data);

// Inicializar cURL
$ch = curl_init($url);

// Configura opciones de cURL
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// Ignora la verificación de SSL
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

// Configurar las opciones de cURL para la solicitud POST
curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// Omitir la verificación de SSL si es necesario (no recomendado para producción)
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

// Ejecutar la solicitud
$response = curl_exec($ch);

// Verificar si ocurrió algún error durante la solicitud
if (curl_errno($ch)) {
    throw new Exception(curl_error($ch));
}

// Cerrar la sesión cURL
curl_close($ch);

// Mostrar la respuesta
echo $response;
