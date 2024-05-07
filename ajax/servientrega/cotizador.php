<?php
// URL del servicio web SOAP
$wsdlUrl = 'https://servientrega-ecuador-prueba.appsiscore.com/app/ws/cotizador_ser_recaudo.php?wsdl';

// Datos de la solicitud
$entidad = 'PRUEBAS RECAUDOS';
$producto = 'MERCANCIA PREMIER';
$origen = 'GUAYAQUIL';
$destino = 'QUITO-PICHINCHA';
$valor_mercaderia = '200';
$piezas = '1';
$peso = '3';
$alto = '1';
$ancho = '1';
$largo = '1';
$token = '1593aaeeb60a560c156387989856db6be7edc8dc220f9feae3aea237da6a951d';
$usu = 'PRUEBA';
$pwd = 's12345ABCDe';

// Configuración del cliente SOAP
$options = [
    'trace' => true, // Habilitar el registro de la solicitud y respuesta SOAP
    'exceptions' => true, // Habilitar excepciones en caso de errores
];

// Crear cliente SOAP
$client = new SoapClient($wsdlUrl, $options);

// Parámetros de la solicitud SOAP
$params = [
    'entidad' => $entidad,
    'producto' => $producto,
    'origen' => $origen,
    'destino' => $destino,
    'valor_mercaderia' => $valor_mercaderia,
    'piezas' => $piezas,
    'peso' => $peso,
    'alto' => $alto,
    'ancho' => $ancho,
    'largo' => $largo,
    'tokn' => $token,
    'usu' => $usu,
    'pwd' => $pwd,
];

try {
    // Realizar la llamada al método del servicio web SOAP
    $response = $client->__soapCall('Consultar', [$params]);

    // Obtener la respuesta del servicio web
    $result = $response->ConsultarResult;

    // Procesar la respuesta según sea necesario
    var_dump($result);
} catch (SoapFault $e) {
    // Capturar errores de la solicitud SOAP
    echo 'Error: ' . $e->getMessage();
}
