@extends('layouts.app')
@section('meta-title', 'Articulaciones')
@section('meta-content', 'Articulaciones')
@section('meta-keywords', 'Articulaciones')
@section('content')
  <main class="mn-inner inner-active-sidebar">
    <div class="content">
      <div class="row no-m-t no-m-b">
        <div class="col s12 m12 l12">
          <h5>
            <a class="footer-text left-align" href="{{route('articulacion')}}">
              <i class="left material-icons arrow-l">arrow_back</i>
            </a> Articulaciones con Grupos de Investigación
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
                      <div class="input-field col s12 m12 l12">
                        <p class="center p-v-xs">
                          <input class="with-gap" name="group1" type="radio" id="IsGrupo" value="0"/ checked readonly>
                          <label for="IsGrupo">Grupo de Investigación</label>
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
                        <input type="text" id="txtfecha_inicio" href="javascript:void(0)" name="txtfecha_inicio" class="datepicker __pickerinput"/>
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
      consultarTipoArticulacion(0);
      $divGrupo = $("#divGrupo");
      $divGrupo.show();

      $('#grupoDeInvestigacionTecnoparque_ArticulacionCreate_table').DataTable({
        "lengthMenu": [[5, 25, 50, -1], [5, 25, 50, "All"]],
        language: {
          "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
        },
        processing: true,
        serverSide: true,
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
        dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        success: function (data) {
          $('button[type="submit"]').removeAttr('disabled');
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


    function noRepeat(documento) {
      let retorno = true;
      let a = document.getElementsByName("documento[]");
      for (x=0;x<a.length;x++){
        if (a[x].value == documento) {
          retorno = false;
          break;
        }
      }
      return retorno;
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
