<?php
//require_once 'src/cargar.php';
require_once("/home/imporsuit/public_html/factelectronica.imporsuit.com/vistas/html/consultas/consulta/src/cargar.php");

require_once("/home/imporsuit/public_html/factelectronica.imporsuit.com/vistas/html/consultas/consulta/src/zipArchiver.php");

//require_once 'src/zipArchiver.php';

$files = glob('comprobantes/*'); // get all file names
foreach($files as $file){ // iterate files
  if(is_file($file)) {
    unlink($file); // delete file
  }
}


$salida = json_decode($_POST['salida'], true);

$cargar = new cargar();
$result = $cargar->cargarXml($salida);

$zipper = new ZipArchiver;

$realPath = getcwd();
// Path of the directory to be zipped
$dirPath = $realPath.'/comprobantes';

// Path of output zip file
$zipPath = $realPath.'/comprobantes.zip';

// Create zip archive
$zip = $zipper->zipDir($dirPath, $zipPath);

if($zip){
    echo 'ZIP archive created successfully.';
}else{
    echo 'Failed to create ZIP.';
}

 
return $result;

