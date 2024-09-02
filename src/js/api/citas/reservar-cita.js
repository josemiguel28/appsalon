// manda los datos de la cita al servidor
async function reservarCita(cita) {
    const {id, fecha, hora, servicios} = cita;
    //extrae cada id del servicio en el objeto cita
    const idServicio = servicios.map(servicio => servicio.id);

    const datos = new FormData();
    datos.append('usuarioId', id);
    datos.append('fecha', fecha);
    datos.append('hora', hora);
    datos.append('serviciosId', idServicio);

    const url = 'http://localhost:3000/api/citas';

    try {
        //peticion a la api
        const response = await fetch(url, {
            method: 'POST',
            body: datos
        });

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        // Intenta parsear la respuesta como JSON
        try {
            const jsonResponse = await response.json();

            //si la respuesta esta bien, muestra un mensaje de exito
            if (jsonResponse.resultado) {
                Swal.fire({
                    icon: "success",
                    title: "Cita creada",
                    text: "La cita se registro correctamente 😀",
                    bottom: 'OK'
                }).then(() => {
                    setTimeout(() => {
                        window.location.reload();
                    },3000)
                });
                
                return true;
            }
        } catch (jsonError) {
            // Si el parseo falla, maneja el contenido como texto plano
            console.error('JSON parsing error:', jsonError);
            const textResponse = await response.text();
            console.log('Response text:', textResponse);
        }
    } catch (error) {
        console.error('Fetch error:', error);
        //en caso que haya error con la url, muestra un mensaje de error
        Swal.fire({
            icon: "error",
            title: "Oops...",
            text: `Algo salio mal :( intente en otro momento ${error}`,
            bottom: 'OK'
        });
    }
}

//funcion con metodo GET para obtener los mensajes que devuelve el backend
async function getCitas() {

    try {
        const url = 'http://localhost:3000/api/citas';
        const request = await fetch(url);

        if (!request.ok) {
            throw new Error(`HTTP error! status: ${request.status}`);
        }

        return await request.json();

    } catch (e) {
        console.log(e);
    }
}

export {reservarCita, getCitas};