@extends('layouts.app')

@section('meta-title', 'Uso de Infraestructura')

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
                                <a href="{{route('nodo.index')}}">
                                    Uso de Infraestructura
                                </a>
                            </li>
                            <li class="active">
                                Editar Uso de Infraestructura
                            </li>
                        </ol>
                    </div>
                </div>
                <div class="card">
                    <div class="card-content">
                        <div class="row">
                            <div class="row">
                                <center>
                                    <span class="card-title center-align">
                                        Editar Uso Infraestructura |
                                        <strong>
                                            {{$usoinfraestructura->actividad->codigo_actividad}}  {{$usoinfraestructura->actividad->nombre}}
                                        </strong>
                                    </span>
                                    <i class="Small material-icons prefix">
                                        domain
                                    </i>
                                </center>
                                <div class="divider">
                                </div>
                                <form action="{{ route('usoinfraestructura.update', $usoinfraestructura->id)}}" id="formUsoInfraestructuraUpdate" method="POST">
                                    {!! method_field('PUT')!!}
	                                    @include('usoinfraestructura.form', [
	                                        'btnText' => 'Modificar',
	                                    ])
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@include('usoinfraestructura.modals')
@endsection
@push('script')
<script>
    $(document).ready(function() {
	        // $divActividad = $(".divActividad");
	        // $divActividad.hide();
	        usoInfraestructuraUpdate.checkTipoUsoInfraestrucuta();

	    });

	    var usoInfraestructuraUpdate = {
	    	checkTipoUsoInfraestrucuta:function () {
	            $( "input[name='txttipousoinfraestructura']" ).change(function (){
	                if ( $("#IsProyecto").is(":checked") ) {
	             
	                    Swal.fire({
	                        toast: true,
	                        position: 'bottom-end',
	                        title: 'proyecto',
	                        text: "por favor seleccion un proyecto",
	                        type: 'warning',
	                        showConfirmButton: false,
	                        timer: 10000
	                    });
	                    usoInfraestructuraUpdate.limpiarInputsActividad();
	                    usoInfraestructuraUpdate.removeValueLineaGestor();
	                    usoInfraestructuraUpdate.eliminarContentTables();
	                    usoInfraestructuraUpdate.removeDisableSelectButtons();
	                    usoInfraestructuraUpdate.DatatableProjectsForUser();
	                                   
	                      
	                } else if ( $("#IsArticulacion").is(":checked") ) {
	                   
	                    usoInfraestructuraUpdate.limpiarInputsActividad();
	                    usoInfraestructuraUpdate.removeValueLineaGestor();
	                    
	                    Swal.fire({
	                        toast: true,
	                        position: 'bottom-end',
	                        title: 'Articulación',
	                        text: "por favor seleccione una articulación",
	                        type: 'warning',
	                        showConfirmButton: false,
	                        timer: 10000
	                    });
	                    
	                    usoInfraestructuraUpdate.eliminarContentTables();
	                    // usoInfraestructuraCreate.dataTableArtculacionFindByUser();

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
	                    
	                    usoInfraestructuraUpdate.limpiarInputsActividad();
	                    usoInfraestructuraUpdate.eliminarContentTables();
	                    usoInfraestructuraUpdate.removeOptionsSelect();
	                    usoInfraestructuraUpdate.disableSelectButtons();
	                    // usoInfraestructuraCreate.dataTableEdtFindByUser();
	                 
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
	                $('#txtlaboratorio').empty();
	                $('#txtgestor').removeAttr('value');
	                $('#txtlinea').removeAttr('value');

	                if (response != '') {
	                    $('#txttalento').append('<option value="">Seleccione el talento</option>');
	                    $('#txtlaboratorio').append('<option value="">Seleccione el laboratorio</option>');
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


	                                             
	                        $.each(element.articulacion_proyecto.actividad.gestor.lineatecnologica.laboratorios, function(e, laboratorio) {
	                    
	                            $('#txtlaboratorio').append('<option  value="'+laboratorio.id+'">'+ laboratorio.nombre + '</option>');
	                        });
	                    });
	                    

	                }else{
	                    $('#txttalento').append('<option value="">no se encontraron resultados</option>');
	                    $('#txttalento').append('<option value="">no se encontraron resultados</option>');
	                }

	                $('#txttalento').material_select();
	                $('#txtlaboratorio').material_select();
  
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
	            .append('<option selected="selected" value="">seleccione talentos</option>').material_select();
	            $('#txtlaboratorio')
	            .empty()
	            .append('<option selected="selected"  value="">seleccione laboratorios</option>').material_select();          
	        },
	        disableSelectButtons: function () {
	            $('#txttalento').attr("disabled", true).material_select(); 
	            
	            $(".btnAgregarTalento").attr("disabled", true).removeAttr("onclick");
	        },
	        removeDisableSelectButtons: function () {
	            $('#txttalento').attr("disabled", false).material_select(); 
	            $(".btnAgregarTalento").removeAttr("disabled").attr('onclick', 'usoInfraestructuraCreate.addTalentoAUso()');
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
	            $('#txtlaboratorio').empty();

	            $('#modalUsoIngraestrucuta_articulaciones_modal').openModal({
	                dismissible: false,
	            });
	        },
	        limpiarInputsActividad: function (){
	            $('#txtproyecto').removeAttr('value');
	            $('#txtarticulacion').removeAttr('value');
	            $('#txtedt').removeAttr('value');
	        },
	        
	        eliminarContentTables: function () {
	            $('#detalleTalento').children("tr").remove();
	            $('#detallesUsoInfraestructura').children("tr").remove();
	        },
	        
  
	    }
		function asociarProyectoAUsoInfraestructura(id, codigo_actividad, nombre, talentos) {
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
            // $divActividad.show();

            usoInfraestructuraUpdate.getSelectTalentoProyecto(id);

	    }
	    function volverModalusoInfrestructura(){

	        $('#txtactividad').val('');
	        $("label[for='txtactividad']").removeClass('active');
	        $("label[for='txtactividad']").text("seleccione un tipo de uso de infraestructura");
	        usoInfraestructuraUpdate.removeOptionsSelect();
	        // $divActividad.show();
	    }
	    function agregarLaboratorioAusoInfraestructura(){
            
            let  cont = 0;
            let idlaboratorio = $("#txtlaboratorio").val();
            let tiempouso = $("#txttiempouso").val();
            let nombreLaboratorio = $('#txtlaboratorio option:selected').text();

            if ($("#txtlaboratorio").val() == ""){
                  Swal.fire({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 1500,
                    type: 'warning',
                    title: 'Debe seleccionar un laboratorio.'
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
              if (usoInfraestructuraCreate.noRepeatLaboratorio() == true) {

                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 1500,
                    type: 'success',
                    title: 'Laboratorio ' + nombreLaboratorio + ' agregado.'
                });

                var a = document.getElementsByName("laboratorio[]");
                let fila ="";

                fila = '<tr class="selected" id="filaLaboratorio'+cont+'"><td><input type="hidden" name="laboratorio[]" value="'+idlaboratorio+'">'+nombreLaboratorio+'</td><td><input type="hidden" name="tiempouso[]" value="'+tiempouso+'">'+tiempouso+'</td><td><a class="waves-effect red lighten-3 btn" onclick="usoInfraestructuraCreate.eliminarLaboratorio('+cont+');"><i class="material-icons">delete_sweep</i></a></td></tr>';
                cont++;
                $('#detallesUsoInfraestructura').append(fila);
              }else{
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 1500,
                    type: 'error',
                    title: 'El laboratorio ' + nombreLaboratorio + ' ya esta listado.'
                  });
                
              }
            }
            $("#txtlaboratorio option[value='']").attr("selected", true);
            $('#txtlaboratorio').material_select();
            $("#txttiempouso").val('');
            
        }
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

            usoInfraestructuraUpdate.getSelectTalentoArtculacionEmprendedores(id);

        }
</script>
@endpush
