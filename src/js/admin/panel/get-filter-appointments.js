async function getAppointmentsWithFilter(filterDate) {
    try {
        const url = `/api/admin/appointment?filtro-fecha=${filterDate}`;
        const resultado = await fetch(url);

        if (!resultado.ok) {
            throw new Error(`HTTP error! status: ${resultado.status}`);
        }

        return await resultado.json();

    } catch (e) {
        console.error('Error fetching appointments:', e);
        return []; // Retornar un array vacío en caso de error
    }
}

export default getAppointmentsWithFilter;
