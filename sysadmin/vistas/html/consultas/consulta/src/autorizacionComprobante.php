<?php
/*require_once 'C:\xampp\htdocs\punto_venta\vistas\html\consultas\consulta/lib/nusoap.php';*/
/*require_once 'https://'.$_SERVER['HTTP_HOST'].'/vistas/html/consultas/consulta/lib/nusoap.php';*/

require_once("/home/imporsuit/public_html/factelectronica.imporsuit.com/vistas/html/consultas/consulta/lib/nusoap.php");

require_once("/home/imporsuit/public_html/factelectronica.imporsuit.com/vistas/html/consultas/consulta/src/class/generarPDF.php");
/*require_once 'C:\xampp\htdocs\punto_venta\vistas\html\consultas\consulta/src/class/generarPDF.php';*/
//require_once 'config/conexion.php';

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of autorizacionComprobante
 *
 * @author UESR
 */
class autorizacionComprobante {

    //put your code here

    public Function generar($claveAcceso, $salida) {
        $comprobante = '';
        $serieComprobante = '';
        $rucEmisor = '';
        $razonSocial = '';
        $fechaEmision = '';
        $fechaAutorizacion = '';
        $tipoEmision = '';
        $identificacionReceptor = '';
       // $claveAcceso = '';
        $numeroAutorizacion = '';
        $importeTotal = '';
        $createdAt = '';



        $service = 'AutorizarComprobante';
        //$claveAcceso = '';

//EndPoint
        //celcer pruebas
        //cel produccion
        $servicio = "https://celcer.sri.gob.ec/comprobantes-electronicos-ws/AutorizacionComprobantesOffline?wsdl"; //url del servicio
        $parametros = array(); //parametros de la llamada
        $parametros['claveAccesoComprobante'] = $claveAcceso;
        
        //$parametros['claveAccesoComprobante'] = '0108202303070611826200110010010000100031234567811';

        $client = new nusoap_client($servicio);

        $error = $client->getError();



        $client->soap_defencoding = 'utf-8';

        
        $result = $client->call("autorizacionComprobante", $parametros, "http://ec.gob.sri.ws.autorizacion");
        
        //var_dump($result);die;
        $_SESSION['autorizacionComprobante'] = $result;
        $response = array();

        $file = fopen("log.txt", "a+");
        fwrite($file, "Servicio: " . $service . PHP_EOL);
        fwrite($file, "Clave Acceso: " . $claveAcceso . PHP_EOL);


        
        if ($client->fault) {

            fwrite($file, "Respuesta: " . print_r($result, true) . PHP_EOL);

            $file_error = fopen('errores/' . $claveAcceso . ".txt", "w");
            fwrite($file_error, "Servicio: " . $service . PHP_EOL);
            fwrite($file_error, "Clave Acceso: " . $claveAcceso . PHP_EOL);
            fwrite($file_error, "Respuesta: " . print_r($result, true) . PHP_EOL);
            fwrite($file_error, "\n__________________________________________________________________\n" . PHP_EOL);
            fclose($file_error);
        } else {
            $error = $client->getError();
            
            if ($error) {

                fwrite($file, "Respuesta: " . print_r($error, true) . PHP_EOL);

                $file_error = fopen('errores/' . $claveAcceso . ".txt", "w");
                fwrite($file_error, "Servicio: " . $service . PHP_EOL);
                fwrite($file_error, "Clave Acceso: " . $claveAcceso . PHP_EOL);
                fwrite($file_error, "Respuesta: " . print_r($error, true) . PHP_EOL);
                fwrite($file_error, "\n__________________________________________________________________\n" . PHP_EOL);
                fclose($file_error);
                echo serialize($error);
            } else {

                fwrite($file, "Respuesta: " . print_r($result, true) . PHP_EOL);
                if ($result['autorizaciones']['autorizacion']['estado'] != 'AUTORIZADO') {

                    $file_error = fopen('errores/' . $claveAcceso . ".txt", "w");
                    fwrite($file_error, "Servicio: " . $service . PHP_EOL);
                    fwrite($file_error, "Clave Acceso: " . $claveAcceso . PHP_EOL);
                    fwrite($file_error, "Respuesta: " . print_r($result, true) . PHP_EOL);
                    fwrite($file_error, "\n__________________________________________________________________\n" . PHP_EOL);
                    fclose($file_error);
                } else {
                    if (!empty($result['autorizaciones']['autorizacion']['comprobante'])) {
                        $file_comprobante = fopen('comprobantes/' . $claveAcceso . ".xml", "w");
                        $comprobante = $client->responseData;


                        $simplexml = simplexml_load_string(utf8_encode($comprobante));
                        $dom = new DOMDocument('1.0');
                        $dom->preserveWhiteSpace = false;
                        $dom->formatOutput = true;
                        $xml = str_replace(['&lt;', '&gt;'], ['<', '>'], $comprobante);

                        fwrite($file_comprobante, $xml . PHP_EOL);
                        fclose($file_comprobante);

                        $dataComprobante = simplexml_load_string(utf8_encode($result['autorizaciones']['autorizacion']['comprobante']));
                        if ($dataComprobante->infoFactura) {
                            //     var_dump($dataComprobante->infoFactura);

                            $facturaPDF = new generarPDF();
                            $facturaPDF->facturaPDF($dataComprobante, $claveAcceso);
                        }
                        if ($dataComprobante->infoNotaCredito) {
                            //     var_dump($dataComprobante->infoFactura);
                            $facturaPDF = new generarPDF();
                            $facturaPDF->notaCreditoPDF($dataComprobante, $claveAcceso);
                        }
                        if ($dataComprobante->infoCompRetencion) {
                            //     var_dump($dataComprobante->infoFactura);asdasdasdasd
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


        /*
        // Create connection
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_DATABASE);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $comprobante = $salida[0];
        $serieComprobante = $salida[1];
        $rucEmisor = $salida[2];
        $razonSocial = $salida[3];


        $fechaEmision = str_replace('/', '-', $salida[4]);
        $fechaEmision = date("d-m-Y", strtotime($fechaEmision));
        $fechaEmision = date_create($fechaEmision);
        $fechaEmision = date_format($fechaEmision, "Y-m-d");




        $fechaAutorizacion = str_replace('/', '-', $salida[5]);
        $fechaAutorizacion = date("d-m-Y H:i:s", strtotime($fechaAutorizacion));
        $fechaAutorizacion = date_create($fechaAutorizacion);
        $fechaAutorizacion = date_format($fechaAutorizacion, "Y-m-d H:i:s");


        $tipoEmision = $salida[6];
        $identificacionReceptor = $salida[7];
        $claveAcceso = $salida[8];
        $numeroAutorizacion = $salida[9];
        $importeTotal = $salida[10];
        $createdAt = date("Y-m-d H:i:s");

        



        $sql = "INSERT INTO `comprobantes` (`comprobante`, `serieComprobante`, `rucEmisor`, `razonSocial`, `fechaEmision`, `fechaAutorizacion`, `tipoEmision`, `identificacionReceptor`, `claveAcceso`, `numeroAutorizacion`, `importeTotal`, `createdAt`) VALUES 
    ('$comprobante', '$serieComprobante', '$rucEmisor', '$razonSocial', '$fechaEmision', '$fechaAutorizacion', '$tipoEmision', '$identificacionReceptor', '$claveAcceso', '$numeroAutorizacion', '$importeTotal', '$createdAt')";
        
        $conn->query($sql);*/
    }

}
