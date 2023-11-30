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
              <i class="left material-icons arrow-l">arrow_back</i>
            </a> Intervención a Empresas
          </h5>
          
          <div class="card">
            <div class="card-content">
              <div class="row">
                <div class="col s12 m12 l12">
                  <br>
                  <center>
                    <span class="card-title center-align">Nueva Intervención a Empresa - {{ auth()->user()->nombres}} {{auth()->user()->apellidos}}</span>
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
                  <form id="fmrIntervencionCreate" method="POST" action="{{route('intervencion.store')}}">
                    {!! csrf_field() !!}
                    <input type="hidden" name="txttipo_articulacion" id="txttipo_articulacion" value="">
                    
                    <div class="row">
                
                      <div class="input-field col s12 m12 l12">
                          <input class="with-gap" name="group1" type="hidden" id="IsEmpresa" value="1"/>
                          
                          
                        
                        <center>
                          <small id="group1-error" class="center-align error red-text"></small>
                        </center>
                      </div>
                    </div>
                    <div class="divider"></div>
                    
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
                    
                      
                  
  
                    <div class="divider"></div>
                    <div class="row">
                      <div class="input-field col s12 m12 l12">
                        <label for="txtnombre">Nombre de la Intervención <span class="red-text">*</span></label>
                        <input type="text" id="txtnombre" name="txtnombre"/>
                        <small id="txtnombre-error" class="error red-text"></small>
                      </div>
                    </div>
                    <div class="row">
                      <div class="input-field col s12 m6 l6">
                        <select class="js-states" id="txtestado" name="txtestado">
                          <option value="">Seleccione el Estado de la Intervención</option>
                          <option value="0">Inicio</option>
                          <option value="1">Ejecución</option>
                        </select>
                        <label for="txtestado">Estado de la Intervención <span class="red-text">*</span></label>
                        <small id="txtestado-error" class="error red-text"></small>
                      </div>
                    </div>
                    <div class="row">
                      <div class="input-field col s12 m6 l6">
                        <input type="text" id="txtfecha_inicio" href="javascript:void(0)" name="txtfecha_inicio" class="datepicker __pickerinput"/>
                        <label for="txtfecha_inicio">Fecha de Inicio de la Intervención<span class="red-text">*</span></label>
                        <small id="txtfecha_inicio-error" class="error red-text"></small>
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
      consultarTipoArticulacion(1);
      
      $divEmpresa = $("#divEmpresa");
      $divEmpresa.show();
      

      $('#empresasDeTecnoparque_ArticulacionCreate_table').DataTable({
        "lengthMenu": [[5, 25, 50, -1], [5, 25, 50, "All"]],
        language: {
          "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
        },
        processing: true,
        serverSide: true,
        ajax:{
          url: host_url + "/empresa/datatableEmpresasDeTecnoparque",
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

    });

    $(document).on('submit', 'form#fmrIntervencionCreate', function (event) {
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
              icon: 'warning',
              showCancelButton: false,
              confirmButtonColor: '#3085d6',
              confirmButtonText: 'Ok'
            })
          } else {
            Swal.fire({
              title: 'Registro Exitoso',
              text: "La articulación ha sido creado satisfactoriamente",
              icon: 'success',
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
    });

    function addEmpresaArticulacion(id) {
      $.ajax({
        dataType:'json',
        type:'get',
        url: host_url + "/empresa/ajaxDetallesDeUnaEmpresa/"+id
      }).done(function(respuesta){
        $('#empresa').val(respuesta.detalles.nit + ' - ' + respuesta.detalles.nombre_empresa);
        $("label[for='empresa']").addClass('active');
        $('#txtempresa_id').val(respuesta.detalles.id);
        Swal.fire({
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 3000,
          icon: 'success',
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
