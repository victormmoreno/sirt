@extends('layouts.app')
@section('meta-title', 'CSIBT')
@section('content')
<main class="mn-inner inner-active-sidebar">
  <div class="content">
    <div class="row no-m-t no-m-b">
      <div class="col s12 m12 l12">
        <h5>
          <a class="footer-text left-align" href="{{route('csibt')}}">
            <i class="left material-icons">arrow_back</i>
          </a> Comité de Selección de Ideas
        </h5>
        <div class="card">
          <div class="card-content">
            <br>
            <center>
              <span class="card-title center-align">Modificar Comité de Selección de Ideas - <b>{{ $comite->codigo }}</b></span>
            </center>
            <div class="divider"></div>
            <div class="divider"></div>
            <div class="card-panel orange lighten-2">
              <div class="card-content white-text">
                <i class="material-icons left">warning</i>
                <span>Si realizas algún cambió en este comité, ten en cuenta que los correos con las cartas de aceptación y redireccionamiento <b>NO SERÁN ENVIADAS POR EL SISTEMA</b>.</span>
              </div>
            </div>
            <br />
            <div class="row">
              <form action="{{route('csibt.update', $comite->id)}}" id="formComiteEdit" method="post">
                {!! method_field('PUT')!!}
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
                    <input id="txtnombrenodo" type="text" value="{{ \NodoHelper::returnNameNodoUsuario() }}" name="txtnombrenodo" disabled>
                    <label for="txtnombrenodo">Nodo <span class="red-text">*</span></label>
                  </div>
                  <div class="input-field col s12 m6 l6">
                    <i class="material-icons prefix">date_range</i>
                    <input id="txtfechacomite_create" type="text" name="txtfechacomite_create" value="{{ $comite->fechacomite->isoFormat('YYYY-MM-DD') }}">
                    <label for="txtfechacomite_create" class="active">Fecha del Comité <span class="red-text">*</span></label>
                    <small id="txtfechacomite_create-error" class="error red-text"></small>
                  </div>
                </div>
                <div class="row">
                  <div class="input-field col s12 m12 l12">
                    <i class="material-icons prefix">speaker_notes</i>
                    <textarea name="txtobservacionescomite" class="materialize-textarea" length="1000" maxlength="1000" id="txtobservacionescomite" >{{ $comite->observaciones }}</textarea>
                    <label for="txtobservacionescomite">Observaciones del Comité</label>
                    <small id="txtobservacionescomite-error" class="error red-text"></small>
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
                                  <input id="txthoraidea" type="text" class="pickertime" name="txthoraidea">
                                  {{-- <span class="helper-text">Hora</span> --}}
                                  <label for="txthoraidea">Hora <span class="red-text">*</span></label>
                                  {{-- <small>Hora <span class="red-text">*</span></small> --}}
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
                                  <textarea name="txtobservacionesidea" class="materialize-textarea" length="2000" maxlength="2000" id="txtobservacionesidea"></textarea>
                                  <label for="txtobservacionesidea" id="labelobservacionesidea">Observaciones de la Idea de Proyecto</label>
                                </div>
                              </div>
                              <center>
                                <a onclick="addIdeaAlComite_edit()" class="indigo lighten-2 btn-large" data-position="bottom" data-delay="50" data-tooltip="Agregar la idea de proyecto seleccionada al comité"><i class="material-icons left">add</i>Agregar</a>
                              </center>
                              <div class="card-content">
                                <table class="responsive-table" style="width: 100%">
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
                                  <tbody id="tblIdeasComiteEdit">
                                    @foreach ($ideasComite as $key => $value)
                                      {{-- {{$value}} --}}
                                      <tr id="ideaComiteEdit{{$value->id}}">
                                        <td><input type="hidden" name="id_ideas[]" value="{{ $value->id }}">{{ $value->nombre_proyecto }}</td>
                                        <td><input type="hidden" name="horas_ideas[]" value="{{ Carbon\Carbon::parse($value->hora)->isoFormat('HH:mm') }}">{{ Carbon\Carbon::parse($value->hora)->isoFormat('HH:mm') }}</td>
                                        <td><input type="hidden" name="asistencias_ideas[]" value="{{ $value->asistencia }}">{{ $value->asistencia }}</td>
                                        <td><input type="hidden" name="observaciones_ideas[]" value="{{ $value->observaciones }}">{{ $value->observaciones }}</td>
                                        <td><input type="hidden" name="admitido_ideas[]" value="{{ $value->admitido }}">{{ $value->admitido }}</td>
                                        <td><a class="waves-effect red lighten-3 btn" onclick="eliminarIdeaEdit({{ $value->id }});"><i class="material-icons">delete_sweep</i></a></td>
                                      </tr>
                                    @endforeach
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
                 <center>
                   <button type="submit" class="btn waves-effect cyan darken-1 center-aling"><i class="material-icons right">done_all</i>Registrar</button>
                   <a href="{{ route('csibt')}}" class="btn waves-effect red lighten-2  center-aling"><i class="material-icons right">backspace</i>Cancelar</a>
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

  //Enviar formulario
  $(document).on('submit', 'form#formComiteEdit', function (event) {
    // $('button[type="submit"]').prop("disabled", true);
    event.preventDefault();
    let form = $(this);
    let data = new FormData($(this)[0]);
    let url = form.attr("action");
    ajaxUpdateComite(form, data, url);
  });

  function ajaxUpdateComite(form, data, url) {
    $('button[type="submit"]').attr('disabled', 'disabled');
    $.ajax({
      type: form.attr('method'),
      url: url,
      data: data,
      dataType: 'json',
      cache: false,
      contentType: false,
      processData: false,
      success: function (data) {
        $('button[type="submit"]').removeAttr('disabled');
        // $('button[type="submit"]').prop("disabled", false);
        $('.error').hide();
        if (data.fail) {
          let errores = "";
          for (control in data.errors) {
            errores += ' </br><b> - ' + data.errors[control] + ' </b> ';
            $('#' + control + '-error').html(data.errors[control]);
            $('#' + control + '-error').show();
          }
          Swal.fire({
            title: 'Advertencia!',
            html: 'Estas ingresando mal los datos.' + errores,
            type: 'error',
            showCancelButton: false,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Ok'
          });
        } else {
          if ( data.result ) {
            Swal.fire({
              title: 'Modificación Exitosa',
              text: "El comité se modificado satisfactoriamente",
              type: 'success',
              showCancelButton: false,
              confirmButtonColor: '#3085d6',
              confirmButtonText: 'Ok'
            });
            setTimeout(function(){
              window.location.replace("{{route('csibt')}}");
            }, 1000);
          } else {
            Swal.fire({
              title: 'Modificación Errónea!',
              text: "El comité no se ha modificado.",
              type: 'error',
              showCancelButton: false,
              confirmButtonColor: '#3085d6',
              confirmButtonText: 'Ok'
            });
          }
        }
      },
      error: function (xhr, textStatus, errorThrown) {
        alert("Error: " + errorThrown);
      }
    });
  }

  function eliminarIdeaEdit(index){
    $('#ideaComiteEdit'+index).remove();
  }

  function noRepeat(id) {
    let idIdea = id;
    let retorno = true;
    let a = document.getElementsByName("id_ideas[]");
    for (x=0;x<a.length;x++){
      if (a[x].value == idIdea) {
        retorno = false;
        break;
      }
    }
    return retorno;
  }

  function addIdeaAlComite_edit() {
    let id = $('#txtideaproyecto').val();
    // console.log(id);
    if (id == 0) {
      Swal.fire('Advertencia!', 'Seleccione una idea de proyecto', 'warning');
    } else {
      if (noRepeat(id) == false) {
        Swal.fire({
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 1500,
          type: 'warning',
          title: 'La idea de proyecto ya se encuentra asociada al comité!'
        });
      } else {
        let hora = $('#txthoraidea').val();

        if (hora === '') {
          Swal.fire('Advertencia!', 'Seleccione la hora a la que se presentó la idea de proyecto al comité', 'warning');
        } else {
          $.ajax({
            dataType:'json',
            type:'get',
            url:'/idea/detallesIdea/'+id,
          }).done(function(ajax){
            let idIdea = ajax.detalles.id;
            let nombre = ajax.detalles.nombre_proyecto;
            let asistencia = 0;
            let observaciones = $('#txtobservacionesidea').val();
            let admitida = 0;

            if ( $('#txtasistencia').is(":checked") ) {
              asistenciaAlComite = 1
            }

            if ( $('#txtadmitido').is(":checked") ) {
              ideaAdmitida = 1;
            }

            if (asistencia == 0) {
              asistencia = 'No';
            } else {
              asistencia = 'Si';
            }

            if (admitida == 0) {
              admitida = 'Si';
            } else {
              admitida = 'Si';
            }

            let fila = '<tr class="selected" id=ideaComiteEdit'+idIdea+'>'
            +'<td><input type="hidden" name="id_ideas[]" value="'+idIdea+'">'+nombre+'</td>'
            +'<td><input type="hidden" name="horas_ideas[]" value="'+hora+'">'+hora+'</td>'
            +'<td><input type="hidden" name="asistencias_ideas[]" value="'+asistencia+'">'+asistencia+'</td>'
            +'<td><input type="hidden" name="observaciones_ideas[]" value="'+observaciones+'">'+observaciones+'</td>'
            +'<td><input type="hidden" name="admitido_ideas[]" value="'+admitida+'">'+admitida+'</td>'
            +'<td><a class="waves-effect red lighten-3 btn" onclick="eliminarIdeaEdit('+idIdea+');"><i class="material-icons">delete_sweep</i></a></td>'
            +'</tr>';
            $('#tblIdeasComiteEdit').append(fila);
            reInitCamposDeLaIdea();
            Swal.fire({
              toast: true,
              position: 'top-end',
              showConfirmButton: false,
              timer: 1500,
              type: 'success',
              title: 'La idea de proyecto se ha asociado al comité!'
            });
          });
        }
      }
    }
  }

  </script>
@endpush
