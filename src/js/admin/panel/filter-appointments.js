import getAppointmentsWithFilter from "./get-filter-appointments.js";

document.addEventListener('DOMContentLoaded', function () {
    iniciarApp();
});

function iniciarApp() {
    filtrarCitasPorFecha();
}

function filtrarCitasPorFecha() {
    const fechaInput = document.querySelector("#fecha");

    fechaInput.addEventListener('change', async function (e) {
        const fechaSeleccionada = e.target.value;

        if (fechaSeleccionada) {
            const citas = await getAppointmentsWithFilter(fechaSeleccionada);
            actualizarVistaConCitas(citas);
        }
    });
}

// Función para actualizar la vista con las citas
function actualizarVistaConCitas(citas) {
    const citasContainer = document.querySelector(".mostrar-citas");
    citasContainer.innerHTML = ''; // Limpiar el contenedor

    if (citas.length === 0) {
        // Mostrar mensaje si no hay citas
        citasContainer.innerHTML = `
            <p class="no-citas">
                <svg xmlns="http://www.w3.org/2000/svg" width="34" height="34" viewBox="0 0 24 24">
                    <path fill="none" stroke="#cccccc" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 21H6a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v6.5M16 3v4M8 3v4m-4 4h16m2 11l-5-5m0 5l5-5" />
                </svg>
                <span>No hay citas para este día</span>
            </p>
        `;
        return;
    }
    const ul = document.createElement('ul');
    ul.className = 'citas';
    let totalPagar = 0; // Total acumulado
    let idCita = null; // Inicializa como null para detectar el primer caso
    let li = null; // Variable para almacenar el <li> actual

        citas.forEach(cita => {
        // Asegúrate de que cita.precio no es null o undefined
        if (cita.precio == null) {
            console.error(`Precio no válido para la cita con ID ${cita.id}`);
            return;
        }
    
        // Asegúrate de que cita.precio es un número
        const precioServicio = parseFloat(cita.precio.toString().replace(/[^0-9.-]+/g, ""));
    
        // Verifica si estamos en una nueva cita
        if (idCita !== cita.id) {
            // Si ya hay una cita anterior, añade el total
            if (li) {
                const totalElement = document.createElement('h3');
                totalElement.className = 'total__pagar';
                totalElement.innerHTML = `Total a pagar <span id="total">${number_format(totalPagar, 2)} L</span>`;
                li.appendChild(totalElement);
            }
    
            // Reiniciar el total para la nueva cita
            totalPagar = 0;
    
            // Crea un nuevo <li> para la nueva cita
            li = document.createElement('li');
            li.innerHTML = `
                <p>ID: <span>${htmlspecialchars(cita.id)}</span></p>
                <p>Hora: <span>${htmlspecialchars(cita.hora)}</span></p>
                <p>Fecha: <span>${htmlspecialchars(cita.fecha)}</span></p>
                <p>Cliente: <span>${htmlspecialchars(cita.cliente)}</span></p>
                <p>E-mail: <span>${htmlspecialchars(cita.email)}</span></p>
                <p>Teléfono: <span>${htmlspecialchars(cita.telefono)}</span></p>
                <h3>Servicios</h3>
            `;
            ul.appendChild(li);
    
            // Establece el ID de la cita actual
            idCita = cita.id;
        }
    
        // Agregar el servicio y el precio al total
        const servicioElement = document.createElement('p');
        servicioElement.className = 'servicio';
        servicioElement.innerHTML = `&#10003; ${htmlspecialchars(cita.servicio)} ${number_format(precioServicio, 2)} L`;
        li.appendChild(servicioElement);
    
        // Acumular el precio del servicio
        totalPagar += precioServicio; // Asegúrate de acumular aquí también
    });

    // Al final, asegúrate de añadir el total de la última cita
    if (totalPagar > 0 && li) {
        const totalElement = document.createElement('h3');
        totalElement.className = 'total__pagar';
        totalElement.innerHTML = `Total a pagar <span id="total">${number_format(totalPagar, 2)} L</span>`;
        li.appendChild(totalElement);
    }

    citasContainer.appendChild(ul);
}

// Función auxiliar para escapar HTML (simulando htmlspecialchars)
function htmlspecialchars(str) {
    const div = document.createElement('div');
    div.innerText = str;
    return div.innerHTML;
}

// Función auxiliar para formatear números (simulando number_format)
function number_format(number, decimals = 2) {
    return parseFloat(number).toFixed(decimals);
}
