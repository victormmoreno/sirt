@extends('layouts.app')

@section('meta-title', 'Nuevo Uso de Infraestructura')

@section('content')
<main class="mn-inner inner-active-sidebar">
    <div class="content">
        <div class="row no-m-t no-m-b">
            <div class="col s12 m12 l12">
                <div class="row">
                    <div class="col s12 m8 l8">
                        <h5 class="left-align">
                            <a class="footer-text left-align" href="{{route('usoinfraestructura.index')}}">
                                <i class="material-icons arrow-l">
                                    arrow_back
                                </i>
                            </a>
                            Uso de Infraestructura
                        </h5>
                    </div>
                    <div class="col s12 m4 l4 push-m2 l2">
                        <ol class="breadcrumbs">
                            <li>
                                <a href="{{route('home')}}">
                                    Inicio
                                </a>
                            </li>
                            <li>
                                <a href="{{route('usoinfraestructura.index')}}">
                                    Uso de Infraestructura
                                </a>
                            </li>
                            <li class="active">
                                Nuevo Uso de Infraestructura
                            </li>
                        </ol>
                    </div>
                </div>
                <div class="card">
                    <div class="card-content">
                        @if($cantidadActividades != 0)
                        <div class="row">
                            <div class="row">
                                <center>
                                    <span class="card-title center-align">
                                        Nuevo Uso de Infraestructura
                                    </span>
                                    <i class="Small material-icons prefix">
                                        domain
                                    </i>
                                </center>
                                <div class="divider">
                                </div>
                                <form action="{{ route('usoinfraestructura.store')}}" id="formUsoInfraestructuraCreate" method="POST">
                                    @include('usoinfraestructura.form', [
                                        'btnText' => 'Guardar',
                                    ])
                                </form>
                            </div>
                        </div>
                        @else
                        <div class="row">
                            <div class="row">
                                <center>
                                    <span class="card-title center-align">
                                        Nuevo Uso de Infraestructura
                                    </span>
                                    <i class="Small material-icons prefix">
                                        domain
                                    </i>
                                </center>
                                <div class="divider">
                                </div>
                            </div>
                        </div>
                        <div class="center-align">
                            <i class="large material-icons prefix">
                                block
                            </i>
                            @if(session()->has('login_role') && session()->get('login_role') == App\User::IsGestor())
                            <p>
                                Aún no tienes proyectos en fase de inicio, planeacion o en fase de ejecución o puedes que no esten aprobados.
                            </p>
                            <p>
                                Aún no tienes articulaciones en fase de inicio o en fase de ejecución.
                            </p>
                            <p>
                                Aún no tienes EDTS registradas.
                            </p>
                            @elseif(session()->has('login_role') && session()->get('login_role') == App\User::IsTalento())
                            <p>
                                Aún no tienes proyectos en fase de inicio, planeacion o en fase de ejecución o puedes que no esten aprobados. Por favor consulta con el gestor asesor.
                            </p>
                            <p>
                                Aún no tienes articulaciones en fase de inicio o en fase de ejecución. Por favor consulta con el gestor asesor.
                            </p>
                            @endif
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@if($cantidadActividades != 0)
@include('usoinfraestructura.modals')
@endif
@endsection
@if($cantidadActividades != 0)
@push('script')
<script>
    $(document).ready(function() {
        $divActividad = $(".divActividad");
        $divActividad.hide();
        usoInfraestructuraCreate.checkTipoUsoInfraestrucuta();

    });

    var usoInfraestructuraCreate = {

        checkTipoUsoInfraestrucuta:function () {
            $( "input[name='txttipousoinfraestructura']" ).change(function (){
                if ( $("#IsProyecto").is(":checked") ) {
             
                    Swal.fire({
                        toast: true,
                        position: 'bottom-end',
                        title: 'proyecto',
                        text: "por favor seleccione un proyecto",
                        type: 'warning',
                        showConfirmButton: false,
                        timer: 10000
                    });
                    usoInfraestructuraCreate.limpiarInputsActividad();
                    usoInfraestructuraCreate.removeValueLineaGestor();
                    usoInfraestructuraCreate.eliminarContentTables();
                    usoInfraestructuraCreate.removeDisableSelectButtons();
                    usoInfraestructuraCreate.DatatableProjectsForUser();
                    usoInfraestructuraCreate.limpiarListaTalentos();
                    usoInfraestructuraCreate.limpiarListaEquipos();
                                   
                      
                } else if ( $("#IsArticulacion").is(":checked") ) {
                   
                    usoInfraestructuraCreate.limpiarInputsActividad();
                    usoInfraestructuraCreate.removeValueLineaGestor();
                    
                    Swal.fire({
                        toast: true,
                        position: 'bottom-end',
                        title: 'Articulación',
                        text: "por favor seleccione una articulación",
                        type: 'warning',
                        showConfirmButton: false,
                        timer: 10000
                    });
                    
                    usoInfraestructuraCreate.eliminarContentTables();
                    usoInfraestructuraCreate.dataTableArtculacionFindByUser();
                    usoInfraestructuraCreate.limpiarListaTalentos();
                    usoInfraestructuraCreate.limpiarListaEquipos();

                } else if( $("#IsEdt").is(":checked")) {
            
                    Swal.fire({
                        toast: true,
                        position: 'bottom-end',
                        title: 'EDT',
                        text: "por favor seleccione una edt ",
                        type: 'warning',
                        showConfirmButton: false,
                        timer: 10000
                    });
                    
                    usoInfraestructuraCreate.limpiarInputsActividad();
                    usoInfraestructuraCreate.eliminarContentTables();
                    usoInfraestructuraCreate.removeOptionsSelect();
                    usoInfraestructuraCreate.disableSelectButtons();
                    usoInfraestructuraCreate.dataTableEdtFindByUser();
                    usoInfraestructuraCreate.limpiarListaTalentos();
                    usoInfraestructuraCreate.limpiarListaEquipos();
                 
                }
               
              });
        },

        DatatableProjectsForUser: function () {
            $('#usoinfraestrucutaProjectsForUserTable').dataTable().fnDestroy();
              $('#usoinfraestrucutaProjectsForUserTable').DataTable({
                language: {
                  "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
                },
                processing: true,
                serverSide: true,
                "lengthChange": false,
                order: [ 0, 'desc' ],
                ajax:{
                  url: "/usoinfraestructura/projectsforuser",
                  type: "get",
                },
                select: true,
                columns: [
                  {
                    title: 'Codigo de proyecto',
                    data: 'codigo_actividad',
                    name: 'codigo_actividad',
                  },
                  {
                    title: 'Nombre del Proyecto',
                    data: 'nombre',
                    name: 'nombre',
                  },
                  {
                    width: '20%',
                    data: 'checkbox',
                    name: 'checkbox',
                    orderable: false,
                  },
                ],
              });

            $('#modalUsoIngraestrucuta_proyjects_modal').openModal({
                dismissible: false,
            });

            
        },

        getSelectTalentoProyecto:function (id){
            $.ajax({
                dataType:'json',
                type:'get',
                url:'/usoinfraestructura/talentosporproyecto/'+id
            }).done(function(response){

                $('#txttalento').empty();
                $('#txtequipo').empty();
                $('#txtgestor').removeAttr('value');
                $('#txtlinea').removeAttr('value');


                if (response != '') {
                    $('#txttalento').append('<option value="">Seleccione el talento</option>');
                    $('#txtequipo').append('<option value="">Seleccione el equipo</option>');
                    $.each(response.data, function(i, element) {

                        $('#txtgestor').val(element.articulacion_proyecto.actividad.gestor.user.documento+ ' - '+ element.articulacion_proyecto.actividad.gestor.user.nombres + ' ' + element.articulacion_proyecto.actividad.gestor.user.apellidos);
                        $("label[for='txtgestor']").addClass('active');

                        $('#txtlinea').val(element.articulacion_proyecto.actividad.gestor.lineatecnologica.abreviatura+ ' - '+ element.articulacion_proyecto.actividad.gestor.lineatecnologica.nombre);
                        $("label[for='txtlinea']").addClass('active');
                            

                      
                        $.each(element.articulacion_proyecto.talentos, function(e, talentos) {
                    
                            $('#txttalento').append('<option value="'+talentos.id+'">'+ talentos.user.documento +' - '+talentos.user.nombres+' '+ talentos.user.apellidos + '</option>');
                        });
                    });


                    $.each(response.data, function(i, element) {
       
                        $.each(element.articulacion_proyecto.actividad.gestor.lineatecnologica.equipos, function(e, equipo) {
                    
                            $('#txtequipo').append('<option  value="'+equipo.id+'">'+ equipo.nombre + '</option>');
                        });
                    });
                    

                }else{
                    $('#txttalento').append('<option value="">no se encontraron resultados</option>');
                    $('#txtequipo').append('<option value="">no se encontraron resultados</option>');
                   
                }

                $('#txttalento').select2();
                $('#txtequipo').select2();

               
            });
           
        },
        removeValueLineaGestor: function(){

            $('#txtlinea').removeAttr('value');
            $('#txtgestor').removeAttr('value');
            $('#txtlinea').attr('value','primero seleccione el tipo de uso de infraestructura');
            $('#txtgestor').attr('value','primero seleccione el tipo de uso de infraestructura');
        },
        removeOptionsSelect: function () {
            $('#txttalento')
            .empty()
            .append('<option selected="selected" value="">seleccione el talento</option>').select2();
            $('#txtequipo')
            .empty()
            .append('<option selected="selected"  value="">seleccione el equipo</option>').select2();          
        },

        disableSelectButtons: function () {
            $('#txttalento').attr("disabled", true).select2(); 
            
            $(".btnAgregarTalento").attr("disabled", true).removeAttr("onclick");
        },
        removeDisableSelectButtons: function () {
            $('#txttalento').attr("disabled", false).select2(); 
             $(".btnAgregarTalento").removeAttr("disabled").attr('onclick', 'addTalentoAUso()');
        },

        //ARTICULACIONES 
        dataTableArtculacionFindByUser: function () {
            $('#usoinfraestrucutaArticulacionesForUserTable').dataTable().fnDestroy();
            $('#usoinfraestrucutaArticulacionesForUserTable').DataTable({
                language: {
                  "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
                },
                processing: true,
                serverSide: true,
                "lengthChange": false,
                order: [ 0, 'desc' ],
                ajax:{
                  url: "/usoinfraestructura/articulacionesforuser",
                  type: "get",
                },
                select: true,
                columns: [
                  {
                    title: 'Codigo de Articulación',
                    data: 'codigo_actividad',
                    name: 'codigo_actividad',
                  },
                  {
                    title: 'Nombre del Proyecto',
                    data: 'nombre',
                    name: 'nombre',
                  },
                  {
                    title: 'tipo articulacion',
                    data: 'tipoarticulacion',
                        name: 'tipoarticulacion',
                  },
                  {
                    width: '20%',
                    data: 'checkbox',
                    name: 'checkbox',
                    orderable: false,
                  },
                ],
              });

            $('#txttalento').empty();
            $('#txtequipo').empty();

            $('#modalUsoIngraestrucuta_articulaciones_modal').openModal({
                dismissible: false,
            });
        },
        
        getSelectTalentoArtculacionEmprendedores:function (id){
            $.ajax({
                dataType:'json',
                type:'get',
                url:'/usoinfraestructura/talentosporarticulacion/'+id
            }).done(function(response){
                $('#txttalento').empty();
                $('#txtequipo').empty();
                $('#txtgestor').removeAttr('value');
                $('#txtlinea').removeAttr('value');

             

                $.each(response.data, function(i, element) {

                    $('#txtgestor').attr('value');
                    $('#txtgestor').val(element.articulacion_proyecto.actividad.gestor.user.documento+ ' - '+ element.articulacion_proyecto.actividad.gestor.user.nombres + ' ' + element.articulacion_proyecto.actividad.gestor.user.apellidos);
                    $("label[for='txtgestor']").addClass('active');

                    $('#txtlinea').val(element.articulacion_proyecto.actividad.gestor.lineatecnologica.abreviatura+ ' - '+ element.articulacion_proyecto.actividad.gestor.lineatecnologica.nombre);
                    $("label[for='txtlinea']").addClass('active');

                    if (element.articulacion_proyecto.talentos.length != 0) {
                        $('.btnAgregarTalento').attr('onclick', 'addTalentoAUso()'); 
                        $('#txttalento').append('<option value="">Seleccione el talento</option>');
                        $('#txtequipo').append('<option value="">Seleccione el equipo</option>');

                        

                        $.each(element.articulacion_proyecto.talentos, function(i, talento) {
                        $('#txttalento').append('<option  value="'+talento.id+'">'+ talento.user.documento +' - '+talento.user.nombres+' '+ talento.user.apellidos + '</option>');
               
                        }); 

                        $.each(element.articulacion_proyecto.actividad.gestor.lineatecnologica.equipos, function(e, equipo) {
                
                            $('#txtequipo').append('<option  value="'+equipo.id+'">'+ equipo.nombre + '</option>');
                        });

                        $('#txttalento').attr("disabled", false).select2();
                        $('#txtequipo').select2();
                    }else{
                        $('#txttalento').append('<option value="">no se encontraron resultados</option>');
                        $('#txttalento').attr("disabled", true).select2();
                        $('.btnAgregarTalento').attr("disabled", true).removeAttr("onclick");
                        usoInfraestructuraCreate.equipos();
                    }

                }); 
      
            });
        },

        //EDTS
        dataTableEdtFindByUser: function (){
            $('#usoinfraestrucutaEdtForUserTable').dataTable().fnDestroy();

            $('#usoinfraestrucutaEdtForUserTable').DataTable({
                language: {
                  "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
                },
                processing: true,
                serverSide: true,
                "lengthChange": false,
                order: [ 0, 'desc' ],
                ajax:{
                  url: "/usoinfraestructura/edtsforuser",
                  type: "get",
                },
                select: true,
                columns: [
                  {
                    title: 'Codigo de empresa',
                    data: 'codigo_actividad',
                    name: 'codigo_actividad',
                  },
                  {
                    title: 'Nombre de la empresa',
                    data: 'nombre',
                    name: 'nombre',
                  },
                  {
                    title: 'empresas',
                    data: 'empresas',
                    name: 'empresas',
                  },
                  {
                    width: '20%',
                    data: 'checkbox',
                    name: 'checkbox',
                    orderable: false,
                  },
                ],
              });


            $('#modalUsoIngraestrucuta_edt_modal').openModal({
                dismissible: false,
            });
        },
        
        equipos: function () {
            $.ajax({
                dataType:'json',
                type:'get',
                url:'/usoinfraestructura/equipos'
            }).done(function(response){
            
                $('#txtequipo').empty();
                $('#txtequipo').append('<option value="">Seleccione el equipo</option>');
                @if(session()->has('login_role') && session()->get('login_role') == App\User::IsGestor())

                    $.each(response.data, function(e, equipo) {
                
                        $('#txtequipo').append('<option  value="'+equipo.id+'">'+ equipo.nombre + '</option>');
                    });
                @elseif(session()->has('login_role') && session()->get('login_role') == App\User::IsTalento())

                    $.each(response.data, function(i, element) {

                            $.each(element.articulacion_proyecto.actividad.gestor.lineatecnologica.equipos, function(e, equipo) {
                    
                            $('#txtequipo').append('<option  value="'+equipo.id+'">'+ equipo.nombre + '</option>');
                        });
                    }); 

                @endif

                $('#txtequipo').select2(); 

            });
        },

        //añadir talento al uso de infraestructura

        noRepeatTalento: function (id) {
            let idtalento = $("#txttalento").val();
              let a = document.getElementsByName("talento[]");
              validacion = true;
              if (a.length >= 1) {
                for (x=0;x<a.length;x++){
                  if (a[x].value == idtalento) {
                    validacion = false;
                  }
                }
              }
            return validacion;

        },
                
        validateTiempoUso: function (){
            let tiempouso = $("#txttiempouso").val();
            let re = new RegExp("^[0-9]{1,2}(?:.[0-9]{1})?$");
            if (re.test(tiempouso) == true) {
                return true;
            }else{
                return false;
            };
            
        },

        noRepeatEquipo: function () {
          let idequipo = $("#txtequipo").val();
          let a = document.getElementsByName("equipo[]");
          validacion = true;
          if (a.length >= 1) {
            for (x=0;x<a.length;x++){
              if (a[x].value == idequipo) {
                validacion = false;
              }
            }
          }
          return validacion;
        },
        
        eliminarContentTables: function () {
            $('#detalleTalento').children("tr").remove();
            $('#detallesUsoInfraestructura').children("tr").remove();
        },
        limpiarInputsActividad: function (){
            $('#txtproyecto').removeAttr('value');
            $('#txtarticulacion').removeAttr('value');
            $('#txtedt').removeAttr('value');
        },
        limpiarListaTalentos: function (){
            $('#detalleTalento').empty();
        },
        limpiarListaEquipos: function (){
            $('#detallesUsoInfraestructura').empty();
        },
    }

    function asociarProyectoAUsoInfraestructura(id, codigo_actividad, nombre) {
            $('#modalUsoIngraestrucuta_proyjects_modal').closeModal();
            Swal.fire({
              toast: true,
              position: 'top-end',
              showConfirmButton: false,
              timer: 1500,
              type: 'success',
              title: 'El proyecto  ' + codigo_actividad +  ' - ' + nombre + ' se ha asociado  al uso de infraestructua'
            });


            

            $('#txtactividad').val(codigo_actividad+ ' - '+ nombre);
            $("label[for='txtactividad']").addClass('active');
            $("label[for='txtactividad']").text("Proyecto");
            $divActividad.show();

            usoInfraestructuraCreate.getSelectTalentoProyecto(id);

    }

    function volverModalusoInfrestructura(){
        $('#txtactividad').val('');
        $("label[for='txtactividad']").removeClass('active');
        $("label[for='txtactividad']").text("seleccione un tipo de uso de infraestructura");
        usoInfraestructuraCreate.removeOptionsSelect();
        $divActividad.show();
    }

    function agregarEquipoAusoInfraestructura(){
            
            let  cont = 0;
            let idequipo = $("#txtequipo").val();
            let tiempouso = $("#txttiempouso").val();
            let nombreEquipo = $('#txtequipo option:selected').text();

            if ($("#txtequipo").val() == ""){
                  Swal.fire({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 1500,
                    type: 'warning',
                    title: 'Debe seleccionar un equipo.'
                  });

            }else  if ($("#txttiempouso").val() == ""){
              Swal.fire({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 1500,
                    type: 'warning',
                    title: 'Debe ingresa el tiempo de uso'
                  });
            }else if(usoInfraestructuraCreate.validateTiempoUso() != true){
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 1500,
                    type: 'error',
                    title: 'El tiempo de uso debe ser un valor numerico entre 0 y 99.9.'
                });
            }else{
              if (usoInfraestructuraCreate.noRepeatEquipo() == true) {

                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 1500,
                    type: 'success',
                    title: 'Equipo ' + nombreEquipo + ' agregado.'
                });

                var a = document.getElementsByName("equipo[]");
                let fila ="";

                fila = '<tr class="selected" id="filaEquipo'+cont+'"><td><input type="hidden" name="equipo[]" value="'+idequipo+'">'+nombreEquipo+'</td><td><input type="hidden" name="tiempouso[]" value="'+tiempouso+'">'+tiempouso+'</td><td><a class="waves-effect red lighten-3 btn" onclick="eliminarEquipo('+cont+');"><i class="material-icons">delete_sweep</i></a></td></tr>';
                cont++;
                $('#detallesUsoInfraestructura').append(fila);
              }else{
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 1500,
                    type: 'error',
                    title: 'El Equipo ' + nombreEquipo + ' ya esta listado.'
                  });
                
              }
            }
            $("#txtequipo option[value='']").attr("selected", true);
            $('#txtequipo').select2();
            $("#txttiempouso").val('');
            
        }

        // Función para cerrar el modal y asignarle un valor al proyecto
        function asociarArticulacionAUsoInfraestructura(id, codigo_actividad, nombre) {
            $('#modalUsoIngraestrucuta_articulaciones_modal').closeModal();
            Swal.fire({
              toast: true,
              position: 'top-end',
              showConfirmButton: false,
              timer: 1500,
              type: 'success',
              title: 'La articulacion  ' + codigo_actividad +  ' - ' + nombre + ' se ha asociado  al uso de infraestructua'
            });

            $('#txtactividad').val(codigo_actividad+ ' - '+ nombre);
            $("label[for='txtactividad']").addClass('active');
            $("label[for='txtactividad']").text("Articulación");
            $divActividad.show();

            usoInfraestructuraCreate.getSelectTalentoArtculacionEmprendedores(id);

        }

        function asociarEdtAUsoInfraestructura(id, codigo_actividad, nombre) {
            $('#modalUsoIngraestrucuta_edt_modal').closeModal();
            Swal.fire({
              toast: true,
              position: 'top-end',
              showConfirmButton: false,
              timer: 1500,
              type: 'success',
              title: 'La edt ' + codigo_actividad +  ' - ' + nombre + ' se ha asociado  al uso de infraestructua'
            });



            $('#txtactividad').val(codigo_actividad+ ' - '+ nombre);
            $("label[for='txtactividad']").addClass('active');
            $("label[for='txtactividad']").text("Edt");
            $divActividad.show();

            usoInfraestructuraCreate.equipos();

        }

        function addTalentoAUso(id) {
            let cont = 0;
            let idtalento = $("#txttalento").val();
            let nombreTalento = $('#txttalento option:selected').text();
            if ($("#txttalento").val() == ""){
                
                Swal.fire({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 1500,
                        type: 'warning',
                        title: 'Debe seleccionar un talento'
                      });
                
            }else{
                if (usoInfraestructuraCreate.noRepeatTalento(idtalento) == false) {
                  
                
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 1500,
                        type: 'error',
                        title: 'El Talento ' + nombreTalento + ' ya esta listado.'
                      });

                    $("#txttalento").val();
                }else{
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 1500,
                        type: 'success',
                        title: 'el Talento ' + nombreTalento + ' agregado.'
                      });
                    

                    // $("#txttalento option:contains(Seleccione el talento)").attr("selected", true);

                    let a = document.getElementsByName("talento[]");
                    let fila ="";

                    fila = '<tr class="selected" id="filaTalento'+cont+'"><td><input type="hidden" name="talento[]" value="'+idtalento+'">'+nombreTalento+'</td><td><a class="waves-effect red lighten-3 btn" onclick="eliminarTalento('+cont+');"><i class="material-icons">delete_sweep</i></a></td></tr>';
                    cont++;
                    $('#detalleTalento').append(fila);

                }
            }
            // $("#txttalento").val();
            $("#txttalento option[value='']").attr("selected", true);
            $('#txttalento').select2();
        }

        function eliminarTalento(index){
          $('#filaTalento'+ index).remove();
          Swal.fire({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 1500,
                type: 'success',
                title: 'Talento eliminado.'
              });
        }

        function eliminarEquipo(index){
          $('#filaEquipo'+ index).remove();
          Swal.fire({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 1500,
            type: 'success',
            title: 'Equipo eliminado.'
          });
        }

        //Enviar formulario
        $(document).on('submit', 'form#formUsoInfraestructuraCreate', function (event) {
            $('button[type="submit"]').attr('disabled', 'disabled');
            event.preventDefault();
            var form = $(this);
            let data = new FormData($(this)[0]);

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
                    console.log(data);
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
                                title: 'El uso de infraestructua no se ha registrado, por favor inténtalo de nuevo',
                                type: 'warning',
                                showCancelButton: false,
                                confirmButtonColor: '#3085d6',
                                confirmButtonText: 'Ok'
                          });
                    }

                    if (data.fail == false && data.redirect_url != false) {
                              Swal.fire({
                                title: 'Registro Exitoso',
                                text: "El uso de infraestructua ha sido creado satisfactoriamente",
                                type: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#3085d6',
                                confirmButtonText: 'Ok'
                              });
                              setTimeout(function(){
                                window.location.replace("{{route('usoinfraestructura.index')}}");
                              }, 1000);
                        }
                }
            });
        });
</script>
@endpush
@endif
