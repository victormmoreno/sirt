@extends('layouts.app')
@section('meta-title', 'Seguimiento')
@section('content')
@php
$yearNow = Carbon\Carbon::now()->isoFormat('YYYY');
@endphp
<main class="mn-inner inner-active-sidebar">
    <div class="content">
        <div class="row no-m-t no-m-b">
        <div class="col s12 m12 l12">
            <div class="row">
            <div class="col s8 m8 l10">
                <h5 class="left-align">
                <i class="material-icons left">
                    search
                </i>
                Seguimiento
                </h5>
            </div>
            <div class="col s4 m4 l2 rigth-align show-on-large hide-on-med-and-down">
                <ol class="breadcrumbs">
                <li><a href="{{route('home')}}">Inicio</a></li>
                <li class="active">Seguimiento</li>
                </ol>
            </div>
            </div>
            <div class="card">
            <div class="card-content">
                <div class="row">
                <div class="col s12 m12 l12">
                    <ul class="tabs tab-demo z-depth-1" style="width: 100%;">
                    <li class="tab col s3"><a class="" href="#tecnoparque">Tecnoparque</a></li>
                    <li class="tab col s3"><a class="" href="#nodo">Nodo</a></li>
                    </ul>
                    <br>
                </div>
                <div id="nodo" class="col s12 m12 l12">
                    <div class="col s12 m12 l12">
                    <ul class="tabs tab-demo z-depth-1" style="width: 100%;">
                        <li class="tab col s3"><a class="active" href="#nodo_todo">Proyectos abiertos (TRL esperado)</a></li>
                        <li class="tab col s3"><a class="" href="#nodo_actual">Fase actual de proyectos</a></li>
                    </ul>
                    <br>
                    </div>
                    <div class="row" id="nodo_todo">
                    <div class="col s12 m4 l4">
                        <div class="input-field col s12 m12 l12">
                        <select id="txtnodo_id" name="txtnodo_id" style="width: 100%" tabindex="-1">
                            <option value="">Seleccione el nodo</option>
                            @foreach($nodos as $nodo)
                            <option value="{{$nodo->id}}">{{$nodo->nodos}}</option>
                            @endforeach
                        </select>
                        <label for="txtnodo_id">Nodo</label>
                        </div>
                        <div class="col s12 m12 l12 center">
                        <button onclick="consultarSeguimientoDeUnNodo_Admin()" class="btn">Consultar</button>
                        </div>
                    </div>
                    <div class="col s12 m8 l8">
                        <div id="graficoSeguimientoDeUnNodo_column" class="green lighten-3"
                        style="min-width: 310px; max-width: 800px; height: 400px; margin: 0 auto">
                        <div class="row card-panel">
                            <h5 class="center">
                            Para consultar el seguimiento de un nodo, debes seleccionar un nodo en la lista desplegable de los nodos y luego presionar el botón de "Consultar".
                        </div>
                        </div>
                    </div>
                    </div>
                    <div class="row" id="nodo_actual">
                    <div class="col s12 m4 l4">
                        <div class="input-field col s12 m12 l12">
                        <select id="txtnodo_id_actual" name="txtnodo_id_actual" style="width: 100%" tabindex="-1">
                            <option value="">Seleccione el nodo</option>
                            @foreach($nodos as $nodo)
                            <option value="{{$nodo->id}}">{{$nodo->nodos}}</option>
                            @endforeach
                        </select>
                        <label for="txtnodo_id_actual">Nodo</label>
                        </div>
                        <div class="col s12 m12 l12 center">
                        <button onclick="consultarSeguimientoActualDeUnNodo_Admin()" class="btn">Consultar</button>
                        </div>
                    </div>
                    <div class="col s12 m8 l8">
                        <div id="graficoSeguimientoDeUnNodoFases_column" class="green lighten-3"
                        style="min-width: 310px; max-width: 800px; height: 400px; margin: 0 auto">
                        <div class="row card-panel">
                            <h5 class="center">
                            Para consultar el seguimiento de un nodo, debes seleccionar un nodo en la lista desplegable de los nodos y luego presionar el botón de "Consultar".
                            </h5>
                        </div>
                        </div>
                    </div>
                    </div>
                </div>
                <div id="tecnoparque" class="col s12 m12 l12">
                    <div class="col s12 m12 l12">
                    <ul class="tabs tab-demo z-depth-1" style="width: 100%;">
                        <li class="tab col s3"><a class="" href="#tecnoparque_esperado">Proyectos abiertos (TRL esperado)</a></li>
                        <li class="tab col s3"><a class="" href="#tecnoparque_actual">Fase actual de proyectos</a></li>
                    </ul>
                    <br>
                    </div>
                    <div class="row" id="tecnoparque_esperado">
                    <div class="col s12 m12 l12">
                        <div id="graficoSeguimientoTecnoparque_column" class="green lighten-3" style="min-width: 310px; max-width: 800px; height: 400px; margin: 0 auto">
                        <div class="row card-panel">
                            <h5 class="center">
                            Para consultar el seguimiento de proyectos del nodo, debes pulsar el botón de <button onclick="consultarSeguimientoEsperadoDeUnNodo(0)"
                                class="btn">Consultar</button>
                            </h5>
                        </div>
                        </div>
                    </div>
                    </div>
                    <div class="row" id="tecnoparque_actual">
                    <div class="col s12 m12 l12">
                        <div id="graficoSeguimientoTecnoparqueFases_column" class="green lighten-3"
                        style="min-width: 310px; max-width: 800px; height: 400px; margin: 0 auto">
                        <div class="row card-panel">
                            <h5 class="center">
                            Aquí puedes ver los estados actuales de los proyectos.
                            </h5>
                        </div>
                        </div>
                    </div>
                    </div>
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
        consultarSeguimientoEsperadoDeTecnoparque();
        consultarSeguimientoDeTecnoparqueFases();
        function consultarSeguimientoDeUnNodo_Admin () {
            let nodo_id = $('#txtnodo_id').val();
            consultarSeguimientoEsperadoDeUnNodo(nodo_id);
        }
        function consultarSeguimientoActualDeUnNodo_Admin () {
            let nodo_id = $('#txtnodo_id_actual').val();
            consultarSeguimientoDeUnNodoFases(nodo_id);
        }
    </script>
@endpush
