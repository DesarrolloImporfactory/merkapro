<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once "../db.php";
require_once "../php_conexion.php";
require_once "../funciones.php";

@$ciudad = $_POST['ciudad'];
@$valor_total = $_POST['valor_total'];
$cantidad_total = $_POST['cantidad_total'];
$cod = $_POST['cod'];
$seguro = $_POST['seguro'];
$costo = $_POST['costo_total'];

if (isset($_POST['ciudad2'])) {
    $ciudad2 = $_POST['ciudad2'];
}

if (isset($_POST['provincia'])) {
    $provincia = $_POST['provincia'];
}
$transportadora = $_POST['transportadora'];
//echo $costo;
$valorasegurado = $_POST['valorasegurado'];
//valorasegurado=$('#valorasegurado').val();
if (empty($transportadora)) {
    $transportadora = 1;
}
//echo $valor_total;
if ($transportadora == 1) {
    $valor_base = get_row('ciudad_cotizacion', 'trayecto_laar', 'id_cotizacion', $ciudad);
    $precio_trayecto = get_row('cobertura_laar', 'precio', 'tipo_cobertura', $valor_base);
    $valor_base = $precio_trayecto;
} else if ($transportadora == 2) {
    if ($ciudad == 1 || $ciudad == 599) {
        $valor_base = 5.5;
    } else {
        $valor_base = 6.5;
    }
} else if ($transportadora == 3) {
    $valor_base = get_row('ciudad_cotizacion', 'trayecto_servientrega', 'ciudad', $ciudad2);
    $precio_trayecto = get_row('cobertura_servientrega', 'precio', 'tipo_cobertura', $valor_base);
    $valor_base =    $precio_trayecto;
}

//echo $cod;
if ($transportadora == 1) {


    if ($cod == "1") {
        $cod = $valor_total * 0.03;
    } else {
        $cod = 0;
    }
} else if ($transportadora == 3) {
    if ($cod == "1") {
        $cod = $valor_total * 0.03;
    } else {
        $cod = 0;
    }
} else {
    $cod = 0;
}
if ($seguro == 1) {
    $seguro = $valorasegurado * 0.01;
} else {
    $seguro = 0;
}
if ($transportadora == 3) {
    $valor_envio = $valor_base + $cod + $seguro;
} else {
    $valor_envio = $valor_base;
}


$valor_texto = "Precio de envío $" . number_format($valor_envio, 2);



?>
<table class="table table-sm table-striped">

    <tr>
        <th>
            <?php
            if ($transportadora == "1") {
            ?>
                <img width="100px" src="../../img_sistema/logo-dark.png" alt="" />
            <?php

            } else if ($transportadora == "2") {
            ?>
                <img width="100px" src="../../img_sistema/speed.jpg" alt="" />
            <?php
            } else if ($transportadora == "3") {
            ?>
                <img width="100px" src="../../img_sistema/servi.png" alt="" />
            <?php

            } else if ($transportadora == "4") {
            ?>
                <img width="100px" src="../../img_sistema/gintracom.png" alt="" />
            <?php
            }
            ?>


        </th>
        <th>$<?php echo number_format($valor_envio, 2) ?></th>
    </tr>
    <tr>
        <th>Total Venta </th>
        <td>$<?php echo number_format($valor_total, 2) ?></td>
    </tr>
    <tr>
        <th>Costo </th>
        <td>$<?php echo number_format($costo, 2) ?></td>
    </tr>
    <tr>
        <th>Costo Fullfilment </th>
        <td>$<?php echo number_format(1.50, 2) ?></td>
    </tr>
    <tr>
        <th>Precio de Envío </th>
        <td>$<?php echo number_format($valor_envio, 2) ?></td>
    </tr>
    <tr>
        <th>Comisión de la plataforma </th>
        <td>$<?php echo number_format(0, 2) ?></td>
    </tr>
    <tr>
        <th>Monto a recibir </th>
        <td id="monto_total_">$<?php echo number_format($valor_total - $costo - $valor_envio - 1.5, 2) ?></td>
    </tr>
</table>

<input type="hidden" id="valor_envio2" name="valor_envio2" value="<?php echo $valor_envio; ?>">