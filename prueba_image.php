<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Tamaño de Imagen con interact.js</title>
    <!-- Agrega interact.js (puedes descargarlo o usar el CDN) -->
    <script src="https://cdn.jsdelivr.net/npm/interactjs/dist/interact.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.0/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
    <style>
        /* Estilos para el contenedor de la imagen */
        .contenedor-imagen {
            width: 500px;
            height: 500px;
            position: relative;
            overflow: hidden;
            border: 1px solid #ccc;
        }

        /* Estilos para la imagen */
        .imagen-editable {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }
    </style>
</head>
<body>
    <!-- Contenedor de la imagen editable -->
    <div class="contenedor-imagen" id="contenedor-imagen">
        
        <img src="sysadmin/img_sistema/formato_pro.jpg" alt="Imagen Editable" class="imagen-editable">
    </div>

    <script>
        // Seleccionar el contenedor y la imagen editable
        var contenedorImagen = document.getElementById('contenedor-imagen');
        var imagen = contenedorImagen.querySelector('.imagen-editable');

        // Habilitar la funcionalidad de arrastrar y redimensionar con interact.js
        interact(imagen)
            .draggable({
                restrict: {
                    restriction: contenedorImagen,
                    elementRect: { top: 0, left: 0, bottom: 1, right: 1 },
                    endOnly: true,
                },
            })
            .resizable({
                edges: { left: true, right: true, top: true, bottom: true },
                restrictEdges: {
                    outer: contenedorImagen,
                    endOnly: true,
                },
                restrictSize: {
                    min: { width: 50, height: 50 },
                },
                inertia: true,
            })
            .on('dragmove', function(event) {
                var target = event.target;
                var x = (parseFloat(target.getAttribute('data-x')) || 0) + event.dx;
                var y = (parseFloat(target.getAttribute('data-y')) || 0) + event.dy;

                target.style.transform = 'translate(' + x + 'px, ' + y + 'px)';
                target.setAttribute('data-x', x);
                target.setAttribute('data-y', y);
            })
            .on('resizemove', function(event) {
                var target = event.target;
                var x = parseFloat(target.getAttribute('data-x')) || 0;
                var y = parseFloat(target.getAttribute('data-y')) || 0;

                target.style.width = event.rect.width + 'px';
                target.style.height = event.rect.height + 'px';
                target.setAttribute('data-x', x);
                target.setAttribute('data-y', y);
            });
            
            
        $(document).ready(function() {
            // Inicializar el redimensionamiento de la imagen con jQuery UI
            $('.imagen-editable').resizable({
                aspectRatio: true, // Mantener la proporción de la imagen al redimensionar
                maxWidth: '100%', // Límite máximo de redimensionamiento
                stop: function(event, ui) {
                    var ancho = ui.size.width;
                    var alto = ui.size.height;
                    console.log("Ancho: " + ancho + "px, Alto: " + alto + "px");
                    // Aquí puedes realizar cualquier acción con el ancho y alto obtenidos
                }
            });
        });
    
    </script>
</body>
</html>
