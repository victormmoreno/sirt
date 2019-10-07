@extends('layouts.app')
@section('meta-title', 'Articulaciones')
@section('content')
  <main class="mn-inner inner-active-sidebar">
    <div class="content">
      <div class="row no-m-t no-m-b">
        <div class="col s12 m12 l12">
          <h5>
            <a class="footer-text left-align" href="{{route('articulacion')}}">
              <i class="left material-icons arrow-l">arrow_back</i>
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
                  <form id="frmArticulacionesCreate" method="POST" action="{{route('articulacion.store')}}">
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
                      <p class="center card-title">Seleccione con quién será la articulación <span class="red-text">*</span></p><br>
                      <div class="input-field col s12 m12 l12">
                        <p class="center p-v-xs">
                          <input class="with-gap" name="group1" type="radio" id="IsGrupo" value="0"/>
                          <label for="IsGrupo">Grupo de Investigación</label>
                          <input class="with-gap" name="group1" type="radio" id="IsEmpresa" value="1"/>
                          <label for="IsEmpresa">Empresa</label>
                          <input class="with-gap" name="group1" type="radio" id="IsEmprendededor" value="2"/>
                          <label for="IsEmprendededor">Emprendedor</label>
                        </p>
                        <center>
                          <small id="group1-error" class="center-align error red-text"></small>
                        </center>
                      </div>
                    </div>
                    <div class="divider"></div>
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
                                <small id="txtgrupo_id-error" class="error red-text"></small>
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
                                <small id="txtempresa_id-error" class="error red-text"></small>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div id="divEmprendedor">
                      <div class="row">
                        <div class="col s12 m8 l8">
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
                        <div class="col s12 m4 l4">
                          <div class="row">
                            <blockquote>
                              <ul class="collection">
                                <li class="collection-item">Para agregar un talento a la articulación solo debe buscarlo y seleccionar el ícono <i class="material-icons">done</i>.</li>
                                <li class="collection-item">Para buscar un talento, lo puedes hacer por su documento de identidad ó nombre en el campo <b><u>Buscar</u></b>.</li>
                                <li class="collection-item">Los talentos agregados a la articulación se mostrarán en la siguiente tabla.</li>
                              </ul>
                            </blockquote>
                          </div>
                          <div class="row">
                            <div id="talentos-error" class="error red-text"></div>
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col s10 m8 l8">
                          <div class="card blue-grey lighten-5">
                            <div class="card-content">
                              <table id="detalleTalentosDeUnaArticulacion" style="width: 100%">
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
                          <div class="row">
                            <blockquote>
                              <ul class="collection">
                                <li class="collection-item">Para seleccionar un talento como talento líder, presione la casilla "Talento Líder" del talento que será el talento líder.</li>
                                <li class="collection-item">Para quitar a un talento de la articulación, debes presionar el botón con el ícono <i class="material-icons">delete</i>.</li>
                              </ul>
                            </blockquote>
                          </div>
                          <div class="row">
                            <div id="radioTalentoLider-error" class="error red-text"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="divider"></div>
                    <div class="row">
                      <div class="input-field col s12 m12 l12">
                        <label for="txtnombre">Nombre de la Articulación <span class="red-text">*</span></label>
                        <input type="text" id="txtnombre" name="txtnombre"/>
                        <small id="txtnombre-error" class="error red-text"></small>
                      </div>
                    </div>
                    <div class="row">
                      <div class="input-field col s12 m6 l6">
                        <select id="txttipoarticulacion_id" name="txttipoarticulacion_id" class="js-states">
                          <option value="">Primero debes seleccionar con quién se hará la articulación</option>
                        </select>
                        <label for="txttipoarticulacion_id">Seleccione el Tipo de Articulación <span class="red-text">*</span></label>
                        <small id="txttipoarticulacion_id-error" class="error red-text"></small>
                      </div>
                      <div class="input-field col s12 m6 l6">
                        <select class="js-states" id="txtestado" name="txtestado">
                          <option value="">Seleccione el Estado de la Articulación</option>
                          <option value="0">Inicio</option>
                          <option value="1">Ejecución</option>
                        </select>
                        <label for="txtestado">Estado de la Articulación <span class="red-text">*</span></label>
                        <small id="txtestado-error" class="error red-text"></small>
                      </div>
                    </div>
                    <div class="row">
                      <div class="input-field col s12 m6 l6">
                        <input type="text" id="txtfecha_inicio" name="txtfecha_inicio" class="datepicker __pickerinput"/>
                        <label for="txtfecha_inicio">Fecha de Inicio de la Articulación<span class="red-text">*</span></label>
                        <small id="txtfecha_inicio-error" class="error red-text"></small>
                      </div>
                    </div>
                    <div class="row">
                      <div class="input-field col s12 m12 l8 offset-l2">
                        <textarea id="txtobservaciones" name="txtobservaciones" class="materialize-textarea"></textarea>
                        <label for="txtobservaciones">Observaciones</label>
                        <small id="txtobservaciones-error" class="error red-text"></small>
                      </div>
                    </div>
                    <div class="divider"></div>
                    <center>
                      <button type="submit" class="cyan darken-1 btn center-aling"><i class="material-icons right">done_all</i>Registrar</button>
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

    $(document).on('submit', 'form#frmArticulacionesCreate', function (event) {
      // $('button[type="submit"]').prop("disabled", true);
      $('button[type="submit"]').attr('disabled', 'disabled');
      event.preventDefault();
      var form = $(this);
      var data = new FormData($(this)[0]);
      var url = form.attr("action");
      $.ajax({
        type: form.attr('method'),
        url: url,
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        success: function (data) {
          $('button[type="submit"]').removeAttr('disabled');
          // $('button[type="submit"]').prop("disabled", false);
          $('.error').hide();
          if (data.fail) {
            for (control in data.errors) {
              $('#' + control + '-error').html(data.errors[control]);
              $('#' + control + '-error').show();
            }
          } else if (data.fail == false && data.redirect_url == false) {
            Swal.fire({
              title: 'La articulación no se ha registrado, por favor inténtalo de nuevo',
              // text: "You won't be able to revert this!",
              type: 'warning',
              showCancelButton: false,
              confirmButtonColor: '#3085d6',
              confirmButtonText: 'Ok'
            })
          } else {
            Swal.fire({
              title: 'Registro Exitoso',
              text: "La articulación ha sido creado satisfactoriamente",
              type: 'success',
              showCancelButton: false,
              confirmButtonColor: '#3085d6',
              confirmButtonText: 'Ok'
            });
            setTimeout(function(){
              window.location.replace("{{route('articulacion')}}");
            }, 1000);
          }
        },
        error: function (xhr, textStatus, errorThrown) {
          alert("Error: " + errorThrown);
        }
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

    // Consulta los tipos de articulaciones que se pueden realizar según el caso (Grupos de Investigación, Empresas, Emprendedores)
    function consultarTipoArticulacion(value) {
      $('#txttipoarticulacion_id').empty();
      $.ajax({
        dataType:'json',
        type:'get',
        url:'/articulacion/consultarTiposArticulacion/'+value,
      }).done(function(ajax){
        $('#txttipoarticulacion_id').append('<option value="">Seleccione el tipo de articulación</option>');
        $.each(ajax.tiposarticulacion, function(i, e) {
          // console.log(e.nombre);
          $('#txttipoarticulacion_id').append('<option value="'+e.id+'">'+e.nombre+'</option>');
        })
        $('#txttipoarticulacion_id').material_select();
      })
    }


    function getTipoArt() {
      return tipo;
    }

    function setTipoArt(value) {
      tipo = value;
    }


    function noRepeat(id) {
      let idTalento = id;
      let retorno = true;
      let a = document.getElementsByName("talentos[]");
      for (x=0;x<a.length;x++){
        if (a[x].value == idTalento) {
          retorno = false;
          break;
        }
      }
      return retorno;
    }

    // Método para agregar talentos a una articulación
    function addTalentoArticulacion(id) {
      if (noRepeat(id) == false) {
        Swal.fire({
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 1500,
          type: 'warning',
          title: 'El talento ya está asociado a la articulación!'
        });
      } else {
        // let talentos = document.getElementsByName("talentos[]");
        $.ajax({
          dataType:'json',
          type:'get',
          url:'/usuario/talento/consultarTalentoPorId/'+id,
        }).done(function(ajax){
          // El ajax.talento.id es el id del TALENTO, no del usuario
          let idTalento = ajax.talento.id;
          let fila = '<tr class="selected" id='+idTalento+'>'
          +'<td><input type="radio" class="with-gap" name="radioTalentoLider" id="radioButton'+id+'" value="'+idTalento+'"/><label for ="radioButton'+idTalento+'"></label></td>'
          +'<td><input type="hidden" name="talentos[]" value="'+idTalento+'">'+ajax.talento.documento+' - '+ajax.talento.talento+'</td>'
          +'<td><a class="waves-effect red lighten-3 btn" onclick="eliminar('+idTalento+');"><i class="material-icons">delete_sweep</i></a></td>'
          +'</tr>';
          $('#detalleTalentosDeUnaArticulacion').append(fila);
          Swal.fire({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 1500,
            type: 'success',
            title: 'El talento se ha asociado a la articulación!'
          });
        });
        }
      }

      function eliminar(index){
        $('#'+index).remove();
      }

      $( "input[name='group1']" ).change(function (){
        if ( $("#IsGrupo").is(":checked") ) {
          $divGrupo.show();
          $divEmpresa.hide();
          $divEmprendedor.hide();
          consultarTipoArticulacion(0);
          setTipoArt(0);
        } else if ( $("#IsEmpresa").is(":checked") ) {
          $divEmpresa.show();
          $divGrupo.hide();
          $divEmprendedor.hide();
          consultarTipoArticulacion(1);
          setTipoArt(1);
        } else {
          $divEmprendedor.show();
          $divEmpresa.hide();
          $divGrupo.hide();
          consultarTipoArticulacion(1);
          setTipoArt(2);
        }
        $('#txttipoart').val(getTipoArt());
      });

    </script>
  @endpush
