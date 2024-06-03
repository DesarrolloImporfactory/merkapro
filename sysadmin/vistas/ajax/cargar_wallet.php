<?php
require_once "../db.php"; //Contiene las variables de configuracion para conectar a la base de datos
require_once "../php_conexion.php"; //Contiene funcion que conecta a la base de datos
//Archivo de funciones PHP
require_once "../funciones.php";

//Obtenemos la fecha actual
$fecha = date('Y-m-d');
$fecha_desde = $_POST['fecha_desde'];

//buscamos los datos de la tabla wallet

$consulta = "SELECT * FROM guia_laar WHERE fecha BETWEEN '$fecha_desde' AND '$fecha' ORDER BY fecha DESC";
$resultado = mysqli_query($conexion, $consulta) or die(mysqli_error($conexion));
//Guardamos los datos en un array
$rows = mysqli_fetch_all($resultado, MYSQLI_ASSOC);
//Recorremos el array y mostramos los datos

foreach ($rows as $row) {
    $data = array();
    $proveedor = "";
    if (strpos($row['guia_laar'], "MKP") === 0) {
        $proveedor = "LAAR";
        if ($row['estado_guia'] == 7) {
            $data["noGuia"] = $row['guia_laar'];
            $data["estadoActualCodigo"] = 7;
            $data["novedades"] = array(
                array(
                    "codigoTipoNovedad" => 43,
                    "nombreTipoNovedad" => "Guía entrega",
                    "codigoDetalleNovedad" => 17,
                    "nombreDetalleNovedad" => "Guía entregada al cliente",
                    "numeroMaximo" => 3,
                    "observacion" => "Guía entregada al cliente",
                    "fechaNovedad" => "2021-09-01",
                )
            );
        } else if ($row['estado_guia'] == 9) {
            $data["noGuia"] = $row['guia_laar'];
            $data["estadoActualCodigo"] = 9;
            $data["novedades"] = array(
                array(
                    "codigoTipoNovedad" => 42,
                    "nombreTipoNovedad" => "Guía devuelta",
                    "codigoDetalleNovedad" => 18,
                    "nombreDetalleNovedad" => "Guía devuelta al remitente",
                    "numeroMaximo" => 3,
                    "observacion" => "Guía devuelta al remitente",
                    "fechaNovedad" => "2021-09-01",
                ),
                array(
                    "codigoTipoNovedad" => 96,
                    "nombreTipoNovedad" => "Guía devuelta",
                    "codigoDetalleNovedad" => 18,
                    "nombreDetalleNovedad" => "Guía devuelta al remitente",
                    "numeroMaximo" => 3,
                    "observacion" => "Guía devuelta al remitente",
                    "fechaNovedad" => "2021-09-01",
                )
            );
        }
    } else if (strpos($row["guia_laar"], "FAST") === 0) {
        $proveedor = "LAAR";

        if ($row['estado_guia'] == 3) {
            $data["noGuia"] = $row['guia_laar'];
            $data["estadoActualCodigo"] = 7;
            $data["novedades"] = array(
                array(
                    "codigoTipoNovedad" => 43,
                    "nombreTipoNovedad" => "Guía entrega",
                    "codigoDetalleNovedad" => 17,
                    "nombreDetalleNovedad" => "Guía entregada al cliente",
                    "numeroMaximo" => 3,
                    "observacion" => "Guía entregada al cliente",
                    "fechaNovedad" => "2021-09-01",
                )
            );
        } else if ($row['estado_guia'] == 9) {
            $data["noGuia"] = $row['guia_laar'];
            $data["estadoActualCodigo"] = 9;

            $data["novedades"] = array(

                array(
                    "codigoTipoNovedad" => 42,
                    "nombreTipoNovedad" => "Guía devuelta",
                    "codigoDetalleNovedad" => 18,
                    "nombreDetalleNovedad" => "Guía devuelta al remitente",
                    "numeroMaximo" => 3,
                    "observacion" => "Guía devuelta al remitente",
                    "fechaNovedad" => "2021-09-01",
                ),
                array(
                    "codigoTipoNovedad" => 96,
                    "nombreTipoNovedad" => "Guía devuelta",
                    "codigoDetalleNovedad" => 18,
                    "nombreDetalleNovedad" => "Guía devuelta al remitente",
                    "numeroMaximo" => 3,
                    "observacion" => "Guía devuelta al remitente",
                    "fechaNovedad" => "2021-09-01",
                )
            );
        }
    } else if (is_numeric($row["guia_laar"])) {
        $proveedor = "SERVI";

        if ($row['estado_guia'] >= 400 && $row["estado_guia"] <= 404) {
            $data["guia"] = $row['guia_laar'];
            $data["ciudad"] = "";
            $data["estado"] = "1";
            $data["movimiento"] = "400";
            $data["observacion1"] = "Devolucion";
            $data["observacion2"] = "";
            $data["observacion3"] = "";
            $data["fecha_movimiento_novedad"] = "2024-05-09 09:32:35";
        } else if ($row['estado_guia'] >= 500 && $row["estado_guia"] <= 504) {
            $data["guia"] = $row['guia_laar'];
            $data["ciudad"] = "";
            $data["estado"] = "1";
            $data["movimiento"] = "400";
            $data["observacion1"] = "Devolucion";
            $data["observacion2"] = "";
            $data["observacion3"] = "";
            $data["fecha_movimiento_novedad"] = "2024-05-09 09:32:35";
        }
    }

    $server = "";
    if ($proveedor == "LAAR") {
        $server = "https://marketplace.imporsuit.com/sysadmin/api/integracion/Laar/";
    } else if ($proveedor == "SERVI") {
        $server = "https://guias.imporsuit.com/Servientrega/";
    }

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $server);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

    $usuario = "importsuite";
    $clave = "ab5b809caf73b2c1abb0e4586a336c3a";
    $credenciales = base64_encode($usuario . ":" . $clave);
    $headers = array(
        "Content-Type: application/json",
        "Authorization: Basic " . $credenciales
    );

    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $result = curl_exec($ch);
    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    }
    curl_close($ch);

    echo $result;
}
