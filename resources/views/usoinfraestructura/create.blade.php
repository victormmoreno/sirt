@extends('layouts.app')

@section('meta-title', 'Usuarios')

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
                                Nuevo Uso de Infraestructura
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
        $divProyecto = $(".divProyecto");
        $divArticulacion = $(".divArticulacion");
        $divEdt = $(".divEdt");
        $divProyecto.hide();
        $divArticulacion.hide();
        $divEdt.hide();
        usoInfraestructuraCreate.checkTipoUsoInfraestrucuta();


        
    });

    var usoInfraestructuraCreate = {

        checkTipoUsoInfraestrucuta:function () {
            $( "input[name='txttipousoinfraestructura']" ).change(function (){
                if ( $("#IsProyecto").is(":checked") ) {
                    $divArticulacion.hide();
                    $divEdt.hide();
                    Swal.fire({
                        toast: true,
                        position: 'bottom-end',
                        title: 'proyecto',
                        text: "por favor seleccion un proyecto",
                        type: 'warning',
                        showConfirmButton: false,
                        timer: 10000
                    });
                    usoInfraestructuraCreate.DatatableProjectsForUser();
                                   
                      
                } else if ( $("#IsArticulacion").is(":checked") ) {
                   
                    $divProyecto.hide();
                    $divEdt.hide();
                    Swal.fire({
                        toast: true,
                        position: 'bottom-end',
                        title: 'Articulación',
                        text: "por favor seleccione una articulación",
                        type: 'warning',
                        showConfirmButton: false,
                        timer: 10000
                    });

                    usoInfraestructuraCreate.dataTableArtculacionFindByUser();

                } else if( $("#IsEdt").is(":checked")) {
                    $divProyecto.hide();
                    $divArticulacion.hide();
                    usoInfraestructuraCreate.dataTableEdtFindByUser();
                  
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
        // Función para cerrar el modal y asignarle un valor al proyecto
        asociarProyectoAUsoInfraestructura: function (id, codigo_actividad, nombre) {
            $('#modalUsoIngraestrucuta_proyjects_modal').closeModal();
            Swal.fire({
              toast: true,
              position: 'top-end',
              showConfirmButton: false,
              timer: 1500,
              type: 'success',
              title: 'El proyecto  ' + codigo_actividad +  ' - ' + nombre + ' se ha asociado  al uso de infraestructua'
            });

            $('#txtproyecto').val(nombre);
            $("label[for='txtproyecto']").addClass('active');
            $divProyecto.show();

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

            $('#modalUsoIngraestrucuta_articulaciones_modal').openModal({
                dismissible: false,
            });
        },
        // Función para cerrar el modal y asignarle un valor al proyecto
        asociarArticulacionAUsoInfraestructura: function (id, codigo_actividad, nombre) {
            $('#modalUsoIngraestrucuta_articulaciones_modal').closeModal();
            Swal.fire({
              toast: true,
              position: 'top-end',
              showConfirmButton: false,
              timer: 1500,
              type: 'success',
              title: 'La articulacion  ' + codigo_actividad +  ' - ' + nombre + ' se ha asociado  al uso de infraestructua'
            });

            $('#txtarticulacion').val(nombre);
            $("label[for='txtarticulacion']").addClass('active');
            $divArticulacion.show();

        },

        //EDTS
        dataTableEdtFindByUser: function (){
            $('#usoinfraestrucutaEdtForUserTable').dataTable().fnDestroy();


            $('#modalUsoIngraestrucuta_edt_modal').openModal({
                dismissible: false,
            });
        },
    



    }
</script>
@endpush
