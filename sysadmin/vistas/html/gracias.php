<?php
session_start();
if (!isset($_SESSION['user_login_status']) and $_SESSION['user_login_status'] != 1) {
    header("location: ../../login.php");
    exit;
}
//$id_producto=$_GET['id'];
/* Connect To Database*/
require_once "../db.php"; //Contiene las variables de configuracion para conectar a la base de datos
require_once "../php_conexion.php"; //Contiene funcion que conecta a la base de datos
require_once "../funciones.php";


//Inicia Control de Permisos
include "../permisos.php";
$user_id = $_SESSION['id_users'];
get_cadena($user_id);
$modulo = "Productos";
permisos($modulo, $cadena_permisos);

  $sql   = "SELECT * FROM gracias " ;
   //echo $sql;
    $query = mysqli_query($conexion, $sql);
   
    $row_cnt = mysqli_num_rows($query);

    if ($row_cnt > 0) {
    
    
    while ($row = mysqli_fetch_array($query)) {
        $contenido       = $row['contenido'];
    }
    }else{
        $contenido="";
    }
//Finaliza Control de Permisos
?>

<?php require 'includes/header_start.php';?>

<?php require 'includes/header_end.php';?>

 <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0" />
 <link href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
<!-- Begin page -->
<div id="wrapper" class="forced enlarged">

	<?php require 'includes/menu_landing.php';?>

	<!-- ============================================================== -->
	<!-- Start right Content here -->
	<!-- ============================================================== -->
	<div class="content-page">
		<!-- Start content -->
		<div class="content">
			<div class="container">
<?php if ($permisos_ver == 1) {
    ?>
				<div class="col-lg-12">
					<div class="portlet">
                                            <h2>Agradece a tu cliente</h2>
    <p>Ingresar el conetido de la pagina de gracias
    <br>
    <div class="portlet-heading bg-primary">
                                                    
							<h3 class="portlet-title">
								Pagina de Gracias
							</h3>
							<div class="portlet-widgets">
								<a href="javascript:;" data-toggle="reload"><i class="ion-refresh"></i></a>
								<span class="divider"></span>
								<a data-toggle="collapse" data-parent="#accordion1" href="#bg-primary"><i class="ion-minus-round"></i></a>
								<span class="divider"></span>
								<a href="#" data-toggle="remove"><i class="ion-close-round"></i></a>
							</div>
							<div class="clearfix"></div>
						</div>
						<div id="bg-primary" class="panel-collapse collapse show">
							<div class="portlet-body">
                                                            <form id="miFormulario" action="../ajax/guardar_gracias.php" method="post">
                                                                <input type="hidden" value="<?php echo $id_producto; ?>"  name="id_producto">             
                                                                
                                                                <textarea id="summernote" name="contenido">
                                                                 <?php echo $contenido; ?>   

                                                                </textarea>
                                                                <input type="submit" class="btn btn-success" value="GUARDAR">
                                                              
                                                                <a style="float: right; color: white" href="productos.php" class="btn btn-danger">
                                                                   CONFIGRUACION DE TIENDA
                                                                    </a>
</form>
								</div>
							</div>
						</div>
					</div>
                            
                        



					<?php
} else {
    ?>
		<section class="content">
			<div class="alert alert-danger" align="center">
				<h3>Acceso denegado! </h3>
				<p>No cuentas con los permisos necesario para acceder a este m¨®dulo.</p>
			</div>
		</section>
		<?php
}
?>

				</div>
				<!-- end container -->
			</div>
			<!-- end content -->

			<?php require 'includes/pie.php';?>

		</div>
		<!-- ============================================================== -->
		<!-- End Right content here -->
		<!-- ============================================================== -->


	</div>

  <script>
    $(document).ready(function() {
        $('#summernote').summernote();
    });
    
   
  </script>
        
        


	<!-- END wrapper -->

	
	<!-- ============================================================== -->
	<!-- Todo el codigo js aqui -->
	<!-- ============================================================== -->

	<!-- Codigos Para el Auto complete de Clientes -->

<!-- FIN -->

	<?php require 'includes/footer_end.php'
?>

