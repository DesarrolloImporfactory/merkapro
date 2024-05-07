<?php
$get_data = file_get_contents("php://input");

/* 
$url = "https://servientrega-ecuador-prueba.appsiscore.com/app/ws/cotizador_ser_recaudo.php?wsdl";

// Estructura del XML a enviar
$xml = <<<XML
<soapenv:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
xmlns:xsd="http://www.w3.org/2001/XMLSchema"
xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ws="https://servientrega-ecuador.appsiscore.com/app/ws/">
   <soapenv:Header/>
   <soapenv:Body>
      <ws:Consultar soapenv:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/">
         <producto xsi:type="xsd:string">PRUEBAS RECAUDOS</producto>
         <origen xsi:type="xsd:string">QUITO</origen>
         <destino xsi:type="xsd:string">GUAYAQUIL-GUAYAS</destino>
         <valor_mercaderia xsi:type="xsd:string">100</valor_mercaderia>
         <piezas xsi:type="xsd:string">2</piezas>
         <peso xsi:type="xsd:string">4</peso>
         <alto xsi:type="xsd:string">10</alto>
         <ancho xsi:type="xsd:string">10</ancho>
         <largo xsi:type="xsd:string">10</largo>
         <tokn xsi:type="xsd:string">1593aaeeb60a560c156387989856db6be7edc8dc220f9feae3aea237da6a951d</tokn>
         <usu xsi:type="xsd:string">PRUEBA</usu>
         <pwd xsi:type="xsd:string">s12345ABCDe</pwd>
      </ws:Consultar>
   </soapenv:Body>
</soapenv:Envelope>
XML;

// Inicializar cURL
$ch = curl_init($url);

// Configurar opcianes de cURL
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Ejecutar la solicitud
$response = curl_exec($ch);

// Cerrar la sesión cURL
curl_close($ch);

// Mostrar la respuesta
echo $response;
 */