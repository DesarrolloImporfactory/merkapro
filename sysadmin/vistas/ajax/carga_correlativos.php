<?php
include 'is_logged.php'; //Archivo verifica que el usario que intenta acceder a la URL esta logueado
/* Connect To Database*/
require_once "../db.php";
require_once "../php_conexion.php";
if (isset($_REQUEST['id_comp'])) {
    $id_comp = intval($_REQUEST['id_comp']);

    //INICIO SECUENCIAL
        $sql         = mysqli_query($conexion, "select * from perfil");
        $rw          = mysqli_fetch_array($sql);
        $secuencialfactura  = $rw['secuencialfactura'];
        $cantidad = strlen($secuencialfactura);
        $maxima = 9;
        $ceros_izquierda = $maxima - $cantidad; 
        $ceros =  '';
        for ($i=0; $i < $ceros_izquierda; $i++) { 
            $ceros = $ceros . '0';
        }
        $secuencial = $ceros . $secuencialfactura;
        
    //FIN SECUENCIAL
    $sql         = mysqli_query($conexion, "select * from comprobantes where  id_comp ='$id_comp'");
    $rw          = mysqli_fetch_array($sql);
    $serie_comp  = $rw['serie_comp'];
    $desde_comp  = $rw['desde_comp'];
    $hasta_comp  = $rw['hasta_comp'];
    $actual_comp = $rw['actual_comp'];
    $long_comp   = $rw['long_comp'];

    $query = mysqli_query($conexion, "SELECT RIGHT(numero_factura,6) as factura FROM facturas_ventas WHERE id_comp_factura='$id_comp' ORDER BY factura DESC LIMIT 1") or die('error ' . mysqli_error($conexion));
    $count = mysqli_num_rows($query);
    if ($count != 0) {
        $row     = mysqli_fetch_assoc($query);
        $factura = $row['factura'] + 1;
    } else {
        $factura = $actual_comp;
    }
    
    $perfil        = mysqli_query($conexion, "select * from perfil");
    $rwperfil         = mysqli_fetch_array($perfil);
    $secuencial_factura = '';
     if(isset($rwperfil["secuencialfactura"]) != null){
        $secuencial_factura = $rwperfil['secuencialfactura'] + 1;
    }
    $numeroConCeros = str_pad($secuencial_factura, 9, "0", STR_PAD_LEFT);
    $formato = str_pad($factura, $long_comp, "0", STR_PAD_LEFT);
    $factura = $rwperfil["codigo_establecimiento"].'-'.$rwperfil["codigo_punto_emision"].'-'.$numeroConCeros;

    echo '<h4>FACTURA #:' . $factura . '<h4><input type="hidden" id="secuencialfactura" value="' . $secuencial . '"  name="secuencialfactura"><input type="hidden" id="factura" value="' . $factura . '"  name="factura">';
}
