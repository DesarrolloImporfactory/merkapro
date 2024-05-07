<?php

$url = 'https://181.39.87.158:8021/api/GuiaRecaudo';

// La estructura de datos a enviar en formato JSON
$data = [
    "ID_TIPO_LOGISTICA" => 1,
    "DETALLE_ENVIO_1" => "1158740281004-01",
    "DETALLE_ENVIO_2" => "0018",
    "DETALLE_ENVIO_3" => "",
    "ID_CIUDAD_ORIGEN" => 1,
    "ID_CIUDAD_DESTINO" => 1,
    "ID_DESTINATARIO_NE_CL" => "PRUEBA",
    "RAZON_SOCIAL_DESTI_NE" => "112233445511",
    "NOMBRE_DESTINATARIO_NE" => "POSTMAN LOCAL",
    "APELLIDO_DESTINATAR_NE" => "NA",
    "SECTOR_DESTINAT_NE" => "",
    "TELEFONO1_DESTINAT_NE" => "+573182261409",
    "TELEFONO2_DESTINAT_NE" => "",
    "CODIGO_POSTAL_DEST_NE" => "",
    "CORREO_DESTINATARIO" => "christian.pinargote@servientrega.com.ec",
    "ID_REMITENTE_CL" => "PRUEBA",
    "RAZON_SOCIAL_REMITE" => "ECUADOR BRANDS S.A.",
    "NOMBRE_REMITENTE" => "FAHED",
    "APELLIDO_REMITE" => "SASADI",
    "DIRECCION1_REMITE" => "EDIFICIO TRADE BUILDING TORRE A PISO 4 OFICINA L.A2",
    "SECTOR_REMITE" => "",
    "TELEFONO1_REMITE" => "3958746164",
    "TELEFONO2_REMITE" => "",
    "CODIGO_POSTAL_REMI" => "",
    "ID_PRODUCTO" => 2,
    "CONTENIDO" => "ZAPATOS",
    "NUMERO_PIEZAS" => 1,
    "VALOR_MERCANCIA" => 0,
    "VALOR_ASEGURADO" => 0,
    "LARGO" => 0,
    "ANCHO" => 0,
    "ALTO" => 0,
    "PESO_FISICO" => 2,
    "FECHA_FACTURA" => "2021-10-12",
    "NUMERO_FACTURA" => "002584154154",
    "VALOR_FACTURA" => 150.25,
    "VALOR_FLETE " => "100",
    "VALOR_COMISION" => "10",
    "VALOR_SEGURO" => "100",
    "VALOR_IMPUESTO" => "10",
    "VALOR_OTROS" => "0",
    "VALOR_A_RECAUDAR" => "200",
    "DETALLE_ITEMS_FACTURA" => "PRUEBAS SISTEMAS",
    "VERIFICAR_CONTENIDO_RECAUDO" => "",
    "VALIDADOR_RECAUDO" => "D",
    "ID_CL" => 0,
    "DIRECCION_RECAUDO" => "Daule",
    "LOGIN_CREACION" => "impor.comex",
    "PASSWORD" => "123456"
];

// Convertir el array a JSON
$jsonData = json_encode($data);

// Inicializar cURL
$ch = curl_init($url);

// Configurar opciones de cURL
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// Omitir la verificación de SSL (NO recomendado para producción)
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

// Ejecutar la solicitud y obtener la respuesta
$response = curl_exec($ch);

// Verificar si ocurrió algún error
if (curl_errno($ch)) {
    throw new Exception(curl_error($ch));
}

// Cerrar la sesión cURL
curl_close($ch);

// Mostrar la respuesta
echo $response;

?>


