$(document).ready(function () {
  load(1);
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
  var numero = $("#numero_q").val();
  var url = "";
  if (numero != 0) {
    url =
      "../ajax/buscar_solicitudes.php?action=ajax&page=" +
      page +
      "&q=" +
      q +
      "&numero=" +
      numero;
  } else {
    url = "../ajax/buscar_solicitudes.php?action=ajax&page=" + page + "&q=" + q;
  }
  $("#loader").fadeIn("slow");
  $.ajax({
    url: url,
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

function buscar(tienda) {
  // alert(tienda)
  var q = $("#q").val();
  var numero = $("#numero_q").val();
  if (tienda == 0) {
    tienda = "";
  }
  if (numero == 0) {
    numero = "";
  }
  page = 1;
  $("#loader").fadeIn("slow");
  $.ajax({
    url:
      "../ajax/buscar_solicitudes.php?action=ajax&page=" +
      page +
      "&tienda=" +
      tienda +
      "&q=" +
      q +
      "&numero=" +
      numero,
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
    url: "../ajax/eliminar_factura.php",
    data: parametros,
    beforeSend: function (objeto) {
      $(".datos_ajax_delete").html(
        '<img src="../../img/ajax-loader.gif"> Cargando...'
      );
    },
    success: function (datos) {
      $(".datos_ajax_delete").html(datos);
      $("#dataDelete").modal("hide");
      //desaparecer la alerta
      $(".alert-success")
        .delay(400)
        .show(10, function () {
          $(this)
            .delay(2000)
            .hide(10, function () {
              $(this).remove();
            });
        }); // /.alert
      load(1);
    },
  });
  event.preventDefault();
});

function buscar_numero(numero) {
  // alert(tienda)
  var q = $("#q").val();

  if (numero == 0) {
    numero = "";
  }

  page = 1;
  $("#loader").fadeIn("slow");
  $.ajax({
    url:
      "../ajax/buscar_solicitudes.php?action=ajax&page=" +
      page +
      "&numero=" +
      numero +
      "&q=" +
      q,
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

function eliminar_solicitud(id) {
  Swal.fire({
    title: "¿Estás seguro?",
    text: "¡No podrás revertir esto!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",

    confirmButtonText: "Si, eliminar!",
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: "../ajax/eliminar_solicitud.php",
        type: "POST",
        dataType: "html",
        data: { id: id },
        success: function (data) {
          Swal.fire({
            title: "Eliminado!",
            text: "La solicitud ha sido eliminada.",
            icon: "success",
            showConfirmButton: false,
            timer: 1500,
          });
          load(1);
        },
      });
    }
  });
}

function visto(id) {
  $.ajax({
    url: "../ajax/visto_solicitud.php",
    type: "POST",
    dataType: "html",
    data: { id: id },
    success: function (data) {
      load(1);
    },
  });
}
