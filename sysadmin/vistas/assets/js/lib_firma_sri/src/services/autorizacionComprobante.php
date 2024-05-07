<?php

session_start();
if (!isset($_SESSION['user_login_status']) and $_SESSION['user_login_status'] != 1) {
    header("location: ../../../login.php");
    exit;
}

/* Connect To Database*/
include "../../../../../db.php";
include "../../../../../php_conexion.php";

require_once('../../lib/nusoap.php');
require_once('class/generarPDF.php');

$claveAcceso = $_POST['claveAcceso'];
$service = $_POST['service'];
$id = $_POST['id'];
$comprobantesri = $_POST['comprobante'];
$ambiente = $_POST['ambiente'];
$logo = $_POST['logo'];

if($ambiente == 2){
    //EndPoint
    $servicio = "https://cel.sri.gob.ec/comprobantes-electronicos-ws/AutorizacionComprobantesOffline?wsdl"; //url del servicio
}else{
    //EndPoint
    $servicio = "https://celcer.sri.gob.ec/comprobantes-electronicos-ws/AutorizacionComprobantesOffline?wsdl"; //url del servicio
}
//EndPoint
//$servicio = "https://celcer.sri.gob.ec/comprobantes-electronicos-ws/AutorizacionComprobantesOffline?wsdl"; //url del servicio
$parametros = array(); //parametros de la llamada
$parametros['claveAccesoComprobante'] = $claveAcceso;

$client = new nusoap_client($servicio);

$error = $client->getError();

$client->soap_defencoding = 'utf-8';


$result = $client->call("autorizacionComprobante", $parametros, "http://ec.gob.sri.ws.autorizacion");
$_SESSION['autorizacionComprobante'] = $result;
$response = array();

$file = fopen("../../log.txt", "a+");
fwrite($file, "Servicio: " . $service . PHP_EOL);
fwrite($file, "Clave Acceso: " . $claveAcceso . PHP_EOL);

$estado = '';

if ($client->fault) {
    fwrite($file, "Respuesta: " . print_r($result, true) . PHP_EOL);

    $file_error = fopen('../../errores/' . $claveAcceso . ".txt", "w");
    fwrite($file_error, "Servicio: " . $service . PHP_EOL);
    fwrite($file_error, "Clave Acceso: " . $claveAcceso . PHP_EOL);
    fwrite($file_error, "Respuesta: " . print_r($result, true) . PHP_EOL);
    fwrite($file_error, "\n__________________________________________________________________\n" . PHP_EOL);
    fclose($file_error);
    echo serialize($result);
} else {
    $error = $client->getError();
    if ($error) {
        fwrite($file, "Respuesta: " . print_r($error, true) . PHP_EOL);

        $file_error = fopen('../../errores/' . $claveAcceso . ".txt", "w");
        fwrite($file_error, "Servicio: " . $service . PHP_EOL);
        fwrite($file_error, "Clave Acceso: " . $claveAcceso . PHP_EOL);
        fwrite($file_error, "Respuesta: " . print_r($error, true) . PHP_EOL);
        fwrite($file_error, "\n__________________________________________________________________\n" . PHP_EOL);
        fclose($file_error);
        echo serialize($error);
    } else {
        echo serialize($result);
        fwrite($file, "Respuesta: " . print_r($result, true) . PHP_EOL);
        
        if ($result['autorizaciones']['autorizacion']['estado'] != 'AUTORIZADO') {
            //var_dump("aqui nuestra extraccion del mensaje");
            if($comprobantesri == 'FACTURA'){
                $mensaje = utf8_encode($result['autorizaciones']['autorizacion']['mensajes']['mensaje']['mensaje'] . $result['autorizaciones']['autorizacion']['mensajes']['mensaje']['informacionAdicional']);
                $estado = $result['autorizaciones']['autorizacion']['estado'];
                $query2 = mysqli_query($conexion, "UPDATE comprobantes_sri 
                                                    SET Estado = '$estado',  Mensaje = '$mensaje'
                                                    WHERE id_factura = '$id'")
                        or die('error: ' . mysqli_error($conexion));
            }elseif($comprobantesri == 'NOTA CREDITO'){
                $mensaje = utf8_encode($result['autorizaciones']['autorizacion']['mensajes']['mensaje']['mensaje'] . $result['autorizaciones']['autorizacion']['mensajes']['mensaje']['informacionAdicional']);
                $estado = $result['autorizaciones']['autorizacion']['estado'];
                $query2 = mysqli_query($conexion, "UPDATE comprobantes_sri 
                                                    SET Estado = '$estado',  Mensaje = '$mensaje'
                                                    WHERE id_credito = '$id'")
                        or die('error: ' . mysqli_error($conexion));
            }elseif($comprobantesri == 'NOTA DEBITO'){
                $mensaje = utf8_encode($result['autorizaciones']['autorizacion']['mensajes']['mensaje']['mensaje'] . $result['autorizaciones']['autorizacion']['mensajes']['mensaje']['informacionAdicional']);
                $estado = $result['autorizaciones']['autorizacion']['estado'];
                $query2 = mysqli_query($conexion, "UPDATE comprobantes_sri 
                                                    SET Estado = '$estado',  Mensaje = '$mensaje'
                                                    WHERE id_debito = '$id'")
                        or die('error: ' . mysqli_error($conexion));
            }elseif($comprobantesri == 'RETENCION'){
                $mensaje = utf8_encode($result['autorizaciones']['autorizacion']['mensajes']['mensaje']['mensaje'] . $result['autorizaciones']['autorizacion']['mensajes']['mensaje']['informacionAdicional']);
                $estado = $result['autorizaciones']['autorizacion']['estado'];
                $query2 = mysqli_query($conexion, "UPDATE comprobantes_sri 
                                                    SET Estado = '$estado',  Mensaje = '$mensaje'
                                                    WHERE id_retencion = '$id'")
                        or die('error: ' . mysqli_error($conexion));
            }elseif($comprobantesri == 'LIQUIDACION COMPRA'){
                $mensaje = utf8_encode($result['autorizaciones']['autorizacion']['mensajes']['mensaje']['mensaje'] . $result['autorizaciones']['autorizacion']['mensajes']['mensaje']['informacionAdicional']);
                $estado = $result['autorizaciones']['autorizacion']['estado'];
                $query2 = mysqli_query($conexion, "UPDATE comprobantes_sri 
                                                    SET Estado = '$estado',  Mensaje = '$mensaje'
                                                    WHERE id_liquidacion = '$id'")
                        or die('error: ' . mysqli_error($conexion));
            }elseif($comprobantesri == 'GUIA'){
                $mensaje = utf8_encode($result['autorizaciones']['autorizacion']['mensajes']['mensaje']['mensaje'] . $result['autorizaciones']['autorizacion']['mensajes']['mensaje']['informacionAdicional']);
                $estado = $result['autorizaciones']['autorizacion']['estado'];
                $query2 = mysqli_query($conexion, "UPDATE comprobantes_sri 
                                                    SET Estado = '$estado',  Mensaje = '$mensaje'
                                                    WHERE id_guia = '$id'")
                        or die('error: ' . mysqli_error($conexion));
            }
            
            $file_error = fopen('../../errores/' . $claveAcceso . ".txt", "w");
            fwrite($file_error, "Servicio: " . $service . PHP_EOL);
            fwrite($file_error, "Clave Acceso: " . $claveAcceso . PHP_EOL);
            fwrite($file_error, "Respuesta: " . print_r($result, true) . PHP_EOL);
            fwrite($file_error, "\n__________________________________________________________________\n" . PHP_EOL);
            fclose($file_error);
        } else {
            if (!empty($result['autorizaciones']['autorizacion']['comprobante'])) {
                $estado = $result['autorizaciones']['autorizacion']['estado'];
                $file_comprobante = fopen('../../../../../assets/comprobantes/autorizados/' . $claveAcceso . ".xml", "w");
                $comprobante = $client->responseData;
                $mensaje  = '';

                $simplexml = simplexml_load_string(utf8_encode($comprobante));
                $dom = new DOMDocument('1.0');
                $dom->preserveWhiteSpace = false;
                $dom->formatOutput = true;
                $xml = str_replace(['&lt;', '&gt;'], ['<', '>'], $comprobante);

                fwrite($file_comprobante, $xml . PHP_EOL);
                fclose($file_comprobante);
                $dataComprobante = simplexml_load_string(utf8_encode($result['autorizaciones']['autorizacion']['comprobante']));
                if($comprobantesri == 'FACTURA'){
                    $query2 = mysqli_query($conexion, "UPDATE comprobantes_sri 
                    SET Estado = '$estado',  Mensaje = '$mensaje'
                    WHERE id_factura = '$id'")
                    or die('error: ' . mysqli_error($conexion));
                }elseif($comprobantesri == 'NOTA CREDITO'){
                    $query2 = mysqli_query($conexion, "UPDATE comprobantes_sri 
                    SET Estado = '$estado',  Mensaje = '$mensaje'
                    WHERE id_credito = '$id'")
                    or die('error: ' . mysqli_error($conexion));
                    
                }elseif($comprobantesri == 'NOTA DEBITO'){
                    $query2 = mysqli_query($conexion, "UPDATE comprobantes_sri 
                    SET Estado = '$estado',  Mensaje = '$mensaje'
                    WHERE id_debito = '$id'")
                    or die('error: ' . mysqli_error($conexion));
                }elseif($comprobantesri == 'RETENCION'){
                    $query2 = mysqli_query($conexion, "UPDATE comprobantes_sri 
                    SET Estado = '$estado',  Mensaje = '$mensaje'
                    WHERE id_retencion = '$id'")
                    or die('error: ' . mysqli_error($conexion));
                }elseif($comprobantesri == 'LIQUIDACION COMPRA'){
                    $query2 = mysqli_query($conexion, "UPDATE comprobantes_sri 
                    SET Estado = '$estado',  Mensaje = '$mensaje'
                    WHERE id_liquidacion = '$id'")
                    or die('error: ' . mysqli_error($conexion));
                }elseif($comprobantesri == 'GUIA'){
                    
                    $query2 = mysqli_query($conexion, "UPDATE comprobantes_sri 
                    SET Estado = '$estado',  Mensaje = '$mensaje'
                    WHERE id_guia = '$id'")
                    or die('error: ' . mysqli_error($conexion));
                    
                }
                if ($dataComprobante->infoFactura) {

                    $facturaPDF = new generarPDF();
                    $facturaPDF->facturaPDF($dataComprobante, $claveAcceso,$logo);
                }
                if ($dataComprobante->infoNotaCredito) {
                    //     var_dump($dataComprobante->infoFactura);
                    $facturaPDF = new generarPDF();
                    $facturaPDF->notaCreditoPDF($dataComprobante, $claveAcceso);
                }
                if ($dataComprobante->infoCompRetencion) {
                    //     var_dump($dataComprobante->infoFactura);
                    $facturaPDF = new generarPDF();
                    $facturaPDF->comprobanteRetencionPDF($dataComprobante, $claveAcceso);
                }
                if ($dataComprobante->infoGuiaRemision) {
                    //     var_dump($dataComprobante->infoFactura);
                    $facturaPDF = new generarPDF();
                    $facturaPDF->guiaRemisionPDF($dataComprobante, $claveAcceso);
                }

                if ($dataComprobante->infoNotaDebito) {
                    //     var_dump($dataComprobante->infoFactura);
                    $facturaPDF = new generarPDF();
                    $facturaPDF->notaDebitoPDF($dataComprobante, $claveAcceso);
                }
                if ($dataComprobante->infoLiquidacionCompra) {
                    //     var_dump($dataComprobante->infoFactura);
                    $facturaPDF = new generarPDF();
                    $facturaPDF->liquidacionPDF($dataComprobante, $claveAcceso);
                }
            }
        }
    }
}

fwrite($file, "\n__________________________________________________________________\n" . PHP_EOL);
fclose($file);





