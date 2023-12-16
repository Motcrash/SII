async function fetchPOSTAspirant(url,body) {
    const query = fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',        
        },
        body: JSON.stringify(body)
    }).then(res => res.json());
    console.log(query);
    return query;
}

async function enviarDatos() {

    const id_usuario = new URLSearchParams(window.location.search).get('id_usuario');

    const paterno = document.getElementById('paterno').value;
    const materno = document.getElementById('materno').value;
    const nombre = document.getElementById('nombre').value;
    const curp = document.getElementById('curp').value;
    const fechaNac = document.getElementById('fechaNac').value;
    const sexo = document.getElementById('sexo').value;
    const nacionalidad = document.getElementById('nacionalidad').value
    const entnac = document.getElementById('entnac').value;
    const carrera = document.getElementById('carrera').value;
    const entdom = document.getElementById('entdom').value;
    const mundom = document.getElementById('mundom').value;
    const cp = document.getElementById('cp').value;
    const coldom = document.getElementById('coldom').value;
    const caldom = document.getElementById('caldom').value;
    const numdom = document.getElementById('numdom').value;
    const email = document.getElementById('email').value;
    const telcel = document.getElementById('telcel').value;
    const telfijo = document.getElementById('telfijo').value;
    const entprep = document.getElementById('entprep').value;
    const munprep = document.getElementById('munprep').value;
    const escuela = document.getElementById('escuela').value;
    const aegreso = document.getElementById('aegreso').value;
    const promedio = document.getElementById('promedio').value;

    let body={
        'nombre_aspirante':nombre,
        'ap_aspirante':paterno,
        'am_aspirante':materno,
        'curp_aspirante':curp,
        'fechanac_aspirante':fechaNac,
        'sexo_aspirante':sexo,
        "nacionalidad_aspirante":nacionalidad,
        'entnac_aspirante':entnac,
        'carrera_aspirante':carrera,
        'entdom_aspirante':entdom,
        'mundom_aspirante':mundom,
        'coldom_aspirante':coldom,
        'caldom_aspirante':caldom,
        'numdom_aspirante':numdom,
        'cp_aspirante':cp,
        'email_aspirante':email,
        'telcel_aspirante':telcel,
        'telfijo_aspirante':telfijo,
        'entprep_aspirante':entprep,
        'munprep_aspirante':munprep,
        'escuela_aspirante':escuela,
        'aegreso_aspirante':aegreso,
        'promedio_aspirante':promedio,
        'estatus_aspirante':0,
        'id_usuario':id_usuario
    }
    console.log(body)
    const query = await fetchPOSTAspirant('http://api.itchiisii.com/?table=aspirantes', body);
    console.log(query)
    if(query.status==200){
        alert('Tus datos han sidos enviado para revision con exito, se cerrara tu sesion');
        window.location.href = 'http://itchiisii.com'
    }
}

function recibirValidacion(){
    const submitBtn = document.getElementById('envioDatos');
    submitBtn.addEventListener('click',()=>{
        enviarDatos();
    })
}