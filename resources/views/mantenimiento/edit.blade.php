@extends('layouts.app')
@section('meta-title', 'Mantenimientos')
@section('content')
<main class="mn-inner inner-active-sidebar">
    <div class="content">
        <div class="row no-m-t no-m-b">
            <div class="col s12 m12 l12">
                <div class="row">
                    <h5 class="left left-align primary-text">
                        <a href="{{route('mantenimiento.index')}}">
                              <i class="material-icons arrow-l left primary-text">
                                  arrow_back
                              </i>
                          </a>
                        Mantenimientos de tecnoparque
                    </h5>
                    <div class="right right-align show-on-large hide-on-med-and-down">
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
                                <div class="center-align primary-text">
                                    <span class="card-title primary-text">Editar Mantenimiento de equipo<b> | {{$mantenimiento->equipo->nombre}}</b></span> <i class="small material-icons prefix">build </i>
                                </div>
                                <div class="divider"></div>
                                <br/>
                                @if( $lineastecnologicas->count() == 0)
                                    <div class="center-align">
                                        <i class="large material-icons prefix">
                                            block
                                        </i>
                                        <p>
                                            Para registrar un nuevo mantenimiento, el tecnoparque debe tener lineas asociadas, por favor solicita al administrador de la plataforma para que este agregue nuevas lineas tecnológicas al nodo.
                                        </p>                                    
                                    </div>
                                @else
                                    <form id="frmMantenimientoEquipoEdit" action="{{ route('mantenimiento.update', $mantenimiento->id)}}" method="POST">
                                    	{!! method_field('PUT')!!}
    	                                @include('mantenimiento.form', [
    								    	'btnText' => 'Modificar',
    								   	])
    							   	</form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

@endsection
@if( $lineastecnologicas->count() != 0)
@push('script')
    <script>
        $(document).ready(function() {
            let nodo = {{$mantenimiento->equipo->nodo_id}};
            let linea = {{$mantenimiento->equipo->lineatecnologica_id}};
            let equipo = {{$mantenimiento->equipo->id}};
            consultarLineasNodoMantenimiento(nodo, linea);
            getEquipoPorLineaEdit(nodo, linea, equipo);
        });
    </script>
@endpush
@endif