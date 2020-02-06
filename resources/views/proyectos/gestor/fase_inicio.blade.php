@extends('layouts.app')
@section('meta-title', 'Proyectos de Base Tecnológica')
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
                <span class="card-title center-align"><b>Proyecto -
                    {{ $proyecto->articulacion_proyecto->actividad->codigo_actividad }}</b></span>
              </center>
              <div class="divider"></div>
              <div class="card-panel red lighten-3">
                <div class="card-content white-text">
                  <a class="btn-floating red"><i class="material-icons left">info_outline</i></a>
                  <span>Los elementos con (*) son obligatorios</span>
                </div>
              </div>
              <br />
              <div class="row">
                <div class="steps clearfix">
                  <ul role="tablist" class="tabs z-depth-1" style="width: 100%;">
                    <li role="tab" class="first current tab" aria-disabled="false" aria-selected="true">
                      <a href="{{ route('proyecto.inicio', $proyecto->id) }}" aria-controls="steps-uid-0-p-0" class="active">
                        <span class="number">1.</span>
                        Inicio
                      </a>
                    </li>
                    <li role="tab" class="tab" aria-disabled="true">
                      <a id="steps-uid-0-t-1" href="#steps-uid-0-h-1" aria-controls="steps-uid-0-p-1">
                        <span class="number">2.</span>
                        Planeación
                      </a>
                    </li>
                    <li role="tab" class="tab" aria-disabled="true">
                      <a id="steps-uid-0-t-2" href="#steps-uid-0-h-2" aria-controls="steps-uid-0-p-2">
                        <span class="number">3.</span>
                        Ejecución
                      </a>
                      </li>
                    <li role="tab" class="last tab" aria-disabled="true">
                      <a id="steps-uid-0-t-3" href="#steps-uid-0-h-3" aria-controls="steps-uid-0-p-3">
                        <span class="number">4.</span>
                        Cierre
                      </a>
                    </li>
                    <div class="indicator" style="right: 1179px; left: 0px;"></div>
                  </ul>
                </div>
              </div>
              <div class="row center">
                <a class="btn-large blue-grey m-b-xs" href="{{route('proyecto.entregables.inicio', $proyecto->id)}}">
                  <i class="material-icons left">library_books</i>
                  Entregables de la Fase de Inicio
                </a>
              </div>
              <form id="frmProyectosCreate" action="{{route('proyecto.update', $proyecto->id)}}" method="POST">
                {!! method_field('PUT')!!}
                @include('proyectos.gestor.form_inicio', [
                'btnText' => 'Modificar'])
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
  $( document ).ready(function() {
  @if($proyecto->nombre_areaconocimiento == 'Otro')
    divOtroAreaConocmiento.show();
  @endif
  @if($proyecto->economia_naranja == 1)
  divEconomiaNaranja.show();
  @endif
  @if($proyecto->dirigido_discapacitados == 1)
  divDiscapacidad.show();
  @endif
  @if($proyecto->art_cti == 1)
  divNombreActorCTi.show();
  @endif
  });

    // function ajaxUpdateProyecto(form, data, url) {
    //   $('button[type="submit"]').attr('disabled', 'disabled');
    //   $.ajax({
    //     type: form.attr('method'),
    //     url: url,
    //     data: data,
    //     dataType: 'json',
    //     cache: false,
    //     contentType: false,
    //     processData: false,
    //     success: function (data) {
    //       $('button[type="submit"]').removeAttr('disabled');
    //       // $('button[type="submit"]').prop("disabled", false);
    //       $('.error').hide();
    //       if (data.fail) {
    //         let errores = "";
    //         for (control in data.errors) {
    //           errores += ' </br><b> - ' + data.errors[control] + ' </b> ';
    //           $('#' + control + '-error').html(data.errors[control]);
    //           $('#' + control + '-error').show();
    //         }
    //         Swal.fire({
    //           title: 'Advertencia!',
    //           html: 'Estas ingresando mal los datos.' + errores,
    //           type: 'error',
    //           showCancelButton: false,
    //           confirmButtonColor: '#3085d6',
    //           confirmButtonText: 'Ok'
    //         });
    //       }
    //       if (data.revisado_final == 'Por Evaluar') {
    //         Swal.fire({
    //           title: 'Error!',
    //           text: "Para poder cerrar el proyecto, debe estar Aprobado o No Aprobado por el Dinamizador!",
    //           type: 'error',
    //           showCancelButton: false,
    //           confirmButtonColor: '#3085d6',
    //           confirmButtonText: 'Ok'
    //         })
    //       }
    //       if ( data.result ) {
    //         Swal.fire({
    //           title: 'Modificación Exitosa',
    //           text: "El proyecto se modificado satisfactoriamente",
    //           type: 'success',
    //           showCancelButton: false,
    //           confirmButtonColor: '#3085d6',
    //           confirmButtonText: 'Ok'
    //         });
    //         setTimeout(function(){
    //           window.location.replace("{{route('proyecto')}}");
    //         }, 1000);
    //       }
    //       if ( data.resulta == false ) {
    //         Swal.fire({
    //           title: 'Modificación Errónea!',
    //           text: "El proyecto no se ha modificado.",
    //           type: 'error',
    //           showCancelButton: false,
    //           confirmButtonColor: '#3085d6',
    //           confirmButtonText: 'Ok'
    //         });
    //       }
    //     },
    //     error: function (xhr, textStatus, errorThrown) {
    //       alert("Error: " + errorThrown);
    //     }
    //   });
    // }


</script>
@endpush