<?php
include 'is_logged.php'; //Archivo verifica que el usario que intenta acceder a la URL esta logueado
/* Connect To Database*/
require_once "../db.php";
require_once "../php_conexion.php";
if (isset($_REQUEST['id_comp'])) {
    $id_comp = intval($_REQUEST['id_comp']);
    $sql         = mysqli_query($conexion, "select * from perfil");
    $rw          = mysqli_fetch_array($sql);
    $secuencialliquidacion  = $rw['secuencialliquidacion'];
    $cantidad = strlen($secuencialliquidacion);
    $maxima = 9;
    $ceros_izquierda = $maxima - $cantidad; 
    $ceros =  '';
    for ($i=0; $i < $ceros_izquierda; $i++) { 
        $ceros = $ceros . '0';
    }
    $secuencial = $ceros . $secuencialliquidacion;
    
    //$query = mysqli_query($conexion, "SELECT RIGHT(numero_factura,6) as factura FROM facturas_ventas WHERE id_comp_factura='$id_comp' ORDER BY factura DESC LIMIT 1") or die('error ' . mysqli_error($conexion));
    //$count = mysqli_num_rows($query);
    /*if ($count != 0) {
        $row     = mysqli_fetch_assoc($query);
        $factura = $row['factura'] + 1;
    } else {
        $factura = $actual_comp;
    }
    $formato = str_pad($factura, $long_comp, "0", STR_PAD_LEFT);
    $factura = $serie_comp . '' . $formato;*/

    echo '<input type="text" class="form-control" autocomplete="off" id="factura" value="' . $secuencial . '" placeholder="Factura" readonly name="factura" >';
}
