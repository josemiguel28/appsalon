async function consultarAPI() {
    try {
        const url = 'http://localhost:3000/api/servicios';
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