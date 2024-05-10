<?php
include 'is_logged.php';  // Archivo verifica que el usuario que intenta acceder a la URL está logueado
require_once "../db.php";  // Contiene las variables de configuración para conectar a la base de datos
require_once "../php_conexion.php";  // Contiene la función que conecta a la base de datos
require_once "../funciones.php";

$nombre_producto = isset($_GET['nombre_producto']) ? $_GET['nombre_producto'] : '';

// Utiliza LIKE para filtrar los productos según las letras ingresadas
$sql = "SELECT * FROM productos WHERE drogshipin=0 and nombre_producto LIKE '%" . mysqli_real_escape_string($conexion, $nombre_producto) . "%'";

$query = mysqli_query($conexion, $sql);

if ($_SERVER['HTTP_HOST'] == 'localhost') {
    $conexion_destino = new mysqli('localhost', 'root', '', 'master');
} else {
    $conexion_destino = new mysqli('localhost', 'imporsuit_marketplace', 'imporsuit_marketplace', 'imporsuit_marketplace');
}
?>
<style>
    .btn-solucion {
        background-color: #FFD100;
        color: white;
    }
</style>
<div class="table-responsive">
    <table class="table table-sm table-striped">
        <tr class="info">
            <th>ID</th>
            <th></th>
            <th>Codigo</th>
            <th style="text-align: center" colspan="1">Producto</th>
            <th class='text-center'>Existencia</th>
            <th>Ajustar</th>

        </tr>
        <?php
        while ($row = mysqli_fetch_array($query)) {
            $id_producto          = $row['id_producto'];
            $image_path           = $row['image_path'];
            $codigo_producto      = $row['codigo_producto'];
            $nombre_producto      = $row['nombre_producto'];
            $drogshipin      = $row['drogshipin'];
            $stock_producto       = $row['stock_producto'];

        ?>


            <tr data-id_producto="<?php echo $id_producto; ?>" data-nombre_producto="<?php echo htmlspecialchars($nombre_producto); ?>">
                <td><span class="badge badge-purple"><?php echo $id_producto; ?></span></td>
                <td class='text-center'>
                    <?php
                    if ($image_path == null) {
                        echo '<img src="../../img/productos/default.jpg" class="" width="60">';
                    } else {
                        echo '<img src="' . $image_path . '" class="" width="60">';
                    }

                    ?>
                    <!--<img src="<?php echo $image_path; ?>" alt="Product Image" class='rounded-circle' width="60">-->
                </td>
                <td><?php echo $codigo_producto; ?></td>
                <td><?php echo $nombre_producto; ?></td>
                <td class='text-center'><?php
                                        if ($drogshipin == 1) {
                                            $id_marketplace      = $row['id_marketplace'];
                                            if (isset($id_marketplace)) {
                                                $sql2    = mysqli_query($conexion_destino, "select * from productos where id_producto='" . $id_marketplace . "'");
                                                $rw      = mysqli_fetch_array($sql2);

                                                $old_qty = $rw['stock_producto']; //Cantidad encontrada en el inventario
                                                echo stock($old_qty);
                                            } else {
                                                echo 'VUELVA A IMPORTAR EL PRODUCTO';
                                            }
                                        } else {
                                            if ($drogshipin == 3) {
                                            } else {
                                                echo stock($stock_producto);
                                            }
                                        }



                                        ?></td>
                <td>
                    <button type="button" class="btn btn-solucion" onclick="ajustarProducto(this);"><i class='bx bxs-shield-plus'></i> Ajustar</button>

                </td>

            </tr>
        <?php
        }
        ?>
        <tr>