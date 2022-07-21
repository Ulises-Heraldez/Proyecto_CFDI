function $(id) {
    return document.querySelector('#' + id);
}

function mostrar_clave(id) {
    $('mostrar_clave').addEventListener('change', () => {
        $(id).type = ($(id).type === 'password') ? 'text' : 'password';
    }, false)
}

function limpiar(elem) {
    elem.style.border = '';
}

function error(elem, event) {
    elem.style.border = '3px solid #f00';
    elem.focus();
    elem.select();
    elem.addEventListener(
        'keydown',
        () => {
            limpiar(elem);
        },
        false
    );
    event.preventDefault();
}

function validacion(event) {
    var usuario = $('txt_login_user');
    var clave1 = $('txt_login_password');

    if (!usuario.value.match(/^[a-zA-Z0-9]{5,}/)) {
        alert('El usuario debe tener letras y números con una longitud de 5 o más caracteres');
        error(usuario, event);
        return;
    }

}

let login = document.querySelector('.btn_login input[type="submit"]');
login.addEventListener('click', (event) => {
    validacion(event);
});

mostrar_clave('txt_login_password');



