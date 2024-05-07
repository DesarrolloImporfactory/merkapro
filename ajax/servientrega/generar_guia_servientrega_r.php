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

$razon_social_remitente = "IMPORCOMEX S.A.";
$nombre_remitente = $_POST['nombre_remitente'];
$apellido_remitente = $_POST['apellido_remitente'];
$direccion_remitente = $_POST['direccion_remitente'];
$telefono_remitente = $_POST['telefono_remitente'];

$contenido = $_POST['productos_guia'];
$valor_mercancia = $_POST['valor_total'];
$valor_asegurado = $_POST['valorasegurado'];

$servi_flete = $_POST['servi_flete'];
$servi_comision = $_POST['servi_comision'];
$servi_seguro = $_POST['servi_seguro'];
$servi_impuesto = $_POST['servi_impuesto'];
$servi_otros = $_POST['servi_otros'];

$ciudad_texto = $_POST['ciudad_texto'];

$fecha = date("Y-m-d");

$factura = "000" . rand(100000, 999999);

$referencia = $_POST['referencia'];

$url = 'https://swservicli.servientrega.com.ec:5052/api/GuiaRecaudo';

// Los datos que vas a enviar en formato JSON
$data = array(
    "ID_TIPO_LOGISTICA" => 1,
    "DETALLE_ENVIO_1" => "",
    "DETALLE_ENVIO_2" => "",
    "DETALLE_ENVIO_3" => "",
    "ID_CIUDAD_ORIGEN" => $ciudad_origen,
    "ID_CIUDAD_DESTINO" => $ciudad_destino,
    "ID_DESTINATARIO_NE_CL" => "001dest",
    "RAZON_SOCIAL_DESTI_NE" =>  $razon_zocial_destinatario,
    "NOMBRE_DESTINATARIO_NE" => $nombre_destinatario,
    "APELLIDO_DESTINATAR_NE" =>     $apellido_destinatario,
    "SECTOR_DESTINAT_NE" => "",
    "TELEFONO1_DESTINAT_NE" => $telefono_destinatario,
    "TELEFONO2_DESTINAT_NE" => "",
    "CODIGO_POSTAL_DEST_NE" => "",
    "CORREO_DESTINATARIO" => "desarrollo1@imporfactoryusa.com",
    "ID_REMITENTE_CL" => "001remi",
    "RAZON_SOCIAL_REMITE" => $razon_social_remitente,
    "NOMBRE_REMITENTE" => "$nombre_remitente",
    "APELLIDO_REMITE" =>    "$apellido_remitente",
    "DIRECCION1_REMITE" => "$direccion_remitente ",
    "SECTOR_REMITE" => "",
    "TELEFONO1_REMITE" => $telefono_remitente,
    "TELEFONO2_REMITE" => "",
    "CODIGO_POSTAL_REMI" => "",
    "ID_PRODUCTO" => 2,
    "CONTENIDO" => $contenido,
    "NUMERO_PIEZAS" => 1,
    "VALOR_MERCANCIA" => $valor_mercancia,
    "VALOR_ASEGURADO" => $valor_asegurado,
    "LARGO" => 2,
    "ANCHO" => 50,
    "ALTO" => 50,
    "PESO_FISICO" => 2,
    "LOGIN_CREACION" => "integracion.api.1",
    "PASSWORD" => "54321",
    "ID_CL" => 0,
    "VERIFICAR_CONTENIDO_RECAUDO" => "",
    "VALIDADOR_RECAUDO" => "D",
    "DIRECCION_RECAUDO" => $direccion_destinatario . " - Referencia: " . $referencia,
    "FECHA_FACTURA" => $fecha,
    "NUMERO_FACTURA" => "002584154154",
    "VALOR_FACTURA" => $valor_mercancia,
    "VALOR_FLETE " => $servi_flete,
    "VALOR_COMISION" => $servi_comision,
    "VALOR_SEGURO" => $servi_seguro,
    "VALOR_IMPUESTO" => $servi_impuesto,
    "VALOR_OTROS" => $servi_otros,
    "VALOR_A_RECAUDAR" => $valor_mercancia,
    "DETALLE_ITEMS_FACTURA" => "PRUEBAS SISTEMAS",

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
