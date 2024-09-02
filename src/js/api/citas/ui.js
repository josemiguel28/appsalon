import {reservarCita, getCitas} from "./reservar-cita.js";

let cita = {
    'id': '',
    'nombre': '',
    'fecha': '',
    'hora': '',
    'servicios': [],
}

//muestra los servicios desde la API
function mostrarServicios(servicios) {
    servicios.forEach(servicio => {

        const {id, nombre, precio} = servicio;

        const nombreServicio = document.createElement('P');
        nombreServicio.classList.add('nombre-servicio');
        nombreServicio.textContent = nombre;

        const precioServicio = document.createElement('P');
        precioServicio.classList.add('precio-servicio');
        precioServicio.textContent = `$ ${precio}`;

        const servicioDiv = document.createElement('DIV');
        servicioDiv.classList.add('servicio');
        servicioDiv.dataset.idServicio = id;

        //evento cuando el usuario da click en un servicio
        servicioDiv.onclick = function () {
            seleccionarServicio(servicio)
        };

        servicioDiv.appendChild(nombreServicio)
        servicioDiv.appendChild(precioServicio)

        document.querySelector('#servicios').appendChild(servicioDiv);
    })

}

//agrega o elimina los servicios que seleccione el usuario
function seleccionarServicio(selectedService) {
    const {id} = selectedService;
    const {servicios} = cita;
    const divServicio = document.querySelector(`[data-id-servicio="${id}"]`)

    if (servicios.some(agregado => agregado.id === id)) {
        //eliminar el servicio cuando se hace click
        cita.servicios = servicios.filter(agregado => agregado.id !== id);
        divServicio.classList.remove('seleccionado');

    } else {
        //agregar el servicio
        cita.servicios = [...servicios, selectedService]; //agrega los servicios al objeto
        divServicio.classList.add('seleccionado');
    }
}

function idCliente() {
    cita.id = document.querySelector('#idCliente').value;
}
function nombreCliente() {
    cita.nombre = document.querySelector('#nombre').value;
}

function seleccionarFecha() {
    const inputFecha = document.querySelector('#fecha');

    inputFecha.addEventListener('input', function (e) {
        const diaUsuario = new Date(e.target.value).getUTCDay(); // obtiene el dia que selecciono el usuario

        if ([6, 0].includes(diaUsuario)) {
            e.target.value = "";
            mostrarAlerta('Dias de semana no atendemos 😓', 'error', '.formulario');
        } else {
            cita.fecha = e.target.value;
            console.log(cita)
        }
    })
}

function seleccionarHora() {
    const inputHora = document.querySelector('#hora');

    inputHora.addEventListener('input', function (e) {
        const horaUsuario = e.target.value;
        const hora = parseInt(horaUsuario.split(':')[0], 10);

        if (hora < 10 || hora > 18) {
            e.target.value = "";
            mostrarAlerta('Horario de atención: 10:00am - 6:00pm', 'error', '.formulario');
        } else {
            cita.hora = e.target.value;
            console.log(cita)
        }
    });
}

function mostrarResumen() {
    const resumen = document.querySelector('.mostrar-resumen');
    const {nombre, fecha, hora, servicios} = cita;

    //limpiar el contenido del resumen
    while (resumen.firstChild) {
        resumen.removeChild(resumen.firstChild)
    }

    //verifica si el objeto de cita contiene alguna llave vacia
    if (Object.values(cita).includes('') || cita.servicios.length === 0) {
        mostrarAlerta('Faltan datos de la cita 🤔', 'error', '.mostrar-resumen', false);
        return;
    }

    const tituloServicios = document.createElement('H3');
    tituloServicios.textContent = 'Resumen de tus Servicios';
    resumen.appendChild(tituloServicios);

    //iterando sobre cada servicio en el objeto
    servicios.forEach(servicio => {
        const {id, precio, nombre} = servicio;

        const contenedorServicios = document.createElement('DIV');

        contenedorServicios.classList.add('contenedor-servicio')

        const textoServicio = document.createElement('P');
        textoServicio.textContent = nombre

        const precioServicio = document.createElement('P');
        precioServicio.innerHTML = `<span>Precio: </span> ${precio}`;

        contenedorServicios.appendChild(textoServicio);
        contenedorServicios.appendChild(precioServicio)

        resumen.appendChild(contenedorServicios)

    })

    const tituloDatosCliente = document.createElement('H3')
    tituloDatosCliente.textContent = 'Resumen de tu cita';
    resumen.appendChild(tituloDatosCliente);

    const nombreCliente = document.createElement('P')
    nombreCliente.innerHTML = `<span>Nombre: </span> ${nombre}`;

    //formatear la fecha
    const fechaObj = new Date(fecha);
    const mes = fechaObj.getMonth();
    const dia = fechaObj.getDate() + 2; // +2 por el desfase de fechas en js 
    const year = fechaObj.getFullYear();

    const fechaUTC = new Date(Date.UTC(year, mes, dia));

    const opciones = {weekday: 'long', year: 'numeric', month: 'long', day: 'numeric'};
    const fechaFormateada = fechaUTC.toLocaleDateString('es-MX', opciones);

    const fechaCita = document.createElement('P');
    fechaCita.innerHTML = `<span>Fecha: </span> ${fechaFormateada}`;

    const horaCita = document.createElement('P');
    horaCita.innerHTML = `<span>Hora: </span> ${hora} Horas`;


    //boton para crear una cita\
    const botonReservar = document.createElement('BUTTON');
    botonReservar.classList.add('boton');
    botonReservar.style.display = 'block'
    botonReservar.style.marginLeft = 'auto'
    botonReservar.style.marginRight = '0'
    botonReservar.textContent = 'Reservar Cita';
    botonReservar.onclick = async function () {
        const success = await reservarCita(cita);
        
        if (success){
            botonReservar.disabled = true;
            botonReservar.textContent = 'Redirigiendo a la pagina de inicio...'
        }
    };

    resumen.appendChild(nombreCliente)
    resumen.appendChild(fechaCita)
    resumen.appendChild(horaCita)
    resumen.appendChild(botonReservar)
}

function mostrarAlerta(mensaje, tipo, elemento = '.formulario', timeout = true) {
    //previene que se genere mas de una alerta
    const alertaPrevia = document.querySelector('.alerta');
    const alerta = document.createElement('DIV')

    if (alertaPrevia) {
        alertaPrevia.remove();
    }

    alerta.textContent = mensaje;
    alerta.classList.add('alerta')
    alerta.classList.add(tipo)

    document.querySelector(elemento).appendChild(alerta);

    if (timeout) {
        setTimeout(() => {
            alerta.classList.add('ocultar');
            setTimeout(() => {
                alerta.remove()
            }, 1000) // Tiempo de transición en milisegundos
        }, 10000)
    }
}

export {mostrarServicios,idCliente, nombreCliente, seleccionarFecha, seleccionarHora, mostrarResumen};