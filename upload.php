 <?php
if ($_FILES['file']['name']) {
    if (!$_FILES['file']['error']) {
        $name = md5(rand(100, 200));
        $ext = explode('.', $_FILES['file']['name']);
        $filename = $name . '.' . $ext[1];
        $destination = 'uploads/' . $filename; // Ajusta la carpeta de destino según tu estructura de archivos
        $location = $_FILES["file"]["tmp_name"];

        // Verifica si el directorio de destino existe, si no, créalo
        if (!is_dir('uploads')) {
            mkdir('uploads', 0755, true);
        }

        // Mueve el archivo al directorio de destino en el sistema de archivos
        if (move_uploaded_file($location, $destination)) {
            $imageURL = '/' . $destination; // URL de la imagen cargada
            echo $imageURL; // Devuelve la URL de la imagen cargada
        } else {
            echo 'Error al mover el archivo....';
        }
    } else {
        echo $message = 'Ocurrió un error: ' . $_FILES['file']['error'];
    }
}
?>