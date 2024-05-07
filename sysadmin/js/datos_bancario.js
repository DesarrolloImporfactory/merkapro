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
    url: "../ajax/buscar_datos_b.php?action=ajax&page=" + page + "&q=" + q,
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

const enviar_datos_b = (e) => {
  e.preventDefault();
  const nombre = e.target.nombre.value;
  const correo = e.target.correo.value;
  const telefono = e.target.telefono.value;
  const banco = e.target.banco.value;
  const tipo_cuenta = e.target.tipo_cuenta.value;
  const numero_cuenta = e.target.numero_cuenta.value;
  const cedula = e.target.cedula.value;

  // send data to backend
  $.ajax({
    type: "POST",
    url: "../ajax/insertar_datos_b.php",
    data: {
      nombre,
      correo,
      telefono,
      banco,
      tipo_cuenta,
      numero_cuenta,
      cedula,
    },
    beforeSend: function (objeto) {
      $("#resultados_ajax").html(
        '<img src="../../img/ajax-loader.gif"> Cargando...'
      );
    },
    success: function (datos) {
      if (datos == "error") {
        Swal.fire({
          icon: "error",
          title: "Oops...",
          text: "Error al ingresar los datos",
          showConfirmButton: false,
          timer: 1000,
        });
      }
      if (datos == "banco") {
        Swal.fire({
          icon: "error",
          title: "Oops...",
          text: "Ingrese un banco",
          showConfirmButton: false,
          timer: 1000,
        });
      }
      if (datos == "cuenta") {
        Swal.fire({
          icon: "error",
          title: "Oops...",
          text: "Ingrese un tipo de cuenta",
          showConfirmButton: false,
          timer: 1000,
        });
      }
      if (datos == "datos") {
        Swal.fire({
          icon: "success",
          title: "Correcto",
          text: "Datos ingresados correctamente",
          showConfirmButton: false,
          timer: 1000,
        });
        setTimeout(() => {
          load(1);
        }, 2000);
      }
    },
  });
};

const solicitar_pago = (e) => {
  e.preventDefault();

  const tienda = e.target.tienda.value;
  const dinero = e.target.dinero.value;

  // send data to backend
  $.ajax({
    type: "POST",
    url: "../ajax/solicitar_pago.php",
    data: {
      tienda,
      dinero,
    },
    beforeSend: function (objeto) {
      $("#resultados_ajax").html(
        '<img src="../../img/ajax-loader.gif"> Cargando...'
      );
      Swal.fire({
        icon: "info",
        title: "Espere...",
        text: "Estamos procesando su solicitud",
        showConfirmButton: false,
        timer: 2000,
      });
    },
    success: function (datos) {
      if (datos == "error") {
        Swal.fire({
          icon: "error",
          title: "Oops...",
          text: "Error al ingresar los datos",
          showConfirmButton: false,
          timer: 1000,
        });
      }
      if (datos == "datos") {
        Swal.fire({
          icon: "success",
          title: "Correcto",
          text: "Datos ingresados correctamente",
          showConfirmButton: false,
          timer: 1000,
        });
        setTimeout(() => {
          load(1);
        }, 2000);
      }
      if (datos == "dinero") {
        Swal.fire({
          icon: "error",
          title: "Oops...",
          text: "Ingrese un monto",
          showConfirmButton: false,
          timer: 1000,
        });
      }
      if (datos == "mayor") {
        Swal.fire({
          icon: "warning",
          title: "Oops...",
          text: "El monto solicitado es mayor al saldo disponible para su tienda",
          showConfirmButton: false,
          timer: 1000,
        });
      }
      if (datos == "enviado") {
        Swal.fire({
          icon: "success",
          title: "Correcto",
          text: "Solicitud enviada correctamente, por favor antes de enviar otra solicitud espere a que el equipo de contabilidad le de respuesta. \n Los pagos se realizan 24 horas laborales después de la solicitud.",
        }).then((result) => {
          if (result.isConfirmed) {
            location.reload();
          }
        });
      }
    },
  });
};
