<?php
session_start();
if (!isset($_SESSION['user_login_status']) and $_SESSION['user_login_status'] != 1) {
    header("location: ../../login.php");
    exit;
}
$id_producto=$_GET['id'];
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
//Finaliza Control de Permisos

  $sql   = "SELECT * FROM landing WHERE id_producto =" . $id_producto ;
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
?>

<?php require 'includes/header_start.php';?>

<?php require 'includes/header_end.php';?>

 <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="../hipertexto/css/froala_editor.css">
  <link rel="stylesheet" href="../hipertexto/css/froala_style.css">
  <link rel="stylesheet" href="../hipertexto/css/plugins/code_view.css">
  <link rel="stylesheet" href="../hipertexto/css/plugins/colors.css">
  <link rel="stylesheet" href="../hipertexto/css/plugins/emoticons.css">
  <link rel="stylesheet" href="../hipertexto/css/plugins/image_manager.css">
  <link rel="stylesheet" href="../hipertexto/css/plugins/image.css">
  <link rel="stylesheet" href="../hipertexto/css/plugins/line_breaker.css">
  <link rel="stylesheet" href="../hipertexto/css/plugins/table.css">
  <link rel="stylesheet" href="../hipertexto/css/plugins/char_counter.css">
  <link rel="stylesheet" href="../hipertexto/css/plugins/video.css">
  <link rel="stylesheet" href="../hipertexto/css/plugins/fullscreen.css">
  <link rel="stylesheet" href="../hipertexto/css/plugins/file.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/6.65.7/codemirror.min.css">
    <style>
    portlet {
      text-align: center;
    }

    div#editor {
      width: 81%;
      margin: auto;
      text-align: left;
    }
  </style>
<!-- Begin page -->
<div id="wrapper" class="forced enlarged">

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
								Landin de Productos ->  <?php echo get_row('productos', 'nombre_producto', 'id_producto', $id_producto); ?>
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
                                                            <form action="../ajax/guardar_landing.php" method="post">
  <div id="editor">
      <input type='hidden' name="id_producto" id="id_producto" value="<?php echo $id_producto; ?>">
      <textarea id='edit' name='edit' style="margin-top: 30px;">

      <?php echo $contenido; ?>
  </textarea>
    <button type="submit">Guarar</button>

								</div>
                                                    </form>
							</div>
						</div>
					</div>
                            
                        
<script>
    

		$(document).ready(function(){
                    alert()
			$('#txt-content').Editor();

			$('#txt-content').Editor('setText', ['<p style="color:red;">Hola</p>']);

			$('#btn-enviar').click(function(e){
				e.preventDefault();
				$('#txt-content').text($('#txt-content').Editor('getText'));
				$('#frm-test').submit();				
			});
		});	
	
        
  $(function() {
    $('#myEditor').froalaEditor({toolbarInline: true})
  });
</script>

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
				<!-- end container -->
			</div>
			<!-- end content -->

			<?php require 'includes/pie.php';?>

		</div>
		<!-- ============================================================== -->
		<!-- End Right content here -->
		<!-- ============================================================== -->


	</div>

<script type="text/javascript">
    function guardar(texto){
        var contenidoHtml = document.getElementById('edit').innerHTML;

        alert(contenidoHtml);
    }
    </script>
        
        
<script type="text/javascript"
    src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/6.65.7/codemirror.min.js"></script>
  <script type="text/javascript"
    src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/6.65.7/mode/xml/xml.min.js"></script>

  <script type="text/javascript" src="../hipertexto/js/froala_editor.min.js"></script>

  <script type="text/javascript" src="../hipertexto/js/plugins/align.min.js"></script>
  <script type="text/javascript" src="../hipertexto/js/plugins/code_beautifier.min.js"></script>
  <script type="text/javascript" src="../hipertexto/js/plugins/code_view.min.js"></script>
  <script type="text/javascript" src="../hipertexto/js/plugins/colors.min.js"></script>
  <script type="text/javascript" src="../hipertexto/js/plugins/draggable.min.js"></script>
  <script type="text/javascript" src="../hipertexto/js/plugins/emoticons.min.js"></script>
  <script type="text/javascript" src="../hipertexto/js/plugins/font_size.min.js"></script>
  <script type="text/javascript" src="../hipertexto/js/plugins/font_family.min.js"></script>
  <script type="text/javascript" src="../hipertexto/js/plugins/image.min.js"></script>
  <script type="text/javascript" src="../hipertexto/js/plugins/file.min.js"></script>
  <script type="text/javascript" src="../hipertexto/js/plugins/image_manager.min.js"></script>
  <script type="text/javascript" src="../hipertexto/js/plugins/line_breaker.min.js"></script>
  <script type="text/javascript" src="../hipertexto/js/plugins/link.min.js"></script>
  <script type="text/javascript" src="../hipertexto/js/plugins/lists.min.js"></script>
  <script type="text/javascript" src="../hipertexto/js/plugins/paragraph_format.min.js"></script>
  <script type="text/javascript" src="../hipertexto/js/plugins/paragraph_style.min.js"></script>
  <script type="text/javascript" src="../hipertexto/js/plugins/video.min.js"></script>
  <script type="text/javascript" src="../hipertexto/js/plugins/table.min.js"></script>
  <script type="text/javascript" src="../hipertexto/js/plugins/url.min.js"></script>
  <script type="text/javascript" src="../hipertexto/js/plugins/entities.min.js"></script>
  <script type="text/javascript" src="../hipertexto/js/plugins/char_counter.min.js"></script>
  <script type="text/javascript" src="../hipertexto/js/plugins/inline_style.min.js"></script>
  <script type="text/javascript" src="../hipertexto/js/plugins/save.min.js"></script>
  <script type="text/javascript" src="../hipertexto/js/plugins/fullscreen.min.js"></script>
  <script type="text/javascript" src="../hipertexto/js/plugins/quote.min.js"></script>
 <script>
      (function () {
      const editorInstance = new FroalaEditor('#edit', {
        events: {
          'image.beforeUpload': function (files) {
            const editor = this
            if (files.length) {
              var reader = new FileReader()
              reader.onload = function (e) {
                var result = e.target.result
                editor.image.insert(result, null, null, editor.image.get())
              }
              reader.readAsDataURL(files[0])
            }
            return false
          }
        }
      })
    })()
    
  
</script>
	<!-- END wrapper -->

	<?php require 'includes/footer_start.php'
?>
	<!-- ============================================================== -->
	<!-- Todo el codigo js aqui -->
	<!-- ============================================================== -->

	<!-- Codigos Para el Auto complete de Clientes -->

<!-- FIN -->

	

