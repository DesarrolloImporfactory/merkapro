<?php


function get_row_destino($conexion_destino, $table, $row, $id, $equal)
{
    //global $conexion_destino;
   // echo "select $row from $table where $id='$equal'";
    $query = mysqli_query($conexion_destino, "select $row from $table where $id='$equal'");
    $rw    = mysqli_fetch_array($query);
    $value = $rw[$row];
    return $value;
}

