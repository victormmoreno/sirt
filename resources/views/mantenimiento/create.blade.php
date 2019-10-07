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
                            <a class="footer-text left-align " href="{{route('equipo.index')}}">
				              	<i class="fas fa-box"></i>
				            </a> Mantenimientos de Equipos | Tecnoparque Nodo  {{\NodoHelper::returnNameNodoUsuario()}}
                        </h5>
                    </div>
                    <div class="col s4 m4 l3 rigth-align">
                        <ol class="breadcrumbs">
                            <li><a href="{{route('home')}}">Inicio</a></li>
                            <li><a href="{{route('mantenimiento.index')}}">Equipos</a></li>
                            <li class="active">Nuevo Equipo</li>
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
                			<form  action="{{route('mantenimiento.store')}}" method="POST" onsubmit="return checkSubmit()">
			                  	
			                  	@include('mantenimiento.form', [
			                  	'btnText' => 'Registrar'
			                  	])
                			</form>
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
            mantenimientoCreate.getEquipoPorLinea();
        });

        var mantenimientoCreate = {
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