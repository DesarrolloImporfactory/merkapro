<?php
//$repositoryPath = 'C:\xampp\htdocs\imporsuitv01'; // Reemplaza con la ruta de tu repositorio
$command = "cd .. && cd .. && git pull";

$result = shell_exec($command);
//echo strlen($result);
// cd $repositoryPath && echo strlen($result);
if (strlen($result)==20){
 $actualzacion_sistema=0;   
}else{
 $actualzacion_sistema=1;  
}
?>


