<div class="modal" id="entidadesTecnoparque_modProyecto_modal">
  <div class="modal-content">
    <div class="row">
      <div class="col s12 m12 l12">
        <table id="entidadesTecnoparque_proyecto_table" style="width: 100%" class="centered">
          <thead>
            <th>Identificador de la entidad</th>
            <th>Nombre de la entidad</th>
            <th>Seleccionar para asociar a proyecto</th>
          </thead>
        </table>
      </div>
    </div>
  </div>
  <div class="modal-footer">
    <a href="#!" onclick="volverSiElegirEntidad();" class="modal-close waves-effect waves-green btn-flat">Cancelar</a>
  </div>
</div>

<div class="modal" id="ideasDeProyectoConEmprendedores_modal">
  <div class="modal-content">
    <div class="row">
      <div class="col s12 m12 l12">
        <table id="ideasDeProyectoConEmprendedores_proyecto_table" style="width: 100%" class="centered">
          <thead>
            <th>Código de la Idea de Proyecto</th>
            <th>Nombre de la Idea</th>
            <th>Nombres del Contacto</th>
            <th>Seleccionar para asociar a proyecto</th>
          </thead>
        </table>
      </div>
    </div>
  </div>
  <div class="modal-footer">
    <a href="#!" class="modal-close waves-effect waves-green btn-flat">Cancelar</a>
  </div>
</div>

<div class="modal" id="ideasDeProyectoConEmpresasGrupos_modal">
  <div class="modal-content">
    <div class="row">
      <div class="col s12 m12 l12">
        <table id="ideasDeProyectoConEmpresasGrupos_proyecto_table" style="width: 100%" class="centered">
          <thead>
            {{-- <th>Código de la Idea de Proyecto</th> --}}
            <th>Nombre de la Idea</th>
            <th>Nombres del Contacto</th>
            <th>Seleccionar para asociar a proyecto</th>
          </thead>
        </table>
      </div>
    </div>
  </div>
  <div class="modal-footer">
    <a href="#!" class="modal-close waves-effect waves-green btn-flat">Cancelar</a>
  </div>
</div>

<div id="modalInformacioTalentosQueDesarrollaranElProyecto" class="modal">
  <div class="modal-content">
    <h4>A tener en cuenta:</h4>
    <ul class="collection">
      <li class="collection-item">
        Para asociar un talento a un proyecto, se debe buscar el talento en la tabla, después se debe presionar el botón con el ícono <i class="material-icons">done</i>,
        luego el talento se asociará al proyecto.
      </li>
      <li class="collection-item">
        Para seleccionar el talento líder del proyecto, debe presionar en la casilla "<b>Talento Líder</b>" del talento que será Talento líder del proyecto, esto se debe hacer luego de haber
        seleccionado los talentos que se asociarán al proyecto.
      </li>
      <li class="collection-item">
        Solo un talento asociado al proyecto puede ser <b>Talento Líder</b>.
      </li>
    </ul>
  </div>
  <div class="modal-footer">
    <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Ok!</a>
  </div>
</div>

<div id="modalInformacioSobreLasIdeasDeProyecto_Proyecto" class="modal">
  <div class="modal-content">
    <h4>A tener en cuenta:</h4>
    <ul class="collection">
      <li class="collection-item">
        Para buscar una idea de proyecto y asociarla al registro del proyecto, debes seleccionar si la idea pasó o no por el CSIBT, acto seguido, seleccionar el botón con el ícono
        <i class="material-icons">search</i>.
      </li>
      <li class="collection-item">
        Para asociar una idea de proyecto debe presionar el botón con el ícono <i class="material-icons">done</i> (esto, luego de listar las ideas de proyecto).
      </li>
      <li class="collection-item">
        En caso de que la idea de proyecto, no se haya inscrito como una idea y por tanto no haber pasado por entrenamientos y CSIBT, el/la Infocenter del nodo deberá registrarla desde su cuenta como
        una idea de proyecto con empresa o grupo de investigación según el caso.
      </li>
    </ul>
  </div>
  <div class="modal-footer">
    <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Ok!</a>
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
