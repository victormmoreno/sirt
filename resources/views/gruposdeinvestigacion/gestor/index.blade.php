@extends('layouts.app')
@section('meta-title', 'Grupos de Investigación')
@section('meta-content', 'Grupos de Investigación')
@section('meta-keywords', 'Grupos de Investigación')
@section('content')
<link rel="stylesheet" type="text/css" href="{{ asset('css/Edicion_Text.css') }}">
<main class="mn-inner inner-active-sidebar">
  <div class="content">
    <div class="row no-m-t no-m-b">
      <div class="col s12 m12 l12">
        <h5><i class="left material-icons">group_work</i>Grupos de Investigación</h5>
        <div class="card">
          <div class="card-content">
            <div class="row">
              <div class="col s12 m12 l12">
                <div class="row">
                  <div class="col s12 m10 l10">
                    <div class="center-align">
                      <span class="card-title center-align">Grupos de Investigación de Tecnoparque</span>
                    </div>
                  </div>
                  <div class="col s12 m2 l2">
                    <a href="{{ route('grupo.create') }}">
                      <div class="card green">
                        <div class="card-content center">
                          <i class="left valign-wrap material-icons white-text">add</i>
                          <span class="white-text">Nuevo Grupo de Investigación</span>
                        </div>
                      </div>
                    </a>
                  </div>
                </div>
                <div class="divider"></div>
                <table style="width: 100%" id="grupoDeInvestigacionTecnoparque_table" class="display responsive-table datatable-example dataTable">
                  <thead>
                    <tr>
                      <th>Código del Grupo de Investigación</th>
                      <th>Nombre del Grupo de Investigación</th>
                      <th>Ciudad</th>
                      <th>Tipo de Grupo de Investigación</th>
                      <th>Institución</th>
                      <th>Clasificación de Colciencias</th>
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
    </div>
  </div>
</main>
<div id="detalleDeUnGrupoDeInvestigacion" class="modal">
  <div class="modal-content">
    <center><h4 id="modalDetalleDeUnGrupoDeInvestigacion_titulo" class="center-aling"></h4></center>
    <div class="divider"></div>
    <div id="modalDetalleDeUnGrupoDeInvestigacion_detalle_empresa"></div>
  </div>
  <div class="modal-footer white-text">
    <a href="#!" class="modal-action modal-close waves-effect waves-yellow btn-flat">Cerrar</a>
  </div>
</div>
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
    // console.log(data);
    ajaxEditContactosDeGrupo(form, url, data);

  });

  // Método para agregar talentos a una articulación
  function addNuevoContacto() {
    $("#contactosDeUnaEntidad_table").append(
      '<tr id='+cont+'>'
      +'<td>'
      +'<input class="validate" required type="text" id="txtnombres_contactos'+cont+'" pattern=".{10,60}" maxlength="60" name="txtnombres_contactos[]" value="" />'
      +'<span class="helper-text" data-error></span>'
      // +'<label for="txtnombres_contactos[]">Nombres del Contacto</label>'
      // +'<small id="txtnombres_contactos[]-error" class="error red-text"></small>'
      +'</td>'
      +'<td>'
      +'<input class="validate" required type="email" id="txtcorreo_contacto'+cont+'" pattern=".{7,100}" maxlength="100" name="txtcorreo_contacto[]" value="" />'
      +'<span class="helper-text" data-error></span>'
      // +'<label for="txtcorreo_contacto[]">Nombres del Contacto</label>'
      // +'<small id="txtcorreo_contacto[]-error" class="error red-text"></small>'
      +'</td>'
      +'<td>'
      +'<input class="validate" required type="text" id="txttelefono_contacto'+cont+'" patten=".{7,11}" maxlength="11" name="txttelefono_contacto[]" value="" />'
      +'<span class="helper-text" data-error></span>'
      // +'<label for="txttelefono_contacto[]">Nombres del Contacto</label>'
      // +'<small id="txttelefono_contacto[]-error" class="error red-text"></small>'
      +'</td>'
      +'<td>'
      +'<input disabled value="{{ \NodoHelper::returnNameNodoUsuario() }}" />'
      +'</td>'
      +'<td>'
      +'<a class="waves-effect bg-danger white-text btn" onclick="eliminar('+cont+');"><i class="material-icons">delete_sweep</i></a>'
      +'</td>'
      +'</tr>'
    );
    cont++;
  }

  function ajaxEditContactosDeGrupo(form, url, data) {
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
            title: 'Modificación Errónea!',
            html: 'Estas ingresando información errónea, por favor verifica los datos.',
            type: 'error',
            showCancelButton: false,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Ok'
          });
        } else {
          Swal.fire({
            title: '<b>Modificación Exitosa</b>',
            html: "Los contactos del grupo de investigación han sido modificados satisfactoriamente",
            type: 'success',
            showCancelButton: false,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Ok'
          });
          setTimeout(function(){
            window.location.replace("grupo");
          }, 1000);
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
      url: host_url + '/grupo/ajaxContactosDeUnaEntidad/'+id
    }).done(function (response) {
      $("#contactosDeUnaEntidad_titulo").empty();
      $("#contactosDeUnaEntidad_table").empty();
      $("#contactosDeUnaEntidad_titulo").append("<span class='cyan-text text-darken-3'>Datos de los Contactos</span><br>");
      $.each(response.contactos, function( index, value ) {
        $("#contactosDeUnaEntidad_table").append(
          '<tr id='+cont+'>'
          +'<td>'
          +'<input class="validate" required type="text" id="txtnombres_contactos'+cont+'" pattern=".{10,60}" length="60" maxlength="60" name="txtnombres_contactos[]" value="'+value.nombres_contacto+'">'
          // +'<label for="txtnombres_contactos'+cont+'">Nombres del Contacto</label>'
          +'<span class="helper-text" data-error></span>'
          +'</td>'
          +'<td>'
          +'<input class="validate" required type="email" id="txtcorreo_contacto'+cont+'" pattern=".{7,100}" length="100" maxlength="100" name="txtcorreo_contacto[]" value="'+value.correo_contacto+'">'
          // +'<label for="txtcorreo_contacto'+cont+'">Correo del Contacto</label>'
          +'<span class="helper-text" data-error></span>'
          +'</td>'
          +'<td>'
          +'<input class="validate" required type="text" id="txttelefono_contacto'+cont+'" patten=".{7,11}" length="11" maxlength="11"  name="txttelefono_contacto[]" value="'+value.telefono_contacto+'">'
          // +'<label for="txttelefono_contacto'+cont+'">Teléfono del Contacto</label>'
          +'<span class="helper-text" data-error></span>'
          +'</td>'
          +'<td>'
          +'<input disabled id="nodo" value='+value.nodo+' />'
          // +'<label for="nodo">Nodo con contacto</label>'
          +'</td>'
          +'<td>'
          +'<a class="waves-effect bg-danger white-text btn" onclick="eliminar('+cont+');"><i class="material-icons">delete_sweep</i></a>'
          +'</td>'
          +'</tr>'
        );
        cont++;
      });
      // console.log(response.route);
      $('#frmContactosEntidades').attr('action', response.route);
      // form.attr("action", response.ruta);
      $('#contactosDeUnaEntidad_modal').openModal();
    })
  }

  function eliminar(index){
    $('#'+index).remove();
  }
</script>
@endpush
