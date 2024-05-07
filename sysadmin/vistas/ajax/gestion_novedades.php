<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once "../db.php";
require_once "../php_conexion.php";
$guia = $_POST['guia'];
$observacion = $_POST['observacion'];
$transporte = $_POST['transporte'];
if ($transporte == 'SERVIENTREGA') {

    $url = "https://servientrega-ecuador.appsiscore.com/app/ws/confirmaciones.php?wsdl";

    $xml = <<<XML
    <soapenv:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
    xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
    xmlns:ws="https://servientrega-ecuador.appsiscore.com/app/ws">
    <soapenv:Header/>
    <soapenv:Body>
    <ws:getXML soapenv:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/">
    <guia xsi:type="xsd:string">$guia</guia>
    <observacion xsi:type="xsd:string">$observacion</observacion>
    <usugenera xsi:type="xsd:string">integracion.api.1</usugenera>
    <usu xsi:type="xsd:string">IMPCOMEX</usu>
    <pwd xsi:type="xsd:string">Rtcom-ex9912</pwd>
    <tokn xsi:type="xsd:string">1593aaeeb60a560c156387989856db6be7edc8dc220f9feae3aea237da6a951d</tokn>
    </ws:getXML>
    </soapenv:Body>
    </soapenv:Envelope>
    XML;

    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);

    curl_close($ch);

    echo $response;
} else if ($transporte === "LAAR") {
    $token = "";

    // Datos de usuario y contraseña
    $usuario = "import.uio.api";
    $contrasena = "Imp@rt*23";

    $token_url = "https://api.laarcourier.com:9727/authenticate";

    // Datos a enviar en formato JSON
    $auth_data = json_encode(array('username' => $usuario, 'password' => $contrasena));

    // Configuración de la solicitud cURL para obtener el token
    $token_ch = curl_init($token_url);
    curl_setopt($token_ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($token_ch, CURLOPT_POSTFIELDS, $auth_data);
    curl_setopt($token_ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($token_ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen($auth_data)
    ));

    // Realizar la solicitud cURL para obtener el token
    $token_response = curl_exec($token_ch);

    // Verificar si hubo errores en la solicitud
    if (curl_errno($token_ch)) {
        echo 'Error en la solicitud cURL para obtener el token: ' . curl_error($token_ch);
    }

    // Cerrar la conexión cURL
    curl_close($token_ch);

    // Procesar la respuesta del servicio web para obtener el token
    if ($token_response) {
        $token_data = json_decode($token_response, true);
        print_r($token_data);
        $token = $token_data['token']; // Suponiendo que el token se encuentra en la respuesta
        // Ahora tenemos el token que debemos enviar en la cabecera Bearer
        // a otro servicio web
    } else {
        echo 'No se recibió respuesta del servicio web para obtener el token';
    }


    $ciudad = $_POST['ciudad'];
    $calle_principal  = $_POST['direccion'];
    $calle_secundaria = $_POST['direccion1'];
    $telefono   = $_POST['telefono'];
    $celular    = $_POST['celular'];
    $numeracion = $_POST['numeracion'];
    $referencia = $_POST['referencia'];
    $novedad    = $_POST['novedad'];
    $nombre    = $_POST['nombre'];
    $novedad   = $_POST['novedad'];
    if (strlen($ciudad) > 4) {
    } else {
        $conexion = mysqli_connect("localhost", "imporsuit_marketplace", "imporsuit_marketplace", "imporsuit_marketplace");
        $sql = "SELECT * FROM ciudad_cotizacion WHERE id_cotizacion = '$ciudad'";
        $result = mysqli_query($conexion, $sql);
        $row = mysqli_fetch_array($result);
        $ciudad = $row['codigo_ciudad_laar'];
        echo $ciudad;
    }
    $data = array(
        'guia' => $guia,
        "destino" => array(
            "ciudad" => $ciudad,
            "nombre" => $nombre,
            "cedula" => "",
            "callePrincipal" => $calle_principal,
            "numeracion" => $numeracion,
            "calleSecundaria" => $calle_secundaria,
            "referencia" => $referencia,
            "telefono" => $telefono,
            "celular" => $celular,
            "observacion" => $observacion,
            "correo" => "",
        ),
        "autorizado" => array(
            "isDevolucion" => false,
            "nombre" => "Administración",
            "observacion" => $novedad
        ),
    );
    //iniciar curl 
    $ch = curl_init();
    //establecer la URL y otras opciones apropiadas
    curl_setopt($ch, CURLOPT_URL, "https://api.laarcourier.com:9727/guias/datos/actualizar");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT"); // Establecer el método HTTP como PUT
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data)); // Adjuntar el cuerpo JSON
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(  // Configurar encabezados HTTP necesarios para la API
        'Content-Type: application/json',
        'Authorization: Bearer ' . $token  // Suponiendo que tienes una variable $token para el acceso
    ));
    //capturar la URL y pasarla al navegador
    $result = curl_exec($ch);
    //cerrar curl
    curl_close($ch);
    echo $result;
} else {
    echo json_encode("Transporte no soportado por el sistema");
}
$sql = "UPDATE novedades SET solucion_novedad = '$observacion' WHERE guia_novedad = '$guia'";
$result = mysqli_query($conexion, $sql);
if ($result) {
    echo "Novedad solucionada";
} else {
    echo "Error al solucionar la novedad";
}
