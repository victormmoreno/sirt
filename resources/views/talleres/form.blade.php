{!! csrf_field() !!}
@php
    $existe = isset($taller) ? true : false;
@endphp
<div class="row">
  <div class="input-field col s12 m12 l12">
    <input type="text" name="txtfecha_sesion1" id="txtfecha_sesion1">
    <label for="txtfecha_sesion1">Fecha del taller de fortalecimiento <span class="red-text">*</span></label>
  </div>
</div>
<div class="row card teal lighten-4">
  <div class="row card-content white-text">
    <span class="card-title">Ideas de proyecto</span>
    <div class="input-field col s12 m5 l5">
      <select class="js-states browser-default select2" id="txtidea_taller" name="txtidea_taller">
        <option value="0">Seleccione una idea de proyecto</option>
        @foreach ($ideas as $key => $idea)
          <option value="{{$idea->id}}">{{$idea->codigo_idea}} - {{$idea->datos_idea->nombre_proyecto->answer}}</option>
        @endforeach
      </select>
      <label for="txtidea_taller" class="active">Idea de proyecto <span class="red-text">*</span></label>
    </div>
    <div class="col s12 m3 l3 offset-m1 offset-l1">
      <span class="black-text text-black">¿Confirmó que asistirá?</span>
      <div class="switch m-b-md">
          <label>
              No
              <input type="checkbox" name="txtconfirmacion" id="txtconfirmacion" value="1">
              <span class="lever"></span>
              Si
          </label>
      </div>
    </div>
    <div class="col s12 m3 l3">
      <span class="black-text text-black">¿Asistió al taller?</span>
      <div class="switch m-b-md">
          <label>
              No
              <input type="checkbox" name="txtasistencia" id="txtasistencia" value="1">
              <span class="lever"></span>
              Si
          </label>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="center">
      <a onclick="addIdeaToEntrenamiento()" class="bg-primary btn-large" data-position="bottom" data-delay="50" data-tooltip="Agregar la idea de proyecto seleccionada al taller de fortalecimiento"><i class="material-icons left">add</i>Agregar</a>
    </div>
  </div>
</div>
<div class="row">
  <div class="col s12 m12 l12">
    <div class="card blue-grey lighten-5">
      <div class="card-content">
        <table class="highlight centered responsive-table">
          <thead>
            <tr>
              <th style="width: 20%">Idea de proyecto</th>
              <th style="width: 10%">¿Confirmación?</th>
              <th style="width: 10%">¿Asistió a la sesión?</th>
              <th style="width: 10%">Eliminar</th>
            </tr>
          </thead>
          <tbody id="tblIdeasEntrenamientoForm">

          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>