$(document).ready(function () {
  load(1);
});

function load(page) {
  var q = $("#q").val();
  var estado = $("#estado_q").val();
  var numero = $("#numero_q").val();
  var url = "";

  if (q != "" || estado != "" || numero != "") {
    url =
      "../ajax/buscar_trabajadores.php?action=ajax&page=" +
      page +
      "&q=" +
      q +
      "&estado=" +
      estado +
      "&numero=" +
      numero;
  } else {
    url = "../ajax/buscar_trabajadores.php?action=ajax&page=" + page;
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
  var estado = $("#estado_q").val();
  var numero = $("#numero_q").val();
  if (estado == 0) {
    estado = "";
  }
  if (numero == 0) {
    numero = "";
  }
  page = 1;
  $("#loader").fadeIn("slow");
  $.ajax({
    url:
      "../ajax/buscar_trabajadores.php?action=ajax&page=" +
      page +
      "&q=" +
      q +
      "&estado=" +
      estado +
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

function buscar_numero(numero) {
  // alert(tienda)
  var q = $("#q").val();
  var tienda = $("#tienda_q").val();
  var estado = $("#estado_q").val();

  if (numero == 0) {
    numero = "";
  }
  if (estado == 0) {
    estado = "";
  }

  page = 1;
  $("#loader").fadeIn("slow");
  $.ajax({
    url:
      "../ajax/buscar_trabajadores.php?action=ajax&page=" +
      page +
      "&numero=" +
      numero +
      "&q=" +
      q +
      "&estado=" +
      estado,

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

function buscar_estado(estado) {
  // alert(tienda)
  var q = $("#q").val();
  var numero = $("#numero_q").val();

  if (estado == 0) {
    estado = "";
  }
  if (numero == 0) {
    numero = "";
  }
  page = 1;
  $("#loader").fadeIn("slow");
  $.ajax({
    url:
      "../ajax/buscar_trabajadores.php?action=ajax&page=" +
      page +
      "&estado=" +
      estado +
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
