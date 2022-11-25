@extends('layouts.app')
@section('meta-title', 'Costos Administrativos')
@section('meta-content', 'Costos Administrativos')
@section('meta-keywords', 'Costos Administrativos')
@section('content')
<main class="mn-inner inner-active-sidebar">
    <div class="content">
        <div class="row no-m-t no-m-b m-r-lg m-l-lg">
            <div class="left left-align">
                <h5 class="left-align primary-text">
                    <i class="material-icons left">settings_input_svideo</i>Costos Administrativos
                </h5>
            </div>
            <div class="right right-align show-on-large hide-on-med-and-down">
                <ol class="breadcrumbs">
                    <li><a href="{{route('home')}}">Inicio</a></li>
                    <li class="active">Costos Administrativos</li>
                </ol>
            </div>
        </div>
        <div class="row no-m-t no-m-b">
            <div class="col s12 m12 l12">
                <div class="card">

                    <div class="card-content">
                        <div class="row">
                            <div class="row">
                                <div class="col s12 m12 l12">
                                    <div class="center">
                                        <span class="card-title center-align primary-text">
                                            Costos Administrativos Fijos Mensuales {{config('app.name')}} {{Carbon\Carbon::now()->year}}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="divider"></div>
                            @if(session()->has('login_role') && (session()->get('login_role') == App\User::IsActivador() || session()->get('login_role') == App\User::IsAdministrador() ))
                                <div class="row">
                                    <div class="col s12 m12 l12">
                                        <label class="active" for="selectnodo">Nodo <span class="red-text">*</span></label>
                                        <select class="js-states browser-default select2 " onchange="selectCostoAdministrativoNodo.selectCostoAdministrativoNodo('{{App\User::IsAdministrador()}}', -1)" tabindex="-1" style="width: 100%" id="selectnodo" >
                                            <option value="">Seleccione nodo</option>
                                            @foreach($nodos as $nodo)
                                              <option value="{{$nodo->id}}">{{$nodo->nodos}}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                </div>
                            @endif
                                <br>
                                <table class="display responsive-table datatable-example dataTable" id="costoadministrativo_administrador_table"  style="width:100%">
                                    <thead class="bg-primary white-text">
                                        <tr>
                                            <th rowspan="2">Nodo</th>
                                            <th rowspan="2">Nombre</th>
                                            <th colspan="3">Costos</th>
                                            <th rowspan="2">Editar</th>
                                        </tr>
                                        <tr>
                                            <th>Costos Administrativos por mes</th>
                                            <th>Costos Administrativos por día</th>
                                            <th>Costos Administrativos por hora</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th colspan="2" style="text-align:right"></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                            </table>
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
            @if(session()->get('login_role') == App\User::IsDinamizador())
            selectCostoAdministrativoNodo.selectCostoAdministrativoNodo("{{App\User::IsDinamizador()}}", {{auth()->user()->dinamizador->nodo_id}});
            @endif
        });
    </script>
@endpush
