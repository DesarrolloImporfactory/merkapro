<?php
/* Connect To Database*/
require_once "../db.php"; //Contiene las variables de configuracion para conectar a la base de datos
require_once "../php_conexion.php"; //Contiene funcion que conecta a la base de datos
session_start();
//Inicia Control de Permisos
include "../permisos.php";
$user_id = $_SESSION['id_users'];
//echo $_SESSION['id_users'];
get_cadena($user_id);
$modulo = "Configuracion";
permisos($modulo, $cadena_permisos);
$query_empresa = mysqli_query($conexion, "select * from origen_laar where id_origen=1");
$row           = mysqli_fetch_array($query_empresa);

?>
<?php require 'includes/header_start.php';?>

<?php require 'includes/header_end.php';?>

<!-- Begin page -->
<div id="wrapper">

	<?php require 'includes/menu.php';?>

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
						<div class="portlet-heading bg-primary">
							<h3 class="portlet-title">
								Origen de la guía Laar Courrier
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

							<form class="form-horizontal" role="form" id="perfil">
								<div class="row">
									<div class="col-md-3">
										<div id='load_img' align="center">
                                                                                    <strong>LOGO DE LA EMPRESA</strong>
                                                                                    <img src="../../img_sistema/images.jpg" alt=""/>
											
										</div>
										
                                                                            
                                                                            

									</div>
                                                                    
									<!-- end col -->

									<div class="col-md-9">
										<div class="card-box">
                                                                                    <div class="">
                                                                            
  
                                                                        </div><br>
												<div class="form-group row">
													<label for="inputPassword3" class="col-sm-3  col-form-label">Provincia:</label>
													<div class="col-sm-9">
														<select onchange="cargar_provincia()" class="datos form-control" id="provinica" name="provinica"  required>
    <option value="">Provincia *</option>
    <?php
    $sql2 = "select * from provincia_laar ";
    $query2 = mysqli_query($conexion, $sql2);

    while ($row2 = mysqli_fetch_array($query2)) {
        $id_prov = $row2['id_prov'];
        $provincia = $row2['provincia'];
        $cod_provincia = $row2['codigo_provincia'];

        // Obtener el valor almacenado en la tabla orgien_laar
        $valor_seleccionado = $row['provinciaO'];

        // Verificar si el valor actual coincide con el almacenado en la tabla
        $selected = ($valor_seleccionado == $cod_provincia) ? 'selected' : '';

        // Imprimir la opción con la marca de "selected" si es el valor almacenado
        echo '<option value="' . $cod_provincia . '" ' . $selected . '>' . $provincia . '</option>';
    }
    ?>
</select>
													</div>
												</div>
												<div  class="form-group row">
													<label for="giro" class="col-sm-3  col-form-label">Ciudad:</label>
													<div id="div_ciudad" class="col-sm-9">
														<select  onchange="cargar_provincia(this.value)" class="datos form-control" id="ciudad" name="ciudad"  required>
                  <option value="">Ciudad *</option>
                  <?php
                           $sql2="select * from ciudad_laar ";
                           //echo $sql2;
                           $query2 = mysqli_query($conexion, $sql2);
                        
                            $rowcount=mysqli_num_rows($query2);
                            //echo $rowcount;
                            $i=1;
                           while ($row2 = mysqli_fetch_array($query2)) {
                               $id_ciudad       = $row2['id_ciudad']; 
                                 $nombre      = $row2['nombre']; 
                                 $cod_ciudad      = $row2['codigo'];
                                 $valor_seleccionado = $row['ciudadO'];
                                   $selected = ($valor_seleccionado == $cod_ciudad) ? 'selected' : '';

        // Imprimir la opción con la marca de "selected" si es el valor almacenado
        echo '<option value="' . $cod_ciudad . '" ' . $selected . '>' . $nombre . '</option>';
                           
?>
        
         <?php }?>
         </select>
													</div>
												</div>
												<div class="form-group row">
													<label for="fiscal" class="col-sm-3 col-form-label">Identificación:</label>
													<div class="col-sm-6">
														<input type="text" class="form-control" required name="identificacion" value="<?php echo $row['identificacion'] ?>" autocomplete="off" >
													</div>
												</div>
                                                                        
                                                                        <div class="form-group row">
													<label for="inputPassword3" class="col-sm-3 col-form-label">Nombre:</label>
													<div class="col-sm-6">
														<input type="text" class="form-control" name="nombre" value="<?php echo $row['nombreO'] ?>" required autocomplete="off">
													</div>
												</div>
                                                                        
                                                                        
												<div class="form-group row">
													<label for="inputPassword3" class="col-sm-3 col-form-label">Teléfono:</label>
													<div class="col-sm-6">
														<input type="text" class="form-control" name="telefono" value="<?php echo $row['telefono'] ?>" required autocomplete="off">
													</div>
												</div>
                                                                        <div class="form-group row">
													<label for="inputPassword3" class="col-sm-3 col-form-label">Celular:</label>
													<div class="col-sm-6">
														<input type="text" class="form-control" name="celular" value="<?php echo $row['celular'] ?>" required autocomplete="off">
													</div>
												</div>
												 <div class="form-group row">
													<label for="inputPassword3" class="col-sm-3 col-form-label">Referencia:</label>
													<div class="col-sm-6">
														<input type="text" class="form-control" name="referencia" value="<?php echo $row['referencia'] ?>" required autocomplete="off">
													</div>
												</div>
                                                                        
                                                                        <div class="form-group row">
													<label for="inputPassword3" class="col-sm-3 col-form-label">Numero de casa:</label>
													<div class="col-sm-6">
														<input type="text" class="form-control" name="numerocasa" value="<?php echo $row['numeroCasa'] ?>" required autocomplete="off">
													</div>
												</div>
												
												
												
												<div class="form-group row">
													<label for="inputPassword3" class="col-sm-3 col-form-label">Dirección:</label>
													<div class="col-sm-9">
														<input type="text" class="form-control UpperCase" name="direccion" value="<?php echo $row["direccion"]; ?>" required autocomplete="off" >
													</div>
												</div>
                                                                                    
                                                                                               
                                                                       
                                                                                    
                                                                                   
												
												
												<div class="form-group row">
													<label for="inputPassword3" class="col-sm-3 col-form-label">Código postal:</label>
													<div class="col-sm-4">
														<input type="text" class="form-control UpperCase" name="codigo_postal" value="<?php echo $row["postal"]; ?>" autocomplete="off">
													</div>
												</div>
                                                                                    
                                                                                    
                                                                                    
                                                                                    

												<div class='col-md-12' id="resultados_ajax"></div><!-- Carga los datos ajax -->


												<div class="form-group m-b-0 row">
													<div class="offset-3 col-sm-9">
														<button type="submit" class="btn btn-info waves-effect waves-light"><i class="fa fa-refresh"></i> Actualizar Datos</button>
													
														<a  type="button" href="../../../index.php" target="_blank" class="btn btn-danger">Vista Preliminar</a>
													</div>
												</div>
                                                                                                
                                                                                                
											</form>

									</div>

								</div>
								<!-- end row -->


							</div>
                                                        </form>
							<!-- /.box -->


						</div>
						<?php
} else {
    ?>
		<section class="content">
			<div class="alert alert-danger" align="center">
				<h3>Acceso denegado! </h3>
				<p>No cuentas con los permisos necesario para acceder a este módulo.</p>
			</div>
		</section>
		<?php
}
?>


					</div>
				</div>
			</div>
		</div>


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
<!-- END wrapper -->

<?php require 'includes/footer_start.php'
?>
<!-- ============================================================== -->
	<!-- Todo el codigo js aqui-->
	<!-- ============================================================== -->
<script>
  $( "#perfil" ).submit(function( event ) {
    $('.guardar_datos').attr("disabled", true);

    var parametros = $(this).serialize();
    $.ajax({
      type: "POST",
      url: "../ajax/editar_origen.php",
      data: parametros,
      beforeSend: function(objeto){
        $("#resultados_ajax").html('<img src="../../img/ajax-loader.gif"> Cargando...');
      },
      success: function(datos){
        $("#resultados_ajax").html(datos);
        $('.guardar_datos').attr("disabled", false);
        //desaparecer la alerta
        $(".alert-success").delay(400).show(10, function() {
                $(this).delay(2000).hide(10, function() {
                  $(this).remove();
                });
              }); // /.alert

      }
    });
    event.preventDefault();
  })


   $(document).on('change','input[type="checkbox"]' ,function(e) {
    if(this.id=="flotar") {
        if(this.checked){
             id=1;
        }
           
        else {
           id=0; 
        }
           $.ajax({
        type: "GET",
        url: "../ajax/habilitaproveedor.php",
        data: "id=" + id,
        beforeSend: function(objeto) {
            $("#resultados").html('<img src="../../img/ajax-loader.gif"> Cargando...');
        },
        success: function(datos) {
            $("#resultados").html(datos);
        }
    });
    
    }
  
});
</script>

<script>
  function upload_image(){

    var inputFileImage = document.getElementById("imagefile");
    var file = inputFileImage.files[0];
    if( (typeof file === "object") && (file !== null) )
    {
      $("#load_img").html('<img src="../../img/ajax-loader.gif"> Cargando...');
      var data = new FormData();
      data.append('imagefile',file);


      $.ajax({
            url: "../ajax/imagen_ajax.php",        // Url to which the request is send
            type: "POST",             // Type of request to be send, called as method
            data: data,         // Data sent to server, a set of key/value pairs (i.e. form fields and values)
            contentType: false,       // The content type used when sending data to the server.
            cache: false,             // To unable request pages to be cached
            processData:false,        // To send DOMDocument or non processed data file it is set to false
            success: function(data)   // A function to be called if request succeeds
            {
              $("#load_img").html(data);

            }
          });
    }


  }
  
  function upload_image_banner(){

    var inputFileImage = document.getElementById("imagefile2");
    var file = inputFileImage.files[0];
    if( (typeof file === "object") && (file !== null) )
    {
      $("#load_img2").html('<img src="../../img/ajax-loader.gif"> Cargando...');
      var data = new FormData();
      data.append('imagefile2',file);


      $.ajax({
            url: "../ajax/imagen_ajax_banner.php",        // Url to which the request is send
            type: "POST",             // Type of request to be send, called as method
            data: data,         // Data sent to server, a set of key/value pairs (i.e. form fields and values)
            contentType: false,       // The content type used when sending data to the server.
            cache: false,             // To unable request pages to be cached
            processData:false,        // To send DOMDocument or non processed data file it is set to false
            success: function(data)   // A function to be called if request succeeds
            {
              $("#load_img2").html(data);

            }
          });
    }


  }
</script>
<script>
       $(document).ready( function () {
        $(".UpperCase").on("keypress", function () {
         $input=$(this);
         setTimeout(function () {
          $input.val($input.val().toUpperCase());
         },50);
        })
       })
       
       function cargar_provincia(){
			
			var formulario = document.getElementById('perfil');
                      //  alert($('#provinica').val())
  var data = new FormData(formulario);




			$.ajax({
					url: "../ajax/cargar_ciudad.php",        // Url to which the request is send
					type: "POST",             // Type of request to be send, called as method
					data: data, 			  // Data sent to server, a set of key/value pairs (i.e. form fields and values)
					contentType: false,       // The content type used when sending data to the server.
					cache: false,             // To unable request pages to be cached
					processData:false,        // To send DOMDocument or non processed data file it is set to false
					success: function(data)   // A function to be called if request succeeds
					{
						//alert(data);
                                                $('#div_ciudad').html(data);

					}
				});

		}
      </script>

	<?php require 'includes/footer_end.php'
?>

