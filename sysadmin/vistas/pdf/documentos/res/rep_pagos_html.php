<style type="text/css">
    <!--
    table {
        vertical-align: top;
    }

    tr {
        vertical-align: top;
    }

    td {
        vertical-align: top;
    }

    .midnight-blue {
        background: #2c3e50;
        padding: 4px 4px 4px;
        color: white;
        font-weight: bold;
        font-size: 14px;
    }

    .silver {
        background: white;
        padding: 3px 4px 3px;
    }

    .clouds {
        background: #ecf0f1;
        padding: 3px 4px 3px;
    }

    .border-top {
        border-top: solid 1px #bdc3c7;

    }

    .border-left {
        border-left: solid 1px #bdc3c7;
    }

    .border-right {
        border-right: solid 1px #bdc3c7;
    }

    .border-bottom {
        border-bottom: solid 1px #bdc3c7;
    }

    table.page_footer {
        width: 100%;
        border: none;
        background-color: white;
        padding: 2mm;
        border-collapse: collapse;
        border: none;
    }
    }
    -->
</style>
<page pageset='new' backtop='10mm' backbottom='10mm' backleft='20mm' backright='20mm' style="font-size: 14px; font-family: helvetica">
    <page_header>
        <table style="width: 100%; border: solid 0px black;" cellspacing=0>
            <tr>
                <td style="text-align: left;    width: 33%"></td>
                <td style="text-align: center;    width: 34%;font-size: 14px; font-weight: bold">Reporte de Pagos</td>
                <td style="text-align: right;    width: 33%"><?php echo date('d/m/Y'); ?></td>
            </tr>
        </table>
    </page_header>
    <?php include "encabezado_general.php"; ?>
    <br>
    <table style="width: 100%; border: solid 0px black;">
        <tr>
            <?php
            $sql_abono = mysqli_query($conexion, "select * from cabecera_cuenta_cobrar where numero_factura='$numero_factura'");
            $rw        = mysqli_fetch_array($sql_abono);
            print_r($rw);
            ?>

        </tr>
    </table>
    <br>
    <br>
    <table class="table-bordered" style="width:100%;">
        <tr class="midnight-blue">
            <th style="width:20%;text-align:center">Numero de Factura</th>
            <th style="width:25%;text-align:center">Fecha</th>
            <th style="width:20%;text-align:center">Cliente</th>
            <th style="width:20%;text-align:center">Tienda</th>
            <th style="width:20%;text-align:center">Total venta</th>
            <th style="width:20%;text-align:center">Costo</th>
            <th style="width:20%;text-align:center">Precio Envio</th>
            <th style="width:20%;text-align:center">Monto a Recibir</th>
            <th style="width:20%;text-align:center">Valor Cobrado</th>
            <th style="width:20%;text-align:center">Valor Pendiente</th>
        </tr>
        <?php
        while ($row = mysqli_fetch_array($query)) {
        ?>
            <tr>
                <td><?php echo $row['numero_factura']; ?></td>
                <td><?php echo date("d/m/Y", strtotime($row['fecha_factura'])); ?></td>
                <td><?php echo $row['cliente']; ?></td>
                <td><?php echo $row['tienda']; ?></td>
                <td><?php echo $simbolo_moneda . '' . number_format($row['total_venta'], 2); ?></td>
                <td><?php echo $simbolo_moneda . '' . number_format($row['costo'], 2); ?></td>
                <td><?php echo $simbolo_moneda . '' . number_format($row['precio_envio'], 2); ?></td>
                <td><?php echo $simbolo_moneda . '' . number_format($row['monto_recibir'], 2); ?></td>
                <td><?php echo $simbolo_moneda . '' . number_format($row['valor_cobrado'], 2); ?></td>
                <td><?php echo $simbolo_moneda . '' . number_format($row['valor_pendiente'], 2); ?></td>
            </tr>
        <?php } ?>
    </table>
    <br><br>
    <br><br>

    <br><br>
    <br><br>
    <page_footer>
        <table style="width: 100%; border: solid 0px black;">
            <tr>
                <td style="text-align: left;    width: 50%"></td>
                <td style="text-align: right;    width: 50%">page [[page_cu]]/[[page_nb]]</td>
            </tr>
        </table>
    </page_footer>
</page>