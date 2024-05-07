<?php
$domi = $_POST["dominio"];
$name = $_POST["nombre"];
// Configuración de la API de cPanel
$cpanelUrl = 'https://imporsuit.com:2083/'; // Reemplaza con la URL de tu cPanel
$cpanelUsername = 'imporsuit';
$cpanelPassword = '09992631072demasiado.';

// Datos del subdominio a crear
$subdomain = $domi;
$rootdomain = 'imporsuit.com';



// URL de la API para agregar subdominios
$apiUrl = $cpanelUrl . '/cpsess' . session_id() . '/execute/SubDomain/addsubdomain?domain=' . $subdomain . '&rootdomain=' . $rootdomain;

// Inicializar cURL
$ch = curl_init($apiUrl);

// Configurar las opciones de cURL
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Desactivar en producción, habilita la verificación SSL
curl_setopt($ch, CURLOPT_USERPWD, $cpanelUsername . ':' . $cpanelPassword);

// Ejecutar la solicitud
$response = curl_exec($ch);
$msg_status = "";
// Verificar si hubo errores
if (curl_errno($ch)) {
} else {
    // Analizar la respuesta JSON si es necesario
    $responseData = json_decode($response, true);

    // Hacer algo con la respuesta (puede variar según la respuesta de la API)
    $msg_status .= "ok_";
}

// Cerrar la sesión cURL
curl_close($ch);
?>

<?php
$domi = $_POST["dominio"];
$name = $_POST["nombre"];
// Configuración de la API de cPanel
$cpanelUrl = 'https://imporsuit.com:2083/'; // Reemplaza con la URL de tu cPanel
$cpanelUsername = 'imporsuit';
$cpanelPassword = '09992631072demasiado.';

// Datos del alias de dominio a crear
$aliasDomain = $domi;
$newDomain = $domi;
$subdomain = "$domi.imporsuit.com";
$directory = $domi;

// Configurar los parámetros para la solicitud
$params = array(
    'cpanel_jsonapi_user' => 'imporsuit',
    'cpanel_jsonapi_apiversion' => 2,
    'cpanel_jsonapi_module' => 'AddonDomain',
    'cpanel_jsonapi_func' => 'addaddondomain',
    'newdomain' => $newDomain,
    'dir' => $directory,
    'subdomain' => $subdomain,
);

// URL de la API para agregar alias
$apiUrl = $cpanelUrl . '/cpsess' . session_id() . '/json-api/cpanel?cpanel_jsonapi_user=' . $cpanelUsername . '&cpanel_jsonapi_apiversion=2&cpanel_jsonapi_module=AddonDomain&cpanel_jsonapi_func=addaddondomain&newdomain=' . $newDomain . '&dir=' . $directory . '&subdomain=' . $subdomain;
// Inicializar cURL
$ch = curl_init($apiUrl);

// Configurar las opciones de cURL
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Desactivar en producción, habilita la verificación SSL
curl_setopt($ch, CURLOPT_USERPWD, $cpanelUsername . ':' . $cpanelPassword);

// Ejecutar la solicitud
$response = curl_exec($ch);

// Verificar si hubo errores
if (curl_errno($ch)) {
    $msg_status .= "fail_";
} else {
    // Analizar la respuesta JSON si es necesario
    $responseData = json_decode($response, true);

    // Hacer algo con la respuesta (puede variar según la respuesta de la API)
    $msg_status .= "ok_";
}

// Cerrar la sesión cURL
curl_close($ch);

?>

<?php
// ************* Script que sube los archivos al directorio ppal **********
$domi = $_POST["dominio"];
$name = $_POST["nombre"];
$host = $_SERVER["HTTP_HOST"];

$zip = new ZipArchive;
$res = $zip->open("/home/imporsuit/public_html/index.zip");
if ($res === TRUE) {
    $zip->extractTo("/home/imporsuit/public_html/$domi/");
    $zip->close();
    $msg_status .= "ok";
} else {
    $msg_status .= "fail";
}
$oldFile = "/home/imporsuit/public_html/$domi/index.html";
file_put_contents($oldFile, str_replace("totototo", "$name", file_get_contents($oldFile)));
$oldFile = "/home/imporsuit/public_html/$domi/index.html";
file_put_contents($oldFile, str_replace("https://joelpizzano.imporfactory.app/", "https://$host", file_get_contents($oldFile)));

echo json_encode($msg_status);

?>