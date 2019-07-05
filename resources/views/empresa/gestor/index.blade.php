@extends('layouts.app')
@section('meta-title', 'Empresas')
@section('content')
<main class="mn-inner inner-active-sidebar">
  <div class="content">
    <div class="row no-m-t no-m-b">
      <div class="col s12 m12 l12">
        <h5>Empresas</h5>
        <div class="card">
          <div class="card-content">
            <div class="row">
              <div class="col s12 m12 l12">
                <div class="row">
                  <div class="col s12 m10 l10">
                    <div class="center-align">
                      <span class="card-title center-align">Empresas de Tecnoparque</span>
                    </div>
                  </div>
                  <div class="col s12 m2 l2">
                    <div class="click-to-toggle show-on-large hide-on-med-and-down">
                      <a href="{{route('empresa.create')}}" class="btn btn-floating btn-large tooltipped green" data-position="bottom" data-delay="50" data-tooltip="Nueva Empresa">
                        <i class="material-icons">exposure_plus_1</i>
                      </a>
                    </div>
                  </div>
                </div>
                {{-- <a class="btn orange lighten-3 m-b-xs modal-trigger" id="modalContactos2" href="#contactosDeUnaEntidad_modal"> --}}
                <i class="material-icons">local_phone</i>
                </a>
                <div class="divider"></div>
                <table style="width: 100%" id="empresasDeTecnoparque_table" class="display responsive-table datatable-example dataTable">
                  <thead>
                    <tr>
                      <th>Nit</th>
                      <th>Nombre de la Empresa</th>
                      <th>Sector de la Empresa</th>
                      <th>Ciudad - Departamento</th>
                      <th>Dirección</th>
                      <th>Detalles</th>
                      <th>Contactos</th>
                      <th>Editar</th>
                    </tr>
                  </thead>
                  <tbody>

                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="fixed-action-btn show-on-medium-and-down hide-on-med-and-up">
        <a href="{{route('empresa.create')}}" class="btn btn-floating btn-large tooltipped green" data-position="left" data-delay="50" data-tooltip="Nueva Empresa">
          <i class="material-icons">exposure_plus_1</i>
        </a>
      </div>
    </div>
  </div>
</main>
@include('empresa.modals')
@endsection
@push('script')
  <script>
  var cont = 1;
  $(document).on('submit', 'form#frmContactosEntidades', function (event) {
    $('button[type="submit"]').attr('disabled', 'disabled');
    event.preventDefault();
    var form = $(this);
    // form.attr("action");
    var data = new FormData($(this)[0]);
    var url = form.attr("action");
    console.log(data);
    ajaxEditContactosDeEmpresa(form, url, data);

  });

  // Método para agregar talentos a una articulación
  function addNuevoContacto() {
    $("#contactosDeUnaEntidad_table").append(
      '<tr id='+cont+'>'
      +'<td>'
      +'<input name="txtnombres_contactos[]" value="" />'
      +'<label for="txtnombres_contactos[]">Nombres del Contacto</label>'
      +'<small id="txtnombres_contactos[]-error" class="error red-text"></small>'
      +'</td>'
      +'<td>'
      +'<input name="txtcorreo_contacto[]" value="" />'
      +'<label for="txtcorreo_contacto[]">Nombres del Contacto</label>'
      +'<small id="txtcorreo_contacto[]-error" class="error red-text"></small>'
      +'</td>'
      +'<td>'
      +'<input name="txttelefono_contacto[]" value="" />'
      +'<label for="txttelefono_contacto[]">Nombres del Contacto</label>'
      +'<small id="txttelefono_contacto[]-error" class="error red-text"></small>'
      +'</td>'
      +'<td>'
      +'<input disabled value="{{ \NodoHelper::returnNodoUsuario() }}" />'
      +'</td>'
      +'<td>'
      +'<a class="waves-effect red lighten-3 btn" onclick="eliminar('+cont+');"><i class="material-icons">delete_sweep</i></a>'
      +'</td>'
      +'</tr>'
    );
    cont++;
  }

  function ajaxEditContactosDeEmpresa(form, url, data) {
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
            html: "La articulación ha sido modificada satisfactoriamente",
            type: 'success',
            showCancelButton: false,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Ok'
          });
          // setTimeout(function(){
          //   window.location.replace("");
          // }, 1000);
        }
      },
      error: function (xhr, textStatus, errorThrown) {
        alert("Error: " + errorThrown);
      }
    });
  }

  function consultarContactosDeUnaEntidad(id){
    $.ajax({
      dataType:'json',
      type:'get',
      url:'/empresa/ajaxContactosDeUnaEntidad/'+id
    }).done(function (response) {
      if (response.contactos.length == 0) {
        Swal.fire(
          'Ups!!',
          'No se han encontrado contactos con esta empresa!',
          'warning'
        );
      } else {
        $("#contactosDeUnaEntidad_titulo").empty();
        $("#contactosDeUnaEntidad_table").empty();
        $("#contactosDeUnaEntidad_titulo").append("<span class='cyan-text text-darken-3'>Datos de los Contactos </span><br>");
        $.each(response.contactos, function( index, value ) {
          $("#contactosDeUnaEntidad_table").append(
            '<tr id='+cont+'>'
            +'<td>'
            +'<input name="txtnombres_contactos[]" value='+value.nombres_contacto+'>'
            +'<label for="txtnombres_contactos[]">Nombres del Contacto</label>'
            +'<small id="txtnombres_contactos[]-error" class="error red-text"></small>'
            +'</td>'
            +'<td>'
            +'<input name="txtcorreo_contacto[]" value='+value.correo_contacto+'>'
            +'<label for="txtcorreo_contacto[]">Correo del Contacto</label>'
            +'<small id="txtcorreo_contacto[]-error" class="error red-text"></small>'
            +'</td>'
            +'<td>'
            +'<input name="txttelefono_contacto[]" value='+value.telefono_contacto+'>'
            +'<label for="txttelefono_contacto[]">Teléfono del Contacto</label>'
            +'<small id="txttelefono_contacto[]-error" class="error red-text"></small>'
            +'</td>'
            +'<td>'
            +'<input disabled value='+value.nodo+' />'
            +'</td>'
            +'<td>'
            +'<a class="waves-effect red lighten-3 btn" onclick="eliminar('+cont+');"><i class="material-icons">delete_sweep</i></a>'
            +'</td>'
            +'</tr>'
          );
          cont++;
        });
        // console.log(response.route);
        $('#frmContactosEntidades').attr('action', response.route);
        // form.attr("action", response.ruta);
        $('#contactosDeUnaEntidad_modal').openModal();
      }
    })
  }

  function eliminar(index){
    $('#'+index).remove();
  }
  </script>
@endpush
