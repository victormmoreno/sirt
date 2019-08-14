@extends('layouts.app')

@section('meta-title', 'Usuarios')

@section('content')
<main class="mn-inner inner-active-sidebar">
    <div class="content">
        <div class="row no-m-t no-m-b">
            <div class="col s12 m12 l12">
                <h5>
                    <a class="footer-text left-align" href="{{ route('usoinfraestructura.index')}}">
                        <i class="material-icons arrow-l">
                            arrow_back
                        </i>
                    </a>
                    Uso de Infraestructura
                </h5>
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
@endsection

@push('script')
<script>
    $(document).ready(function() {
        $divProyecto = $("#divProyecto");
        $divArticulacion = $(".divArticulacion");
        $divProyecto.hide();
        $divArticulacion.hide();
        usoInfraestructuraCreate.selectTipoArticulacion();



        $(document).on('submit', 'form#formUsoInfraestructuraCreate', function (event) {
            event.preventDefault();
            $('button[type="submit"]').attr('disabled', 'disabled');
            console.log('hols');
        });

        $( "input[name='txttipousoinfraestructura']" ).change(function (){
        if ( $("#IsProyecto").is(":checked") ) {
            Swal.fire({
                toast: true,
                position: 'bottom-end',
                title: 'proyecto',
                text: "por favor seleccion un proyecto",
                type: 'warning',
                showConfirmButton: false,
                timer: 3000
            });
            $divProyecto.show();
            $divArticulacion.hide();

            usoInfraestructuraCreate.selectProyecto();
             $('input#txtfecha').parent().removeClass("s12 m4 l4");
             $('input#txtfecha').parent().addClass("s12 m6 l6");
              
        } else if ( $("#IsArticulacion").is(":checked") ) {
            $('input#txtfecha').parent().removeClass("s12 m6 l6");
            $('input#txtfecha').parent().addClass("s12 m4 l4");
            $('select#txttipoarticulacion').parent().parent().removeClass("col s12 m6 l6");
            $('select#txttipoarticulacion').parent().parent().addClass("col s12 m4 l4");
            $('select#txtarticulacion').parent().parent().removeClass("col s12 m6 l6");
            $('select#txtarticulacion').parent().parent().addClass("col s12 m4 l4");
            console.log();
            Swal.fire({
                toast: true,
                position: 'bottom-end',
                title: 'Articulación',
                text: "por favor seleccione un tipo de articulación",
                type: 'warning',
                showConfirmButton: false,
                timer: 3000
            });
          $divProyecto.hide();
          $divArticulacion.show();

        } else {
          $divProyecto.hide();
          $divArticulacion.hide();

          
        }
       
      });
    });

    var usoInfraestructuraCreate = {
        selectProyecto:function () {
            $('#txtproyecto').empty();
            $.ajax({
                dataType:'json',
                type:'get',
                url:'/proyecto/gestor/'+{{{auth()->user()->gestor->id}}},
            }).done(function(response){
                if (response != '') {
                   $('#txtproyecto').append('<option value="">Seleccione el proyecto</option>');
                    $.each(response.projects, function(i, e) {
                        $('#txtproyecto').append('<option value="'+e.id+'">'+e.articulacion_proyecto.actividad.codigo_actividad+' - '+e.articulacion_proyecto.actividad.nombre+'</option>');
                    }); 
                }else{
                    $('#txtproyecto').append('<option value="">No se encontraron proyectos</option>');
                }
                
                $('#txtproyecto').material_select();
            })
        },
        selectTipoArticulacion:function (id) {
            let tipoArticulacion_id = $(id).val();
            let tipoArticulacion_nombre = $("#txttipoarticulacion option:selected").text();
            console.log(tipoArticulacion_nombre);
            console.log(tipoArticulacion_id);
            let grupoInvestigacion = $(".divGrupoInvestigacion");
            let empresa = $(".divEmpresa");
            let emprendedor = $(".divEmprendedor");


            $('#txtarticulacion').empty();
            $.ajax({
                dataType:'json',
                type:'get',
                url:'/articulacion/gestor/'+{{{auth()->user()->gestor->id}}}+'/'+tipoArticulacion_id,
            }).done(function(response){
                
                $('#txtarticulacion').empty();
                if (response != '') {
                   $('#txtarticulacion').append('<option value="">Seleccione el proyecto</option>');
                    $.each(response.articulaciones, function(i, e) {
                        $('#txtarticulacion').append('<option value="'+e.id+'">'+e.articulacion_proyecto.actividad.codigo_actividad+' - '+e.articulacion_proyecto.actividad.nombre+'</option>');
                    }); 
                }else{
                    $('#txtarticulacion').append('<option value="">No se encontraron proyectos</option>');
                }
                $('#txtarticulacion').material_select();
            })

            if(tipoArticulacion_nombre == 'Grupo de Investigación'){
                grupoInvestigacion.show();
                empresa.hide();
                emprendedor.hide();
            }else if(tipoArticulacion_nombre == 'Empresa'){
                grupoInvestigacion.hide();
                emprendedor.hide();
                empresa.show();
            }else if(tipoArticulacion_nombre == 'Emprendedor'){
                grupoInvestigacion.hide();
                empresa.hide();
                emprendedor.show();
            }else{
                grupoInvestigacion.hide();
                empresa.hide();
                emprendedor.hide();
            }
            
           
        }
    }

    

</script>
@endpush
