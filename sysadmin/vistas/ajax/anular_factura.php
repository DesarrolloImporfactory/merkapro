<?php
/*-----------------------
Autor: Delmar Lopez
http://www.softwys.com
----------------------------*/
include 'is_logged.php'; //Archivo verifica que el usario que intenta acceder a la URL esta logueado
/* Connect To Database*/
require_once "../db.php";
require_once "../php_conexion.php";
require_once "../funciones.php";
//Inicia Control de Permisos
include "../permisos.php";
$user_id = $_SESSION['id_users'];
get_cadena($user_id);
$modulo = "Ventas";
permisos($modulo, $cadena_permisos);
/*Inicia validacion del lado del servidor*/
if (empty($_POST['id_factura'])) {
    $errors[] = "ID vacío";
} else if (
    !empty($_POST['id_factura'])

) {
    $id_factura = intval($_POST['id_factura']);
    $numero_factura=  get_row('facturas_ventas', 'numero_factura', 'id_factura', $id_factura);
 //echo $numero_factura;
    //echo "select * from detalle_fact_ventas where numero_factura='".$numero_factura."'";
          $sql=mysqli_query($conexion, "select * from detalle_fact_ventas where numero_factura='".$numero_factura."'");
while ($row=mysqli_fetch_array($sql))
	{
	
	$cantidad=$row['cantidad'];
        $producto=$row['id_producto'];
	
        $stock=get_row('productos','stock_producto', 'id_producto', $producto);
        //echo $stock;
        
        //$vendidos=get_row('products','vendidos', 'id_producto', $producto);
        //echo $vendidos;
        
        $stock_total=$stock+$cantidad;
        //$vendidos_total=$vendidos-$cantidad;
        
        
	          
            $udate="UPDATE productos SET stock_producto=$stock_total where id_producto='".$producto."'";
            
		echo $udate;
		mysqli_query($conexion,$udate);
            
                
                
	//die();
	//$nums++;
	}
            
              
		$del1="UPDATE facturas_ventas SET estado_factura=0, monto_factura=0 where numero_factura='".$numero_factura."'";
		//echo $del1;
		if ($delete1=mysqli_query($conexion,$del1) ){
			?>
			<div class="alert alert-success alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Aviso!</strong> Factura anulada exitosamente
			</div>
			<?php 
		}else {
			?>
			<div class="alert alert-danger alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Error!</strong> No se puedo anular la factura
			</div>
			<?php
			
		}  
    

} else {
    $errors[] = "Error desconocido.";
}

if (isset($errors)) {

    ?>
    <div class="alert alert-danger" role="alert">
        <strong>Error!</strong>
        <?php
foreach ($errors as $error) {
        echo $error;
    }
    ?>
    </div>
    <?php
}

?>