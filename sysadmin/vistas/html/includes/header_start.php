<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once "../funciones.php";
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<meta name="description" content="Constructor Merkapro">
	<meta name="author" content="Merkapro">

	<link rel="shortcut icon" href="<?php
									if (get_row('perfil', 'favicon', 'id_perfil', '1') == "") {
										echo "../../assets/images/favicon.png";
									} else {
										echo str_replace("../..", "/sysadmin", get_row('perfil', 'favicon', 'id_perfil', '1'));
									}
									?>">
	<!-- daterange picker -->
	<link rel="stylesheet" href="../../assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css">
	<link href="../../assets/plugins/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
	<!-- librerias para la busqueda de de autocomplete -->
	<link type="text/css" href="../../js/jquery-ui.css" rel="stylesheet" />





	<title>MERKAPRO</title>

	<!-- Sweet Alert css -->
	<link href="../../assets/plugins/switchery/switchery.min.css" rel="stylesheet" />
	<link href="../../assets/plugins/bootstrap-sweetalert/sweet-alert.css" rel="stylesheet" type="text/css" />
	<link href="../../assets/plugins/select2/select2.css" rel="stylesheet" type="text/css" />
	<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
	<style>
		.select2-container--default .select2-selection--single {
			height: 38px;
		}

		.select2-container--default .select2-selection--single .select2-selection__rendered {
			line-height: 38px;
		}

		.caja {
			padding: 20px !important;
			border-radius: 25px;
			-webkit-box-shadow: -2px 2px 5px 0px rgba(0, 0, 0, 0.23);
			-moz-box-shadow: -2px 2px 5px 0px rgba(0, 0, 0, 0.23);
			box-shadow: -2px 2px 5px 0px rgba(0, 0, 0, 0.23);
		}
	</style>