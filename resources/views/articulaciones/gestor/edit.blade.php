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
                    <span class="card-title center-align">Modificar Articulación - <b>{{ $articulacion->codigo_articulacion }}</b></span>
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
                  <form id="frmArticulacionesEdit" method="POST" action="{{route('articulacion.update', $articulacion->id)}}">
                    {!! csrf_field() !!}
                    {!! method_field('PUT')!!}
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
                          <input class="with-gap" onchange="contenedores();" name="group1" type="radio" {{ $articulacion->tipo_articulacion == 0 ? 'checked' : '' }} id="IsGrupo" value="0"/>
                          <label for="IsGrupo">Grupo de Investigación</label>
                          <input class="with-gap" onchange="contenedores();" name="group1" type="radio" {{ $articulacion->tipo_articulacion == 1 ? 'checked' : '' }} id="IsEmpresa" value="1"/>
                          <label for="IsEmpresa">Empresa</label>
                          <input class="with-gap" onchange="contenedores();" name="group1" type="radio" {{ $articulacion->tipo_articulacion == 2 ? 'checked' : '' }} id="IsEmprendededor" value="2"/>
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
                                <input type="hidden" name="txtgrupo_id" id="txtgrupo_id" value="{{ $articulacion->tipo_articulacion == 0 ? $articulacion->articulacion_proyecto->entidad->grupoinvestigacion->id : '' }}">
                                <input readonly type="text" name="grupoInvestigacion" id="grupoInvestigacion"
                                value="{{ $articulacion->tipo_articulacion == 0 ? $articulacion->articulacion_proyecto->entidad->grupoinvestigacion->codigo_grupo . ' - ' . $articulacion->articulacion_proyecto->entidad->nombre : '' }}">
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
                                <input type="hidden" name="txtempresa_id" id="txtempresa_id" value="{{ $articulacion->tipo_articulacion == 1 ? $articulacion->articulacion_proyecto->entidad->empresa->id : '' }}">
                                <input readonly type="text" name="empresa" id="empresa"
                                value="{{ $articulacion->tipo_articulacion == 1 ? $articulacion->articulacion_proyecto->entidad->empresa->nit . ' - ' . $articulacion->articulacion_proyecto->entidad->nombre : '' }}">
                                <label for="empresa">Empresa</label>
                                <small id="txtempresa_id-error" class="error red-text"></small>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div id="divEmprendedor">
                      <div class="row col s12 m12 l12">
                        <div class="input-field col s12 m2 l2">
                          <input type="text" id="txtdocumento_emprendedor" name="txtdocumento_emprendedor"/>
                          <label for="txtdocumento_emprendedor">Documento del emprendedor<span class="red-text">*</span></label>
                          <small id="txtdocumento_emprendedor-error" class="error red-text"></small>
                        </div>
                        <div class="input-field col s12 m2 l2">
                          <input type="text" id="txtnombres_emprendedor" name="txtnombres_emprendedor"/>
                          <label for="txtnombres_emprendedor">Nombres del emprendedor<span class="red-text">*</span></label>
                          <small id="txtnombres_emprendedor-error" class="error red-text"></small>
                        </div>
                        <div class="input-field col s12 m2 l2">
                          <input type="email" name="txtemail_emprendedor" id="txtemail_emprendedor">
                          <label for="txtemail_emprendedor">Email del emprendedor</label>
                          <small id="txtemail_emprendedor-error" class="error red-text"></small>
                        </div>
                        <div class="input-field col s12 m2 l2">
                          <input type="number" name="txttelefono_emprendedor" id="txttelefono_emprendedor">
                          <label for="txttelefono_emprendedor">Número de contacto</label>
                          <small id="txttelefono_emprendedor-error" class="error red-text"></small>
                        </div>
                        <div class="col s12 m3 l3">
                          <a href="javascript:void(0)" onclick="addTalentoArticulacion()">
                            <div class="card green">
                              <div class="card-content center">
                                <i class="left material-icons white-text">add</i>
                                <span class="white-text">Agregar emprendedor</span>
                              </div>
                            </div>
                          </a>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col s10 m8 l8">
                          <div class="card blue-grey lighten-5">
                            <div class="card-content">
                              <table id="detalleTalentosDeUnaArticulacion" style="width: 100%">
                                <thead>
                                  <tr>
                                    <th style="width: 20%">Número de documento del emprendedor</th>
                                    <th style="width: 20%">Nombres del emprendedor</th>
                                    <th style="width: 20%">Email del emprendedor</th>
                                    <th style="width: 20%">Número de contacto</th>
                                    <th style="width: 20%">Eliminar emprendedor</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  @foreach ($pivot as $key => $value)
                                    <tr id="{{$value->documento}}">
                                      <td><input type="hidden" name="documento[]" value="{{$value->documento}}">{{$value->documento}}</td>
                                      <td><input type="hidden" name="nombres[]" value="{{$value->nombres}}">{{$value->nombres}}</td>
                                      <td><input type="hidden" name="email[]" value="{{$value->email}}">{{$value->email}}</td>
                                      <td><input type="hidden" name="contacto[]" value="{{$value->contacto}}">{{$value->contacto}}</td>
                                      <td><a class="waves-effect red lighten-3 btn" onclick="eliminar({{$value->documento}});"><i class="material-icons">delete_sweep</i></a></td>
                                    </tr>
                                  @endforeach
                                </tbody>
                              </table>
                              <div class="row">
                                <div id="documento-error" class="error red-text"></div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col s2 m4 l4">
                          <div class="row">
                            <blockquote>
                              <ul class="collection">
                                <li class="collection-item">Para añadir un emprendedor a la articulación, debes ingresar sus datos en los respectivos campos de: número de documento, nombres,
                                  email y número  de contacto (teléfono o celular) y luego presionar el botón de "Agregar emprendedor"</li>
                                <li class="collection-item">Para quitar a un emprendedor de la articulación, debes presionar el botón con el ícono <i class="material-icons">delete</i>.</li>
                              </ul>
                            </blockquote>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="divider"></div>
                    <div class="row">
                      <div class="input-field col s12 m12 l12">
                        <label for="txtnombre">Nombre de la Articulación <span class="red-text">*</span></label>
                        <input type="text" id="txtnombre" name="txtnombre" value="{{ $articulacion->articulacion_proyecto->actividad->nombre }}"/>
                        <small id="txtnombre-error" class="error red-text"></small>
                      </div>
                    </div>
                    <div class="row">
                      <div class="input-field col s12 m5 l5">
                        <select id="txttipoarticulacion_id" name="txttipoarticulacion_id" class="js-states">
                          <option value="">Primero debes seleccionar con quién se hará la articulación</option>
                        </select>
                        <label for="txttipoarticulacion_id">Seleccione el Tipo de Articulación <span class="red-text">*</span></label>
                        <small id="txttipoarticulacion_id-error" class="error red-text"></small>
                      </div>
                      <div class="col s12 m3 l3">
                        <blockquote>
                          <ul class="collection">
                            <li class="collection-item">Debes tener en cuenta que para cerrar una articulación, <b>el dinamizador del nodo debe haberla aprobado o no aprobado.</b></li>
                          </ul>
                        </blockquote>
                      </div>
                      <div class="input-field col s12 m4 l4">
                        <select class="js-states" id="txtestado" name="txtestado" onchange="estadoArticulacion(this.value);">
                          <option value="">Seleccione el Estado de la Articulación</option>
                          <option value="0">Inicio</option>
                          <option value="1">Ejecución</option>
                          @if ($articulacion->articulacion_proyecto->revisado_final == 1)
                            <option value="2">Cierre</option>
                          @endif
                        </select>
                        <label for="txtestado">Estado de la Articulación <span class="red-text">*</span></label>
                        <small id="txtestado-error" class="error red-text"></small>
                      </div>
                    </div>
                    <div class="row">
                      <div class="input-field col s12 m6 l6">
                        <input type="text" id="txtfecha_inicio" name="txtfecha_inicio" class="datepicker __pickerinput" value="{{ $articulacion->articulacion_proyecto->actividad->fecha_inicio->toDateString() }}"/>
                        <label for="txtfecha_inicio">Fecha de Inicio de la Articulación<span class="red-text">*</span></label>
                        <small id="txtfecha_inicio-error" class="error red-text"></small>
                      </div>
                      <div id="divFechaCierre">
                        <div class="input-field col s12 m6 l6">
                          <input type="text" id="txtfecha_cierre" name="txtfecha_cierre" class="datepicker __pickerinput" value=""/>
                          <label for="txtfecha_cierre">Fecha de Cierre de la Articulación<span class="red-text">*</span></label>
                          <small id="txtfecha_cierre-error" class="error red-text"></small>
                        </div>
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
                      <button type="submit" class="cyan darken-1 btn center-aling"><i class="material-icons right">done</i>Modificar</button>
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
      $divFechaCierre = $('#divFechaCierre');
      $divFechaCierre.hide();

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

      // $('#talentosDeTecnoparque_ArticulacionCreate_table').DataTable({
      //   // "lengthMenu": [[5, 25, 50, -1], [5, 25, 50, "All"]],
      //   language: {
      //     "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
      //   },
      //   processing: true,
      //   serverSide: true,
      //   // order: false,
      //   ajax:{
      //     url: "/usuario/talento/getTalentosDeTecnoparque/",
      //     type: "get",
      //   },
      //   columns: [
      //   {
      //     data: 'documento',
      //     name: 'documento',
      //   },
      //   {
      //     data: 'talento',
      //     name: 'talento',
      //   },
      //   {
      //     data: 'add_articulacion',
      //     name: 'add_articulacion',
      //     orderable: false,
      //   },
      //   ],
      // });
      contenedores();
      $('#txtestado').val({{$articulacion->estado}});
      $('#txtestado').material_select();
    });

    $(document).on('submit', 'form#frmArticulacionesEdit', function (event) {
      $('button[type="submit"]').attr('disabled', 'disabled');
      event.preventDefault();
      var form = $(this);
      var data = new FormData($(this)[0]);
      var url = form.attr("action");
      if ($('#txtestado').val() == 2) {
        Swal.fire({
          title: 'Advertencia!',
          text: "Al cerrar la articulación con el código {{$articulacion->codigo_articulacion}}, ten en cuenta que no podrás realizar ningún cambio una vez cerrada la articulación!",
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          cancelButtonText: 'Cancelar',
          confirmButtonText: 'Sí, cerrar la articulación'
        }).then((result) => {
          ajaxEdit(form, url, data);
        })
      } else {
        ajaxEdit(form, url, data);
      }

    });


    function ajaxEdit(form, url, data) {
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
            let errores = "";
            for (control in data.errors) {
              // -1 si no encuentra la cadena
              // if (control.indexOf('documento') != -1 ) {
              //   errores += ' </br><b> - Uno de los emprendedores tiene los datos erróneos</b> ';
              // } else {
              //   errores += ' </br><b> - ' + data.errors[control] + ' </b> ';
              // }
              errores += ' </br><b> - ' + data.errors[control] + ' </b> ';
              $('#' + control + '-error').html(data.errors[control]);
              $('#' + control + '-error').show();
            }
            Swal.fire({
              title: 'Advertencia!',
              html: 'Estas ingresando mal los datos.' + errores,
              type: 'warning',
              showCancelButton: false,
              confirmButtonColor: '#3085d6',
              confirmButtonText: 'Ok'
            });
            // Swal.fire('Advertencia!', 'Estas ingresando mal los datos', 'warning');
          } else if (data.fail == false && data.redirect_url == false) {
            Swal.fire({
              title: 'Modificación Errónea',
              text: 'La articulación no se ha modificado, por favor inténtalo de nuevo',
              type: 'error',
              showCancelButton: false,
              confirmButtonColor: '#3085d6',
              confirmButtonText: 'Ok'
            });
          } else {
            Swal.fire({
              title: '<b>Modificación Exitosa</b>',
              html: "La articulación <b>{{$articulacion->codigo_articulacion}}</b> ha sido modificada satisfactoriamente",
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
    }


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
        $('#txttipoarticulacion_id').val({{$articulacion->tipoarticulacion->id}});
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

    // Método para agregar emprendedores a una articulación
    function addTalentoArticulacion(id) {
      let documento = $('#txtdocumento_emprendedor').val();
      let nombres = $('#txtnombres_emprendedor').val();
      let email = $('#txtemail_emprendedor').val();
      let contacto = $('#txttelefono_emprendedor').val();
      if (noRepeat(documento) == false) {
        Swal.fire({
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 1500,
          type: 'warning',
          title: 'El talento ya está asociado a la articulación!'
        });
      } else {

        if (documento === '') {
          Swal.fire('Advertencia!', 'El número de documento del emprendedor debe ser obligatorio', 'warning');
        } else {
          if (nombres === '') {
            Swal.fire('Advertencia!', 'El nombre del emprendedor debe ser obligatorio', 'warning');
          } else {
            if (email === '') {
              email = 'No registra';
            }

            if (contacto === '') {
              contacto = 'No registra';
            }

            let fila = '<tr class="selected" id='+documento+'>'
            +'<td><input type="hidden" name="documento[]" value="'+documento+'">'+ documento +'</td>'
            +'<td><input type="hidden" name="nombres[]" value="'+nombres+'">'+ nombres +'</td>'
            +'<td><input type="hidden" name="email[]" value="'+email+'">'+ email +'</td>'
            +'<td><input type="hidden" name="contacto[]" value="'+contacto+'">'+ contacto +'</td>'
            +'<td><a class="waves-effect red lighten-3 btn" onclick="eliminar('+documento+');"><i class="material-icons">delete_sweep</i></a></td>'
            +'</tr>';
            $('#detalleTalentosDeUnaArticulacion').append(fila);
            Swal.fire({
              toast: true,
              position: 'top-end',
              showConfirmButton: false,
              timer: 1500,
              type: 'success',
              title: 'El emprendedor se ha asociado a la articulación!'
            });
            resetValueInputEmprendedores();
          }
        }

      }
      // if (noRepeat(id) == false) {
      //   Swal.fire({
      //     toast: true,
      //     position: 'top-end',
      //     showConfirmButton: false,
      //     timer: 1500,
      //     type: 'warning',
      //     title: 'El talento ya está asociado a la articulación!'
      //   });
      // } else {
      //   // let talentos = document.getElementsByName("talentos[]");
      //   $.ajax({
      //     dataType:'json',
      //     type:'get',
      //     url:'/usuario/talento/consultarTalentoPorId/'+id,
      //   }).done(function(ajax){
      //     // El ajax.talento.id es el id del TALENTO, no del usuario
      //     let idTalento = ajax.talento.id;
      //     let fila = '<tr class="selected" id='+idTalento+'>'
      //     +'<td><input type="radio" class="with-gap" name="radioTalentoLider" id="radioButton'+id+'" value="'+idTalento+'"/><label for ="radioButton'+idTalento+'"></label></td>'
      //     +'<td><input type="hidden" name="talentos[]" value="'+idTalento+'">'+ajax.talento.documento+' - '+ajax.talento.talento+'</td>'
      //     +'<td><a class="waves-effect red lighten-3 btn" onclick="eliminar('+idTalento+');"><i class="material-icons">delete_sweep</i></a></td>'
      //     +'</tr>';
      //     $('#detalleTalentosDeUnaArticulacion').append(fila);
      //     Swal.fire({
      //       toast: true,
      //       position: 'top-end',
      //       showConfirmButton: false,
      //       timer: 1500,
      //       type: 'success',
      //       title: 'El talento se ha asociado a la articulación!'
      //     });
      //   });
      //   }
      }

      function resetValueInputEmprendedores() {
        $('#txtdocumento_emprendedor').val(null);
        $("label[for='txtdocumento_emprendedor']").removeClass("active", false);
        $('#txtnombres_emprendedor').val(null);
        $("label[for='txtnombres_emprendedor']").removeClass("active", false);
        $('#txtemail_emprendedor').val(null);
        $("label[for='txtemail_emprendedor']").removeClass("active", false);
        $('#txttelefono_emprendedor').val(null);
        $("label[for='txttelefono_emprendedor']").removeClass("active", false);
      }

      function eliminar(index){
        $('#'+index).remove();
      }

      function contenedores() {
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
      }

      function estadoArticulacion(value) {
        if ( value == 2 ) {
          $divFechaCierre.show();
        }  else {
          $divFechaCierre.hide();
        }
      }

    </script>
  @endpush
