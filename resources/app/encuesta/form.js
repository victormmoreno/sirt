let contador_secciones = 0;
let contenedorSecciones = document.getElementById('formularioEncuestas');
function nuevaSeccion() {
    let elementHtml = contenedorSecciones.outerHTML;
    let seccion = elementHtml;
    contador_secciones++;
    seccion += `
    <div id="seccion${getContadoSecciones()}">
        <div class="row card-panel">
            <div class="row">
                <h4>Seccion ${getContadoSecciones()}<a onclick="borrarSeccion('seccion${getContadoSecciones()}')" class="btn btn-flat right bg-danger white-text"><i class="material-icons left">delete_sweep</i>Borrar sección</a></h4>
                <p>Descripción</p>
            </div>
            <div id="preguntasSeccion${getContadoSecciones()}">
            </div>
            <div class="row">
                <a class="waves-effect waves-grey bg-secondary white-text btn-flat btn-small" value="" disabled selected>Nueva pregunta</a>
                <a class="waves-effect waves-grey bg-secondary white-text btn-flat btn-small" value="radio">Selección única</a>
                <a class="waves-effect waves-grey bg-secondary white-text btn-flat btn-small" value="checkbox">Selección múltiple</a>
                <a class="waves-effect waves-grey bg-secondary white-text btn-flat btn-small" value="text">Texto</a>
                <a class="waves-effect waves-grey bg-secondary white-text btn-flat btn-small" value="likert">Likert</a>
            </div>
        </div>
    </div>
    `
    contenedorSecciones.innerHTML = seccion;
    // console.log(getContadoSecciones());
}

function borrarSeccion(seccion) {
    seccion = document.getElementById(seccion);
    seccion.remove();
}

function getContadoSecciones() {
    return contador_secciones;
}