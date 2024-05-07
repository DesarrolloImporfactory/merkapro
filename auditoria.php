<?php
$ip = $_SERVER['REMOTE_ADDR'];
$userAgent = $_SERVER['HTTP_USER_AGENT'];
$timestamp = date('Y-m-d H:i:s');
$sql = "INSERT INTO registros_visitas (ip, user_agent, fecha_hora, pagina, id_producto) VALUES ('$ip', '$userAgent', '$timestamp', '$pagina', '$id_producto')";
$query = mysqli_query($conexion, $sql);
