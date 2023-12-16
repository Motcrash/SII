const fillPendientAspirantsTable = async () => {

    const getPendientAspirants = await fetch('http://api.itchiisii.com/?columnas=id_aspirante,nombre_aspirante,ap_aspirante,am_aspirante&table=aspirantes&linkTo=estatus_aspirante&operadorRelTo==&valueTo=0')
        .then(response => response.json())
        .catch((error) => console.log('Ha ocurrido un error: ', error));

    const { datos: aspirantes } = getPendientAspirants;

    const mensajePendientes = document.getElementById('numAspirantes');


    if (aspirantes && aspirantes.length > 0) {
        const tableBody = document.getElementById('aspirantesPendientes');

        aspirantes.forEach(aspirante => {

            const {
                id_aspirante,
                nombre_aspirante,
                ap_aspirante,
                am_aspirante
            } = aspirante;

            const nombreCompleto = `${nombre_aspirante} ${ap_aspirante} ${am_aspirante}`;

            const fila = document.createElement('tr');
            const containerNumControl = document.createElement('td');
            const linkAspirante = document.createElement('a');
            linkAspirante.href = `user-validate.html?aspirante=${id_aspirante}`;
            linkAspirante.innerText = `${id_aspirante}`;
            containerNumControl.appendChild(linkAspirante);
            const containerNombre = document.createElement('td');
            containerNombre.innerText = `${nombreCompleto}`;

            fila.appendChild(containerNumControl);
            fila.appendChild(containerNombre);

            tableBody.appendChild(fila);

        }
        )
        mensajePendientes.innerText = `El dia de hoy tienes un total de ${aspirantes.length} aspirantes a comprobar documentación.`
    } else {
        mensajePendientes.innerText = `El dia de hoy tienes un total de 0 aspirantes a comprobar documentación.`;
    }
};

const fillApprovedAspirantsTable = async () => {

    const getApprovedAspirants = await fetch('http://api.itchiisii.com/?columnas=id_aspirante,nombre_aspirante,ap_aspirante,am_aspirante&table=aspirantes&linkTo=estatus_aspirante&operadorRelTo==&valueTo=1')
        .then(response => response.json())
        .catch((error) => console.log('Ha ocurrido un error: ', error));

    const { datos: aspirantes } = getApprovedAspirants;



    if (aspirantes && aspirantes.length > 0) {
        const tableBody = document.getElementById('approvedAspirants');

        aspirantes.forEach(aspirante => {

            const {
                id_aspirante,
                nombre_aspirante,
                ap_aspirante,
                am_aspirante
            } = aspirante;

            const nombreCompleto = `${nombre_aspirante} ${ap_aspirante} ${am_aspirante}`;

            const fila = document.createElement('tr');
            const containerNumControl = document.createElement('td');           
            containerNumControl.innerText = `${id_aspirante}`;            
            const containerNombre = document.createElement('td');
            containerNombre.innerText = `${nombreCompleto}`;

            fila.appendChild(containerNumControl);
            fila.appendChild(containerNombre);

            tableBody.appendChild(fila);

        }
        )
    }
};