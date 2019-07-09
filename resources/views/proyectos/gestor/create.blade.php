@extends('layouts.app')
@section('meta-title', 'Proyectos de Base Tecnológica')
@push('style')
  <style media="screen">
  #divPreload {
    /* width: 150px;
    height: 150px; */
    position: fixed;
    left:50%;
    top:50%;
    /* top: 50%;
    left: 50%; */
    /* margin-top: -75px;
    margin-left: -75px; */

  }
  </style>
@endpush
@section('content')
  <main class="mn-inner inner-active-sidebar">
    <div class="content">
      <div class="row no-m-t no-m-b">
        <div class="col s12 m12 l12">
          <h5>
            <a class="footer-text left-align" href="{{route('proyecto')}}">
              <i class="material-icons arrow-l">arrow_back</i>
            </a> Proyectos
          </h5>
          <div class="card">
            <div class="card-content">
              <div class="row">
                <br>
                <center>
                  <span class="card-title center-align"><b>Nuevo Proyecto - {{ auth()->user()->nombres }} {{ auth()->user()->apellidos }}</b></span>
                </center>
                <div class="divider"></div>
                <div class="card-panel red lighten-3">
                  <div class="card-content white-text">
                    <a class="btn-floating red"><i class="material-icons left">info_outline</i></a><span>Los elementos con (*) son obligatorios</span>
                  </div>
                </div>
                <br />
                <form action=""  method="POST">
                  <div class="row">
                    <div class="input-field col s12 m6 l6">
                      <input disabled id="txtgestor" name="txtgestor" value="{{ auth()->user()->nombres }} {{ auth()->user()->apellidos }}" type="text">
                      <label for="txtgestor" class="">Gestor</label>
                    </div>
                    <div class="input-field col s12 m6 l6">
                      <input disabled id="txtlinea" name="txtlinea" value="{{ auth()->user()->gestor->lineatecnologica->nombre }}" type="text">
                      <label for="txtlinea" class="">Línea Tecnológica</label>
                    </div>
                  </div>
                  <div class="row">
                    <div class="input-field col s12 m12 l12">
                      <select class="js-states" id="txttipoarticulacionproyecto_id" name="txttipoarticulacionproyecto_id" onchange="consultarEntidadesSegunElCaso(this.value);">
                        <option value="">Seleccione el Tipo de Articulación</option>
                        @forelse ($tipoarticulacion as $id => $value)
                          <option value="{{$id}}">{{$value}}</option>
                        @empty
                          <option value="">No hay información disponible</option>
                        @endforelse
                      </select>
                      <label for="txttipoarticulacionproyecto_id">Tipo de Articulación <span class="red-text">*</span></label>
                      <small id="txttipoarticulacionproyecto_id-error" class="error red-text"></small>
                    </div>
                  </div>
                  <div class="row" id="divOtroTipoArticulacion" >
                    <div class="input-field col s12 m12 l12">
                      <input type="text" name="txtotro_tipoarticulacion" id="otro_tipoarticulacion" value="">
                      <label for="txtotro_tipoarticulacion">¿Cuál? <span class="red-text">*</span></label>
                      <small id="txtotro_tipoarticulacion-error" class="error red-text"></small>
                    </div>
                  </div>
                  <div class="row">
                    <div class="input-field col s12 m6 l6">
                      <select id="txtsublinea_id" class="js-states" name="txtsublinea_id" style="width: 100%">
                        <option value="">Seleccione la Sublínea</option>
                        @forelse ($sublineas as $key => $value)
                          <option value="{{$key}}">{{$value}}</option>
                        @empty
                          <option value="">No hay información disponible</option>
                        @endforelse
                      </select>
                      <label for="txtsublinea_id">Sublínea <span class="red-text">*</span></label>
                      <small id="txtsublinea_id-error" class="error red-text"></small>
                    </div>
                    <div class="input-field col s12 m6 l6">
                      <select id="txtsector_id" class="js-states" name="txtsector_id" style="width: 100%;">
                        <option value="">Seleccione el Sector</option>
                        @forelse ($sectores as $id => $value)
                          <option value="{{$id}}">{{$value}}</option>
                        @empty
                          <option value="">No hay información disponible</option>
                        @endforelse
                      </select>
                      <label for="txtsector_id">Sector <span class="red-text">*</span></label>
                      <small id="txtsector_id-error" class="error red-text"></small>
                    </div>
                  </div>
                  <div class="row">
                    <div class="input-field col s12 m6 l6">
                      <select style="width: 100%" class="js-states" id="txtareaconocimiento_id" name="txtareaconocimiento_id">
                        <option value="">Seleccione el área de conocimiento</option>
                        @forelse ($areasconocimiento as $id => $value)
                          <option value="{{$id}}">{{$value}}</option>
                        @empty
                          <option value=""> No hay información disponible</option>
                        @endforelse
                      </select>
                      <label for="txtareaconocimiento_id">Áreas de Conocmiento <span class="red-text">*</span></label>
                      <small id="txtareaconocimiento_id-error" class="error red-text"></small>
                    </div>
                    <div class="input-field col s12 m6 l6">
                      <select id="txtestadoproyecto_id" name="txtestadoproyecto_id" style="width: 100%;">
                        <option value="">Seleccione el Estado del Proyecto</option>
                        @forelse ($estadosproyecto as $id => $value)
                          <option value="{{$id}}"> {{$value}} </option>
                        @empty
                          <option value="">No hay información disponible.</option>
                        @endforelse
                      </select>
                      <label for="txtestadoproyecto_id">Estado del Proyecto <span class="red-text">*</span></label>
                      <small id="txtestadoproyecto_id-error" class="error red-text"></small>
                      <!-- <label>Estado del Proyecto *</label> -->
                    </div>
                  </div>
                  <div class="divider"></div>
                  {{-- <div class="divider"></div> --}}
                  <div id="divEntidadesTecnoparque">
                    <div class="row">
                      <div class="col s12 m12 l12">
                        <center>
                          <a class="btn-floating blue-grey modal-trigger" href="#modalInformacioDeLaEntidadesEnProyecto"><i class="material-icons left">info_outline</i></a>
                          <span class="card-title center-align"><b>Datos de la Entidad con la que se articulará el proyecto.</b></span>
                        </center>
                      </div>
                    </div>
                    <div class="divider"></div>
                    <div id="divEntidadEmpresaProyecto" class="row">
                      <div class="input-field col s12 m6 l6">
                        <input type="text" name="txtnitEmpresa" id="txtnitEmpresa" disabled>
                        <label for="txtnitEmpresa" class="active">Nit de la Empresa</label>
                      </div>
                      <div class="input-field col s12 m6 l6">
                        <input type="text" name="txtnombreEmpresa" id="txtnombreEmpresa" disabled>
                        <label for="txtnombreEmpresa" class="active">Nombre de la Empresa</label>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col s12 m12 l12">
                      <center>
                        <span class="black-text text-black">¿Viene de una idea de proyecto?</span>
                        <div class="switch m-b-md">
                          <label>
                            No
                            <input type="checkbox" name="ideaProyecto" id="ideaProyecto" value="1"/>
                            <span class="lever"></span>
                            Si
                          </label>
                        </div>
                      </center>
                    </div>
                  </div>
                  <div class="divider"></div>
                  <div class="row">
                    <div class="col s6 m6 l6">
                      <span class="black-text text-black">Articulado con CT+i <span class="red-text">*</span></span>
                      <div class="switch m-b-md">
                        <label>
                          No
                          <input type="checkbox" name="txtarti_cti" id="txtarti_cti" value="1">
                          <span class="lever"></span>
                          Si
                        </label>
                      </div>
                    </div>
                    <div id="divNombreActorCTi" class="input-field col s6 m6 l6">
                      <input type="text" name="nom_act_cti" id="nom_act_cti" value="">
                      <label for="nom_act_cti">Nombre del Actor CT+i<span class="red-text">*</span></label>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col s6 m6 l6">
                      <span class="black-text text-black">Dirigido a área de emprendimiento SENA <span class="red-text">*</span></span>
                      <div class="switch m-b-md">
                        <label>
                          No
                          <input type="checkbox" name="txtdiri_ar_emp" id="txtdiri_ar_emp" value="1">
                          <span class="lever"></span>
                          Si
                        </label>
                      </div>
                    </div>
                    <div class="col s6 m6 l6">
                      <span class="black-text text-black">Recibido a través del área de emprendimiento SENA <span class="red-text">*</span></span>
                      <div class="switch m-b-md">
                        <label>
                          No
                          <input type="checkbox" name="txtreci_ar_emp" id="txtreci_ar_emp" value="1">
                          <span class="lever"></span>
                          Si
                        </label>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col s6 m6 l6">
                      <span class="black-text text-black">Dinero de regalías <span class="red-text">*</span></span>
                      <div class="switch m-b-md">
                        <label>
                          No
                          <input type="checkbox" name="txtdine_rega" id="txtdine_rega" value="1">
                          <span class="lever"></span>
                          Si
                        </label>
                      </div>
                    </div>
                  </div>
                  <div class="divider"></div>
                  <center>
                    <button type="submit" class="waves-effect cyan darken-1 btn center-aling"><i class="material-icons right">done_all</i>Registrar</button>
                    <a href="{{route('proyecto')}}" class="waves-effect red lighten-2 btn center-aling"><i class="material-icons right">backspace</i>Cancelar</a>
                  </center>
                </form>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </main>
@include('proyectos.modals')
@endsection
@push('script')
  <script>
  // Contenedores
  divPreload = $('#divPreload');
  divEntidadEmpresaProyecto = $('#divEntidadEmpresaProyecto');
  divNombreActorCTi = $('#divNombreActorCTi');
  divOtroTipoArticulacion = $('#divOtroTipoArticulacion');
  divEntidadesTecnoparque = $('#divEntidadesTecnoparque');


  // Ocultar contenedores
  divPreload.hide();
  divEntidadEmpresaProyecto.hide();
  divNombreActorCTi.hide();
  divOtroTipoArticulacion.hide();
  divEntidadesTecnoparque.hide();
  function consultarEntidadesSegunElCaso(id) {
    let nombre = $("#txttipoarticulacionproyecto_id [value='"+id+"']").text();
    if (nombre == 'Empresas') {
      $('#empresasTecnoparque_proyecto_table').dataTable().fnDestroy();
      $('#empresasTecnoparque_proyecto_table').DataTable({
        language: {
          "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
        },
        processing: true,
        serverSide: true,
        order: [ 0, 'desc' ],
        ajax:{
          url: "/proyecto/datatableEmpresasTecnoparque",
          type: "get",
        },
        columns: [
          {
            data: 'nit',
            name: 'nit',
          },
          {
            data: 'nombre_empresa',
            name: 'nombre_empresa',
          },
          {
            width: '20%',
            data: 'checkbox',
            name: 'checkbox',
            orderable: false,
          },
        ],
      });
      $('#empresasTecnoparque_modProyecto_modal').openModal();
    }

    if (nombre == 'Grupos y Semilleros del SENA' || nombre == 'Grupos y Semilleros Externos') {
      let tipo_grupo = 0;
      if (nombre == 'Grupos y Semilleros del SENA') {
        tipo_grupo = 1;
      }
      $('#gruposInvestigacionTecnoparque_proyecto_table').dataTable().fnDestroy();
      $('#gruposInvestigacionTecnoparque_proyecto_table').DataTable({
        language: {
          "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
        },
        processing: true,
        serverSide: true,
        order: [ 0, 'desc' ],
        ajax:{
          url: "/proyecto/datatableGruposInvestigacionTecnoparque/"+tipo_grupo,
          type: "get",
        },
        columns: [
          {
            data: 'codigo_grupo',
            name: 'codigo_grupo',
          },
          {
            data: 'nombre',
            name: 'nombre',
          },
          {
            width: '20%',
            data: 'checkbox',
            name: 'checkbox',
            orderable: false,
          },
        ],
      });
      $('#gruposInvestigacionTecnoparque_modProyecto_modal').openModal();

    }

    // if (nombre == ) {
    //
    // }
  }

  // Función para cerrar el modal y asignarle un valor al
  function asociarEmpresaAProyecto(id, nit, nombre) {
    // console.log(id);
    $('#empresasTecnoparque_modProyecto_modal').closeModal();
    Swal.fire({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 1500,
      type: 'success',
      title: 'La siguiente empresa se ha asociado a la articulación: ' + nit + ' - ' + nombre
    });
    $('#txtnombreEmpresa').val(nombre);
    $('#txtnitEmpresa').val(nit);
    $("label[for='txtnombreEmpresa']").addClass('active');
    $("label[for='txtnitEmpresa']").addClass('active');
    divEntidadEmpresaProyecto.show();
  }

  // Función para cerrar el modal y asignarle un valor al
  function asociarGrupoInvestigacionAProyecto(id, codigo, nombre) {
    // console.log(id);
    $('#gruposInvestigacionTecnoparque_modProyecto_modal').closeModal();
    Swal.fire({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 1500,
      type: 'success',
      title: 'El siguiente grupo de investigación se ha asociado a la articulación: ' + codigo + ' - ' + nombre
    });
    $('#txtnombreGrupo').val(nombre);
    $('#txtcodigoGrupo').val(codigo);
    $("label[for='txtnombreGrupo']").addClass('active');
    $("label[for='txtcodigoGrupo']").addClass('active');
    divEntidadEmpresaProyecto.show();
  }

  $('#txttipoarticulacionproyecto_id').change(function (){
    let id =  $("#txttipoarticulacionproyecto_id").val();
    let nombre = $("#txttipoarticulacionproyecto_id [value='"+id+"']").text();
    if (nombre == 'Otro') {
      divOtroTipoArticulacion.show();
    } else {
      divOtroTipoArticulacion.hide();
    }

    if (nombre != 'Empresas') {
      divEntidadEmpresaProyecto.hide();
    }

    if (nombre == 'Empresas') {
      divEntidadEmpresaProyecto.show();
    }

    if (nombre == 'Emprendedor' || nombre == 'Proyecto financiado por SENNOVA' || nombre == 'Otro') {
      divEntidadesTecnoparque.hide();
    } else {
      divEntidadesTecnoparque.show();
    }
  });


  $('#txtarti_cti').change(function() {
    if ( $('#txtarti_cti').is(':checked') ) {
      divNombreActorCTi.show();
    } else {
      divNombreActorCTi.hide();
    }
  });
</script>
@endpush
