<?php
require_once "../db.php"; //Contiene las variables de configuracion para conectar a la base de datos
require_once "../php_conexion.php"; //Contiene funcion que conecta a la base de datos


$guia = $_POST['guia'];

$consulta = "SELECT * FROM detalle_novedad WHERE guia_novedad = '$guia'";
$result = mysqli_query($conexion, $consulta);
$tabla = "<table class='table table-bordered table-striped'>";
$tabla .= "<thead>";
$tabla .= "<tr>";
$tabla .= "<th>Id</th>";
$tabla .= "<th>Guia</th>";
$tabla .= "<th>Nombre</th>";
$tabla .= "<th>Detalle</th>";
$tabla .= "<th>Observacion</th>";
$tabla .= "</tr>";
$tabla .= "</thead>";
$tabla .= "<tbody>";


if (mysqli_num_rows($result) > 0) {
    $response = array();
    while ($row = mysqli_fetch_array($result)) {
        $tabla .= "<tr>";
        $tabla .= "<td>" . $row['id_detalle_novedad'] . "</td>";
        $tabla .= "<td>" . $row['guia_novedad'] . "</td>";
        $tabla .= "<td>" . $row['nombre_novedad'] . "</td>";
        $tabla .= "<td>" . $row['detalle_novedad'] . "</td>";
        $tabla .= "<td>" . $row['observacion'] . "</td>";
        $tabla .= "</tr>";
    }


    $tabla .= "</tbody>";

    $tabla .= "</table>";
    echo $tabla;
} else {
    echo "0";
}
