<?php
require_once "sysadmin/vistas/db.php"; //Contiene las variables de configuracion para conectar a la base de datos
require_once "sysadmin/vistas/php_conexion.php"; //Contiene funcion que conecta a la base de datos
require_once "sysadmin/vistas/funciones.php";

if ($_SERVER['HTTP_HOST']=='localhost'){
    $destino = new mysqli('localhost', 'root', '', 'master');
}else{
 $destino = new mysqli('localhost', 'imporsuit_marketplace', 'imporsuit_marketplace', 'imporsuit_marketplace');   
}

$id_producto=$_GET['id'];
  $sql   = "SELECT * FROM landing WHERE id_producto =" . $id_producto ;
   //echo $sql;
    $query = mysqli_query($destino, $sql);
   
    $row_cnt = mysqli_num_rows($query);

    if ($row_cnt > 0) {
    
    
    while ($row = mysqli_fetch_array($query)) {
        $contenido       = $row['contenido'];
    }
    }else{
        $contenido="";
    }
    //echo 'asdd'.$contenido;
?>
 <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0" />
 <link href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
<!-- Begin page -->
<div id="wrapper" class="forced enlarged">



	<!-- ============================================================== -->
	<!-- Start right Content here -->
	<!-- ============================================================== -->
	<div class="content-page">
		<!-- Start content -->
		<div class="content">
			<div class="container">

				<div class="col-lg-12">
					<div class="portlet">
                                            <h2>Ingresa la descripción de tu producto</h2>
    <p>Aquí puedes proporcionar una descripción detallada de tu producto. Puedes destacar sus características, beneficios y cualquier otra información relevante que desees comunicar a tus visitantes.</p>

    <br>
    <div class="portlet-heading bg-primary">
                                                    
						
							<div class="clearfix"></div>
						</div>
						<div id="bg-primary" class="panel-collapse collapse show">
							<div class="portlet-body">
                                                            <form id="miFormulario" action="ajax/ajax_procesar.php" method="post">
                                                                <input type="hidden" value="<?php echo $id_producto; ?>"  name="id_producto">             
                                                                
                                                                <textarea id="summernote" name="contenido">
                                                                 
<?php echo $contenido; ?>   
                                                                </textarea>
                                                              
                                                              
                                                                <a style="float: right; color: white" href="sysadmin/vistas/html/marketplace.php" class="btn btn-danger">
                                                                   VOLVER A MARKETPLACE
                                                                    </a>
</form>
								</div>
							</div>
						</div>
					</div>
                            
                        


  <script>
 
    
  $(document).ready(function() {
    $('#summernote').summernote({
        height: 300,
        callbacks: {
            onImageUpload: function(files) {
                // Función para cargar imágenes
                uploadImage(files[0]);
            }
        }
    });
});

function uploadImage(file) {
    var formData = new FormData();
    formData.append('file', file);

    $.ajax({
        url: 'upload.php', // Reemplaza 'upload.php' con la URL de tu script PHP de carga de imágenes
        method: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            // Inserta la URL de la imagen en el editor de Summernote
            $('#summernote').summernote('insertImage', response);
        }
    });
}

  </script>
  
  
        
        


	<!-- END wrapper -->

	
	<!-- ============================================================== -->
	<!-- Todo el codigo js aqui -->
	<!-- ============================================================== -->

	<!-- Codigos Para el Auto complete de Clientes -->

<!-- FIN -->

	<?php require 'includes/footer_end.php'
?>

