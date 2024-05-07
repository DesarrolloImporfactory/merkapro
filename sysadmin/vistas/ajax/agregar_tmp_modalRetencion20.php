<?php
/*-------------------------
Autor: Delmar Lopez
Web: www.softwys.com
Mail: softwysop@gmail.com
---------------------------*/
include 'is_logged.php'; //Archivo verifica que el usario que intenta acceder a la URL esta logueado
$session_id = session_id();
/* Connect To Database*/
require_once "../db.php";
require_once "../php_conexion.php";
//Archivo de funciones PHP
require_once "../funciones.php";
if (isset($_POST['id2'])) {$id2 = $_POST['id2'];}
if (isset($_POST['tipoImpuesto'])) {$tipoImpuesto = $_POST['tipoImpuesto'];}
if (isset($_POST['codRetencion'])) {$codRetencion = $_POST['codRetencion'];}
if (isset($_POST['porcentaje'])) {$porcentaje = $_POST['porcentaje'];}
if (isset($_POST['baseImponible'])) {$baseImponible = $_POST['baseImponible'];}
if (isset($_POST['total'])) {$total = $_POST['total'];}
if (isset($_POST['documento'])) {$documento = $_POST['documento'];}
if (isset($_POST['tipoDoc'])) {$tipoDoc = $_POST['tipoDoc'];}
if (isset($_POST['fecha'])) {$fecha = $_POST['fecha'];}
//echo $descripcion_libre;
if (!empty($id2) and !empty($tipoImpuesto) and !empty($codRetencion) and !empty($porcentaje) and !empty($baseImponible) and !empty($total)
and !empty($documento) and !empty($tipoDoc) and !empty($fecha) ) {
    /*// consulta para comparar el stock con la cantidad resibida
    $query = mysqli_query($conexion, "select stock_producto, inv_producto from productos where id_producto = '$id'");
    $rw    = mysqli_fetch_array($query);
    $stock = $rw['stock_producto'];
    $inv   = $rw['inv_producto'];*/
    
    //Comprobamos si agregamos un producto a la tabla tmp_debito20
    $comprobar = mysqli_query($conexion, "select * from tmp_retencion20, retencion20 where retencion20.id_factura = tmp_retencion20.id_retencion and tmp_retencion20.id_retencion='" . $id2 . "' and tmp_retencion20.session_id='" . $session_id . "'");
    if ($row = mysqli_fetch_array($comprobar)) {
        // condicion si el stock e menor que la cantidad requerida
        /*if ($cant > $row['stock_producto'] and $inv == 0) {
            echo "<script>swal('LA CATIDAD SUPERA AL STOCK', 'INTENTAR NUEVAMENTE', 'error')
            $('#resultados').load('../ajax/agregarnotacredito_tmp.php');
            </script>";
            exit;
        } else {*/
            $sql          = "UPDATE tmp_retencion20 SET tipoImpuesto='" . $tipoImpuesto . "', codRetencion='" . $codRetencion . "',
            porcentaje='" . $porcentaje . "',baseImponible='" . $baseImponible . "', total='" . $total . "',
            documento='" . $documento . "', tipoDoc='" . $tipoDoc . "', fecha='" . $fecha . "'  WHERE id_debito='" . $id . "' and session_id='" . $session_id . "'";
            $query_update = mysqli_query($conexion, $sql);
            echo "<script> $.Notification.notify('success','bottom center','NOTIFICACIÓN', 'DETALLE AGREGADO A LA RETENCION CORRECTAMENTE')</script>";
        //}
        // fin codicion cantaidad

    } else {
        $id = 0;
        $cantidad = 1;
        $precio_venta = 0;
        $descripcion_libre = 0;
        // condicion si el stock e menor que la cantidad requerida
        /*if ($cantidad > $stock and $inv == 0) {
            echo "<script>swal('LA CATIDAD SUPERA AL STOCK', 'INTENTAR NUEVAMENTE', 'error')
             $('#resultados').load('../ajax/agregarnotacredito_tmp.php');
            </script>";
            exit;
        } else {*/
            
            $insert_tmp = mysqli_query($conexion, "INSERT INTO tmp_retencion20 (id_producto,id_retencion,cantidad_tmp,precio_tmp,descripcion_tmp,desc_tmp,session_id,tipoImpuesto,codRetencion,porcentaje,baseImponible,total,documento,tipoDoc,fecha) 
            VALUES (null,'$id2','$cantidad','$precio_venta','$descripcion_libre','0','$session_id','$tipoImpuesto','$codRetencion','$porcentaje','$baseImponible','$total','$documento'
            ,'$tipoDoc','$fecha')");
            echo "<script> $.Notification.notify('success','bottom center','NOTIFICACIÓN', 'DETALLE AGREGADO A LA RETENCION CORRECTAMENTE')</script>";
        //}
        // fin codicion cantaidad
    }

}else{
    echo "<script> $.Notification.notify('error','bottom center','NOTIFICACIÓN', 'Campos Vacios en los campos del Formulario')</script>";
}
if (isset($_GET['id'])) //codigo elimina un elemento del array
{
    
    $id_tmp = intval($_GET['id']);
    $delete = mysqli_query($conexion, "DELETE FROM tmp_retencion20 WHERE id_tmp='" . $id_tmp . "'");
}
$simbolo_moneda = get_row('perfil', 'moneda', 'id_perfil', 1);

?>
<div class="table-responsive">
    <table class="table table-sm">
        <thead class="thead-default">
            <tr>
                <th class='text-center'>Tipo</th>
				<th class='text-center'>Cod. Reten</th>
				<th class='text-center'>%</th>
				<th class='text-center'>Base Imp.</th>
				<th class='text-center'>Total</th>
				<th class='text-center'>Documento No.</th>
				<th class='text-center'>Tipo Doc</th>
				<th class='text-center'>Fecha Doc</th>
                <!--<th class='text-center'>Raz&oacute;n Modificaci&oacute;n</th>
                <th class='text-center'>Valor Modificaci&oacute;n</th>
                <th class='text-center'>DESCRIP.</th>
                <th class='text-center'>Valor Modificaci&oacute;n <?php echo $simbolo_moneda; ?></th>
                <th class='text-center'>DESC %</th>
                <th class='text-right'>TOTAL</th>-->
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php
$impuesto       = get_row('perfil', 'impuesto', 'id_perfil', 1);
$nom_impuesto   = get_row('perfil', 'nom_impuesto', 'id_perfil', 1);
$sumador_total  = 0;
$total_iva      = 0;
$total_impuesto = 0;
$subtotal       = 0;
$sql            = mysqli_query($conexion, "select * from tmp_retencion20 where tmp_retencion20.session_id='" . $session_id . "'");
while ($row = mysqli_fetch_array($sql)) {
    $id_tmp          = $row["id_tmp"];
    $id_producto     = $row['id_producto'];
    $id_retencion       = $row['id_retencion'];
    $cantidad        = $row['cantidad_tmp'];
    $desc_tmp        = $row['desc_tmp'];
    $nombre_producto = $row['descripcion_tmp'];
    $precio_venta   = $row['precio_tmp'];

    $tipoImpuesto   = $row['tipoImpuesto'];
    $codRetencion   = $row['codRetencion'];
    $porcentaje   = $row['porcentaje'];
    $baseImponible   = $row['baseImponible'];
    $total   = $row['total'];
    $documento   = $row['documento'];
    $tipoDoc   = $row['tipoDoc'];
    $fecha   = $row['fecha'];

    $precio_venta_unitario = $precio_venta;
    $precio_venta_f = number_format($precio_venta, 2); //Formateo variables
    $precio_venta_r = str_replace(",", "", $precio_venta_f); //Reemplazo las comas
    $precio_total   = $precio_venta_r * $cantidad;
    $final_items    = rebajas($precio_total, $desc_tmp); //Aplicando el descuento
    /*--------------------------------------------------------------------------------*/
     $impuesto=get_row('perfil','impuesto', 'id_perfil', 1);
        $valor= ($impuesto/100)+1;
	$precio_venta=$final_items;
	$precio_venta_f=$precio_venta;//Formateo variable
	$precio_venta_r1=str_replace(",","",$precio_venta_f);//Reemplazo las comas  
        //PRECIO DESGLOSADO
        $precio_venta_desglosado=$precio_venta_r1/$valor;
        $impuesto_unitario=$precio_venta_f-$precio_venta_desglosado;
    /*--------*/
    $precio_total_f = number_format($final_items, 2); //Precio total formateado
    $precio_total_r = str_replace(",", "", $precio_total_f); //Reemplazo las comas
    $sumador_total += $precio_venta_desglosado; //Sumador
    $final_items = rebajas($precio_total, $desc_tmp); //Aplicando el descuento
    $subtotal    = number_format($sumador_total, 2, '.', '');
  /*  if ($row['iva_producto'] == 1) {
        $total_iva = $impuesto_unitario;
    } else {
        $total_iva = iva($precio_venta_desglosado);
    }*/
    //$total_impuesto += rebajas($subtotal, $desc_tmp) * $cantidad;
    $total_impuesto=$total_impuesto+$impuesto_unitario;
    //echo $total_impuesto.'<br>';
    ?>
    <tr>
        <!--<td class='text-center'><?php /*echo $codigo_producto; ?></td>
        <td class='text-center'><?php echo $cantidad; ?></td>
        <td><?php echo $nombre_producto; */ ?></td>-->
         <td>
            <!--<select class="form-control employee_id" id="<?php echo $id_tmp; ?>" >-->
            <select class="form-control "  >
                <?php if($tipoImpuesto == '1'){ ?>
                    <option value = '1'> Renta</option>
                <?php  }elseif($tipoImpuesto == '2'){ ?>
                    <option value = '2'> IVA</option>
                <?php  }elseif($tipoImpuesto == '6'){ ?>
                    <option value = '6'> ISD</option>
                <?php  } ?>
            </select>
        </td>
        <td><?php echo $codRetencion; ?></td>
        <td><?php echo $porcentaje; ?></td>
        <td><?php echo $baseImponible; ?></td>
        <td><?php echo $total; ?></td>
        <td><?php echo $documento; ?></td>
        <td>
            <select class='form-control'>
                <option value = '01' <?php if($tipoDoc == '1'){ ?> selected <?php } ?>> Factura</option>
            </select>
        </td>
        <td><?php echo $fecha; ?></td>
        
        <!--<td align="right" width="15%">
                <input type="text" class="form-control txt_desc" style="text-align:center" value="<?php /*echo $desc_tmp; ?>" id="<?php echo $id_tmp; ?>">
        </td>
        <td class='text-right'><?php 
     
                echo $simbolo_moneda . ' ' . number_format($precio_venta_desglosado, 2); ?></td>
        
        <td class='text-right'><?php echo $simbolo_moneda . ' ' . number_format($final_items, 2); */?></td>-->
      
        <td class='text-center'>
            <a href="#" class='btn btn-danger btn-sm waves-effect waves-light' onclick="eliminar('<?php echo $id_tmp ?>')"><i class="fa fa-remove"></i>
            </a>
        </td>
    </tr>
    <?php
}
$total_factura = $subtotal + $total_impuesto;

?>
<!--<tr>
    <td class='text-right' colspan=2>SUBTOTAL</td>
    <td class='text-right'><b><?php /*echo $simbolo_moneda . ' ' . number_format($subtotal, 2); ?></b></td>
    <td></td>
</tr>
<tr>
    <td class='text-right' colspan=2><?php echo $nom_impuesto; ?> (<?php echo $impuesto; ?>)% </td>
    <td class='text-right'><?php echo $simbolo_moneda . ' ' . number_format($total_impuesto, 2); ?></td>
    <td></td>
</tr>
<tr>
    <td style="font-size: 14pt;" class='text-right' colspan=2><b>TOTAL <?php echo $simbolo_moneda; ?></b></td>
    <td style="font-size: 16pt;" class='text-right'><span class="label label-danger"><b><?php echo number_format($total_factura, 2); */?></b></span></td>
    <td></td>
</tr>-->
</tbody>
</table>
</div>
<script>
    $(document).ready(function () {
        $('.txt_desc').off('blur');
        $('.txt_desc').on('blur',function(event){
            var keycode = (event.keyCode ? event.keyCode : event.which);
        // if(keycode == '13'){
            id_tmp = $(this).attr("id");
            desc = $(this).val();
             //Inicia validacion
             if (isNaN(desc)) {
                $.Notification.notify('error','bottom center','ERROR', 'DIGITAR UN DESCUENTO VALIDO')
                $(this).focus();
                return false;
            }
        //Fin validacion
        $.ajax({
            type: "POST",
            url: "../ajax/editar_desc_venta.php",
            data: "id_tmp=" + id_tmp + "&desc=" + desc,
            success: function(datos) {
            $("#resultados").load("../ajax/agregarretencion20_tmp.php");
            $.Notification.notify('success','bottom center','EXITO!', 'DESCUENTO ACTUALIZADO CORRECTAMENTE')
        }
    });
        // }
    });
        $(".employee_id").on("change", function(event) {
            id_tmp = $(this).attr("id");
            precio = $(this).val();
            $.ajax({
                type: "POST",
                url: "../ajax/editar_precio_retencion.php",
                data: "id_tmp=" + id_tmp + "&precio=" + precio,
                success: function(datos) {
                $("#resultados").load("../ajax/agregarretencion20_tmp.php");
                $.Notification.notify('success','bottom center','EXITO!', 'PRECIO ACTUALIZADO CORRECTAMENTE')
                }
            });
        });

    });
</script>