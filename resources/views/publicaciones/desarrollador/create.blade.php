@extends('layouts.app')
@section('meta-title', 'Publicaciones')
@section('meta-content', 'Publicaciones')
@section('meta-keywords', 'Publicaciones')
@section('content')
  <main class="mn-inner inner-active-sidebar">
    <div class="content">
      <div class="row no-m-t no-m-b">
        <div class="col s12 m12 l12">
          <h5>
            <a class="footer-text left-align" href="{{route('publicacion.index')}}">
              <i class="left material-icons arrow-l">event</i>
            </a> Publicaciones
          </h5>
          <div class="card">
            <div class="card-content">
              <div class="row">
                <div class="col s12 m12 l12">
                  <br>
                  <center>
                    <span class="card-title center-align">Nueva Publicación</span>
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
                  <form id="frmPublicacionesCreate" method="POST" action="{{ route('publicacion.store') }}">
                    @include('publicaciones.desarrollador.form')
                    <center>
                      <button type="submit" class="cyan darken-1 btn center-aling"><i class="material-icons right">done_all</i>Registrar</button>
                      <a href="{{route('publicacion.index')}}" class="waves-effect red lighten-2 btn center-aling"><i class="material-icons right">backspace</i>Cancelar</a>
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
    //Enviar formulario
    $(document).on('submit', 'form#frmPublicacionesCreate', function (event) {
      // $('button[type="submit"]').prop("disabled", true);
      $('button[type="submit"]').attr('disabled', 'disabled');
      event.preventDefault();
      let form = $(this);
      let data = new FormData($(this)[0]);
      let url = form.attr("action");
      ajaxPublicacionCreate(form, data, url);
    });

    function ajaxPublicacionCreate(form, data, url) {
      $.ajax({
        type: form.attr('method'),
        url: url,
        data: data,
        cache: false,
        contentType: false,
        dataType: 'json',
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
              icon: 'error',
              showCancelButton: false,
              confirmButtonColor: '#3085d6',
              confirmButtonText: 'Ok'
            });
          }
          if (data.fail == false && data.redirect_url == false) {
            Swal.fire({
              title: 'La publicación no se ha registrado, por favor inténtalo de nuevo.',
              icon: 'warning',
              showCancelButton: false,
              confirmButtonColor: '#3085d6',
              confirmButtonText: 'Ok'
            })
          }
          if (data.fail == false && data.redirect_url != false) {
            Swal.fire({
              title: 'Registro Exitoso',
              text: "La publicación ha sido creada satisfactoriamente",
              icon: 'success',
              showCancelButton: false,
              confirmButtonColor: '#3085d6',
              confirmButtonText: 'Ok'
            });
            setTimeout(function(){
              window.location.replace("{{route('publicacion.index')}}");
            }, 1000);
          }
        },
        error: function (xhr, textStatus, errorThrown) {
          alert("Error: " + errorThrown);
        }
      });
    };
  </script>
@endpush
