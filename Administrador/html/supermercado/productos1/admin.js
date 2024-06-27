function guardarAlmacenamientoLocal(llave, valor_a_guardar) {
    localStorage.setItem(llave, JSON.stringify(valor_a_guardar));
}

function obtenerAlmacenamientoLocal(llave) {
    const datos = JSON.parse(localStorage.getItem(llave));
    return datos;
}

let productos = obtenerAlmacenamientoLocal('productos') || [];
let mensaje = document.getElementById('mensaje');

//Añadir un producto
document.getElementById("botonAñadir").addEventListener("click", function (event) {
    event.preventDefault();
    let productoAñadir = document.getElementById('productoAñadir').value;
    let valorAñadir = document.getElementById('valorAñadir').value;
    let existenciaAñadir = document.getElementById('existenciaAñadir').value;
    let imagenArchivo = document.getElementById('imagenArchivo').files[0]; // Obtener el archivo de imagen

    let van = true;

    if (productoAñadir === '' || valorAñadir === '' || existenciaAñadir === '' || !imagenArchivo) { // Comprueba si no se seleccionó ningún archivo
        mensaje.classList.add('llenarCampos');
        setTimeout(() => { mensaje.classList.remove('llenarCampos') }, 2500);
        van = false;
    } else {
        for (let i = 0; i < productos.length; i++) {
            if (productos[i].nombre === productoAñadir) {
                mensaje.classList.add('repetidoError');
                setTimeout(() => { mensaje.classList.remove('repetidoError') }, 2500);
                van = false;
                break;
            }
        }
    }

    if (van) {
        const lector = new FileReader();
        lector.onload = function(e) {
            const urlImagen = e.target.result;
            productos.push({
                nombre: productoAñadir,
                valor: valorAñadir,
                existencia: existenciaAñadir,
                urlImagen: urlImagen
            });
            mensaje.classList.add('realizado');
            setTimeout(() => {
                mensaje.classList.remove('realizado');
                window.location.reload();
            }, 1500);
            guardarAlmacenamientoLocal('productos', productos);
        };
        lector.readAsDataURL(imagenArchivo);
    }
});

// Editar
document.getElementById("botonEditar").addEventListener("click", function (event) {
    event.preventDefault();
    let productoEditar = document.getElementById('productoEditar').value;
    let atributoEditar = document.getElementById('atributoEditar').value;
    let nuevoAtributo = document.getElementById('nuevoAtributo').value;
    let van = false;

    if (productoEditar === '' || atributoEditar === '' || nuevoAtributo === '') {
        mensaje.classList.add('llenarCampos');
        setTimeout(() => { mensaje.classList.remove('llenarCampos') }, 2500);
    } else {
        for (let i = 0; i < productos.length; i++) {
            if (productos[i].nombre === productoEditar) {
                productos[i][atributoEditar] = nuevoAtributo;
                van = true;
                break;
            }
        }
        if (van) {
            mensaje.classList.add('realizado');
            setTimeout(() => {
                mensaje.classList.remove('realizado');
                window.location.reload();
            }, 1500);
        } else {
            mensaje.classList.add('noExisteError');
            setTimeout(() => { mensaje.classList.remove('noExsiteError') }, 2500);
        }
        guardarAlmacenamientoLocal('productos', productos);
    }
});

// Eliminar
document.getElementById("botonEliminar").addEventListener("click", function (event) {
    event.preventDefault();
    let productoEliminar = document.getElementById('productoEliminar').value;
    let van = false;

    for (let i = 0; i < productos.length; i++) {
        if (productos[i].nombre === productoEliminar) {
            productos.splice(i, 1);
            van = true;
            break;
        }
    }

    if (!van) {
        mensaje.classList.add('noExsiteError');
        setTimeout(() => { mensaje.classList.remove('noExsiteError') }, 2500);
    } else {
        mensaje.classList.add('realizado');
        setTimeout(() => {
            mensaje.classList.remove('realizado');
            window.location.reload();
        }, 1500);
    }
    guardarAlmacenamientoLocal('productos', productos);
});

// Mostrar productos
window.addEventListener("load", () => {
    const productoEd = document.getElementById('productoEditar');
    const productoEl = document.getElementById('productoEliminar');

    for (let i = 0; i < productos.length; i++) {
        productoEd.innerHTML += `<option>${productos[i].nombre}</option>`;
        productoEl.innerHTML += `<option>${productos[i].nombre}</option>`;
    }

    let mostrarProductos = document.getElementById('mostrarProductos');
    mostrarProductos.innerHTML = '';

    for (let i = 0; i < productos.length; i++) {
        mostrarProductos.innerHTML += `
            <div class="contenedorProductos">
                <img src="${productos[i].urlImagen}">
                <div class="informacion">
                    <p>${productos[i].nombre}</p>
                    <p class="precio"><span>Precio: ${productos[i].valor}$</span></p>
                    Existencia: ${productos[i].existencia}<p></p>
                </div>
            </div>`;
    }
});
