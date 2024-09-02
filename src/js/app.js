import consultarAPI from './api/servicios/get-servicios.js';
import { mostrarServicios,idCliente, nombreCliente, seleccionarFecha, seleccionarHora, mostrarResumen } from './api/citas/ui.js';

let paso = 1;
const pasoInicial = 1;
const pasoFinal = 3;


document.addEventListener('DOMContentLoaded', function () {
    iniciarApp();
});

async function iniciarApp() {
    mostrarSeccion(); //muestra y oculta las secciones del index
    tabs(); // cambia la seccin cuando se presionan los tabs
    botonesPaginador(); //agrega o quita los botones del paginador
    paginaSiguiente();
    paginaAnterior();

    //api 
    const servicios = await consultarAPI();
    mostrarServicios(servicios);

    //llena el objeto de cita
    idCliente() //agrega el id del cliente al objeto de cita
    nombreCliente(); //agrega el nombre del cliente al objeto de cita
    seleccionarFecha(); //agrega la fecha al objeto de cita
    seleccionarHora(); //agrega la hora al objeto de cita

    //muestra el resumen de la cita
    mostrarResumen();
}

function toggleClase(selector, clase, condicion) {
    const elemento = document.querySelector(selector);
    if (elemento) {
        elemento.classList.toggle(clase, condicion);
    }
}

function mostrarSeccion() {
    //ocultar la seccion que tenga la clase de .mostrar
    toggleClase('.mostrar', 'mostrar', false);

    //selecionar la seccion con el paso 
    const pasoSelector = `#paso-${paso}`;
    toggleClase(pasoSelector, 'mostrar', true);

    //quita la clase actual al tab anterior
    toggleClase('.actual', 'actual', false);

    //resalta el boton actual
    const tabActualSelector = `[data-paso="${paso}"]`;
    toggleClase(tabActualSelector, 'actual', true);
}

function tabs() {
    const botones = document.querySelectorAll('.tabs button');

    botones.forEach(boton => {
        boton.addEventListener('click', function (e) {
            paso = parseInt(e.target.dataset.paso);

            mostrarSeccion();
            botonesPaginador();
            mostrarResumen()
        });
    })
}

function botonesPaginador() {
    const backBoton = document.querySelector('#anterior');
    const nextBoton = document.querySelector('#siguiente');

    backBoton.classList.toggle('ocultar', paso === 1);
    nextBoton.classList.toggle('ocultar', paso === 3);

}

function paginaAnterior() {

    const paginaAnterior = document.querySelector('#anterior');

    paginaAnterior.addEventListener('click', function () {

        if (paso <= pasoInicial) return;
        paso--;

        botonesPaginador();
        mostrarSeccion();

    })
}

function paginaSiguiente() {
    const paginaSiguiente = document.querySelector('#siguiente');

    paginaSiguiente.addEventListener('click', function () {

        if (paso >= pasoFinal) return;
        paso++;

        botonesPaginador();
        mostrarSeccion();
        mostrarResumen()

    })
}

