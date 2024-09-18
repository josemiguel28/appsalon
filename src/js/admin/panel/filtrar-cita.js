document.addEventListener('DOMContentLoaded', function () {
    iniciarApp();
})

function iniciarApp() {
    filtrarCitasPorFecha();
}

function filtrarCitasPorFecha() {
    const fechaInput = document.querySelector("#fecha");

    fechaInput.addEventListener('change', function (e) {
        const fechaSeleccionada = e.target.value;

        // Asegúrate de que la fecha esté en el formato adecuado
        if (fechaSeleccionada) {
            // Actualizar la URL sin recargar la página
            const newUrl = `?filtro-fecha=${encodeURIComponent(fechaSeleccionada)}`;
            history.pushState(null, '', newUrl);
            window.location.reload();
            // Opcionalmente, podrías hacer una solicitud AJAX aquí si deseas actualizar el contenido sin recargar
            // fetch(newUrl)
            //     .then(response => response.text())
            //     .then(data => {
            //         // Actualizar el contenido de la página con los datos recibidos
            //     });
        }
    });
}