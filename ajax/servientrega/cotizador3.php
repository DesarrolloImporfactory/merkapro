<?php
require_once '../../sysadmin/vistas/db.php';
require_once '../../sysadmin/vistas/php_conexion.php';

$ciudad_origen = $_POST['ciudad_origen'];
$ciudad_destino = $_POST['ciudad_destino'];
$provincia_destino = $_POST['provincia_destino'];
$precio_total = $_POST['precio_total'];
$sql = "SELECT ciudad FROM ciudad_cotizacion WHERE ciudad LIKE '%$ciudad_destino%' AND provincia LIKE '%$provincia_destino%'";
$result = mysqli_query($conexion, $sql);
$es_slash = mysqli_fetch_array($result);

// Verifica si la ciudad contiene un slash
if (strpos($es_slash['ciudad'], '/') !== false) {
   $destino = $ciudad_destino . " (" . $provincia_destino . ")-" . $provincia_destino;
} else {
   $destino = $ciudad_destino . "-" . $provincia_destino;
}


$url = "https://servientrega-ecuador.appsiscore.com/app/ws/cotizador_ser_recaudo.php?wsdl";

$xml = <<<XML
<soapenv:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ws="https://servientrega-ecuador.appsiscore.com/app/ws/">
   <soapenv:Header/>
   <soapenv:Body>
      <ws:Consultar soapenv:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/">
         <producto xsi:type="xsd:string">MERCANCIA PREMIER</producto>
         <origen xsi:type="xsd:string">$ciudad_origen</origen>
         <destino xsi:type="xsd:string">$destino</destino>
         <valor_mercaderia xsi:type="xsd:string">$precio_total</valor_mercaderia>
         <piezas xsi:type="xsd:string">1</piezas>
         <peso xsi:type="xsd:string">2</peso>
         <alto xsi:type="xsd:string">10</alto>
         <ancho xsi:type="xsd:string">50</ancho>
         <largo xsi:type="xsd:string">50</largo>
         <tokn xsi:type="xsd:string">1593aaeeb60a560c156387989856db6be7edc8dc220f9feae3aea237da6a951d</tokn>
         <usu xsi:type="xsd:string">IMPCOMEX</usu>
         <pwd xsi:type="xsd:string">Rtcom-ex9912</pwd>
      </ws:Consultar>
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
