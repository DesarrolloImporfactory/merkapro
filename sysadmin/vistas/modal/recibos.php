 <?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    require_once "../db.php"; //Contiene las variables de configuracion para conectar a la base de datos
    require_once "../php_conexion.php"; //Contiene funcion que conecta a la base de datos
    $id_cabecera_cpp = $_POST['id_cabecera_cpp'];
    $marketplace_conexion = mysqli_connect("localhost", "imporsuit_marketplace", "imporsuit_marketplace", "imporsuit_marketplace");
    $sql_recibos = "SELECT * FROM detalle_cuenta_pagar WHERE id_cabecera_cpp = '$id_cabecera_cpp'";

    $query_recibos = mysqli_query($marketplace_conexion, $sql_recibos);
    $count_query = mysqli_query($marketplace_conexion, "SELECT count(*) AS numrows FROM detalle_cuenta_pagar WHERE id_cabecera_cpp = '$id_cabecera_cpp'");
    $row = mysqli_fetch_array($count_query);
    $num_rows = $row['numrows'];
    $total_recibos = 0;
    if ($num_rows > 0) {
        $tabla = "
        <div class='container-fluid'>
    <div class='table-responsive'>
        <table class='table table-striped table-hover table-bordered'>
            <thead>
                <tr>
                    <th>Numero documento</th>
                    <th>Fecha</th>
                    <th>Valor</th>
                    <th>Forma de Pago</th>
                    <th>Recibo</th>
                </tr>
            </thead>
            <tbody>
";


        while ($row_recibos = mysqli_fetch_array($query_recibos)) {
            $id_detalle_cpp = $row_recibos['id_detalle_cpp'];
            $valor = $row_recibos['valor'];
            $forma_pago = $row_recibos['metodo_pago'];
            $id_pago = $row_recibos['id_pago'];
            $sql_pago = "SELECT * FROM pagos WHERE id_pago = '$id_pago'";
            $query_pago = mysqli_query($marketplace_conexion, $sql_pago);
            $row_pago = mysqli_fetch_array($query_pago);
            $numero_documento = $row_pago['numero_documento'];
            $imagen = $row_pago['imagen'];
            $fecha = $row_pago['fecha'];
            $total_recibos += $valor;
            $tabla .= '
                        <tr>
                            <td>' . $numero_documento . '</td>
                            <td>' . $fecha . '</td>
                            <td>' . $valor . '</td>
                            <td>' . $forma_pago . '</td>
                            <td><a href="' . $imagen . '" target="_blank"><i class="fa fa-file-pdf-o"></i></a></td>
                        </tr>
                    ';
        }

        $tabla .= "
            </tbody>
            </table>

            <div class='text-success'>
                <h5>Total dinero recibido: " . $total_recibos . "</h5>
    
                </div>
            
            </div>
            ";
        echo $tabla;
    } else {
        echo "
        <div class='alert alert-danger'>
            <strong>No hay recibos para mostrar</strong>
        </div>
        ";
    }

    ?>


