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
                                <a href="{{route('usoinfraestructura.index')}}">
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
	                    usoInfraestructuraUpdate.limpiarInputsActividad();
	                    usoInfraestructuraUpdate.removeValueLineaGestor();
	                    usoInfraestructuraUpdate.eliminarContentTables();
	                    usoInfraestructuraUpdate.dataTableArtculacionFindByUser();

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
	                    usoInfraestructuraUpdate.dataTableEdtFindByUser();
	                 
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
	            $('#txtlaboratorio').empty();

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
	                $('#txtlaboratorio').empty();
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
		                    $('#txtlaboratorio').append('<option value="">Seleccione el laboratorio</option>');

		                    

                        	$.each(element.articulacion_proyecto.talentos, function(i, talento) {
                            $('#txttalento').append('<option  value="'+talento.id+'">'+ talento.user.documento +' - '+talento.user.nombres+' '+ talento.user.apellidos + '</option>');
                   
                            }); 

                            $.each(element.articulacion_proyecto.actividad.gestor.lineatecnologica.laboratorios, function(e, laboratorio) {
                    
                                $('#txtlaboratorio').append('<option  value="'+laboratorio.id+'">'+ laboratorio.nombre + '</option>');
                            });

                            $('#txttalento').attr("disabled", false).material_select();
                    		$('#txtlaboratorio').material_select();
                    	}else{
                    		$('#txttalento').append('<option value="">no se encontraron resultados</option>');
		                    $('#txttalento').attr("disabled", true).material_select();
		                    $('.btnAgregarTalento').attr("disabled", true).removeAttr("onclick");
		                    usoInfraestructuraUpdate.laboratorios();
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
	        limpiarInputsActividad: function (){
	            $('#txtproyecto').removeAttr('value');
	            $('#txtarticulacion').removeAttr('value');
	            $('#txtedt').removeAttr('value');
	        },
	        
	        eliminarContentTables: function () {
	            $('#detalleTalento').children("tr").remove();
	            $('#detallesUsoInfraestructura').children("tr").remove();
	        },
	        laboratorios: function () {
	            $.ajax({
	                dataType:'json',
	                type:'get',
	                url:'/usoinfraestructura/laboratorios'
	            }).done(function(response){
	                $('#txtlaboratorio').empty();
	                $('#txtlaboratorio').append('<option value="">Seleccione el laboratorio</option>');
	                @if(session()->has('login_role') && session()->get('login_role') == App\User::IsGestor())

	                    $.each(response.data, function(e, laboratorio) {
	                
	                        $('#txtlaboratorio').append('<option  value="'+laboratorio.id+'">'+ laboratorio.nombre + '</option>');
	                    });
	                @elseif(session()->has('login_role') && session()->get('login_role') == App\User::IsTalento())

	                    $.each(response.data, function(i, element) {

	                            $.each(element.articulacion_proyecto.actividad.gestor.lineatecnologica.laboratorios, function(e, laboratorio) {
	                    
	                            $('#txtlaboratorio').append('<option  value="'+laboratorio.id+'">'+ laboratorio.nombre + '</option>');
	                        });
	                    }); 

	                @endif

	                $('#txtlaboratorio').material_select(); 

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
	        noRepeatLaboratorio: function () {
	          let idlaboratorio = $("#txtlaboratorio").val();
	          let a = document.getElementsByName("laboratorio[]");
	          validacion = true;
	          if (a.length >= 1) {
	            for (x=0;x<a.length;x++){
	              if (a[x].value == idlaboratorio) {
	                validacion = false;
	              }
	            }
	          }
	          return validacion;
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
            }else if(usoInfraestructuraUpdate.validateTiempoUso() != true){
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 1500,
                    type: 'error',
                    title: 'El tiempo de uso debe ser un valor numerico entre 0 y 99.9.'
                });
            }else{
              if (usoInfraestructuraUpdate.noRepeatLaboratorio() == true) {

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

                fila = '<tr class="selected" id="filaLaboratorio'+cont+'"><td><input type="hidden" name="laboratorio[]" value="'+idlaboratorio+'">'+nombreLaboratorio+'</td><td><input type="hidden" name="tiempouso[]" value="'+tiempouso+'">'+tiempouso+'</td><td><a class="waves-effect red lighten-3 btn" onclick="eliminarLaboratorio('+cont+');"><i class="material-icons">delete_sweep</i></a></td></tr>';
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
            // $divActividad.show();

            usoInfraestructuraUpdate.getSelectTalentoArtculacionEmprendedores(id);

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
            // $divActividad.show();

            usoInfraestructuraUpdate.laboratorios();

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
                if (usoInfraestructuraUpdate.noRepeatTalento(idtalento) == false) {
                  
                
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
            $("#txttalento option[value='']").attr("selected", true);
            $('#txttalento').material_select();
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
        function eliminarLaboratorio(index){
          $('#filaLaboratorio'+ index).remove();
          Swal.fire({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 1500,
            type: 'success',
            title: 'Laboratorio eliminado.'
          });
        }

        //Enviar formulario
        $(document).on('submit', 'form#formUsoInfraestructuraUpdate', function (event) {
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

                    // if (data.fail == false && data.redirect_url == false) {
                    //       Swal.fire({
                    //             title: 'El uso de infraestructua no se ha registrado, por favor inténtalo de nuevo',
                    //             // text: "You won't be able to revert this!",
                    //             type: 'warning',
                    //             showCancelButton: false,
                    //             confirmButtonColor: '#3085d6',
                    //             confirmButtonText: 'Ok'
                    //       });
                    // }

                    // if (data.fail == false && data.redirect_url != false) {
                    //   Swal.fire({
                    //     title: 'Registro Exitoso',
                    //     text: "El uso de infraestructua ha sido creado satisfactoriamente",
                    //     type: 'success',
                    //     showCancelButton: false,
                    //     confirmButtonColor: '#3085d6',
                    //     confirmButtonText: 'Ok'
                    //   });
                    //   setTimeout(function(){
                    //     window.location.replace("{{route('usoinfraestructura.index')}}");
                    //   }, 1000);
                    // }
                }
            });

        });
</script>
@endpush
