<head>
<style>
        .loader-page {
    position: fixed;
    z-index: 25000;
    background: rgb(255, 255, 255);
    left: 0px;
    top: 0px;
    height: 100%;
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    transition:all .3s ease;
  }
  .loader-page::before {
    content: "";
    position: absolute;
    border: 2px solid rgb(50, 150, 176);
    width: 60px;
    height: 60px;
    border-radius: 50%;
    box-sizing: border-box;
    border-left: 2px solid rgba(50, 150, 176,0);
    border-top: 2px solid rgba(50, 150, 176,0);
    animation: rotarload 1s linear infinite;
    transform: rotate(0deg);
  }
  @keyframes rotarload {
      0%   {transform: rotate(0deg)}
      100% {transform: rotate(360deg)}
  }
  .loader-page::after {
    content: "";
    position: absolute;
    border: 2px solid rgba(50, 150, 176,.5);
    width: 60px;
    height: 60px;
    border-radius: 50%;
    box-sizing: border-box;
    border-left: 2px solid rgba(50, 150, 176, 0);
    border-top: 2px solid rgba(50, 150, 176, 0);
    animation: rotarload 1s ease-out infinite;
    transform: rotate(0deg);
  }
    </style>
</head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="../../assets/js/lib_firma_sri/js/uft8.js"></script>
<script src="../../assets/js/lib_firma_sri/js/fiddle.js"></script>
<script src="../../assets/js/lib_firma_sri/js/forge.min.js"></script>
<script src="../../assets/js/lib_firma_sri/js/moment.min.js"></script>
<script src="../../assets/js/lib_firma_sri/js/buffer.js"></script>
<?php
/*-------------------------
Autor: Obed Alvarado
Web: obedalvarado.pw
Mail: info@obedalvarado.pw
---------------------------*/
session_start();
if (!isset($_SESSION['user_login_status']) and $_SESSION['user_login_status'] != 1) {
    header("location: ../../../login.php");
    exit;
}

/* Connect To Database*/
include "../../db.php";
include "../../php_conexion.php";
//Archivo de funciones PHP
include "../../funciones.php";

function validar_clave($clave) {

    if ($clave == "") {
        $verificado = false;
        return $verificado;
    }

    $x = 2;
    $sumatoria = 0;
    for ($i = strlen($clave) - 1; $i >= 0; $i--) {
        if ($x > 7) {
            $x = 2;
        }
        $sumatoria = $sumatoria + ($clave[$i] * $x);
        $x++;
    }
    $digito = $sumatoria % 11;
    $digito = 11 - $digito;

    switch ($digito) {
        case 10:
            $digito = "1";
            break;
        case 11:
            $digito = "0";
            break;
    }

    /*
      if (strtolower($digito_v)==$digito){
      $verificado=true;
      } else {
      $verificado=false;
      }

     */

    return $digito;
}
$id_retencion = intval($_GET['id_factura']);
$sql_count  = mysqli_query($conexion, "select * from retencion where id_retencion='" . $id_retencion . "'");
$count      = mysqli_num_rows($sql_count);
if ($count == 0) {
    echo "<script>alert('Factura no encontrada')</script>";
    echo "<script>window.close();</script>";
    exit;
}

$sql_factura    = mysqli_query($conexion, "select * from retencion where id_retencion='" . $id_retencion . "'");
$rw_factura     = mysqli_fetch_array($sql_factura);
//$xml_detalles = '<detalles>';
$query = mysqli_query($conexion, "SELECT  *
                                  FROM impuestocomprobanteretencion
                                left JOIN retencion  ON impuestocomprobanteretencion.retencion_id = retencion.id_retencion
                                WHERE impuestocomprobanteretencion.retencion_id = '" . $id_retencion . "'");
$contadorProductos = 0;
$detallesProductos = array();
$totalSinImpuestos = 0;
$xml_impuestos = '';
    $xml_impuestosfinal = '';
    $xml_pagos = '';
    $xml_motivos = '';
    $vartot = 0;
    $base = 0;
    
while ($data_productos = $query->fetch_assoc()) {
     
     $xml_impuestos .= '<impuesto>
        <codigo>' . $data_productos['codigo'] . '</codigo>
        <codigoRetencion>' . $data_productos['codigoretencion'] . '</codigoRetencion>
        <baseImponible>' . $data_productos['baseimponible'] .'</baseImponible>
        <porcentajeRetener>' . $data_productos['porcentajeretener'] .'</porcentajeRetener>
        <valorRetenido>' . $data_productos['valorretenido'] .'</valorRetenido>
        <codDocSustento>' . $data_productos['coddocsustento'] .'</codDocSustento>
        <numDocSustento>' . $data_productos['numdocsustento'] .'</numDocSustento>
        <fechaEmisionDocSustento>' . date("d/m/Y", strtotime($data_productos['fechaemisiondocsustento'])) . '</fechaEmisionDocSustento>
    </impuesto>';
    
}
//$xml_detalles .= '</detalles>';

// Datos para el Encabezado del XML
$query = mysqli_query($conexion, "SELECT * from perfil ORDER BY id_perfil DESC")
or die('error: ' . mysqli_error($conexion));
$dataperfil = mysqli_fetch_assoc($query);
$id_tipo_ambiente= $dataperfil['ambiente'];
$id_tipo_emision = $dataperfil['tipoEmision'];
$razon_social_empresa = $dataperfil['giro_empresa'];
$nombre_comercial_empresa = $dataperfil['nombre_empresa'];
$nro_documento_empresa = $dataperfil['ruc'];
//$nro_documento_empresa = '1713683801001';

//destinatario
$id_cliente = $rw_factura['id_cliente'];
$querycliente = mysqli_query($conexion, "SELECT * from clientes where id_cliente='".$id_cliente."'")
or die('error: ' . mysqli_error($conexion));
$datacliente = mysqli_fetch_assoc($querycliente);
$identificacionDestinatario = '0707061214';
$razonSocialDestinatario = $datacliente['razon_social'];
$direccion_cliente = $datacliente['direccion_cliente'];



$clave_acceso = '';
$codigo_establecimiento = $dataperfil['codigo_establecimiento'];
$codigo_punto_emision = $dataperfil['codigo_punto_emision'];
//$secuencial = $id_factura;
$secuencial = 100011204+$id_retencion;

$direccion_empresa = $dataperfil['direccion'];
//$fecha_emision = date('m/d/Y h:i:s a', time());
$fecha_emision = date('m/d/Y h:i:s a', time());

$direccion_sucursal = $dataperfil['direccion'];
//$id_tipo_documento = '05';
$id_tipo_documento = '05';

$ruta_firma = $dataperfil['firma'];
$pass_firma = $dataperfil['passFirma'];
//$valortotal = $rw_factura['monto_factura'];
//$num_doc_modificado = $rw_factura['numdocmod'];
$periodoFiscal = $rw_factura['periodoFiscal'];

//$fechaemisiondocmodulo = $rw_factura['fechaemisiondocmodulo'];
//$fechaemisiondocmodulo = date('d/m/Y', strtotime($fechaemisiondocmodulo));
$clave = "" . date('dmY', strtotime($fecha_emision)) . "" . '07' . "" . $nro_documento_empresa . "" . $id_tipo_ambiente . "" . $codigo_establecimiento . "" . $codigo_punto_emision . "" . str_pad($secuencial, '9', '0', STR_PAD_LEFT) . "" . str_pad($id_retencion, '8', '0', STR_PAD_LEFT) . "" . $id_tipo_emision . "";
$digito_verificador_clave = validar_clave($clave);
$clave_acceso = "" . date('dmY', strtotime($fecha_emision)) . "" . '07' . "" . $nro_documento_empresa . "" . $id_tipo_ambiente . "" . $codigo_establecimiento . "" . $codigo_punto_emision . "" . str_pad($secuencial, '9', '0', STR_PAD_LEFT) . "" . str_pad($id_retencion, '8', '0', STR_PAD_LEFT) . "" . $id_tipo_emision  . "" . $digito_verificador_clave . "";
$total_sin_impuestos = $base;

$xml = '<?xml version="1.0" encoding="UTF-8"?>
    <comprobanteRetencion id="comprobante" version="1.0.0">
        <infoTributaria>
            <ambiente>' . $id_tipo_ambiente . '</ambiente>
            <tipoEmision>' . $id_tipo_emision . '</tipoEmision>
            <razonSocial>' . $razon_social_empresa . '</razonSocial>
            <nombreComercial>' . $nombre_comercial_empresa . '</nombreComercial>
            <ruc>' . $nro_documento_empresa . '</ruc>
            <claveAcceso>' . $clave_acceso . '</claveAcceso>
            <codDoc>07</codDoc>
            <estab>' . $codigo_establecimiento . '</estab>
            <ptoEmi>' . $codigo_punto_emision . '</ptoEmi>
            <secuencial>' . str_pad($secuencial, '9', '0', STR_PAD_LEFT) . '</secuencial>
            <dirMatriz>' . $direccion_empresa . '</dirMatriz>
        </infoTributaria>
        <infoCompRetencion>
            <fechaEmision>' . date("d/m/Y", strtotime($fecha_emision)) . '</fechaEmision>
            <dirEstablecimiento>' . $direccion_sucursal . '</dirEstablecimiento>
            <obligadoContabilidad>NO</obligadoContabilidad>      
            <tipoIdentificacionSujetoRetenido>'.$id_tipo_documento.'</tipoIdentificacionSujetoRetenido>
            <razonSocialSujetoRetenido>'.$razonSocialDestinatario.'</razonSocialSujetoRetenido>
            <identificacionSujetoRetenido>' . $identificacionDestinatario . '</identificacionSujetoRetenido>            
            <periodoFiscal>' . $periodoFiscal . '</periodoFiscal>            
        </infoCompRetencion>
        <impuestos>';
        $xml .= $xml_impuestos;
        $xml .= '</impuestos>
        <infoAdicional>
            <campoAdicional nombre="Direccion">PRUEBAS </campoAdicional>
            <campoAdicional nombre="Telefono">pruebas@hotmail.com</campoAdicional>		
            <campoAdicional nombre="Email">022070995</campoAdicional>
        </infoAdicional>
    </comprobanteRetencion>';
    
    
$file = fopen("../comprobantes/Retencion_" . $id_retencion . ".xml", "w+");
fwrite($file, $xml);

/*$ruta_factura = 'http://localhost/punto_venta/vistas/xml/comprobantes/Retencion_' . $id_retencion . ".xml";
$ruta = 'http://localhost/punto_venta/vistas/xml/firmas/'.$ruta_firma;*/
$ruta_factura = 'http://'.$_SERVER['HTTP_HOST'].'/punto_venta/vistas/xml/comprobantes/Retencion_' . $id_retencion . ".xml";
$ruta = 'http://'.$_SERVER['HTTP_HOST'].'/punto_venta/vistas/xml/firmas/'.$ruta_firma;
$ruta_certificado =  $ruta;
$pass = $pass_firma;
$ruta_respuesta='';

echo ' <script>obtenerComprobanteFirmado_sri("' . $ruta_certificado . '","' . $pass . '","' .$ruta_respuesta. '","' .$ruta_factura.'","' .$id_retencion.'","RETENCION")</script>';
?>
    <script>
            /*$(window).on('load', function () {
                setTimeout(function () {
                    $(".loader-page").css({visibility:"hidden",opacity:"0"})
                }, 20000);
                
            });*/
        </script>
<?php
