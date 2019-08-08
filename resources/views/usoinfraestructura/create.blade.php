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
        $divProyecto.hide();


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
              
        } else if ( $("#IsEmpresa").is(":checked") ) {
          
          $divProyecto.hide();
        } else {
          $divProyecto.hide();
          
        }
       
      });
    });

    var usoInfraestructuraCreate = {
        selectProyecto:function () {
            $('#txtproyecto').empty();
            $.ajax({
                dataType:'json',
                type:'get',
                url:'/articulacion/consultarTiposArticulacion/'+value,
            }).done(function(response){
                console.log(response);
                $('#txtproyecto').append('<option value="">Seleccione el proyecto</option>');
                // $.each(response.tiposarticulacion, function(i, e) {
                //   // console
                //   // .log(e.nombre);
                //     $('#txtproyecto').append('<option value="'+e.id+'">'+e.nombre+'</option>');
                // })
                $('#txtproyecto').material_select();
            })
        }
    }

    

</script>
@endpush
