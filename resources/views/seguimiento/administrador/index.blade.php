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
        function consultarSeguimientoDeUnNodo_Admin() {
            let nodo_id = $('#txtnodo_id').val();
            consultarSeguimientoEsperadoDeUnNodo(nodo_id);
        }
        function consultarSeguimientoActualDeUnNodo_Admin() {
            let nodo_id = $('#txtnodo_id_actual').val();
            consultarSeguimientoDeUnNodoFases(nodo_id);
        }
    </script>
@endpush
