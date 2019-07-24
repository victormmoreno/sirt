@extends('layouts.app')
@section('meta-title', 'Eventos de Divulación Tecnológica')
@section('content')
  <main class="mn-inner inner-active-sidebar">
    <div class="content">
      <div class="row no-m-t no-m-b">
        <div class="col s12 m12 l12">
          <h5><a class="footer-text left-align" href="{{route('edt')}}">
            <i class="material-icons arrow-l">arrow_back</i>
          </a> Edt </h5>
          <div class="card">
            <div class="card-content">
              <div class="row">
                <center><span class="card-title center-align">Nueva Edt</span> <i class="small material-icons prefix">record_voice_over</i></center>
                <form method="post" id="formEdtCreate" action="{{route('edt.store')}}">
                  @include('edt.gestor.form', [
                    'btnText' => 'Registrar'
                  ])
                </form>
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
  function ajaxCreateEdt(form, data, url) {
    $('button[type="submit"]').attr('disabled', 'disabled');
    $.ajax({
      type: form.attr('method'),
      url: url,
      data: data,
      cache: false,
      contentType: false,
      processData: false,
      success: function (data) {
        $('button[type="submit"]').removeAttr('disabled');
        $('.error').hide();
        if (data.fail) {
          Swal.fire({
            title: 'Registro Erróneo',
            text: "Estas ingresando mal los datos!",
            type: 'error',
            showCancelButton: false,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Ok'
          })
          for (control in data.errors) {
            $('#' + control + '-error').html(data.errors[control]);
            $('#' + control + '-error').show();
          }
        }
        if ( data.fail == false && data.redirect_url == "false" ) {
          Swal.fire({
            title: 'Registro Erróneo',
            text: "La Edt no se ha registrado!",
            type: 'error',
            showCancelButton: false,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Ok'
          });
        }
        if ( data.fail == false && data.redirect_url != "false" ) {
          Swal.fire({
            title: 'Registro Exitoso',
            text: "La Edt se ha registrado satisfactoriamente!",
            type: 'success',
            showCancelButton: false,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Ok'
          });
          setTimeout(function(){
            window.location.replace(data.redirect_url);
          }, 1000);
        }
      },
      error: function (xhr, textStatus, errorThrown) {
        alert("Error: " + errorThrown);
      }
    });
  }

  //Enviar formulario
  $(document).on('submit', 'form#formEdtCreate', function (event) {
    // $('button[type="submit"]').prop("disabled", true);
    event.preventDefault();
    var form = $(this);
    var data = new FormData($(this)[0]);
    var url = form.attr("action");
    ajaxCreateEdt(form, data, url);
  });
</script>
@endpush
