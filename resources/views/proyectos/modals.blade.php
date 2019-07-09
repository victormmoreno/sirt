<div class="modal" id="empresasTecnoparque_modProyecto_modal">
  <div class="modal-content">
    <div class="row">
      <div class="col s12 m12 l12">
        <table id="empresasTecnoparque_proyecto_table" style="width: 100%" class="centered">
          <thead>
            <th>Nit de la Empresa</th>
            <th>Nombre de la Empresa</th>
            <th>Seleccionar para asociar a proyecto</th>
          </thead>
        </table>
      </div>
    </div>
  </div>
</div>
<div class="modal" id="gruposInvestigacionTecnoparque_modProyecto_modal">
  <div class="modal-content">
    <div class="row">
      <div class="col s12 m12 l12">
        <table id="gruposInvestigacionTecnoparque_proyecto_table" style="width: 100%" class="centered">
          <thead>
            <th>Código del Grupo de Investigación</th>
            <th>Nombre del Grupo de Investigación</th>
            <th>Seleccionar para asociar a proyecto</th>
          </thead>
        </table>
      </div>
    </div>
  </div>
</div>

<div id="modalInformacioDeLaEntidadesEnProyecto" class="modal">
  <div class="modal-content">
    <h4>A tener en cuenta:</h4>
    <ul class="collection">
      <li class="collection-item">
        Para asociar una entidad con la que se realizará el proyecto, primero se debe haber seleccionado una opcion del campo
        <b>Tipo de Articulación</b>, luego, puedes filtrar según el tipo de articulación seleccionado.
      </li>
      <li class="collection-item">
        En caso de no encontrar la entidad, puedes registrarla en el menú lateral izquierdo de la pantalla (Únicamente grupos de investigación y/o empresas).
      </li>
      <li class="collection-item">
        Solo se puede asociar <b>UNA ENTIDAD</b> a una proyecto.
      </li>
    </ul>
  </div>
  <div class="modal-footer">
    <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Ok!</a>
  </div>
</div>
<div id="modal2" class="modal modal-fixed-footer">
  <div class="modal-content">
    <center><h4 id="tituloTalento" class="center-aling"></h4></center>
    <div class="divider"></div>
    <div id="detallemodaltalento"></div>
  </div>
  <div class="modal-footer  white-text">
    <a href="#!" class="modal-action modal-close waves-effect waves-yellow btn-flat ">Cerrar</a>
  </div>
</div>
<div id="modal1" class="modal modal-fixed-footer">
  <div class="modal-content">
    <div id="titulo">

    </div>
    <div id="detalleproyecto"></div>
  </div>
  <div class="modal-footer  white-text">
    <a href="#!" class="modal-action modal-close waves-effect waves-yellow btn-flat ">Cerrar</a>
  </div>
</div>
<div id="modal_talentos_proyecto" class="modal modal-fixed-footer">
  <div class="modal-content">
    <center><h4 id="tituloPro" class="center-aling"></h4></center>
    <div class="divider"></div>
    <div>
      <table class="striped">
        <thead>
          <tr>
            <th>Documento de Identidad</th>
            <th>Nombres</th>
            <th>Correo</th>
            <th>Contacto</th>
            <th>Información del Talento</th>
          </tr>
        </thead>
        <tbody id="talentos">

        </tbody>
      </table>
    </div>
  </div>
  <div class="modal-footer  white-text">
    <a href="#!" class="modal-action modal-close waves-effect waves-yellow btn-flat">Cerrar</a>
  </div>
</div>
