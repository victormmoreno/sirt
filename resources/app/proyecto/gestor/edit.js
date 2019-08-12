
  //Enviar formulario
  $(document).on('submit', 'form#frmProyectosCreate', function (event) {
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
      cache: false,
      contentType: false,
      processData: false,
      success: function (data) {
        $('button[type="submit"]').removeAttr('disabled');
        // $('button[type="submit"]').prop("disabled", false);
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
        if (data.fail == false && data.redirect_url == false) {
          Swal.fire({
            title: 'El proyecto no se ha registrado, por favor inténtalo de nuevo',
            // text: "You won't be able to revert this!",
            type: 'warning',
            showCancelButton: false,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Ok'
          })
        }
        if (data.fail == false && data.redirect_url != false) {
          Swal.fire({
            title: 'Registro Exitoso',
            text: "El proyecto ha sido creado satisfactoriamente",
            type: 'success',
            showCancelButton: false,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Ok'
          });
          setTimeout(function(){
            window.location.replace("{{route('proyecto')}}");
          }, 1000);
        }
      },
      error: function (xhr, textStatus, errorThrown) {
        alert("Error: " + errorThrown);
      }
    });
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

  // -- Cambia la idea asociada a null en caso de que se cambie el check del campo "¿La idea de proyecto se aprobó en el CSIBT?"
  function resetIdeaDeProyectoAsociadaAlProyecto() {
    $('#txtidea_id').val("");
    $('#txtnombreIdeaProyecto_Proyecto').val("");
    $("label[for='txtnombreIdeaProyecto_Proyecto']").removeClass('active');
  }

  // Consultas las ideas de proyecto si fueron aprobadas en el comité ó si son con empresa  emprendedor
  function consultarIdeasDeProyectoDelNodo() {
    let tipo = 0;
    if ( $('#ideaProyecto').is(':checked') ) {
      tipo = 1;
    }
    if (tipo == 1) {
      consultarIdeasDeProyectoEmprendedores_Proyecto();
    } else {
      consultarIdeasDeProyectoGruposOEmpresas_Proyecto();
    }

  }
  //
  function consultarIdeasDeProyectoEmprendedores_Proyecto() {
    $('#ideasDeProyectoConEmprendedores_proyecto_table').dataTable().fnDestroy();
    $('#ideasDeProyectoConEmprendedores_proyecto_table').DataTable({
      language: {
        "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
      },
      processing: true,
      serverSide: true,
      order: [ 0, 'desc' ],
      ajax:{
        url: "/proyecto/datatableIdeasConEmprendedores",
        type: "get",
      },
      select: true,
      columns: [
        {
          data: 'codigo_idea',
          name: 'codigo_idea',
        },
        {
          data: 'nombre_proyecto',
          name: 'nombre_proyecto',
        },
        {
          data: 'nombres_contacto',
          name: 'nombres_contacto',
        },
        {
          width: '20%',
          data: 'checkbox',
          name: 'checkbox',
          orderable: false,
        },
      ],
    });
    $('#ideasDeProyectoConEmprendedores_modal').openModal({
      dismissible: false,
    });
  }

  //
  function consultarIdeasDeProyectoGruposOEmpresas_Proyecto() {
    $('#ideasDeProyectoConEmpresasGrupos_proyecto_table').dataTable().fnDestroy();
    $('#ideasDeProyectoConEmpresasGrupos_proyecto_table').DataTable({
      language: {
        "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
      },
      processing: true,
      serverSide: true,
      order: [ 0, 'desc' ],
      ajax:{
        url: "/proyecto/datatableIdeasConEmpresasGrupo",
        type: "get",
      },
      select: true,
      columns: [
        {
          data: 'codigo_idea',
          name: 'codigo_idea',
        },
        // {
          //   data: 'nombre_proyecto',
          //   name: 'nombre_proyecto',
          // },
          {
            data: 'nombre_proyecto',
            name: 'nombre_proyecto',
          },
          {
            width: '20%',
            data: 'checkbox',
            name: 'checkbox',
            orderable: false,
          },
        ],
      });
      $('#ideasDeProyectoConEmpresasGrupos_modal').openModal({
        dismissible: false,
      });
    }

  function asociarIdeaDeProyectoAProyecto(id, nombre, codigo) {
    $('#txtidea_id').val(id);
    $('#ideasDeProyectoConEmprendedores_modal').closeModal();
    $('#ideasDeProyectoConEmpresasGrupos_modal').closeModal();
    Swal.fire({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 1500,
      type: 'success',
      title: 'La siguiente idea se ha asociado al proyecto: ' + codigo + ' - ' + nombre
    });
    $('#txtnombreIdeaProyecto_Proyecto').val(codigo +" - "+ nombre);
    $('#txtnombre').val(nombre);
    $("label[for='txtnombreIdeaProyecto_Proyecto']").addClass('active');
    $("label[for='txtnombre']").addClass('active');
  }


  // Edita el nombre de la universidad que se asociará con el proyecto
  function editarNombreUniversidad(value) {
    Swal.fire({
      title: '¿Cuál es la universidad con la que se realizará el proyecto?',
      input: 'text',
      inputValue: value,
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
    $('#txttipoarticulacionproyecto_id').val("");
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
