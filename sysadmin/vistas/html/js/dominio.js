const dominio = (e) => {
  e.preventDefault();
  const dominioActual = window.location.origin + "/";
  const dominio = document.getElementById("dominio").value;
  const nombre = document.getElementById("nombre").value;
  const formData = new FormData();
  formData.append("dominio", dominio);
  formData.append("nombre", nombre);
  fetch(dominioActual + "sysadmin/vistas/html/dominio.php", {
    method: "POST",
    body: formData,
  }).then((response) => {
    response.json().then((data) => {
      if (data === "ok_ok_ok") {
        Swal.fire({
          title: "¡Dominio actualizado!",
          icon: "success",
          confirmButtonText: "¡Aceptar!",
        }).then(() => {
          window.location.reload();
        });
      } else {
        Swal.fire({
          title: "¡Error al actualizar el dominio!",
          icon: "error",
          confirmButtonText: "¡Aceptar!",
        });
      }
    });
  });
};
document.querySelector("#dominioForm").addEventListener("submit", dominio);
