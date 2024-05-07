$(document).ready(function () {
  load(1);
});
$("#editar_linea").submit(function (event) {
  // alert();
  $("#actualizar_datos").attr("disabled", true);
  var parametros = $(this).serialize();
  $.ajax({
    type: "POST",
    url: "../ajax/editar_wallet.php",
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
      $("#editarLinea").modal("hide");

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
function load(page) {
  var q = $("#q").val();
  $("#loader").fadeIn("slow");
  $.ajax({
    url: "../ajax/buscar_referidos.php?action=ajax&page=" + page + "&q=" + q,
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
$("#dataDelete").on("show.bs.modal", function (event) {
  var button = $(event.relatedTarget); // Botón que activó el modal
  var id = button.data("id"); // Extraer la información de atributos de datos
  var modal = $(this);
  modal.find("#id_factura").val(id);
});
$("#eliminarDatos").submit(function (event) {
  var parametros = $(this).serialize();
  $.ajax({
    type: "POST",
    url: "../ajax/eliminar_wallet.php",
    data: parametros,
    beforeSend: function (objeto) {
      $("#resultados_ajax").html(
        '<img src="../../img/ajax-loader.gif"> Cargando...'
      );
    },
    success: function (datos) {
      $("#resultados_ajax").html(datos);
      $("#dataDelete").modal("hide");
      load(1);
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

function generar_referido() {
  var dominio = location.origin;
  dominio = String(dominio);

  $.ajax({
    type: "POST",
    url: "../ajax/generar_referido.php",
    contentType: "application/json", // Asegúrate de incluir esta línea si envías JSON
    data: JSON.stringify({ dominio: dominio }),
    success: function (data) {
      if (data == "ok") {
        Swal.fire({
          title: "Enlace generado",
          text: "El enlace de referido se ha generado correctamente",
          type: "success",
          confirmButtonClass: "btn-success",
          confirmButtonText: "Ok",
          closeOnConfirm: false,
        });
      } else {
        Swal.fire({
          title: "Error",
          text: "Ha ocurrido un error al generar el enlace de referido",
          type: "error",
          confirmButtonClass: "btn-danger",
          confirmButtonText: "Ok",
          closeOnConfirm: false,
        });
      }
    },
  });
}
