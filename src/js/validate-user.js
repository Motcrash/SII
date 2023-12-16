const fetchCurrentAspirantData = async () => {

    const numEstudiante = new URLSearchParams(window.location.search).get('aspirante');
    const getCurrentAspirant = await fetch(
        `http://api.itchiisii.com/?columnas=*&table=aspirantes&linkTo=id_aspirante&operadorRelTo==&valueTo=${numEstudiante}`
    ).then(response => response.json())
        .catch((error) => console.log('Ha ocurrido un error: ', error));

    const { datos } = getCurrentAspirant;

    const {
        nombre_aspirante,
        ap_aspirante,
        am_aspirante,
        curp_aspirante,
        fechanac_aspirante,
        sexo_aspirante,
        nacionalidad_aspirante,
        entnac_aspirante,
        carrera_aspirante,
        entdom_aspirante,
        mundom_aspirante,
        cp_aspirante,
        coldom_aspirante,
        caldom_aspirante,
        numdom_aspirante,
        email_aspirante,
        telcel_aspirante,
        telfijo_aspirante,
        entprep_aspirante,
        munprep_aspirante,
        escuela_aspirante,
        aegreso_aspirante,
        promedio_aspirante,
        estatus_aspirante
    } = datos[0];

    const checkMessage = document.querySelector('.welcome-message');
    checkMessage.innerHTML = `Estás revisando al Aspirante con el número ${numEstudiante}`

    const paterno = document.getElementById('paterno');
    paterno.value = `${ap_aspirante}`;
    const materno = document.getElementById('materno');
    materno.value = `${am_aspirante}`;
    const nombre = document.getElementById('nombre');
    nombre.value = `${nombre_aspirante}`;
    const curp = document.getElementById('curp');
    curp.value = `${curp_aspirante}`
    const fechaNac = document.getElementById('fechaNac');
    fechaNac.value = `${fechanac_aspirante}`;
    const sexo = document.getElementById('sexo');
    sexo.value = `${sexo_aspirante}`;
    const nacionalidad = document.getElementById('nacionalidad')
    nacionalidad.value = `${nacionalidad_aspirante}`;
    const entnac = document.getElementById('entnac');
    entnac.value = `${entnac_aspirante}`;
    const carrera = document.getElementById('carrera');
    carrera.value = `${carrera_aspirante}`
    document.getElementById('entdom').value = `${entdom_aspirante}`;
    document.getElementById('mundom').value = `${mundom_aspirante}`;
    document.getElementById('cp').value = `${cp_aspirante}`;
    document.getElementById('coldom').value = `${coldom_aspirante}`;
    document.getElementById('caldom').value = `${caldom_aspirante}`;
    document.getElementById('numdom').value = `${numdom_aspirante}`;
    document.getElementById('email').value = `${email_aspirante}`;
    document.getElementById('telcel').value = `${telcel_aspirante}`;
    document.getElementById('telfijo').value = `${telfijo_aspirante}`;
    document.getElementById('entprep').value = `${entprep_aspirante}`;
    document.getElementById('munprep').value = `${munprep_aspirante}`;
    document.getElementById('escuela').value = `${escuela_aspirante}`;
    document.getElementById('aegreso').value = `${aegreso_aspirante}`;
    document.getElementById('promedio').value = `${promedio_aspirante}`;

    const aceptarBtn = document.getElementById('aceptarAspirante');

    aceptarBtn.addEventListener('click', () => {
        const verificacion = document.getElementById('aspiranteValido').checked;
        if (verificacion) {
            let body = {
                estatus_aspirante: 1
            };
            putFetch('http://api.itchiisii.com/?table=aspirantes', body, numEstudiante)
            alert('Aspirante aprobado con exito');
            window.location.href = 'admin-view.html';
        } else {
            alert('Marca la casilla para confirmar que el aspirante esta correctamente verificado');
        }
    });

    const rechazarBtn = document.getElementById('rechazarAspirante');
    rechazarBtn.addEventListener('click', () => {

        if (confirm("¿Estás seguro de rechazar a este aspirante?") == true) {

            let body = {
                estatus_aspirante: 2
            };
            putFetch('http://api.itchiisii.com/?table=aspirantes', body, numEstudiante)
            alert('Aspirante rechazado con exito');
            window.location.href = 'admin-view.html' 
        }
    })
}

async function putFetch(url, body, valor) {
    const query = fetch(url, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'id': 'id_aspirante',
            'idValor': valor
        },
        body: JSON.stringify(body)
    }).then(res => res.json());

    console.log(query);
    return query;
}