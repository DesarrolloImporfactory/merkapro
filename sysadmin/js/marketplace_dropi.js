let indice=1;
let limite=1;
const paginasAMostrar = 5;
let q = '';
let id_producto_dropi = null;
$(document).ready(function () {
  load();
});
$("#editar_linea").submit(function (event) {
  // alert();
  $("#actualizar_datos").attr("disabled", true);
  var parametros = $(this).serialize();
  $.ajax({
    type: "POST",
    url: "../ajax/editar_pedido.php",
    data: parametros,
    beforeSend: function (objeto) {
      $("#resultados_ajax2").html(
        '<img src="../../img/ajax-loader.gif"> Cargando...'
      );
    },
    success: function (datos) {
      $("#resultados_ajax2").html(datos);
      $("#actualizar_datos").attr("disabled", false);
      //load(1);
      let msg = JSON.parse(datos);
      if (msg[0] === "Linea ha sido actualizada con Exito.") {
        $.Notification.autoHideNotify(
          "success",
          "top right",
          "Linea ha sido actualizada con Exito.",
          "Linea ha sido actualizada con Exito."
        );
        load(1);
      } else {
        $.Notification.autoHideNotify(
          "error",
          "top right",
          "Error al actualizar la linea.",
          "Comuniquese con Soporte."
        );
      }
    },
  });
  event.preventDefault();
});
function load(page) {
  q = $("#keyword").val();
  id_producto_dropi = parseInt($("#id_producto_dropi").val());
    card_productos(q);
  
    let fecha_storage = new Date();
    fecha_storage = localStorage.getItem('fecha_datos_dropi');
    const fecha_actual = new Date().toLocaleDateString();
    if(fecha_storage !== fecha_actual){
      const fechaActualTexto = new Date().toLocaleDateString();
      localStorage.setItem('fecha_datos_dropi', fechaActualTexto)
      cargar_datos_storage(q);
    }
}

function card_productos(q,numero_paginacion=1){
  var url_datos_new = location.origin + "/sysadmin/vistas/json/datos_dropi_new.json";
  fetch(url_datos_new)
  .then(response => response.json())
  .then(data => {
    var datos = data;
    if (!isNaN(id_producto_dropi)){
      if ((q === '') || (q === null)){
      console.log(q);
      let find_id = data.findIndex(item => item.id === id_producto_dropi);
      console.log(find_id);
      id_producto_dropi = NaN;

      
      var html= '<div class= "d-flex flex-column">\n';
      html= '<div class= "d-flex flex-wrap" style="gap:0px">\n';

      var boton_inicio = 0;
      var boton_fin = datos.length;
      for (boton_inicio ; boton_inicio < boton_fin; boton_inicio++) {
        if (boton_inicio === find_id){
        var info_proveedor= datos[find_id]['user'];
      var ultimo= datos[find_id]['gallery'].length - 1;
      let url_img='';
      if(datos[find_id]['gallery'].length !== 0){
        if(datos[find_id]['gallery'][ultimo]['urlS3'] === null){
          url_img='https://api.dropi.ec/'+datos[find_id]['gallery'][ultimo]['url']+'';
        }else{
          url_img='https://d39ru7awumhhs2.cloudfront.net/'+datos[find_id]['gallery'][ultimo]['urlS3']+'';
        }
      }else{
        url_img='https://cdn.icon-icons.com/icons2/2633/PNG/512/office_gallery_image_picture_icon_159182.png';
      }
      //inicio card
      html += '<div  class="col-md-3 " >\n';
      html += '<div  style="padding:10px"  align="center" class="card" width="500px" height="500px" >\n';
      //imagen
      html += '<div class="view overlay">\n';
      html += '<img class="card-img-top" width="150px" height="180px" src="'+url_img+'">\n';
      html += '</div>\n';
      //final de imagen
      html += '<div class="card-body">\n';
      html += '<h6 class="card-title"><strong>'+ datos[find_id]['name'] +'</strong></h6>\n';
      html += '<p class="card-text"><strong>Stock: </strong>'+ datos[find_id]['stock']+'</p>\n';
      html += '<p class="card-text"><strong>Precio de venta:</strong> $ '+ datos[find_id]['sale_price'] +'</p>\n';
      html += '<p class="card-text"><strong>Precio Sugerido:</strong> $ '+ datos[find_id]['suggested_price']+'</p>\n';
      html += '<p class="card-text"><strong>Proveedor:</strong>  '+ info_proveedor['name']+'</p>\n';
      html += '<div class= "d-flex flex-column" style="gap:10px">\n';
      html += '<button type="button" class="btn btn-light-blue btn-md" data-toggle="modal" data-target="#Descripcion_'+find_id+'">Descripción</button>\n';
      html += '<a class="btn btn-primary" style="width: 100%; gap:5px; color: white;" title="Importar" onclick="importar('+find_id+')"><strong>Importar</strong></a>\n';
      html += '</div>\n';
      html += '</div>\n';
      html += '</div>\n';
      html += '</div>\n';
      //Modal
      html = modal_producto_dropi(html,find_id,datos,info_proveedor,url_img);
      //Fin Modal
    }
    }
    html += '</div>\n';
    html += '</div>\n';

    $('.outer_div').html(html);
      }
    }else{
      var key = q.toLowerCase();
      let respuesta = datos.filter(item => item.name.toLowerCase().includes(key));

      indice = numero_paginacion;
      var filtro = respuesta.length;
      filtro = Math.trunc(filtro / 20) ;
      limite = filtro-1;
      var html= '<div class= "d-flex flex-column">\n';
      html += '<div class= "d-flex flex-wrap" style="gap:0px">\n';

      var boton_inicio = (numero_paginacion  * 20 ) - 20;
      var boton_fin = boton_inicio + 20;
      for (boton_inicio ; boton_inicio < boton_fin; boton_inicio++) {
        var info_proveedor= respuesta[boton_inicio]['user'];
      var ultimo= respuesta[boton_inicio]['gallery'].length - 1;
      let url_img='';
      if(respuesta[boton_inicio]['gallery'].length !== 0){
        if(respuesta[boton_inicio]['gallery'][ultimo]['urlS3'] === null){
          url_img='https://api.dropi.ec/'+respuesta[boton_inicio]['gallery'][ultimo]['url']+'';
        }else{
          url_img='https://d39ru7awumhhs2.cloudfront.net/'+respuesta[boton_inicio]['gallery'][ultimo]['urlS3']+'';
        }
      }else{
        url_img='https://cdn.icon-icons.com/icons2/2633/PNG/512/office_gallery_image_picture_icon_159182.png';
      }
      //inicio card
      html += '<div  class="col-md-3 " >\n';
      html += '<div  style="padding:10px"  align="center" class="card" width="500px" height="500px" >\n';
      //imagen
      html += '<div class="view overlay">\n';
      html += '<img class="card-img-top" width="150px" height="180px" src="'+url_img+'">\n';
      html += '</div>\n';
      //final de imagen
      html += '<div class="card-body">\n';
      html += '<h6 class="card-title"><strong>'+ respuesta[boton_inicio]['name'] +'</strong></h6>\n';
      html += '<p class="card-text"><strong>Stock: </strong>'+ respuesta[boton_inicio]['stock']+'</p>\n';
      html += '<p class="card-text"><strong>Precio de venta:</strong> $ '+ respuesta[boton_inicio]['sale_price'] +'</p>\n';
      html += '<p class="card-text"><strong>Precio Sugerido:</strong> $ '+ respuesta[boton_inicio]['suggested_price']+'</p>\n';
      html += '<p class="card-text"><strong>Proveedor:</strong>  '+ info_proveedor['name']+'</p>\n';
      html += '<div class= "d-flex flex-column" style="gap:10px">\n';
      html += '<button type="button" class="btn btn-light-blue btn-md" data-toggle="modal" data-target="#Descripcion_'+boton_inicio+'">Descripción</button>\n';
      html += '<a class="btn btn-primary" style="width: 100%; gap:5px; color: white;" title="Importar" onclick="importar('+boton_inicio+')"><strong>Importar</strong></a>\n';
      html += '</div>\n';
      html += '</div>\n';
      html += '</div>\n';
      html += '</div>\n';
      //Modal
      html = modal_producto_dropi(html,boton_inicio,respuesta,info_proveedor,url_img);
      //Fin Modal
    }
    console.log()
    html += '</div>\n';
    console.log(filtro)
    paginacion_productos_dropi(filtro);

    html += '</div>\n';
    
    $('.outer_div').html(html);
  }
  })
  .catch(error => console.error('Error al cargar el JSON:', error));
}

function modal_producto_dropi(html,boton_inicio,datos,info_proveedor,url_img){
  html += '<div class="modal fade" id="Descripcion_'+boton_inicio+'" tabindex="-1" role="dialog" aria-labelledby="descripcionLabel_'+boton_inicio+'" aria-hidden="true">\n';
      html += '<div class="modal-dialog modal-lg" role="document">\n';
      html += '<div class="modal-content">\n';
      html += '<div class="modal-header">\n';
      html += '<h5 class="modal-title text-center" id="facebookLabel">Descripción del Producto</h5>\n';
      html += '<button type="button" class="close" data-dismiss="modal" aria-label="Close">\n';
      html += '<span aria-hidden="true">&times;</span>\n';
      html += '</button>\n';
      html += '</div>\n';
      html += '<div class="modal-body d-flex flex-row">\n';

      html += '<div style="flex: 1; border-right: 1px solid #dee2e6; padding-right: 20px;">\n';
      html += '<ul>\n';
      html += '<h4>Información</h4>\n';
      html += '<li><strong>Id del producto:</strong> '+datos[boton_inicio]['id']+'</li>\n';
      html += '<li><strong>Stock:</strong> '+datos[boton_inicio]['stock']+'</li>\n';
      html += '<li><strong>Precio:</strong> '+datos[boton_inicio]['sale_price']+'$</li>\n';
      html += '<li><strong>Precio Sugerido:</strong> '+datos[boton_inicio]['suggested_price']+'$</li>\n';
      html += '<li><strong>Peso:</strong> '+datos[boton_inicio]['weight']+' g</li>\n';
      html += '<li><strong>Proveedor:</strong> '+info_proveedor['name']+'</li>\n';
      html += '</ul>\n';
      html += '<ul>\n';
      html += '<h4>Dimensiones</h4>\n';
      if (datos[boton_inicio]['length'] === '0.00'){
        html += '<li><strong>Longitud:</strong> No hay registro de longitud</li>\n';
      }else{
        html += '<li><strong>Longitud:</strong> '+datos[boton_inicio]['length']+'</li>\n';
      }
      if (datos[boton_inicio]['width'] === '0.00'){
        html += '<li><strong>Ancho:</strong> No hay registro de ancho</li>\n';
      }else{
        html += '<li><strong>Ancho:</strong> '+datos[boton_inicio]['width']+'</li>\n';
      }
      if (datos[boton_inicio]['height'] === '0.00'){
        html += '<li><strong>Altura:</strong> No hay registro de altura</li>\n';
      }else{
        html += '<li><strong>Altura:</strong> '+datos[boton_inicio]['height']+'</li>\n';
      }
      html += '</ul>\n';
      html += '</div>\n';
      //imagen
      html += '<div style="flex: 1; display: flex; justify-content: center; align-items: center; padding-left: 20px;">\n';
      html += '<div class="view overlay">\n';
      html += '<img class="card-img-top" width="150px" height="180px" src="'+url_img+'">\n';
      html += '</div>\n';
      html += '</div>\n';
      //final de imagen
      html += '</div>\n';
      html += '<div class="modal-footer">\n';
      html += '<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>\n';
      html += '</div>\n';
      html += '</div>\n';
      html += '</div>\n';
      html += '</div>\n';
      return html;
}

function paginacion_productos_dropi(filtro){
    // Determina las páginas a mostrar basadas en la página actual
    const inicio = Math.max(0, indice - Math.ceil(paginasAMostrar / 2));
    const fin = Math.min(filtro, inicio + paginasAMostrar);
    let li_paginator = '';
    let back_paginator = '';
    let next_paginator = ''
    filtro+=1;
    const paginadorUl = document.querySelector('.pagination')
    back_paginator += '<li class="page-item back_paginator" style="background: white">\n';
    back_paginator += `<a class="page-link" onclick="previus('${filtro}')" aria-label="Previous">\n`;
    back_paginator += '<span aria-hidden="true">&laquo;</span>\n';
    back_paginator += '<span class="sr-only">Previous</span>\n';
    back_paginator += '</a>\n';
    back_paginator += '</li>\n';
    $('.back_d').html(back_paginator);

    console.log(filtro)
    for (var i=1; i<filtro;i++){
      console.log("i")
      li_paginator += `<li class="page-item" onclick="card_productos('${q}',${i})"><a class="page-link">${i}</a></li>\n`;
    }
    $('.pagination').html(li_paginator);

    next_paginator += '<li class="page-item next_paginator" style="background: white">\n';
    next_paginator += `<a class="page-link" onclick="next('${filtro}')" aria-label="Next">\n`;
    next_paginator += '<span aria-hidden="true">&raquo;</span>\n';
    next_paginator += '<span class="sr-only">Next</span>\n';
    next_paginator += '</a>\n';
    next_paginator += '</li>\n';
    $('.next_d').html(next_paginator);

    const flechaDerecha = document.querySelector('.next_paginator');
    const flechaIzquierda = document.querySelector('.back_paginator');
    // Oculta todas las páginas primero
    Array.from(paginadorUl.children).forEach(li => li.style.display = 'none');

    for (let i = inicio; i < fin; i++) {
      paginadorUl.children[i].style.display = 'inline-block';
    }
    
    // Ajuste de visibilidad de las flechas
    flechaIzquierda.style.display = indice > 1 ? 'inline-block' : 'none';
    flechaDerecha.style.display = indice < filtro-1 ? 'inline-block' : 'none';

    // Resaltar la página actual
    document.querySelectorAll('.pagination li a').forEach(a => a.classList.remove('pagina-actual'));
    document.querySelector(`.pagination li:nth-child(${indice}) a`).classList.add('pagina-actual');
}

function previus(){
  if (indice != 1)
  card_productos(q,indice-1);
  paginacion_productos_dropi();

}

function next(){
  if (indice <= limite){
  card_productos(q,indice+1);
  paginacion_productos_dropi()
  }
}

function importar(dato_importar){
  var url_productos = location.origin + "/sysadmin/vistas/html/productos.php";
  var url_datos_new = location.origin + "/sysadmin/vistas/json/datos_dropi_new.json";
  fetch(url_datos_new)
  .then(response => response.json())
  .then(data => {
  var url_origen = location.origin + "/sysadmin/vistas/ajax/importar_dropi.php";
  var info = data
  console.log(info)
  info = info[dato_importar];
  var jsonData = JSON.stringify(info);

  $.ajax({
    url: url_origen,
    method: 'POST',
    data: {info: jsonData},
    success: function(response) {
      console.log('Datos enviados correctamente');
      console.log('Respuesta del servidor:', response);
      window.location.href = url_productos;
    },
    error: function(xhr, status, error) {
      console.error('Error al enviar datos:', error);
    }
  });
})
}

function buscar_producto(){
  if ((q === '') || (q === null)){
    if (id_producto_dropi !== null){
      var url_guardar_productos = location.origin + "/sysadmin/vistas/json/datos_dropi_new.json";

      fetch(url_guardar_productos)
      .then(response => response.json()) // Convierte la respuesta en JSON
      .then(data => {
      let resultadoFind = data.find(datas => datas.id === id_producto_dropi);

      console.log(resultadoFind);
      id_producto_dropi = null;


  })
  .catch(error => console.error('Hubo un error al cargar el JSON:', error));
    }
  }
}


function cargar_datos_storage(){
  var destino_url = "https://api.dropi.ec/api/products/index";
  $.ajax({
    url: destino_url,
    type: "POST",
    headers:{
      'Content-Type': 'application/json',
      'Authorization' : 'Bearer ' + localStorage.getItem('dropi_token'),
    },
    data: JSON.stringify({
    }),
    success: function (data) {
      data = data['objects'];
      var url_guardar_productos = location.origin + "/sysadmin/vistas/ajax/guardar_datos_dropi.php";
      fetch(url_guardar_productos, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
      })
      .then(response => {
        if (!response.ok) {
          throw new Error('Error al enviar los datos al servidor');
        }
        return response.json();
      })
      .then(response => {
        console.log('Datos guardados correctamente en el servidor:', response);
        const fechaActualTexto = new Date().toLocaleDateString();
        if(localStorage.getItem('fecha_datos_dropi') === null){
        localStorage.setItem('fecha_datos_dropi', fechaActualTexto)
        }
      }).catch(error => {
        console.error('Error al realizar la solicitud:', error);
      });
      
      //localStorage.setItem('data_dropi',JSON.stringify(data))
    },
  });
}

const isEmpty = (str) => (!str?.length);
