function $(id) {
    return document.querySelector('#' + id);
}

function limpiar(elem) {
    elem.style.border = '';
}

function error(elem, event) {
    elem.style.border = '3px solid #f00';
    elem.focus();
    elem.select();
    elem.addEventListener('keydown', () => {
        limpiar(elem);
    }, false);
    event.preventDefault();
}


function mostrar_clave(id) {
    $('mostrar_clave').addEventListener('change', () => {
        $(id).type = ($(id).type === 'password') ? 'text' : 'password';
    }, false)
}

function validacion(event) {
    var nombre = $('txt_nombre');
    var edad = $('txt_edad');
    var email = $('txt_email');
    var usuario = $('txt_usuario');
    var clave1 = $('txt_clave');
    var clave2 = $('txt_confirmar_clave');
    var condiciones = $('aceptar_condiciones');
    // var clave_cifrada = $('txt_clave_cifrada');
    // var clave_descifrada = $('txt_clave_descifrada');

    if (!nombre.value.match(/^[a-zA-ZÀ-ÿ\s]+$/)) {
        alert('En el nombre solo se permiten letras y espacios');
        error(nombre, event);
        return;
    }

    if (!edad.value.match(/^\d+$/) || parseInt(edad.value) < 18 || parseInt(edad.value) > 100) {
        alert('Ingrese una edad válida (de 18 a 100 edad)');
        error(edad, event);
        return;
    }

    if (!email.value.match(/^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/)) {
        alert('En el correo es necesario contar con caracteres, luego un arroba, seguido de mas caracteres, un punto y luego mas caracteres \nEjemplo: test_21@gmail.com');
        error(email, event);
        return;
    }

    if (!usuario.value.match(/^[a-zA-Z0-9]{5,}/)) {
        alert('El usuario solo puede contar con letras, números, guiones, guiones bajos y puntos');
        error(usuario, event);
        return;
    }

    let regex_clave = /^(?=(.*[0-9]))(?=.*[\!@#$%^&*()\\[\]{}\-_+=~´|:;"'<>,.\/?])(?=.*[a-z])(?=(.*[A-Z]))(?=(.*)).{8,}/;

    if (!clave1.value.match(regex_clave)) {
        alert('La clave debe de combinar letras, al menos un número, al menos un símbolo especial, al menos 8 caracteres');
        error(clave1, event);
        return;
    }

    if (!clave2.value.match(regex_clave)) {
        alert('La clave debe de combinar letras, al menos un número, al menos un símbolo especial, al menos 8 caracteres');
        error(clave2, event);
        return;
    }

    if (clave1.value != clave2.value) {
        alert('Las claves no coinciden');
        error(clave1, event);
        error(clave2, event);
        clave1.addEventListener('keydown', () => {
            limpiar(clave1);
            limpiar(clave2);
        })
        clave2.addEventListener('keydown', () => {
            limpiar(clave1);
            limpiar(clave2);
        })
        return;
    }

    if (!condiciones.checked) {
        alert('Tienes que aceptar las condiciones');
        condiciones.focus();
        event.preventDefault();
        return;
    }

    let clave_cifrada = btoa(clave1.value);
    // let clave_descifrada = atob(clave_cifrada);

    alert(
        `
        Nombre: ${nombre.value}\n
        Edad: ${edad.value}\n
        E-Mail: ${email.value}\n
        Usuario: ${usuario.value}\n
        Clave: ${clave1.value}\n
        Clave cifrada: ${clave_cifrada}
        `
    );
}
let registro = document.querySelector('.btn_registro input[type="submit"]');
registro.addEventListener('click', (event) => {
    validacion(event);
});

let error_alert = document.querySelector('.error');
let success_alert = document.querySelector('.success');
if (error_alert.textContent != '' || success_alert.textContent != '') {
    setTimeout(() => {
        error_alert.textContent = ''
        success_alert.textContent = ''
    }, 3000);
}

mostrar_clave('txt_clave');
mostrar_clave('txt_confirmar_clave');