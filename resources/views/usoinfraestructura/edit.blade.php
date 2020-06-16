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
            usoInfraestructuraUpdate.checkTipoUsoInfraestrucuta();
            @if(isset($usoinfraestructura->actividad->articulacion_proyecto->proyecto))
            usoInfraestructuraUpdate.getSelectTalentoProyecto({{$usoinfraestructura->actividad->articulacion_proyecto->proyecto->id}});
            @endif

            @if(isset($usoinfraestructura->actividad->articulacion_proyecto->articulacion))
            usoInfraestructuraUpdate.getSelectTalentoArticulacion({{$usoinfraestructura->actividad->articulacion_proyecto->articulacion->id}});
            @endif



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
	                    usoInfraestructuraUpdate.limpiarInputNodo();
	                    usoInfraestructuraUpdate.removeValueLineaGestor();
	                    usoInfraestructuraUpdate.eliminarContentTables();
	                    usoInfraestructuraUpdate.limpiarListaTalentos();
	                    usoInfraestructuraUpdate.limpiarListaEquipos();
	                    usoInfraestructuraUpdate.limpiarListaMateriales();
	                    usoInfraestructuraUpdate.limpiarListaGestorACargo();
	                    usoInfraestructuraUpdate.limpiarListaGestorAsesores();
	                    usoInfraestructuraUpdate.removeDisableSelectButtons();
	                    usoInfraestructuraUpdate.removeDisableButtonGestorAsesor();
	                    usoInfraestructuraUpdate.removeDisableButtonEquipos();
	                    usoInfraestructuraUpdate.removeDisableButtonTalento();
	                    usoInfraestructuraUpdate.removeDisableButtonMaterial();
	                    usoInfraestructuraUpdate.DatatableProjectsForUser();



	                } else if ( $("#IsArticulacion").is(":checked") ) {



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
	                    usoInfraestructuraUpdate.limpiarInputNodo();
	                    usoInfraestructuraUpdate.removeValueLineaGestor();
	                    usoInfraestructuraUpdate.eliminarContentTables();
	                    usoInfraestructuraUpdate.dataTableArtculacionFindByUser();
	                    usoInfraestructuraUpdate.limpiarListaTalentos();
	                    usoInfraestructuraUpdate.limpiarListaEquipos();
	                    usoInfraestructuraUpdate.limpiarListaMateriales();
	                    usoInfraestructuraUpdate.limpiarListaGestorACargo();
	                    usoInfraestructuraUpdate.limpiarListaGestorAsesores();
	                    usoInfraestructuraUpdate.removeDisableButtonGestorAsesor();
	                    usoInfraestructuraUpdate.addDisableButtonTalento();
	                	usoInfraestructuraUpdate.addDisableButtonEquipos();
	                	usoInfraestructuraUpdate.addDisableButtonMaterial();


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
	                    usoInfraestructuraUpdate.limpiarInputNodo();
	                    usoInfraestructuraUpdate.eliminarContentTables();
	                    usoInfraestructuraUpdate.removeOptionsSelect();
	                    usoInfraestructuraUpdate.disableSelectButtons();
	                    usoInfraestructuraUpdate.dataTableEdtFindByUser();
	                    usoInfraestructuraUpdate.limpiarListaTalentos();
	                    usoInfraestructuraUpdate.limpiarListaEquipos();
	                    usoInfraestructuraUpdate.limpiarListaMateriales();
	                    usoInfraestructuraUpdate.limpiarListaGestorACargo();
	                    usoInfraestructuraUpdate.limpiarListaGestorAsesores();
	                    usoInfraestructuraUpdate.removeDisableButtonGestorAsesor();
		                usoInfraestructuraUpdate.addDisableButtonTalento();
		                usoInfraestructuraUpdate.addDisableButtonEquipos();
		                usoInfraestructuraUpdate.addDisableButtonMaterial();
	                }

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
	        removeDisableButtonGestorAsesor: function () {
	             $(".btnAgregarGestorAsesor").removeAttr("disabled").attr('onclick', 'addGestoresAUso()');
	             $('#txtgestorasesor').attr("disabled", false).select2();
	             $('#txtasesoriadirecta').removeAttr("readonly");
	             $('#txtasesoriaindirecta').removeAttr("readonly");

	        },
	        removeDisableButtonEquipos: function () {
	             $(".btnAgregarEquipo").removeAttr("disabled").attr('onclick', 'agregarEquipoAusoInfraestructura()');
	             $('#txtlineatecnologica').attr("disabled", false).select2();
	             $('#txtequipo').attr("disabled", false).select2();
	             $('#txttiempouso').removeAttr("readonly");
	        },
	        removeDisableButtonMaterial: function () {
	             $(".btnAgregarMaterial").removeAttr("disabled").attr('onclick', 'addMaterialesAUso()');
	             $('#txtmaterial').attr("disabled", false).select2();
	             $('#txtcantidad').removeAttr("readonly");
	        },
	        addDisableButtonGestorAsesor: function () {
	             $(".btnAgregarGestorAsesor").removeAttr('onclick', 'addGestoresAUso()').attr("disabled");
	             $('#txtgestorasesor').attr("disabled", true).select2();
	             $('#txtasesoriadirecta').attr("readonly", true);
	             $('#txtasesoriaindirecta').attr("readonly", true);
	        },
	        addDisableButtonEquipos: function () {
	             $(".btnAgregarEquipo").removeAttr('onclick', 'agregarEquipoAusoInfraestructura()').attr("disabled");
	             $('#txtlineatecnologica').attr("disabled", true).select2();
	             $('#txtequipo').attr("disabled", true).select2();
	             $('#txttiempouso').attr("readonly", true);
	        },
	        addDisableButtonMaterial: function () {
	             $(".btnAgregarMaterial").removeAttr('onclick', 'addMaterialesAUso()').attr("disabled");
	             $('#txtmaterial').attr("disabled", true).select2();
	             $('#txtcantidad').attr("readonly", true);
	        },
	        removeDisableButtonTalento: function () {
	             $(".btnAgregarTalento").removeAttr("disabled").attr('onclick', 'addTalentoAUso()');
	             $('#txttalento').attr("disabled", false).select2();

	        },
	        addDisableButtonTalento: function () {
	             $(".btnAgregarTalento").removeAttr('onclick', 'addTalentoAUso()').attr("disabled");
	             $('#txttalento').attr("disabled", true).select2();

	        },

	        eliminarContentTables: function () {
	            $('#detalleTalento').children("tr").remove();
	            $('#detallesUsoInfraestructura').children("tr").remove();
	            $('#detallesGestores').children("tr").remove();
	            $('#detallesGestoresAsesores').children("tr").remove();
	            $('#detalleMaterialUso').children("tr").remove();
	        },
	        limpiarInputsActividad: function (){
	            $('#txtactividad').val();

	        },
	        limpiarInputNodo: function (){
	            $('#txtnodo').val("");
	        },
            limpiarTipoUsoInfraestructura: function (){
	            $('#txttipousoinfraestructura').removeAttr("checked");
	        },
	        limpiarListaTalentos: function (){
	            $('#detalleTalento').empty();
	        },
	        limpiarListaEquipos: function (){
	            $('#detallesUsoInfraestructura').empty();
	        },
	        limpiarListaMateriales: function (){
	            $('#detalleMaterialUso').empty();
	        },
	        limpiarListaGestorACargo: function (){
	            $('#detallesGestores').empty();
	            $('#detallesGestores').children("tr").remove();
	        },
	        limpiarListaGestorAsesores: function (){
	            $('#detallesGestoresAsesores').empty();
	            $('#detallesGestoresAsesores').children("tr").remove();
	        },
	        DatatableProjectsForUser: function () {
            $('#usoinfraestrucutaProjectsForUserTable').dataTable().fnDestroy();
              $('#usoinfraestrucutaProjectsForUserTable').DataTable({
                language: {
                  "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
                },
                processing: true,
                serverSide: true,
                pageLength: 5,
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
                $('#txtlinea').empty();
                $('#txtlineatecnologica').empty();
                $('#txtmaterial').empty();
                $('#txtlinea').removeAttr('value');
                $('#detallesGestores').children("tr").remove();


                $('#txttalento').append('<option value="">Seleccione el talento</option>');
                $('#txtequipo').append('<option value="">Seleccione el equipo</option>');
                $('#txtlineatecnologica').append('<option value="">Seleccione la linea tecnológica</option>');
                $('#txtmaterial').append('<option value="">Seleccione el material de formación</option>');

                if (response.proyecto.length != 0) {
                    @if(session()->has('login_role') && session()->get('login_role') == App\User::IsGestor())
                        let cont;
                        let a = document.getElementsByName("gestor[]");
                        let fila ="";

                        fila = '<tr class="selected" id="filaGestor'+cont+'"><td>'+response.proyecto.abreviatura + ' - ' + response.proyecto.lineatecnologica_nombre+'</td><td><input type="hidden" name="gestor[]"  value="'+response.proyecto.gestor_id+'">'+response.proyecto.documento + ' -  ' + response.proyecto.nombres+' '+  response.proyecto.apellidos+' - Gestor a cargo'+'</td><td><input type="number" min="0" step="0.1" name="asesoriadirecta[]" min="0" maxlength="6" value="1"></td><td><input type="number" min="0" step="0.1" name="asesoriaindirecta[]" min="0" maxlength="6" value="1"></td></td><td></tr>';
                        cont++;
                        $('#detallesGestores').append(fila);

                    @elseif(session()->has('login_role') && session()->get('login_role') == App\User::IsTalento())
                        $('#txtgestor').val(response.proyecto.documento+ ' - '+ response.proyecto.nombres + ' ' + response.proyecto.apellidos);
                        $("label[for='txtgestor']").addClass('active');
                    @endif

                    $('#txtlinea').val(response.proyecto.abreviatura+ ' - '+ response.proyecto.lineatecnologica_nombre);
                    $('#txtnodo').val(response.proyecto.nodo_id);
                    $("label[for='txtlinea']").addClass('active');
                }else{
                    @if(session()->has('login_role') && session()->get('login_role') == App\User::IsGestor())
                        let cont;
                        let a = document.getElementsByName("gestor[]");
                        let fila ="";

                        fila = '<tr class="selected" id="filaGestor'+cont+'"><td>No se encontraron resultados</td><td></td><td></td><td></td></td><td></tr>';
                        cont++;
                        $('#detallesGestores').append(fila);

                    @elseif(session()->has('login_role') && session()->get('login_role') == App\User::IsTalento())
                        $('#txtgestor').val("No se encontraron resultados");
                        $("label[for='txtgestor']").addClass('active');
                    @endif
                    $('#txtlinea').val("No se encontraron resultados");
                    $('#txtnodo').val();
                    $("label[for='txtlinea']").addClass('active');
                }

                if (response.talentos.length != 0) {
                    $.each(response.talentos, function(e, talento) {
                        $('#txttalento').append('<option value="'+talento.id+'">'+ talento.documento +' - '+talento.nombres+' '+ talento.apellidos + '</option>');
                    });
                }else{
                    $('#txttalento').append('<option value="">no se encontraron resultados</option>');
                }

                if (response.lineastecnologicas.length != 0) {
                    $.each(response.lineastecnologicas, function(e, lineatecnologica) {
                        $('#txtlineatecnologica').append('<option  value="'+lineatecnologica.linea_tecnologica_id+'">'+ lineatecnologica.abreviatura + ' ' + lineatecnologica.nombre + '</option>');
                    });
                }else{
                    $('#txtlineatecnologica').append('<option value="">no se encontraron resultados</option>');
                }

                if (response.equipos.length != 0) {
                    $.each(response.equipos, function(e, equipo) {
                        if (equipo.nombre.length > 30){
                            $('#txtequipo').append('<option  value="'+equipo.id+'">'+ equipo.nombre.substr(0,30) + '...  / ' + equipo.referencia + ' - '+ equipo.marca +'</option>');
                        }else{
                            $('#txtequipo').append('<option  value="'+equipo.id+'">'+ equipo.nombre+ '/ ' + equipo.referencia + ' - '+ equipo.marca +'</option>');
                        }
                    });
                }else{
                    $('#txtequipo').append('<option value="">no se encontraron resultados</option>');
                }

                if (response.materiales.length != 0) {
                    $.each(response.materiales, function(e, material) {
                        if (material.material_nombre.length > 30){
                            $('#txtmaterial').append('<option  value="'+material.material_id+'">'+material.codigo_material + ' - '+ material.presentacion_nombre + ' '+material.material_nombre.substr(0,30)+ '... x ' +material.medida_nombre  +'</option>');
                        }else{
                            $('#txtmaterial').append('<option  value="'+material.material_id+'">'+material.codigo_material + ' - '+ material.presentacion_nombre + ' '+ material.material_nombre + ' x ' +material.medida_nombre  +'</option>');
                        }
                    });
                }else{
                    $('#txtmaterial').append('<option value="">no se encontraron resultados</option>');
                }

                $('#txttalento').select2();
                $('#txtequipo').select2();
                $('#txtlineaselect').select2();
                $('#txtlineatecnologica').select2();
                $('#txtmaterial').select2();

            });

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
                pageLength: 5,
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
                    title: 'fase',
                    data: 'fase',
                        name: 'fase',
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

        getSelectTalentoArticulacion:function (id){
            $.ajax({
                dataType:'json',
                type:'get',
                url:'/usoinfraestructura/talentosporarticulacion/'+id
            }).done(function(response){
                $('#txtequipo').empty();
                $('#txtgestor').removeAttr('value');
                $('#txtlinea').removeAttr('value');
                $('#txtlineatecnologica').empty();
                $('#txtmaterial').empty();
                $('#txttalento').empty();

                $('#txttalento').append('<option value="">Seleccione el talento</option>');
                $('#txtequipo').append('<option value="">Seleccione el equipo</option>');
                $('#txtlineatecnologica').append('<option value="">Seleccione la linea tecnológica</option>');
                $('#txtmaterial').append('<option value="">Seleccione el material de formación</option>');

                if (response.articulacion.length != 0) {
                    @if(session()->has('login_role') && session()->get('login_role') == App\User::IsGestor())
                        let cont;
                        let a = document.getElementsByName("gestor[]");
                        let fila ="";
                        @if(!isset($usoinfraestructura->actividad->articulacion_proyecto->articulacion))


                        fila = '<tr class="selected" id="filaGestor'+cont+'"><td>'+response.articulacion.lineatecnologica_abreviatura + ' - ' + response.articulacion.lineatecnologica_nombre+'</td><td><input type="hidden" name="gestor[]" value="'+response.articulacion.gestor_id+'">'+response.articulacion.documento + ' - ' +response.articulacion.user_nombres+' '+ response.articulacion.user_apellidos +' - Gestor a cargo'+'</td><td><input type="number" min="0" maxlength="6" name="asesoriadirecta[]" value="1"></td><td><input type="number" min="0" maxlength="6" name="asesoriaindirecta[]" value="1"></td></td><td></tr>';
                        @endif


                        cont++;
                        $('#detallesGestores').append(fila);
                    @elseif(session()->has('login_role') && session()->get('login_role') == App\User::IsTalento())
                        $('#txtgestor').attr('value');
                        $('#txtgestor').val(response.articulacion.documento+ ' - '+ response.articulacion.user_nombres + ' ' + response.articulacion.actividad.user_apellidos);
                        $("label[for='txtgestor']").addClass('active');
                    @endif
                    $('#txtlinea').val(response.articulacion.lineatecnologica_abreviatura+ ' - '+ response.articulacion.lineatecnologica_nombre);
                    $('#txtnodo').val(response.articulacion.actividad_nodo_id);
                    $("label[for='txtlinea']").addClass('active');
                }else{
                    @if(session()->has('login_role') && session()->get('login_role') == App\User::IsGestor())
                        let cont;
                        let a = document.getElementsByName("gestor[]");
                        let fila ="";

                        fila = '<tr class="selected" id="filaGestor'+cont+'"><td>No se encontraron resultados</td><td></td><td></td><td></td></td><td></tr>';
                        cont++;
                        $('#detallesGestores').append(fila);

                    @elseif(session()->has('login_role') && session()->get('login_role') == App\User::IsTalento())
                        $('#txtgestor').val("No se encontraron resultados");
                        $("label[for='txtgestor']").addClass('active');
                    @endif
                    $('#txtlinea').val("No se encontraron resultados");
                    $('#txtnodo').val();
                    $("label[for='txtlinea']").addClass('active');
                }

                if (response.talentos.length != 0) {
                    $.each(response.talentos, function(e, talento) {
                        $('#txttalento').append('<option value="'+talento.id+'">'+ talento.documento +' - '+talento.nombres+' '+ talento.apellidos + '</option>');
                    });
                }else{
                    $('#txttalento').append('<option value="">no se encontraron resultados</option>');
                }

                if (response.equipos.length != 0) {
                    $.each(response.lineastecnologicas, function(e, lineatecnologica) {
                        $('#txtlineatecnologica').append('<option  value="'+lineatecnologica.linea_tecnologica_id+'">'+ lineatecnologica.abreviatura + ' - ' + lineatecnologica.nombre + '</option>');
                    });
                }else{
                    $('#txtlineatecnologica').append('<option value="">no se encontraron resultados</option>');
                }

                if (response.equipos.length != 0) {
                    $.each(response.lineastecnologicas, function(i, lineatecnologica) {
                        $('#txtlineatecnologica').append('<option  value="'+lineatecnologica.id+'">'+ lineatecnologica.nombre + '</option>');
                    });
                }else{
                    $('#txtlineatecnologica').append('<option value="">no se encontraron resultados</option>');
                }

                if (response.equipos.length != 0) {
                    $.each(response.equipos, function(e, equipo) {
                        if (equipo.nombre.length > 40){
                            $('#txtequipo').append('<option  value="'+equipo.id+'">'+ equipo.nombre.substr(0,50) + '...  / ' + equipo.referencia + ' - '+ equipo.marca +'</option>');
                        }else{
                            $('#txtequipo').append('<option  value="'+equipo.id+'">'+ equipo.nombre+ '/ ' + equipo.referencia + ' - '+ equipo.marca +'</option>');
                        }
                    });
                }else{
                    $('#txtequipo').append('<option value="">no se encontraron resultados</option>');
                }

                if (response.materiales.length != 0) {
                    $.each(response.materiales, function(e, material) {
                        if (material.material_nombre.length > 40){
                            $('#txtmaterial').append('<option  value="'+material.material_id+'">'+ material.presentacion_nombre + ' '+material.material_nombre.substr(0,50)+ '... x ' +material.medida_nombre  +'</option>');
                        }else{
                            $('#txtmaterial').append('<option  value="'+material.material_id+'">'+ material.presentacion_nombre + ' '+ material.material_nombre + ' x ' +material.medida_nombre  +'</option>');
                        }
                    });
                }else{
                    $('#txtmaterial').append('<option value="">no se encontraron resultados</option>');
                }
                $('#txttalento').select2();
                $('#txtmaterial').select2();
                $('#txtequipo').select2();
                $('#txtlineatecnologica').select2();
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
                pageLength: 5,
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
        getSelectEdt: function(id){
            $.ajax({
                dataType:'json',
                type:'get',
                url:'/usoinfraestructura/edtforuser/'+id
            }).done(function(response){

                $('#txtequipo').empty();
                $('#txtgestor').removeAttr('value');
                $('#txtlinea').removeAttr('value');
                $('#txtlineatecnologica').empty();
                $('#txtmaterial').empty();

                $('#txtequipo').append('<option value="">Seleccione el equipo</option>');
                $('#txtlineatecnologica').append('<option value="">Seleccione la linea tecnológica</option>');
                $('#txtmaterial').append('<option value="">Seleccione el material de formación</option>');

                if (response.edt.length != 0) {
                    @if(session()->has('login_role') && session()->get('login_role') == App\User::IsGestor())
                        let cont;
                        let a = document.getElementsByName("gestor[]");
                        let fila ="";

                        fila = '<tr class="selected" id="filaGestor'+cont+'"><td>'+response.edt.lineatecnologica_abreviatura + ' - ' + response.edt.lineatecnologica_nombre+'</td><td><input type="hidden" name="gestor[]" value="'+response.edt.gestor_id+'">'+response.edt.documento + ' - ' + response.edt.user_nombres+' '+response.edt.user_apellidos+' - Gestor a cargo'+'</td><td><input type="number" min="0" maxlength="6" name="asesoriadirecta[]" value="1"></td><td><input type="number" min="0" maxlength="6" name="asesoriaindirecta[]" value="1"></td></td><td></tr>';
                        cont++;
                        $('#detallesGestores').append(fila);
                    @elseif(session()->has('login_role') && session()->get('login_role') == App\User::IsTalento())
                        $('#txtgestor').attr('value');
                        $('#txtgestor').val(response.edt.documento+ ' - '+ response.edt.user_nombres + ' ' + response.edt.user_apellidos);
                        $("label[for='txtgestor']").addClass('active');
                    @endif
                    $('#txtlinea').attr('value');
                    $('#txtlinea').val(response.edt.lineatecnologica_abreviatura+ ' - '+ response.edt.lineatecnologica_nombre);
                    $("label[for='txtlinea']").addClass('active');
                    $('#txtnodo').val(response.edt.actividad_nodo_id);
                }else{
                    @if(session()->has('login_role') && session()->get('login_role') == App\User::IsGestor())
                        let cont;
                        let a = document.getElementsByName("gestor[]");
                        let fila ="";

                        fila = '<tr class="selected" id="filaGestor'+cont+'"><td>No se encontraron resultados</td><td></td><td></td><td></td></td><td></tr>';
                        cont++;
                        $('#detallesGestores').append(fila);

                    @elseif(session()->has('login_role') && session()->get('login_role') == App\User::IsTalento())
                        $('#txtgestor').val("No se encontraron resultados");
                        $("label[for='txtgestor']").addClass('active');
                    @endif
                    $('#txtlinea').val("No se encontraron resultados");
                    $('#txtnodo').val();
                    $("label[for='txtlinea']").addClass('active');
                }

                if (response.lineastecnologicas.length != 0) {
                    $.each(response.lineastecnologicas, function(e, lineatecnologica) {
                        $('#txtlineatecnologica').append('<option  value="'+lineatecnologica.id+'">'+ lineatecnologica.nombre + '</option>');
                    });
                }else{
                   $('#txtlineatecnologica').append('<option value="">no se encontraron resultados</option>');
                }

                if (response.equipos.length != 0) {
                    $.each(response.equipos, function(e, equipo) {
                        $('#txtequipo').append('<option  value="'+equipo.id+'">'+ equipo.nombre + '/ ' + equipo.referencia + ' - '+ equipo.marca +'</option>');
                    });
                }else{
                    $('#txtequipo').append('<option value="">no se encontraron resultados</option>');
                }

                if (response.materiales.length != 0) {
                    $.each(response.materiales, function(e, material) {
                       $('#txtmaterial').append('<option  value="'+material.material_id+'">'+material.codigo_material + ' - '+ material.presentacion_nombre + ' '+ material.material_nombre + ' x ' +material.medida_nombre  +'</option>');
                    });
                }else{
                    $('#txtmaterial').append('<option value="">no se encontraron resultados</option>');
                }
                $('#txtequipo').select2();
                $('#txtlineatecnologica').select2();
                $('#txtmaterial').select2();

            });
        },

        getEquipoPorLinea:function(){
            let lineatecnologica = $('#txtlineatecnologica').val();
            let nodo = $('#txtnodo').val();

            if(nodo != '' && lineatecnologica !=''){
                $.ajax({
                    dataType:'json',
                    type:'get',
                    url:'/equipos/getequiposporlinea/'+nodo+'/'+lineatecnologica
                }).done(function(response){
                    $('#txtequipo').empty();
                    if (response.equipos == '' && response.equipos.length == 0) {
                        $('#txtequipo').append('<option value="">No se encontraron resultados</option>');
                    }else{
                        $('#txtequipo').append('<option value="">Seleccione el equipo</option>');
                        @if($errors->any())
                            $.each(response.equipos, function(i, equipo) {
                                $('#txtequipo').append('<option  value="'+equipo.id+'">'+ equipo.nombre + '/ ' + equipo.referencia + ' - '+ equipo.marca +'</option>');
                            });
                        @else
                            $.each(response.equipos, function(i, equipo) {

                                $('#txtequipo').append('<option  value="'+equipo.id+'">'+ equipo.nombre + '/ ' + equipo.referencia + ' - '+ equipo.marca +'</option>');
                            });
                        @endif
                    }
                    @if($errors->any())
                        $('#txtequipo').val("{{old('txtequipo')}}");
                    @endif
                    $('#txtequipo').select2();
                });
            }else{
                $('#txtequipo').append('<option value="">no se encontraron resultados</option>');
            }

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

        noRepeatGestor: function () {
          let idequipo = $("#txtgestorasesor").val();
          let a = document.getElementsByName("gestor[]");
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
        noRepeatMaterial: function () {
          let idmaterial = $("#txtmaterial").val();
          let a = document.getElementsByName("material[]");
          validacion = true;
          if (a.length >= 1) {
            for (x=0;x<a.length;x++){
              if (a[x].value == idmaterial) {
                validacion = false;
              }
            }
          }
          return validacion;
        },
    }

    function getSelectMaterial(){
        let material = $("#txtmaterial").val();
        if(material != ''){
            $.ajax({
                dataType:'json',
                type:'get',
                url:'/materiales/getmaterial/'+ material
            }).done(function(response){

                $("label[for='txtcantidad']").empty();
                $("label[for='txtcantidad']").text('cantidad a gastar ('+response.material.medida.nombre+ ')');
            });
        }else{
            $("label[for='txtcantidad']").empty();
            $('#txtcantidad').text('Cantidad a gastar');
        }
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


            usoInfraestructuraUpdate.getSelectTalentoProyecto(id);

    }

    function volverModalusoInfrestructura(){
        $('#txtactividad').val('');
        $("label[for='txtactividad']").removeClass('active');
        $("label[for='txtactividad']").text("seleccione un tipo de uso de infraestructura");
        usoInfraestructuraUpdate.removeOptionsSelect();
        usoInfraestructuraUpdate.addDisableButtonGestorAsesor();
        usoInfraestructuraUpdate.addDisableButtonTalento();
        usoInfraestructuraUpdate.addDisableButtonEquipos();
        usoInfraestructuraUpdate.addDisableButtonMaterial();
        usoInfraestructuraUpdate.limpiarInputNodo();
        usoInfraestructuraUpdate.limpiarTipoUsoInfraestructura();

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
            }else if($("#txttiempouso").val() <= 0){
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 1500,
                    type: 'warning',
                    title: 'el tiempo de uso debe ser mayor o igual a 1.'
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
              if (usoInfraestructuraUpdate.noRepeatEquipo() == true) {

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
            $("#txttiempouso").val(1);

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

            usoInfraestructuraUpdate.getSelectTalentoArticulacion(id);

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


            usoInfraestructuraUpdate.getSelectEdt(id);

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

                    let a = document.getElementsByName("talento[]");
                    let fila ="";

                    fila = '<tr class="selected" id="filaTalento'+cont+'"><td><input type="hidden" name="talento[]" value="'+idtalento+'">'+nombreTalento+'</td><td><a class="waves-effect red lighten-3 btn" onclick="eliminarTalento('+cont+');"><i class="material-icons">delete_sweep</i></a></td></tr>';
                    cont++;
                    $('#detalleTalento').append(fila);

                }
            }

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
        function addGestoresAUso() {

            let cont = 0;
            let idgestor = $("#txtgestorasesor").val();
            let asesoriadirecta = $("#txtasesoriadirecta").val();
            let asesoriaindirecta = $("#txtasesoriaindirecta").val();
            let nombreGestor = $('#txtgestorasesor option:selected').text();
            if ($("#txtgestorasesor").val() == ""){

                Swal.fire({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 1500,
                        type: 'warning',
                        title: 'Debe seleccionar un Gestor'
                      });

            }else{
                if (usoInfraestructuraUpdate.noRepeatGestor(idgestor) == false) {


                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 1500,
                        type: 'error',
                        title: 'El Gestor ' + nombreGestor + ' ya esta listado.'
                      });

                    $("#txtgestorasesor").val();
                }else if($("#txtasesoriadirecta").val() == '' ||  (!/^([0-9])\d*(\.\d+)?$/.test($("#txtasesoriadirecta").val()))){
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 1500,
                        type: 'error',
                        title: 'Por favor ingrese una hora de asesoria directa correcta'
                      });
                    $("#txtasesoriadirecta").val(0);
                    $("label[for='txtasesoriadirecta']").addClass('active');
                }else if($("#txtasesoriadirecta").val() == 0 && $("#txtasesoriaindirecta").val() < 1 || $("#txtasesoriadirecta").val() < 1 && $("#txtasesoriaindirecta").val() == 0 || $("#txtasesoriadirecta").val() == 0 && $("#txtasesoriaindirecta").val() == 0){
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 1500,
                        type: 'error',
                        title: 'Debe de haber al menos una asesoria con el valor de 1'
                      });
                    $("#txtasesoriadirecta").val(0);
                    $("label[for='txtasesoriadirecta']").addClass('active');
                    $("#txtasesoriaindirecta").val(0);
                    $("label[for='txtasesoriadirecta']").addClass('active');
                }
                else if($("#txtasesoriaindirecta").val() == '' ||  (!/^([0-9])\d*(\.\d+)?$/.test($("#txtasesoriaindirecta").val()))){
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 1500,
                        type: 'error',
                        title: 'Por favor ingrese una hora de asesoria indirecta correcta.'
                      });
                    $("#txtasesoriaindirecta").val(0);
                    $("label[for='txtasesoriaindirecta']").addClass('active');

                }else{
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 1500,
                        type: 'success',
                        title: 'El Gestor ' + nombreGestor + ' agregado.'
                      });



                    let a = document.getElementsByName("gestor[]");
                    let fila ="";

                    fila = '<tr class="selected" id="filaGestorAsesor'+cont+'"><td><input type="hidden" name="gestor[]" value="'+idgestor+'">'+nombreGestor+'</td><td><input type="hidden" name="asesoriadirecta[]" value="'+asesoriadirecta+'">'+asesoriadirecta+'</td><td><input type="hidden" name="asesoriaindirecta[]" value="'+asesoriaindirecta+'">'+asesoriaindirecta+'</td><td><a class="waves-effect red lighten-3 btn" onclick="eliminarGestorAsesor('+cont+');"><i class="material-icons">delete_sweep</i></a></td></tr>';
                    cont++;
                    $('#detallesGestoresAsesores').append(fila);

                    $("#txtasesoriadirecta").val(0);
                    $("label[for='txtasesoriadirecta']").addClass('active');
                    $("#txtasesoriaindirecta").val(0);
                    $("label[for='txtasesoriadirecta']").addClass('active');

                }
            }
            $("#txtgestorasesor option[value='']").attr("selected", true);
            $('#txtgestorasesor').select2();
        }

        function eliminarGestorAsesor(index){
          $('#filaGestorAsesor'+ index).remove();
          Swal.fire({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 1500,
            type: 'success',
            title: 'Gestor eliminado.'
          });
        }

        function eliminarMaterial(index){
          $('#filaMaterial'+ index).remove();
          Swal.fire({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 1500,
            type: 'success',
            title: 'Material eliminado.'
          });
        }

        function addMaterialesAUso() {

            let cont = 0;
            let idmaterial = $("#txtmaterial").val();
            let cantidad = $("#txtcantidad").val();
            let nombreMaterial = $('#txtmaterial option:selected').text();
            if ($("#txtmaterial").val() == ""){

                Swal.fire({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 1500,
                        type: 'warning',
                        title: 'Debe seleccionar un Material de Formación.'
                      });

            }else{
                if (usoInfraestructuraUpdate.noRepeatMaterial(idmaterial) == false) {


                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 1500,
                        type: 'error',
                        title: 'El Material ' + nombreMaterial + ' ya esta listado.'
                      });

                    $("#txtmaterial").val();

                }else if($("#txtcantidad").val() == '' || $("#txtcantidad").val() <= 0 || (!/^([0-9])\d*(\.\d+)?$/.test($("#txtcantidad").val()))){
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 1500,
                        type: 'error',
                        title: 'Por favor ingrese una cantidad correcta'
                      });
                    $("#txtcantidad").val(1);
                    $("label[for='txtcantidad']").addClass('active');
                }else{
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 1500,
                        type: 'success',
                        title: 'Material ' + nombreMaterial + ' agregado.'
                      });

                    let a = document.getElementsByName("material[]");
                    let fila ="";

                    fila = '<tr class="selected" id="filaMaterial'+cont+'"><td><input type="hidden" name="material[]" value="'+idmaterial+'">'+nombreMaterial+'</td><td><input type="hidden" name="cantidad[]" value="'+cantidad+'">'+cantidad+'</td><td><a class="waves-effect red lighten-3 btn" onclick="eliminarMaterial('+cont+');"><i class="material-icons">delete_sweep</i></a></td></tr>';
                    cont++;
                    $('#detalleMaterialUso').append(fila);

                    $("#txtcantidad").val(1);

                }
            }
            $("#txtmaterial option[value='']").attr("selected", true);
            $('#txtmaterial').select2();
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
                dataType: 'json',
                cache: false,
                dataType: 'json',
                contentType: false,
                processData: false,
                success: function (data) {
                    $('button[type="submit"]').removeAttr('disabled');
                    let errores = "";
                    for (control in data.errors) {
                        errores += '<br/><b>'+data.errors[control]+'</b>';
                        $('#' + control + '-error').html(data.errors[control]);
                        $('#' + control + '-error').show();
                    }

                    $('.error').hide();
                    if (data.fail) {
                        let errores = "";
                        for (control in data.errors) {
                            errores += '<br/><b>'+ data.errors[control]+'</b>';
                            $('#' + control + '-error').html(data.errors[control]);
                            $('#' + control + '-error').show();
                        }
                        Swal.fire({
                          title: 'Registro Erróneo',
                          html: "Estas ingresando mal los datos." + errores,
                          type: 'error',
                          showCancelButton: false,
                          confirmButtonColor: '#3085d6',
                          confirmButtonText: 'Ok'
                        });
                    }

                    if (data.fail == false && data.redirect_url == false) {
                          Swal.fire({
                                title: 'El uso de infraestructua no se ha modificado, por favor inténtalo de nuevo',
                                type: 'warning',
                                showCancelButton: false,
                                confirmButtonColor: '#3085d6',
                                confirmButtonText: 'Ok'
                          });
                    }

                    if (data.fail == false && data.redirect_url != false) {
                      Swal.fire({
                        title: 'Modificación Exitosa',
                        text: "El uso de infraestructua ha sido modificado satisfactoriamente",
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
