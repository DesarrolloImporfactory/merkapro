<?php

require_once 'src/cargar.php';

ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(-1);
/**
 * Convert a comma separated file into an associated array.
 * The first row should contain the array keys.
 * 
 * Example:
 * 
 * @param string $filename Path to the CSV file
 * @param string $delimiter The separator used in the file
 * @return array
 * @link http://gist.github.com/385876
 * @author Alexander Cortes
 * @copyright Copyright (c) 2021, Alexander Cortes
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */


 /*$ruta = "https://srienlinea.sri.gob.ec/facturacion-internet/consultas/publico/ruc-datos2.jspa?accion=siguiente&ruc=".$ruc;
        //var_dump($ruta);die;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://srienlinea.sri.gob.ec/facturacion-internet/consultas/publico/ruc-datos2.jspa?accion=siguiente&ruc=".$ruc);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 1);*/

        
        
if (isset($_POST['submit'])) {
    $file = realpath($_FILES['file']['tmp_name']);


    if (is_uploaded_file($file)) {

        move_uploaded_file(realpath($_FILES['file']['tmp_name']), "txt/" . $_FILES["file"]["name"]);
        $cargar = new cargar();
        $salida = $cargar->cargarTxt($_FILES["file"]["name"]);
        
        
        $salida_serializada = json_encode($salida, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
        
        
    }
}

if (isset($_POST['reset'])) {
    $salida = '';
}

/**
 * Example
 */
//generarXml();
?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>Bootstrap 101 Template</title>

        <!-- Bootstrap -->
        <link rel="stylesheet" href="css/loading.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>


    <body>

        <div id="loading"></div>
        <div class="row">
            <div class="col-md-3">
                <form method="post" id="form" action="index.php" enctype="multipart/form-data">

                    <div class="form-group">
                        <label for="exampleFormControlFile1">Cargar Archivo Txt</label>
                        <input type="file" class="form-control-file" id="file" name="file">
                        <input type="hidden" name="submit" id="submit" value="submit">
                    </div>
                    <button type="submit" class="btn btn-primary">Cargar</button>
                </form>
            </div>
            <div class="col-md-3">


                <div class="form-group">
                    <label for="exampleFormControlFile1">Generar Comprobantes XML</label>
                    <input type="hidden" name="salida_serializada" id="salida_serializada" value='<?php echo $salida_serializada; ?>'>
                    <input type="hidden" name="generarXML" value="generarXML">
                    
                </div>

                <button id="generarXml" class="btn btn-warning">Generar XML</button>
                <a href="descargar.php" id="generarzip" class="btn btn-success" style = "display:none;">Descargar ZIP</a>

            </div>
            <div class="col-md-3">
                <form method="post" id="form" action="index.php" enctype="multipart/form-data">
                    <button type="submit" name="reset" class="btn btn-danger">Reset</button>
                </form>
            </div>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">COMPROBANTE</th>
                    <th scope="col">SERIE_COMPROBANTE</th>
                    <th scope="col">RUC_EMISOR</th>
                    <th scope="col">RAZON_SOCIAL_EMISOR</th>
                    <th scope="col">FECHA_EMISION</th>
                    <th scope="col">FECHA_AUTORIZACION</th>
                    <th scope="col">TIPO_EMISION</th>
                    <th scope="col">IDENTIFICACION_RECEPTOR</th>
                    <th scope="col">CLAVE_ACCESO</th>
                    <th scope="col">NUMERO_AUTORIZACION</th>
                    <th scope="col">IMPORTE TOTAL</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <?php
                    if (!empty($salida)) {
                        foreach ($salida as $key => $value) {
                            ?>
                    <th scope="row"><?php echo utf8_decode($salida[$key][0]); ?></th>
                            <th scope="row"><?php echo utf8_decode($salida[$key][1]); ?></th>
                            <th scope="row"><?php echo utf8_decode($salida[$key][2]); ?></th>
                            <th scope="row"><?php echo utf8_decode($salida[$key][3]); ?></th>
                            <th scope="row"><?php echo utf8_decode($salida[$key][4]); ?></th>
                            <th scope="row"><?php echo utf8_decode($salida[$key][5]); ?></th>
                            <th scope="row"><?php echo utf8_decode($salida[$key][6]); ?></th>
                            <th scope="row"><?php echo utf8_decode($salida[$key][7]); ?></th>
                            <th scope="row"><?php echo utf8_decode($salida[$key][8]); ?></th>
                            <th scope="row"><?php echo utf8_decode($salida[$key][9]); ?></th>
                            <th scope="row"><?php echo utf8_decode($salida[$key][10]); ?></th>


                        </tr>
                        <?php
                    }
                }
                ?>
            </tbody>
        </table>

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ" crossorigin="anonymous"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>

        <script>


            
            $('#generarXml').click(function () {
                
                $("#loading").show();
                var form = $(this);
                var url = 'generarXml.php';
                var salida = $('#salida_serializada').val()

                $.ajax({
                    type: "POST",
                    url: url,
                    data: {form: form.serialize(), salida: salida},
                    success: function (data)
                    {
                        alert("Comprobantes generados, ahora puede descargar los archivos pdf y xml")
                        $("#loading").hide();
                        $('#generarXml').hide();
                        $('#generarzip').show();
                        
                    }
                });
            });

            

        </script>
    </body>
</html>