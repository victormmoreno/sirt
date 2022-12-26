@extends('layouts.app')
@section('meta-title', 'Mantenimientos de Equipos ' . 'Tecnoparque Nodo ' . \NodoHelper::returnNameNodoUsuario())
@section('content')
<main class="mn-inner inner-active-sidebar">
    <div class="content">
      	<div class="row no-m-t no-m-b">
        	<div class="col s12 m12 l12">
        		<div class="row">
                    <div class="col s8 m8 l9">
                        <h5 class="left-align hand-of-Sean-fonts">
                                <form  action="{{route('mantenimiento.store')}}" method="POST" onsubmit="return checkSubmit()">
                            <a class="footer-text left-align " href="{{route('equipo.index')}}">
				              	<i class="left material-icons white-text">arrow_back</i>
				            </a> Mantenimientos de Equipos | Tecnoparque Nodo  {{\NodoHelper::returnNameNodoUsuario()}}
                        </h5>
                    </div>
                    <div class="col s4 m4 l3 rigth-align show-on-large hide-on-med-and-down">
                        <ol class="breadcrumbs">
                            <li><a href="{{route('home')}}">Inicio</a></li>
                            <li><a href="{{route('mantenimiento.index')}}">Mantenimientos</a></li>
                            <li class="active">Nuevo Mantenimiento</li>
                        </ol>
                    </div>
                </div>
          		<div class="card">
            		<div class="card-content">
              			<div class="row">
			                <center>
				                <span class="card-title center-align">Nuevo Mantenimiento de Equipos | Tecnoparque Nodo {{ \NodoHelper::returnNameNodoUsuario() }}
				                </span>
			                </center>
                			<div class="divider"></div>
                			<br/>
                            @if( $lineastecnologicas->count() == 0)
                                <div class="center-align">
                                    <i class="large material-icons prefix">
                                        block
                                    </i>
                                    <p>
                                        Para registrar un nuevo mantenimiento, Tecnoparque Nodo {{ \NodoHelper::returnNameNodoUsuario() }} debe tener lineas asociadas, por favor solicita al administrador de la plataforma para que este agregue nuevas lineas tecnológicas al nodo.
                                    </p>                                    
                                </div>
                            @else
                    			<form  action="{{route('mantenimiento.store')}}" method="POST" onsubmit="return checkSubmit()">
    			                  	@include('mantenimiento.form', [
    			                  	'btnText' => 'Registrar'
    			                  	])
                    			</form>
                            @endif
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
            @if($errors->any())
                mantenimientoCreate.getEquipoPorLinea();
            @endif
        });

        var mantenimientoCreate = {
            getEquipoPorLinea:function(){
                let lineatecnologica = $('#txtlineatecnologica').val();
                let nodo = {{auth()->user()->dinamizador->nodo_id}};
                $.ajax({
                    dataType:'json',
                    type:'get',
                    url: host_url + '/equipos/getequiposporlinea/'+nodo+'/'+lineatecnologica
                }).done(function(response){
                    console.log(response);
                    $('#txtequipo').empty();
                    if (response.equipos == '' && response.equipos.length == 0) {
                        $('#txtequipo').append('<option value="">No se encontraron resultados</option>');
                    }else{
                        $('#txtequipo').append('<option value="">Seleccione el equipo</option>');
                        @if($errors->any())
                            $.each(response.equipos, function(i, e) {
                                $('#txtequipo').append('<option  value="'+e.id+'">'+e.nombre+'</option>');
                            });
                        @else
                            $.each(response.equipos, function(i, e) {
                                $('#txtequipo').append('<option  value="'+e.id+'">'+e.nombre+'</option>');
                            });
                        @endif
                    }
                    @if($errors->any())
                        $('#txtequipo').val("{{old('txtequipo')}}");
                    @endif
                    $('#txtequipo').select2();
                });
            },
        }
    
    </script>
@endpush