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
                            <a class="footer-text left-align" href="{{route('mantenimiento.index')}}">
                                  <i class="material-icons arrow-l">
                                      arrow_back
                                  </i>
                              </a>
                            Mantenimientos Tecnoparque Nodo {{\NodoHelper::returnNameNodoUsuario()}}
                        </h5>
                    </div>
                    <div class="col s4 m4 l4 rigth-align show-on-large hide-on-med-and-down">
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
                                <center><span class="card-title center-align">Editar Mantenimiento de equipo<b> | {{$mantenimiento->equipo->nombre}}</b></span> <i class="Small material-icons prefix">build </i></center>
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