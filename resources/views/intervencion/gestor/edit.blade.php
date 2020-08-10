@extends('layouts.app')
@section('meta-title', 'Intervención a Empresas')
@section('meta-content', 'Intervención a Empresas')
@section('meta-keywords', 'Intervención a Empresas')
@section('content')
  <main class="mn-inner inner-active-sidebar">
    <div class="content">
      <div class="row no-m-t no-m-b">
        <div class="col s12 m12 l12">
          <h5>
            <a class="footer-text left-align" href="{{route('intervencion.index')}}">
              <i class="material-icons arrow-l">arrow_back</i>
            </a> Intervención a Empresas
          </h5>
          <div class="card">
            <div class="card-content">
              <div class="row">
                <div class="col s12 m12 l12">
                  <br>
                  <center>
                    <span class="card-title center-align">Modificar Intervención a Empresa - <b>{{ $articulacion->articulacion_proyecto->actividad->codigo_actividad }}</b></span>
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

                  <form id="frmIntervencionesEdit" method="POST" action="{{route('intervencion.update', $articulacion->id)}}">
                    {!! csrf_field() !!}
                    {!! method_field('PUT')!!}
                    <input type="hidden" name="txttipo_articulacion" id="txttipo_articulacion" value="">
                          <input class="with-gap" onchange="contenedores();" name="group1" type="radio" {{ $articulacion->tipo_articulacion == 1 ? 'checked' : '' }} id="IsEmpresa" value="1"/>
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
                        <h6>La Intervención se realizará con la siguiente empresa</h6>
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
                    
                    <div class="divider"></div>
                    <div class="row">
                      <div class="input-field col s12 m12 l12">
                        <label for="txtnombre">Nombre de la Intervención <span class="red-text">*</span></label>
                        <input type="text" id="txtnombre" name="txtnombre" value="{{ $articulacion->articulacion_proyecto->actividad->nombre }}"/>
                        <small id="txtnombre-error" class="error red-text"></small>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col s12 m3 l3">
                        <blockquote>
                          <ul class="collection">
                            <li class="collection-item">Debes tener en cuenta que para cerrar una Intervención, <b>el dinamizador del nodo debe haberla aprobado o no aprobado.</b></li>
                          </ul>
                        </blockquote>
                      </div>
                    </div>
                    <div class="row">
                      <div class="input-field col s12 m6 l6">
                        <input type="text" id="txtfecha_inicio" name="txtfecha_inicio" class="datepicker __pickerinput" value="{{ $articulacion->articulacion_proyecto->actividad->fecha_inicio->toDateString() }}"/>
                        <label for="txtfecha_inicio">Fecha de Inicio de la Intervención<span class="red-text">*</span></label>
                        <small id="txtfecha_inicio-error" class="error red-text"></small>
                      </div>
                      <div id="divFechaCierre">
                        <div class="input-field col s12 m6 l6">
                          <input type="text" id="txtfecha_cierre" name="txtfecha_cierre" class="datepicker __pickerinput" value=""/>
                          <label for="txtfecha_cierre">Fecha de Cierre de la Intervención<span class="red-text">*</span></label>
                          <small id="txtfecha_cierre-error" class="error red-text"></small>
                        </div>
                      </div>
                    </div>
                    <div class="divider"></div>
                    <center>
                      <button type="submit" class="cyan darken-1 btn center-aling"><i class="material-icons right">done</i>Modificar</button>
                      <a href="{{route('intervencion.index')}}" class="waves-effect red lighten-2 btn center-aling"><i class="material-icons right">backspace</i>Cancelar</a>
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
      consultarTipoArticulacion({{$articulacion->tipo_articulacion}});
     
      $divEmpresa = $("#divEmpresa");
      $divEmpresa.hide();
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

      contenedores();
      $('#txtestado').val({{$articulacion->estado}});
      $('#txtestado').material_select();
    });

    $(document).on('submit', 'form#frmIntervencionesEdit', function (event) {
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
        dataType: 'json',
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
              window.location.replace("{{route('intervencion.index')}}");
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

      function contenedores() {
         if ( $("#IsEmpresa").is(":checked") ) {
          $divEmpresa.show();
          
          consultarTipoArticulacion(1);
          setTipoArt(1);
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
