async function validateLogin() {
    const userid = document.getElementById('username').value;
    const password = document.getElementById('password').value;

    let body = {
        'pass': password,
        'id_usuario': userid
    }

    const loginResponse = await fetchPOSTLogin(body);
    if (loginResponse.status == 200) {
        alert('Inicio de sesion exitoso')
        fetchGETLogin(userid);
    } else {
        alert('Inicio de sesion fallado');
    }


}

async function fetchGETLogin(user_id) {
    const url = `http://api.itchiisii.com/?columnas=tipo_usuario&table=usuarios&linkTo=id_usuario&operadorRelTo==&valueTo=${user_id}`

    const query = await fetch(url)
        .then(response => response.json())
        .catch((error) => console.log('Ha ocurrido un error: ', error));
    console.log(query)
    const { datos } = query;
    const { tipo_usuario } = datos[0];
    
    if (tipo_usuario == 'administrador') {
        console.log('entro')
        window.location.href = `http://itchiisii.com/src/html/admin-view.html?id_usuario=${user_id}`
    }else{
        window.location.href = `http://itchiisii.com/src/html/aspirant-view.html?id_usuario=${user_id}`
    }

}

async function fetchPOSTLogin(body) {
    const url = 'http://api.itchiisii.com/?login=true&table=usuarios'
    const query = await fetch(url,
        {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(body)
        }).then(
            response => response.json()
        ).catch(error => console.log('Error en fetch login', error));
    return query;
}

document.addEventListener('DOMContentLoaded',()=>{
    document.getElementById('iniciarSesion').addEventListener('click', ()=>{
        validateLogin()
    });
})