<?php
session_start();
if (!isset($_SESSION['user_login_status']) and $_SESSION['user_login_status'] != 1) {
    header("location: ../../login.php");
    exit;
}
/* Connect To Database */
require_once "../db.php"; //Contiene las variables de configuracion para conectar a la base de datos
require_once "../php_conexion.php"; //Contiene funcion que conecta a la base de datos




$sql = "SELECT * FROM ciudad_laar WHERE codigo = " . $_POST["ciudad"] . ";";

$query = mysqli_query($conexion, $sql);

$row = mysqli_fetch_array($query);

echo $row['codigoProvincia'];
