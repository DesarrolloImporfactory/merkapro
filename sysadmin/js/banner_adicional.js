$(document).ready(function () {
  load(1);
});

function load(page) {
  var q = $("#q").val();
  $("#loader").fadeIn("slow");
  $.ajax({
    url: "../ajax/buscar_banner.php?action=ajax&page=" + page + "&q=" + q,
    beforeSend: function (objeto) {
      $("#loader").html('<img src="../../img/ajax-loader.gif"> Cargando...');
    },
    success: function (data) {
      $(".outer_div").html(data).fadeIn("slow");
      $("#loader").html("");
      $('[data-toggle="tooltip"]').tooltip({
        html: true,
      });
    },
  });
}
$("#guardar_linea2").submit(function (event) {
  $("#guardar_datos2").attr("disabled", true);
  var parametros = $(this).serialize();
  $.ajax({
    type: "POST",
    url: "../ajax/nuevo_banner.php",
    data: parametros,
    beforeSend: function (objeto) {
      $("#resultados_ajax").html(
        '<img src="../../img/ajax-loader.gif"> Cargando...'
      );
    },
    success: function (datos) {
      $("#resultados_ajax").html(datos);
      $("#guardar_datos2").attr("disabled", false);
      load(1);
      //resetea el formulario
      $("#guardar_linea2")[0].reset();
      //$("#nombre").focus();
      //desaparecer la alerta
      window.setTimeout(function () {
        $(".alert")
          .fadeTo(200, 0)
          .slideUp(200, function () {
            $(this).remove();
          });
      }, 2000);
    },
  });
  event.preventDefault();
});
$("#editar_linea").submit(function (event) {
  $("#actualizar_datos").attr("disabled", true);
  var parametros = $(this).serialize();
  $.ajax({
    type: "POST",
    url: "../ajax/editar_banner.php",
    data: parametros,
    beforeSend: function (objeto) {
      $("#resultados_ajax2").html(
        '<img src="../../img/ajax-loader.gif"> Cargando...'
      );
    },
    success: function (datos) {
      $("#resultados_ajax2").html(datos);
      $("#actualizar_datos").attr("disabled", false);
      load(1);
      //desaparecer la alerta
      window.setTimeout(function () {
        $(".alert")
          .fadeTo(200, 0)
          .slideUp(200, function () {
            $(this).remove();
          });
      }, 2000);
    },
  });
  event.preventDefault();
});

$("#dataDelete2").on("show.bs.modal", function (event) {
  var button = $(event.relatedTarget); // Botón que activó el modal
  var id = button.data("id"); // Extraer la información de atributos de datos
  var modal = $(this);
  modal.find("#mod_id").val(id);
});
$("#eliminarDatos2").submit(function (event) {
  var parametros = $(this).serialize();
  $.ajax({
    type: "POST",
    url: "../ajax/eliminar_banner.php",
    data: parametros,
    beforeSend: function (objeto) {
      $(".datos_ajax_delete").html(
        '<img src="../../img/ajax-loader.gif"> Cargando...'
      );
    },
    success: function (datos) {
      $(".datos_ajax_delete").html(datos);
      $("#dataDelete2").modal("hide");
      load(1);
      //desaparecer la alerta
      window.setTimeout(function () {
        $(".alert")
          .fadeTo(200, 0)
          .slideUp(200, function () {
            $(this).remove();
          });
      }, 2000);
    },
  });
  event.preventDefault();
});

function obtener_datos_banner(id) {
  var titulo = $("#titulo" + id).val();
  var texto_banner = $("#texto_banner" + id).val();
  var texto_boton = $("#texto_boton" + id).val();
  var enlace_boton = $("#enlace_boton" + id).val();
  var alineacion = $("#alineacion" + id).val();
  //var posicion = $("#posicion" + id).val();

  // alert(id)

  $("#titulo_slider2").val(titulo);
  $("#texto_slider2").val(texto_banner);
  $("#texto_btn_slider2").val(texto_boton);
  $("#enlace_btn_slider2").val(enlace_boton);
  $("#alineacion").val(alineacion);
  //$("#mod_posicion").val(posicion);
  $("#mod_id_banner").val(id);

  // Preparar datos para enviar
  var datosParaEnviar = {
    id: id,
    titulo: titulo,
    texto_banner: texto_banner,
    texto_boton: texto_boton,
    enlace_boton: enlace_boton,
    alineacion: alineacion
};
  // Llamada AJAX
  $.ajax({
    type: "POST",
    url: "../ajax/editar_banner_modal.php", // Asegúrate de reemplazar 'tu_archivo_destino.php' por la ruta correcta a tu archivo PHP
    data: datosParaEnviar,
    success: function (response) {
        $("#editar_linea").html(response);

    },
    error: function (xhr, status, error) {
      // Aquí puedes manejar errores durante el envío.
      console.error("Error al enviar los datos: ", error);
    },
  });
}
