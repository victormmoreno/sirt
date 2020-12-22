<link rel="stylesheet" type="text/css" href="{{ asset('css/Edicion_Text.css') }}">
<div class="modal" id="gruposDeInvestigacion_ArticulacionInicio_modal">
  <div class="modal-content">
    <div class="row">
      <div class="col s12 m12 l12">
        <table id="gruposInvestigacion_articulacion_table" style="width: 100%" class="centered">
          <thead>
            <th>Código del Grupo de Investigación</th>
            <th>Nombre del Grupo de Investigación</th>
            <th>Seleccionar para asociar a la articulación</th>
          </thead>
        </table>
      </div>
    </div>
  </div>
  <div class="modal-footer">
    <a href="#!" class="modal-close waves-effect waves-green btn-flat">Cancelar</a>
  </div>
</div>
<div id="info_actividad_modal" class="modal modal-fixed-footer">
    <div class="modal-content" >
        <h4 id="actividad_titulo" class="valign-wrapper truncate center-align "></h4>
        <div id="detalleActividad"></div>
        
    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat ">Cerrar</a>
    </div>
</div>
