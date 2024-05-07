var filtroG = "mayor_menor";
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
  var numero = $("#numero_q").val();
  if (numero != 0) {
    var url =
      "../ajax/buscar_wallet.php?action=ajax&page=" +
      page +
      "&q=" +
      q +
      "&numero=" +
      numero +
      "&filtro=" +
      filtroG;
  } else {
    var url =
      "../ajax/buscar_wallet.php?action=ajax&page=" +
      page +
      "&q=" +
      q +
      "&filtro=" +
      filtroG;
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
      $("#outerpay").load("../ajax/ver_pagos.php");

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
      "../ajax/buscar_wallet.php?action=ajax&page=" +
      page +
      "&numero=" +
      numero +
      "&q=" +
      q +
      "&filtro=" +
      filtroG,

    beforeSend: function (objeto) {
      $("#loader").html('<img src="../../img/ajax-loader.gif"> Cargando...');
    },
    success: function (data) {
      $(".outer_div").html(data).fadeIn("slow");
      $("#loader").html("");
      $('[data-toggle="tooltip"]').tooltip({
        html: true,
      });
      verProveedor();
    },
  });
}

function filtrarRegistros(filtro) {
  var q = $("#q").val();
  var numero = $("#numero_q").val();
  filtroG = filtro;
  if (numero != 0) {
    var url =
      "../ajax/buscar_wallet.php?action=ajax&page=" +
      "&q=" +
      q +
      "&numero=" +
      numero +
      "&filtro=" +
      filtro;
  } else {
    var url =
      "../ajax/buscar_wallet.php?action=ajax&page=" +
      page +
      "&q=" +
      q +
      "&filtro=" +
      filtro;
  }
  $("#loader").fadeIn("slow");
  $.ajax({
    url: url,
    beforeSend: function (objeto) {
      $("#loader").html('<img src="../../img/ajax-loader.gif"> Cargando...');
    },
    success: function (data) {
      $(".outer_div").html(data).fadeIn("slow");
      $("#outerpay").load("../ajax/ver_pagos.php");

      $("#loader").html("");
      $('[data-toggle="tooltip"]').tooltip({
        html: true,
      });
    },
  });
}
function verProveedor() {
  var url = "../ajax/proveedor.php";
  let tienda = "<?php echo $dominio_completo ?>";

  $.ajax({
    url: url,
    type: "POST",
    data: {
      tienda: tienda,
    },
    success: function (response) {
      $("#proveedor").html(response);
    },
  });
}
