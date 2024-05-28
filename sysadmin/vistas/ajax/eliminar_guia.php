<?php
// Datos de autenticación
require_once "../db.php";
require_once "../php_conexion.php";
$authData = array(
    "username" => "import.uio.api",
    "password" => "Imp@rt*23"
);

$guia = $_POST['guia'];

if (strpos($guia, "MKP") !== 0 && !is_numeric($guia)) {
    $authUrl = "https://fast.imporsuit.com/GenerarGuia/anular/" . $guia;
    $authHeaders = array(
        'accept: application/json',
        'Content-Type: application/json',
        'X-Token-Guia: Zc46Um3cI8Eh9vce6hn9'
    );

    $chAuth = curl_init($authUrl);
    curl_setopt($chAuth, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($chAuth, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($chAuth, CURLOPT_HTTPHEADER, $authHeaders);

    $authResponse = curl_exec($chAuth);

    $httpCode = curl_getinfo($chAuth, CURLINFO_HTTP_CODE);

    if ($httpCode !== 200) {
        echo 'Error en la autenticación. Código de estado: ' . $httpCode;
    } else {
        $authResult = json_decode($authResponse, true);
        $token = $authResult['token'];
        $deleteURL = 'https://fast.imporsuit.com/GenerarGuia/anular/' . $guia;
        $chDelete = curl_init($deleteURL);
        $deleteHeaders = array(
            'X-Token-Guia: Zc46Um3cI8Eh9vce6hn9',
            'Authorization: Bearer ' . $token,
        );

        curl_setopt($chDelete, CURLOPT_CUSTOMREQUEST, 'DELETE');
        curl_setopt($chDelete, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($chDelete, CURLOPT_HTTPHEADER, $deleteHeaders);

        $deleteResponse = curl_exec($chDelete);

        $deleteHttpCode = curl_getinfo($chDelete, CURLINFO_HTTP_CODE);
        if ($deleteHttpCode === 200) {
            $sql = "UPDATE facturas_cot SET  estado_guia_sistema=8
                                WHERE id_factura='" . $id . "'";
            $query_update = mysqli_query($conexion, $sql);
            echo 'ok';
        } else {
            echo 'Error al enviar la solicitud DELETE. Código de estado: ' . $deleteHttpCode;
        }

        curl_close($chDelete);
    }

    curl_close($chAuth);
    return;
} else if (is_numeric($guia)) {
    $url = "https://guias.imporsuit.com/Servientrega/Anular/" . $guia;

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    echo $response;
    curl_close($ch);
    return;
}

$id = $_POST['id'];
//echo $guia;
// Convertir los datos de autenticación a formato JSON
$authDataJSON = json_encode($authData);

// URL y datos para la autenticación
$authURL = 'https://api.laarcourier.com:9727/authenticate';
$authHeaders = array(
    'accept: application/json',
    'Content-Type: application/json',
);

// Inicializar cURL para la autenticación
$chAuth = curl_init($authURL);
curl_setopt($chAuth, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($chAuth, CURLOPT_POSTFIELDS, $authDataJSON);
curl_setopt($chAuth, CURLOPT_RETURNTRANSFER, true);
curl_setopt($chAuth, CURLOPT_HTTPHEADER, $authHeaders);

// Ejecutar la solicitud de autenticación y obtener la respuesta
$authResponse = curl_exec($chAuth);

// Verificar si la autenticación fue exitosa
$httpCode = curl_getinfo($chAuth, CURLINFO_HTTP_CODE);
if ($httpCode !== 200) {
    echo 'Error en la autenticación. Código de estado: ' . $httpCode;
    // Manejar el error apropiadamente
} else {
    // Decodificar la respuesta JSON de autenticación
    $authResult = json_decode($authResponse, true);

    // Obtener el token de autenticación
    $token = $authResult['token'];

    // URL para la solicitud DELETE
    $deleteURL = 'https://api.laarcourier.com:9727/guias/anular/' . $guia;

    // Inicializar cURL para la solicitud DELETE con la cabecera de autenticación
    $chDelete = curl_init($deleteURL);
    $deleteHeaders = array(
        'Authorization: Bearer ' . $token,
    );

    curl_setopt($chDelete, CURLOPT_CUSTOMREQUEST, 'DELETE');
    curl_setopt($chDelete, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($chDelete, CURLOPT_HTTPHEADER, $deleteHeaders);

    // Ejecutar la solicitud DELETE y obtener la respuesta
    $deleteResponse = curl_exec($chDelete);

    // Verificar si la solicitud DELETE fue exitosa
    $deleteHttpCode = curl_getinfo($chDelete, CURLINFO_HTTP_CODE);
    if ($deleteHttpCode === 200) {
        $sql = "UPDATE facturas_cot SET  estado_guia_sistema=8
                                WHERE id_factura='" . $id . "'";
        $query_update = mysqli_query($conexion, $sql);
        echo 'ok';
    } else {
        echo 'Error al enviar la solicitud DELETE. Código de estado: ' . $deleteHttpCode;
        // Manejar el error apropiadamente
    }

    // Cerrar las conexiones cURL
    curl_close($chDelete);
}

// Cerrar la conexión cURL de autenticación
curl_close($chAuth);
