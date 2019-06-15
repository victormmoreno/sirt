@extends('layouts.app')
@section('meta-title', 'CSIBT')
@section('content')
<main class="mn-inner inner-active-sidebar">
  <div class="content">
    <div class="row no-m-t no-m-b">
      <div class="col s12 m12 l12">
        <h5>
          <a class="footer-text left-align" href="{{route('csibt')}}">
            <i class="material-icons arrow-l">arrow_back</i>
          </a> Comité de Selección de Ideas
        </h5>
        <div class="card">
          <div class="card-content">
            <br>
            <center>
              <span class="card-title center-align">Nuevo Comité de Selección de Ideas - Tecnoparque nodo{{ \NodoHelper::returnNodoUsuario() }}</span>
            </center>
            <div class="divider"></div>
            <div class="row">
              <form action="{{route('csibt.store')}}" id="formComiteCreate" method="post" onsubmit="return checkSubmit()">
                {!! csrf_field() !!}
                @if($errors->any())
                  <div class="card red lighten-3">
                    <div class="row">
                      <div class="col s12 m12">
                        <div class="card-content white-text">
                          <p><i class="material-icons left"> info_outline</i>  Los datos marcados con * son obligatorios</p>
                        </div>
                      </div>
                    </div>
                  </div>
                @endif
                <center>
                  <span class="card-title center-align">Datos del Comité</span> <i class="Small material-icons prefix">account_circle </i>
                </center>
                <div class="divider"></div>
                <div class="row">
                  <div class="input-field col s12 m6 l6">
                    <i class="material-icons prefix">location_city</i>
                    <input id="txtnombrenodo" type="text" value="{{ \NodoHelper::returnNodoUsuario() }}" name="txtnombrenodo" disabled>
                    <label for="txtnombrenodo">Nodo <span class="red-text">*</span></label>
                  </div>
                  <div class="input-field col s12 m6 l6">
                    <i class="material-icons prefix">date_range</i>
                    <input id="txtfechacomite_create" type="text" name="txtfechacomite_create" value="{{Carbon\Carbon::now()->toDateString()}}">
                    <label for="txtfechacomite_create" class="active">Fecha del Comité <span class="red-text">*</span></label>
                  </div>
                </div>
                <div class="row">
                  <div class="input-field col s12 m12 l12">
                    <i class="material-icons prefix">speaker_notes</i>
                    <textarea name="txtobservacionescomite" class="materialize-textarea" length="1000" maxlength="1000" id="txtobservacionescomite" ></textarea>
                    <label for="txtobservacionescomite">Observaciones del Comité</label>
                  </div>
                </div>
                <div class="divider"></div>
                <center>
                  <span class="card-title center-align">Ideas de Proyecto</span>
                  <i class="Small material-icons prefix">info</i>
                </center>
                <div class="row">
                  <div class="col s12 m12 l12">
                    <div class="card-content">
                      <h5>
                        <span class="red-text text-darken-2">Para registrar las ideas en el comité dar click en el botón <a class="btn-floating waves-effect waves-light red"><i class="material-icons">add</i></a></span>
                      </h5>
                      <p>Si desea agregar mas ideas de proyecto por favor seleccione..</p>
                      <ul class="collapsible collapsible-accordion" data-collapsible="accordion">
                        <li>
                          <div class="collapsible-header active blue-grey lighten-1"><i class="material-icons">lightbulb</i>Seleccione las ideas de proyecto que se presentarán en el comité</div>
                          <div class="collapsible-body">
                            <div class="card-content">
                              <div class="row">
                                <div class="input-field col s12 m12 l12">
                                  <select id="txtideaproyecto" class="js-states browser-default select2" style="width: 100%;" name="txtideaproyecto">
                                    <option value="0">Seleccione las ideas de proyecto que se presentarán en el comité</option>
                                    @foreach ($ideas as $key => $value)
                                      <option value="{{$value['id']}}">{{$value['nombre_idea']}}</option>
                                    @endforeach
                                  </select>
                                  <label for="#txtideaproyecto" class="active">Ideas de Proyecto <span class="red-text">*</span></label>
                                </div>
                              </div>
                              <div class="row">
                                <div class="input-field col s12 m6 l6">
                                  <i class="material-icons prefix">access_time</i>
                                  <input id="txthoraidea" type="time" class="pickertime" name="txthoraidea">
                                  <label class="active" for="txthoraidea">Hora <span class="red-text">*</span></label>
                                </div>
                                <div class="col s6 m3 l3">
                                  <span class="black-text text-black">¿Asistió?</span>
                                  <div class="switch m-b-md">
                                    <label>
                                      No
                                      <input type="checkbox" name="txtasistencia" id="txtasistencia" value="1">
                                      <span class="lever"></span>
                                      Si
                                    </label>
                                  </div>
                                </div>
                                <div class="col s6 m3 l3">
                                  <span class="black-text text-black">¿Admitido?</span>
                                  <div class="switch m-b-md">
                                    <label>
                                      No
                                      <input type="checkbox" name="txtadmitido" id="txtadmitido" value="1">
                                      <span class="lever"></span>
                                      Si
                                    </label>
                                  </div>
                                </div>
                              </div>
                              <div class="row">
                                <div class="input-field col s12 m12 l12">
                                  <i class="material-icons prefix">speaker_notes</i>
                                  <textarea name="txtobservacionesidea" class="materialize-textarea" length="1000" maxlength="1000" id="txtobservacionesidea" ></textarea>
                                  <label for="txtobservacionesidea" id="labelobservacionesidea">Observaciones de la Idea de Proyecto</label>
                                </div>
                              </div>
                              <center>
                                <a onclick="csibt_create.addIdeaDeProyectoAlComite()" class="indigo lighten-2 btn-large" data-position="bottom" data-delay="50" data-tooltip="Agregar la idea de proyecto seleccionada al comité"><i class="material-icons left">add</i>Agregar</a>
                                {{-- <a onclick="agregar()" class="btn-floating btn-large waves-effect waves-light indigo lighten-2 tooltipped" data-position="bottom" data-delay="50" data-tooltip="Agregar la idea de proyecto seleccionada al comité"><i class="material-icons">add</i></a> --}}
                              </center>
                              <div class="card-content">
                                <table>
                                  <thead>
                                    <tr>
                                      <th style="width: 30%">Idea de Proyecto</th>
                                      <th style="width: 10%">Hora</th>
                                      <th style="width: 5%">¿Asistió?</th>
                                      <th style="width: 40%">Observaciones</th>
                                      <th style="width: 5%">¿Admitido?</th>
                                      <th style="width: 10%">Eliminar</th>
                                    </tr>
                                  </thead>
                                  <tbody id="tblIdeasComiteCreate">

                                  </tbody>
                                </table>
                              </div>
                            </div>
                          </div>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
                <div class="divider"></div>
               <div class="row">
                 <h5>Entregables Fase Inicio</h5>
                 <div class="input-field col s6 m3 l3">
                   <p class="p-v-xs">
                     <input type="checkbox" id="txtcorreos" name="txtcorreos" value="1">
                     <label for="txtcorreos">Correos <span class="red-text">*</span></label>
                   </p>
                 </div>
                 <div class="input-field col s6 m3 l3">
                   <p class="p-v-xs">
                     <input type="checkbox" id="txtlistado_asistencia" name="txtlistado_asistencia" value="1">
                     <label for="txtlistado_asistencia">Listado de Asistencia <span class="red-text">*</span></label>
                   </p>
                 </div>
                 <div class="input-field col s6 m3 l3">
                   <p class="p-v-xs">
                     <input type="checkbox" id="txtotros" name="txtotros" value="1">
                     <label for="txtotros">Otros <span class="red-text">*</span></label>
                   </p>
                 </div>
               </div>
               <div class="divider"></div>
               <div class="dropzone"></div>
               <div class="divider"></div>
               <div class="row">
                 <center>
                   <button type="submit" class="btn waves-effect cyan darken-1 center-aling"><i class="material-icons right">done_all</i>Registrar</button>
                   <a href="{{route('csibt')}}" class="btn waves-effect red lighten-2  center-aling"><i class="material-icons right">backspace</i>Cancelar</a>
                 </center>
               </div>
                <!-- <a id="btnSave" class="btn" readonly><i class="material-icons right">done_all</i>Registrar</a> -->
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
@endsection
@push('script')
  <script>
  var DropzoneComite = new Dropzone('.dropzone', {
    url: '/csibt/store/filesComite',
    headers: {
      'X-CSRF-TOKEN': '{{ csrf_token() }}'
    },
    dictDefaultMessage: 'Arrastra los archivos aquí para subirlos',
    paramName: 'nombreArchivo'
  });

  DropzoneComite.on('error', function (file, res) {
    var msg = res.errors.nombreArchivo[0];
    $('.dz-error-message:last > span').text(msg);

  })
  Dropzone.autoDiscover = false;
  </script>
@endpush
