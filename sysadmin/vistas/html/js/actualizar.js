const actualizar = () => {
  const dominio = window.location.origin + "/";
  Swal.fire({
    title: "¿Estás seguro?",
    text: "¡Se actualizará el sistema!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonText: "¡Sí, actualizar!",
    cancelButtonText: "¡No, cancelar!",
    reverseButtons: true,
    showLoaderOnConfirm: true,
    preConfirm: async () => {
      const responseAS = await fetch(
        dominio + "actualizacion_sistema291123.php",
        {
          method: "GET",
          headers: {
            "Content-Type": "application/json",
          },
        }
      );
      responseAS.json().then((data) => {
        if (data === "ok") {
          Swal.fire({
            title: "¡Actualización del sistema exitosa!",
            icon: "success",
            text: "¡Pulse click en siguiente y espere mientras la base de datos se actualiza!",
            confirmButtonText: "¡Siguiente!",
            showCancelButton: false,
            showLoaderOnConfirm: true,
            preConfirm: async () => {
              const responseAS = await fetch(dominio + "db_update291123.php", {
                method: "GET",
                headers: {
                  "Content-Type": "application/json",
                },
              });
              responseAS.json().then((data) => {
                if (data === "ok") {
                  Swal.fire({
                    title: "¡Actualización de la base de datos exitosa!",
                    icon: "success",
                    confirmButtonText: "¡Aceptar!",
                  }).then(() => {
                    window.location.reload();
                  });
                }
              });
            },
          });
        }
      });
    },
  });
};
