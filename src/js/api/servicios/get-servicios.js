async function consultarAPI() {
    try {
        const url = `/api/servicios`;
        const resultado = await fetch(url);

        if (!resultado.ok) {
            throw new Error(`HTTP error! status: ${resultado.status}`);
        }

        return await resultado.json();
        
    } catch (e) {
        console.log(e);
    }
}

export default consultarAPI;