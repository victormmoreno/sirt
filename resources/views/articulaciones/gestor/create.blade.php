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
                  <form id="frmArticulacion_FaseInicio" method="POST" action="{{route('articulacion.store')}}">
                    @include('articulaciones.gestor.form_inicio', [
                        'btnText' => 'Guardar'])
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
@include('articulaciones.modals')
@push('script')
<script>
    $(document).ready(function() {
        consultarTalentosDeTecnoparque_Articulacion_FaseInicio_table('#talentosDeTecnoparque_Articulacion_FaseInicio_table', 'add_articulacion');
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

    // function addGrupoArticulacion(id) {
    //   $.ajax({
    //     dataType:'json',
    //     type:'get',
    //     url:"/grupo/ajaxDetallesDeUnGrupoInvestigacion/"+id
    //   }).done(function(respuesta){
    //     $('#grupoInvestigacion').val(respuesta.detalles.codigo_grupo + ' - ' + respuesta.detalles.entidad.nombre);
    //     $("label[for='grupoInvestigacion']").addClass('active');
    //     $('#txtgrupo_id').val(respuesta.detalles.id);
    //     Swal.fire({
    //       toast: true,
    //       position: 'top-end',
    //       showConfirmButton: false,
    //       timer: 3000,
    //       type: 'success',
    //       title: 'El código del grupo de investigación con el que se realizará la articulación es: ' + respuesta.detalles.codigo_grupo
    //     })
    //   })
    // }

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
