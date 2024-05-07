<?php
session_start();
if (!isset($_SESSION['user_login_status']) and $_SESSION['user_login_status'] != 1) {
    header("location: ../../../login.php");
    exit;
}
require_once('../../lib/nusoap.php');

//require_once "../../../../../config/database.php";
include "../../../../../db.php";
include "../../../../../php_conexion.php";

header("Content-Type: text/plain");
$content = file_get_contents("../../facturaFirmada.xml");
$mensaje = base64_encode($content);

$claveAcceso = $_POST['claveAcceso'];
$service = $_POST['service'];
$id = $_POST['id'];
$comprobante = $_POST['comprobante'];
$ambiente = $_POST['ambiente'];
//factura
if($comprobante == 'FACTURA'){
    $busquedafactura        = mysqli_query($conexion, "select * from comprobantes_sri WHERE id_factura = '$id'");
    $resfactura         = mysqli_fetch_array($busquedafactura);

    if($resfactura == null){
        $query2 = mysqli_query($conexion, "INSERT INTO comprobantes_sri (id_factura, tipo, claveAcceso)
                VALUES('$id', '$comprobante', '$claveAcceso')")
                or die('error: ' . mysqli_error($conexion));
    }
}else
//credito
if($comprobante == 'NOTA CREDITO'){
    $busquedacredito        = mysqli_query($conexion, "select * from comprobantes_sri WHERE id_credito = '$id'");
    $rescredito         = mysqli_fetch_array($busquedacredito);
    
    if($rescredito == null){
        $query2 = mysqli_query($conexion, "INSERT INTO comprobantes_sri (id_credito, tipo, claveAcceso)
                VALUES('$id', '$comprobante', '$claveAcceso')")
                or die('error: ' . mysqli_error($conexion));
    }
}else
//debito
if($comprobante == 'NOTA DEBITO'){
    $busquedadebito        = mysqli_query($conexion, "select * from comprobantes_sri WHERE id_debito = '$id'");
    $resdebito         = mysqli_fetch_array($busquedadebito);
    if($resdebito == null){
        $query2 = mysqli_query($conexion, "INSERT INTO comprobantes_sri (id_debito, tipo, claveAcceso)
                VALUES('$id', '$comprobante', '$claveAcceso')")
                or die('error: ' . mysqli_error($conexion));
    }
}else
//liquidacion
if($comprobante == 'LIQUIDACION COMPRA'){
    $busquedacredito        = mysqli_query($conexion, "select * from comprobantes_sri WHERE id_liquidacion = '$id'");
    $rescredito         = mysqli_fetch_array($busquedacredito);
    
    if($rescredito == null){
        $query2 = mysqli_query($conexion, "INSERT INTO comprobantes_sri (id_liquidacion, tipo, claveAcceso)
                VALUES('$id', '$comprobante', '$claveAcceso')")
                or die('error: ' . mysqli_error($conexion));
    }
}else
//guia
if($comprobante == 'GUIA'){
    $busquedaguia        = mysqli_query($conexion, "select * from comprobantes_sri WHERE id_guia = '$id'");
    $resguia        = mysqli_fetch_array($busquedaguia);
    
    if($resguia == null){
        $query2 = mysqli_query($conexion, "INSERT INTO comprobantes_sri (id_guia, tipo, claveAcceso)
                VALUES('$id', '$comprobante', '$claveAcceso')")
                or die('error: ' . mysqli_error($conexion));
    }
}else
//retencion
if($comprobante == 'RETENCION'){
    $busquedaretencion        = mysqli_query($conexion, "select * from comprobantes_sri WHERE id_retencion = '$id'");
    $resretencion        = mysqli_fetch_array($busquedaretencion);
    
    if($resretencion == null){
        $query2 = mysqli_query($conexion, "INSERT INTO comprobantes_sri (id_retencion, tipo, claveAcceso)
                VALUES('$id', '$comprobante', '$claveAcceso')")
                or die('error: ' . mysqli_error($conexion));
    }
}
if($ambiente == 2){
    //EndPoint
    $servicio = "https://cel.sri.gob.ec/comprobantes-electronicos-ws/RecepcionComprobantesOffline?wsdl"; //url del servicio
}else{
    //EndPoint
    $servicio = "https://celcer.sri.gob.ec/comprobantes-electronicos-ws/RecepcionComprobantesOffline?wsdl"; //url del servicio
}

$parametros = array(); //parametros de la llamada

$parametros['xml'] = $mensaje;

$client = new nusoap_client($servicio);


$client->soap_defencoding = 'utf-8';


$result = $client->call("validarComprobante", $parametros, "http://ec.gob.sri.ws.recepcion");
$response = array();
$file = fopen("../../log.txt", "a+");
fwrite($file, "Servicio: " . $service . PHP_EOL);
fwrite($file, "Clave Acceso: " . $claveAcceso . PHP_EOL);
$estado = '';
$_SESSION['validarComprobante']=$result;
if ($client->fault) {  
    $estado = 'ERROR';
    $file_error = fopen('../../errores/'.$claveAcceso.".txt", "w");
    fwrite($file_error, "Servicio: " . $service . PHP_EOL);
    fwrite($file_error, "Clave Acceso: " . $claveAcceso . PHP_EOL);
    fwrite($file_error, "Respuesta: " . print_r($result,true) . PHP_EOL);
    fwrite($file_error, "\n__________________________________________________________________\n". PHP_EOL);
    fclose($file_error);
    fwrite($file, "Respuesta: " . print_r($result,true) . PHP_EOL);
    echo serialize($result);
    if($comprobante == 'FACTURA'){
        $mensaje = utf8_encode($result['autorizaciones']['autorizacion']['mensajes']['mensaje']['mensaje'] . $result['autorizaciones']['autorizacion']['mensajes']['mensaje']['informacionAdicional']);
        $estado = $result['autorizaciones']['autorizacion']['estado'];
        $query2 = mysqli_query($conexion, "UPDATE comprobantes_sri 
                                                SET Estado = '$estado',  Mensaje = '$mensaje'
                                                WHERE id_factura = '$id'")
                    or die('error: ' . mysqli_error($conexion));
    }elseif($comprobante == 'NOTA CREDITO'){
        $mensaje = utf8_encode($result['autorizaciones']['autorizacion']['mensajes']['mensaje']['mensaje'] . $result['autorizaciones']['autorizacion']['mensajes']['mensaje']['informacionAdicional']);
        $estado = $result['autorizaciones']['autorizacion']['estado'];
        $query2 = mysqli_query($conexion, "UPDATE comprobantes_sri 
                                                SET Estado = '$estado',  Mensaje = '$mensaje'
                                                WHERE id_credito = '$id'")
                    or die('error: ' . mysqli_error($conexion));
    }elseif($comprobante == 'NOTA DEBITO'){
        $mensaje = utf8_encode($result['autorizaciones']['autorizacion']['mensajes']['mensaje']['mensaje'] . $result['autorizaciones']['autorizacion']['mensajes']['mensaje']['informacionAdicional']);
        $estado = $result['autorizaciones']['autorizacion']['estado'];
        $query2 = mysqli_query($conexion, "UPDATE comprobantes_sri 
                                                SET Estado = '$estado',  Mensaje = '$mensaje'
                                                WHERE id_debito = '$id'")
                    or die('error: ' . mysqli_error($conexion));
    }elseif($comprobante == 'RETENCION'){
        $mensaje = utf8_encode($result['autorizaciones']['autorizacion']['mensajes']['mensaje']['mensaje'] . $result['autorizaciones']['autorizacion']['mensajes']['mensaje']['informacionAdicional']);
        $estado = $result['autorizaciones']['autorizacion']['estado'];
        $query2 = mysqli_query($conexion, "UPDATE comprobantes_sri 
                                                SET Estado = '$estado',  Mensaje = '$mensaje'
                                                WHERE id_retencion = '$id'")
                    or die('error: ' . mysqli_error($conexion));
    }elseif($comprobante == 'LIQUIDACION COMPRA'){
        $mensaje = utf8_encode($result['autorizaciones']['autorizacion']['mensajes']['mensaje']['mensaje'] . $result['autorizaciones']['autorizacion']['mensajes']['mensaje']['informacionAdicional']);
        $estado = $result['autorizaciones']['autorizacion']['estado'];
        $query2 = mysqli_query($conexion, "UPDATE comprobantes_sri 
                                                SET Estado = '$estado',  Mensaje = '$mensaje'
                                                WHERE id_liquidacion = '$id'")
                    or die('error: ' . mysqli_error($conexion));
    }elseif($comprobante == 'GUIA'){
        $mensaje = utf8_encode($result['autorizaciones']['autorizacion']['mensajes']['mensaje']['mensaje'] . $result['autorizaciones']['autorizacion']['mensajes']['mensaje']['informacionAdicional']);
        $estado = $result['autorizaciones']['autorizacion']['estado'];
        $query2 = mysqli_query($conexion, "UPDATE comprobantes_sri 
                                                SET Estado = '$estado',  Mensaje = '$mensaje'
                                                WHERE id_guia = '$id'")
                    or die('error: ' . mysqli_error($conexion));
    }
    
        
} else {
    $error = $client->getError();
    if ($error) {
        $estado = 'ERROR';
        fwrite($file, "Respuesta: " . print_r($error,true) . PHP_EOL);
        $file_error = fopen('../../errores/'.$claveAcceso.".txt", "w");
        fwrite($file_error, "Servicio: " . $service . PHP_EOL);
        fwrite($file_error, "Clave Acceso: " . $claveAcceso . PHP_EOL);
        fwrite($file_error, "Respuesta: " . print_r($error,true) . PHP_EOL);
        fwrite($file_error, "\n__________________________________________________________________\n". PHP_EOL);
        fclose($file_error);
        echo serialize($error);
        
        
            if($comprobante == 'FACTURA'){
                $mensaje = utf8_encode($result['autorizaciones']['autorizacion']['mensajes']['mensaje']['mensaje'] . $result['autorizaciones']['autorizacion']['mensajes']['mensaje']['informacionAdicional']);
                $estado = $result['autorizaciones']['autorizacion']['estado'];
                $query2 = mysqli_query($conexion, "UPDATE comprobantes_sri 
                                                    SET Estado = '$estado',  Mensaje = '$mensaje'
                                                    WHERE id_factura = '$id'")
                        or die('error: ' . mysqli_error($conexion));
            }else if($comprobante == 'NOTA CREDITO'){
                $mensaje = utf8_encode($result['autorizaciones']['autorizacion']['mensajes']['mensaje']['mensaje'] . $result['autorizaciones']['autorizacion']['mensajes']['mensaje']['informacionAdicional']);
                $estado = $result['autorizaciones']['autorizacion']['estado'];
                $query2 = mysqli_query($conexion, "UPDATE comprobantes_sri 
                                                    SET Estado = '$estado',  Mensaje = '$mensaje'
                                                    WHERE id_credito = '$id'")
                        or die('error: ' . mysqli_error($conexion));
            }else if($comprobante == 'NOTA DEBITO'){
                $mensaje = utf8_encode($result['autorizaciones']['autorizacion']['mensajes']['mensaje']['mensaje'] . $result['autorizaciones']['autorizacion']['mensajes']['mensaje']['informacionAdicional']);
                //var_dump($mensaje);die;
                $estado = $result['autorizaciones']['autorizacion']['estado'];
                $query2 = mysqli_query($conexion, "UPDATE comprobantes_sri 
                                                    SET Estado = '$estado',  Mensaje = '$mensaje'
                                                    WHERE id_debito = '$id'")
                        or die('error: ' . mysqli_error($conexion));
            }else if($comprobante == 'RETENCION'){
                $mensaje = utf8_encode($result['autorizaciones']['autorizacion']['mensajes']['mensaje']['mensaje'] . $result['autorizaciones']['autorizacion']['mensajes']['mensaje']['informacionAdicional']);
                $estado = $result['autorizaciones']['autorizacion']['estado'];
                $query2 = mysqli_query($conexion, "UPDATE comprobantes_sri 
                                                    SET Estado = '$estado',  Mensaje = '$mensaje'
                                                    WHERE id_retencion = '$id'")
                        or die('error: ' . mysqli_error($conexion));
            }else if($comprobante == 'LIQUIDACION COMPRA'){
                $mensaje = utf8_encode($result['autorizaciones']['autorizacion']['mensajes']['mensaje']['mensaje'] . $result['autorizaciones']['autorizacion']['mensajes']['mensaje']['informacionAdicional']);
                $estado = $result['autorizaciones']['autorizacion']['estado'];
                $query2 = mysqli_query($conexion, "UPDATE comprobantes_sri 
                                                    SET Estado = '$estado',  Mensaje = '$mensaje'
                                                    WHERE id_liquidacion = '$id'")
                        or die('error: ' . mysqli_error($conexion));
            }else if($comprobante == 'GUIA'){
                $mensaje = utf8_encode($result['autorizaciones']['autorizacion']['mensajes']['mensaje']['mensaje'] . $result['autorizaciones']['autorizacion']['mensajes']['mensaje']['informacionAdicional']);
                $estado = $result['autorizaciones']['autorizacion']['estado'];
                $query2 = mysqli_query($conexion, "UPDATE comprobantes_sri 
                                                    SET Estado = '$estado',  Mensaje = '$mensaje'
                                                    WHERE id_guia = '$id'")
                        or die('error: ' . mysqli_error($conexion));
            }
        
            
    } else {
        if ($result['estado']=='RECIBIDA'){
            $estado = 'RECIBIDA';          
            fwrite($file, "Respuesta: " . print_r($result,true) . PHP_EOL);
            //$estado = $result['autorizaciones']['autorizacion']['estado'];
            if($comprobante == 'FACTURA'){
                $query2 = mysqli_query($conexion, "UPDATE comprobantes_sri 
                                                SET Estado = '$estado'
                                                WHERE id_factura = '$id'")
                    or die('error: ' . mysqli_error($conexion));
            }elseif($comprobante == 'NOTA CREDITO'){
                $query2 = mysqli_query($conexion, "UPDATE comprobantes_sri 
                                                SET Estado = '$estado'
                                                WHERE id_credito = '$id'")
                    or die('error: ' . mysqli_error($conexion));
            }elseif($comprobante == 'NOTA DEBITO'){
                    $query2 = mysqli_query($conexion, "UPDATE comprobantes_sri 
                                                    SET Estado = '$estado'
                                                    WHERE id_debito = '$id'")
                        or die('error: ' . mysqli_error($conexion));
            }elseif($comprobante == 'RETENCION'){
                
                $query2 = mysqli_query($conexion, "UPDATE comprobantes_sri 
                                                SET Estado = '$estado'
                                                WHERE id_retencion = '$id'")
                    or die('error: ' . mysqli_error($conexion));
            }elseif($comprobante == 'LIQUIDACION COMPRA'){
                
                $query2 = mysqli_query($conexion, "UPDATE comprobantes_sri 
                                                SET Estado = '$estado'
                                                WHERE id_liquidacion = '$id'")
                    or die('error: ' . mysqli_error($conexion));
            }elseif($comprobante == 'GUIA'){
                $query2 = mysqli_query($conexion, "UPDATE comprobantes_sri 
                                                SET Estado = '$estado'
                                                WHERE id_guia = '$id'")
                    or die('error: ' . mysqli_error($conexion));
            }
            
        }else {
            $estado = 'ERROR';
            fwrite($file, "Respuesta: " . print_r($result,true) . PHP_EOL);
            $file_error = fopen('../../errores/'.$claveAcceso.".txt", "w");
            fwrite($file_error, "Servicio: " . $service . PHP_EOL);
            fwrite($file_error, "Clave Acceso: " . $claveAcceso . PHP_EOL);            
            fwrite($file_error, "Respuesta: " . print_r($result,true) . PHP_EOL);
            fwrite($file_error, "\n__________________________________________________________________\n". PHP_EOL);
            fclose($file_error);
            
            
            if($comprobante == 'FACTURA'){
                
                if(isset($result['autorizaciones'])){
                    $mensaje = utf8_encode($result['autorizaciones']['autorizacion']['mensajes']['mensaje']['mensaje'] . $result['autorizaciones']['autorizacion']['mensajes']['mensaje']['informacionAdicional']);
                    $estado = $result['autorizaciones']['autorizacion']['estado'];
                    $query2 = mysqli_query($conexion, "UPDATE comprobantes_sri 
                                                        SET Estado = '$estado',  Mensaje = '$mensaje'
                                                        WHERE id_factura = '$id'")
                            or die('error: ' . mysqli_error($conexion));
                }else{
                    
                    if(isset($result['comprobantes']['comprobante']['mensajes']['mensaje']['informacionAdicional'])){
                        $mensaje = utf8_encode($result['comprobantes']['comprobante']['mensajes']['mensaje']['mensaje'] . $result['comprobantes']['comprobante']['mensajes']['mensaje']['informacionAdicional']);
                        $estado = $result['estado'];
                        $query2 = mysqli_query($conexion, "UPDATE comprobantes_sri 
                                                            SET Estado = '$estado',  Mensaje = '$mensaje'
                                                            WHERE id_factura = '$id'")
                                or die('error: ' . mysqli_error($conexion));
                    }else{
                        $mensaje = utf8_encode($result['comprobantes']['comprobante']['mensajes']['mensaje']['mensaje']);
                        $estado = $result['estado'];
                        $query2 = mysqli_query($conexion, "UPDATE comprobantes_sri 
                                                            SET Estado = '$estado',  Mensaje = '$mensaje'
                                                            WHERE id_factura = '$id'")
                                or die('error: ' . mysqli_error($conexion));
                    }
                    
                }
                
            }elseif($comprobante == 'NOTA CREDITO'){
                $estado = $result['estado'];
                $mensaje = utf8_encode($result['comprobantes']['comprobante']['mensajes']['mensaje']['mensaje']);
                
                $query2 = mysqli_query($conexion, "UPDATE comprobantes_sri 
                                                    SET Estado = '$estado',  Mensaje = '$mensaje'
                                                    WHERE id_credito = '$id'")
                        or die('error: ' . mysqli_error($conexion));
            }elseif($comprobante == 'NOTA DEBITO'){
                $estado = $result['estado'];
                $mensaje = utf8_encode($result['comprobantes']['comprobante']['mensajes']['mensaje']['mensaje'] );
                if(isset($result['comprobantes']['comprobante']['mensajes']['mensaje']['informacionAdicional'])){
                    $mensaje .= utf8_encode('- Info Adicional: '. $result['comprobantes']['comprobante']['mensajes']['mensaje']['informacionAdicional'] );
                    
                    $mensaje = str_replace('{', "", $mensaje);
                    $mensaje = str_replace('}', "", $mensaje);
                    $mensaje = str_replace("'", "", $mensaje);
                }
                
                $query2 = mysqli_query($conexion, "UPDATE comprobantes_sri 
                                                    SET Estado = '$estado',  Mensaje = '$mensaje'
                                                    WHERE id_debito = '$id'")
                        or die('error: ' . mysqli_error($conexion));
            }elseif($comprobante == 'RETENCION'){
                $estado = $result['estado'];
                $mensaje = utf8_encode($result['comprobantes']['comprobante']['mensajes']['mensaje']['mensaje'] );
                if(isset($result['comprobantes']['comprobante']['mensajes']['mensaje']['informacionAdicional'])){
                    $mensaje .= utf8_encode('- Info Adicional: '. $result['comprobantes']['comprobante']['mensajes']['mensaje']['informacionAdicional'] );
                    
                    $mensaje = str_replace('{', "", $mensaje);
                    $mensaje = str_replace('}', "", $mensaje);
                    $mensaje = str_replace("'", "", $mensaje);
                }
                //$mensaje =  str_replace('"', '', $mensaje);
               
                //var_dump($mensaje,$result);die;
                $query2 = mysqli_query($conexion, "UPDATE comprobantes_sri 
                                                    SET Estado = '$estado',  Mensaje = '$mensaje'
                                                    WHERE id_retencion = '$id'")
                        or die('error: ' . mysqli_error($conexion));
            }elseif($comprobante == 'LIQUIDACION COMPRA'){
                $estado = $result['estado'];
                $mensaje = utf8_encode($result['comprobantes']['comprobante']['mensajes']['mensaje']['mensaje'] );
                if(isset($result['comprobantes']['comprobante']['mensajes']['mensaje']['informacionAdicional'])){
                    $mensaje .= utf8_encode('- Info Adicional: '. $result['comprobantes']['comprobante']['mensajes']['mensaje']['informacionAdicional'] );
                    
                    $mensaje = str_replace('{', "", $mensaje);
                    $mensaje = str_replace('}', "", $mensaje);
                    $mensaje = str_replace("'", "", $mensaje);
                }
                $query2 = mysqli_query($conexion, "UPDATE comprobantes_sri 
                                                    SET Estado = '$estado',  Mensaje = '$mensaje'
                                                    WHERE id_liquidacion = '$id'")
                        or die('error: ' . mysqli_error($conexion));
            }elseif($comprobante == 'GUIA'){
                $estado = $result['estado'];
                $mensaje = utf8_encode($result['comprobantes']['comprobante']['mensajes']['mensaje']['mensaje']);
                
                $query2 = mysqli_query($conexion, "UPDATE comprobantes_sri 
                                                    SET Estado = '$estado',  Mensaje = '$mensaje'
                                                    WHERE id_guia = '$id'")
                        or die('error: ' . mysqli_error($conexion));
            }
            
        }
        echo serialize($result);

        /*$mysqli = new mysqli("localhost","root","","da_kennedy");

        // Check connection
        if ($mysqli -> connect_errno) {
        echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
        exit();
        }
        $id = 2;
       $sql = "UPDATE factura SET estado='".$estado."' WHERE id= $id";*/

        /*if ($mysqli->query($sql) === FALSE) {
            echo "Error updating record: " . $mysqli->error;
        }*/


        
    }
}
fwrite($file, "\n__________________________________________________________________\n". PHP_EOL);
fclose($file);




