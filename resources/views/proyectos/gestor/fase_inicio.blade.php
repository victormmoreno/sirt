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
                  <span class="card-title center-align"><b>Proyecto - {{ $proyecto->codigo_proyecto }}</b></span>
                </center>
                <div class="divider"></div>
                <div class="card-panel red lighten-3">
                  <div class="card-content white-text">
                    <a class="btn-floating red"><i class="material-icons left">info_outline</i></a>
                    <span>Los elementos con (*) son obligatorios</span>
                  </div>
                </div>
                <br />
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
      resetDatosEntidad();
    });

    function ajaxUpdateProyecto(form, data, url) {
      $('button[type="submit"]').attr('disabled', 'disabled');
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
            let errores = "";
            for (control in data.errors) {
              errores += ' </br><b> - ' + data.errors[control] + ' </b> ';
              $('#' + control + '-error').html(data.errors[control]);
              $('#' + control + '-error').show();
            }
            Swal.fire({
              title: 'Advertencia!',
              html: 'Estas ingresando mal los datos.' + errores,
              type: 'error',
              showCancelButton: false,
              confirmButtonColor: '#3085d6',
              confirmButtonText: 'Ok'
            });
          }
          if (data.revisado_final == 'Por Evaluar') {
            Swal.fire({
              title: 'Error!',
              text: "Para poder cerrar el proyecto, debe estar Aprobado o No Aprobado por el Dinamizador!",
              type: 'error',
              showCancelButton: false,
              confirmButtonColor: '#3085d6',
              confirmButtonText: 'Ok'
            })
          }
          if ( data.result ) {
            Swal.fire({
              title: 'Modificación Exitosa',
              text: "El proyecto se modificado satisfactoriamente",
              type: 'success',
              showCancelButton: false,
              confirmButtonColor: '#3085d6',
              confirmButtonText: 'Ok'
            });
            setTimeout(function(){
              window.location.replace("{{route('proyecto')}}");
            }, 1000);
          }
          if ( data.resulta == false ) {
            Swal.fire({
              title: 'Modificación Errónea!',
              text: "El proyecto no se ha modificado.",
              type: 'error',
              showCancelButton: false,
              confirmButtonColor: '#3085d6',
              confirmButtonText: 'Ok'
            });
          }
        },
        error: function (xhr, textStatus, errorThrown) {
          alert("Error: " + errorThrown);
        }
      });
    }

    //Enviar formulario
    $(document).on('submit', 'form#frmProyectosCreate', function (event) {
      // $('button[type="submit"]').prop("disabled", true);
      event.preventDefault();
      let id = $("#txtestadoproyecto_id").val();
      let nombre = $("#txtestadoproyecto_id [value='"+id+"']").text();

      var form = $(this);
      var data = new FormData($(this)[0]);
      var url = form.attr("action");

      if (nombre == "Cierre PF" || nombre == "Cierre PMV") {
        Swal.fire({
          title: 'Advertenica!',
          html: "<p class='red-text'>Una vez cerrado un proyecto, no podrás volver a modificar los datos de este!</br>"
          +"<b>¿Estás seguro(a) de cerrar este proyecto?</b></p>",
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          cancelButtonText: 'Cancelar',
          confirmButtonText: 'Sí, cerrar definitivamente!'
        }).then((result) => {
          if (result.value) {
            ajaxUpdateProyecto(form, data, url);
          }
        })
      } else {
        ajaxUpdateProyecto(form, data, url);
      }


    });


    // Contenedores
    divPreload = $('#divPreload');
    divEntidadEmpresaProyecto = $('#divEntidadEmpresaProyecto');
    divEntidadGrupoInvestigacionProyecto = $('#divEntidadGrupoInvestigacionProyecto');
    divEntidadTecnoacademiaProyecto = $('#divEntidadTecnoacademiaProyecto');
    divEntidadNodoProyecto = $('#divEntidadNodoProyecto');
    divCentroFormacionProyecto = $('#divCentroFormacionProyecto');
    divUniversidadProyecto = $('#divUniversidadProyecto');
    divNombreActorCTi = $('#divNombreActorCTi');
    divOtroTipoArticulacion = $('#divOtroTipoArticulacion');
    divEntidadesTecnoparque = $('#divEntidadesTecnoparque');
    divFechaCierreProyecto = $('#divFechaCierreProyecto');
    divOtroEstadoPrototipo = $('#divOtroEstadoPrototipo');


    // Ocultar contenedores
    divPreload.hide();
    divEntidadEmpresaProyecto.hide();
    divEntidadGrupoInvestigacionProyecto.hide();
    divEntidadTecnoacademiaProyecto.hide();
    divEntidadNodoProyecto.hide();
    divCentroFormacionProyecto.hide();
    divUniversidadProyecto.hide();
    divNombreActorCTi.hide();
    divOtroTipoArticulacion.hide();
    divEntidadesTecnoparque.hide();
    divFechaCierreProyecto.hide();
    divOtroEstadoPrototipo.hide();


    function setFechaCierreProyecto() {
      // console.log('fecha de cierre');
      let id = $("#txtestadoproyecto_id").val();
      let nombre = $("#txtestadoproyecto_id [value='"+id+"']").text();

      if (nombre == "Cierre PF" || nombre == "Cierre PMV" || nombre == "Suspendido") {
        divFechaCierreProyecto.show();
      } else {
        divFechaCierreProyecto.hide();
      }
    }

    @if($proyecto->art_cti == 'Si')
    divNombreActorCTi.show();
    @endif

    function resetDatosEntidad() {
      @if($proyecto->nombre_tipoarticulacion == 'Otro')
      divOtroTipoArticulacion.show();
      @endif

      @if ($proyecto->nombre_tipoarticulacion == 'Empresas')
      divEntidadEmpresaProyecto.show();
      @endif


      @if($proyecto->nombre_tipoarticulacion == 'Empresas')
      divEntidadEmpresaProyecto.show();
      @endif

      @if ($proyecto->nombre_tipoarticulacion == 'Grupos y Semilleros del Sena' || $proyecto->nombre_tipoarticulacion == 'Grupos y Semilleros Externos')
      divEntidadGrupoInvestigacionProyecto.show();
      @endif

      @if ($proyecto->nombre_tipoarticulacion == 'Tecnoacademias')
      divEntidadTecnoacademiaProyecto.show();
      @endif

      @if ($proyecto->nombre_tipoarticulacion == 'Tecnoparques')
      divEntidadNodoProyecto.show();
      @endif

      @if ($proyecto->nombre_tipoarticulacion == 'Centros de Formación')
      divCentroFormacionProyecto.show();
      @endif

      @if ($proyecto->nombre_tipoarticulacion == 'Universidades')
      divUniversidadProyecto.show();
      @endif

      @if ($proyecto->nombre_tipoarticulacion == 'Emprendedor' || $proyecto->nombre_tipoarticulacion == 'Proyecto financiado por SENNOVA' || $proyecto->nombre_tipoarticulacion == 'Otro')
      divEntidadesTecnoparque.hide();
      @else
      divEntidadesTecnoparque.show();
      @endif
    }

    $('#talentosDeTecnoparque_ProyectoCreate_table').DataTable({
      // "lengthMenu": [[5, 25, 50, -1], [5, 25, 50, "All"]],
      language: {
        "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
      },
      processing: true,
      serverSide: true,
      // order: false,
      ajax:{
        url: "/usuario/talento/getTalentosDeTecnoparque/",
        type: "get",
      },
      columns: [
      {
        data: 'documento',
        name: 'documento',
      },
      {
        data: 'talento',
        name: 'talento',
      },
      {
        data: 'add_proyecto',
        name: 'add_proyecto',
        orderable: false,
      },
      ],
    });



    function consultarEntidadesSegunElCaso(id) {
      let nombre = $("#txttipoarticulacionproyecto_id [value='"+id+"']").text();
      if (nombre == 'Empresas') {
        $('#entidadesTecnoparque_proyecto_table').dataTable().fnDestroy();
        $('#entidadesTecnoparque_proyecto_table').DataTable({
          language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
          },
          processing: true,
          serverSide: true,
          order: [ 0, 'desc' ],
          ajax:{
            url: "/proyecto/datatableEmpresasTecnoparque",
            type: "get",
          },
          columns: [
            {
              title: 'Nit de la Empresa',
              data: 'nit',
              name: 'nit',
            },
            {
              title: 'Nombre de la Empresa',
              data: 'nombre_empresa',
              name: 'nombre_empresa',
            },
            {
              width: '20%',
              data: 'checkbox',
              name: 'checkbox',
              orderable: false,
            },
          ],
        });
        $('#entidadesTecnoparque_modProyecto_modal').openModal({
          dismissible: false,
        });
      }

      if (nombre == 'Tecnoacademias') {
        $('#entidadesTecnoparque_proyecto_table').dataTable().fnDestroy();
        $('#entidadesTecnoparque_proyecto_table').DataTable({
          language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
          },
          processing: true,
          serverSide: true,
          order: [ 0, 'desc' ],
          ajax:{
            url: "/proyecto/datatableTecnoacademiasTecnoparque",
            type: "get",
          },
          select: true,
          columns: [
            {
              title: 'Centro de Formación',
              data: 'codigo',
              name: 'codigo',
            },
            {
              title: 'Nombre de la Tecnoacademia',
              data: 'nombre',
              name: 'nombre',
            },
            {
              // title: 'Seleccionar para asociar a proyecto',
              width: '20%',
              data: 'checkbox',
              name: 'checkbox',
              orderable: false,
            },
          ],
        });
        $('#entidadesTecnoparque_modProyecto_modal').openModal({
          dismissible: false,
        });

      }

      if (nombre == 'Tecnoparques') {
        $('#entidadesTecnoparque_proyecto_table').dataTable().fnDestroy();
        $('#entidadesTecnoparque_proyecto_table').DataTable({
          language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
          },
          processing: true,
          serverSide: true,
          order: [ 0, 'desc' ],
          ajax:{
            url: "/proyecto/datatableNodosTecnoparque",
            type: "get",
          },
          select: true,
          columns: [
            {
              title: 'Centro de Formación',
              data: 'centro',
              name: 'centro',
            },
            {
              title: 'Nombre del Nodo',
              data: 'nombre_nodo',
              name: 'nombre_nodo',
            },
            {
              // title: 'Seleccionar para asociar a proyecto',
              width: '20%',
              data: 'checkbox',
              name: 'checkbox',
              orderable: false,
            },
          ],
        });
        $('#entidadesTecnoparque_modProyecto_modal').openModal({
          dismissible: false,
        });

      }

      if (nombre == 'Centros de Formación') {
        $('#entidadesTecnoparque_proyecto_table').dataTable().fnDestroy();
        $('#entidadesTecnoparque_proyecto_table').DataTable({
          language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
          },
          processing: true,
          serverSide: true,
          order: [ 0, 'desc' ],
          ajax:{
            url: "/proyecto/datatableCentroFormacionTecnoparque",
            type: "get",
          },
          select: true,
          columns: [
            {
              title: 'Código del Centro de Formación',
              data: 'codigo_centro',
              name: 'codigo_centro',
            },
            {
              title: 'Nombre del Centro de Formación',
              data: 'nombre',
              name: 'nombre',
            },
            {
              // title: 'Seleccionar para asociar a proyecto',
              width: '20%',
              data: 'checkbox',
              name: 'checkbox',
              orderable: false,
            },
          ],
        });
        $('#entidadesTecnoparque_modProyecto_modal').openModal({
          dismissible: false,
        });

      }

      if (nombre == 'Grupos y Semilleros del SENA' || nombre == 'Grupos y Semilleros Externos') {
        let tipo_grupo = 0;
        if (nombre == 'Grupos y Semilleros del SENA') {
          tipo_grupo = 1;
        }
        $('#entidadesTecnoparque_proyecto_table').dataTable().fnDestroy();
        $('#entidadesTecnoparque_proyecto_table').DataTable({
          language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
          },
          processing: true,
          serverSide: true,
          order: [ 0, 'desc' ],
          ajax:{
            url: "/proyecto/datatableGruposInvestigacionTecnoparque/"+tipo_grupo,
            type: "get",
          },
          select: true,
          columns: [
            {
              title: 'Código del Grupo de Investigación',
              data: 'codigo_grupo',
              name: 'codigo_grupo',
            },
            {
              title: 'Nombre del  Grupo de Investigación',
              data: 'nombre',
              name: 'nombre',
            },
            {
              // title: 'Seleccionar para asociar a proyecto',
              width: '20%',
              data: 'checkbox',
              name: 'checkbox',
              orderable: false,
            },
          ],
        });
        $('#entidadesTecnoparque_modProyecto_modal').openModal({
          dismissible: false,
        });

      }

      if (nombre == 'Universidades') {
        Swal.fire({
          title: '¿Cuál es la universidad con la que se realizará el proyecto?',
          input: 'text',
          inputValue: "",
          showCancelButton: true,
          cancelButtonColor: '#d33',
          cancelButtonText: '<a class="white-text" onclick="volverSiElegirEntidad(); Swal.close()">Cancelar</a>',
          showCancelButton: true,
          inputValidator: (value) => {
            if (!value) {
              return 'El nombre de la universidad es obligatorio!'
            }
            if (value.length > 50) {
              return 'El nombre de la universidad debe ser máximo de 50 carácteres!'
            }
            if (value) {
              $('#txtuniversidad_proyecto').val(value);
              $("label[for='txtuniversidad_proyecto']").addClass('active');
              divUniversidadProyecto.show();
            }
          }
        })
      }

      // if (nombre == ) {
      //
      // }
    }

    /**
     * Método que muestra una alerta para ingresar otro estado de prototipo
     */
     function setOtroEstadoPrototipo(id) {
       let nombre = $("#txtestadoprototipo_id [value='"+id+"']").text();
       if (nombre == 'Otro.') {
         divOtroEstadoPrototipo.show();
       } else {
         divOtroEstadoPrototipo.hide();
       }
     }

    // Edita el nombre de la universidad que se asociará con el proyecto
    function editarNombreUniversidad(value) {
      Swal.fire({
        title: '¿Cuál es la universidad con la que se realizará el proyecto?',
        input: 'text',
        inputValue: value,
        showCancelButton: true,
        cancelButtonColor: '#d33',
        cancelButtonText: '<a class="white-text" onclick="volverSiElegirEntidad(); Swal.close()">Cancelar</a>',
        showCancelButton: true,
        inputValidator: (value) => {
          if (!value) {
            return 'Debes ingresar el nombre de una universidad!'
          }
          if (value) {
            $('#txtuniversidad_proyecto').val(value);
            $("label[for='txtuniversidad_proyecto']").addClass('active');
            divUniversidadProyecto.show();
          }
        }
      })
    }

    // En caso de que no se asocie ninguna entidad al proyecto
    function volverSiElegirEntidad() {
      divEntidadesTecnoparque.hide();
      resetDatosEntidad();
      $('#txttipoarticulacionproyecto_id').val({{ $proyecto->tipoarticulacionproyecto_id }});
      $('#txttipoarticulacionproyecto_id').material_select();
    }

    // Función para cerrar el modal y asignarle un valor al
    function asociarEmpresaAProyecto(id, nit, nombre) {
      // console.log(id);
      $('#entidadesTecnoparque_modProyecto_modal').closeModal();
      Swal.fire({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 1500,
        type: 'success',
        title: 'La siguiente empresa se ha asociado al proyecto: ' + nit + ' - ' + nombre
      });
      $('#txtnombreEmpresa').val(nombre);
      $('#txtnitEmpresa').val(nit);
      $("label[for='txtnombreEmpresa']").addClass('active');
      $("label[for='txtnitEmpresa']").addClass('active');
      $('#txtentidad_proyecto_id').val(id);
      divEntidadEmpresaProyecto.show();
    }

    // Función para cerrar el modal y asignarle un valor al
    function asociarNodoAProyecto(id, codigo, nombre, centro) {
      // console.log(id);
      $('#entidadesTecnoparque_modProyecto_modal').closeModal();
      Swal.fire({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 1500,
        type: 'success',
        title: 'El siguiente centro de formación se ha asociado al proyecto: ' + codigo + ' con el siguiente nodo ' + nombre
      });
      $('#txtCentroFormacionNodo').val(centro);
      $('#txtNombreNodo').val(nombre);
      $("label[for='txtCentroFormacionNodo']").addClass('active');
      $("label[for='txtNombreNodo']").addClass('active');
      $('#txtentidad_proyecto_id').val(id);
      divEntidadNodoProyecto.show();
    }

    // Función para cerrar el modal y asignarle un valor al
    function asociarCentroDeFormacionAProyecto(id, codigo, nombre) {
      // console.log(id);
      $('#entidadesTecnoparque_modProyecto_modal').closeModal();
      Swal.fire({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 1500,
        type: 'success',
        title: 'El siguiente centro de formación se ha asociado al proyecto: ' + codigo + ' - ' + nombre
      });
      $('#txtCodigoCentroFormacion').val(codigo);
      $('#txtNombreCentroFormacion').val(nombre);
      $("label[for='txtCodigoCentroFormacion']").addClass('active');
      $("label[for='txtNombreCentroFormacion']").addClass('active');
      $('#txtentidad_proyecto_id').val(id);
      divCentroFormacionProyecto.show();
    }

    // Función para cerrar el modal y asignarle un valor al
    function asociarTecnoacademiaAProyecto(id, codigo, nombre, centro) {
      // console.log(id);
      $('#entidadesTecnoparque_modProyecto_modal').closeModal();
      Swal.fire({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        type: 'success',
        title: 'El siguiente centro de formación se ha asociado al proyecto: ' + codigo + ' con la siguiente tecnoacademia: ' + nombre
      });
      $('#txtcentroFormacion').val(centro);
      $('#txtnombreTecnoacademia').val(nombre);
      $("label[for='txtcentroFormacion']").addClass('active');
      $("label[for='txtnombreTecnoacademia']").addClass('active');
      $('#txtentidad_proyecto_id').val(id);
      divEntidadTecnoacademiaProyecto.show();
    }

    // Función para cerrar el modal y asignarle un valor al
    function asociarGrupoInvestigacionAProyecto(id, codigo, nombre) {
      // console.log(id);
      $('#entidadesTecnoparque_modProyecto_modal').closeModal();
      Swal.fire({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 1500,
        type: 'success',
        title: 'El siguiente grupo de investigación se ha asociado al proyecto: ' + codigo + ' - ' + nombre
      });
      $('#txtnombreGrupo').val(nombre);
      $('#txtcodigoGrupo').val(codigo);
      $("label[for='txtnombreGrupo']").addClass('active');
      $("label[for='txtcodigoGrupo']").addClass('active');
      $('#txtentidad_proyecto_id').val(id);
      divEntidadGrupoInvestigacionProyecto.show();
    }

    $('#txttipoarticulacionproyecto_id').change(function (){
      let id =  $("#txttipoarticulacionproyecto_id").val();
      let nombre = $("#txttipoarticulacionproyecto_id [value='"+id+"']").text();
      if (nombre == 'Otro') {
        divOtroTipoArticulacion.show();
      } else {
        divOtroTipoArticulacion.hide();
      }

      if (nombre != 'Empresas') {
        divEntidadEmpresaProyecto.hide();
      }

      if (nombre == 'Empresas') {
        divEntidadEmpresaProyecto.show();
      }

      if (nombre != 'Grupos y Semilleros del Sena' || nombre != 'Grupos y Semilleros Externos') {
        divEntidadGrupoInvestigacionProyecto.hide();
      }

      if (nombre != 'Tecnoacademias') {
        divEntidadTecnoacademiaProyecto.hide();
      }

      if (nombre != 'Tecnoparques') {
        divEntidadNodoProyecto.hide();
      }

      if (nombre != 'Centros de Formación') {
        divCentroFormacionProyecto.hide();
      }

      if (nombre != 'Universidades') {
        divUniversidadProyecto.hide();
      }

      if (nombre == 'Emprendedor' || nombre == 'Proyecto financiado por SENNOVA' || nombre == 'Otro') {
        divEntidadesTecnoparque.hide();
      } else {
        divEntidadesTecnoparque.show();
      }
    });

    $('#txtarti_cti').change(function() {
      if ( $('#txtarti_cti').is(':checked') ) {
        divNombreActorCTi.show();
      } else {
        divNombreActorCTi.hide();
      }
    });

    function noRepeat(id) {
      let idTalento = id;
      let retorno = true;
      let a = document.getElementsByName("talentos[]");
      for (x=0;x<a.length;x++){
        if (a[x].value == idTalento) {
          retorno = false;
          break;
        }
      }
      return retorno;
    }

    // Método para agregar talentos a una articulación
    function addTalentoProyecto(id) {
      if (noRepeat(id) == false) {
        Swal.fire({
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 1500,
          type: 'warning',
          title: 'El talento ya se encuentra asociado al proyecto!'
        });
      } else {
        // let talentos = document.getElementsByName("talentos[]");
        $.ajax({
          dataType:'json',
          type:'get',
          url:'/usuario/talento/consultarTalentoPorId/'+id,
        }).done(function(ajax){
          // <input type="text" id="rolTalento'+idTalento+'" value="" readonly>
          // El ajax.talento.id es el id del TALENTO, no del usuario
          let idTalento = ajax.talento.id;
          let fila = '<tr class="selected" id=talentoAsociadoAProyecto'+idTalento+'>'
          +'<td><input type="radio" class="with-gap" name="radioTalentoLider" id="radioButton'+id+'" value="'+idTalento+'" /><label for ="radioButton'+idTalento+'"></label></td>'
          +'<td><input type="hidden" name="talentos[]" value="'+idTalento+'">'+ajax.talento.documento+' - '+ajax.talento.talento+'</td>'
          +'<td><a class="waves-effect red lighten-3 btn" onclick="eliminar('+idTalento+');"><i class="material-icons">delete_sweep</i></a></td>'
          +'</tr>';
          $('#detalleTalentosDeUnProyecto_Create').append(fila);
          Swal.fire({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 1500,
            type: 'success',
            title: 'El talento se ha asociado al proyecto!'
          });
        });
      }
    }

    function eliminar(index){
      $('#talentoAsociadoAProyecto'+index).remove();
    }

  </script>
@endpush
