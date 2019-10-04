@extends('layouts.app')

@section('meta-title', 'Mantenimientos | ')

@section('content')

<main class="mn-inner inner-active-sidebar">
    <div class="content">
        <div class="row no-m-t no-m-b">
            <div class="col s12 m12 l12">
                <div class="row">
                    <div class="col s8 m8 l8">
                        <h5 class="left-align">
                            <a class="footer-text left-align" href="{{route('costoadministrativo.index')}}">
                                  <i class="material-icons arrow-l">
                                      arrow_back
                                  </i>
                              </a>
                            Mantenimientos buildTecnoparque Nodo {{\NodoHelper::returnNameNodoUsuario()}}
                        </h5>
                    </div>
                    <div class="col s4 m4 l4 rigth-align">
                        <ol class="breadcrumbs">
                            <li><a href="{{route('home')}}">Inicio</a></li>
                            <li><a href="{{route('mantenimiento.index')}}">Mantenimientos</a></li>
                            <li class="active">Editar Mantenimiento</li>
                        </ol>
                    </div>
                </div>
                <div class="card stats-card">
                    <div class="card-content">
                        <div class="row">
                            <div class="row">
                                <center><span class="card-title center-align">Editar Mantenimiento de equipo<b> | {{$mantenimiento->equipo_nombre}}</b></span> <i class="Small material-icons prefix">build </i></center>
                                <div class="divider"></div>
                                <br/>
                                <form action="{{ route('mantenimiento.update', $mantenimiento->id)}}" method="POST" onsubmit="return checkSubmit()">
                                	{!! method_field('PUT')!!}
	                                @include('mantenimiento.form', [
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

@endsection
@push('script')
    <script>
        $(document).ready(function() {
            mantenimientoEdit.getEquipoPorLinea();
        });

        var mantenimientoEdit = {
            getEquipoPorLinea:function(){
  
                let lineatecnologica = $('#txtlineatecnologica').val();
                $.ajax({
                    dataType:'json',
                    type:'get',
                    url:'/equipos/getequiposporlinea/'+lineatecnologica
                }).done(function(response){
                    $('#txtequipo').empty();
                        
                    if (response.equipos == '' && response.equipos.length == 0) {
                        $('#txtequipo').append('<option value="">No se encontraron resultados</option>');
                    }else{
                        $('#txtequipo').append('<option value="">Seleccione el equipo</option>');
                        $.each(response.equipos, function(i, e) {
                            $('#txtequipo').append('<option  value="'+e.id+'">'+e.nombreequipo+'</option>');
                        });

                        @if($errors->any())
                        $('#txtequipo').val({{old('txtequipo')}});
                        @else
                        $('#txtequipo').val('{{$mantenimiento->equipo_id}}');
                        @endif
                    }
                    $('#txtequipo').select2();
                });
            },
        }
    </script>
@endpush