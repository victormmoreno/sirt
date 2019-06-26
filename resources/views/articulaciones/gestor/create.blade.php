@extends('layouts.app')
@section('meta-title', 'Articulaciones')
@section('content')
  <main class="mn-inner inner-active-sidebar">
    <div class="content">
      <div class="row no-m-t no-m-b">
        <div class="col s12 m12 l12">
          <h5>
            <a class="footer-text left-align" href="{{route('articulacion')}}">
              <i class="material-icons arrow-l">arrow_back</i>
            </a> Articulaciones
          </h5>
          <div class="card">
            <div class="card-content">
              <div class="row">
                <div class="col s12 m12 l12">
                  <br>
                  <center>
                    <span class="card-title center-align">Nueva Articulación - {{ auth()->user()->nombres}} {{auth()->user()->apellidos}}</span>
                  </center>
                  <div class="divider"></div>
                  <div class="row">
                    <div class="col s12 m12 l12">
                      <div class="card red lighten-3">
                        <div class="row">
                          <div class="col s12 m12">
                            <div class="card-content white-text">
                              <p><i class="material-icons left">info_outline</i>Los datos marcados con * son obligatorios</p>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <form method="POST" action="{{route('articulacion.store')}}" onsubmit="return checkSubmit()">
                    {!! csrf_field() !!}
                    <input type="hidden" name="txttipo_articulacion" id="txttipo_articulacion" value="">
                    <div class="row">
                      <div class="col s12 m12 l12">
                        <blockquote>
                          <ul class="collection">
                            <li class="collection-item">Debes tener en cuenta que solo se puede realizar un articulación con un solo grupo de investigación o empresa. <br>En caso de que la articulación se realize con emprendedor (es), estos se deben registrar como talento.</li>
                          </ul>
                        </blockquote>
                      </div>
                    </div>
                    <div class="row">
                      <p class="center card-title">Seleccione con quién será la articulación</p><br>
                      <div class="input-field col s12 m12 l12">
                        <p class="center p-v-xs">
                          <input class="with-gap" name="group1" type="radio" id="IsGrupo" value="0"/>
                          <label for="IsGrupo">Grupo de Investigación</label>
                          <input class="with-gap" name="group1" type="radio" id="IsEmpresa" value="1"/>
                          <label for="IsEmpresa">Empresa</label>
                          <input class="with-gap" name="group1" type="radio" id="IsEmprendededor" value="2"/>
                          <label for="IsEmprendededor">Emprendedor</label>
                        </p>
                      </div>
                    </div>
                    <div id="divGrupo" class="row">
                      <div class="col s12 m6 l6">
                        <table style="width: 100%;" id="grupoDeInvestigacionTecnoparque_ArticulacionCreate_table" class="display responsive-table datatable-example dataTable">
                          <thead>
                            <tr>
                              <th style="width: 15px;">Código del Grupo de Investigación</th>
                              <th>Nombre del Grupo de Investigación</th>
                              <th>Seleccionar</th>
                            </tr>
                          </thead>
                          <tbody>

                          </tbody>
                        </table>
                      </div>
                      <div class="col s12 m6 l6">
                        <h6>La articulación se realizará con el siguiente grupo de investigación</h6>
                        <div class="card horizontal teal lighten-4">
                          <div class="card-stacked">
                            <div class="card-content">
                              <div class="input-field col s12 m12 l12">
                                <input type="hidden" name="txtgrupo_id" id="txtgrupo_id" value="">
                                <input readonly type="text" name="grupoInvestigacion" id="grupoInvestigacion" value="">
                                <label for="grupoInvestigacion">Grupo de Investigación</label>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div id="divEmpresa" class="row">
                      <div class="col s12 m6 l6">
                        <table style="width: 100%" id="empresasDeTecnoparque_ArticulacionCreate_table" class="display responsive-table datatable-example DataTable">
                          <thead>
                            <tr>
                              <th>Nit</th>
                              <th>Nombre de la Empresa</th>
                              <th>Seleccionar</th>
                            </tr>
                          </thead>
                          <tbody>

                          </tbody>
                        </table>
                      </div>
                      <div class="col s12 m6 l6">
                        <h6>La articulación se realizará con la siguiente empresa</h6>
                        <div class="card horizontal teal lighten-4">
                          <div class="card-stacked">
                            <div class="card-content">
                              <div class="input-field col s12 m12 l12">
                                <input type="hidden" name="txtempresa_id" id="txtempresa_id" value="">
                                <input readonly type="text" name="empresa" id="empresa" value="">
                                <label for="empresa">Empresa</label>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div id="divEmprendedor">
                      <div class="row">
                        <table style="width: 100%;" id="talentosDeTecnoparque_ArticulacionCreate_table" class="display responsive-table datatable-example dataTable">
                          <thead>
                            <tr>
                              <th>Documento de Identidad</th>
                              <th>Talento</th>
                              <th>Agregar</th>
                            </tr>
                          </thead>
                          <tbody>

                          </tbody>
                        </table>
                      </div>
                      <div class="row">
                        <div class="col s10 m8 l8">
                          <div class="card blue-grey lighten-5">
                            <div class="card-content">
                              <table id="detalleTalentosDeUnaArticulacion" style="width: 100%" class="highlight centered responsive-table">
                                <thead>
                                  <tr>
                                    <th style="width: 20%">Talento Líder</th>
                                    <th style="width: 60%">Talento</th>
                                    <th style="width: 60%">Eliminar</th>
                                  </tr>
                                </thead>
                                <tbody>

                                </tbody>
                              </table>
                            </div>
                          </div>
                        </div>
                        <div class="col s2 m4 l4">
                          <blockquote>
                            <ul class="collection">
                              <li class="collection-item">Para agregar un talento a la articulación solo debe buscarlo y seleccionarlo.</li>
                              <li class="collection-item">Para seleccionar un talento como talento líder, presione la casilla "Talento Líder" del talento que será el talento líder.</li>
                            </ul>
                          </blockquote>
                        </div>
                      </div>
                    </div>
                    <div class="divider"></div>
                    <div class="row">
                      <div class="input-field col s12 m12 l12">
                        <input type="text" id="txtnombre" name="txtnombre"/>
                        <label for="txtnombre">Nombre <span class="red-text">*</span></label>
                      </div>
                    </div>
                    <div class="row">
                      {{-- <div class="input-field col s12 m6 l6">
                        <select id="txttipoarticulacion_id" name="txttipoarticulacion_id" class="js-states" required>
                          <option value="">Seleccione el tipo de articulación</option>
                        </select>
                        <label for="txttipoarticulacion_id">Seleccione el Tipo de Articulación <span class="red-text">*</span></label>
                      </div> --}}
                      <div class="input-field col s12 m6 l6">
                        <select class="js-states" id="txtestado" name="txtestado">
                          <option value="null">Seleccione el Estado de la Articulación</option>
                          <option value="0">Inicio</option>
                          <option value="1">Ejecución</option>
                        </select>
                        <label for="txtestado">Estado de la Articulación <span class="red-text">*</span></label>
                      </div>
                    </div>
                    <div class="row">
                      <div class="input-field col s12 m6 l6">
                        <input type="text" id="txtfecha_inicio" name="txtfecha_inicio" class="datepicker __pickerinput"/>
                        <label for="txtfecha_inicio">Fecha de Inicio de la Articulación<span class="red-text">*</span></label>
                      </div>
                    </div>
                    <div class="row">
                      <div class="input-field col s12 m12 l8 offset-l2">
                        <textarea id="txtobservaciones" name="txtobservaciones" class="materialize-textarea" length="400" maxlength="400"></textarea>
                        <label for="txtobservaciones">Observaciones</label>
                      </div>
                    </div>
                    <div class="divider"></div>
                    <center>
                      <button type="submit" class="waves-effect cyan darken-1 btn center-aling"><i class="material-icons right">done_all</i>Registrar</button>
                      <a href="{{route('articulacion')}}" class="waves-effect red lighten-2 btn center-aling"><i class="material-icons right">backspace</i>Cancelar</a>
                    </center>
                  </form>
                </div>
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

    $(document).ready(function() {
      $divGrupo = $("#divGrupo");
      $divGrupo.hide();
      $divEmpresa = $("#divEmpresa");
      $divEmpresa.hide();
      $divEmprendedor = $('#divEmprendedor');
      $divEmprendedor.hide();

      $('#empresasDeTecnoparque_ArticulacionCreate_table').DataTable({
        "lengthMenu": [[5, 25, 50, -1], [5, 25, 50, "All"]],
        language: {
          "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
        },
        processing: true,
        serverSide: true,
        ajax:{
          url: "/empresa/datatableEmpresasDeTecnoparque",
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
          data: 'add_articulacion',
          name: 'add_articulacion',
          orderable: false,
        },
        ],
      });

      $('#grupoDeInvestigacionTecnoparque_ArticulacionCreate_table').DataTable({
        "lengthMenu": [[5, 25, 50, -1], [5, 25, 50, "All"]],
        language: {
          "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
        },
        processing: true,
        serverSide: true,
        // order: false,
        ajax:{
          url: "/grupo/datatableGruposInvestigacionDeTecnoparque",
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
          data: 'add_articulacion',
          name: 'add_articulacion',
          orderable: false,
        },
        ],
      });

      $('#talentosDeTecnoparque_ArticulacionCreate_table').DataTable({
        // "lengthMenu": [[5, 25, 50, -1], [5, 25, 50, "All"]],
        language: {
          "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
        },
        processing: true,
        serverSide: true,
        // order: false,
        ajax:{
          url: "/usuario/talento/getTalentosDeTecnoparque/",
          type: "get",
        },
        columns: [
        {
          data: 'documento',
          name: 'documento',
        },
        {
          data: 'talento',
          name: 'talento',
        },
        {
          data: 'add_articulacion',
          name: 'add_articulacion',
          orderable: false,
        },
        ],
      });

    });

    function addEmpresaArticulacion(id) {
      $.ajax({
        dataType:'json',
        type:'get',
        url:"/empresa/ajaxDetallesDeUnaEmpresa/"+id
      }).done(function(respuesta){
        $('#empresa').val(respuesta.detalles.nit + ' - ' + respuesta.detalles.nombre_empresa);
        $("label[for='empresa']").addClass('active');
        $('#txtempresa_id').val(respuesta.detalles.id);
        Swal.fire({
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 3000,
          type: 'success',
          title: 'El nit de la empresa con la que se realizará la articulación es: ' + respuesta.detalles.nit
        })
      })
    }

    function addGrupoArticulacion(id) {
      $.ajax({
        dataType:'json',
        type:'get',
        url:"/grupo/ajaxDetallesDeUnGrupoInvestigacion/"+id
      }).done(function(respuesta){
        $('#grupoInvestigacion').val(respuesta.detalles.codigo_grupo + ' - ' + respuesta.detalles.entidad.nombre);
        $("label[for='grupoInvestigacion']").addClass('active');
        $('#txtgrupo_id').val(respuesta.detalles.id);
        Swal.fire({
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 3000,
          type: 'success',
          title: 'El código del grupo de investigación con el que se realizará la articulación es: ' + respuesta.detalles.codigo_grupo
        })
      })
    }

    function getTipoArt() {
      return tipo;
    }

    function setTipoArt(value) {
      tipo = value;
    }

    $( "input[name='group1']" ).change(function (){
      if ( $("#IsGrupo").is(":checked") ) {
        $divGrupo.show();
        $divEmpresa.hide();
        $divEmprendedor.hide();
        setTipoArt(0);
      } else if ( $("#IsEmpresa").is(":checked") ) {
        $divEmpresa.show();
        $divGrupo.hide();
        $divEmprendedor.hide();
        setTipoArt(1);
      } else {
        $divEmprendedor.show();
        $divEmpresa.hide();
        $divGrupo.hide();
        setTipoArt(2);
      }
      $('#txttipoart').val(getTipoArt());
    });

  </script>
@endpush
