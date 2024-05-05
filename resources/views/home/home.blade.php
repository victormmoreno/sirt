@extends('layouts.app')
@section('meta-title','Inicio')
@section('content')
<main class="mn-inner inner-active-sidebar">
    <div class="row no-m-t no-m-b">
        <div class="col s12 m12 l12">
            <div class="card card-transparent">
                <div class="card-content">
                    @can('showDahsboardExperto', Illuminate\Database\Eloquent\Model::class)
                    @include('home.dashboard.experto')
                    @endcan
                    @can('showDahsboardDinamizador', Illuminate\Database\Eloquent\Model::class)
                    @include('home.dashboard.dinamizador')
                    @endcan
                    @if (session()->get('login_role') == App\User::IsDinamizador() || session()->get('login_role') == App\User::IsActivador() || session()->get('login_role') == App\User::IsAdministrador())
                    <div class="center-align">
                        <p class="card-title aling-center"> Tablero Power Bi - Red Tecnoparque Colombia
                        </p>
                    </div>
                    <div class="row">
                        <div class="col s12 m12 l10 offset-l2">
                            <iframe title="1 ModuloTecnoBI_SIRT_2024" width="1024" height="612" src="https://app.powerbi.com/view?r=eyJrIjoiNDQ1YmIwMWYtOTg4Yy00MzAzLTgwYTgtNjVkODkxYTE3YmM3IiwidCI6ImNiYzJjMzgxLTJmMmUtNGQ5My05MWQxLTUwNmM5MzE2YWNlNyIsImMiOjR9" frameborder="0" allowFullScreen="true"></iframe>

                        </div>
                    </div>
                    @else
                    <div class="center-align">
                        <p class="card-title aling-center">Bienvenido <span class="secondary-title"> Sistema Nacional de
                                la Red de Tecnoparques Colombia</span>
                        </p>
                    </div>
                    <div class="row">
                        <div class="col s12 m12 l10 offset-l1">
                            <img class="materialboxed responsive-img"
                                src="{{ asset('img/logo-tecnoparque-green.svg') }}" alt="sena | Tecnoparque">
                        </div>
                    </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</main>
@include('home.modals')
@endsection
@push('script')
@if (session()->get('login_role') == App\User::IsExperto())
<script>
    $(document).ready(function() {
        consultarProyectosInscritosPorMes({{auth()->user()->id}});
        });
        function consultarProyectosInscritosPorMes(gestor_id) {
        $.ajax({
            dataType: 'json',
            type: 'get',
            url: host_url + '/seguimiento/seguimientoInscritosPorMesExperto/'+gestor_id,
            success: function (data) {
            graficoSeguimientoPorMes(data, graficosSeguimiento.inscritos_mes);
            },
            error: function (xhr, textStatus, errorThrown) {
            alert("Error: " + errorThrown);
            },
        })
        }
</script>
@endif
@endpush
@include('home.functions')
