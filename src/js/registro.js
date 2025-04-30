import Swal from 'sweetalert2';

(function() {
    let eventos = [];
    const resumen = document.querySelector('.registro__resumen');
    if(resumen) {
    
    const eventosBoton = document.querySelectorAll('.evento__agregar');
    eventosBoton.forEach(boton => boton.addEventListener('click', seleccionarEvento))
    
    const formularioRegistro = document.querySelector('#registro');
    formularioRegistro.addEventListener('submit', submitFormulario);
    mostrarEventos();

    function seleccionarEvento({target}){
        if(eventos.length < 5) {
             //Deshabilitar el evento
            target.disabled = true;
            eventos = [...eventos, {
                id: target.dataset.id,
                titulo: target.parentElement.querySelector('.evento__nombre').textContent.trim()
            }]
            mostrarEventos();
        } else {
                Swal.fire({
                    icon: "error",
                    title: 'Error',
                    text: 'Máximo 5 eventos por registro',
                    confirmButtonText: 'Ok'
                })
        }

    }

    function mostrarEventos() {
        //Limpiar el HTML
        LimpiarEventos();
        if(eventos.length > 0) {
            eventos.forEach( evento => {
                const eventoDom = document.createElement('DIV');
                eventoDom.classList.add('registro__evento');
                const titulo = document.createElement('H3');
                titulo.classList.add('registro__nombre');
                titulo.textContent = evento.titulo;

                const botonEliminar = document.createElement('BUTTON');
                botonEliminar.classList.add('registro__eliminar');
                botonEliminar.innerHTML = `<i class="fa-solid fa-trash"></i>`
                botonEliminar.onclick = function() {
                    eliminarEvento(evento.id);
                }
                //Renderizar en el html
                eventoDom.appendChild(titulo);
                eventoDom.appendChild(botonEliminar);
                resumen.appendChild(eventoDom);
            });
        } else {
            const noRegistro = document.createElement('P');
            noRegistro.textContent = 'No hay eventos, añade hasta 5 eventos';
            noRegistro.classList.add('registro__texto');
            resumen.appendChild(noRegistro);
        }
    }

    function LimpiarEventos() {
        while(resumen.firstChild) {
            resumen.removeChild(resumen.firstChild);
        }
    }
    function eliminarEvento(id){
        eventos = eventos.filter(evento => evento.id !== id);
        const botonAgregar = document.querySelector(`[data-id="${id}"]`);
        botonAgregar.disabled = false;
        mostrarEventos();
    }
    async function submitFormulario(e){
        e.preventDefault();
        
        //Obtener el regalo
        const regaloId = document.querySelector('#regalo').value;
        const eventosId = eventos.map(evento => evento.id);
        
        if(eventosId.length === 0 || regaloId === '') {
            Swal.fire({
                icon: "error",
                title: 'Error',
                text: 'Elige al menos un evento y un regalo',
                confirmButtonText: 'Ok'
            });
            return;
        }
        const datos = new FormData();
        datos.append('eventos', eventosId);
        datos.append('regalo_id', regaloId);
        const url = '/finalizar-registro/conferencias';
        const respuesta = await fetch(url, {
            method: 'POST',
            body: datos
        })
        const resultado = await respuesta.json();
        if(resultado.resultado) {
            Swal.fire({
                icon: "success",
                title: 'Exitoso',
                text: 'Tus conferencias se han almacenado, tu registro fue exitoso, Te esperamos en DevWebCamp',
                confirmButtonText: 'Ok'
            }).then(() => {
                location.href = `/boleto?id=${resultado.token}`;
            });
        } else {
            Swal.fire({
                icon: "error",
                title: 'Error',
                text: 'Hubo un error',
                confirmButtonText: 'Ok'
            }).then(() => {
                location.reload();
            });;
        }
    }
}
})();